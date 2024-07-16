<?php

class InvalideUtilisateurExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Utilisateurs {
    /// Attributs privés de la classe
    private $cle, $identifiant, $nom, $prenom, $email, $motdepasse, $etablissement, $role;

    /// Constructeur de la classe
    public function __construct($identifiant, $nom, $prenom, $email, $motdepasse, $etablissement, $role) {
        $this->cle == null;

        try{
            $this->setIdentifiant($identifiant);
            $this->setNom($nom);
            $this->setPrenom($prenom);
            $this->setEmail($email);
            $this->setMotdepasse($motdepasse);
            $this->setEtablissement($etablissement);
            $this->setRole($role);

        // On récuèpre les éventuelles erreurs
        } catch(InvalideUtilisateurExceptions $e){
            throw $e;
        }
    }

    static public function makeUtilisateurs($infos=[]) {
        // On vérifie la présence des données
        if(empty($infos))
            throw new Exception("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");

        // On vérifie l'intégrité des données
        if(!isset($infos['identifiant']) ||!isset($infos['nom']) ||!isset($infos['prenom']) || !isset($infos['email']) || !isset($infos['mot de passe']) ||!isset($infos['etablissement']) || !isset($infos['role']))
            throw new Exception('Donnnées éronnées. Champs manquants.');

        // On retourne le nouvel utilisateur
        return new Utilisateurs($infos['identifiant'], $infos['nom'], $infos['prenom'], $infos['email'], $infos['mot de passe'], $infos['etablissement'], $infos['role']);
    }

    /// Getters
    public function getCle(){ return $this->cle; }
    public function getIdentifiant(){ return $this->identifiant; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail(){ return $this->email; }
    public function getMotdepasse(){ return $this->motdepasse; }
    public function getEtablissement(){ return $this->etablissement; }
    public function getRole(){ return $this->role; }


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
    private function setEtablissement($etablissement) {
        // On vérifie que l'établissement est non-vide
        if(empty($etablissement))
            throw new InvalideUtilisateurExceptions("L'établissement d'un utilisateur ne peut être vide !");
        // On vérifie que l'établissement est un string
        elseif(!is_numeric($etablissement))
            throw new InvalideUtilisateurExceptions("L'établissement d'un utilisateur doit être une chaine de caractères");
        
            // On implémente
        else $this->etablissement = $etablissement;
    }
    private function setRole($role){
        // On vérifie que le role est non-vide
        if(empty($role))
            throw new InvalideUtilisateurExceptions("Le rôle d'un utilisateur ne peut être vide !");
        // On vérifie que le mot de passe est un string
        elseif(!is_numeric($role))
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
    public function exportToSQL(): ?array {
        if($this->getNom() == null || $this->getPrenom() == null) 
            throw new Exception("Le nom et le prenom de l'utilisateur sont requis pour une exportation SQL.");
        
        else return [
            'identifiant' => $this->getIdentifiant(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'email' => $this->getEmail(),
            // 'motdepasse' => password_hash($this->getMotdepasse(), PASSWORD_DEFAULT),
            'motdepasse' => $this->getMotdepasse(),
            'cle_etablissement' => $this->getEtablissement(),
            'cle_role' => $this->getRole()
        ];
    } 
}