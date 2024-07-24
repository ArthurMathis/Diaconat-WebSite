<?php 

require_once('Model.php');
require_once(CLASSE.DS.'Instants.php');
require_once(CLASSE.DS.'Contrats.php');

class CandidatsModel extends Model {
    /// Méthode publique récupérant dans la base de données la liste des candidats
    public function getContent() {
        // On initialise la requête
        $request = "SELECT 
            Id_Candidats AS Cle,
            Nom_candidats AS Nom, 
            Prenom_Candidats AS Prenom, 
            Email_Candidats AS Email, 
            Ville_Candidats AS Ville, 
            Notations_Candidats AS Notation
            FROM Candidats AS c";
    
        // On lance la requête
        $temp = $this->get_request($request, []);
    
        // On traite les données
        foreach ($temp as &$obj) {  // Utilisation de la référence
            if ($obj['Notation'] == null) {
                $obj['Notation'] = "Aucune notation";
            }    
        }
        unset($obj);
    
        // On retourne la liste
        return $temp;
    }
    /// Méthode publique récupérant les données à metttre à jour dans la base de données
    public function getEditContent($index) {
        // On vérifie l'intégrité des données
        if(!is_numeric($index))
            throw new Exception("L'index n'est pas valide. Veullez saisir un entier !");

        $candidats = $this->getCandidats($index);
        array_push($candidats, ['diplomes' => $this->getDiplomes($index)]);

        return [
            'candidat' => $candidats,
            'aide' => $this->get_request("SELECT Id_Aides_au_recrutement AS id, Intitule_Aides_au_recrutement AS intitule FROM Aides_au_recrutement", [])
        ];
    }

