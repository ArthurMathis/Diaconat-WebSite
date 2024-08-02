<?php 

require_once('Instants.php');

class InvalideContratExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Contrat {
    /// Attributs privés de la classe
    private $cle=null, $date_debut, $date_fin=null, $salaire=null, $date_demission=null, $travail_nuit=false, $travail_wk=false, $nb_heures=null, $signature=null, $cle_candidats, $cle_instants, $Cle_Services, $Cle_Postes, $Cle_Type;

    /// Constructeur de la classe
    public function __construct($date_debut, $cle_candidats, $cle_instants, $Cle_Postes, $Cle_Services, $Cle_Type) {
        $this->setDateDebut($date_debut);
        $this->setCleCandidats($cle_candidats);
        $this->setCleInstants($cle_instants);
        $this->setClePostes($Cle_Postes);
        $this->setCleServices($Cle_Services);
        $this->setCleType($Cle_Type);
    }

    /// Méthode statique permettant la construction sur mesure d'un contrat
    public static function makeContrat($infos=[]) {
        // On vérifie la présence des données
        if(empty($infos))
            return;

        // On vérifie l'intégrité des données
        if(!isset($infos['date debut']) || !isset($infos['cle candidat']) || !isset($infos['cle instant']) || 
           !isset($infos['cle poste']) || !isset($infos['cle service']) || !isset($infos['cle type']))
            throw new Exception('Donnnées éronnées. Champs manquants.');

        // On construit le contrat
        $contrat = new Contrat($infos['date debut'], $infos['cle candidat'], $infos['cle instant'], $infos['cle poste'], $infos['cle service'], $infos['cle type']);

        // On ajoute les champs suplémentaires
        foreach($infos as $key => $value) switch($key) {
            case 'date fin':
                $contrat->setDateFin($value);
                break;
                
            case 'salaire':
                $contrat->setSalaire($value);
                break;    

            case 'date demission':
                $contrat->setDateDemission($value);
                break;

            case 'signature': 
                $contrat->setSignature($value);
                break;    

            case 'travail nuit':
                $contrat->setTravailNuit();
                break; 

            case 'travail week-end':
                $contrat->setTravailWk();
                break; 

            case 'taux horaire':
                $contrat->setNbHeures($value);
                break; 
        }     

        // On retourne le contrat
        return $contrat;
    }

    /// Getteurs
    public function getCle() { return $this->cle; }
    public function getDateDebut() { return $this->date_debut; }
    public function getDateFin() { return $this->date_fin; }
    public function getSalaire() { return $this->salaire; }
    public function getDateDemission() { return $this->date_demission; }
    public function getTravailNuit() { return $this->travail_nuit; }
    public function getTravailWk() { return $this->travail_wk; }
    public function getNbHeures() { return $this->nb_heures; }
    public function getSignature() { return $this->signature; }
    public function getCleCandidats() { return $this->cle_candidats; }
    public function getCleInstants() { return $this->cle_instants; }
    public function getCleServices() { return $this->Cle_Services; }
    public function getClePostes() { return $this->Cle_Postes; }
    public function getCleType() { return $this->Cle_Type; }

