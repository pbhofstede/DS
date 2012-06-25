<?php
include ('header.php');
session_destroy();
$_SESSION['dutchscouts'] = Null;
redirect($config['url']);
//include ('footer.php');
?>
