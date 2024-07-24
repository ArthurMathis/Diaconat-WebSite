<?php 

require_once('Instants.php');

class InvalideCandidatExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Candidat {
    private $nom, $prenom, $email, $telephone, $adresse, $ville, $code_postal, $cle = null, $disponibilite = null, $visite_medicale = null;

    public function __construct($nom, $prenom, $email, $telephone, $adresse, $ville, $code_postal) {
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setEmail($email);
        $this->settelephone($telephone);
        $this->setAdresse($adresse);
        $this->setVille($ville);
        $this->setCodePostal($code_postal);
    } 

    public function getCle() { return $this->cle; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getTelephone() { return $this->telephone; }
    public function getAdresse() { return $this->adresse; }
    public function getVille() { return $this->ville; }
    public function getCodePostal() { return $this->code_postal; }
    public function getDisponibilite() { return $this->disponibilite; }
    public function getVisite_medicale() { return $this->visite_medicale; }

    public function setCle($cle) { 
        // On vérifie la présence d'une clé
        if($cle == null)
            return;

        // On vérifie l'intégrité des données
        elseif(!is_numeric($cle)) 
            throw new InvalideCandidatExceptions("La clé d'un candidat doit être un entier !");
        elseif($cle < 0)
            throw new InvalideCandidatExceptions("La clé d'un candidat doit être strictement positive !");

        // On implémente    
        else  $this->cle = $cle;
    }
    private function setNom($nom) { 
        // On vérifie l'intégrité des données
        if(empty($nom))
            throw new InvalideCandidatExceptions("Le nom d'un candidat ne peut pas être vide !");
        elseif(!is_string($nom))
            throw new InvalideCandidatExceptions("Le nom d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $nom))
            throw new InvalideCandidatExceptions("Le nom d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\p{L}\p{M}\s\'-]/u', $nom))
            throw new InvalideCandidatExceptions("Le nom d'un candidat ne peut pas contenir de carcatères spéciaux !");

        // On implémente    
        else $this->nom = $nom;
    }
    private function setPrenom($prenom) { 
        // On vérifie l'intégrité des données
        if(empty($prenom))
            throw new InvalideCandidatExceptions("Le prenom d'un candidat ne peut pas être vide !");
        elseif(!is_string($prenom))
            throw new InvalideCandidatExceptions("Le prenom d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $prenom))
            throw new InvalideCandidatExceptions("Le prenom d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\p{L}\p{M}\s\'-]/u', $prenom))
            throw new InvalideCandidatExceptions("Le prenom d'un candidat ne peut pas contenir de carcatères spéciaux !");

        // On implémente    
        else $this->prenom = $prenom;
    }
    private function setEmail($email) { 
        // On vérifie l'intégrité des données
        if(empty($email))
            throw new InvalideCandidatExceptions("L'email d'un candidat ne peut être vide !");
        elseif(!is_string($email))
            throw new InvalideCandidatExceptions("L'email d'un candidat doit être une chaine de caractères !");
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new InvalideCandidatExceptions("L'email doit contenir un nom, un @ et une adresse ! (ex: nom.prenom@diaconat-mulhouse.fr)");
        
        // On implémente
        else $this->email = $email;
    }
    private function setTelephone($telephone) { 
        // On vérifie l'intégrité des données
        if(empty($telephone)) 
            throw new InvalideCandidatExceptions("Le téléphone d'un utilisateur ne peut pas être vide !");
        elseif(!is_string($telephone))
            throw new InvalideCandidatExceptions("Un numero de téléphone doit être une chaine de carcatères composées de nombres et de points !");

        // On implémente    
        else $this->telephone = $telephone;
    }
    private function setAdresse($adresse) { 
        // On vérifie l'intégrité des données
        if(empty($adresse))
            throw new InvalideCandidatExceptions("L'adresse d'un candidat ne peut pas être vide !");
        elseif(!is_string($adresse))
            throw new InvalideCandidatExceptions("L'adresse d'un candidat doit être une chaine de carcatères !");
        
        // On implémente
        else $this->adresse = $adresse;
    }
    private function setVille($ville) { 
        // On vérifie l'intégrité des données
        if(empty($ville))
            throw new InvalideCandidatExceptions("La ville d'un candidat ne peut pas être vide !");
        elseif(!is_string($ville))
            throw new InvalideCandidatExceptions("La ville d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $ville))
            throw new InvalideCandidatExceptions("La ville d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\w\s]/', $ville))
            throw new InvalideCandidatExceptions("La ville d'un candidat ne peut pas contenir de carcatères spéciaux !");
        
        // On implémente
        else $this->ville = $ville;
    }
    private function setCodePostal($code_postal) { 
        // On vérifie l'intégrité des données
        if(empty($code_postal))
            throw new InvalideCandidatExceptions("Le code postale d'un cndidat ne peut être vide !");
        elseif(!preg_match ("~^[0-9]{5}$~", $code_postal))
            throw new InvalideCandidatExceptions("Le code postale doit être composé de cinq nombres uniquement !");

        else $this->code_postal = $code_postal;
    }
    public function setdisponibilite($disponibilite) { 
        // On vérfiie l'intégrité des données
        if(empty($disponibilite))
            throw new InvalideCandidatExceptions("La disponibilité d'un candidat doit être remplie !");
        elseif(!Instants::isDate($disponibilite))
            throw new InvalideCandidatExceptions("La disponibilité d'un candidat doit être une date !");
        
        // On implémente
        else $this->disponibilite = $disponibilite;
    }
    public function setVisite($visite=true) {
        if(!is_bool($visite))
            throw new InvalideCandidatExceptions("La visite médicale d'un candidat doit être un booléen !");

        else $this->visite_medicale = $visite;
    }

    public function exportToSQL() {
        return [
            "nom" => $this->getNom(),
            "prenom" => $this->getPrenom(),
            "email" => $this->getEmail(), 
            "telephone" => $this->getTelephone(),
            "adresse" => $this->getAdresse(),
            "ville" => $this->getVille(),
            "code_postal" => $this->getCodePostal(),
            "disponibilite" => $this->getDisponibilite(),
            "visite" => $this->getVisite_medicale() ? 1 : 0
        ];
    }
    public function exportToSQL_update() {
        return [
            "nom" => $this->getNom(),
            "prenom" => $this->getPrenom(),
            "email" => $this->getEmail(), 
            "telephone" => $this->getTelephone(),
            "adresse" => $this->getAdresse(),
            "ville" => $this->getVille(),
            "code_postal" => $this->getCodePostal()
        ];
    }
    public function exportToSQL_cle() {
        if($this->getCle() == null) {
            throw new InvalideCandidatExceptions("La clé du candidat doit être implémentée avec une exporttation SQL !");
            exit;
        }

        return [
            "id" => $this->getCle(),
            "nom" => $this->getNom(),
            "prenom" => $this->getPrenom(),
            "email" => $this->getEmail(), 
            "telephone" => $this->getTelephone(),
            "adresse" => $this->getAdresse() ,
            "ville" => $this->getVille(),
            "code_postal" => $this->getCodePostal(),
            "disponibilite" => $this->getDisponibilite(),
            "visite" => $this->getVisite_medicale()
        ];
    }
}
