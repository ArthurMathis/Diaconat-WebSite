<?php 

require_once('define.php');
require_once(COMPONENTS.DS.'forms_manip.php');

$str = "123467890";
$number = 1234567890;

var_dump($str); 
echo "<br>" . forms_manip::numberFormat($str) . "<br>";
var_dump($number); 
echo "<br>" . forms_manip::numberFormat($number);
