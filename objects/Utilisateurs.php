<?php

class InvalideUtilisateurExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Utilisateurs {
    private $identifiant, $email, $motdepasse, $role;
    
    public function __construct($identifiant, $email, $motdepasse, $role){
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

    public function getIdentifiant(){ return $this->identifiant; }
    public function getEmail(){ return $this->email; }
    public function getMotdepasse(){ return $this->motdepasse; }
    public function getRole(){ return $this->role; }

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
            throw new InvalideUtilisateurExceptions("Le mot de passe d'un utilisateur doit être une chaine de caractères");
        $this->motdepasse = $motdepasse;
    }
    private function setRole($role){
        // On vérifie que le role est non-vide
        if(empty($role))
            throw new InvalideUtilisateurExceptions("Le rôle d'un utilisateur ne peut être vide !");
        // On vérifie que le mot de passe est un string
        elseif(!is_string($role))
        // On implémente
            throw new InvalideUtilisateurExceptions("Le mot de passe d'un utilisateur doit être une chaine de caractères");
        $this->role = $role;
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
}