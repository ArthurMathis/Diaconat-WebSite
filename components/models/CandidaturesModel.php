<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Instants.php');
require_once(CLASSE.DS.'Candidats.php');

class CandidaturesModel extends Model {
    public function getCandidatures() {
        // On initialise la requête
        $request = "SELECT 
        id_Candidats AS Cle,
        Statut_Candidatures AS Statut, 
        nom_candidats AS Nom, 
        prenom_candidats AS Prénom, 
        intitule_postes AS Poste,
        email_candidats AS Email, 
        telephone_candidats AS Téléphone, 
        intitule_sources AS Source, 
        Disponibilite_Candidats AS Disponibilité
        FROM `candidatures` as c
        INNER JOIN candidats as i on c.Cle_Candidats = i.Id_Candidats
        INNER JOin postes as p on c.Cle_Postes = p.Id_Postes
        INNER JOIN sources as s on c.Cle_Sources = s.Id_Sources";
    
        // On lance la requête
        return $this->get_request($request);
    }
    public function getAides() {
        // On inititalise la requête
        $request = "SELECT Id_Aides_au_recrutement, Intitule_Aides_au_recrutement FROM aides_au_recrutement";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }

    public function verify_candidat($candidat=[], $diplomes=[], $aide, $visite_medicale) {
        // On vérifie l'intégrité des données
        try {
            $candidat = new Candidat(
                $candidat['nom'], 
                $candidat['prenom'], 
                $candidat['email'], 
                $candidat['telephone'], 
                $candidat['adresse'],
                $candidat['ville'],
                $candidat['code_postal']
            );
        
        } catch(InvalideCandidatExceptions $e) {
            forms_manip::error_alert($e->getMessage());
        }


        if($diplomes != null) {
            // On récupère la liste des diplomes
            $temp = [];

            foreach($diplomes as $obj) {
                echo "On recherche " . $obj . "<br>";
                // Si un diplome est saisi
                if(!empty($obj) && strlen($obj) > 0) {
                    // On recherche dans la base de données
                    $search = $this->searchDiplome($obj);

                    if(empty($search)) {
                        // On ajoute le nouveau diplome à la base de données
                        $this->createDiplome($obj);

                        // On récupère le diplome
                        $search = $this->searchDiplome($obj);
                    }

                    $temp[] = $search;
                }
            }

            // On gère la mémoire allouée
            unset($diplomes);
            $diplomes = $temp;
            unset($temp);
        }

        // On ajoute la visite médical
        $candidat->setVisite($visite_medicale);

        // On enregistre les données dans la session
        $_SESSION['candidat'] = $candidat;
        $_SESSION['diplomes'] = $diplomes;
        $_SESSION['aide']     = $aide;
    }

    public function createCandidat($candidat, $diplomes=[], $aide) {
        // On inscrit le candidat
        $this->inscriptCandidat($candidat);

        // On récupère l'Id du candidat
        $search = $this->searchcandidat($candidat->getNom(), $candidat->getPrenom(), $candidat->getEmail());
        
        // On ajoute la clé de Candidats
        $candidat->setCle($search['Id_Candidats']);

        // On enregistre les diplomes
        foreach($diplomes as $item) 
            $this->inscriptDiplome($candidat, $item);

        if($aide != null) 
            $this->inscriptAvoir_droit_a($candidat, $aide);
    }
    public function createDiplome($diplome) {
        // On initialise la requête
        $request = "INSERT INTO Diplomes (Intitule_Diplomes) VALUES (:intitule)";
        $params = ["intitule" => $diplome];

        // On lance la requête
        $this->post_request($request, $params);
    }
    public function createAide($aide) {
        // On initialise la requête
        $request = "INSERT INTO Aides_au_recrutement (Intitule_Aides_au_recrutement) VALUES (:intitule)";
        $params = ["intitule" => $aide];

        // On lance la requête
        $this->post_request($request, $params);
    }


