<?php
include ('header.php');
//Array
$trainingArray['1']		=	'keepen';
$trainingArray['2']		=	'verdedigen';
$trainingArray['3']		=	'controlerendspel';
$trainingArray['4']		=	'vleugelspel';
$trainingArray['5']		=	'vleugelaanval';
$trainingArray['6']		=	'positiespel';
$trainingArray['7']		=	'scoren';
$trainingArray['8']		=	'schieten';			
$trainingArray['9']		=	'kortepass';
$trainingArray['10']	=	'openingenmaken';
$trainingArray['11']	=	'spelhervatting';

if ($user != NULL) {
	if(!empty($_GET['a'])) {
		$player		=	PlayerDB::getPlayer($_GET['a']);
		//Als een speler geselecteerd
		if($player != NULL && $player->getCoach()->getTeamid() == $user->getTeamid()) {
			echo '<h1>'.$player->getName().'</h1>';
			// Speler gegevens
			echo '<table width="100%">';
				echo '<tr>';
				
				if (! $player->getU20()) {
					$indexScoutName = $player->getBestIndexScoutName();
					$mijnPositie = PlayerDB::getScoutPosition($player->getID(), $player->getU20(), $indexScoutName);
				
					echo '<th colspan="2">'.$player->getName().' '.$indexScoutName.': '.$player->getBestIndexScout().' Positie: '.$mijnPositie.'</th>';
				}
				else {
					echo '<th colspan="2">'.$player->getName().'</th>';
				}
				echo '</tr>';
				echo '<tr class="niveau1">';
					echo '<td colspan="2">Speler gegevens</td>';
				echo '</tr>';
				echo '<tr class="none">';
					echo '<td width="50%" valign="top">';
						echo 'Speler ID: '.$player->getId().'<br />';
						echo 'Speler: '.$player->getName().'<br />';
						if($player->getCoach() != NULL) {
							echo 'Eigenaar: '.$player->getCoach()->getTeamname().' ('.$player->getCoach()->getTeamid().')<br /><br />';
						} else {
							echo 'Eigenaar: onbekend<br /><br />';
						}
						$cur_time = (floor(time() / 86400)) * 86400;	
						echo 'Leeftijd: '.$player->getLeeftijdStr().'<br />';
						echo 'TSI: '.$player->getTsi().'<br />';
						echo 'Salaris: '.round($player->getSalary() / 10).' &euro;<br />';
						echo $specs[$player->getSpeciality()].'<br />';
						echo 'Vorm: '.getSkillLevel($player->getForm()).'<br />';
						echo 'Conditie: '.getSkillLevel($player->getStamina());
					echo '</td>';
					echo '<td width="50%" valign="top">';
						echo 'Keepen: '.getSkillLevel($player->getKeeper()).' ('.$player->getKeeper().'/20)<br />';
						echo 'Verdedigen: '.getSkillLevel($player->getDefender()).' ('.$player->getDefender().'/20)<br />';
						echo 'Positiespel: '.getSkillLevel($player->getPlaymaker()).' ('.$player->getPlaymaker().'/20)<br />';
						echo 'Vleugelspel: '.getSkillLevel($player->getWinger()).' ('.$player->getWinger().'/20)<br />';
						echo 'Passen: '.getSkillLevel($player->getPassing()).' ('.$player->getPassing().'/20)<br />';
						echo 'Scoren: '.getSkillLevel($player->getScorer()).' ('.$player->getScorer().'/20)<br />';
						echo 'Spelhervatting: '.getSkillLevel($player->getSetPieces()).' ('.$player->getSetPieces().'/20)<br /><br />';
						echo 'Toegevoegd op: '.date('d-m-Y', $player->getAdded()).'<br />';
						echo 'Laatste update: '.date('d-m-Y', $player->getLastupdate());
					echo '</td>';
				echo '</tr>';
			echo '</table>';
			// Spelertraining 
			if(empty($_GET['b'])) {
				echo '<table width="100%">';
					echo '<tr class="niveau1">';
						echo '<td colspan="10">Training geschiedenis</td>';
					echo '</tr>';
					echo '<tr class="niveau2">';
						echo '<td>Van</td>';
						echo '<td>Tot</td>';
						echo '<td>Training</td>';
						echo '<td>TI%</td>';
						echo '<td>Conditie %</td>';
						echo '<td>Assistenten</td>';
						echo '<td>Fysios</td>';
						echo '<td>Training gemist</td>';
						echo '<td>Opmerking</td>';
						echo '<td>&nbsp;</td>';
					echo '</tr>';
		
					$trainingList	=	$user->getTraining();
					if($trainingList != NULL) {
						foreach($trainingList AS $training) {
							$playerTraining	=	PlayerTrainingDB::getPlayerTrainingByTraining($training->getId(), $player->getId());
								echo '<tr>';
									echo '<td>'.date('d-m-Y', $training->getVan()).'</td>';
									echo '<td>'.date('d-m-Y', $training->getTot()).'</td>';
									echo '<td>'.$trainingArray[$training->getTraining()].'</td>';
									echo '<td>'.$training->getTi().'</td>';
									echo '<td>'.$training->getConditie().'</td>';
									echo '<td>'.$training->getAssistenten().'</td>';
									echo '<td>'.$training->getFysios().'</td>';
									if($playerTraining != NULL) {
										echo '<td>'.$playerTraining->getGemist().'</td>';
										echo '<td>'.$playerTraining->getOpmerking().'</td>';
									} else {
										echo '<td colspan="2">Geen informatie beschikbaar</td>';
									}
									echo '<td><a href="'.$config['url'].'/myPlayer/'.$player->getId().'/'.$training->getId().'/"><img src="'.$config['url'].'/images/edit.png"/></a></td>';
								echo '</tr>';
						}
					} else {
						echo '<tr><td colspan="10">Training niet aanwezig</td></tr>';
					}
				echo '</table>';
				echo '<span style="float: right"><a href="'.$config['url'].'/myTraining/">Training toevoegen</a></span><br />';
			} else {
			// Spelertraining aanpassen
				$training	=	$user->getTrainingByIdAndCoach($_GET['b']);
				if($training != NULL) {
					$playerTraining	=	PlayerTrainingDB::getPlayerTrainingByTraining($training->getId(), $player->getId());
					if($playerTraining != NULL) { 
						$playerTrainingInfo = 1;
					} else {
						$playerTrainingInfo = 0;
					}
						
					echo '<table width="100%">';
					echo '<form action="" method="POST">';
						echo '<tr>';
							echo '<td colspan="10" style="padding: 3px; background-color: #999999; color: white; font-weight:bold">Training bewerken</td>';
						echo '</tr>';
						echo '<tr style="background-color: #CCCCCC; font-weight:bold">';
							echo '<td>Van</td>';
							echo '<td>Tot</td>';
							echo '<td>Training</td>';
							echo '<td>TI%</td>';
							echo '<td>Conditie %</td>';
							echo '<td>Assistenten</td>';
							echo '<td>Fysios</td>';
							echo '<td>Training gemist</td>';
							echo '<td>Opmerking</td>';
							echo '<td>&nbsp;</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.date('d-m-Y', $training->getVan()).'</td>';
							echo '<td>'.date('d-m-Y', $training->getTot()).'</td>';
							echo '<td>'.$trainingArray[$training->getTraining()].'</td>';
							echo '<td>'.$training->getTi().'</td>';
							echo '<td>'.$training->getConditie().'</td>';
							echo '<td>'.$training->getAssistenten().'</td>';
							echo '<td>'.$training->getFysios().'</td>';
							if($playerTrainingInfo == 1) {
								echo '<td><input name="gemist" type="text" value="'.$playerTraining->getGemist().'" size="1" /></td>';
							} else {
								echo '<td><input name="gemist" type="text" value="'.$_POST['gemist'].'" size="1" /></td>';
							}
							if($playerTrainingInfo == 1) {
								echo '<td><input name="opmerking" type="text" value="'.$playerTraining->getOpmerking().'" size="15" /></td>';
							} else {
								echo '<td><input name="opmerking" type="text" value="'.$_POST['opmerking'].'" size="15" /></td>';
							}
							echo '<td><input type="submit" name="verander" value="Verander" /></td>';
						echo '</tr>';
					echo '</form>';
					echo '</table>';
					echo '<span style="float: right"><a href="'.$config['url'].'/myTraining/'.$_GET['b'].'/">Complete training bewerken</a></span><br />';
					echo '<span style="float: right"><a href="'.$config['url'].'/myPlayer/'.$player->getId().'/">Terug naar '.$player->getName().'</a></span><br />';
					
					if($_POST['verander']) {
						if(!ctype_digit($_POST['gemist'])) {
							echo '<div class="error">De gemiste training moet een geheel getal zijn.</div>';
						} else {
							if($playerTrainingInfo == 1) {
								PlayerTrainingDB::updatePlayerTraining(new PlayerTraining($player->getId(), $training->getId(), $_POST['gemist'], $_POST['opmerking']));
								header("Location: ".$config['url']."/myPlayer/".$player->getId()."/");
							} else {
								PlayerTrainingDB::insertPlayerTraining(new PlayerTraining($player->getId(), $training->getId(), $_POST['gemist'], $_POST['opmerking']));
								header("Location: ".$config['url']."/myPlayer/".$player->getId()."/");
							}
						}
					}

				} else {
					echo 'redirect';
				}
			}
			
			//Concurrenten
						
			if (!$player->getU20()) {
				$concurrenten = PlayerDB::getScoutPositionConcurrenten($player->getID(), $player->getU20(), $indexScoutName);
				echo '<table width="100%">';
				echo '<tr class="niveau1">';
				if ($player->getU20()) {
					echo '<td colspan="6">Concurrenten (leeftijd u20: + of - 50 dagen)</td>';
				}
				else {
					echo '<td colspan="6">Concurrenten (leeftijd NT: + of - 1 seizoen)</td>';
				}
				echo '</tr>';
				echo '<tr class="niveau2">';
				echo '<td>Positie</td>';
				echo '<td>ID</td>';
				echo '<td>Speler</td>';
				echo '<td>Specialiteit</td>';
				echo '<td>Leeftijd</td>';
				echo '<td>Index '.$indexScoutName.'</td>';
				echo '</tr>';
				
				if ($concurrenten != Null) {
					$aantalVoor = 0;
					foreach($concurrenten AS $concurrent) {
						if ($concurrent->getId() == $player->getId()) {
							break;
						}
						else {
							$aantalVoor++;
						}
					}
					
					$startNummer = $mijnPositie - $aantalVoor;
					foreach($concurrenten AS $concurrent) {
						if ($concurrent->getId() == $player->getId()) {
							echo '<tr class="niveau2">';
						}
						else {
							echo '<tr>';
						}
						echo '<td>'.$startNummer.'</td>';
						echo '<td>'.$concurrent->getId().'</td>';
						echo '<td>'.$concurrent->getName().'</td>';
						echo '<td>'.$specs[$concurrent->getSpeciality()].'</td>';
						echo '<td>'.$concurrent->getLeeftijdStr().'</td>';
						echo '<td>'.$concurrent->getIndexByName($indexScoutName).'</td>';
						echo '</tr>';
						$startNummer++;
					}
				}	
				echo '</table>';
			}
			
		// Commentaar / informatie voor coach van scout
			$playerComment	=	PlayerCommentDB::getPlayerCommentById($player->getId());
			echo '<form action="" method="POST">'; 
			echo '<table width="100%">';
				echo '<tr class="niveau1">';
					echo '<td>Uw opmerkingen</td>';
				echo '</tr>';
				if (($playerComment != NULL) && 
				    ($playerComment->getCoach() <> '')) {
					echo '<tr class="none">';
					echo '<td><textarea name="coach" cols=70 rows=6>'.$playerComment->getCoach().'</textarea></td>';
					echo '</tr>';
				} else {
					echo '<tr><td><textarea name="coach" cols=70 rows=6>Voer hier uw opmerkingen in...</textarea></td></tr>';
				}
			echo '<tr class="none"><td colspan="2" align="right"><input type="submit" name="submit" value="Voeg toe" /></td></tr>';
			echo '</table>';
			
			if (isset($_POST['submit'])) {
				PlayerCommentDB::insertOrUpdatePlayerComment(new PlayerComment($player->getId(), $playerComment->getScouts(), $_POST['coach']));
				header("Location: ".$config['url']."/myPlayer/".$player->getId()."/");
			}
			
			echo '<table width="100%">';
				echo '<tr class="niveau1">';
					echo '<td>Commentaar / Informatie van de scouts</td>';
				echo '</tr>';
				if($playerComment != NULL) {
					echo '<tr class="none">';
						echo '<td>'.$playerComment->getScouts().'</td>';
					echo '</tr>';
				} else {
					echo '<tr><td>Geen informatie beschikbaar</td></tr>';
				}
			echo '</table>';
			
			echo '<span style="float: right"><a href="'.$config['url'].'/myPlayers/">Terug naar mijn spelers</a></span>';
		} else {
			echo 'Speler niet aanwezig.';
		}
	} else {
		echo 'Geen spelers aanwezig.';
	}
}
else {
	redirect($config['url'].'/', 0);
}
?>