    /// Méthode publique retournant la fiche profil d'un candidat
    public function getContentCandidat($index) {
        // On vérifie l'intégrité des données
        if(!is_numeric($index))
            throw new Exception("L'index n'est pas valide. Veullez saisir un entier !");

        $candidats = $this->getCandidats($index);
        array_push($candidats, ['diplomes' => $this->getDiplomes($index)]);

        return [
            'candidat' => $candidats,
            'aide' => $this->getAides($index),
            'candidatures' => $this->getCandidatures($index),
            'contrats' => $this->getContrats($index),
            'rendez-vous' => $this->getRendezVous($index)
        ];
    }
    /// Méthode privée retournant un candidat selon son Id 
    public function getCandidats($index) {
        // On initialise la requête
        $request = "SELECT 
        Id_Candidats AS id,
        Nom_Candidats AS nom,
        Prenom_Candidats AS prenom,
        Telephone_Candidats AS telephone,
        Email_Candidats AS email, 
        Adresse_Candidats AS adresse,
        Ville_Candidats AS ville,
        CodePostal_Candidats AS code_postal,
        Disponibilite_Candidats AS disponibilite,
        Notations_Candidats AS notation,
        Descriptions_Candidats AS description, 
        A_Candidats AS a, 
        B_Candidats AS b, 
        C_Candidats AS c

        FROM candidats AS c
        WHERE c.Id_Candidats = :cle";

        $params = [
            "cle" => $index
        ];

        // On lance la requête
        return $this->get_request($request, $params)[0];
    }
    /// Méthode privée retournant la liste des diplômes obetnus par un candidat 
    private function getDiplomes($index) {
        // On initialise la requête
        $request = "SELECT Intitule_Diplomes

        FROM candidats AS c
        INNER JOIN obtenir AS o ON c.Id_candidats = o.Cle_Candidats
        INNER JOIN diplomes AS d on o.Cle_Diplomes = d.Id_Diplomes
        
        WHERE c.Id_Candidats = :cle";
        $params = ['cle' => $index];

        // On lance la requête
        return $this->get_request($request, $params);
    }
    /// Méthode privée retournant la liste des candidatures d'un candidat 
    private function getCandidatures($index) {
        // On initialise la requête
        $request = "SELECT 
        Id_Candidatures AS cle,
        Statut_Candidatures AS statut, 
        Intitule_Sources AS source, 
        Intitule_Types_de_contrats AS type_de_contrat,
        Jour_Instants AS date,
        Intitule_Postes AS poste,
        Intitule_Services AS service,
        Intitule_Etablissements AS etablissement
        
        FROM candidatures AS c
        INNER JOIN instants AS i ON c.Cle_Instants = i.Id_Instants
        INNER JOIN sources AS s ON c.Cle_Sources = s.Id_Sources
        INNER JOIN postes AS p ON c.Cle_Postes = p.Id_Postes
        INNER JOIN types_de_contrats AS t ON c.Cle_Types_de_contrats = t.Id_Types_de_contrats
        LEFT JOIN appliquer_a AS app ON c.Id_candidatures = app.Cle_Candidatures
        LEFT JOIN services as serv ON app.Cle_Services = serv.Id_Services
        LEFT JOIN etablissements AS e ON serv.Cle_Etablissements = e.id_Etablissements

        WHERE c.Cle_Candidats = :cle";
        $params = [
            'cle' => $index
        ];

        // On lance la requête
        return $this->get_request($request, $params);
    }
    /// Méthode privée retournant la liste des contrats d'un candidat 
    private function getContrats($index) {
        // On initialise la requête 
        $request = "SELECT 
        Id_Contrats AS cle,
        Intitule_Postes AS poste,
        Intitule_Services AS service,
        Intitule_Etablissements AS etablissement,
        Salaires_Contrats AS salaire,
        Nombre_heures_hebdomadaires_Contrats AS heures,
        Travail_de_nuit_Contrats AS nuit,
        Travail_week_end_Contrats AS week_end,
        Date_debut_Contrats AS date_debut,
        Date_fin_Contrats AS date_fin,
        Date_demission_Contrats AS demission,
        Intitule_Types_de_contrats AS type_de_contrat,
        Jour_Instants AS proposition,
        Statut_Proposition AS statut,
        date_signature_Contrats AS signature 

        FROM contrats as c
        INNER JOIN Missions AS m ON c.Cle_Services = m.Cle_Services AND c.Cle_Postes = m.Cle_Postes
        INNER JOIN Postes AS p ON c.Cle_Postes = p.Id_Postes
        INNER JOIN Services AS s ON c.Cle_Services = s.Id_Services
        INNER JOIN Etablissements AS e ON s.Cle_Etablissements = e.Id_Etablissements
        INNER JOIN instants AS i ON c.Cle_Instants = i.Id_Instants
        INNER JOIN Types_de_contrats AS t ON c.Cle_Types_de_contrats = t.Id_Types_de_contrats

        WHERE c.Cle_Candidats = :cle";
        $params = [
            'cle' => $index
        ];

        // On lance la requête
        return $this->get_request($request, $params);
    }
    /// Méthode privée retournant la liste des rendez-vous d'un candidat 
    private function getRendezVous($index) {
        // On initialise la requête 
        $request = "SELECT 
        Nom_Utilisateurs AS nom,
        Prenom_Utilisateurs AS prenom,
        Jour_Instants AS date,
        Heure_Instants AS heure,
        Intitule_Etablissements AS etablissement,
        Compte_rendu_Avoir_rendez_vous_avec AS description,

        Id_Utilisateurs AS cle_utilisateur,
        Cle_Candidats AS cle_candidat,
        Id_Instants AS cle_instant

        FROM  avoir_rendez_vous_avec AS rdv
        INNER JOIN utilisateurs AS u ON rdv.Cle_Utilisateurs = u.Id_Utilisateurs
        INNER JOIN instants AS i  ON rdv.Cle_Instants = i.Id_Instants
        INNER JOIN Etablissements AS e ON e.Id_Etablissements = rdv.Cle_Etablissements

        WHERE rdv.Cle_Candidats = :cle";
        $params = [
            'cle' => $index
        ];

        // On lance la requête
        return $this->get_request($request, $params);
    }

