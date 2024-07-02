<?php

class InvalideUtilisateurExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Utilisateurs {
    /// Attributs privés de la classe
    private $cle, $identifiant, $nom, $prenom, $email, $motdepasse, $role, $role_id;

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

    static public function makeUtilisateurs($infos=[]) {
        // On vérifie la présence des données
        if(empty($infos))
            return;

        // On vérifie l'intégrité des données
        if(!isset($infos['identifiant']) || !isset($infos['email']) || !isset($infos['mot de passe']) || !isset($infos['role']))
            throw new Exception('Donnnées éronnées. Champs manquants.');

            // On construit le contrat
        $utilisateur = new Utilisateurs($infos['identifiant'], $infos['email'], $infos['mot de passe'], $infos['role']);

        // On ajoute les champs suplémentaires
        foreach($infos as $key => $value) switch($key) {
            case 'nom':
                $utilisateur->setNom($value);
                break;

            case 'prenom': 
                $utilisateur->setPrenom($value);
                break;
                
            default: 
                throw new Exception('Paramètre inidentifiable: ' . $key . ".");
        }

        // On retourne le nouvel utilisateur
        return $utilisateur;
    }

    /// Getters
    public function getCle(){ return $this->cle; }
    public function getIdentifiant(){ return $this->identifiant; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail(){ return $this->email; }
    public function getMotdepasse(){ return $this->motdepasse; }
    public function getRole(){ return $this->role; }
    public function getRole_id(){ /* ... */ }


    /// Setters
    private function setIdentifiant($identifiant){
        // On vérifie que l'indentifiant utilisateur est non-vide
        if(empty($identifiant))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!is_string($identifiant))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->identifiant = $identifiant;
    }
    private function setNom($nom) {
        // On vérifie que le nom est non-vide
        if(empty($nom))
            throw new InvalideUtilisateurExceptions("Le nom d'un utilisateur ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!is_string($nom))
            throw new InvalideUtilisateurExceptions("Le nom d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->nom = $nom;
    }
    private function setPrenom($prenom) {
        // On vérifie que le prénom est non-vide
        if(empty($prenom))
            throw new InvalideUtilisateurExceptions("Le prénom d'un utilisateur ne peut être vide !");
        // On vérifie que le prénom est un string
        elseif(!is_string($prenom))
            throw new InvalideUtilisateurExceptions("Le prénom d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->prenom = $prenom;
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
        if($cle == null || !is_int($cle)) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être un entier !");
        // On vérifie que l'id est un nombre positif ou nul
        elseif($cle < 0) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être supéieure ou égale à 0 !");

        // On implémente
        else $this->cle = $cle;
    }
    public function setRole_id($role_id) {
        // On vérifie que l'id est un nombre positif ou nul
        if($role_id == null || !is_int($role_id)) 
            throw new InvalideUtilisateurExceptions("La clé extrene de rôle doit être un entier !");
        // On vérifie que l'id est un nombre positif ou nul
        elseif($role_id < 0) 
            throw new InvalideUtilisateurExceptions("La clé extrene de rôle doit être supéieure ou égale à 0 !");

        // On implémente
        else $this->role_id = $role_id;
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
    /// Méthode publique retournant les données de l'Utilisateurs pour une requêtes SQL
    public function exportToSQL($cle_role): ?array {
        if($this->getNom() == null || $this->getPrenom() == null) 
            throw new Exception("Le nom et le prenom de l'utilisateur sont requis pour une exportation SQL.");
        
        else return [
            'identifiant' => $this->getIdentifiant(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'email' => $this->getEmail(),
            'motdepasse' => password_hash($this->getMotdepasse(), PASSWORD_DEFAULT),
            'id_Roles' => $cle_role
        ];
    } 
}