    public function inscriptCandidature($candidat, $candidatures=[]) {
        // On iscrit la candidature 
        try {
            // On inscrit l'instant 
            $instant = $this->inscriptInstants()['Id_Instants'];

            echo "On génère la nouvelle candidature<br>";
            echo "Clé de l'utilisateur : " . $candidat->getCle();

            // Si la clé n'est pas présente
            if($candidat->getCle() == null) {
                // On récupère la clé du candidat 
                $search = $this->searchCandidat($candidat->getNom(), $candidat->getPrenom(), $candidat->getEmail())['Id_Candidats'];
                $candidat->setCle($search);           
            }

            // On récupère le type de contrat
            $contrat = $this->searchTypeContrat($candidatures['type de contrat'])['Id_Types_de_contrats'];
            
            // On récupère la source
            $source = $this->searchSource($candidatures["source"])['Id_Sources'];

            // On récupère le poste
            $poste = $this->searchPoste($candidatures["poste"])['Id_Postes'];

            // On inscrit la demande de poste
            $this->inscriptPostuler_a($candidat, $instant);

            // On ajoute l'action à la base de données
            $request = "INSERT INTO Candidatures (Statut_Candidatures, Cle_Candidats, Cle_Instants, Cle_Sources, Cle_Postes, Cle_Types_de_contrats) 
                        VALUES (:statut, :candidat, :instant, :source, :poste, :contrat)";
            $params = [
                "statut" => 'non traitee', 
                "candidat" => $candidat->getCle(), 
                "instant" => $instant, 
                "source" => $source, 
                "poste" => $poste,
                "contrat" => $contrat
            ];
        
            // On ajoute la base de données
            $this->post_request($request, $params);

        } catch (Exception $e) {
            forms_manip::error_alert($e->getMessage());
        }

        // On inscript la demande de service
        if(!empty($candidatures['service'])) {
            // On récupère la candidature
            $cle_candidatures = $this->searchCandiature($candidat->getCle(), $instant)['Id_Candidatures'];

            // On récupère la clé service
            $service = $this->searchService($candidatures['service'])['Id_Services'];

            // On vérifie l'intégrité des données
            if(empty($service)) {
                throw new Exception('Service introuvable');
                exit;
            }

            // On inscrit la demande
            $this->inscriptAppliquer_a($cle_candidatures, $service);
        }
    }
    protected function inscriptCandidat($candidat) {
        // On initialise la requête
        $request = "INSERT INTO Candidats (Nom_Candidats, Prenom_Candidats, Telephone_Candidats, Email_Candidats, 
                    Adresse_Candidats, Ville_Candidats, CodePostal_Candidats, Disponibilite_Candidats, VisiteMedicale_Candidats)
                    VALUES (:nom, :prenom, :telephone, :email, :adresse, :ville, :code_postal, :disponibilite, :visite)";
        
