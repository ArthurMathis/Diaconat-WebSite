<?php

class forms_manip {
    public static function error_alert($msg) {
        if(empty($msg))
            $msg = "Une erreur est survenue";
        elseif($msg instanceof Exception)    
            $msg = $msg->getMessage();

        echo "<script>window.history.back(); alert(\"" . $msg . "\");</script>";
        exit;
    }
    
    public static function nameFormat($str): string {
        if(!is_string($str))
            throw new Exception("Le formatage d'un nom doit se réaliser sur une chaine de caractères. ");

        return ucwords(strtolower($str));
    }

    public static function numberFormat($number): ?string {
        // Vérifier si la chaîne est null ou vide
        if (is_null($number) || empty($number)) 
            throw new InvalidArgumentException("Le numéro de téléphone est vide ou non défini.");
        
    
        // On supprime tous les caractères non numériques
        $number = preg_replace('/\D/', '', $number);
    
        // On vérifie la longueur du numéro
        if (strlen($number) > 10) 
            throw new InvalidArgumentException("Le numéro de téléphone est trop long.");   
    
        // On ajoute des zéros devant si nécessaire pour obtenir 10 chiffres
        $number = str_pad($number, 10, '0', STR_PAD_LEFT);
        return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1.$2.$3.$4.$5', $number);         
    }
    
    static public function majusculeFormat($str) {
        if(!is_string($str))
        throw new Exception("Le formatage d'un nom doit se réaliser sur une chaine de caractères. ");

        // Convertit les caractères accentués en caractères non accentués et en majuscule
        return strtoupper(preg_replace('/[^A-Za-z0-9\- ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str)));
    }
}