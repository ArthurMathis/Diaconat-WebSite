<?php 

require_once('define.php');
require_once(COMPONENTS.DS.'AlertManipulation.php');

include(COMMON.DS.'entete.php');

alert_manipulation::alert([
    'title' => "Information",
    'msg' => "Hello, ton mot de passe est <b>Mart-123</b>. Note-le et ne l'oublie pas !",
    'direction' => 'index.php',
    'confirm' => true
]);

include(COMMON.DS.'footer.php');