    /// Méthode privée retournant la liste des aides au recrutement
    private function getAides($index) {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Aides_au_recrutement AS intitule 

        FROM Aides_au_recrutement AS aide
        INNER JOIN Avoir_droit_a AS avoir ON aide.Id_Aides_au_recrutement = avoir.Cle_Aides_au_recrutement
        WHERE avoir.Cle_candidats = " . $index;

        // On lance la requête
        $result = $this->get_request($request);
    
        return empty($result) ? null : $result[0];
    }
    public function getTypeContrat($cle_candidature) {
        $candidature = $this->searchCandidature($cle_candidature);
        return $this->searchTypeContrat($candidature['Cle_Types_de_contrats'])['Intitule_Types_de_contrats'];
    }
    

    /// Méthode publique construisant un candidat selon son Id
    public function makeCandidat($index) {
        // On initialise la requête
        $request = "SELECT 
        Id_Candidats AS id,
        Nom_Candidats AS nom,
        Prenom_Candidats AS prenom,
        Telephone_Candidats AS telephone,
        Email_Candidats AS email, 
        Adresse_Candidats AS adresse,
        Ville_Candidats AS ville,
        CodePostal_Candidats AS code_postal,
        Disponibilite_Candidats AS disponibilite,
        Notations_Candidats AS notation

        FROM candidats AS c
        WHERE c.Id_Candidats = " . $index;

        // On lance la requête
        $result = $this->get_request($request)[0];

        // On construit la candidat selon la recherche
        $candidat = new Candidat(
            $result['nom'], 
            $result['prenom'], 
            $result['email'], 
            $result['telephone'],
            $result['adresse'], 
            $result['ville'], 
            $result['code_postal']
        );
        $candidat->setCle($result['id']);

        return $candidat;
    }

