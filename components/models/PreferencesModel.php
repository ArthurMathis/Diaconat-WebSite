<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Instants.php');
require_once(CLASSE.DS.'Candidats.php');

class PreferencesModel extends Model {

    
    /// Méthode publique récupérant la liste des Utilisateurs
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
        INNER JOIN Etablissements AS e ON u.Cle_Etablissements = e.Id_Etablissements

        ORDER BY Role";

        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique récupérant l'historique de connexion
    public function getHistorique() {
        // On initialise la requête
        $request = "SELECT
        Intitule_Types AS Action,
        Intitule_Role AS Role,
        Nom_Utilisateurs AS Nom,
        Prenom_Utilisateurs AS Prenom, 
        Jour_Instants AS Date,
        Heure_Instants AS Heure

        FROM Actions AS a
        INNER JOIN Utilisateurs AS u ON a.Cle_Utilisateurs = u.Id_Utilisateurs
        INNER JOIN Roles AS r ON u.Cle_Roles = r.Id_Role
        INNER JOIN Types AS t ON a.Cle_Types = t.Id_Types
        INNER JOIN Instants AS i ON a.Cle_Instants = i.Id_Instants

        ORDER BY Date DESC, Heure DESC";

        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique récupérant les roles de la base de données
    public function getRoles() {
        // On initialise la requête
        $request = "SELECT 
        Id_Role AS id,
        Intitule_Role AS role

        FROM Roles

        ORDER BY id DESC";

        // On lance la requête
        return $this->get_request($request);
    }

    /// Méthode publique générant un nouvel Utilisateur
    public function createUser(&$infos=[]) {
        // On récupère l'établissement
        $temp = $this->searchEtablissement($infos['etablissement']);
        $infos['etablissement'] = $temp['Id_Etablissements'];
        // On vide la mémoire temporaire
        unset($temp);

        // On crée l'utilisateur
        $user = Utilisateurs::makeUtilisateurs($infos);

        // On inscrit l'Utilisateur
        $this->inscriptUtilisateurs($user->exportToSQL());        
    }
}