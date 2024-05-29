<?php

require_once 'View.php';

class LoginView extends View {
    public function getContent() {
        $this->generateCommonHeader();
        include LAYOUTS.DS.'login.php';
        $this->generateCommonFooter();
    }
}