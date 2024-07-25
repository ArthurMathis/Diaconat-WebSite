<?php

class alert_manipulation {
    static public function alert($infos=[]) {
        // On vérifie l'intégrité du message
        if($infos['msg'] instanceof Exception)
            $infos['msg'] = $infos['msg']->getMessage();

        // On vérifie l'intégrité du titre
        if(!isset($infos['title']))    
        $infos['title'] =  "Une erreur est survenue...";

        if(isset($infos['confirm']) && empty($infos['icon']))
            $infos['icon'] = 'question';

        // On vérifie l'intégrité du titre
        if(empty($infos['icon']) || !is_string($infos['icon']))
            $infos['icon'] = 'success';

        // On vérifie l'intégrité du bouton
        if(isset($infos['button']) && (empty($infos['text button']) || !is_string($infos['text button'])))
            $infos['text button'] = "Compris";


        // On lance l'alerte    
        include(COMMON.DS.'alert.php');
        exit;
    }
}