<?php 

require_once ("../components/connect_server.php");
require_once ("../objects/Utilisateurs.php");

global $bdd;

$user = new Utilisateurs("mathis.a", "arthur.mathis@diaconat-mulhouse.fr", "Arthur2003", "Administrateur");
$user->searchCle($bdd);
echo "Clé : " . $user->getCle();

?>