<?php 

require_once(MODELS.DS.'Model.php');

class HomeModel extends Model {
    /// Méthode publique récupérant les candidatures non traitées de la base de données
    public function getNonTraiteeCandidatures(){
        // On initialise la requête
        $request = "SELECT id_Candidats AS Cle,
        intitule_postes AS Poste, 
        nom_candidats AS Nom, 
        prenom_candidats AS Prénom, 
        email_candidats AS Email, 
        telephone_candidats AS Téléphone, 
        intitule_sources AS Source

        FROM `candidatures` as c
        INNER JOIN candidats as i on c.Cle_Candidats = i.Id_Candidats
        INNER JOin postes as p on c.Cle_Postes = p.Id_Postes
        INNER JOIN sources as s on c.Cle_Sources = s.Id_Sources
        WHERE c.Statut_Candidatures = 'non traitee'";
    
        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
    }
    /// Méthode publique récupérant les propositions de contrats de la base de données
    public function getReductProposition() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Postes AS Poste,
        Nom_Candidats AS Nom, 
        Prenom_Candidats AS Prenom

        FROM Contrats AS con
        INNER JOIN Candidats AS can ON con.Cle_Candidats = can.Id_Candidats
        INNER JOIN Postes AS p ON con.Cle_Postes = p.Id_Postes
        WHERE con.Statut_Proposition = 0";

        // On lance la requête
        return $this->get_request($request);
    }
}