<?php 

require_once('Model.php');
require_once(CLASSE.DS.'Instants.php');
require_once(CLASSE.DS.'Contrats.php');

class CandidatsModel extends Model {
    private function getCandidats($index) {
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
        $result = $this->get_request($request);
    
        return $result[0];
    }
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
    private function getDiplomes($index) {
        // On initialise la requête
        $request = "SELECT Intitule_Diplomes

        FROM candidats AS c
        INNER JOIN obtenir AS o ON c.Id_candidats = o.Cle_Candidats
        INNER JOIN diplomes AS d on o.Cle_Diplomes = d.Id_Diplomes";

        // On lance la requête
        return $this->get_request($request);
    }
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
    private function getRendezVous($index) {
        // On initialise la requête 
        $request = "SELECT 
        Nom_Utilisateurs AS utilisateur,
        Jour_Instants AS date,
        Compte_rendu_Avoir_rendez_vous_avec AS description

        FROM  avoir_rendez_vous_avec AS rdv
        INNER JOIN utilisateurs AS u ON rdv.Cle_Utilisateurs = u.Id_Utilisateurs
        INNER JOIN instants AS i  ON rdv.Cle_Instants = i.Id_Instants

        WHERE rdv.Cle_Candidats = :cle";
        $params = [
            'cle' => $index
        ];

        // On lance la requête
        return $this->get_request($request, $params);
    }
    public function getContent($index) {
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

    public function getTypeContrat($cle_candidature) {
        $candidature = $this->searchCandidature($cle_candidature);
        return $this->searchTypeContrat($candidature['Cle_Types_de_contrats'])['Intitule_Types_de_contrats'];
    }

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

    public function createPropositions($cle, $propositions) {
        try {
            echo "<h1>On construit la proposition</h1>";
            echo "On inscrit l'intant actuel<br>";

            // On génère l'instant actuel
            $instant = $this->inscriptInstants()['Id_Instants'];

            echo "<h2>On ajoute les clés extrenes</h2>";

            // On ajoute la clé candidat
            $propositions['cle candidat'] = $cle;
            echo "Clé candidat: " . $propositions['cle candidat'] . "<br>";

            // On ajoute la clé instant
            $propositions['cle instant'] = $instant;
            echo "Clé instant: " . $propositions['cle instant'] . "<br>";

            // On ajoute la clé poste
            $propositions['cle poste'] = is_numeric($propositions['poste']) ? $propositions['poste'] : $this->searchPoste($propositions['poste'])['Id_Postes'];;
            echo "Clé poste: " . $propositions['cle poste'] . "<br>";
            
            // On ajoute la clé service
            $propositions['cle service'] = is_numeric($propositions['service']) ? $propositions['service'] : $this->searchService($propositions['service'])['Id_Services'];
            echo "Clé service: " . $propositions['cle service'] . "<br>";

            // On ajoute la clé de type de contrat
            $propositions['cle type'] = isset($propositions['type']) && is_numeric($propositions['type']) ? $propositions['type'] : $this->searchTypeContrat($propositions['type_de_contrat'])['Id_Types_de_contrats'];
            echo "Clé type: " . $propositions['cle type'] . "<br>";


            echo "<h2>On construit un contrat </h2>";

            // On génère le contrat
            $contrat = Contrat::makeContrat($propositions);

            $infos_contrat = $contrat->exportToSQL();

            foreach($infos_contrat as $k => $v)
                echo $k . " => " . $v . "<br>";
        
        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
        
        echo "<h2>On inscrit la proposition</h2>";

        // On inscrit la proposition
        $this->inscriptProposer_a($contrat->getCleCandidats(), $contrat->getCleInstants());

        echo "Proposition inscrite<br>";

        echo "<h2>On test la présence de la mission</h2>";

        $this->verifyMission($contrat->getCleServices(), $contrat->getClePostes());


        echo "<h2>On inscrit le contrat</h2>";

        // On enregistre le contrat 
        $this->inscriptContrats($infos_contrat);
    }
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
    public function createPropositionsFromEmptyCandidature($cle_candidature, &$propositions=[], &$cle_candidat) {
        // On récupère la candidature
        $candidature = $this->searchCandidature($cle_candidature);

        // On implémente le tableau de données de la proposition
        $propositions['poste'] = $candidature['Cle_Postes'];
        $propositions['type_de_contrat'] = $candidature['Cle_Types_de_contrats'];

        // On récupère la clé candidat
        $cle_candidat = $this->searchCandidatFromCandidature($cle_candidature)['Cle_Candidats'];
    }
    public function createContrats($cle_candidats, &$contrat=[]) {
        try {
            echo "<h2>On construit la proposition</h2>";
            echo "On inscrit l'intant actuel<br>";

            // On génère l'instant actuel
            $instant = $this->inscriptInstants()['Id_Instants'];

            echo "On ajoute la date de signature<br>";

            $contrat['signature'] = Instants::currentInstants()->getdate();

            echo "<h3>On ajoute les clés extrenes</h3>";

            // On ajoute la clé candidat
            $contrat['cle candidat'] = $cle_candidats;
            echo "Clé candidat: " . $contrat['cle candidat'] . "<br>";

            // On ajoute la clé instant
            $contrat['cle instant'] = $instant;
            echo "Clé instant: " . $contrat['cle instant'] . "<br>";

            // On ajoute la clé poste
            $contrat['cle poste'] = is_numeric($contrat['poste']) ? $contrat['poste'] : $this->searchPoste($contrat['poste'])['Id_Postes'];;
            echo "Clé poste: " . $contrat['cle poste'] . "<br>";
            
            // On ajoute la clé service
            $contrat['cle service'] = is_numeric($contrat['service']) ? $contrat['service'] : $this->searchService($contrat['service'])['Id_Services'];
            echo "Clé service: " . $contrat['cle service'] . "<br>";

            // On ajoute la clé de type de contrat
            $contrat['cle type'] = isset($contrat['type']) && is_numeric($contrat['type']) ? $contrat['type'] : $this->searchTypeContrat($contrat['type_de_contrat'])['Id_Types_de_contrats'];
            echo "Clé type: " . $contrat['cle type'] . "<br>";

            echo "<h2>On construit un contrat </h2>";
            // On génère le contrat
            $contrat = Contrat::makeContrat($contrat);

            $infos_contrat = $contrat->exportToSQL();

            foreach($infos_contrat as $k => $v)
                echo $k . " => " . $v . "<br>";
        
        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
        
        echo "<h2>On inscrit la proposition</h2>";

        // On inscrit la proposition
        $this->inscriptProposer_a($contrat->getCleCandidats(), $contrat->getCleInstants());

        echo "Proposition inscrite<br>";

        echo "<h2>On test la présence de la mission</h2>";

        $this->verifyMission($contrat->getCleServices(), $contrat->getClePostes());


        echo "<h2>On inscrit le contrat</h2>";

        // On enregistre le contrat 
        $this->inscriptContrats($infos_contrat);
    }

    /// Méthode protégées inscrivant un contrat dans la base de données
    protected function inscriptContrats($contrats=[]) {

        foreach($contrats as $k => $v)
            echo $k . " => " . $v . "<br>";

        echo "<h1>On génère la requête</h1>";    

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

        $params['cle_instant']  =strval($params['cle_instant']);
        $params['cle_service']  =strval($params['cle_service']);
        $params['cle_poste']  =strval($params['cle_poste']);
        $params['cle_types']  =strval($params['cle_types']);

        echo "<h2>Requête</h2>";
        echo $request ."<br>";
        echo "<h2>Paramètres de la requête</h2>";
        foreach($params as $k => $v) 
            echo $k . " => " . gettype($v) . " : " . $v . "<br>";

        // exit;

        echo "<h2>On lance la requête</h2>";
    
        // On lance la requête
        $this->post_request($request, $params);

        echo "<h1>Contrat enregistré !</h1>";
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
    }
    /// Méthode protégée vérifiant qu'une mission est dans la base de données
    protected function verifyMission($cle_service, $cle_poste) {
        echo "On recherche la mission<br>";

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

        else echo "Mission trouvée<br>";
    }
}