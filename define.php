<?php 

// On définit ROOT comme la racine du dossier
define('ROOT',dirname('.'));
// On utilise DS à la place du slash pour la redirection de fichiers
define('DS',DIRECTORY_SEPARATOR);

// On définit les chemins vers les sous-répertoires php
define('COMPONENTS', ROOT.DS.'components');
define('MODELS', COMPONENTS.DS.'models');
define('VIEWS', COMPONENTS.DS.'views');
define('CONTROLLERS', COMPONENTS.DS.'controllers');
define('CLASSE', MODELS.DS.'classe');

// On définit le chemin vers les ressources
define('LAYOUTS', ROOT.DS.'layouts');
define('ASSETS', LAYOUTS.DS.'assets');

// Les composants HTML
define('BARRES', LAYOUTS.DS.'barres');
define('COMMON', LAYOUTS.DS.'common');
define('FORMULAIRES', LAYOUTS.DS.'formulaires');
define('MY_ITEMS', LAYOUTS.DS.'my items');
define('SCRIPTS', LAYOUTS.DS.'scripts');

// Les feuilles de styles
define('STYLESHEET', ASSETS.DS.'stylesheet');
define('FORMS_STYLES', STYLESHEET.DS.'formulaires');
define('PAGES_STYLES', STYLESHEET.DS.'pages');

// Les images
define('IMG', ASSETS.DS.'img');

// Les scripts
define('JAVASCRIPT', ASSETS.DS.'scripts');
define('JAVASCRIPT_OBJ', JAVASCRIPT.DS.'objects');

// On charge le contenu du fichier .env
function env_start() {
    $env = parse_ini_file('.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}