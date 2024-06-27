<?php 

require_once('Model.php');
require_once(CLASSE.DS.'Candidats.php');

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
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
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

        WHERE c.Cle_Candidats = " . $index;

        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
    }
    private function getContrats($index) {
        // On initialise la requête 
        $request = "SELECT 
        Intitule_Missions AS intitule,
        Intitule_Postes AS postes,
        Intitule_Services AS service,
        Intitule_Etablissements AS etablissement,
        Salaires_Contrats AS salaire,
        Nombre_heures_hebdomadaire_Contrats AS heures,
        Travail_de_nuit_Contrats AS nuit,
        Travail_week_end_Contrats AS week_end,
        Date_debut_Contrats AS date_debut,
        Date_fin_Contrats AS date_fin,
        Demissionne_Contrats AS demission,
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
        WHERE c.Cle_Candidats = " . $index;

        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
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
        WHERE rdv.Cle_Candidats = " . $index;

        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
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
        if(empty($statut) || !is_string($statut))
            throw new Exception('Statut invalide !');   
        
        else {
            // On initialise la requête
            $request = "UPDATE Candidatures SET Statut_Candidatures = :statut WHERE Id_Candidatures = :cle";
            $params = [
                'statut' => $statut,
                'cle' => $cle
            ];

            // On exécute la requête
            $this->post_request($request, $params);
        }
    }
    public function setPropositionStatut($statut, $cle) {
        // à compléter
    }

    private function searchcandidatFromCandidature($cle) {
        // On initialise la requête
        $request = "SELECT * 
        FROM Candidatures 
        INNER JOIN Candidats ON Candidatures.Cle_Candidats = Candidats.Id_Candidats
        WHERE Candidatures.Id_Candidatures = " . $cle;

        // On lance la requête
        return $this->get_request($request);
    }

    public function createPropositons($cle, $propositions) {
        // On génère l'instant actuel
        $instant = $this->inscriptInstants()['Id_Instants'];

        // On prépare la proposition
        array_push($propositions, ['cle candidat' => $cle]);
        array_push($proposition, ['cle instant' => $instant]);
        // Ajouter la clé service, la clé poste et la clé type de contrat

        // On génère le contrat
        $contrat = Contrat::makeContrat($propositions);
    }

    protected function inscriptProposer_a($cle_candidat, $cle_instant) {
        // On initialise la requête
        $request = "INSERT INTO Proposer_a (Cle_candidats, Cle_Instants) 
        VALUES (:candidat, :instant)";
        $params = [
            'candidat' => $cle_candidat,
            'instant' => $cle_instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
}
// étape 1 : créer l'instant de proposition
// étape 2 : enregistrer la proposition (instant + candidat)
// étape 3 : générer le contrat (classe)
// étape 4 : enregistrer le contrat dans la base de données