<?php

class alert_manipulation {
    static public function alert($msg, $title=null, $icon=null, $button=null, $direction=null) {
        // On vérifie l'intégrité du message    
        if(empty($msg))
            $msg = "Une erreur est survenue";
        elseif($msg instanceof Exception)    
            $msg = $msg->getMessage();

        // On vérifie l'intégrité du titre
        if(empty($title) || !is_string($title))
            $title = "Une erreur est survenue.";

        // On vérifie l'intégrité de l'icon
        if(empty($icon) || !is_string($icon))   
            $icon = "success";

        // On vérifie l'intégrité du bouton
        if(empty($button) || !is_string($button))   
            $button = "Compris";

        include(COMMON.DS.'alert.php');    
    }
}