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
    
    public static function nameFormat($str): ?string {
        if(empty($str))
            return null; 

        // On prépare la chaine de caractères aux traitements
        $str = str_split(trim($str));

        // On met la première lettre en majuscule
        $str[0] = strtoupper($str[0]);

        // On met les lettres suivant en minuscule
        $size = count($str);
        for($i = 1; $i < $size; $i++) 
            $str[$i] = strtolower($str[$i]);

        // On retourne la chaine concaténée
        return implode('', $str);
    }
    public static function numberFormat($number): ?string {
        // On test la présence de données
        if(empty($number))
            return null;

        // On convertit en chaine de caractère si nécessaire 
        if(is_int($number))
            $number = strval($number);

        // On vérifie l'intégrité des données 
        if(!is_string($number))
            return null;

        // On prépare la chaine de caractères aux traitements
        $number = str_split(trim($number));

        // On déclare les variables temporaires    
        $temp = [$number[0]];
        $size = count($number);
        // On construit le nouveau tableau
        for($i = 1; $i < $size; $i++) {
            // On ajoute un point de séparation entre les numéros
            if($i % 2 == 0)
                array_push($temp, '.');

            // On ajoute le numéro    
            array_push($temp, $number[$i]);
        }
           
        // On retourne le résultat en chaine de caractères
        return implode('', $temp);
    }
}