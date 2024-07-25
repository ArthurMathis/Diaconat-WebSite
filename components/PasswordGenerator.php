<?php

class PasswordGenerator {
    /// tableaux de caractères utilisés pour la génération de mots de passe
    static public $majuscule = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    static public $minuscule = 'abcdefghijklmnopqrstuvwxyz';
    static public $chiffres = '0123456789';
    static public $special = '!@#$%&*()_+-={}[]:;,.?~';

    public static function random_password(): string {
        $all = PasswordGenerator::$majuscule .PasswordGenerator::$minuscule . PasswordGenerator::$chiffres;

        // Initialiser le mot de passe avec au moins un de chaque type requis
        $password = '';
        $password .= PasswordGenerator::$majuscule[rand(0, strlen(PasswordGenerator::$majuscule) - 1)];
        $password .= PasswordGenerator::$minuscule[rand(0, strlen(PasswordGenerator::$minuscule) - 1)];
        $password .= PasswordGenerator::$chiffres[rand(0, strlen(PasswordGenerator::$chiffres) - 1)];
        $password .= PasswordGenerator::$special[rand(0, strlen(PasswordGenerator::$special) - 1)];

        // Ajouter des caractères aléatoires jusqu'à atteindre la longueur minimale de 8
        for ($i = 4; $i <= 12; $i++) {
            $password .= $all[rand(0, strlen($all) - 1)];
        }

        // Mélanger les caractères pour assurer un mot de passe aléatoire
        $password = str_shuffle($password);

        return $password;
    }
    // public static function random_password(&$name, &$first_name): ?string {
    //     if(!is_string($name) || !is_string($first_name)) {
    //         throw new Exception('Erreur lors de la génération du mot de passe standart. Le nom et le prénom doivent être des chaines de caractères !');
    //         return null;
    //     }
    //     
    //     $temp = str_split($first_name, 1);
    //     return strtoupper(str_split($name, 1)[0]) . strtolower($temp[0]) . strtolower($temp[1]) . strtolower($temp[2]) . '-123';
    // }
}