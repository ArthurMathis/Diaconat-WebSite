<?php 

require_once('Model.php');

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
        FROM candidats";

        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
    }
    private function getDiplomes($index) {
        // On initialise la requête
        $request = "SELECT Intitule_Diplomes
        FROM candidats AS c
        INNER JOIN diplomes AS d on c.Id_candidats = d.Cle_Candidats";

        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
    }
    private function getCandidatures($index) {
        // On initialise la requête
        $request = "SELECT 
        Statut_candidats AS statut, 
        Intitule_Sources AS source, 
        Intitule_Types_de_contrats AS type_de_contrat,
        Jour_Instants AS date,
        Intitule_Postes AS poste,

        
        FROM candidatures AS c
        INNER JOIN sources AS s ON c.Cle_Sources = s.Id_Sources
        INNER JOIN postes AS p ON c.Cle_Postes = p.Id_Postes
        INNER JOIN services AS serv ON 
        INNER JOIN etablissement AS e ON serv.Cle_Etablissement = e.id_Etablissement
        WHERE c.Cle_Candidats = " . $index;

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
                'candidats' => $candidats,
                'candidatures' => [],
                'contrats' => [],
                'rendez-vous' => []
            ];

    }
}