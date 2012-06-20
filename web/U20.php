<?php
include ('header.php');

if ($user != Null) {
  
	$scouting	=	$user->getScout();
	
	if (($scouting != NULL) or
			($user->getRank() == 'administrator') or 
			($user->getRank() == 'bc')) {
		if (isset($_GET['NEW'])) {
			$newPlayers = '<b>('.$_GET['NEW'].' nieuwe spelers)</b>';
		}

		echo '<h2>U20 spelers te koop</h2>';
		echo' <form action="" method="POST">';
			echo '<input name="submit" type="submit" id="submit" value="Voeg toe"> '.$newPlayers;
		echo '</form>';

		if($_POST['submit']) {
			redirect($config['url'].'/getNTPlayerInfo.php?NT=0&Callback='.$config['url'].'/U20/');
		}

		echo'<h3>De spelers</h3>';	
		$U20PlayersList		=	NationalPlayersDB::getU20PlayersList();
		if($U20PlayersList != NULL) {
			echo '<table width=100%>';
				echo '<tr align="center" class="niveau2">';
					echo '<td align="left">Naam</td>';
					echo '<td align="left">PlayerID</td>';
					echo '<td align="left">Land</td>';
					echo '<td>Leeftijd</td>';
					echo '<td>TSI</td>';
					echo '<td>Loon</td>';
					echo '<td>Inj</td>';
					echo '<td>vorm</td>';
					echo '<td>sta</td>';
					echo '<td>gk</td>';
					echo '<td>def</td>';
					echo '<td>pm</td>';
					echo '<td>wng</td>';
					echo '<td>pas</td>';
					echo '<td>sc</td>';
					echo '<td>sp</td>';
					echo '<td>spec</td>';
					echo '<td>xp</td>';
					echo '<td>ls</td>';
					echo '<td>NT</td>';
					echo '<td>U20</td>';
					echo '<td>update</td>';
				echo '</tr>';
		 
				foreach($U20PlayersList AS $nationalPlayers) {
					echo '<tr align="left">';
						echo '<td>'.$nationalPlayers->getPlayer().'</td>';
						echo '<td>'.$nationalPlayers->getId().'</td>';
						echo '<td>'.$nationalPlayers->getCountry().'</td>';
						echo '<td align="center">'.$nationalPlayers->getAge().'</td>';
						echo '<td align="center">'.$nationalPlayers->getTsi().'</td>';
						echo '<td align="right">'.$nationalPlayers->getWage().'</td>';
						echo '<td align="center">'.$nationalPlayers->getInjury().'</td>';
						echo '<td align="center" bgcolor="#CCCCCC">'.$nationalPlayers->getForm().'</td>';
						echo '<td align="center">'.$nationalPlayers->getStamina().'</td>';
						echo '<td align="right" bgcolor="#CCCCCC">'.$nationalPlayers->getKeeper().'</td>';
						echo '<td align="right">'.$nationalPlayers->getDefender().'</td>';
						echo '<td align="right" bgcolor="#CCCCCC">'.$nationalPlayers->getPlaymaker().'</td>';
						echo '<td align="right">'.$nationalPlayers->getWinger().'</td>';
						echo '<td align="right" bgcolor="#CCCCCC">'.$nationalPlayers->getPassing().'</td>';
						echo '<td align="right">'.$nationalPlayers->getScorer().'</td>';
						echo '<td align="right" bgcolor="#CCCCCC">'.$nationalPlayers->getSetPieces().'</td>';
						echo '<td align="center">'.$nationalPlayers->getSpec().'</td>';
						echo '<td align="right" bgcolor="#CCCCCC">'.$nationalPlayers->getXp().'</td>';
						echo '<td align="right">'.$nationalPlayers->getLs().'</td>';
						echo '<td align="center" bgcolor="#CCCCCC">'.$nationalPlayers->getCaps().'</td>';
						echo '<td align="center">'.$nationalPlayers->getCapsU20().'</td>';
						echo '<td>'.date("d-m-y", $nationalPlayers->getTimestamp()).'</td>';
					echo '</tr>';
				}
			echo'</table>';
		} else {
			echo 'Geen spelers aangetroffen!';
		}
	}
	else {
	  echo 'Geen rechten';
	}
}
else {
	redirect($config['url'].'/', 0);
}
include ('footer.php');	
?>