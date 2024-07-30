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
            // forms_manip::error_alert($e->getMessage());
            die("Connexion à la base de données réchouée. " . $e->getMessage());
        }
        return $this->connection;
    }
    /// Méthode protégée retournant la connexion à la base de données
    protected function getConnection() {
        return $this->connection;
    }
    /// Méthode privée inscrivant les actions dans la base de données
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
    

    /// Méthode privée permettant de vérifier les paramètres fournis au fonction de requêtes
    private function test_data_request(&$request, &$params): bool {
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
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
            // forms_manip::error_alert("Erreur lors de la requête à la base de données", $e);
        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 

        return null;
    }
    /// Méthode privée exécutant une requête POST à la base de données
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



    /// Méthode publique retournant la liste des utilisateurs pour l'autocomp
    public function getAutoCompletUtilisateurs() {
        // On initialise la requête
        $request = "SELECT Identifiant_Utilisateurs FROM Utilisateurs ORDER BY Identifiant_Utilisateurs";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /// Méthode publique retournant la liste des établissements pour l'autocomp
    public function getAutoCompletEtablissements() {
        // On initialise la requête
        $request = "SELECT Intitule_Etablissements FROM Etablissements ORDER BY Intitule_Etablissements";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
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
    /// Métohode publique retournant la liste des aides pour l'autocomplétion
    public function getAides() {
        // On inititalise la requête
        $request = "SELECT 
        Id_Aides_au_recrutement AS id,
        Intitule_Aides_au_recrutement AS text

        FROM aides_au_recrutement";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /// Méthode public retournant la liste des diplomes pour l'autocomplétion
    public function getDiplomes() {
        // On initialise la requête
        $request = "SELECT
        Intitule_Diplomes AS text
        
        FROM Diplomes";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /// Méthode publique retournant la liste des postes pour l'autocomplétion
    public function getAutoCompPostes() {
        // On inititalise la requête
        $request = "SELECT Intitule_Postes FROM Postes ORDER BY Intitule_Postes";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /// Méthode publique retournant la liste des services pour l'autocomplétion
    public function getAutoCompServices() {
        // On inititalise la requête
        $request = "SELECT Intitule_Services FROM Services ORDER BY Intitule_Services";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /// Méthode publique retournant la liste des types de contrats pour l'autocomplétion
    public function getAutoCompTypesContrat() {
        // On initialise la requête
        $request = "SELECT Intitule_Types_de_contrats FROM Types_de_contrats ORDER BY Intitule_Types_de_contrats";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /// Méthode publique retournant la liste des sources pour l'autocomplétion
    public function getAutoCompSources() {
        // On initialise la requête
        $request = "SELECT Intitule_Sources FROM Sources ORDER BY Intitule_Sources";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
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

    /// Méthode protégée recherchant un instant dans la base de données
    protected function searchInstant($cle_instant) {
        // On initialise la requête
        $request = "SELECT * FROM Instants WHERE Id_Instants = :cle";
        $params = ['cle' => $cle_instant];

        // On récupère le résultat
        return $this->get_request($request, $params, true, true);
    }
    /// Méthode protégée recherchant un etablissement dans la base de données
    protected function searchEtablissement($etablissement) {
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
    /// Méthode protégée recherchant un pôle dans la base de données
    protected function searchPole($pole) {
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
    /// Méthode protégée recherchant un role dans la base de données
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
    /// Méthode protégée recherchant un type d'action dans la base de donnés
    protected function serachAction_type($action) {
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
    /// Méthode protégée recherchant un Utilisateur dans la base de données 
    protected function searchUser($user) {
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
    /// Méthode protégée recherchant un utilisateur depuis son nom d'utilisateur
    protected function searchUserFromUsername($user) {
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

    /// Méthode protégée recherchant une candidature dans la base de données
    protected function searchCandidature($cle) {
        // On initialise la requête
        $request = "SELECT * FROM Candidatures WHERE Id_candidatures = :cle";
        $params = ['cle' => $cle];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /// Méthode publique recherchant un candidat dans la base de données depuis une de ses candidatures
    public function searchCandidatFromCandidature($cle) {
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
    /// Méthode publique recherchant un candidat dans la base de données depuis une de ses contrats
    public function searchcandidatFromContrat($cle) {
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
    /// Méthode protégée recherchant une candidature depuis sont candidat et son instant dans la base de données
    protected function searchCandidatureFromCandidat($cle_candidat, $cle_instant) {
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
    /// Méthode protégée recherchant un diplome dans la base de données
    protected function searchDiplome($diplome) {
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
    /// Méthode protégée recherchant un type de contrat dans la base de données 
    protected function searchTypeContrat($contrat) {
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
    /// Méthode recherchant une source dans la base de données
    protected function searchSource($source) {
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
    /// Méthode protégée recherchant un poste dans la base de données
    protected function searchPoste($poste) {
        // On initialise la requête
        if(is_numeric($poste)) {
            $request = "SELECT * FROM Postes WHERE Id_Postes = :Id";
            $params = ["Id" => $poste];
            
        } elseif(is_string($poste)) {
            $request = "SELECT * FROM Postes WHERE Intitule_Postes = :Intitule";
            $params = ["Intitule" => $poste];
        } else 
            throw new Exception("Erreur lors de la recherche de poste. La saisie du poste est mal typée. Il doit être un identifiant (entier positif) ou une chaine de caractères !");

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /// Méthode protégée recherchant un service dans la base de données 
    protected function searchService($service) {
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
    /// Méthode protégée recherchant une aide dans la base de données
    protected function searchAide($aide) {
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
    /// Méthode protégée recherchant un Appliquer_a depuis sa candidature
    protected function searchAppliquer_aFromCandidature($cle) {
        // On initialise la requête
        $request = "SELECT * FROM Appliquer_a WHERE Cle_Candidatures = :cle";
        $params = ['cle' => $cle];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /// Méthode protégée recherchant un Appliquer_a depuis son service
    protected function searchAppliquer_aFromService($cle) {
        // On initialise la requête
        $request = "SELECT * FROM Appliquer_a WHERE Cle_Services = :cle";
        $params = ['cle' => $cle];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /// Méthode protégée recherchant un contrat dans la base de données
    protected function searchContrat(&$cle_contrat) {
        if(empty($cle_contrat) || !is_numeric($cle_contrat))
            throw new Exception('Erreur lors de la recherche du contrat. La clé contrat doit être un nombre entier positif !');

        // On initialise la requête
        $request  = "SELECT * FROM Contrats WHERE Id_Contrats = :cle";
        $params = ['cle' => $cle_contrat];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    


    // METHODES D'INSCRIPTION DANS LA BASE DE DONNES //

    /// Méthode protégées inscrivant un instant dans la base de données et reournant son id
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
        $request = "SELECT * FROM Instants WHERE Jour_Instants = :jour AND Heure_Instants = :heure";

        return $this->get_request($request, $params, true, true);
    }
    /// Méthode protégée inscrivant un Utilisateurs dans la base de données
    protected function inscriptUtilisateurs($utilisateur=[]) {
        if(empty($utilisateur)) 
            throw new Exception("Impossible d'inscrire un Utilisateur. Données manquantes !");

        else {
            // On initialise la requête
            $request = "INSERT INTO utilisateurs (identifiant_utilisateurs, nom_utilisateurs, prenom_utilisateurs, email_utilisateurs, motdepasse_utilisateurs, Cle_Etablissements, Cle_Roles)
                        VALUES (:identifiant, :nom, :prenom, :email, :motdepasse, :cle_etablissement, :cle_role)";

            // On lance la requête
            $this->post_request($request, $utilisateur);
        }
    }
    /// Méthode protégée enregistrant une action dans la base de données
    protected function inscriptAction(&$cle_user, &$cle_action, &$cle_instant, $description) {
        // On vérifie l'intégrité des données
        if(empty($cle_user) || !is_int($cle_user))
            throw new Exception("La clé Utilisateur est nécessaire pour l'enregistrement d'une action !");
        elseif(empty($cle_action) || !is_int($cle_action))
            throw new Exception("La clé Action est nécessaire pour l'enregistrement d'une action !");
        elseif(empty($cle_instant) || !is_int($cle_instant))
            throw new Exception("La clé Action est nécessaire pour l'enregistrement d'une action !");

        else if(!empty($description)) {
            // On ajoute l'action à la base de données
            $request = "INSERT INTO Actions (Cle_Utilisateurs, Cle_Types, Cle_Instants, Description_Actions) VALUES (:user_id, :type_id, :instant_id, :description)";
            $params = [
                "user_id" => $cle_user,
                "type_id" => $cle_action,
                "instant_id" => $cle_instant,
                'description' => $description
            ];
            
            $this->post_request($request, $params);

        } else {
            // On ajoute l'action à la base de données
            $request = "INSERT INTO Actions (Cle_Utilisateurs, Cle_Types, Cle_Instants) VALUES (:user_id, :type_id, :instant_id)";
            $params = [
                "user_id" => $cle_user,
                "type_id" => $cle_action,
                "instant_id" => $cle_instant
            ];

            $this->post_request($request, $params);
        }
    }

    /// Méthode protégée inscrivant une Candidat dans la base de données
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
        
        echo "<h2>Le candidat</h2>";
        var_dump($candidat);
        echo "<h3>La requête</h3>";
        var_dump($request);
        echo "<h3>Les paramètres</h3>";
        var_dump($candidat->exportToSQL());

        // On lance  requête
        $this->post_request($request, $candidat->exportToSQL());
    }
    /// Méthode protégée inscrivant une Aide dans la base de données
    protected function inscriptAide($candidat, $aide) {      
        // On initialise la requête
        $request = "INSERT INTO avoir_droit_a (Cle_Candidats, Cle_Aides_au_recrutement) VALUES (:candidat, :aide)";
        $params = [
            "candidat" => $candidat->getCle(), 
            "diplome" => $aide["Id_Aides_au_recrutement"]
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /// Méthode protégée inscrivant un Diplome dans la base de données
    protected function inscriptDiplome($cle_candidat, $cle_diplome) {
        // On initialise la requête
        $request = "INSERT INTO obtenir (Cle_Candidats, Cle_Diplomes) VALUES (:candidat, :diplome)";
        $params = [
            "candidat" => $cle_candidat, 
            "diplome" => $cle_diplome
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /// Méthode protégée inscrivant un Postuler_a dans la base de données
    protected function inscriptPostuler_a($candidat, $instant) {
        // On initialise la requête 
        $request = "INSERT INTO Postuler_a (Cle_Candidats, Cle_Instants) VALUES (:candidat, :instant)";
        $params = [
            "candidat" => $candidat->getCle(), 
            "instant" => $instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /// Méthode protégée inscrivant un Appliquer_a dans la base de données
    protected function inscriptAppliquer_a($cle_candidature, $cle_service) {
        // On vérifie l'intégrité des données
        if(empty($cle_candidature) || empty($cle_service)) 
            throw new Exception('Données éronnées. Pour inscrire un Appliquer_a, la clé de candidature et la clé de service sont nécessaires');        

        // On inititalise la requête
        $request = "INSERT INTO Appliquer_a (Cle_Candidatures, Cle_Services) VALUES (:candidature, :service)";
        $params = [
            "candidature" => $cle_candidature,
            "service" => $cle_service
        ];

        // On exécute la requête
        $this->post_request($request, $params);
    }
    /// Méthode protégée inscrivant un Avoir_droit_a dans la base de données
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

        echo "<h4>La requête</h4>";
        var_dump($request);
        echo "<h4>Les paramètres</h4>";
        var_dump($params);
        
        // On lance la requête
        $this->post_request($request, $params);
    }
    /// Méthode protégée inscrivant un Proposer_a dans la base de données
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
    /// Méthode protégée inscrivant une mission dans la base de données
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
    /// Méthode protégée inscrivant un rendez vous dans la base de données
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
    /// Méthode protégée inscrivant un poste dans la base de données
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
    /// Méthode protégée inscrivant un service dans la base de données
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
    /// Méthode protégée inscrivant un nouvel établissement dans la base de données
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
    /// Méthode protégée inscrivant un nouveau pôle dans la base de données
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

    /// Méthode publique mettant à jour le mot de passe d'un utilisateur
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
    /// Méthode publique mettant à jour la notation d'un candidat 
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
    /// Méthode publique mettant à jour la notation d'un candidat 
    public function updateCandidat($cle_candidat, &$candidat=[]) {
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
    /// Méthode publique mettant à jour le rendez-vous d'un candidat
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


    // METHODE DE SUPPRESSION //

    /// Méthode protégée supprimant un rendez-vous de la base de données
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
    /// Méthode protégée supprimant un instant de la base de données
    protected function deleteInstant($cle_instant) {
        // On initialise la requête
        $request = "DELETE FROM Instants WHERE Id_Instants = :cle";
        $params = ['cle' => $cle_instant];

        // On lance la requête
        $this->post_request($request, $params);
    }

    // MÉTHODE À RENOMMER //
    public function createDiplome($diplome) {
        // On initialise la requête
        $request = "INSERT INTO Diplomes (Intitule_Diplomes) VALUES (:intitule)";
        $params = ["intitule" => $diplome];

        // On lance la requête
        $this->post_request($request, $params);
    }
}