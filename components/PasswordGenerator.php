<?php

class PasswordGenerator {
    /// tableaux de caractères utilisés pour la génération de mots de passe
    static public $majuscule = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    static public $minuscule = 'abcdefghijklmnopqrstuvwxyz';
    static public $chiffres = '0123456789';
    static public $special = '!@-_?#';

    public static function random_password(): string {
        $all = PasswordGenerator::$majuscule .PasswordGenerator::$minuscule . PasswordGenerator::$chiffres;

        // Initialiser le mot de passe avec au moins un de chaque type requis
        $password = '';
        $password .= PasswordGenerator::$majuscule[rand(0, strlen(PasswordGenerator::$majuscule) - 1)];
        $password .= PasswordGenerator::$minuscule[rand(0, strlen(PasswordGenerator::$minuscule) - 1)];
        $password .= PasswordGenerator::$chiffres[rand(0, strlen(PasswordGenerator::$chiffres) - 1)];
        $password .= PasswordGenerator::$special[rand(0, strlen(PasswordGenerator::$special) - 1)];

        // Ajouter des caractères aléatoires jusqu'à atteindre la longueur minimale de 8
        for ($i = 4; $i <= 8; $i++) {
            $password .= $all[rand(0, strlen($all) - 1)];
        }

        // Mélanger les caractères pour assurer un mot de passe aléatoire
        $password = str_shuffle($password);

        return $password;
    }
}