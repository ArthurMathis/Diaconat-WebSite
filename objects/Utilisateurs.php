<?php

class InvalideUtilisateurExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Utilisateurs {
    /// Attributs privés de la classe
    private $identifiant, $email, $motdepasse, $role, $cle;

    /// Constructeur de la classe
    public function __construct($identifiant, $email, $motdepasse, $role) {
        $this->cle == null;

        try{
            $this->setIdentifiant($identifiant);
            $this->setEmail($email);
            $this->setMotdepasse($motdepasse);
            $this->setRole($role);

        // On récuèpre les éventuelles erreurs
        } catch(InvalideUtilisateurExceptions $e){
            throw $e;
        }
    }

    /// Getters
    public function getIdentifiant(){ return $this->identifiant; }
    public function getEmail(){ return $this->email; }
    public function getMotdepasse(){ return $this->motdepasse; }
    public function getRole(){ return $this->role; }
    public function getCle(){ return $this->cle; }


    /// Setters
    private function setIdentifiant($identifiant){
        // On vérifie que le nom est non-vide
        if(empty($identifiant))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!is_string($identifiant))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->identifiant = $identifiant;
    }
    private function setEmail($email){
        // On vérifie que l'email est non-vide
        if(empty($email))
            throw new InvalideUtilisateurExceptions("L'email d'un utilisateur ne peut être vide !");
        // On vérifie que l'email est un string
        elseif(!is_string($email))
            throw new InvalideUtilisateurExceptions("L'email d'un utilisateur doit être une chaine de caractères !");
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new InvalideUtilisateurExceptions("L'email doit contenir un nom, un @ et une adresse ! (ex: nom.prenom@diaconat-mulhouse.fr)");
        
        // On implémente
        else $this->email = $email;
    }
    private function setMotdepasse($motdepasse){
        // On vérifie que le mot de passe est non-vide
        if(empty($motdepasse))
            throw new InvalideUtilisateurExceptions("Le mot de passe d'un utilisateur ne peut être vide !");
        // On vérifie que le mot de passe est un string
        elseif(!is_string($motdepasse))
        // On implémente
            throw new InvalideUtilisateurExceptions("Le mot de passe d'un utilisateur doit être une chaine de caractères. Le mot de passe !");
        
        else $this->motdepasse = $motdepasse;
    }
    private function setRole($role){
        // On vérifie que le role est non-vide
        if(empty($role))
            throw new InvalideUtilisateurExceptions("Le rôle d'un utilisateur ne peut être vide !");
        // On vérifie que le mot de passe est un string
        elseif(!is_string($role))
            throw new InvalideUtilisateurExceptions("Le rôle d'un utilisateur doit être une chaine de caractères");
        
            // On implémente
        else $this->role = $role;
    }
    public function setCle($cle) {
        // On vérifie que l'id est un nombre positif ou nul
        if(!is_numeric($cle)) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être un entier !");
        // On vérifie que l'id est un nombre positif ou nul
        elseif($cle < 0) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être supéieure ou égale à 0 !");

        // On implémente
        else $this->cle = $cle;
    }

    static function searchRole($bdd, $role) {
        // On initialise la requête
        $sql = "SELECT * FROM roles WHERE Id = :Id";
        $query = $bdd->prepare($sql);
        
        // On lance la requête
        $query->execute(["Id" => $role]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // On teste les résultats
        if(empty($result))
            throw new Exception("Role introuvable");
        else return $result;
    }
    public function searchRole_id($bdd) {
        // On initialise la requête
        $sql = "SELECT * FROM roles WHERE Intitule = :Intitule";
        $query = $bdd->prepare($sql);
        
        // On lance la requête
        $query->execute(["Intitule" => $this->getRole()]);
        
        // On récupère le résultat de la requête
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        // On teste si la requête a renvoyé des résultats
        if(!$result) {
            throw new Exception("Rôle introuvable");
            return null;
            
        } else {
            return $result['Id'];
        }
    }
    public function searchCle($bdd) {
        try {
            // On récupère l'utilisateur dans la base de données
            $sql = "SELECT * FROM Utilisateurs WHERE Nom = :nom AND Email = :email AND Id_Roles = :id_Roles";
            $query = $bdd->prepare($sql);
            $params = [
                'nom' => $this->getIdentifiant(),
                'email' => $this->getEmail(),
                'id_Roles' => $this->searchRole_id($bdd)
            ];
            $query->execute($params);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            
            // On vérifie qu'il y a des utilisateurs
            if(empty($user)) 
                // On émet une erreur si la base de données est vide
                throw new Exception("Erreur lors de la récupération de la clé de l'utilisateur");
   
        } catch(PDOException $e){
            echo "<script>
                console.log(\"Erreur PDO : " . $e->getMessage() . " \");
                console.log(\"Code d'erreur PDO : " . $e->getCode() . " \");
            </script>";
        } catch(Exception $e){
            echo "<script>console.log(\"Aucun utilisateur enregistré correspondant à la requête\");</script>";
        }

        // Afficher le contenu de $user
        if (empty($user)) 
            echo "<script>console.log('Aucun utilisateur trouvé');</script>";
        
        else $this->setCle($user["Id"]);
    }

    /// Méthode publique permettant la construction d'un Utilisateurs depuis un tableau associatif 
    public static function createFromArray(array $data) {
        return new self(
            $data['identifiant'],
            $data['email'],
            $data['motdepasse'],
            $data['role'], 
            $data['cle']
        );
    }
    /// Méthode retournant l'item sous forme d'un tableau associatif
    public function exportToArray() {
        return [
            'identifiant' => $this->getIdentifiant(),
            'email' => $this->getEmail(),
            'motdepasse' => $this->getMotdepasse(),
            'role' => $this->getRole(),
        ];
    }

    /// Méthode publique exportant l'item sous-forme de tableau associatif avec le mot de passe haché
    public function exportToSQL($bdd){
        return [
            'nom' => $this->getIdentifiant(),
            'email' => $this->getEmail(),
            'motdepasse' => password_hash($this->getMotdepasse(), PASSWORD_DEFAULT),
            'id_Roles' => $this->searchRole_id($bdd),
        ];
    }
}