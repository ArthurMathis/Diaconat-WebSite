<?php 

abstract class Model {
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
            
        } catch(PDOException $e) {
            forms_manip::error_alert($e->getMessage());
            // $Error = new ErrorView();
            // $Error->getErrorContent($e);
        }
        return $this->connection;
    }

    protected function getConnection() {
        return $this->connection;
    }


    // METHODES DE REQUETES A LA BASE DE DONNEES //
    
    /// Méthode privée permettant de vérifier les paramètres fournis au fonction de requêtes
    private function test_data_request($request, $params): bool {
        // On déclare une variable tampon
        $res = false;
    
        // On vérifie l'intégrité des paramètres
        if(empty($request) || !is_string($request)) 
            throw new Exception("La requête doit être passée en paramètre !");
        elseif(!is_array($params))
            throw new Exception("Les données de la requête doivent être passsée en paramètre !");
    
        // On retourne le résultat
        else $res = true;
        return $res;
    }
    /// Méthode privée exécutant une requête GET à la base de données
    protected function get_request($request, $params = [], $unique=false, $present=false): ?array {
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

            if(empty($result)) {
                if($present) 
                    throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
                
                else return null;
                    
            } else
                // On retourne le résultat de la requête 
                return $result;
    
        } catch(Exception $e){
            forms_manip::error_alert($e->getMessage());
            // $Error = new ErrorView();
            // $Error->getErrorContent($e);
            // exit;
        } catch(PDOException $e){
            forms_manip::error_alert($e->getMessage());
            // $Error = new ErrorView();
            // $Error->getErrorContent($e);
            // exit;
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
            forms_manip::error_alert($e->getMessage());
            // $Error = new ErrorView();
            // $Error->getErrorContent($e);
            // exit;
        } 
    
        // On retourne le résultat
        return $res;
    }


    // Geston des instants
    protected function inscriptInstants($jour=null, $heure=null) {
        if(empty($jour) && empty($heure))
            // On génère l'instant actuel (date et heure actuelles)
            $instant = Instants::currentInstants();
            
        // On génère un instant    
        else $instant = new Instants($jour, $heure);

        // J'enregistre mon instant dans la base de données
        $request = "INSERT INTO Instants (Jour_Instants, Heure_Instants) VALUES (:jour, :heure)";
        $params = $instant->exportToSQL();
        $this->post_request($request, $params);

        // On récupère l'id de mon instant 
        $request = "SELECT Id_Instants FROM Instants WHERE Jour_Instants = :jour AND Heure_Instants = :heure";
        $instant_id = $this->get_request($request, $params, true, true);

        return $instant_id;
    }
}