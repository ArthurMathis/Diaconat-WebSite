<?php

class forms_manip {
    public static function error_alert($msg) {
        if(empty($msg))
            $msg = "Une erreur est survenue";

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
        echo "1 : " . $str[0] . '<br>';

        // On met les lettres suivant en minuscule
        $size = count($str);
        for($i = 1; $i < $size; $i++) {
            $str[$i] = strtolower($str[$i]);
            echo $i + 1 . " : " . $str[$i] . '<br>';
        } 
            

        // On retourne la chaine concaténée
        $str = implode('', $str);
        echo "Résultat du formatage : " . $str . '<br>';

        return $str;
}
}