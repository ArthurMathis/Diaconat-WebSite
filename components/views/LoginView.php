<?php

class TransfertView extends View
{
    public function getContent() {
        $this->generateCommonHeader();
        include LAYOUTS.DS.'login.php';
        $this->generateCommonFooter();
    }
}