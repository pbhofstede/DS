<?php
//set_time_limit(0);
error_reporting(E_ALL);
ini_set("max_execution_time", "3000");
ini_set('memory_limit','128M');

include ('config.php');
require ('calcTraining.php');
require ('class/log.class.php');

$aantalScanned = 0;

function myLog($log, $aStr) {
	$log->lwrite($aStr);
}

function AddPlayTime($vPosition, $aMinutes, &$posGK, &$posCD, &$posWB, &$posIM, &$posWG, &$posSC) {
	if ($vPosition == 100) {
		$posGK = $posGK + $aMinutes;
	}
	if ($vPosition == 101) {
		$posWB = $posWB + $aMinutes;
	}
	if ($vPosition == 102) {
		$posCD = $posCD + $aMinutes;
	}
	if ($vPosition == 103) {
		$posCD = $posCD + $aMinutes;
	}
	if ($vPosition == 104) {
		$posCD = $posCD + $aMinutes;
	}
	if ($vPosition == 105) {
		$posWB = $posWB + $aMinutes;
	}
	if ($vPosition == 106) {
		$posWG = $posWG + $aMinutes;
	}
	if ($vPosition == 107) {
		$posIM = $posIM + $aMinutes;
	}
	if ($vPosition == 108) {
		$posIM = $posIM + $aMinutes;
	}
	if ($vPosition == 109) {
		$posIM = $posIM + $aMinutes;
	}
	if ($vPosition == 110) {
		$posWG = $posWG + $aMinutes;
	}
	if ($vPosition == 111) {
		$posSC = $posSC + $aMinutes;
	} 
	if ($vPosition == 112) {
		$posSC = $posSC + $aMinutes;
	}
	if ($vPosition == 113) {
		$posSC = $posSC + $aMinutes;
	}
	if ($vPosition == 114) {
		$posGK = $posGK + $aMinutes;
	}
	if ($vPosition == 115) {
		$posCD = $posCD + $aMinutes;
	}
	if ($vPosition == 116) {
		$posIM = $posIM + $aMinutes;
	}
	if ($vPosition == 117) {
		$posWG = $posWG + $aMinutes;
	}
	if ($vPosition == 118) {
		$posSC = $posSC + $aMinutes;
	}
	if ($vPosition > 118) {
    myLog($log, 'onbekende positie: '.$vPosition);
	}
}

