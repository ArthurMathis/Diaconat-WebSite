<?php

require_once 'View.php';

class HomeView extends View {
    public function getContent() {
        $this->generateCommonHeader('Diaconat Web Site - Welcome', ["layouts\assets\stylesheet\index.css"]);
        include LAYOUTS.DS.'nav_barre.php';
        $this->generateCommonFooter();
    }
}