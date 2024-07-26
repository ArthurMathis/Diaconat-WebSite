<?php

class alert_manipulation {
    /**
     * Supprime les retours à la ligne dans une chaîne de caractères.
     *
     * @param string $string La chaîne de caractères à traiter.
     * @return string La chaîne de caractères sans retours à la ligne.
     */
    static private function removeNewLines(string $string): string {
        // Remplace les caractères de nouvelle ligne par une chaîne vide
        return str_replace(["\r", "\n", "\r\n"], '<br>', $string);
    } 
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