<?php
include ('header.php');
echo '<h1>Mijn spelers</h1>';
echo 'Hieronder alle Nederlandse spelers uit jouw team die in de database zijn toegevoegd.<br />';
echo 'Alle spelers kunnen individueel bekeken worden. Hier kan, indien aanwezig, ook informatie van de scout opgenomen zijn.';
echo '<h2>Spelers</h2>';

if ($user != NULL) {
	$players	=	$user->getPlayers();
}
else {
  $players = NULL;
}

if($players != NULL) {
	echo '<table width="100%" class="list">';
		echo '<tr>';
			echo '<th colspan="3">Spelers</th>';
		echo '</tr>';
		echo '<tr class="niveau1">';
			echo '<td>'.$language['ID'].'</td>';
			echo '<td>'.$language['player'].'</td>';
			echo '<td>'.$language['age'].'</td>';
		echo '</tr>';
		foreach($players AS $player) {
			echo '<tr onClick="top.location=\''.$config['url'].'/myPlayer/'.$player->getId().'/\'">';
				echo '<td>'.output($player->getId()).'</td>';
				echo '<td>'.output($player->getName()).'</td>';
				echo '<TD>'.$player->getLeeftijdStr().'</TD>';
			echo '</tr>';
		}
	echo '</table>';
} 
else {
	if ($user != NULL) {
		echo 'Geen spelers aanwezig.';
	}
	else {
		redirect($config['url'].'/', 0);
	}
}
include ('footer.php');
?>
