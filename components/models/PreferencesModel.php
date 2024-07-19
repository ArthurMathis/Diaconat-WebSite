<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Instants.php');
require_once(CLASSE.DS.'Candidats.php');
require_once(CLASSE.DS.'Utilisateurs.php');
require_once(COMPONENTS.DS.'Passwordgenerator.php');

class PreferencesModel extends Model {
    /// Méthode publique retournant les informations du l'utilisateur actuelk
    public function getProfil(&$cle_utilisateur):array {
        // On récupère les informations de l'utilisateur
        try {
            // On initialise la requête
            $request = "SELECT 
            Nom_Utilisateurs AS Nom,
            Prenom_Utilisateurs AS Prénom, 
            Intitule_Role AS Role, 
            Email_Utilisateurs AS Email,
            LENGTH(MotDePasse_Utilisateurs) AS 'mot de passe'

            FROM Utilisateurs AS u
            INNER JOIN Roles AS r ON u.Cle_Roles = r.Id_Role
            
            WHERE u.Id_Utilisateurs = :cle";
            $params = ['cle' => $cle_utilisateur];

            // On implémente les données
            $infos = ['utilisateur' => $this->get_request($request, $params)[0]];

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }


        // On récupère l'historique de connexions de l'utilisateur
        try {
            // On initialise la requête
            $request = "SELECT
            Intitule_Types AS Action,
            Jour_Instants AS Date,
            Heure_Instants AS Heure

            FROM Actions AS a
            INNER JOIN Types AS t ON a.Cle_Types = t.Id_Types
            INNER JOIN Instants AS i ON a.Cle_Instants = i.Id_Instants

            WHERE t.Intitule_Types IN ('Connexion', 'Déconnexion')
            AND a.Cle_Utilisateurs = :cle
            ORDER BY Date DESC, Heure DESC";

            // On implémente les données
            $infos['connexions'] = $this->get_request($request, $params);;

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
        

        // On récupère l'historique d'actions de l'utilisateur
        try {
            // On initialise la requête
            $request = "SELECT
            Intitule_Types AS Action,
            Jour_Instants AS Date,
            Heure_Instants AS Heure

            FROM Actions AS a
            INNER JOIN Types AS t ON a.Cle_Types = t.Id_Types
            INNER JOIN Instants AS i ON a.Cle_Instants = i.Id_Instants

            WHERE t.Intitule_Types NOT IN ('Connexion', 'Déconnexion')
            AND a.Cle_Utilisateurs = :cle
            ORDER BY Date DESC, Heure_Instants DESC";

            // On implémente les données
            $infos['actions'] = $this->get_request($request, $params);

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
     
        // On retourne les données
        return $infos;
    }

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
    /// Méthode publique récupérant les nouveaux utilisateurs 
    public function getNouveauxUtilisateurs() {
        // On initialise la requête
        $request = "SELECT
        Intitule_Role AS Role, 
        Nom_Utilisateurs AS Nom,
        Prenom_Utilisateurs AS Prénom, 
        Intitule_Etablissements AS Etablissement
        
        FROM Utilisateurs AS u
        INNER JOIN Roles AS r ON u.cle_Roles = r.Id_Role
        INNER JOIN Etablissements AS e ON u.Cle_Etablissements = e.Id_Etablissements

        WHERE MotDePasseTemp_Utilisateurs = 1
        
        ORDER BY Role";

        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique récupérant l'historique de connexion
    public function getConnexionHistorique() {
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

        WHERE t.Intitule_Types IN ('Connexion', 'Déconnexion')

        ORDER BY Date DESC, Heure DESC";

        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique récupérant l'historique d'action
    public function getActionHistorique() {
        // On initialise la requête
        $request = "SELECT
        Intitule_Types AS Action,
        CONCAT(u.Nom_Utilisateurs, ' ', u.Prenom_Utilisateurs) AS Utilisateur,
        Jour_Instants AS Date,
        Description_Actions AS Description

        FROM Actions AS a
        INNER JOIN Utilisateurs AS u ON a.Cle_Utilisateurs = u.Id_Utilisateurs
        INNER JOIN Types AS t ON a.Cle_Types = t.Id_Types
        INNER JOIN Instants AS i ON a.Cle_Instants = i.Id_Instants

        WHERE t.Intitule_Types NOT IN ('Connexion', 'Déconnexion')

        ORDER BY Date DESC, Heure_Instants DESC";

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

        // On génère un mot de passe
        $infos['mot de passe'] = PasswordGenerator::random_password($infos['nom'], $infos['prenom']);

        // On crée l'utilisateur
        $user = Utilisateurs::makeUtilisateurs($infos);

        // On inscrit l'Utilisateur
        $this->inscriptUtilisateurs($user->exportToSQL());        
    }
    /// Méthode publique vérifiant le mot de passe de l'utilisateur
    public function verify_password(&$password) {
        echo "<h2>On récupère les informations</h2>";
        // On initialise la requête
        $request = "SELECT * FROM Utilisateurs WHERE Id_Utilisateurs = :cle";
        $params = ['cle' => $_SESSION['user_cle']];

        echo "<h3>La requête</h3>";
        var_dump($request);
        echo "<h3>Les paramètres</h3>";
        var_dump($params);


        $user = $this->get_request($request, $params, 1, 1)[0];

        echo "<h3>Le résultat</h3>";
        var_dump($user);

        echo "<h2>On compare les mots de passe</h2>";
        echo "<h3>Ancien mot de passe</h3>";
        var_dump($password);

        // On compare les mots de passe
        $res = password_verify($password, $user['MotDePasse_Utilisateurs']);

        echo "<h3>Le test</h3>";
        var_dump($res);

        return $res;
    }
}