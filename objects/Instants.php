<?php

class InvalideInstantExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

class Instants {
    private $date, $heure;

    public function __construct($date, $heure) {
        $this->setDate($date);
        $this->setHeure($heure);
    }

    public function getDate(){ return $this->date; }
    public function getHeure(){ return $this->heure; }

    private function setDate($date){
        // On vérifie que le nom est non-vide
        if(empty($date))
            throw new InvalideInstantExceptions("La date ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!self::isDate($date))
            throw new InvalideInstantExceptions("La date doit être au format 'Y-m-d' !");
        // On implémente
        else $this->date = $date;
    }
    private function setHeure($heure){
        // On vérifie que l'heure n'est pas vide
        if(empty($heure))
            throw new InvalideInstantExceptions("L'heure ne peut être vide !");
        // On vérifie que l'heure est au format hh:mm:ss
        elseif(!self::isHeure($heure))
            throw new InvalideInstantExceptions("L'heure doit être au format 'hh:mm:ss' !");
        // On implémente
        else $this->heure = $heure;
    }

    public static function isDate($dateString, $format = 'Y-m-d') {
        $dateTime = DateTime::createFromFormat($format, $dateString);
        return $dateTime && $dateTime->format($format) === $dateString;
    }
    public static function isHeure($heureString, $format = 'H:i:s') {
        // On crée un objet DateTime à partir de l'heure donnée et du format
        $dateTime = DateTime::createFromFormat($format, $heureString);
        // On vérifie si l'objet DateTime a été créé avec succès et si l'heure correspond au format donné
        return $dateTime && $dateTime->format($format) === $heureString;
    }

    public static function currentInstants() {
        // On crée un objet DateTime représentant la date et l'heure actuelle
        $now = new DateTime('now', new DateTimeZone('UTC'));
        
        // On récupère la date au format 'Y-m-d' et l'heure au format 'H:i:s'
        $date = $now->format('Y-m-d');
        $heure = $now->format('H:i:s');
    
        // On crée un nouvel objet Instants avec la date et l'heure actuelles
        return new Instants($date, $heure);
    }
    public function exportToSQL(){
        return [
            "Jour" => $this->getdate(), 
            "Heure" => $this->getHeure()
        ];
    }
}