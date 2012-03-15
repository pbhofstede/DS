<?php
include ('header.php');

if (empty($_GET['a'])) {
	redirect($config['url'].'/index/', 0);
} else {
	$information = InformationDB::getInformationByAfkorting($_GET['a']);
	if ($information != NULL) {
		echo '<h2>'.stripslashes($information->getNaam()).'</h2>';;
		echo stripslashes($information->getContent());
	} else {
		redirect($config['url'].'/index/', 0);
	}
}

include ('footer.php');
?>