        // On lance  requête
        $this->post_request($request, $candidat->exportToSQL());
    }
    protected function inscriptAide($candidat, $aide) {      
        // On initialise la requête
        $request = "INSERT INTO avoir_droit_a (Cle_Candidats, Cle_Aides_au_recrutement) VALUES (:candidat, :aide)";
        $params = [
            "candidat" => $candidat->getCle(), 
            "diplome" => $aide["Id_Aides_au_recrutement"]
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    protected function inscriptDiplome($candidat, $diplome) {
        // On initialise la requête
        $request = "INSERT INTO obtenir (Cle_Candidats, Cle_Diplomes) VALUES (:candidat, :diplome)";
        $params = [
            "candidat" => $candidat->getCle(), 
            "diplome" => $diplome["Id_Diplomes"]
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    protected function inscriptPostuler_a($candidat, $instant) {
        // On initialise la requête 
        $request = "INSERT INTO Postuler_a (Cle_Candidats, Cle_Instants) VALUES (:candidat, :instant)";
        $params = [
            "candidat" => $candidat->getCle(), 
            "instant" => $instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    protected function inscriptAppliquer_a($candidature, $service) {
        // On vérifie l'intégrité des données
        if(empty($candidature) || empty($service)) {
            throw new Exception('Données éronnées. Pour inscrire un Appliquer_a, la clé de candidature et la clé de service sont nécessaires');
            exit;
        }

        // On inititalise la requête
        $request = "INSERT INTO Appliquer_a (Cle_Candidatures, Cle_Services) VALUES (:candidature, :service)";
        $params = [
            "candidature" => $candidature,
            "service" => $service
        ];

        // On exécute la requête
        $this->post_request($request, $params);
    }
    protected function inscriptAvoir_droit_a($candidat, $aide) {
        // On vérifie l'intégrité des données
        if(empty($candidat) || empty($aide) || !is_numeric($aide)) {
            throw new Exception('Données éronnées. Pour inscrire un Appliquer_a, la clé de candidature et la clé de service sont nécessaires');
            exit;
        }

        // On initialise la requête
        $request = "INSERT INTO Avoir_droit_a (Cle_Candidats, Cle_Aides_au_recrutement) VALUES (:candidat, :aide)";
        $params = [
            'candidat' => $candidat->getCle(),
            'aide' => $aide
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    

    public function searchCandidat($nom, $prenom, $email=null, $telephone=null) {
        if($email != null) {
            // On récupère le candidats
            $request = "SELECT * FROM Candidats WHERE Nom_Candidats = :nom AND Prenom_Candidats = :prenom AND Email_Candidats = :email";
            $params = [
                ":nom" => $nom,
                ":prenom" => $prenom, 
                ":email" => $email
            ];
            $candidats = $this->get_request($request, $params, true);

        } elseif($telephone != null) {
            // On récupère le candidats
            $request = "SELECT * FROM Candidats WHERE Nom_Candidats = :nom AND Prenom_Candidats = :prenom AND Telephone_Candidats = :telephone";
            $params = [
                ":nom" => $nom,
                ":prenom" => $prenom, 
                ":telephone" => $telephone
            ];
            $candidats = $this->get_request($request, $params, true);

        } else {
            throw new Exception("Imposssible d'effectuer la requête sans email ou numéro de téléphone !");
            exit;
        }
        

        // On retourne le résultat
        return $candidats;
    }
    protected function searchCandiature($cle_candidat, $cle_instant) {
        // On vérifie l'intégrité des données
        if(empty($cle_candidat) || empty($cle_instant)) {
            throw new Exception ('Données éronnées. Pour rechercher une candidatures, lla clé candidat et la clé instant sont nécessaires !');
            exit;
        }
        
        // On initialise la requête
        $request = "SELECT * FROM candidatures WHERE Cle_Candidats = :candidat AND Cle_Instants = :instant";    
        $params = [
            "candidat" => $cle_candidat,
            "instant" => $cle_instant
        ];

        // On retourne le résultat
        return $this->get_request($request, $params, true, true);
    }
    protected function searchSource($source) {
        // On initialise la requête
        if(is_numeric($source)) {
            $request = "SELECT * FROM sources WHERE Id_Sources = :Id";
            $params = ["Id" => $source];

        } elseif(is_string($source)) {
            $request = "SELECT * FROM sources WHERE Intitule_Sources = :Intitule";
            $params = ["Intitule" => $source];
        } else 
            throw new Exception("La saisie de la source est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    protected function searchPoste($poste) {
        // On initialise la requête
        if(is_numeric($poste)) {
            $request = "SELECT * FROM Postes WHERE Id_Postes = :Id";
            $params = ["Id" => $poste];

        } elseif(is_string($poste)) {
            $request = "SELECT * FROM Postes WHERE Intitule_Postes = :Intitule";
            $params = ["Intitule" => $poste];
        } else 
            throw new Exception("La saisie du poste est mal typée. Il doit être un identifiant (entier positif) ou un echaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    protected function searchDiplome($diplome) {
        // Si diplome est un ID
        if(is_numeric($diplome)) {
            
            echo "Le type fournit est un entier. On recherche un Id.<br>";

            // On initialise la requête
            $request = "SELECT * FROM diplomes WHERE Id_Diplomes = :id";
            $params = ["id" => $diplome];

            // On lance la requête
            $result = $this->get_request($request, $params, true, true);

        // SI diplome est un intitule    
        } elseif(is_string($diplome)) {

            echo "Le type fournit est un string. On recherche un intitule.<br>";

            // On initialise la requête 
            $request = "SELECT * FROM diplomes WHERE Intitule_Diplomes = :intitule";
            $params = ["intitule" => $diplome];

            // On lance la requête
            $result = $this->get_request($request, $params, true);

        // En cas d'erreur de typage
        } else {
            throw new Exception("La saisie du diplome est mal typée. Il doit être un identifiant (entier positif) ou un echaine de caractères !");
            exit;
        }
           
        // On retourne le résultat
        return $result;
    }
    protected function searchAide($aide) {
        // Si aide est un ID
        if(is_numeric($aide)) {
            // On initialise la requête
            $request = "SELECT * FROM Aides_au_recrutement WHERE Id_Aides_au_recrutement = :id";
            $params = ["id" => $aide];

            // On lance la requête
            $result = $this->get_request($request, $params, true, true);
        
        // Si aide est un intitule    
        } elseif(is_string($aide)) {
            // On intitialise la requête
            $request = "SELECT * FROM Aides_au_recrutement WHERE Intitule_Aide_au_recrutement = :intitule";
            $params = ["intitule" => $aide];

            // On lance la requête
            $result = $this->get_request($request, $params, true);

        } else {
            throw new Exception("La saisie de l'aide est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
            exit;
        }

        // On retourne le résultat
        return $result;
    }
    protected function searchTypeContrat($contrat) {
        // Si contrat est un ID
        if(is_numeric($contrat)) {
            // On initialise la requête
            $request = "SELECT * FROM Types_de_contrats WHERE Id_Types_de_contrats = :id";
            $params = ['id' => $contrat];

        // Si contrat est un intitulé    
        } elseif(is_string($contrat)) {
            // On initialise la requête
            $request =  "SELECT * FROM Types_de_contrats WHERE Intitule_Types_de_contrats = :intitule";
            $params = ['intitule' => $contrat];

        } else {
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
            exit;
        }

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le résultat
        return $result;
    }
    protected function searchService($service) {
        // Si contrat est un ID
        if(is_numeric($service)) {
            // On initialise la requête
            $request = "SELECT * FROM Services WHERE Id_Services = :id";
            $params = ['id' => $service];

        // Si contrat est un intitulé    
        } elseif(is_string($service)) {
            // On initialise la requête
            $request =  "SELECT * FROM Services WHERE Intitule_Services = :intitule";
            $params = ['intitule' => $service];

        } else {
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
            exit;
        }

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le résultat
        return $result;
    }
}