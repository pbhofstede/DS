<?php
session_start(); // initialize session

unset($_SESSION['DUTCHSCOUTS']);
unset($_SESSION['DUTCHSCOUTSNAME']);
unset($_SESSION['dutchscoutsSC']);
						
session_destroy(); // destroy session

if ($_SERVER["SERVER_NAME"] == 'web.dutchscouts.nl') {
	$url =	'http://web.dutchscouts.nl/';
} 
else if ($_SERVER["SERVER_NAME"] == 'scan.dutchscouts.nl') {
	$url =	'http://scan.dutchscouts.nl/';
} 
else if ($_SERVER["SERVER_NAME"] == 'localhost') {
	$url =	'http://localhost/dutchscouts/web/';
}
else {
  $url =	'http://www.dutchscouts.nl/';
}

header("Location: ".$url);
?>