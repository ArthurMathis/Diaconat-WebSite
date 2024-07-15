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
define('PAGES', LAYOUTS.DS.'pages');

// Les composants HTML
define('BARRES', PAGES.DS.'barres');
define('COMMON', PAGES.DS.'common');
define('FORMULAIRES', PAGES.DS.'formulaires');
define('MY_ITEMS', PAGES.DS.'my items');
define('SCRIPTS', PAGES.DS.'import scripts');

// Les sources
define('STYLESHEET', ASSETS.DS.'stylesheet');
define('IMG', ASSETS.DS.'img');
define('LOGO', IMG.DS.'logo');

// Les feuilles de styles
define('FORMS_STYLES', STYLESHEET.DS.'formulaires');
define('PAGES_STYLES', STYLESHEET.DS.'pages');

// Les scripts
define('JAVASCRIPT','layouts/assets/scripts/');

// On charge le contenu du fichier .env
function env_start() {
    $env = parse_ini_file('.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}