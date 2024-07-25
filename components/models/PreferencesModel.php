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
            LENGTH(MotDePasse_Utilisateurs) AS 'Mot de passe'

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
    /// Méthode publique retournant les postes de la base de données
    public function getPostes() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Postes AS Poste,
        Description_Postes AS Description

        FROM Postes";
        
        return $this->get_request($request);
    }
    /// Méthode publique retournant les services de la base de données
    public function getServices() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Services AS Service,
        Intitule_Etablissements AS Etablissement

        FROM Services AS s
        
        INNER JOIN Etablissements AS e ON s.cle_Etablissements = e.Id_Etablissements
        
        ORDER BY Service, Etablissement";
        
        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique retournant les services de la base de données
    public function getEtablissements() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Etablissements AS Intitulé,
        Adresse_Etablissements AS Adresse,
        Ville_Etablissements AS Ville, 
        CodePostal_Etablissements AS Code,
        Intitule_Poles AS Pôle

        FROM Etablissements  AS e
        INNER JOIN Poles AS p ON e.Cle_Poles = p.Id_Poles";

        // On lance la requête
        return $this->get_request($request);
    }

    /// Méthode publique générant un nouvel Utilisateur
    public function createUser(&$infos=[]) {
        // On récupère l'établissement
        $infos['etablissement'] = $this->searchEtablissement($infos['etablissement'])['Id_Etablissements'];

        // On génère un mot de passe
        $infos['mot de passe'] = PasswordGenerator::random_password($infos['nom'], $infos['prenom']);

        // On crée l'utilisateur
        $user = Utilisateurs::makeUtilisateurs($infos);
        unset($infos);

        // On inscrit l'Utilisateur
        $this->inscriptUtilisateurs($user->exportToSQL());  
        
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Nouvel utilisateur",
            "Création du compte de " . strtoupper($user->getNom()) . " " . forms_manip::nameFormat($user->getPrenom()) 
        );
    }
    /// Méthode publique générant un nouveau poste
    public function createPoste(&$infos=[]) {
        // On inscrit le nouveau poste
        $this->inscriptPoste($infos['poste'], $infos['description']);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Nouveau poste",
            "Ajout du poste " . $infos['poste'] . " à la base de données"
        );
    }
    /// Méthode publique générant un nouveau service
    public function createService(&$service, &$etablissement) {
        // On récupère l'établissement
        $etablissement = $this->searchEtablissement($etablissement);

        // On inscrit le service
        $this->inscriptService($service, $etablissement['Id_Etablissements']);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Nouveau service",
            "Ajout du service " . $service . " dans l'établissement " . $etablissement['Intitule_Etablissements']
        );
    }
    /// Méthode publique générant un nouvel établissement
    public function createEtablissement(&$infos=[]) {
        // On récupère le pôle
        $infos['pole'] = $this->searchPole($infos['pole'])['Id_Poles'];

        // On inscrit l'établissement
        $this->inscriptEtablissement($infos);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Nouvel établissement",
            "Ajout de l'établissement " . $infos['intitule']
        );
    }
    /// Méthode publique vérifiant le mot de passe de l'utilisateur
    public function verify_password(&$password) {
        // On initialise la requête
        $request = "SELECT * FROM Utilisateurs WHERE Id_Utilisateurs = :cle";
        $params = ['cle' => $_SESSION['user_cle']];

        $user = $this->get_request($request, $params, 1, 1)[0];

        // On compare les mots de passe
        return password_verify($password, $user['MotDePasse_Utilisateurs']);
    }

    /// Méthode publique enregistrant les mise-à-jour de mots de passe dans les logs
    public function updatePasswordLogs() {
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_cle'],
            "Mise-à-jour mot de passe",
            strtoupper($_SESSION['user_nom']) . " " . forms_manip::nameFormat($_SESSION['user_prenom']) . " a mis-à-jour son mot de passe"
        );
    }
}