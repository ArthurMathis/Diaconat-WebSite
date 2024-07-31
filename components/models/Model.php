<?php 

/**
 * Abstract class representing a model
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
abstract class Model {
    /**
     * Private attribute containing the database connection
     */
    private $connection;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->makeConnection();
    }

    /**
     * Protected method connecting the application to the database
     */
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
            die("Connexion à la base de données réchouée. " . $e->getMessage());
        }
        return $this->connection;
    }
    /**
     * Protected method returning the database connection
     */
    protected function getConnection() { return $this->connection; }
    /**
     * Protected method recording application logs
     *
     * @param integer $user_cle The user identification key in the database
     * @param string $action The action title
     * @param string optionnal $description The action description 
     * @return void
     */
    protected function writeLogs(&$user_cle, $action, $description=null) {
        try {
            // On récupère le type d'action
            $action_type = $this->serachAction_type($action);

            // On génère l'instant actuel (date et heure actuelles)
            $instant_id = $this->inscriptInstants();

            // On ajoute l'action à la base de données
            $this->inscriptAction($user_cle, $action_type['Id_Types'], $instant_id['Id_Instants'], $description);

        } catch (Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'enregistrement des logs",
                'msg' => $e
            ]);
        }
    }


    // METHODES DE REQUETES A LA BASE DE DONNEES //
    

    /**
     * Private method checking the request parameters
     *
     * @param string $request The SQL request
     * @param array<string> $params The request data array
     * @return boolean TRUE if the request executed successfully, FALSE otherwise
     */
    private function test_data_request(&$request, &$params=[]): bool {
        // On vérifie l'intégrité des données
        try {

        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => 'Les données de la requête à la base de données sont erronnées. ' . $e->getMessage()
            ]);
        }
        // On vérifie l'intégrité des paramètres
        if(empty($request) || !is_string($request)) 
            throw new Exception("La requête doit être passée en paramètre !");
        elseif(!is_array($params))
            throw new Exception("Les données de la requête doivent être passsée en paramètre !");
    
        // Aucune alerte, on valide les données    
        return true;
    }
    /**
     * Private method executing a GET request to the database
     *
     * @param string $request The SQL request
     * @param array<string> $params The request data parameters
     * @param boolean $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param boolean $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @return array|null
     */
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

            // On retourne le résultat de la requête         
            } else 
                return $result;
    
        } catch(Exception $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 

        return null;
    }
    /**
     * Private method executing a POST request to the database
     *
     * @param string  $request The SQL request
     * @param array<string>  $params The request data array
     * @return boolean
     */
    protected function post_request(&$request, $params): bool {
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
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 
    
        // On retourne le résultat
        return $res;
    }


    /**
     * Public method returning the users list to autocomplete items
     *
     * @return void
     */
    public function getAutoCompletUtilisateurs() {
        // On initialise la requête
        $request = "SELECT Identifiant_Utilisateurs FROM Utilisateurs ORDER BY Identifiant_Utilisateurs";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return void
     */
    public function getAutoCompletEtablissements() {
        // On initialise la requête
        $request = "SELECT Intitule_Etablissements FROM Etablissements ORDER BY Intitule_Etablissements";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the candidate who have a job in the foundation list to autocomplete items
     *
     * @return void
     */
    public function getAutoCompletEmployer() {
        // On initialise la requête
        $request = "SELECT 
        CONCAT(c.Nom_Candidats, ' ', c.Prenom_Candidats) AS text
        FROM Candidats AS c
        INNER JOIN Contrats AS con ON c.Id_Candidats = con.Cle_Candidats
        WHERE con.Date_signature_Contrats IS NOT NULL
        AND (con.Date_fin_Contrats IS NULL OR con.Date_fin_Contrats > CURDATE())";
    
        // On lance la requête
        return $this->get_request($request, []);
    }
    /**
     * Public method returning the assistants list to autocomplete items
     *
     * @return void
     */
    public function getAides() {
        // On inititalise la requête
        $request = "SELECT 
        Id_Aides_au_recrutement AS id,
        Intitule_Aides_au_recrutement AS text

        FROM aides_au_recrutement";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return void
     */
    public function getDiplomes() {
        // On initialise la requête
        $request = "SELECT
        Intitule_Diplomes AS text
        
        FROM Diplomes";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the job lost to the autocomplete items
     *
     * @return void
     */
    public function getAutoCompPostes() {
        // On inititalise la requête
        $request = "SELECT Intitule_Postes FROM Postes ORDER BY Intitule_Postes";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the services list to the autocomplete items
     *
     * @return void
     */
    public function getAutoCompServices() {
        // On inititalise la requête
        $request = "SELECT Intitule_Services FROM Services ORDER BY Intitule_Services";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the types of contracts list to the autocomplete items
     *
     * @return void
     */
    public function getAutoCompTypesContrat() {
        // On initialise la requête
        $request = "SELECT Intitule_Types_de_contrats FROM Types_de_contrats ORDER BY Intitule_Types_de_contrats";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the sources list to the autocomplete items
     *
     * @return void
     */
    public function getAutoCompSources() {
        // On initialise la requête
        $request = "SELECT Intitule_Sources FROM Sources ORDER BY Intitule_Sources";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the role liste without the owner
     *
     * @return void
     */
    public function getAccessibleRole() {
        // ON initialise la requête
        $request = "SELECT 
        Id_Role AS id,
        Intitule_Role AS text

        FROM Roles
        
        WHERE Id_Role != :cle";
        $params = ['cle' => $this->searchRole('Propriétaire')['Id_Role']];

        // On lance la requête
        return $this->get_request($request, $params);
    }



    // METHODES DE RECHERCHE DANS LA BASE DE DONNEES //

    /**
     * Public method searching one Instant in the database
     *
     * @param integer $cle_instant The Instant's primary key 
     * @return array
     */
    protected function searchInstant($cle_instant): array {
        // On initialise la requête
        $request = "SELECT * FROM Instants WHERE Id_Instants = :cle";
        $params = ['cle' => $cle_instant];

        // On récupère le résultat
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one establishment 
     *
     * @param integer|string $etablissement The establishment primary key or intitule 
     * @return array
     */
    protected function searchEtablissement($etablissement): array {
        if(is_numeric($etablissement)) 
            // On initialise la requête
            $request = "SELECT * FROM Etablissements WHERE Id_Etablissements = :etablissement";
        
         elseif(is_string($etablissement)) 
            // On initialise la requête
            $request = "SELECT * FROM Etablissements WHERE Intitule_Etablissements = :etablissement";

        // On prépare les paramètres de la requête
        $params = [
            'etablissement' => $etablissement
        ];
        
        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one hub in the database
     *
     * @param integer|string $pole The hub primary key or intitule
     * @return array
     */
    protected function searchPole($pole): array {
        if(is_numeric($pole)) {
            $request = "SELECT * FROM Poles WHERE Id_Poles = :cle";
            $params = [
                'cle' => $pole
            ];
        
        } elseif(is_string($pole)) {
            $request = "SELECT * FROM Poles WHERE Intitule_Poles = :intitule";
            $params = [
                'intitule' => $pole
            ];
            
        } else 
            throw new Exception("paramètre invalide");

        return $this->get_request($request, $params, true, true);    
    }
    /**
     * Protected method searching one role in the database
     *
     * @param integer|string $role The role primary key or intitule
     * @return array
     */
    protected function searchRole($role): array {
        // On initialise la requête
        if(is_numeric($role)) {
            $request = "SELECT * FROM roles WHERE Id_Role = :Id";
            $params = ["Id" => $role];

        } elseif(is_string($role)) {
            $request = "SELECT * FROM roles WHERE Intitule_Role = :Intitule";
            $params = ["Intitule" => $role];

        } else 
            throw new Exception("La saisie du rôle est mal typée. Le rôle doit être un identifiant (entier positif) ou une chaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    /**
     * Protected method searching one action type in the database
     *
     * @param integer|string $action The type primary key or intitule
     * @return array
     */
    protected function serachAction_type($action): array {
        if($action == null) 
            throw new Exception("Données éronnées. La clé action ou son intitulé sont nécessaires pour rechercher une action !");

        elseif(is_int($action)) 
            $request = "SELECT * FROM types WHERE Id_Types = :action";

        elseif(is_string($action))
            $request = "SELECT * FROM types WHERE Intitule_Types = :action";

        else 
            throw new Exception('Type invlide. La clé action (int) ou son intitulé (string) sont nécessaires pour rechercher une action !');   

        $params = [ "action" => $action ];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method search one user in the database
     *
     * @param integer|string $user The user primary key or intitule
     * @return array
     */ 
    protected function searchUser($user): array {
        if($user == null)
            throw new Exception("Le nom ou l'identifiant de l'utilisateur sont nécessaires pour le rechercher dans la base de données !");

        // On recherche l'Utilisateur via sont identifiant    
        elseif(is_numeric($user)) {
            // On initialise la requêre
            $request = "SELECT * FROM Utilisateurs WHERE Id_Utilisateurs = :user";
            $params = [
                'user' => $user
            ];
    
            // On lance la requête
            return $this->get_request($request, $params, true, true);

        // On recherche l'utilisateur via son nom      
        } elseif(is_string($user)) {
            // On initialise la requête 
            $request = "SELECT * FROM Utilisateurs WHERE Nom_Utilisateurs = :user";
            $params = [
                'user' => $user
            ];

            // On lance la requête
            return $this->get_request($request, $params, false, true);

        // Sinon    
        } else 
            throw new Exception("Le type n'a pas pu être reconnu. Le nom (string) ou l'identifiant (int) de l'utilisateur sont nécessaires pour le rechercher dans la base de données !");
    }
    /**
     * Protected method searching one user according to his name
     *
     * @param string $user The user name
     * @return array
     */
    protected function searchUserFromUsername($user): array {
        if(empty($user) || !is_string($user))
            throw new Exception("Erreur lors de la récupération du nom d'utilisateur");

        // On initialise la requête 
        $request = "SELECT * FROM Utilisateurs WHERE Identifiant_Utilisateurs = :user";
        $params = [
            'user' => $user
        ];

        // On lance la requête
        return $this->get_request($request, $params, false, true);
    }
    /**
     * Protected method searching one application in the database
     *
     * @param integer $application The application primary key
     * @return array
     */
    protected function searchCandidature($application): array {
        // On initialise la requête
        $request = "SELECT * FROM Candidatures WHERE Id_candidatures = :cle";
        $params = ['cle' => $application];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /// Méthode publique recherchant un candidat dans la base de données depuis une de ses candidatures
    /**
     * Public method searching one candidate from one of his application in the database
     *
     * @param integer $cle The application primary key
     * @return array
     */
    public function searchCandidatFromCandidature($cle): array {
        // On initialise la requête
        $request = "SELECT * 
        FROM Candidatures 
        INNER JOIN Candidats ON Candidatures.Cle_Candidats = Candidats.Id_Candidats
        WHERE Candidatures.Id_Candidatures = :cle";
        $params = [
            'cle' => $cle
        ];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }

    /**
     * Public method searching one candidate from one of his contract in the database
     *
     * @param integer $cle The contract primary key
     * @return array
     */
    public function searchcandidatFromContrat($cle): array {
        // On initialise la requête
        $request = "SELECT * 
        FROM Contrats 
        INNER JOIN Candidats ON Contrats.Cle_Candidats = Candidats.Id_Candidats
        WHERE Contrats.Id_Contrats = :cle";
        $params = [
            'cle' => $cle
        ];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one application from his candidate in the database
     *
     * @param integer $cle_candidat The candidate primary key
     * @param integer $cle_instant The instant primary key
     * @return array
     */
    protected function searchCandidatureFromCandidat($cle_candidat, $cle_instant): array {
        // On vérifie l'intégrité des données
        if(empty($cle_candidat) || empty($cle_instant)) 
            throw new Exception ('Données éronnées. Pour rechercher une candidatures, lla clé candidat et la clé instant sont nécessaires !');
        
        // On initialise la requête
        $request = "SELECT * FROM candidatures WHERE Cle_Candidats = :candidat AND Cle_Instants = :instant";    
        $params = [
            "candidat" => $cle_candidat,
            "instant" => $cle_instant
        ];

        // On retourne le résultat
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one degree in the database 
     *
     * @param integer|string $diplome The degree primary key or intitule
     * @return array
     */
    protected function searchDiplome($diplome): array {
        // Si diplome est un ID
        if(is_numeric($diplome)) {
            // On initialise la requête
            $request = "SELECT * FROM diplomes WHERE Id_Diplomes = :id";
            $params = ["id" => $diplome];

            // On lance la requête
            $result = $this->get_request($request, $params, true, true);

        // SI diplome est un intitule    
        } elseif(is_string($diplome)) {
            // On initialise la requête 
            $request = "SELECT * FROM diplomes WHERE Intitule_Diplomes = :intitule";
            $params = ["intitule" => $diplome];

            // On lance la requête
            $result = $this->get_request($request, $params, true);

        // En cas d'erreur de typage
        } else 
            throw new Exception("La saisie du diplome est mal typée. Il doit être un identifiant (entier positif) ou un echaine de caractères !");        
           
        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method searching one type of contracts in the database 
     *
     * @param integer|string $contrat The types of contracts primary key or intitule
     * @return array
     */
    protected function searchTypeContrat($contrat): array {
        // Si contrat est un ID
        if(is_numeric($contrat)) {
            // On initialise la requête
            $request = "SELECT * FROM Types_de_contrats WHERE Id_Types_de_contrats = :id";
            $params = ['id' => $contrat];

        // Si contrat est un intitulé    
        } elseif(is_string($contrat)) {
            // On initialise la requête
            $request =  "SELECT * FROM Types_de_contrats WHERE Intitule_Types_de_contrats = :intitule";
            $params = ['intitule' => $contrat];

        } else 
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
        
        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method one source in the database
     *
     * @param integer|string $source The source primary key or intitule
     * @return array
     */
    protected function searchSource($source): array {
        // On initialise la requête
        if(is_numeric($source)) {
            $request = "SELECT * FROM sources WHERE Id_Sources = :Id";
            $params = ["Id" => $source];

        } elseif(is_string($source)) {
            $request = "SELECT * FROM sources WHERE Intitule_Sources = :Intitule";
            $params = ["Intitule" => $source];
        } else 
            throw new Exception("La saisie de la source est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    /**
     * Protected method searching one job in the database
     *
     * @param integer|string $job The job primary key or intitule
     * @return array
     */
    protected function searchPoste($job): array {
        // On initialise la requête
        if(is_numeric($job)) {
            $request = "SELECT * FROM Postes WHERE Id_Postes = :Id";
            $params = ["Id" => $job];
            
        } elseif(is_string($job)) {
            $request = "SELECT * FROM Postes WHERE Intitule_Postes = :Intitule";
            $params = ["Intitule" => $job];
        } else 
            throw new Exception("Erreur lors de la recherche de poste. La saisie du poste est mal typée. Il doit être un identifiant (entier positif) ou une chaine de caractères !");

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one service in the database
     *
     * @param integer|string $service The service primary key or intitule
     * @return array
     */
    protected function searchService($service): array {
        // Si contrat est un ID
        if(is_numeric($service)) {
            // On initialise la requête
            $request = "SELECT * FROM Services WHERE Id_Services = :id";
            $params = ['id' => $service];

        // Si contrat est un intitulé    
        } elseif(is_string($service)) {
            // On initialise la requête
            $request =  "SELECT * FROM Services WHERE Intitule_Services = :intitule";
            $params = ['intitule' => $service];

        } else 
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
        
        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method searching one assistance in the database
     *
     * @param integer|string $aide The assistance primary key or intitule
     * @return array
     */
    protected function searchAide($aide): array {
        // Si aide est un ID
        if(is_numeric($aide)) {
            // On initialise la requête
            $request = "SELECT * FROM Aides_au_recrutement WHERE Id_Aides_au_recrutement = :id";
            $params = ["id" => $aide];

            // On lance la requête
            $result = $this->get_request($request, $params, true, true);
        
        // Si aide est un intitule    
        } elseif(is_string($aide)) {
            // On intitialise la requête
            $request = "SELECT * FROM Aides_au_recrutement WHERE Intitule_Aide_au_recrutement = :intitule";
            $params = ["intitule" => $aide];

            // On lance la requête
            $result = $this->get_request($request, $params, true);

        } else 
            new Exception("La saisie de l'aide est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");        

        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method searching one Appliquer_a from its application
     *
     * @param integer $cle The application primary key
     * @return array
     */
    protected function searchAppliquer_aFromCandidature($cle): array {
        // On initialise la requête
        $request = "SELECT * FROM Appliquer_a WHERE Cle_Candidatures = :cle";
        $params = ['cle' => $cle];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one Appliquer_a from its service
     *
     * @param integer $cle the service primary key
     * @return array
     */
    protected function searchAppliquer_aFromService($cle): array {
        // On initialise la requête
        $request = "SELECT * FROM Appliquer_a WHERE Cle_Services = :cle";
        $params = ['cle' => $cle];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one contract in the database
     *
     * @param integer $cle_contrat The contract primary key
     * @return array
     */
    protected function searchContrat(&$cle_contrat): array {
        if(empty($cle_contrat) || !is_numeric($cle_contrat))
            throw new Exception('Erreur lors de la recherche du contrat. La clé contrat doit être un nombre entier positif !');

        // On initialise la requête
        $request  = "SELECT * FROM Contrats WHERE Id_Contrats = :cle";
        $params = ['cle' => $cle_contrat];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    


    // METHODES D'INSCRIPTION DANS LA BASE DE DONNEES //

    /**
     * Protected method registering and returning one Instant in the database
     *
     * @param string $jour The instant day
     * @param string $heure The instant hour
     * @return array
     */
    protected function inscriptInstants($jour=null, $heure=null): array {
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
        $request = "SELECT * FROM Instants WHERE Jour_Instants = :jour AND Heure_Instants = :heure";

        return $this->get_request($request, $params, true, true);
    }
    /**
     * protected method registering one user in the database
     *
     * @param array $user The user's data array
     * @return void
     */
    protected function inscriptUtilisateurs($user=[]) {
        if(empty($user)) 
            throw new Exception("Impossible d'inscrire un Utilisateur. Données manquantes !");

        else {
            // On initialise la requête
            $request = "INSERT INTO utilisateurs (identifiant_utilisateurs, nom_utilisateurs, prenom_utilisateurs, email_utilisateurs, motdepasse_utilisateurs, Cle_Etablissements, Cle_Roles)
                        VALUES (:identifiant, :nom, :prenom, :email, :motdepasse, :cle_etablissement, :cle_role)";

            // On lance la requête
            $this->post_request($request, $user);
        }
    }
    /**
     * Protected method registering one action in the database
     *
     * @param integer $cle_user The user's primary key
     * @param integer $cle_action The action primary key
     * @param integer $cle_instant The instant primary key
     * @param string $description The action description
     * @return void
     */
    protected function inscriptAction(&$cle_user, &$cle_action, &$cle_instant, $description=null) {
        // On vérifie l'intégrité des données
        try {
            if(empty($cle_user) || !is_int($cle_user))
                throw new Exception("La clé Utilisateur est nécessaire pour l'enregistrement d'une action !");
            elseif(empty($cle_action) || !is_int($cle_action))
                throw new Exception("La clé Action est nécessaire pour l'enregistrement d'une action !");
            elseif(empty($cle_instant) || !is_int($cle_instant))
                throw new Exception("La clé Action est nécessaire pour l'enregistrement d'une action !");

        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        
        // Sans description
        if(!empty($description)) {
            // On ajoute l'action à la base de données
            $request = "INSERT INTO Actions (Cle_Utilisateurs, Cle_Types, Cle_Instants, Description_Actions) VALUES (:user_id, :type_id, :instant_id, :description)";
            $params = [
                "user_id" => $cle_user,
                "type_id" => $cle_action,
                "instant_id" => $cle_instant,
                'description' => $description
            ];

        // Avec description    
        } else {
            // On ajoute l'action à la base de données
            $request = "INSERT INTO Actions (Cle_Utilisateurs, Cle_Types, Cle_Instants) VALUES (:user_id, :type_id, :instant_id)";
            $params = [
                "user_id" => $cle_user,
                "type_id" => $cle_action,
                "instant_id" => $cle_instant
            ];   
        }

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one candidate ine the database
     *
     * @param Candidat $candidat The candidate's data 
     * @return void
     */
    protected function inscriptCandidat(&$candidat) {
        // On initialise la requête
        if($candidat->getVisite_medicale()) 
            $request = "INSERT INTO Candidats (Nom_Candidats, Prenom_Candidats, Telephone_Candidats, Email_Candidats, 
                Adresse_Candidats, Ville_Candidats, CodePostal_Candidats, Disponibilite_Candidats, VisiteMedicale_Candidats)
                VALUES (:nom, :prenom, :telephone, :email, :adresse, :ville, :code_postal, :disponibilite, :visite)";

        else 
            $request = "INSERT INTO Candidats (Nom_Candidats, Prenom_Candidats, Telephone_Candidats, Email_Candidats, 
                Adresse_Candidats, Ville_Candidats, CodePostal_Candidats, Disponibilite_Candidats)
                VALUES (:nom, :prenom, :telephone, :email, :adresse, :ville, :code_postal, :disponibilite)";

        // On lance  requête
        $this->post_request($request, $candidat->exportToSQL());
    }
    /**
     * Protected method registering one Obtenir in the database
     *
     * @param integer $cle_candidat The candidate's primary key
     * @param integer $cle_diplome The degree primary key
     * @return void
     */
    protected function inscriptObtenir($cle_candidat, $cle_diplome) {
        // On initialise la requête
        $request = "INSERT INTO obtenir (Cle_Candidats, Cle_Diplomes) VALUES (:candidat, :diplome)";
        $params = [
            "candidat" => $cle_candidat, 
            "diplome" => $cle_diplome
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method regstering one Postuler_a in the database
     *
     * @param integer $candidat The candidate's primary key
     * @param integer $instant The instant primary key
     * @return void
     */
    protected function inscriptPostuler_a($candidat, $instant) {
        // On initialise la requête 
        $request = "INSERT INTO Postuler_a (Cle_Candidats, Cle_Instants) VALUES (:candidat, :instant)";
        $params = [
            "candidat" => $candidat, 
            "instant" => $instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one Appliquer_a ine the database
     *
     * @param integer $cle_candidature The application primary key
     * @param integer $cle_service The service primary key
     * @return void
     */
    protected function inscriptAppliquer_a($cle_candidature, $cle_service) {
        // On vérifie l'intégrité des données
        try {
            if(empty($cle_candidature) || empty($cle_service)) 
                throw new Exception('Données éronnées. Pour inscrire un Appliquer_a, la clé de candidature et la clé de service sont nécessaires');

        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        
        // On inititalise la requête
        $request = "INSERT INTO Appliquer_a (Cle_Candidatures, Cle_Services) VALUES (:candidature, :service)";
        $params = [
            "candidature" => $cle_candidature,
            "service" => $cle_service
        ];

        // On exécute la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one Avoir_droit_a in the database
     *
     * @param integer $cle_candidat The candidate's primary key
     * @param integer $cle_aide The assistance primary key
     * @param integer $cle_coopteur The recommander's primary key
     * @return void
     */
    protected function inscriptAvoir_droit_a($cle_candidat, $cle_aide, $cle_coopteur=null) {
        if(!empty($cle_coopteur)) {
            // On initialise la requête
            $request = "INSERT INTO Avoir_droit_a (Cle_Candidats, Cle_Aides_au_recrutement, Cle_Coopteur) VALUES (:candidat, :aide, :coopteur)";
            $params = [
                'candidat' => $cle_candidat,
                'aide' => $cle_aide,
                'coopteur' => $cle_coopteur
            ];

        } else {
            // On initialise la requête
            $request = "INSERT INTO Avoir_droit_a (Cle_Candidats, Cle_Aides_au_recrutement) VALUES (:candidat, :aide)";
            $params = [
                'candidat' => $cle_candidat,
                'aide' => $cle_aide
            ];
        }
        
        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registerin one Proposer_a in the database
     *
     * @param integer $cle_candidat The candidate's primary key
     * @param integer $cle_instant The instant primary key
     * @return void
     */
    protected function inscriptProposer_a($cle_candidat, $cle_instant) {
        // On initialise la requête
        $request = "INSERT INTO Proposer_a (Cle_candidats, Cle_Instants) VALUES (:candidat, :instant)";
        $params = [
            'candidat' => $cle_candidat,
            'instant' => $cle_instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one mission in the database
     *
     * @param integer $cle_service The sevice primary key
     * @param integer $cle_poste The job primary key
     * @return void
     */
    protected function inscriptMission($cle_service, $cle_poste) {
        // On intitialise la requête 
        $request = "INSERT INTO Missions (Cle_Services, Cle_Postes) VALUES (:cle_service, :cle_poste)";
        $params = [
            "cle_service" => $cle_service,
            "cle_poste" => $cle_poste
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one meeting in the database 
     *
     * @param integer $cle_utilisateur The user's primary key (recruiter) 
     * @param integer $cle_candidat The candidate's primary key
     * @param integer $cle_etablissement The establishment primary key
     * @param integer $cle_instants The instant primary key
     * @return void
     */
    protected function inscriptAvoir_rendez_vous_avec($cle_utilisateur, $cle_candidat, $cle_etablissement, $cle_instants) {
        // On intitialise la requête 
        $request = "INSERT INTO Avoir_rendez_vous_avec (Cle_Utilisateurs, Cle_Candidats, Cle_Etablissements, Cle_Instants) VALUES (:cle_utilisateurs, :cle_candidats, :cle_etablissements, :cle_instants)";
        $params = [
            ":cle_utilisateurs" => $cle_utilisateur, 
            ":cle_candidats" => $cle_candidat, 
            ":cle_etablissements" => $cle_etablissement, 
            ":cle_instants" => $cle_instants
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one job in the database
     *
     * @param string $poste The job intitule
     * @param string $description The job description
     * @return void
     */
    protected function inscriptPoste(&$poste, &$description) {
        // On initialise la requête
        $request = "INSERT INTO Postes (Intitule_Postes, Description_Postes) VALUES (:poste, :description)";
        $params = [
            "poste" => $poste,
            "description" => $description
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one service in the database
     *
     * @param string $service The service intitule
     * @param string $cle_etablissement The service description
     * @return void
     */
    protected function inscriptService(&$service, $cle_etablissement) {
        // On initialise la requête 
        $request = "INSERT INTO Services (Intitule_Services, Cle_Etablissements) VALUES (:service, :etablissement)";
        $params = [
            'service' => $service,
            'etablissement' => $cle_etablissement
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one establishment
     *
     * @param array<string> $infos The establishment data array 
     * @return void
     */
    protected function inscriptEtablissement(&$infos=[]) {
        // On initialise la requête 
        $request = "INSERT INTO Etablissements (Intitule_Etablissements, Adresse_Etablissements, Ville_Etablissements, CodePostal_Etablissements, Cle_Poles) 
        VALUES (:intitule, :adresse, :ville, :code, :pole)";
        $params = [
            'intitule' => $infos['intitule'],
            'adresse' => $infos['adresse'],
            'ville' => $infos['ville'],
            'code' => $infos['code postal'],
            'pole' => $infos['pole']
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one hub in the database
     *
     * @param string $intitule The hub intitule
     * @param string $description The hub description
     * @return void
     */
    protected function inscriptPole(&$intitule, &$description) {
        // On initialise la requête 
        $request = "INSERT INTO Poles (Intitule_Poles, Description_Poles) VALUES (:intitule, :desc)";
        $params = [
            'intitule' => $intitule,
            'desc' => $description
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one degree in the database
     *
     * @param string $diplome The degree intitule
     * @return void
     */
    protected function inscriptDiplome($diplome) {
        // On initialise la requête
        $request = "INSERT INTO Diplomes (Intitule_Diplomes) VALUES (:intitule)";
        $params = ["intitule" => $diplome];

        // On lance la requête
        $this->post_request($request, $params);
    }


    // METHODES DE MISE-A-JOUR // 

    /**
     * Public method updating one user's password 
     *
     * @param string $password The new user's password
     * @return void
     */
    public function updatePassword(&$password) {
        // On initialise la requête
        $request = "UPDATE Utilisateurs
        SET MotDePasse_Utilisateurs = :password, MotDePassetemp_Utilisateurs = false
        WHERE Id_Utilisateurs = :cle";
        $params = [
            'cle' => $_SESSION['user_cle'],
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        
        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating one user's data
     *
     * @param integer $cle_utilisateur The user's primary key
     * @param array<string> $user The user's data array
     * @return void
     */
    public function updateUser($cle_utilisateur, $user=[]) {
        // On initialise la requête
        $request = "UPDATE Utilisateurs 
        SET Nom_Utilisateurs = :nom, Prenom_Utilisateurs = :prenom, Email_Utilisateurs = :email, Cle_Roles = :role
        WHERE Id_Utilisateurs = :cle";
        $params = [
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role'],
            'cle' => $cle_utilisateur
        ];

        // On lance la requête
        return $this->get_request($request, $params);
    }
    /**
     * public method updating one candidate's evaluation
     *
     * @param integer $cle_candidat The candidate's primary key
     * @param array $notation The candidate's data array
     * @return void
     */
    public function updateNotation($cle_candidat, &$notation=[]) {
        // On initialise la requête
        $request = "UPDATE Candidats 
        SET Notations_Candidats = :notation, Descriptions_Candidats = :description, A_candidats = :a, B_Candidats = :b, C_Candidats = :c
        WHERE Id_Candidats = :cle";
        $params = [
            'notation' => $notation['notation'],
            'description' => $notation['description'],
            'a' => $notation['a'],
            'b' => $notation['b'],
            'c' => $notation['c'],
            'cle' => $cle_candidat
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating a candidate's data
     *
     * @param integer $cle_candidat The candidate's primary key
     * @param array<string> $candidat The cadidate's data array
     * @return void
     */
    public function updateCandidat($cle_candidat, $candidat=[]) {
        // On initialise la requête
        $request = "UPDATE Candidats 
        SET Nom_candidats = :nom, Prenom_Candidats = :prenom, Email_Candidats = :email, Telephone_Candidats = :telephone, Adresse_Candidats = :adresse, Ville_Candidats = :ville, CodePostal_Candidats = :code_postal
        Where Id_Candidats = :cle";
        $params = [
            'nom' => $candidat['nom'], 
            'prenom' => $candidat['prenom'], 
            'email' => $candidat['email'], 
            'telephone' => $candidat['telephone'], 
            'adresse' => $candidat['adresse'], 
            'ville' => $candidat['ville'], 
            'code_postal' => $candidat['code_postal'],
            'cle' => $cle_candidat
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating one candidate's meeting
     *
     * @param integer $cle_candidat The candidate's primary key
     * @param integer $cle_utilisateur The user's primary key
     * @param integer $cle_instant The instant primary key
     * @param array $rdv The metting data array
     * @return void
     */
    public function updateRendezVous($cle_candidat, $cle_utilisateur, $cle_instant, &$rdv=[]) {
        // On met-à-jour l'utilisateur
        $request = "UPDATE Avoir_rendez_vous_avec
        SET Cle_utilisateurs = :user, Cle_Etablissements = :etablissement
        WHERE Cle_Candidats = :candidat AND Cle_utilisateurs = :utilisateur AND Cle_Instants = :instant";
        $params = [
            'user' => $this->searchUserFromUsername($rdv['recruteur'])[0]['Id_Utilisateurs'],
            'etablissement' => $this->searchEtablissement($rdv['etablissement'])['Id_Etablissements'],
            'candidat' => $cle_candidat,
            'utilisateur' => $cle_utilisateur,
            'instant' => $cle_instant 
        ];
        $this->post_request($request, $params);

        // On met-à-jour la date et l'heure
        $request = "UPDATE Instants
        SET Jour_Instants = :date, Heure_Instants = :time";
        $params = [
            'date' => $rdv['date'],
            'time' => $rdv['time']
        ];
        $this->post_request($request, $params);
    }


    // METHODES DE SUPPRESSION //

    /**
     * Protected method deleting one meeting
     *
     * @param integer $cle_candidat The candidate's primary key
     * @param integer $cle_utilisateur The use's primary key
     * @param integer $cle_instant The instant primary key
     * @return void
     */
    protected function deleteRendezVous($cle_candidat, $cle_utilisateur, $cle_instant) {
        // On initialise la requête
        $request = "DELETE FROM Avoir_rendez_vous_avec
        WHERE Cle_Candidats = :candidat
        AND Cle_Utilisateurs = :utilisateur
        AND Cle_Instants = :instant";
        $params = [
            'candidat' => $cle_candidat,
            'utilisateur' => $cle_utilisateur,
            'instant' => $cle_instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method deleting one instant
     *
     * @param integer $cle_instant The instant primary key
     * @return void
     */
    protected function deleteInstant($cle_instant) {
        // On initialise la requête
        $request = "DELETE FROM Instants WHERE Id_Instants = :cle";
        $params = ['cle' => $cle_instant];

        // On lance la requête
        $this->post_request($request, $params);
    }
}