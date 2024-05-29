<?php

class View {
    public function generateCommonHeader($name=null) {
        return LAYOUTS.'entete.php';
    }

    public function generateCommonFooter() {
        return LAYOUTS.DS.'footer.php';
    }
}