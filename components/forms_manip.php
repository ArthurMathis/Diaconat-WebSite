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
    // public static function numberFormat($number): ?string {
    //     // On test la présence de données
    //     if(empty($number))
    //         return null;
    // 
    //     // On convertit en chaine de caractère si nécessaire 
    //     if(is_int($number))
    //         $number = strval($number);
    // 
    //     // On vérifie l'intégrité des données 
    //     if(!is_string($number))
    //         return null;
    // 
    //     // On prépare la chaine de caractères aux traitements
    //     $number = str_split(trim($number));
    // 
    //     // On déclare les variables temporaires    
    //     $temp = [$number[0]];
    //     $size = count($number);
    //     // On construit le nouveau tableau
    //     for($i = 1; $i < $size; $i++) {
    //         // On ajoute un point de séparation entre les numéros
    //         if($i % 2 == 0)
    //             array_push($temp, '.');
    // 
    //         // On ajoute le numéro    
    //         array_push($temp, $number[$i]);
    //     }
    //        
    //     // On retourne le résultat en chaine de caractères
    //     return implode('', $temp);
    // }
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