    /// Setteurs
    private function setCle($cle) { 
        // On vérifie que l'id est un nombre positif ou nul
        if($cle == null || !is_numeric($cle)) 
            throw new InvalideContratExceptions("La clé du contrat doit être un entier !");
        // On vérifie que l'id est un nombre positif ou nul
        elseif($cle < 0) 
            throw new InvalideContratExceptions("La clé du contrat doit être supéieure ou égale à 0 !");

        // On implémente    
        else $this->cle = $cle;
    }
    private function setDateDebut($date) { 
        // On vérifie que la date est un string
        if(!is_string($date))
            throw new InvalideContratExceptions('La date de début de contratdoit être saisie dans une chaine de caractères !');
        // On vérifie que $date est une date
        elseif(!Instants::isDate($date))
            throw new InvalideCandidatExceptions("La date de début de contrat doit être une date !");
        
        // On implémente 
        $this->date_debut = $date;
    }
    private function setDateFin($date) {
        // On vérifie que la date de début est un string
        if(empty($date))
            throw new InvalideContratExceptions('La date de fin de contrat doit être saisie !');
        // On vérifie que $date est une date
        elseif(!Instants::isDate($date))
            throw new InvalideCandidatExceptions("La date de fin de contrat doit être une date !");
        
        
        // On implémente 
        $this->date_fin = $date;
    }
    private function setSalaire($salaire) {
        // On vérifie que le salaire est un entier 
        if(!is_numeric($salaire))
            throw new InvalideContratExceptions('Le salaire doit être un entier !');
        // On vérifie que le salaire est non nul
        elseif(intval($salaire) <= 0)
            throw new InvalideContratExceptions('Le salaire ne peut pas être négatif ou nul !');

        // On implémente
        else $this->salaire = intval($salaire);
    }
    private function setDateDemission($date) {
        // On vérifie que la date de début est un string
        if(empty($date))
            throw new InvalideContratExceptions('La date de démission doit être saisie !');
        // On vérifie que $date est une date
        elseif(!Instants::isDate($date))
            throw new InvalideCandidatExceptions("La date de démission doit être une date !");
        
        
        // On implémente 
        $this->date_demission = $date;
    }
    private function setTravailNuit() {
        $this->travail_nuit = true;
    }
    private function setTravailWk() {
        $this->travail_wk = true;
    }
    private function setNbHeures($heures) {
        // On vérifie que le nombre d'heures est un entier
        if(!is_numeric($heures))
            throw new InvalideContratExceptions("Le taux horaires hebdomadaire doit être un entier !");
        // On vérifie que le nombre d'heures et non nul
        elseif($heures <= 0)
            throw new InvalidArgumentException("le taux horaires hebdomadaires ne peut pas être négatif ou nul !");

        else $this->nb_heures = $heures;
    }
    private function setSignature($signature) {
        // On vérifie que la siganture est une date 
        if($signature instanceof DateTime || Instants::isDate($signature))
            $this->signature = $signature;
        else 
            throw new Exception("La signature d'un contrat doit être une date !");
    }
    private function setCleCandidats($cle) {
        // On vérifie la présence d'une clé
        if($cle == null || !is_numeric($cle)) 
            throw new InvalideCandidatExceptions("La clé d'un candidat doit être un entier !");
        elseif($cle < 0)
            throw new InvalideCandidatExceptions("La clé d'un candidat doit être strictement positive !");

        // On implémente    
        else  $this->cle_candidats = $cle;
    }
    private function setCleInstants($cle) {
        // On vérifie la présence d'une clé
        if($cle == null || !is_numeric($cle)) 
            throw new InvalideCandidatExceptions("La clé d'un instants doit être un entier !");
        elseif($cle < 0)
            throw new InvalideCandidatExceptions("La clé d'un instants doit être strictement positive !");

        // On implémente    
        else  $this->cle_instants = $cle;
    }
    private function setCleServices($cle) {
        // On vérifie la présence d'une clé
        if($cle == null || !is_numeric($cle)) 
            throw new InvalideCandidatExceptions("La clé d'un service doit être un entier !");
        elseif($cle < 0)
            throw new InvalideCandidatExceptions("La clé d'un service doit être strictement positive !");

        // On implémente    
        else  $this->Cle_Services = $cle;
    }
    private function setClePostes($cle) {
        // On vérifie la présence d'une clé
        if($cle == null || !is_numeric($cle)) 
            throw new InvalideCandidatExceptions("La clé d'un poste doit être un entier !");
        elseif($cle < 0)
            throw new InvalideCandidatExceptions("La clé d'un poste doit être strictement positive !");

        // On implémente    
        else  $this->Cle_Postes = $cle;
    }
    private function setCleType($cle) {
        // On vérifie la présence d'une clé
        if($cle == null || !is_numeric($cle)) 
            throw new InvalideCandidatExceptions("La clé d'un type de contrats doit être un entier !");
        elseif($cle < 0)
            throw new InvalideCandidatExceptions("La clé d'un type de contrats doit être strictement positive !");

        // On implémente    
        else  $this->Cle_Type = $cle;
    }

    public function exportToSQL(): array {
        // On déclare le tableau de données
        $result = [
            "date debut" => $this->getDateDebut(),
            "signature" => $this->getSignature() != null ? $this->getSignature() : NULL,
            "cle candidat" => $this->getCleCandidats(),
            "cle instant" => $this->getCleInstants(),
            "cle service" => $this->getCleServices(),
            "cle poste" => $this->getClePostes(),
            "cle types" => $this->getCleType()
        ];
        
        // On ajoute les données optionnelles
        if($this->getCle() != null)
            $result['cle contrat'] = $this->getCle();
        if($this->getDateFin() != null)
            $result["date fin"] = $this->getDateFin();
        if($this->getSalaire() != null)
            $result['salaire'] = $this->getSalaire();
        if($this->getDateDemission() != null)
            $result['date demission'] = $this->getDateDemission();
        if($this->getTravailNuit())
            $result['travail nuit'] = $this->getTravailNuit();
        if($this->getTravailWk())
            $result['travail wk'] = $this->getTravailWk();
        if($this->getNbHeures() != null)
            $result['nb heures'] = $this->getNbHeures();
        

        // On retourne le tableau de données    
        return $result;
    }
}