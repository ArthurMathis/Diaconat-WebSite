<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Instants.php');
require_once(CLASSE.DS.'Candidats.php');

class CandidaturesModel extends Model {
    /// Méthode publique retourant la liste des candidatures 
    public function getCandidatures() {
        // On initialise la requête
        $request = "SELECT 
        id_Candidats AS Cle,
        Statut_Candidatures AS Statut, 
        nom_candidats AS Nom, 
        prenom_candidats AS Prenom, 
        intitule_postes AS Poste,
        email_candidats AS Email, 
        telephone_candidats AS Telephone, 
        intitule_sources AS Source, 
        Disponibilite_Candidats AS Disponibilite

        FROM `candidatures` as c
        INNER JOIN candidats as i on c.Cle_Candidats = i.Id_Candidats
        INNER JOin postes as p on c.Cle_Postes = p.Id_Postes
        INNER JOIN sources as s on c.Cle_Sources = s.Id_Sources
        
        ORDER BY c.Id_Candidatures DESC";
    
        // On lance la requête
        return $this->get_request($request);
    }
    
    protected function searchCandidatByConcat($name) {
        // On initalise la requête
        $request = "SELECT * FROM Candidats
        WHERE CONCAT(Nom_Candidats, ' ', Prenom_Candidats) = :candidat";
        $params = ['candidat' => $name];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }

    /// Méthode publique vérifiant l'intégrité d'un candidat avant son inscription en base
    public function verify_candidat(&$candidat=[], $diplomes=[], $aide=[], $visite_medicale, $coopteur) {
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
            
            if(!empty($aide)) {
            $i = 0;
            $size = count($aide);
            $coopt = 0;
            while($i < $size) {
                if($aide[$i] == $this->searchAide('Prime de cooptation')['Id_Aides_au_recrutement']) 
                    $coopt++; 
                $i++;
            }
            if(1 < $coopt) throw new Exception("Il n'est possible de renseigner q'une prime de cooptation");
        }
        
        } catch(InvalideCandidatExceptions $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }

        

        // On ajoute la visite médical
        if(!empty($visite_medicale))
            $candidat->setVisite($visite_medicale);
    
        // On récupère la clé du coopteur
        if($coopteur)
            $coopteur = $this->searchCandidatByConcat($coopteur);

        // On enregistre les données dans la session
        $_SESSION['candidat'] = $candidat;
        $_SESSION['diplomes'] = $diplomes;
        $_SESSION['aide']     = $aide;
        $_SESSION['coopteur'] = $coopteur;
    }

    /// Méthode publique générant un candidat et inscrivant les logs
    public function createCandidat(&$candidat, $diplomes=[], $aide=[], $coopteur) {
        // On inscrit le candidat
        $this->inscriptCandidat($candidat);

        // On récupère l'Id du candidat
        $search = $this->searchcandidat($candidat->getNom(), $candidat->getPrenom(), $candidat->getEmail());
        
        // On ajoute la clé de Candidats
        $candidat->setCle($search['Id_Candidats']);

        // On enregistre les diplomes
        if(!empty($diplomes)) foreach($diplomes as $item) {
            $this->inscriptObtenir($candidat->getCle(), $this->searchDiplome($item)['Id_Diplomes']);
        }

        // On enregistre les aides
        if($aide != null) foreach($aide as $item) 
            $this->inscriptAvoir_droit_a($candidat->getCle(), $item, $item == 3 ? $coopteur['Id_Candidats'] : null);
            
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau candidat", 
            "Inscription du candidat " . strtoupper($candidat->getNom()) . " " . forms_manip::nameFormat($candidat->getPrenom())
        );
    }
    /// Méthode publique générant une nouvelle aide
    public function createAide($aide) {
        // On initialise la requête
        $request = "INSERT INTO Aides_au_recrutement (Intitule_Aides_au_recrutement) VALUES (:intitule)";
        $params = ["intitule" => $aide];

        // On lance la requête
        $this->post_request($request, $params);
    }

    /// Méthode publique inscrivant une candidature et les logs
    public function inscriptCandidature(&$candidat, $candidatures=[]) {
        // On iscrit la candidature 
        try {
            // On inscrit l'instant 
            $instant = $this->inscriptInstants()['Id_Instants'];

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
            $this->inscriptPostuler_a($candidat->getCle(), $instant);

            // On ajoute l'action à la base de données
            $request = "INSERT INTO Candidatures (Statut_Candidatures, Cle_Candidats, Cle_Instants, Cle_Sources, Cle_Postes, Cle_Types_de_contrats) 
                        VALUES (:statut, :candidat, :instant, :source, :poste, :contrat)";
            $params = [
                "statut" => 'Non-traitée', 
                "candidat" => $candidat->getCle(), 
                "instant" => $instant, 
                "source" => $source, 
                "poste" => $poste,
                "contrat" => $contrat
            ];
        
            // On ajoute la base de données
            $this->post_request($request, $params);

        } catch (Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription de la candidature",
                'msg' => $e
            ]);
        }

        // On inscript la demande de service
        if(!empty($candidatures['service'])) {
            // On récupère la candidature
            $cle_candidatures = $this->searchCandidatureFromCandidat($candidat->getCle(), $instant)['Id_Candidatures'];

            // On récupère la clé service
            $service = $this->searchService($candidatures['service'])['Id_Services'];

            // On vérifie l'intégrité des données
            try {
                if(empty($service)) throw new Exception('Service introuvable');
                
            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription de la candidature",
                    'msg' => $e
                ]);
            }
            
            // On inscrit la demande
            $this->inscriptAppliquer_a($cle_candidatures, $service);
        }

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouvelle candidature", 
            "Nouvelle candidature de " . strtoupper($candidat->getNom()) . " " . forms_manip::nameFormat($candidat->getPrenom()) . " au poste de " . $candidatures["poste"]
        );
    }

    /// Méthode publique récupérant un candidat de la base de données depuis son nom et son prénom
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

        } else 
            throw new Exception("Imposssible d'effectuer la requête sans email ou numéro de téléphone !");
        
        // On retourne le résultat
        return $candidats;
    }
}