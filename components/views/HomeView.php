<?php

require_once 'View.php';

class HomeView extends View {
    public function getContent() {
        $this->generateCommonHeader();
        include LAYOUTS.DS.'nav_barre.php';
        $this->generateCommonFooter();
    }

}