<?php 

require_once('Model.php');
require_once(CLASSE.DS.'Candidats.php');

class CandidatsModel extends Model {
    private function getCandidats($index) {
        // On initialise la requête
        $request = "SELECT 
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
        Statut_candidatures AS statut, 
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
}