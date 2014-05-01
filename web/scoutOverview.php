<?php
//Scout overzicht pagina
include ('header.php');


if ($user != NULL) {
	$scouting	=	$user->getScout();
}
else {
	$scouting = NULL;
}

function cmpBestIndex($playerA, $playerB)
{
 	if ($playerA->getBestIndexScout() > $playerB->getBestIndexScout())
 		return -1;
 	else if ($playerA->getBestIndexScout() < $playerB->getBestIndexScout())
 		return 1;
 	else
		return 0;
}

if($scouting != NULL) {
  //nieuwe spelers
	$datumNieuw = strtotime("-8 days", time());

	//update nodig
	$datumMin = strtotime("-35 days", time());
	$datumMax = strtotime("-119 days", time());

	//inactieve managers
	$datumMinInlog = strtotime("-20 days", time());  


	$datumTraining = strtotime("-7 days", time()); 
	
	$knownLastTrainingdate = strtotime(CoachDB::getLastTrainingdate());
	$maandagNaTraining = strtotime("+3 days", $knownLastTrainingdate); 
	 
	echo '<h1>Scouting</h1>';	
	echo '<h2>Scoutgroepen</h2>';
	echo '<ul>';
		foreach($scouting AS $scout) {
			if ($scout != null) {
				echo '<li><a href="'.$config['url'].'/scouting/'.$scout->getId().'/">'.$scout->getName().'</a></li>';
			}
		}
	echo '</ul>';
	
	echo '<h2>Scout nieuws</h2>';
	foreach($scouting AS $scout) {
		if ($scout != null) {
			echo '<table width="100%">';
			echo '<tr onClick="top.location=\''.$config['url'].'/scouting/'.$scout->getId().'/\'">';
			echo '<th colspan="2" style="cursor: pointer">'.$scout->getName().'</th>';
			echo '</tr>';
			echo '<tr>';
			
			echo '<td width="50%" valign="top"><table width="95%" class="list">';
			
			//pops
			echo '<tr class="niveau1">';
			echo '<td colspan="12">Pops (laatste week)</td>';
			echo '</tr>';
			echo '<tr class="niveau2">';
			echo '<td>Naam</td>';
			echo '<td>ID</td>';
			echo '<td>Leeftijd</td>';
			echo '<td>Datum</td>';
			echo '<td>Skill</td>';
			echo '<td>Van</td>';
			echo '<td colspan="5">Naar</td>';
			echo '<td>Index</td>';
			echo '</tr>';
			
			$playerList	=	$scout->getPlayerList(FALSE);
			$playersFound = FALSE;
			
			if($playerList != NULL) {
				usort($playerList,'cmpBestIndex');
				
				foreach($playerList AS $player) {
					$vLog = PlayerLogDB::getPlayerLogByPlayerByDate($player->getId(), $datumTraining);

					if ($vLog != Null) {
						echo '<tr onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						echo '<td>'.$player->getName().'</td>';
						echo '<td>'.$player->getId().'</td>';
						echo '<td>'.$player->getLeeftijdStr().'</td>';
						echo '<td>'.date("d-m-y", $vLog->getDate()).'</td>';
						echo '<td>'.$vLog->getType().'</td>';
						echo '<td>'.$vLog->getOld().'</td>';
						echo '<td colspan="5">'.$vLog->getNew().'</td>';
						echo '<td>'.$player->getBestIndexScoutName().': '.$player->getBestIndexScout().'</td>';
						echo '</tr>';
						
						$playersFound = TRUE;
					}
				}
			} 
			if (! $playersFound) {
				echo '<tr><td colspan="12" style="cursor: default">Geen pops geregistreerd</td></tr>';
			}
			
			//Nieuwe spelers
			echo '<tr class="niveau1">';
			echo '<td colspan="12">Nieuw (laatste week)</td>';
			echo '</tr>';
			echo '<tr class="niveau2">';
			echo '<td>Naam</td>';
			echo '<td>ID</td>';
			echo '<td>Leeftijd</td>';
			echo '<td>Spec</td>';
			echo '<td>Datum</td>';
			echo '<td>Cond%</td>';
			echo '<td>TI</td>';
			echo '<td>Trnr</td>';
			echo '<td>Ass</td>';
			echo '<td>Training</td>';
			echo '<td>% Training</td>';
			echo '<td>Index</td>';
			echo '</tr>';
			
			$playerList	=	$scout->getPlayerList(FALSE);
			$playersFound = FALSE;
			
			if($playerList != NULL) {
				usort($playerList,'cmpBestIndex');
				
				foreach($playerList AS $player) {
					if ($player->getAdded() >= $datumNieuw) {
						echo '<tr onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						echo '<td>'.$player->getName().'</td>';
						echo '<td>'.$player->getId().'</td>';
						echo '<td>'.$player->getLeeftijdStr().'</td>';
						echo '<td>'.$specs[$player->getSpeciality()].'</td>';
						echo '<td>'.date("d-m-y", $player->getAdded()).'</td>';					
						echo '<td>'.$player->getconditieperc().'</td>';
						echo '<td>'.$player->gettrainingintensity().'</td>';
						echo '<td>'.$player->gettrainerskill().'</td>';
						echo '<td>'.$player->getassistants().'</td>';
						echo '<td>'.$language[$player->gettrainingtype()+20].'</td>';
						echo '<td>'.$player->getlasttraining().'</td>';
						echo '<td>'.$player->getBestIndexScoutName().': '.$player->getBestIndexScout().'</td>';
						echo '</tr>';
						
						$playersFound = TRUE;
					}
				}
			} 
			if (! $playersFound) {
				echo '<tr><td colspan="12" style="cursor: default">Geen nieuwe spelers aanwezig</td></tr>';
			}
			
			//Slechte training
			echo '<tr class="niveau1">';
			echo '<td colspan="12">Slechte training</td>';
			echo '</tr>';
			echo '<tr class="niveau2">';
			echo '<td>Naam</td>';
			echo '<td>ID</td>';
			echo '<td>Leeftijd</td>';
			echo '<td>Spec</td>';
			echo '<td>Datum</td>';
			echo '<td>Cond%</td>';
			echo '<td>TI</td>';
			echo '<td>Trnr</td>';
			echo '<td>Ass</td>';
			echo '<td>Training</td>';
			echo '<td>% Training</td>';
			echo '<td>Index</td>';
			echo '</tr>';
			
			$playersFound = FALSE;
			if($playerList != NULL) {			
				foreach($playerList AS $player) {
					if (($player->getLastupdate() >= $datumTraining) &&
              ($player->gettrainingtype() > 0)) {					
						if (($player->getlasttraining() < 100) or
								($player->gettrainingintensity() < 100) or
								((($player->getU20()) && ($player->getassistants() < 15)) or
                 ((! $player->getU20()) && ($player->getassistants() < 12))) or
								($player->getconditieperc() > 50) or
								($player->gettrainerskill() < 7)) {
							$playersFound = TRUE;
							echo '<tr onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
							echo '<td>'.$player->getName().'</td>';
							echo '<td>'.$player->getId().'</td>';
							echo '<td>'.$player->getLeeftijdStr().'</td>';
							echo '<td>'.$specs[$player->getSpeciality()].'</td>';
							echo '<td>'.date("d-m-y", $player->getLastupdate()).'</td>';
							
							if ($player->getconditieperc() > 50) {
								echo '<td bgcolor="#FEE0C6">'.$player->getconditieperc().'</td>';
							}
							else {
								echo '<td>'.$player->getconditieperc().'</td>';
							}
							
							if ($player->gettrainingintensity() < 100) {
								echo '<td bgcolor="#FEE0C6">'.$player->gettrainingintensity().'</td>';
							}
							else {
								echo '<td>'.$player->gettrainingintensity().'</td>';
							}
							
							if ($player->gettrainerskill() < 7) {
								echo '<td bgcolor="#FEE0C6">'.$player->gettrainerskill().'</td>';
							}
							else {
								echo '<td>'.$player->gettrainerskill().'</td>';
							}
							
							if ($player->getassistants() < 9) {
							  echo '<td bgcolor="#FEE0C6">'.$player->getassistants().'</td>';
							}
							else {
								echo '<td>'.$player->getassistants().'</td>';
							}
							echo '<td>'.$language[$player->gettrainingtype()+20].'</td>';
							
							if ($player->getlasttraining() < 100) {
								echo '<td bgcolor="#FEE0C6">'.$player->getlasttraining().'</td>';
							}
							else {
								echo '<td>'.$player->getlasttraining().'</td>';
							}
							
							echo '<td>'.$player->getBestIndexScoutName().': '.$player->getBestIndexScout().'</td>';
							echo '</tr>';
						}
					}
				}
			} 
			
			if (! $playersFound) {
				echo '<tr><td colspan="12" style="cursor: default">Alle spelers zijn optimaal getraind!</td></tr>';
			}
			
			//Oude spelers
			echo '<tr class="niveau1">';
			echo '<td colspan="12">Update nodig (5-16 weken)</td>';
			echo '</tr>';
			echo '<tr class="niveau2">';
			echo '<td>Naam</td>';
			echo '<td>ID</td>';
			echo '<td>Leeftijd</td>';
			echo '<td>Spec</td>';
			echo '<td>Datum</td>';
			echo '<td>Cond%</td>';
			echo '<td>TI</td>';
			echo '<td>Trnr</td>';
			echo '<td>Ass</td>';
			echo '<td>Training</td>';
			echo '<td>% Training</td>';
			echo '<td>Index</td>';
			echo '</tr>';
			$playersFound = FALSE;
			
			if($playerList != NULL) {
				foreach($playerList AS $player) {
					if (($player->getLastupdate() <= $datumMin) &&
						  ($player->getLastupdate() >= $datumMax)) {
						echo '<tr onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						echo '<td>'.$player->getName().'</td>';
						echo '<td>'.$player->getId().'</td>';
						echo '<td>'.$player->getLeeftijdStr().'</td>';
						echo '<td>'.$specs[$player->getSpeciality()].'</td>';
						echo '<td>'.date("d-m-y", $player->getLastupdate()).'</td>';		
						echo '<td>'.$player->getconditieperc().'</td>';
						echo '<td>'.$player->gettrainingintensity().'</td>';
						echo '<td>'.$player->gettrainerskill().'</td>';
						echo '<td>'.$player->getassistants().'</td>';
						echo '<td>'.$language[$player->gettrainingtype()+20].'</td>';
						echo '<td>'.$player->getlasttraining().'</td>';
						echo '<td>'.$player->getBestIndexScoutName().': '.$player->getBestIndexScout().'</td>';
						echo '</tr>';
						$playersFound = TRUE;
					}
				}
			} 
			
			if (! $playersFound) {
				echo '<tr><td colspan="12" style="cursor: default">Geen spelers aanwezig</td></tr>';
			}
			
			
			//Inactive
			echo '<tr class="niveau1">';
			echo '<td colspan="12">Inactieve managers (minimaal 3 weken niet ingelogd HT)</td>';
			echo '</tr>';
			echo '<tr class="niveau2">';
			echo '<td>Naam</td>';
			echo '<td>ID</td>';
			echo '<td>Leeftijd</td>';
			echo '<td>Spec</td>';
			echo '<td>Login</td>';
			echo '<td>Cond%</td>';
			echo '<td>TI</td>';
			echo '<td>Trnr</td>';
			echo '<td>Ass</td>';
			echo '<td>Training</td>';
			echo '<td>% Training</td>';
			echo '<td>Index</td>';
			echo '</tr>';
			$playersFound = FALSE;
			
			if($playerList != NULL) {
				foreach($playerList AS $player) {
					if ($player != NULL) {
					$vCoach = $player->getCoach();
					if ($vCoach != NULL) {	
						$vTime = strtotime($vCoach->getlastHTlogin());
						if (($vTime > 0) &&
						    ($vTime <= $datumMinInlog)) {
							echo '<tr onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
							echo '<td>'.$player->getName().'</td>';
							echo '<td>'.$player->getId().'</td>';
							echo '<td>'.$player->getLeeftijdStr().'</td>';
							echo '<td>'.$specs[$player->getSpeciality()].'</td>';
							echo '<td>'.date("d-m-y H:i", $vTime).'</td>';		
							echo '<td>'.$player->getconditieperc().'</td>';
							echo '<td>'.$player->gettrainingintensity().'</td>';
							echo '<td>'.$player->gettrainerskill().'</td>';
							echo '<td>'.$player->getassistants().'</td>';
							echo '<td>'.$language[$player->gettrainingtype()+20].'</td>';
							echo '<td>'.$player->getlasttraining().'</td>';
							echo '<td>'.$player->getBestIndexScoutName().': '.$player->getBestIndexScout().'</td>';
							echo '</tr>';
							$playersFound = TRUE;
						}
					}
					}
				}
			} 
			
			if (! $playersFound) {
				echo '<tr><td colspan="12" style="cursor: default">Geen spelers aanwezig</td></tr>';
			}
			
		
			//Zondag niet gespeeld
			if (time() >= $maandagNaTraining) {
				echo '<tr class="niveau1">';
				echo '<td colspan="12">Spelers zondag niet gespeeld / getraind</td>';
				echo '</tr>';
				echo '<tr class="niveau2">';
				echo '<td>Naam</td>';
				echo '<td>ID</td>';
				echo '<td>Leeftijd</td>';
				echo '<td>Spec</td>';
				echo '<td>Datum</td>';
				echo '<td>Cond%</td>';
				echo '<td>TI</td>';
				echo '<td>Trnr</td>';
				echo '<td>Ass</td>';
				echo '<td>Training</td>';
				echo '<td>% gespeeld</td>';
				echo '<td>Index</td>';
				echo '</tr>';
				$playersFound = FALSE;
				
				if($playerList != NULL) {			
					foreach($playerList AS $player) {
						if (($player->getsundayTraining() != NULL) &&
								($player->getsundayTraining() < 100)) {
							$playersFound = TRUE;
							echo '<tr onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
							echo '<td>'.$player->getName().'</td>';
							echo '<td>'.$player->getId().'</td>';
							echo '<td>'.$player->getLeeftijdStr().'</td>';
							echo '<td>'.$specs[$player->getSpeciality()].'</td>';
							echo '<td>'.date("d-m-y", $player->getLastupdate()).'</td>';
							echo '<td>'.$player->getconditieperc().'</td>';
							echo '<td>'.$player->gettrainingintensity().'</td>';
							echo '<td>'.$player->gettrainerskill().'</td>';
							echo '<td>'.$player->getassistants().'</td>';
							echo '<td>'.$language[$player->gettrainingtype()+20].'</td>';
							echo '<td bgcolor="#FEE0C6">'.$player->getsundayTraining().'</td>';							
							echo '<td>'.$player->getBestIndexScoutName().': '.$player->getBestIndexScout().'</td>';
							echo '</tr>';
						}
					}
				}
				if (! $playersFound) {
					echo '<tr><td colspan="12" style="cursor: default">Geen spelers aanwezig</td></tr>';
				}
			}
			echo '</table></td>';
		}
		
		
		echo '</table></td>';
		echo '</tr>';
		echo '</table>';

	}
} else {
	if ($user != NULL) {
		echo 'Je hebt geen scoutgroepen toegewezen gekregen.';
	}
	else {
		redirect($config['url'].'/', 0);
	}
}

?>