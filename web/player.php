<?php
include ('header.php');
//Array
$trainingArray['1']		=	'Keepen';
$trainingArray['2']		=	'Verdedigen';
$trainingArray['3']		=	'Controlerendspel';
$trainingArray['4']		=	'Vleugelspel';
$trainingArray['5']		=	'Vleugelaanval';
$trainingArray['6']		=	'Positiespel';
$trainingArray['7']		=	'Scoren';
$trainingArray['8']		=	'Schieten';			
$trainingArray['9']		=	'Kortepass';
$trainingArray['10']	=	'Openingenmaken';
$trainingArray['11']	=	'Spelhervatting';

if ($user != NULL) {
	$scouting	=	$user->getScout();
}
else {
  $scouting = NULL;
}

if (($user != NULL) &&
    (($scouting != NULL) or
		 ($user->getRank() == 'administrator') or 
		 ($user->getRank() == 'bc'))) {	
	if(!empty($_GET['a'])) {
		$player		=	PlayerDB::getPlayer($_GET['a']);
		if($player != NULL) {
// Spelerinformatie

		if (!empty($_GET['b'])) {
			if ($_GET['b'] == 'makeU20') {
				$player->setU20(TRUE);
				$player->calcIndicesAndUpdateToDB();
				PlayerDB::updatePlayerScout($player->getID(), 0);
			}
			else if ($_GET['b'] == 'makeNT') {
				$player->setU20(FALSE);
				$player->calcIndicesAndUpdateToDB();
			}
			redirect($config['url'].'/player/'.$player->getID().'/');
		}
		
		if (isset($_POST['submitAddScout'])) {
			echo "file: ".$_POST['scoutingFile'];
			
			PlayerDB::updatePlayerScout($player->getID(), $_POST['scoutingFile']);
			
			redirect($config['url'].'/player/'.$player->getID().'/');
		}
		
		echo '<h1>'.$player->getName().'</h1>';
		echo '<table width="100%">';
		echo '<tr>';
		echo '<th colspan="6">'.$player->getName().'</th>';
		echo '</tr>';
		echo '<tr class="niveau1">';
		echo '<td colspan="6">Speler gegevens</td>';
		echo '</tr>';
		echo '<tr class="none">';
				
		$U20 = $player->getHasU20Age();
		echo "<td width='15%' valign='top'>Speler ID:<BR>Naam:<BR>Team ID:<BR>Team:<BR><BR>Conditie %:<BR>Type training:<BR>Training intensiteit:<BR>Vaardigheid trainer:<BR>Nivo assistenten:<BR>Nivo vormcoach:<BR>Nivo dokter:<BR><BR>";
		echo 'Leeftijd:<BR>TSI:<BR>Salaris:<BR>Vorm:<BR>Conditie:<BR><BR>Specialiteit:';
				
		if ($player->getU20() <> '') {
			echo '<BR>U20<BR>';
		}
		else {
			echo '<BR><BR><BR><BR>Scoutingfile';
		}
		echo '</TD>';
		echo '<td width="25%" valign="top">'.$player->getID().'<br />'.$player->getName().'<br />';
		
		$vCoach = $player->getCoach();
		if($vCoach != NULL) {
			if ($player->getbot() == -1) {
				echo 'BOT...<br /><BR><br /><BR><br /><br /><BR><br /><br /><BR>';
			}
			else {
				echo $player->getTeamid().'<BR>'.$player->getTeamname().'<br/><br/>';
							
				echo ''.$player->getconditieperc().'<BR>';
				if ($player->gettrainingtype() > 0) {
					echo ''.$language[$player->gettrainingtype()].' ('.$player->getlasttraining().'%)';
				}
				echo '<BR>';
				echo ''.$player->gettrainingintensity().'<BR>';
				echo ''.$player->gettrainerskill().'<BR>';
				echo ''.$player->getassistants().'<BR>';
				echo ''.$player->getFormCoach().'<BR>';
				echo ''.$player->getdoctors().'<BR>';
			}
			
	
		} else {
			echo 'onbekend<br/><br/><BR><BR><BR><BR><BR><BR><BR>';
		}
		echo '<BR>';
		echo $player->getLeeftijdStr().'<br/>';
		echo $player->getTsi().'<br/>';
		echo round($player->getSalary() / 10).' &euro;<br/>';
		echo getSkillLevel($player->getForm()).'<br/>';
		echo getSkillLevel($player->getStamina()).'<BR><BR>';
		echo $specs_long[$player->getSpeciality()];
		
		echo '<BR>';
		if ($U20 <> '') {
			echo $U20;
		}
		
		if ($player->getU20()) {
			echo '<BR><a href="#" onclick="maakNT();">maak NT!</a><BR>';
		}
		else {
		  if ((getDayInt(0) - getDayInt($player->getDateOfBirth())) < (21 * 112)) {
			  echo '<BR><a href="#" onclick="maakU20();">maak U20!</a><BR>';
			}
			else {
			   echo '<BR><BR>';
			}
			
			echo '<BR><form action="" method="POST">';
			echo '<select name="scoutingFile"><option value="0"></option>';
			$scouts = ScoutRequirementsDB::getNTScoutingFiles();
			if ($scouts != NULL) {				
				foreach ($scouts AS $scoutingRegel) {
					if ($player->getscoutid() == $scoutingRegel->getId()) {
						echo '<option value="'.$scoutingRegel->getId().'" SELECTED>'.$scoutingRegel->getName().'</option>';
					}
					else {
						echo '<option value="'.$scoutingRegel->getId().'">'.$scoutingRegel->getName().'</option>';
					}
				}
			}
			echo '</select><input type="submit" name="submitAddScout" value="Aanpassen" /></form>';
		}
					
		echo '</TD>';
		
		echo '<td width="15%" valign="top">Keepen:<BR>Verdedigen:<BR>Positiespel:<BR>Vleugelspel:<BR>Passen:<BR>Scoren:<BR>Spelhervatting:<BR><BR><BR><BR>Enrollment date:<BR>Last update:<BR>Last HT login:</TD>';
		echo '<TD width="25%"valign="top">'.getSkillLevel($player->getKeeper()).' ('.$player->getKeeperStr().')<br />';
		echo getSkillLevel($player->getDefender()).' ('.$player->getDefenderStr().')<br />';
		echo getSkillLevel($player->getPlaymaker()).' ('.$player->getPlaymakerStr().')<br />';
		echo getSkillLevel($player->getWinger()).' ('.$player->getWingerStr().')<br />';
		echo getSkillLevel($player->getPassing()).' ('.$player->getPassingStr().')<br />';
		echo getSkillLevel($player->getScorer()).' ('.$player->getScorerStr().')<br />';
		echo getSkillLevel($player->getSetPieces()).' ('.$player->getSetPiecesStr().')<br /><br />';
		echo '<a href="'.$config['url'].'/updateSubSkill.php?player='.$player->getID().'">Subskills aanpassen</a><br /><br />';
		echo date('d-m-Y', $player->getAdded()).'<br />';
		echo date('d-m-Y', $player->getLastupdate()).'<br />';
		
		if ($vCoach != NULL) {
			if ($player->getbot() == -1) {
				echo 'BOT...';
			}
			else if (strtotime($vCoach->getlastHTlogin()) > 0) {
				echo date('d-m-Y H:i', strtotime($vCoach->getlastHTlogin()));
			}
		}
		echo '</td>';
		echo '<td width="10%" valign="top">index GK:<br />index CD:<br />index DEF:<br />index WB: <br />index IM:<br />index WG:<br />index SC:<br />index DFW:<br />index SP:<br /><br />Kwal. index:</TD>'; 
		echo '<td width="10%" valign="top">';
		if ($player->getindexGK() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexGK().'</p></b>';
		}
		else {
			echo ''.$player->getindexGK().'<br />';
		}
		if ($player->getindexCD() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexCD().'</p></b>';
		}
		else {
			echo ''.$player->getindexCD().'<br />';
		}
		if ($player->getindexDEF() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexDEF().'</p></b>';
		}
		else {
			echo ''.$player->getindexDEF().'<br />';
		}
		if ($player->getindexWB() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexWB().'</p></b>';
		}
		else {
			echo ''.$player->getindexWB().'<br />';
		}
		if ($player->getindexIM() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexIM().'</p></b>';
		}
		else {
			echo ''.$player->getindexIM().'<br />';
		}
		if ($player->getindexWG() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexWG().'</p></b>';
		}
		else {
			echo ''.$player->getindexWG().'<br />';
		}
		if ($player->getindexSC() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexSC().'</p></b>';
		}
		else {
			echo ''.$player->getindexSC().'<br />';
		}
		if ($player->getindexDFW() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexDFW().'</p></b>';
		}
		else {
			echo ''.$player->getindexDFW().'<br/>';
		}
    if ($player->getindexSP() > 0) {
			echo '<b><p STYLE="color: green;">'.$player->getindexSP().'</p></b>';
		}
		else {
			echo ''.$player->getindexSP().'<br/>';
		}
		
		$indexScoutName = $player->getBestIndexScoutName();
		$index = $player->getBestIndexScout();
		echo '<br/>'.$indexScoutName.': '.Round($player->getLeeftijdWeken() + $index - 200, 2);
		echo '</TD>';
		echo '</tr>';
		echo '</table>';
		
		//Concurrenten		
		$mijnPositie = PlayerDB::getScoutPosition($player->getID(), $player->getU20(), $player->getLeeftijdJaar(), $indexScoutName);
		$concurrenten = PlayerDB::getScoutPositionConcurrenten($player->getID(), $player->getU20(), $player->getLeeftijdJaar(), $indexScoutName);
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
		
// Speler training volgens coach
			echo '<table width="100%">';
				echo '<tr>';
					echo '<td colspan="10" class="niveau1">Training geschiedenis volgens coach(es)</td>';
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
					echo '<td>Coach</td>';
				echo '</tr>';
				
				$playerTrainingList	=	PlayerTrainingDB::getPlayerTrainingListByPlayer($player->getId());
				if($playerTrainingList != NULL) {
					foreach ($playerTrainingList AS $playerTraining) {
						$training	=	TrainingDB::getTrainingById($playerTraining->getTraining());
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
							echo '<td>'.$training->getCoachId().'</td>';
						echo '</tr>';
					}
				} else {
					echo '<tr><td colspan="10">Training niet aanwezig</td></tr>';
				}
			echo '</table>';
// Commentaar / informatie voor scouts en de coach
			$playerComment	=	PlayerCommentDB::getPlayerCommentById($player->getId());
			echo '<table width="100%">';
				echo '<tr>';
					echo '<td colspan="2" class="niveau1">Commentaar / informatie voor scouts en de coach</td>';
				echo '</tr>';
				echo '<tr class="niveau2">';
					echo '<td width=50%>Scouts</td>';
					echo '<td>Coach</td>';
				echo '</tr>';
				if($playerComment != NULL) {
					echo '<form action="" method="POST">';
					echo '<tr class="none">';
						echo '<td><textarea name="scouts" cols=70 rows=6>'.$playerComment->getScouts().'</textarea></td>';
						echo '<td><textarea name="coach" cols=70 rows=6>'.$playerComment->getCoach().'</textarea></td>';
					echo '</tr>';
					echo '<tr><td colspan="2" align="right"><input type="submit" name="verander" value="Verander" /></td></tr>';
				} else {
					echo '<form action="" method="POST">';
					echo '<tr class="none">';
						echo '<td><textarea name="scouts" cols=70 rows=6>';
						if (isset($_POST['scouts'])) {
							echo $_POST['scouts'];
						}
						echo '</textarea></td>';
						echo '<td><textarea readonly="yes" name="coach" cols=70 rows=6>';
						echo '</textarea></td>';
					echo '</tr>';
					echo '<tr class="none"><td colspan="2" align="right"><input type="submit" name="submit" value="Voeg toe" /></td></tr>';
				}
			echo '</table>';
			
			if ($playerComment != NULL) {
				$coach_comment = $playerComment->getCoach();
			}
			else {
			  $coach_comment = '';
			}
			
			if (isset($_POST['submit'])) {
				PlayerCommentDB::insertOrUpdatePlayerComment(new PlayerComment($player->getId(), $_POST['scouts'], $coach_comment));
				header("Location: ".$config['url']."/player/".$player->getId()."/");
			}
			if (isset($_POST['verander'])) {
				PlayerCommentDB::insertOrUpdatePlayerComment(new PlayerComment($player->getId(), $_POST['scouts'], $coach_comment));
				header("Location: ".$config['url']."/player/".$player->getId()."/");
			}
//Player Log
			echo '<table width="100%">';
				echo '<tr>';
					echo '<td colspan="4" class="niveau1">Spelers vaardigheden log</td>';
				echo '</tr>';
				echo '<tr class="niveau2">';
					echo '<td>Vaardigheid</td>';
					echo '<td>Oud</td>';
					echo '<td>Nieuw</td>';
					echo '<td>Datum</td>';
				echo '</tr>';
				//Conditie
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'stamina');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Conditie</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Ervaring
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'experience');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Ervaring</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Keepen
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'keeper');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Keepen</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Verdedigen
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'defender');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Verdedigen</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Positiespel
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'playmaker');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Positiespel</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Vleugelspel
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'winger');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Vleugelspel</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Passen
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'passing');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Passen</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Scoren
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'scorer');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Scoren</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
				//Spelhervatten
				$popLog		=	PlayerLogDB::getPlayerLogByPlayerByType($player->getId(), 'setPieces');
				if($popLog != NULL) {
					foreach ($popLog AS $log) {
						echo '<tr>';
							echo '<td>Spelhervatten</td>';
							echo '<td>'.getSkillLevel($log->getOld()).'</td>';
							echo '<td>'.getSkillLevel($log->getNew()).'</td>';
							echo '<td>'.date('d-m-Y', $log->getDate()).'</td>';
						echo '</tr>';
					}
				}
			echo '</table>';
		}		
	}
} else {
	redirect($config['url'].'/', 0);
}
include ('footer.php');
?>