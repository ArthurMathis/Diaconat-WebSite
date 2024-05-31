<?php

class InvalideUtilisateurExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Utilisateurs {
    /// Attributs privés de la classe
    private $cle, $identifiant, $email, $motdepasse, $role, $role_id;

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
    public function getRole_id(){ /* ... */ }
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
    public function setRole_id($role_id) {
        // On vérifie que l'id est un nombre positif ou nul
        if(!is_numeric($role_id)) 
            throw new InvalideUtilisateurExceptions("La clé extrene de rôle doit être un entier !");
        // On vérifie que l'id est un nombre positif ou nul
        elseif($role_id < 0) 
            throw new InvalideUtilisateurExceptions("La clé extrene de rôle doit être supéieure ou égale à 0 !");

        // On implémente
        else $this->role_id = $role_id;
    }

    /// Méthode publique permettant la construction d'un Utilisateurs depuis un tableau associatif 
    public static function createFromArray(array $data): Utilisateurs {
        return new self(
            $data['identifiant'],
            $data['email'],
            $data['motdepasse'],
            $data['role'], 
            $data['cle']
        );
    }
    /// Méthode retournant l'item sous forme d'un tableau associatif
    public function exportToArray(): array {
        return [
            'identifiant' => $this->getIdentifiant(),
            'email' => $this->getEmail(),
            'motdepasse' => $this->getMotdepasse(),
            'role' => $this->getRole(),
            'cle' => $this->getCle()
        ];
    }
}