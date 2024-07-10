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
        WHERE c.Statut_Candidatures = 'non traitee'
        
        ORDER BY c.Id_Candidatures DESC";
    
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
        WHERE con.Statut_Proposition = 0
        
        ORDER BY con.Id_Contrats DESC";

        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique récupérant les rendez-vous
    public function getreductRendezVous() {
        // On initialise la requête
        $request = "SELECT 
        Nom_Candidats AS Nom, 
        Prenom_Candidats AS Prenom,
        Jour_Instants AS Jour,
        Heure_Instants AS Heure
        
        FROM Avoir_rendez_vous_avec AS rdv
        INNER JOIN Candidats AS c ON rdv.Cle_Candidats = c.Id_Candidats
        INNER JOIN Instants AS i ON rdv.Cle_Instants = i.Id_Instants
        
        WHERE rdv.Cle_Utilisateurs = :cle";
        $params = ['cle' => $_SESSION['user_cle']];

        // On lance la requête
        $this->get_request($request, $params);
    }
}