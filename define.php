<?php 

// On définit ROOT comme la racine du dossier
define('ROOT',dirname('.'));
// On utilise DS à la place du slash pour la redirection de fichiers
define('DS',DIRECTORY_SEPARATOR);

// On définit les chemins vers les sous-répertoires 
define('COMPONENTS', ROOT.DS.'components');
define('MODELS', COMPONENTS.DS.'models');
define('VIEWS', COMPONENTS.DS.'views');
define('CONTROLLERS', COMPONENTS.DS.'controllers');
define('CLASSE', MODELS.DS.'classe');

// On définit le chemin vers le sous-répertoire de page web
define('LAYOUTS', ROOT.DS.'layouts');
define('ASSETS', LAYOUTS.DS.'assets');
define('FORMULAIRES', LAYOUTS.DS.'formulaires');
define('STYLESHEET', ASSETS.DS.'stylesheet');
define('IMG', ASSETS.DS.'img');

// Utile ?
define('LOG', 'log');

// On charge le contenu du fichier .env
function env_start() {
    $env = parse_ini_file('.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}