<?php

class PasswordGenerator {
        public static function random_password(&$name, &$first_name): ?string {
        if(!is_string($name) || !is_string($first_name)) {
            throw new Exception('Erreur lors de la génération du mot de passe standart. Le nom et le prénom doivent être des chaines de caractères !');
            return null;
        }
        
        $temp = str_split($first_name, 1);
        return strtoupper(str_split($name, 1)[0]) . strtolower($temp[0]) . strtolower($temp[1]) . strtolower($temp[2]) . '-123';
    }
}