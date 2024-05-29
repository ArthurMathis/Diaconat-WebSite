<?php 

require_once MODELS.DS.'Utilisateurs.php';

class Login {
    /// Attribut privé contenant la connexion à la base de données
    private $connection;

    /// Constructeur de la classe
    public function __construct() {
        $this->makeConnection();
    }

    /// Méthode protégée connectant l'application à la base de données
    protected function makeConnection() {
        try {
            $db_connection  = getenv('DB_CONNEXION');
            $db_host        = getenv('DB_HOST');
            $db_port        = getenv('DB_PORT');
            $db_name        = getenv('DB_NAME');
            $db_user        = getenv('DB_USER');
            $db_password    = getenv('DB_PASS');
    
            // Supprimez le slash dans la valeur de DB_HOST
            $db_host = str_replace('/', '', $db_host);
    
            $db_fetch = "$db_connection:host=$db_host;port=$db_port;dbname=$db_name";

            $this->connection = new PDO($db_fetch, $db_user, $db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "<script>console.log(\"Connexion à " . $db_fetch . " réussie !\");</script>";
            
        } catch(PDOException $Exception) {
            echo $Exception->getMessage();
        }
        return $this->connection;
    }

    protected function getConnection() {
        return $this->connection;
    }



    public function connectUser($identifiant, $motdepasse) {
        // On cherche l'utilisateur dans la base de données
        $user = $this->searchUser($identifiant, $motdepasse);
        
        // On récupère les données de l'utilisateur
        $_SESSION['user_cle']           = $user->getCle();
        $_SESSION['user_identifiant']   = $user->getIdentifiant();
        $_SESSION['user_email']         = $user->getEmail();
        $_SESSION['user_motdepasse']    = $user->getMotdepasse();
        $_SESSION['user_role']          = $user->getRole();
        $_SESSIon['user_role_id']       = $user->getRole_id();
    }
    public function inscriptUser($identifiant, $email, $motdepasse) {
        // On récupère le rôle invité pour l'asigner à l'utilisateur
        $role = $this->searchRole('Invite');        

        // On crée l'utilisateur
        $user = new Utilisateurs($identifiant, $email, $motdepasse, $role['Intitule']);

        // On prépare la requête SQL
        $request = "INSERT INTO utilisateurs (nom, email, motdepasse, id_Roles)  VALUES (:nom, :email, :motdepasse, :id_Roles)";
        $params = [
            'nom' => $user->getIdentifiant(),
            'email' => $user->getEmail(),
            'motdepasse' => password_hash($user->getMotdepasse(), PASSWORD_DEFAULT),
            'id_Roles' => $role['Id']
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



    // METHODES DE MANIPULATIONS ES UTILISATEURS //

    protected function searchUser($identifiant, $motdepasse) {
        // On récupère les Utilisateurs
        $request = "SELECT * FROM Utilisateurs WHERE Nom = :nom";
        $params = [":nom" => $identifiant];
        $users = $this->get_request($request, $params, false, true);

        // On déclare les variables tampons
        $i = 0;
        $size = $users != null ? count($users) : 0;    
        $find = false;  

        // On fait défiler la table
        while($i < $size && !$find) {
            if($users[$i]["Nom"] == $identifiant && password_verify($motdepasse, $users[$i]["MotDePasse"])) {
                // On implémente find
                $find = true;

                // On récupère le rôle de l'utilisateur 
                $role = $this->searchRole($users[$i]["Id_Roles"]);
                try {
                    // On construit notre Utilisateur
                    $user = new Utilisateurs($identifiant, $users[$i]['Email'], $motdepasse, $role['Intitule']);
                    $user->setcle($users[$i]['Id']);
                    $user->setRole_id($users[$i]['Id_Roles']);

                // On récupère les éventuelles erreurs 
                } catch(InvalideUtilisateurExceptions $e) {
                    echo "<script>alerte(\"" . $e->getMessage() . "\");</script>";
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
    protected function searchCle($user) {
        // On initialise la requête
        $request = "SELECT Id FROM Utilisateurs WHERE Nom = :nom AND Email = :email AND Id_Roles = :id_Roles";
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
            $request = "SELECT * FROM roles WHERE Id = :Id";
            $params = ["Id" => $role_id];

        } elseif(is_string($role_id)) {
            $sql = "SELECT * FROM roles WHERE Intitule = :Intitule";
            $data = ["Intitule" => $role_id];
        } else 
        throw new Exception("La saisie du rôle est mal typée. Le rôle doit être un identifiant (entier positif) ou un echaine de caractères !");

        echo "<script>console.log(\"" . $sql . "\");</script>";
        echo "<script>console.log(\"" . $data['Intitule'] . "\");</script>";

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }

    //  protected function searchRole($bdd, $role): array {
    //      // On initialise la requête
    //      if(is_numeric($role)) {
    //          $sql = "SELECT * FROM roles WHERE Id = :Id";
    //          $data = ["Id" => $role];
    //  
    //     } elseif(is_string($role)) {
    //         $sql = "SELECT * FROM roles WHERE Intitule = :Intitule";
    //         $data = ["Intitule" => $role];
    //  
    //      } else 
    //          throw new Exception("La saisie du rôle est mal typée. Le rôle doit être un identifiant (entier positif) ou un echaine de caractères !");
    //  
    //      echo "<script>console.log(\"" . $sql . "\");</script>";
    //      echo "<script>console.log(\"" . $data['Intitule'] . "\");</script>";
    //  
    //      // On lance la requête
    //      $result = get_request($bdd, $sql, $data, true, true);
    //  
    //      // On retourne le rôle
    //      return $result;
    //  }
    // public function searchRole_id($bdd) {
    //     $role = Utilisateurs::searchRole($bdd, $this->getRole());
    //     return $role['Id'];
    // }
    // public function searchCle($bdd) {
    //     // On initialise la requête
    //     $sql = "SELECT * FROM Utilisateurs WHERE Nom = :nom AND Email = :email AND Id_Roles = :id_Roles";
    //     $params = [
    //         'nom' => $this->getIdentifiant(),
    //         'email' => $this->getEmail(),
    //         'id_Roles' => $this->searchRole_id($bdd)
    //     ];
    // 
    //     // On lance la requête
    //     $user = get_request($bdd, $sql, $params, true, true);
    // 
    //     // On implémente
    //     $this->setCle($user["Id"]);
    // }



    // METHODES DE REQUETES A LA BASE DE DONNEES //
    
    /// Méthode privée permettant de vérifier les paramètres fournis au fonction de requêtes
    private function test_data_request($sql, $data): bool {
        // On déclare une variable tampon
        $res = false;
    
        // On vérifie l'intégrité des paramètres
        if(empty($sql) || !is_string($sql)) 
            throw new Exception("La requête doit être passée en paramètre !");
        elseif(empty($data) || !is_array($data)) 
            throw new Exception("Les données de la requête doivent être passsée en paramètre !");
    
        // On retourne le résultat
        else $res = true;
        return $res;
    }
    /// Méthode privée exécutant une requête GET à la base de données
    protected function get_request($request, $params, $unique=false, $present=false): ?array {
        // On vérifie le paramètre uniquue
        if(empty($unique) || !is_bool($unique)) 
            $unique = false;
        // On vérifie le paramètre uniquue
        if(empty($present) || !is_bool($present)) 
            $present = false;
    
        // On vérifie l'intégrité des paramètres
        if($this->test_data_request($request, $params)) try {
            // On prépare la requête
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);
    
            // On récupère le résultat de la requête
            if($unique) 
                $result = $query->fetch(PDO::FETCH_ASSOC);
            else 
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            if($present && empty($result)) 
                throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
            
            // On retourne le résultat de la requête 
            return $result;
    
        } catch(Exception $e){
            echo "<script>alerte(\"" . $e->getMessage() . "\");</script>";
        } catch(PDOException $e){
            echo "<script>alerte(\"" . $e->getMessage() . "\");</script>";
        } 

        return null;
    }
    /// Méthode privée exécutant une requête POST à la base de données
    protected function post_request($request, $params): bool {
        // On déclare une variable tampon
        $res = true;
    
        // On vérifie l'intégrité des paramètres
        if(!$this->test_data_request($request, $params)) 
            $res = false;
    
        else try {
            // On prépare la requête
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);
    
        // On vérifie qu'il n'y a pas eu d'erreur lors de l'éxécution de la requête    
        } catch(PDOException $e){
            echo "<script>alerte(\"" . $e->getMessage() . "\");</script>";
            // $_SESSION['erreur'] = $e;
            // // On redirige la page
            // header("Location: ../view/erreur.php");
            // exit;
        } 
    
        // On retourne le résultat
        return $res;
    }
}