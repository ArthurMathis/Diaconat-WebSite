<?php 

require_once('Model.php');
require_once(CLASSE.DS.'Instants.php');

class UtilisateursModel extends Model {
    public function getUtilisateurs() {
        // On initialise la requête 
        $request = "SELECT 
        Intitule_Role AS Role,
        Nom_Utilisateurs AS Nom, 
        Prenom_Utilisateurs AS Prenom,
        Email_Utilisateurs AS Email,
        Intitule_Etablissements AS Etablissement

        FROM Utilisateurs AS u
        INNER JOIN Roles AS r ON u.Cle_Roles = r.Id_Role
        INNER JOIN Etablissements AS e ON u.Cle_Etablissements = e.Id_Etablissements";

        return $this->get_request($request);
    }
}