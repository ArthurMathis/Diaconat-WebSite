<?php

class Connexion {
    /// Attribut privé contenant la connexion à la base de données
    private $connection;

    public function __construct() {
        $this->makeConnection();
    }

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

            echo "<script>console.log(\"Connexion à " . $db_fetch . "réussie !\");</script>";
        }
        catch(PDOException $Exception) {
            echo $Exception->getMessage();
        }
        return $this->connection;
    }

    protected function getConnection() {
        return $this->connection;
    }
}