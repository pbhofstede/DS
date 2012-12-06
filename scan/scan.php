<?php
include ('config.php');
require ('calcTraining.php');


try {
	$coach = CoachDB::LoginUser($_GET['name'], $_GET['password']);
		
	if($coach != NULL) {
		IF ((isset($_SESSION['HT']))) {
			$HT = $_SESSION['HT'];
			
			//wel even de team en club resetten in geval van andere user
			$HT->clearClub();
			$HT->clearTeams();
		}
		else {
			$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		}
				
		$HT->setOauthToken($coach->getHTuserToken());
    $HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
    $loggedInHT = FALSE;
		
		try {
			$_SESSION['dutchscouts']		=	$HT->getClub()->getUserId();
			$loggedInHT = TRUE;
		}
		catch(HTError $e) {
			$pos = strpos($e, 'Access is denied');
			if ($pos === false) {
				echo $e;
			}	
		}
		$_SESSION['dutchscoutsName']	=	$_GET['name'];
		$_SESSION['dutchscoutsSC']		=	$_GET['password'];
		
		if ($loggedInHT) {
			$training = $HT->getTraining();
			
			$TeamPlayers = $HT->getTeamPlayers(null, false);
			$team = $HT->getTeam(); 
			$trainerID = $team->getTrainerId();
			
			$i=1;			
			
			$world = $HT->getWorldDetails();
			$league = $world->getLeague(12);
			$trainingdate = $league->getTrainingDate("d-m-Y");
			$prevTrainingdate = strtotime($trainingdate) - (14 * 86400); 
			$thisTrainingdate = strtotime($trainingdate) - (7 * 86400); 
			
			echo '<table width="220px">';
			echo '<TR><TD colspan="2"><B>Trainingdetails: '.date("d-m-Y", $thisTrainingdate).'</B></TD></TR>';
			echo '<TR><TD>'.$language['conditie'].'</TD><TD>'.$training->getLastTrainingStaminaTrainingPart().'%'.'</TD></TR>';
			echo '<TR><TD>'.$language['training'].'</TD><TD>'.$language[$training->getLastTrainingTrainingType()].'</TD></TR>';
			echo '<TR><TD>'.$language['trainingintensiteit'].'</TD><TD>'.$training->getLastTrainingTrainingLevel().'%'.'</TD></TR>';
			
			echo '<TR><TD>'.$language['assistenten'].'</TD><TD>'.$HT->getClub()->getSpecialists()->getAssistantTrainers().'</TD></TR>';
			echo '</table><div align="right"><a href="'.$config['urlweb'].'">'.$language['toFullVersion'].'</a></div><BR><BR>';
			
			$coach->setconditieperc($training->getLastTrainingStaminaTrainingPart());
			$coach->settrainingtype($training->getLastTrainingTrainingType());
			$coach->settrainingintensity($training->getLastTrainingTrainingLevel());
			
			$coach->setleagueID($team->getLeagueId());
			
			$specialists = $HT->getClub()->getSpecialists();
			if ($specialists != Null) {
				$coach->setassistants($specialists->getAssistantTrainers());
				$coach->setphysios($specialists->getPhysiotherapists());
				$coach->setdoctors($specialists->getDoctors());
			}
			else {
				$coach->setassistants(0);
				$coach->setphysios(0);
				$coach->setdoctors(0);
			}
			$coach->setlastHTlogin($team->getLastLoginDate());
			
			while($i <= $TeamPlayers->getNumberPlayers()) {
				$player = $TeamPlayers->getPlayer($i);
				
				if ($player->getId() == $trainerID) {
					$coach->settrainerskill($player->getTrainerSkill());
					break;
				}			
				$i++;
			}
			CoachDB::updateCoach($coach);

			echo '<table width="560px">';
			echo '<tr>';
			echo '<td><strong>'.$language['ID'].'</strong></td>';
			echo '<td><strong>'.$language['player'].'</strong></td>';
			echo '<td><strong>'.$language['age'].'</strong></td>';
			echo '<td><strong>Index</strong></td>';
			echo '<td width=10%><strong>'.$language['interessant'].'</strong></td>';
			echo '<td></td>';
			echo '</tr>';
			$i=1;
			$idlist = '';
		
			while($i <= $TeamPlayers->getNumberPlayers()) {
				$player = $TeamPlayers->getPlayer($i);
				
				$aantalDagen = ($player->getAge() * 112) + $player->getDays();
   			$dateOfBirth	=	strtotime('today -'.$aantalDagen.' days');
			
				if($player->getCountryId() == 12) {
					$idlist = $idlist.$player->getId().",";
					echo '<tr>';
					echo '<td>'.$player->getId().'</td>';
					echo '<td>'.$player->getName().'</td>';
					echo '<td>'.$player->getAge().' '.$language['year'].' en '.$player->getDays().' '.$language['days'];
			
					$localPlayer =	PlayerDB::getPlayer($player->getId());
					
					$doUpdate = false;
					if($localPlayer != NULL) {					
						$playerCoachID = $localPlayer->getCoachId();
						
						if (((time() - $localPlayer->getLastupdate()) > (8 * 86400)) or
						    ($playerCoachID <> $coach->getId()) or
								($dateOfBirth <> $localPlayer->getDateOfBirth())) {
							$localPlayer->update($coach->getId(), $dateOfBirth, $player->getTsi(), $player->getSalary(), $player->getInjury(), 
								$player->getForm(), $player->getStamina(), $player->getExperience (), $player->getKeeper(), 
								$player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
								$player->getScorer(), $player->getSetPieces(), $player->getACaps(), $player->getU20Caps(), time());
							$doUpdate = true;
						}
			
					} else {
						PlayerDB::insertPlayer(new Player($player->getId(), $coach->getId(), $player->getName(), $dateOfBirth, 
							$player->getTsi(), $player->getSalary(), $player->getInjury(), $player->getAggressiveness(), 
							$player->getAgreeability(), $player->getHonesty(), $player->getLeadership(), $player->getSpeciality(), 
							$player->getForm(), $player->getStamina(), $player->getExperience (), $player->getKeeper(), 
							$player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
							$player->getScorer(), $player->getSetPieces(), $player->getACaps(), $player->getU20Caps(), time(), time(),
							0, 0, 0, 0, 0, 0, 0, 0, 0, 
							0, 0, 0, 0, 0, 0, 0,
							0, 0, 0, 0, 0, 0, 0,
              0, 0));
            
						$localPlayer =	PlayerDB::getPlayer($player->getId());
						$doUpdate = true;
					}
					
					if ($doUpdate) {
						$localPlayer->calcIndicesAndUpdateToDB();
					}
					
					echo '<TD>'.$localPlayer->getBestIndexScout().' ('.$localPlayer->getBestIndexScoutName().')</TD>';
					
					if ($localPlayer->getIsInteresting()) {	
						echo "<TD><FONT COLOR='green'><B>V</B></TD>";
					}
					else {
						echo "<TD><FONT COLOR='red'><B>X</B></TD>";
					}
					
					if ($doUpdate) {
						echo "<TD><B>updated</B></td>";
					}
					else {
						echo "<TD></td>";
					}
					echo '</tr>';
				}
				$i++;
			}
			echo '</table>';
			
			if (strlen($idlist) == 0) {
				$idlist = "0,";
			}
			
			$idlist = substr($idlist, 0, -1);
			PlayerDB::clearNonExistingPlayer($coach->getId(), $idlist);
		}
		else {
			//kan niet met CHPP inloggen
			echo '<span class="error">'.$language['noHTPermission'].'</span><BR><BR>';
			
			echo '<a href="'.$config['url'].'/loginHT.php"><u>'.$language['new'].'</u></a>';
		}
	} else {
		echo '<span class="error">'.$language['incorrectAccount'].'</span><BR><BR>';
		
		echo '<a href="'.$config['url'].'/loginHT.php"><u>'.$language['new'].'</u></a>';
	}
} catch(HTError $e) {
	echo $e;
}
?>
