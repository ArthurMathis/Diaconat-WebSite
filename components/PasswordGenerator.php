<?php

class PasswordGenerator {
    static private $majuscule = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    static private $minuscule = 'abcdefghijklmnopqrstuvwxyz';
    static private $chiffres = '0123456789';
    
    static public function random_mot_de_passe(): string {
        // Définir les ensembles de caractères
        $all = PasswordGenerator::$majuscule . PasswordGenerator::$minuscule . PasswordGenerator::$chiffres;

        // Initialiser le mot de passe avec au moins un de chaque type requis
        $password = '';
        $password .= PasswordGenerator::$majuscule[rand(0, strlen(PasswordGenerator::$majuscule) - 1)];
        $password .= PasswordGenerator::$minuscule[rand(0, strlen(PasswordGenerator::$minuscule) - 1)];
        $password .= PasswordGenerator::$chiffres[rand(0, strlen(PasswordGenerator::$chiffres) - 1)];

        // Ajouter des caractères aléatoires jusqu'à atteindre la longueur minimale de 8
        for ($i = 4; $i <= 8; $i++) 
            $password .= $all[rand(0, strlen($all) - 1)];

        // Mélanger les caractères pour assurer un mot de passe aléatoire
        return str_shuffle($password);
    }
}