try {
	$log = new Logging();
	$log->lfile('log/scanTraining');
	
	$a = 0;
	if(isset($_GET['a'])) {
	  $a = $_GET['a'];
	}
	
	if (($a >= 100) ||
    	(CoachDB::getSiteStats('training_running') == -1)) {
		if ($a >= 100) {
		}
		else {
			myLog($log, "Training already running. This call is cancelled.");
		}
		$aantalScanned = 200;
	}
	else {
		if( !ini_get('safe_mode') ){
		  //myLog($log, "Safe mode off: setting time limit = 0");
			set_time_limit(0);
		} 
		else {
		  //myLog($log, "Safe mode...");
		}	
	
		$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		
		$coach = CoachDB::LoginUser('__auto_Pays', '');
		$HT->setOauthToken($coach->getHTuserToken());
		$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
		
		$world = $HT->getWorldDetails();
		$league = $world->getLeague(12);
		$trainingdate = $league->getTrainingDate("d-m-Y");
		
		$prevTrainingdate = strtotime("-14 days", strtotime($trainingdate)); 
		$thisTrainingdate = strtotime("-7 days", strtotime($trainingdate));
														
		$knownLastTrainingdate = strtotime(CoachDB::getLastTrainingdate());

		//myLog($log, "prevTrainingdate: ".$prevTrainingdate);
		//myLog($log, date("Y-m-d", $prevTrainingdate));
		
		//myLog($log, "This trainingdate: ".$thisTrainingdate);
		//myLog($log, date("Y-m-d", $thisTrainingdate));
		
		//myLog($log, "Known Last Trainingdate: ".$knownLastTrainingdate);
		//myLog($log, date("Y-m-d", $knownLastTrainingdate));
		
		if ($knownLastTrainingdate < ($thisTrainingdate)) {
			myLog($log, "Clearing last training...");
			PlayerDB::clearLastTraining();
			myLog($log, "done");
			myLog($log, "Clearing last sunday training...");
			PlayerDB::clearsundayTraining();
			myLog($log, "done");
		}
		$coaches = CoachDB::getUsersToScan(date("Y-m-d", $thisTrainingdate), $a);
		myLog($log, "Start: ".$a." Aantal coaches: ".count($coaches));
		$aantalScanned = count($coaches);
		
		if ($aantalScanned > 0) {
			CoachDB::setTrainingRunning(TRUE);
			
			//myLog($log, "Start");
			
			for ($count = 0; $count < count($coaches); $count++) {
				try {
					$coach = $coaches[$count];
					
					if ($coach->getHTuserToken() <> '') {
						$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');					
						$HT->setOauthToken($coach->getHTuserToken());
						$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());

                       $teams = $coach->getTeams($HT);
                       $idlist = '';
                       foreach($teams as $team) {

                            if ($team !== NULL) {
 
                                $teamID = $team->getTeamID();
                                $coachteam =  CoachDB::getCoachTeam($coach->getId(), $teamID); 
                                $training = $HT->getTraining($teamID);
                                $coachteam->setconditieperc($training->getLastTrainingStaminaTrainingPart());
						        $coachteam->settrainingtype($training->getLastTrainingTrainingType());
						        $coachteam->settrainingintensity($training->getLastTrainingTrainingLevel());
                                $coachteam->setassistants($HT->getClub($teamID)->getAssistantTrainerLevels());
				                $coachteam->setformcoach($HT->getClub($teamID)->getFormCoachLevels());
				                $coachteam->setdoctors($HT->getClub($teamID)->getMedicLevels());
                                $coachteam->setTeamName($team->getTeamName());

                                $TeamPlayers = $HT->getTeamPlayers($teamID, false);
							    $trainerID = $team->getTrainerId();
                                $coachteam->setleagueID($team->getLeagueId());

                                $i=1;
						        
					
						        while($i <= $TeamPlayers->getNumberPlayers()) {
							        $player = $TeamPlayers->getPlayer($i);
							
							        if ($player->getId() == $trainerID) {
								        $coachteam->settrainerskill($player->getTrainerSkill());
								        break;
							        }			
							        $i++;
						        }
                                $i=1;
                                //myLog($log, $coach->getTeamname().'('.$coach->getId().') Aantal spelers:'.$TeamPlayers->getNumberPlayers());
						
						        while($i <= $TeamPlayers->getNumberPlayers()) {
							        $player = $TeamPlayers->getPlayer($i);
						
							        if($player->getCountryId() == 12) {
								        $aantalDagen = ($player->getAge() * 112) + $player->getDays();
								        $dateOfBirth	=	strtotime('today -'.$aantalDagen.' days');
						
								        $pos = 'onbekend';
								        $mins = 0;
								        $idlist = $idlist.$player->getId().",";
							
								        $localPlayer = PlayerDB::getPlayer($player->getId());
								        if($localPlayer == NULL) {
									        PlayerDB::insertPlayer(new Player($player->getId(), $coach->getId(), $teamID, NULL, $player->getName(), $dateOfBirth, 
										        $player->getTsi(), $player->getSalary(), $player->getInjury(), $player->getAggressiveness(), 
										        $player->getAgreeability(), $player->getHonesty(), $player->getLeadership(), $player->getSpeciality(), 
										        $player->getForm(), $player->getStamina(), $player->getExperience(), $player->getKeeper(), 
										        $player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
										        $player->getScorer(), $player->getSetPieces(), $player->getACaps(), $player->getU20Caps(), time(), time(),
										        0, 0, 0, 0, 0, 0, 0, 0, 0,
										        0, 0, 0, 0, 0, 0, 0,
										        0, 0, 0, 0, 0, 0, 0,
										        0, 0, 0, 0, 0, 0));

									        $localPlayer = PlayerDB::getPlayer($player->getId());
								        }
								
								        $matches = $HT->getSeniorTeamMatches($teamID);
								
								        $posGK = 0;
								        $posCD = 0;
								        $posWB = 0;
								        $posIM = 0;
								        $posWG = 0;
								        $posSC = 0;
								        $posSP = 0.8;
								
								        $walkover = FALSE;
								
								        for($vCount=1;$vCount<=$matches->getNumberMatches();$vCount++) {
									        $match = $matches->getMatch($vCount);
									
									        if (($match != NULL) &&
											        (! $walkover)) {
										        if ((strtotime($match->getDate()) >= $prevTrainingdate) and
												        (strtotime($match->getDate()) < $thisTrainingdate)) {
												
											        $vMatchType = $match->getType();
											
											        if (($vMatchType == 1) ||
											            ($vMatchType == 2) ||
													        ($vMatchType == 3) ||
													        ($vMatchType == 4) ||
													        ($vMatchType == 5) ||
													        ($vMatchType == 6) ||
													        ($vMatchType == 7) ||
													        ($vMatchType == 8) ||
													        ($vMatchType == 9)) {
												        $lineup = $HT->getSeniorLineup($match->getId(), $teamID);
											        }
											        else {
											          $lineup = NULL;
											          //myLog($log, 'Geen trainingswedstrijd: '.$match->getId().' type: '.$vMatchType);
											        } 
											
											        if ($lineup != NULL) {
												        $startingLineup = $lineup->getStartingLineup();
												        $vPosition = 0;
												
												        if ($startingLineup != NULL) {
													        $aantalOpgesteldeSpelers = $startingLineup->getPlayersNumber();

													        $walkover = ($aantalOpgesteldeSpelers < 9);
													
													        if (! $walkover) {
														        $aantalOpgesteldeSpelers = 0;
														
													          for($vLineUpindex=1;$vLineUpindex<=$startingLineup->getPlayersNumber();$vLineUpindex++) {
															        $vLineupPlayer = $startingLineup->getPlayer($vLineUpindex);
															
															        if ($vLineupPlayer != NULL) {
																        if (($vLineupPlayer->getRole() <> 17) &&
																		        ($vLineupPlayer->getRole() <> 18)) {
																	        $aantalOpgesteldeSpelers = $aantalOpgesteldeSpelers + 1;
																        }
															        }
														        }
														
														        $walkover = ($aantalOpgesteldeSpelers < 9);
													        }
													
													        if (! $walkover) {
														        for($vLineUpindex=1;$vLineUpindex<=$startingLineup->getPlayersNumber();$vLineUpindex++) {
															        $vLineupPlayer = $startingLineup->getPlayer($vLineUpindex);
															
															        if ($vLineupPlayer != NULL) {
																        if ($vLineupPlayer->getId() == $player->getId()) {
																	        if ($vLineupPlayer->getRole() >= 100) {
																		        $vPosition = $vLineupPlayer->getRole();
																		        //myLog($log, $player->getName()." start op ".$vPosition);
																		        AddPlayTime($vPosition, 90, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC);  
																	        }
																	        else {
																		        if ($vLineupPlayer->getRole() == 17) {
																			        $posSP = 1;
																		        }
																		        else if ($vLineupPlayer->getRole() == 18) {
																			        $vAanvoerder = 1;
																		        }
																	        }
																        }
															        }
														        }
													        }
												        }
											        }
											
											        if ((! $walkover) &&
													        ($lineup != NULL)) {
												        for ($vSubstitutionIndex=1;$vSubstitutionIndex<=$lineup->getSubstitutionNumber();$vSubstitutionIndex++) {
													        $vSubstitutionLineup = $lineup->getSubstitution($vSubstitutionIndex); 
													
													        if ($vSubstitutionLineup != NULL) {												
														        $vNewPosition = $vPosition;
														
														        if ($vSubstitutionLineup->getMinute() > 90) {
															        $vAantalMinuten = 0;
														        }
														        else {
															        $vAantalMinuten = 90 - $vSubstitutionLineup->getMinute();
														        }
														
														        if (($vSubstitutionLineup->getPlayerOutId() == $player->getId()) && ($vAantalMinuten > 0)) {
															        if ($vSubstitutionLineup->getNewPositionId() == 0) {
																        AddPlayTime($vPosition, $vAantalMinuten * -1, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC); 
																        //myLog($log, "Blessure zonder wissel:".$player->getName()." positie = ".$vPosition);
															        }
															        else
															        {
																        if ($vSubstitutionLineup->getNewPositionId() <> $vPosition) {
																	        AddPlayTime($vPosition, $vAantalMinuten * -1, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC);
																	
																	        if ($vSubstitutionLineup->getPlayerInId() == $vSubstitutionLineup->getPlayerOutId()) {
																		        AddPlayTime($vSubstitutionLineup->getNewPositionId(), $vAantalMinuten, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC);
																	        }
																	        $vNewPosition = $vSubstitutionLineup->getNewPositionId();
																        }
																        else {
																	        AddPlayTime($vSubstitutionLineup->getNewPositionId(), $vAantalMinuten * -1, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC);  
																        }
															        }
															        //myLog($log, $player->getName()." UIT op ".$vSubstitutionLineup->getMinute()." plek: ".$vSubstitutionLineup->getNewPositionId()); 
														        }
														
														        if (($vSubstitutionLineup->getPlayerInId() == $player->getId()) && ($vAantalMinuten > 0)) {
															        $vNewPosition = $vSubstitutionLineup->getNewPositionId();
															
															        if (($vPosition > 0) &&
																	        (($vSubstitutionLineup->getPlayerInId() <> $vSubstitutionLineup->getPlayerOutId())) or
																	         ($vPosition <> $vNewPosition)) {
																        //als hij reeds stond opgesteld, dan is er een positiewisseling
																        //nu moet helaas uitgezocht worden aan de hand van de positie van de speler waarmee hij wisselt wat zijn nieuwe positie wordt...
																        AddPlayTime($vPosition, $vAantalMinuten * -1, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC);
																
																
																        for($vLineUpindex=1;$vLineUpindex<=$startingLineup->getPlayersNumber();$vLineUpindex++) {
																	        $vLineupPlayer = $startingLineup->getPlayer($vLineUpindex);
																
																	        if ($vLineupPlayer != NULL) {
																		        if ($vLineupPlayer->getId() == $vSubstitutionLineup->getPlayerOutId()) {
																			        if ($vLineupPlayer->getRole() >= 100) {
																				        $vNewPosition = $vLineupPlayer->getRole();
																				        break;
																			        }
																		        }
																	        }
																        }
															        }
															        AddPlayTime($vNewPosition, $vAantalMinuten, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC);  
															        //myLog($log, $player->getName()." IN op ".$vSubstitutionLineup->getMinute()." plek: ".$vPosition.' -> '.$vNewPosition);
															        $vPosition = $vNewPosition;
														        }
														
														        $vPosition = $vNewPosition;
													        }
												        }
												        $seniorMatch = $HT->getSeniorMatchDetails($match->getId(), FALSE);
												        $vKaarten = $seniorMatch->getTotalCards();
												
												        for ($vKaartenIndex=1;$vKaartenIndex<=$vKaarten;$vKaartenIndex++) {
												          $card = $seniorMatch->getCard($vKaartenIndex);
													
													        if (($card->getType() == 2) &&
													            ($card->getPlayerid() == $player->getId())) {
														        if ($card->getMinute() > 90) {
															        $vAantalMinuten = 0;
														        }
														        else {
															        $vAantalMinuten = 90 - $card->getMinute();
														        }
													          AddPlayTime($vPosition, $vAantalMinuten * -1, $posGK, $posCD, $posWB, $posIM, $posWG, $posSC); 
														        //myLog($log, "Rode kaart:".$player->getName()." positie = ".$vPosition);
													        }
												        }
											        }
											        //myLog($log, $player->getName().": ".$vPosition." / ".$posGK." / ".$posCD." / ".$posWB." / ".$posIM." / ".$posWG." / ".$posSC);
										        }
									        }
								        }
								
								        if ($walkover) {
									        $posGK = 0;
									        $posCD = 0;
									        $posWB = 0;
									        $posIM = 0;
									        $posWG = 0;
									        $posSC = 0;
									        //myLog($log, "WALKOVER!: ".$player->getName()."(".$player->getId().")");
								        }
								
								        if (($training->getLastTrainingTrainingType() == $HT_TR_SP)) {
									        if (($posSP < 1) && ($posGK > 0)) {
										        $posSP = 0.8 + ($posGK / 90 * 0.2);											
									        }
									        if ($posSP > 1) {
										        $posSP = 1;
									        }
									        $localPlayer->addSubSkill($HT_TR_SP, $posSP, $posGK + $posCD + $posWB + $posIM + $posWG + $posSC);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_DEF) && (($posCD + $posWB) > 0)) {
									        $localPlayer->addSubSkill($HT_TR_DEF, 1, $posCD + $posWB);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_SCO) && ($posSC > 0)) {
									        $localPlayer->addSubSkill($HT_TR_SCO, 1, $posSC);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_CRO) && ($posWG > 0)) {
									        $localPlayer->addSubSkill($HT_TR_CRO, 1, $posWG);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_CRO) && ($posWB > 0)) {
									        if (($posWB + $posWG) > 90) {
										        $posWB = $posWB - (($posWB + $posWG) - 90);
									        }
									        $localPlayer->addSubSkill($HT_TR_CRO, 0.5, $posWB);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_SHO)) {
									        $localPlayer->addSubSkill($HT_TR_SHO, 1, $posGK + $posCD + $posWB + $posIM + $posWG + $posSC);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_PAS) && (($posIM + $posWG + $posSC) > 0)) {
									        $localPlayer->addSubSkill($HT_TR_PAS, 1, $posIM + $posWG + $posSC);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_PM) && ($posIM > 0)) {
									        $localPlayer->addSubSkill($HT_TR_PM, 1, $posIM);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_PM) && ($posWG > 0)) {
									        if (($posWG + $posIM) > 90) {
										        $posWG = $posWG - (($posWG + $posIM) - 90);
									        }
									        $localPlayer->addSubSkill($HT_TR_PM, 0.5, $posWG);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_GK) && ($posGK > 0)) {
									        $localPlayer->addSubSkill($HT_TR_GK, 1, $posGK);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_OPM) && (($posCD + $posWB + $posIM + $posWG) > 0)) {
									        $localPlayer->addSubSkill($HT_TR_OPM, 1, $posCD + $posWB + $posIM + $posWG);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_CTR) && (($posGK + $posCD + $posWB + $posIM + $posWG) > 0)) {
									        $localPlayer->addSubSkill($HT_TR_CTR, 1, $posGK + $posCD + $posWB + $posIM + $posWG);	
								        }
								        else if (($training->getLastTrainingTrainingType() == $HT_TR_VLA) && (($posWG + $posSC) > 0)) {
									        $localPlayer->addSubSkill($HT_TR_VLA, 1, $posWG + $posSC);	
								        }
								
								        $localPlayer->update($coach->getId(), $teamID, $dateOfBirth, $player->getTsi(), $player->getSalary(), $player->getInjury(), 
									        $player->getForm(), $player->getStamina(), $player->getExperience(), $player->getKeeper(), 
									        $player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
									        $player->getScorer(), $player->getSetPieces(), $player->getACaps(), $player->getU20Caps(), time());
							
								        $localPlayer->calcIndicesAndUpdateToDB();
							        }
							        $i++;
						        } 

                                try {
							        $coach->setLastTraining(date("Y-m-d", $thisTrainingdate)); 
							        $vLastHTlogin = strtotime($team->getLastLoginDate());
							
							        if ($vLastHTlogin > 0) {
								        $coach->setlastHTlogin($team->getLastLoginDate());
							        }
							        else {
								        $coachteam->setbot(-1);
							        }
							
							        $coach->setTeamname($team->getTeamname());
							        CoachDB::updateCoach($coach);
						        }
						        catch(HTError $e) {
							        myLog($log, "Error: ".$e);
						        }

                                CoachDB::updateCoachTeam($coachteam);    
                            } // team not null
                        } // foreeach
                       
                       if (strlen($idlist) == 0) {
							$idlist = "0,";
					    }
						
					    $idlist = substr($idlist, 0, -1);
						PlayerDB::clearNonExistingPlayer($coach->getId(), $idlist); 
					}
					else {
						//myLog($log, $coach->getTeamname().'('.$coach->getId().') GEEN HTuserToken!');
					}
				}
				catch(HTError $e) {
					$errpos = strpos($e, 'Access is denied');
					if ($errpos !== false) {
						//myLog($log, " Access denied voor: ".$coach->getTeamname());
						
						$coach->setHTuserToken('');
						$coach->setHTuserTokenSecret('');
						CoachDB::updateCoach($coach);
					}
					else {
						$errpos = strpos($e, 'An application error occurred on the server');
						if ($errpos !== false) {
							//myLog($log, " Application error voor: ".$coach->getTeamname());
							
							$coach->setHTuserToken('');
							$coach->setHTuserTokenSecret('');
							CoachDB::updateCoach($coach);
						}
						else {
							myLog($log, $e);
						}
					}
				}
				$HT->clearTeamsPlayers();
				$HT->clearPlayers();
				$HT->clearSeniorTeamsMatches();
				$HT->clearSeniorMatchesDetails();
				$HT->clearSeniorTeamsArchiveMatches();
				$HT->clearSeniorLineups();
				$HT->clearClubs();
				$HT->clearTeams();
				$HT->clearEconomy();
				$HT->clearTrainings();
				$HT->clearTrainingsStats();
                $HT->ClearPrimaryTeam();
                $HT->clearSecondaryTeam();
			}
		}
			
		$allPlayers = PlayerDB::getPlayerWithoutCoach($a);
		if ($allPlayers != Null) {
			myLog($log, "Start players without coach aantal: ".count($allPlayers));
			$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
				
			$coach = CoachDB::LoginUser('__auto_Pays', '');
			$HT->setOauthToken($coach->getHTuserToken());
			$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());

			foreach($allPlayers AS $player) {
				if ($player != Null) {
					//myLog($log, "playerID = ".$player->getId());
					try {
						$HTplayer = $HT->getPlayer($player->getId());
						
						if ($HTplayer != Null) {
							$aantalDagen = ($HTplayer->getAge() * 112) + $HTplayer->getDays();
							$dateOfBirth =	strtotime('today -'.$aantalDagen.' days');
							
							try {
								$teamID = $HTplayer->getTeamId();
							}
							catch(HTError $e) {
								$teamID = 0;
							}
							
							if ($teamID <= 0) {	
								//myLog($log, "player deleted");
								PlayerDB::deletePlayer($player->getId());
							}
							else {
								$userID = 0;
								//echo "teamID = ".$teamID."<BR>";
								if ($teamID > 0) {
									$team = $HT->getTeam($teamID);
									$userID = $team->getUserId();
									
									if ($userID <= 0) {
										$userID = -1;
									}
									//echo "userID = ".$userID."<BR>";
								}
								
								if ($HTplayer->isSkillsAvailable()) {
									$player->update($userID, $teamID, $dateOfBirth, $HTplayer->getTsi(), $HTplayer->getSalary(), $HTplayer->getInjury(), 
										$HTplayer->getForm(), $HTplayer->getStamina(), $HTplayer->getExperience (), $HTplayer->getKeeper(), 
										$HTplayer->getDefender(), $HTplayer->getPlaymaker(), $HTplayer->getWinger(), $HTplayer->getPassing(), 
										$HTplayer->getScorer(), $HTplayer->getSetPieces(), $HTplayer->getACaps(), $HTplayer->getU20Caps(), time());
								}
								else {
									$player->update($userID, $teamID, $dateOfBirth, $HTplayer->getTsi(), $HTplayer->getSalary(), $HTplayer->getInjury(), 
										$HTplayer->getForm(), $HTplayer->getStamina(), $HTplayer->getExperience (), $player->getKeeper(), 
										$player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
										$player->getScorer(), $player->getSetPieces(), $player->getCaps(), $player->getCapsU20(), $player->getLastupdate());
								}
								
								if ($userID > 0) {
									$playercoach = CoachDB::getCoach($userID);
									if ($playercoach == NULL) {
										if ($team != NULL) {
											if ($team->isBot()) {
												CoachDB::insertCoach(new Coach($userID, $teamID, $HTplayer->getTeamname(), 
													"user", "", "", "", "", "",
													0, 0, 0, 0, 0, 0, 0, 0, 0, -1));										}
											else {
												//myLog($log, "Last Login = ".$team->getLastLoginDate());
												CoachDB::insertCoach(new Coach($userID, $teamID, $HTplayer->getTeamname(), 
													"user", "", "", "", "", "",
													0, 0, 0, 0, 0, 0, 0, 0, $team->getLastLoginDate(), 0, $team->getLeagueId()));
											}
											
										}
									}
									else {
										if ($team != NULL) {
                                            $coachteam = CoachDB::getCoachTeam($playercoach->getId(), $teamID); 
											if ($team->isBot()) {
												$coachteam->setbot(-1);
												$playercoach->setlastHTlogin(date("d-m-y H:i", 0));
											}
											else {
												$coachteam->setbot(0);
												//myLog($log, "last login = ".$team->getLastLoginDate());
												$playercoach->setlastHTlogin($team->getLastLoginDate());
											}

											CoachDB::updateCoach($playercoach);
                                            CoachDB::updateCoachTeam($coachteam);    
										}
									}
								}
							}
						}
					}
					catch(HTError $e) {
						//myLog($log, "player deleted");
						PlayerDB::deletePlayer($player->getId());
					}
				}
				$HT->clearTeamsPlayers();
				$HT->clearPlayers();
				$HT->clearSeniorTeamsMatches();
				$HT->clearSeniorMatchesDetails();
				$HT->clearSeniorTeamsArchiveMatches();
				$HT->clearSeniorLineups();
				$HT->clearClubs();
				$HT->clearTeams();
				$HT->clearEconomy();
				$HT->clearTrainings();
				$HT->clearTrainingsStats();
			}
		}
		//myLog($log, "Einde controle spelers zonder coach");
		
		if ($a < 100) {
			$datum = strtotime("-20 days", time());
			
			try {
				$allCoaches = CoachDB::getAllCoachesLoginUpdate(date("Y-m-d", $datum), $a);
				if ($allCoaches != Null) {
					myLog($log, "Start coachHTlogin aantal: ".count($allCoaches));
					
					$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		
					$coach = CoachDB::LoginUser('__auto_Pays', '');
					$HT->setOauthToken($coach->getHTuserToken());
					$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
					
					foreach($allCoaches AS $coach) {
						if ($coach != Null) {
							try {
								$team = $HT->getTeam($coach->getTeamid());
								//myLog($log, $coach->getTeamid(). " ");
								if ($team != Null) {
									$vLastHTlogin = strtotime($team->getLastLoginDate());
									
									if ($vLastHTlogin > 0) {
										$coach->setlastHTlogin($team->getLastLoginDate());
										//myLog($log, date("d-m-y H:i", $vLastHTlogin));
										CoachDB::updateCoach($coach);
									}
									else {
										//myLog($log, "BOT");;
                                        $coachteam = CoachDB::getCoachTeam($coach->getId(), $teamID); 
                    					$coachteam->setbot(-1);
                                        CoachDB::updateCoachTeam($coachteam);    
                    				}
								}
								else {
								  myLog($log, "team is null");;
								}
							}
							catch(HTError $e) {
								myLog($log, "Error in coachHTlogin: ".$e);
							}
						}
					}
				}
			}
			catch(HTError $e) {
				myLog($log, "Error: ".$e);
			}
			//myLog($log, "Eind coachHTlogin");
		}	
		CoachDB::setTrainingRunning(FALSE);

		$a = $a + 1;
		header("Location: ".$config['url'].'/scanTraining.php?a='.$a);
		
	}
} 
catch(HTError $e) {
	myLog($log, $e);
}

ini_set("max_execution_time", "30");
ini_set('memory_limit','128M');
ini_set('output_buffering', 4096);
ini_set('implicit_flush', 0);
?>
