<?php

/**
 * Class creating random password
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class PasswordGenerator {
    /**
     * Public static string with uppercase letters of the alphabet
     *
     * @var string The string
     */
    static public $majuscule = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    /**
     * Public static string with lowercase letters of the alphabet
     *
     * @var string The string
     */
    static public $minuscule = 'abcdefghijklmnopqrstuvwxyz';
    /**
     * Public static string with numbers
     *
     * @var string The string
     */
    static public $chiffres = '0123456789';
    /**
     * Public static string with special caracters
     *
     * @var string The string
     */
    static public $special = '!@-_?#';


    /**
     * Public static method generating a random password
     *
     * @return string The new password
     */
    public static function random_password(): string {
        $all = PasswordGenerator::$majuscule .PasswordGenerator::$minuscule . PasswordGenerator::$chiffres;

        // On initialise le mot de passe avec au moins un de chaque type requis
        $password = '';
        $password .= PasswordGenerator::$majuscule[rand(0, strlen(PasswordGenerator::$majuscule) - 1)];
        $password .= PasswordGenerator::$minuscule[rand(0, strlen(PasswordGenerator::$minuscule) - 1)];
        $password .= PasswordGenerator::$chiffres[rand(0, strlen(PasswordGenerator::$chiffres) - 1)];
        $password .= PasswordGenerator::$special[rand(0, strlen(PasswordGenerator::$special) - 1)];

        // On joute des caractères aléatoires jusqu'à atteindre la longueur minimale de 8
        for ($i = 4; $i <= 8; $i++) {
            $password .= $all[rand(0, strlen($all) - 1)];
        }

        // On mélange les caractères pour assurer un mot de passe aléatoire
        return str_shuffle($password);
    }
}