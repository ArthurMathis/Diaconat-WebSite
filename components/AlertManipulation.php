<?php

/**
 * Class manipulating notification
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class alert_manipulation {
    /**
     * Private static method deleting line break in a string
     *
     * @param string $string The string
     * @return string La chaîne The string without line break
     */
    static private function removeNewLines(string $string): string {
        return str_replace(["\r", "\n", "\r\n"], '<br>', $string);
    } 

    /**
     * Public static method creating a notification (Javascript : SweetAlert2.js)
     *
     * @param array $infos The notiication data array 
     * @return void
     */
    static public function alert($infos=[]) {
        // On vérifie l'intégrité du message
        if($infos['msg'] instanceof Exception)
            $infos['msg'] = $infos['msg']->getMessage();
        $infos['msg'] = alert_manipulation::removeNewLines($infos['msg']);

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
        include(COMMON.DS.'entete.php');
        include(COMMON.DS.'alert.php');
        include(COMMON.DS.'footer.php');
        exit;
    }
}