<?php

class View {
    public function generateCommonHeader($name=null, $cssFiles = []) {
        include LAYOUTS.DS.'entete.php';
    }

    public function generateCommonFooter() {
        include LAYOUTS.DS.'footer.php';
    }
}