    /// Méthode publique implémentant le statut d'une candidature
    public function setCandidatureStatut($statut, $cle) {
        try {
            if(empty($statut) || !is_string($statut))
                throw new Exception('Statut invalide !');

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
           
        // On initialise la requête
        $request = "UPDATE Candidatures SET Statut_Candidatures = :statut WHERE Id_Candidatures = :cle";
        $params = [
            'statut' => $statut,
            'cle' => $cle
        ];

        // On exécute la requête
        $this->post_request($request, $params);
    }
    /// Méthode publique implémentant le statut d'une proposition
    public function setPropositionStatut($cle) {
        // On initialise la requête
        $request = "UPDATE Contrats SET Statut_Proposition = :statut WHERE Id_Contrats = :cle";
        $params = [
            'statut' => 1,
            'cle' => $cle
        ];
        
        // On exécute la requête
        $this->post_request($request, $params);
    }

    /// Méthpode publique refusant une candidature et inscrivant les logs
    public function rejectCandidature(&$cle_candidature) {
        // On implémente le statut de la candidature
        $this->setCandidatureStatut('Refusée', $cle_candidature);

        // On récupère les informations de la candidature
        $candidat = $this->searchCandidatFromCandidature($cle_candidature);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'], 
            "Refus d'une candidature", 
            "Refus de la candidature de " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . 
            " au poste de " . forms_manip::nameFormat($this->searchPoste($this->searchCandidature($cle_candidature)['Cle_Postes'])['Intitule_Postes'])
        );
    }
    /// Méthode publique refusant une proposition et inscrivant les logs
    public function rejectProposition(&$cle_proposition) {
        // On implémente le statut de la proposition
        $this->setPropositionStatut($cle_proposition);       

        // On récupère les informations de la proposition
        $candidat = $this->searchcandidatFromContrat($cle_proposition);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'], 
            "Refus d'une proposition", 
            strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " refuse la proposition d'embauche au poste de " . 
            forms_manip::nameFormat($this->searchPoste($this->searchCandidature($cle_proposition)['Cle_Postes'])['Intitule_Postes'])
        );
    }

    /// Méthode construisant une nouvelle proposition d'embauche et l'inscrivant dans la base de données
    public function createPropositions(&$cle, &$propositions) {
        try {
            // On génère l'instant actuel
            $instant = $this->inscriptInstants()['Id_Instants'];

            // On ajoute la clé candidat
            $propositions['cle candidat'] = $cle;
            // On ajoute la clé instant
            $propositions['cle instant'] = $instant;
            // On ajoute la clé poste
            $propositions['cle poste'] = is_numeric($propositions['poste']) ? $propositions['poste'] : $this->searchPoste($propositions['poste'])['Id_Postes'];    
            // On ajoute la clé service
            $propositions['cle service'] = is_numeric($propositions['service']) ? $propositions['service'] : $this->searchService($propositions['service'])['Id_Services'];
            // On ajoute la clé de type de contrat
            $propositions['cle type'] = isset($propositions['type']) && is_numeric($propositions['type']) ? $propositions['type'] : $this->searchTypeContrat($propositions['type_de_contrat'])['Id_Types_de_contrats'];

            // On génère le contrat
            $contrat = Contrat::makeContrat($propositions);
        
        } catch(Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription de la proposition",
                'msg' => $e
            ]);
            // forms_manip::error_alert($e);
        }
        
        // On inscrit la proposition
        $this->inscriptProposer_a($contrat->getCleCandidats(), $contrat->getCleInstants());
        $this->verifyMission($contrat->getCleServices(), $contrat->getClePostes());
   
        // On enregistre le contrat 
        $this->inscriptContrats($contrat->exportToSQL());
        unset($contrat);

        // On enregistre les logs
        $candidat = $this->searchcandidat($cle);
        $this-> writeLogs(
            $_SESSION['user_cle'],
            "Nouvelle proposition",
            "Nouvelle proposition de contrat pour " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " au poste de " . forms_manip::nameFormat($this->searchPoste($propositions['cle poste'])['Intitule_Postes'])
        );
    }
    /// Méthode construisant une nouvelle proposition d'embauche depuis une candidature et l'inscrivant dans la base de données
    public function createPropositionsFromCandidature($cle_candidature, &$propositions=[], &$cle_candidat) {
        // On récupère la candidature
        $candidature = $this->searchCandidature($cle_candidature);

        // On implémente le tableau de données de la proposition
        $propositions['poste'] = $candidature['Cle_Postes'];
        $propositions['service'] = $this->searchAppliquer_aFromCandidature($candidature['Id_Candidatures'])['Cle_Services'];
        $propositions['type_de_contrat'] = $candidature['Cle_Types_de_contrats'];

        // On récupère la clé candidat
        $cle_candidat = $this->searchCandidatFromCandidature($cle_candidature)['Cle_Candidats'];
    }
    /// Méthode construisant une nouvelle proposition d'embauche depuis une cnadidature sans service et l'inscrivant dans la base de données
    public function createPropositionsFromEmptyCandidature($cle_candidature, &$propositions=[], &$cle_candidat) {
        // On récupère la candidature
        $candidature = $this->searchCandidature($cle_candidature);

        // On implémente le tableau de données de la proposition
        $propositions['poste'] = $candidature['Cle_Postes'];
        $propositions['type_de_contrat'] = $candidature['Cle_Types_de_contrats'];

        // On récupère la clé candidat
        $cle_candidat = $this->searchCandidatFromCandidature($cle_candidature)['Cle_Candidats'];
    }
    /// Méthode construisant nouveau contrat et l'inscrivant dans la base de données
    public function createContrats($cle_candidats, &$contrat=[]) {
        try {
            // On génère l'instant actuel
            $instant = $this->inscriptInstants()['Id_Instants'];

            // On ajoute la date de signature
            $contrat['signature'] = Instants::currentInstants()->getdate();

            // On récupère les informations relatives au poste
            $poste = $this->searchPoste($contrat['poste']);

            // On ajoute la clé candidat
            $contrat['cle candidat'] = $cle_candidats;
            unset($cle_candidat);
            // On ajoute la clé instant
            $contrat['cle instant'] = $instant;
            unset($instant);
            // On ajoute la clé poste
            // $contrat['cle poste'] = is_numeric($contrat['poste']) ? $contrat['poste'] : $this->searchPoste($contrat['poste'])['Id_Postes'];
            $contrat['cle poste'] = $poste['Id_Postes'];
            // On ajoute la clé service
            $contrat['cle service'] = is_numeric($contrat['service']) ? $contrat['service'] : $this->searchService($contrat['service'])['Id_Services'];
            // On ajoute la clé de type de contrat
            $contrat['cle type'] = isset($contrat['type']) && is_numeric($contrat['type']) ? $contrat['type'] : $this->searchTypeContrat($contrat['type_de_contrat'])['Id_Types_de_contrats'];

            // On génère le contrat
            $contrat = Contrat::makeContrat($contrat);
        
        } catch(Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription du contrat",
                'msg' => $e
            ]);
        }

        // On inscrit la proposition
        $this->inscriptProposer_a($contrat->getCleCandidats(), $contrat->getCleInstants());
        $this->verifyMission($contrat->getCleServices(), $contrat->getClePostes());

        // On enregistre le contrat 
        $this->inscriptContrats($contrat->exportToSQL());

        // On enregistre les logs
        $candidat = $this->searchcandidat($contrat->getCleCandidats());
        unset($contrat);
        $this->writeLogs(
            $_SESSION['user_cle'], 
            "Nouveau contrat", 
            "Nouveau contrat de " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " au poste de " . $poste['Intitule_Postes']
        );
    }
    public function createRendezVous($cle_candidat, &$rendezvous=[]) {
        try {
            // On génère l'instant
            $rendezvous['instant'] = $this->inscriptInstants($rendezvous['date'], $rendezvous['time'])['Id_Instants'];

            // On récupère l'établissement
            $rendezvous['cle etablissement'] = $this->searchEtablissement($rendezvous['etablissement'])['Id_Etablissements'];

            // On récupère la clé de l'utilisateur
            $rendezvous['recruteur'] = $rendezvous['recruteur'] == $_SESSION['user_identifiant'] ? $_SESSION['user_cle'] : $this->searchUserFromUsername($rendezvous['recruteur'])['Id_Utilisateurs'];

        // On récupère les éventuelles erreurs    
        } catch(Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription du rendez-vous",
                'msg' => $e
            ]);
        }

        $this->inscriptAvoir_rendez_vous_avec($rendezvous['recruteur'], $cle_candidat, $rendezvous['cle etablissement'], $rendezvous['instant']);

        // On enregistre les logs
        $candidat = $this->searchcandidat($cle_candidat);
        $this->writeLogs(
            $_SESSION['user_cle'], 
            "Nouveau rendez-vous", 
            "Nouveau rendez-vous avec " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . ", le " . $rendezvous['date']
        );
    }

    /// Méthode protégées inscrivant un contrat dans la base de données
    protected function inscriptContrats($contrats=[]) {
        // Requête avec date de fin de contrat
        if(isset($contrat['date fin'])) {
            // Requête avec salaire
            if(isset($contrats['salaire'])) {
                // Requête avec travail de nuit
                if(isset($contrats['travail nuit'])) {
                    // Requête avec travail de week-end
                    if(isset($contrats['travail wk'])) {
                        // Requête avec taux horaire hebdomadaire
                        if(isset($contrats['nb heures'])) {
                            // On initialise la requête
                            $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                            VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                            // On prépare les paramètres
                            $params = [
                                "date_debut" => $contrats['date debut'],
                                "date_fin" => $contrats['date fin'],
                                "salaire" => $contrats['salaire'],
                                "travail_nuit" => $contrats['travail nuit'],
                                "travail_wk" => $contrats['travail wk'],
                                "nb_heures" => $contrats['nb heures'],
                                "signature" => $contrats['signature'],
                                "cle_candidat" => $contrats['cle candidat'],
                                "cle_instant" => $contrats['cle instant'],
                                "cle_service" => $contrats['cle service'],
                                "cle_poste" => $contrats['cle poste'],
                                "cle_types" => $contrats['cle types']
                            ];

                        // Requête sans taux horaire hebdomadaire    
                        } else {
                            // On initialise la requête
                            $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                            VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                            // On prépare les paramètres
                            $params = [
                                "date_debut" => $contrats['date debut'],
                                "date_fin" => $contrats['date fin'],
                                "salaire" => $contrats['salaire'],
                                "travail_nuit" => $contrats['travail nuit'],
                                "travail_wk" => $contrats['travail wk'],
                                "signature" => $contrats['signature'],
                                "cle_candidat" => $contrats['cle candidat'],
                                "cle_instant" => $contrats['cle instant'],
                                "cle_service" => $contrats['cle service'],
                                "cle_poste" => $contrats['cle poste'],
                                "cle_types" => $contrats['cle types']
                            ];
                        }

                    // Requête sans travail de week-end avec taux horaire hebdomadaire
                    } elseif(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire    
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de nuit avec travail de week-end
                } elseif(isset($contrats['travail wk'])) {
                    // Requête avec taux horaire hebdomadaire
                    if(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_wk" => $contrats['travail wk'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire    
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_wk" => $contrats['travail wk'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de week-end avec taux horaire hebdomadaire    
                } elseif(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :salaire, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "salaire" => $contrats['salaire'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire    
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :salaire, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "salaire" => $contrats['salaire'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans salaire avec travail de nuit
            } if(isset($contrats['travail nuit'])) {
                // Requête avec travail de week-end
                if(isset($contrats['travail wk'])) {
                    // Requête avec taux horaire hebdomadaire
                    if(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire    
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de week-end avec taux horaire hebdomadaire 
                } elseif(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                   
                // Requête sans taux horaire hebdomadaire     
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de nuit avec travail de week-end
            } elseif(isset($contrats['travail wk'])) {
                // Requête avec taux horaire hebdomadaire
                if(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_wk" => $contrats['travail wk'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_wk" => $contrats['travail wk'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de nuit avec taux horaire hebdomadaire
            } elseif(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :date_fin, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "date_fin" => $contrats['date fin'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire    
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :date_fin, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "date_fin" => $contrats['date fin'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans date de fin avec salaire 
        } elseif(isset($contrats['salaire'])) {
            // Requête avec travail de nuit
            if(isset($contrats['travail nuit'])) {
                // Requête avec travail de week-end
                if(isset($contrats['travail wk'])) {
                    // Requête sans travail de week-end avec taux horaire hebdomadaire 
                    if(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :salaire, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :salaire, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de nuit avec taux horaire hebdomadaire  
                } elseif(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :salaire, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                     
                // Requête sans taux horaire hebdomadaire     
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :salaire, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de nuit avec travail de week-end 
            } elseif(isset($contrats['travail wk'])) {
                // Requête sans travail de week-end avec taux horaire hebdomadaire
                if(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :salaire, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_wk" => $contrats['travail wk'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)   
                    VALUES (:date_debut, :salaire, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_wk" => $contrats['travail wk'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de week-end avec taux horaire hebdomadaire
            } elseif(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :salaire, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "salaire" => $contrats['salaire'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :salaire, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "salaire" => $contrats['salaire'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans salaire avec travail de nuit    
        } else if(isset($contrats['travail nuit'])) {
            // Requête avec travail de week-end 
            if(isset($contrats['travail wk'])) {
                // Requêtes avec taux horaire hebdomadaire
                if(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "travail_wk" => $contrats['travail wk'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire    
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "travail_wk" => $contrats['travail wk'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de week-end avec taux horaire hebdomadaire
            } elseif(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_nuit" => $contrats['travail nuit'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_nuit" => $contrats['travail nuit'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans travail de nuit avec travail de week-end    
        } elseif(isset($contrats['travail wk'])) {
            // Requête avec taux horaire hebdomadaire
            if(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_wk" => $contrats['travail wk'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_wk" => $contrats['travail wk'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans travail de week-end avec taux horaire hebdomadaire     
        } elseif(isset($contrats['nb heures'])) {
            // On initialise la requête
            $request = "INSERT INTO Contrats (Date_debut_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
            VALUES (:date_debut, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
            // On prépare les paramètres
            $params = [
                "date_debut" => $contrats['date debut'],
                "nb_heures" => $contrats['nb heures'],
                "signature" => $contrats['signature'],
                "cle_candidat" => $contrats['cle candidat'],
                "cle_instant" => $contrats['cle instant'],
                "cle_service" => $contrats['cle service'],
                "cle_poste" => $contrats['cle poste'],
                "cle_types" => $contrats['cle types']
            ];

        // Requête sans taux horaire hebdomadaire
        } else {
            // On initialise la requête
            $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
            VALUES (:date_debut, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
            // On prépare les paramètres
            $params = [
                "date_debut" => $contrats['date debut'],
                "signature" => $contrats['signature'],
                "cle_candidat" => $contrats['cle candidat'],
                "cle_instant" => $contrats['cle instant'],
                "cle_service" => $contrats['cle service'],
                "cle_poste" => $contrats['cle poste'],
                "cle_types" => $contrats['cle types']
            ];
        }

        $params['cle_instant'] = strval($params['cle_instant']);
        $params['cle_service'] = strval($params['cle_service']);
        $params['cle_poste'] = strval($params['cle_poste']);
        $params['cle_types'] = strval($params['cle_types']);

        // On lance la requête
        $this->post_request($request, $params);
    }
    /// Méthode publique ajoutant une signature à un contrat
    public function addSignature($cle) {
        // On génère l'instant actuel
        $instant = Instants::currentInstants()->getDate();

        // On initialise la requête
        $request = "UPDATE Contrats SET Date_signature_Contrats = :date WHERE Id_Contrats = :contrat";
        $params = [
            'date' => $instant,
            'contrat' => $cle
        ];

        // On lance la requête
        $this->post_request($request, $params);

        // On enregistre les logs
        $candidat = $this->searchcandidatFromContrat($cle);
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Nouveau contrat",
            strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " a accepté la proposition d'offre pour le poste " . forms_manip::nameFormat($this->searchPoste($this->searchContrat($cle)['Cle_Postes'])['Intitule_Postes'])
        );
    }
    /// Méthode ajoutant une démission à un contrat 
    public function addDemission($cle) {
        // On génère l'instant actuel
        $instant = Instants::currentInstants()->getDate();

        // On initialise la requête
        $request = "UPDATE Contrats SET Date_demission_Contrats = :date WHERE Id_Contrats = :contrat";
        $params = [
            'date' => $instant,
            'contrat' => $cle
        ];

        // On lance la requête
        $this->post_request($request, $params);

        // On enregistre les logs
        $candidat = $this->searchcandidatFromContrat($cle);
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Démission",
            strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " a démissioné de son travail de " . forms_manip::nameFormat($this->searchPoste($this->searchContrat($cle)['Cle_Postes'])['Intitule_Postes'])
        );
    }
    /// Méthode supprimant un rendez-vous
    public function annulationRendezVous($cle_utilisateur, $cle_candidat, $cle_instant) {
        // On supprime le rendez-vous
        $this->deleteRendezVous($cle_candidat, $cle_utilisateur, $cle_instant);
        unset($cle_utilisateur);

        // On récupère les informations du rendez-vous
        $candidat = $this->searchCandidat($cle_candidat);
        unset($cle_candidat);
        $instant = $this->searchInstant($cle_instant);
        
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Annulation rendez-vous",
            strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " a annulé son rendez-vous du " . $instant['Jour_Instants']
        );
        unset($candidat);
        unset($instant);

        // On suprime l'instant du rendez-vous
        $this->deleteInstant($cle_instant);
    }
    /// Méthode protégée vérifiant qu'une mission est dans la base de données
    protected function verifyMission($cle_service, $cle_poste) {
        // On initialise la requête 
        $request = "SELECT * FROM Missions WHERE Cle_Services = :service AND Cle_Postes = :poste";
        $params = [
            'service' => $cle_service,
            'poste' => $cle_poste
        ];

        // On lance la requête
        $mission = $this->get_request($request, $params);

        // On test la présence de la mission
        if(empty($mission)) {
            echo "On inscript la mission<br>";
            // On inscrit la mission
            $this->inscriptMission($cle_service, $cle_poste);
        }
    }

    public function makeUpdatecandidat($cle_candidat, &$candidat) {
        try {
            $c = new Candidat($candidat['nom'], $candidat['prenom'], $candidat['email'], $candidat['telephone'], $candidat['adresse'], $candidat['ville'], $candidat['code-postal']);
            unset($candidat['nom']);
            unset($candidat['prenom']);
            unset($candidat['email']);
            unset($candidat['telephone']);
            unset($candidat['adresse']);
            unset($candidat['ville']);
            unset($candidat['code-postal']);

        } catch(InvalideCandidatExceptions $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de la mise-à-jour du candidat",
                'msg' => $e
            ]);
        }

        // On met à jour le candidat
        $this->updateCandidat($cle_candidat, $c->exportToSQL_update());
        unset($c);

        // On supprime les diplomes du candidat
        $request = "DELETE FROM Obtenir WHERE Cle_Candidats = :cle";
        $params = ['cle' => $cle_candidat];

        // On lance la requête
        $this->post_request($request, $params);

        // On récupère la liste des diplomes
        for($i = 0; $i < count($candidat['diplome']); $i++) {
            if(!empty($candidat['diplome'][$i]) && 0 < strlen($candidat['diplome'][$i])) {
                $temp = $this->searchDiplome($candidat['diplome'][$i]);

                if(empty($temp)) {
                    // On ajoute le nouveau diplome à la base de données
                    $this->createDiplome($candidat['diplome'][$i]);

                    // On récupère le diplome
                    $temp = $this->searchDiplome($candidat['diplome'][$i]);
                }

                unset($candidat['diplome'][$i]);
                $this->inscriptDiplome($cle_candidat, $temp['Id_Diplomes']);
            }
        }
        unset($candidat['diplome']);

        // On supprime l'aide du candidat
        $request = "DELETE FROM Avoir_droit_a WHERE Cle_Candidats = :cle";
        $params = ['cle' => $cle_candidat];

        // On lance la requête
        $this->post_request($request, $params);

        if($candidat['aide']) 
            $this->inscriptAvoir_droit_a($cle_candidat, $candidat['aide']);
        
        unset($candidat);
    }

    /// Méthode publique enregistrant les logs de la mise-à-jour de la notation d'un candidat
    public function updateNotationLogs($cle_candidat) {
        // On récupère les informations du candidat
        $candidat = $this->searchcandidat($cle_candidat);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Mise-à-jour notation",
            "Mise-à-jour de la notation de " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats'])
        );
    }
    /// Méthode publique enregistrant les logs de la mise-à-jour d'un candidat
    public function updateCandidatLogs($cle_candidat) {
        // On récupère les informations du candidat
        $candidat = $this->searchcandidat($cle_candidat);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Mise-à-jour candidat",
            "Mise-à-jour du profil de " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats'])
        );
    }

    /// Méthode protégée recherchant un candidat dans la base de données
    private function searchcandidat($cle_candidat) {
        if(empty($cle_candidat) || !is_numeric($cle_candidat)) 
            throw new Exception('Erreur lors de la recherche du candidat. La clé candidat doit être un nombre entier positif !');

        // On initialise la requête
        $request = "SELECT * FROM Candidats WHERE Id_Candidats = :cle";
        $params = ['cle' => $cle_candidat];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
}