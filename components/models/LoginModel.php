<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Utilisateurs.php');
require_once(CLASSE.DS.'Instants.php');
require_once(VIEWS.DS.'ErrorView.php');

class LoginModel extends Model {
    public function connectUser($identifiant, $motdepasse) {
        // On cherche l'utilisateur dans la base de données
        $user = $this->searchUser($identifiant, $motdepasse);
        
        // On récupère les données de l'utilisateur
        $_SESSION['user_cle']           = $user->getCle();
        $_SESSION['user_identifiant']   = $user->getIdentifiant();
        $_SESSION['user_email']         = $user->getEmail();
        $_SESSION['user_motdepasse']    = $user->getMotdepasse();
        $_SESSION['user_role']          = $user->getRole();
        $_SESSION['user_role_id']       = $user->getRole_id();

        // On enregistre les logs
        $this->writeLogs($_SESSION['user_cle'], "Connexion");
    }
    public function inscriptUser($identifiant, $email, $motdepasse) {
        // On récupère le rôle invité pour l'asigner à l'utilisateur
        $role = $this->searchRole('Invite');        

        // On crée l'utilisateur
        $user = new Utilisateurs($identifiant, $email, $motdepasse, $role['Intitule_Role']);

        // On prépare la requête SQL
        $request = "INSERT INTO utilisateurs (nom_utilisateurs, email_utilisateurs, motdepasse_utilisateurs, Cle_Roles)  VALUES (:nom, :email, :motdepasse, :id_Roles)";
        $params = [
            'nom' => $user->getIdentifiant(),
            'email' => $user->getEmail(),
            'motdepasse' => password_hash($user->getMotdepasse(), PASSWORD_DEFAULT),
            'id_Roles' => $role['Id_Role']
        ];
        // On exécute la requête
        $this->post_request($request, $params);
    }
    public function firstConnectUser($identifiant, $email, $motdepasse) {
        // On ajoute l'utilisateur à la base de données
        $this->inscriptUser($identifiant, $email, $motdepasse);
        // On récupère l'utilisateur et son identifiant 
        $this->connectUser($identifiant, $motdepasse);
    }

    public function deconnectUser() {
        $this->writeLogs($_SESSION['user_cle'], 'Deconnexion');
        session_destroy();
    }
    private function writeLogs($user_cle, $action) {
        try {
            // On récupère le type d'action
            $request = "SELECT Id_Types FROM Types WHERE Intitule_Types = :Intitule";
            $action_type = $this->get_request($request, ["Intitule" => $action], true, true);
    
            // On génère l'instant actuel (date et heure actuelles)
            $instant = Instants::currentInstants();
    
            // J'enregistre mon instant dans la base de données
            $request = "INSERT INTO Instants (Jour_Instants, Heure_Instants) VALUES (:jour, :heure)";
            $params = $instant->exportToSQL();
            $this->post_request($request, $params);
    
            // On récupère l'id de mon instant 
            $request = "SELECT Id_Instants FROM Instants WHERE Jour_Instants = :jour AND Heure_Instants = :heure";
            $instant_id = $this->get_request($request, $params, true, true);
    
            // On ajoute l'action à la base de données
            $request = "INSERT INTO Actions (Cle_Utilisateurs, Cle_Types, Cle_Instants) VALUES (:user_id, :type_id, :instant_id)";
            $params = [
                "user_id" => $user_cle,
                "type_id" => $action_type['Id'],
                "instant_id" => $instant_id['Id']
            ];
            $res = $this->post_request($request, $params);

        } catch (Exception $e) {
            $Error = new ErrorView();
            $Error->getErrorContent($e);
        }
    }


    // METHODES DE MANIPULATIONS ES UTILISATEURS //

    protected function searchUser($identifiant, $motdepasse): ?Utilisateurs{
        // On récupère les Utilisateurs
        $request = "SELECT * FROM Utilisateurs WHERE Nom_Utilisateurs = :nom";
        $params = [":nom" => $identifiant];
        $users = $this->get_request($request, $params, false, true);

        // On déclare les variables tampons
        $i = 0;
        $size = $users != null ? count($users) : 0;    
        $find = false;  

        // On fait défiler la table
        while($i < $size && !$find) {
            if($users[$i]["Nom_Utilisateurs"] == $identifiant && password_verify($motdepasse, $users[$i]["MotDePasse_Utilisateurs"])) {
                // On implémente find
                $find = true;

                // On récupère le rôle de l'utilisateur 
                $role = $this->searchRole($users[$i]["Cle_Roles"]);
                try {
                    // On construit notre Utilisateur
                    $user = new Utilisateurs($identifiant, $users[$i]['Email_Utilisateurs'], $motdepasse, $role['Intitule_Role']);
                    $user->setcle($users[$i]['Id_Utilisateurs']);
                    $user->setRole_id($users[$i]['Cle_Roles']);

                // On récupère les éventuelles erreurs 
                } catch(InvalideUtilisateurExceptions $e) {
                    // echo "<script>alerte(\"" . $e->getMessage() . "\");</script>";
                    $Error = new ErrorView();
                    $Error->getErrorContent($e);
                }

                // On retourne notre utilisateur, la connexion est validée
                return $user;
            } 
            // On implémnte l'index
            $i++;
        }
        // Utilisateur introuvé, on signale l'erreur
        if($i == $size) 
            throw new Exception("Aucun utilisateur correspondant");
    }
    protected function searchCle($user): ?int {
        // On initialise la requête
        $request = "SELECT Id_Utilisateurs FROM Utilisateurs WHERE Nom_Utilisateurs = :nom AND Email_Utilisateurs = :email AND Cle_Roles = :id_Roles";
        $params = [
            'nom' => $user->getIdentifiant(),
            'email' => $user->getEmail(),
            'id_Roles' => $this->searchRole($user->getRole())
        ];

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    protected function searchRole($role_id): array {
        // On initialise la requête
        if(is_numeric($role_id)) {
            $request = "SELECT * FROM roles WHERE Id_Role = :Id";
            $params = ["Id" => $role_id];

        } elseif(is_string($role_id)) {
            $request = "SELECT * FROM roles WHERE Intitule_Role = :Intitule";
            $params = ["Intitule" => $role_id];
        } else 
        throw new Exception("La saisie du rôle est mal typée. Le rôle doit être un identifiant (entier positif) ou un echaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
}