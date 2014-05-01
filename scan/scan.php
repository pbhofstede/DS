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
            $HT->ClearPrimaryTeam();
            $HT->clearSecondaryTeam();
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
            $teams = $coach->getTeams($HT);

            $isFirstTeam = TRUE;

            $idlist = '';
            foreach($teams as $HTteam) {
       
                if ($HTteam !== NULL) {
                    $teamID = $HTteam->getTeamID();
                    
                    $coachTeam =  CoachDB::getCoachTeam($coach->getId(), $teamID); 
                    
			        $training = $HT->getTraining($teamID);
			        $TeamPlayers = $HT->getTeamPlayers($teamID, false);
                    $team = $HT->getTeam($teamID); 
			        $trainerID = $team->getTrainerId($teamID);
			
			        $i=1;	

                    $world = $HT->getWorldDetails();
			        $league = $world->getLeague(12);
			        $trainingdate = $league->getTrainingDate("d-m-Y");
			        $prevTrainingdate = strtotime($trainingdate) - (14 * 86400); 
			        $thisTrainingdate = strtotime($trainingdate) - (7 * 86400);
                    
                    echo '<table width="220px">';
                    if ($isFirstTeam == FALSE){
			        echo '<TR></TR>';
                    echo '<TR></TR>';
                    echo '<TR></TR>';
                    }  
			        echo '<TR><TD colspan="2"><B>Trainingdetails: '.date("d-m-Y", $thisTrainingdate).'</B></TD></TR>';
                    echo '<TR><TD>'.$language['team'].'</TD><TD>'.$team->getTeamName().'</TD></TR>';
			        echo '<TR><TD>'.$language['conditie'].'</TD><TD>'.$training->getLastTrainingStaminaTrainingPart().'%'.'</TD></TR>';
			        echo '<TR><TD>'.$language['training'].'</TD><TD>'.$language[$training->getLastTrainingTrainingType()].'</TD></TR>';
			        echo '<TR><TD>'.$language['trainingintensiteit'].'</TD><TD>'.$training->getLastTrainingTrainingLevel().'%'.'</TD></TR>';
			
			        echo '<TR><TD>'.$language['assistenten'].'</TD><TD>'.$HT->getClub($teamID)->getAssistantTrainerLevels().'</TD></TR>';
                    if ($isFirstTeam == TRUE){
			            echo '</table><div align="right"><a href="'.$config['urlweb'].'">'.$language['toFullVersion'].'</a></div><BR><BR>'; 
                    } 
                    else {
                        echo '</table><div align="right"></div><BR><BR>'; 
                    }     
                            
                    $coachTeam->setconditieperc($training->getLastTrainingStaminaTrainingPart());
			        $coachTeam->settrainingtype($training->getLastTrainingTrainingType());
			        $coachTeam->settrainingintensity($training->getLastTrainingTrainingLevel());
			
			        $coachTeam->setleagueID($team->getLeagueId());
                    $coachTeam->setassistants($HT->getClub($teamID)->getAssistantTrainerLevels());
				    $coachTeam->setformcoach($HT->getClub($teamID)->getFormCoachLevels());
				    $coachTeam->setdoctors($HT->getClub($teamID)->getMedicLevels());
                    $coachTeam->setTeamName($team->getTeamName());

                    $coach->setlastHTlogin($team->getLastLoginDate());
			
			        while($i <= $TeamPlayers->getNumberPlayers()) {
				        $player = $TeamPlayers->getPlayer($i);
				
				        if ($player->getId() == $trainerID) {
					        $coachTeam->settrainerskill($player->getTrainerSkill());
					        break;
				        }			
				        $i++;
			        }
			        CoachDB::updateCoach($coach);
                    CoachDB::updateCoachTeam($coachTeam);    
			    
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
                                    ($localPlayer->getTeamID() == 0) or
								        ($dateOfBirth <> $localPlayer->getDateOfBirth())) {
							        $localPlayer->update($coach->getId(), $teamID, $dateOfBirth, $player->getTsi(), $player->getSalary(), $player->getInjury(), 
								        $player->getForm(), $player->getStamina(), $player->getExperience (), $player->getKeeper(), 
								        $player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
								        $player->getScorer(), $player->getSetPieces(), $player->getACaps(), $player->getU20Caps(), time());
							        $doUpdate = true;
						        }
			
					        } else {
						        PlayerDB::insertPlayer(new Player($player->getId(), $coach->getId(), $teamID, NULL, $player->getName(), $dateOfBirth, 
							        $player->getTsi(), $player->getSalary(), $player->getInjury(), $player->getAggressiveness(), 
							        $player->getAgreeability(), $player->getHonesty(), $player->getLeadership(), $player->getSpeciality(), 
							        $player->getForm(), $player->getStamina(), $player->getExperience (), $player->getKeeper(), 
							        $player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
							        $player->getScorer(), $player->getSetPieces(), $player->getACaps(), $player->getU20Caps(), time(), time(),
							        0, 0, 0, 0, 0, 0, 0, 0, 0, 
							        0, 0, 0, 0, 0, 0, 0,
							        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
            
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
                } // if team is not null
                $isFirstTeam = FALSE;
            }
			
			
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
