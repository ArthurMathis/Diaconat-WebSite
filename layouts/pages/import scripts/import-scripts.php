<?php 
if(empty($scripts)) 
    exit;

foreach($scripts as $s)
    echo '<script src="' . JAVASCRIPT.DS.$s . '"></script>';