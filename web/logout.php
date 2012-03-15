<?php
include ('header.php');
session_destroy();
redirect($config['url']);
include ('footer.php');
?>
