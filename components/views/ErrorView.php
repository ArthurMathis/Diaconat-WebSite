<?php

require_once('View.php');

class ErrorView extends View {
    public function getErrorContent($e) {
        $this->generateCommonHeader();
        echo "<style>body {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--padding);
        
            width: 100dvw;
            height: 100dvh;
        }
        h2 {
            margin-top: 37.5dvh;
        }
        p {
            max-width: 50dvw;
        }</style>";
        echo "<h2>Il semblerait d'une erreur se soit produite...</h2>";
        if($e instanceof Exception && $e != null)
            echo "<p>".$e->getMessage()."</p>";
        $this->generateCommonFooter();
    }
}