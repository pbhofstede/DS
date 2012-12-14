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
//	echo $aStr.'<BR>';
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
	$log->lfile('log/scanGespeeld');

	if( !ini_get('safe_mode') ){
		myLog($log, "Safe mode off: setting time limit = 0");
		set_time_limit(0);
	} 
	else {
		myLog($log, "Safe mode...");
	}	
		
	$a = 0;
	if(isset($_GET['a'])) {
	  $a = $_GET['a'];
	}
	
	if ($a < 10) {
		$knownLastTrainingdate = strtotime(CoachDB::getLastTrainingdate());

		$maandagNaTraining = strtotime("+3 days", $knownLastTrainingdate);
		$dinsdagMiddagNaTraining = $maandagNaTraining + (86400 * 1.5);
		
		myLog($log, "Known Last Trainingdate: ".$knownLastTrainingdate);
		myLog($log, date("Y-m-d", $knownLastTrainingdate));
		
				
		myLog($log, "maandagNaTraining: ".$maandagNaTraining);
		myLog($log, date("Y-m-d", $maandagNaTraining));
		
		myLog($log, "dinsdagMiddagNaTraining: ".$dinsdagMiddagNaTraining);
		myLog($log, date("Y-m-d H:i", $dinsdagMiddagNaTraining));
		
		if ((time() > $maandagNaTraining) && (time() < $dinsdagMiddagNaTraining)) {
			if ($a == 0) {
				PlayerDB::clearsundayTraining();
			}
			$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
			$coaches = CoachDB::getCoachList();
			myLog($log, "Start");
			myLog($log, "Coaches: ".count($coaches));
			$aantalScanned = 0;
			
			if (count($coaches) > 0) {			
				myLog($log, "Start");
				
				for ($count = 0; $count < count($coaches); $count++) {
					$coach = $coaches[$count];
					
					if (($coach->getId() % 10 == $a) &&
							($coach->getHTuserToken() <> '') && 
							(CoachDB::getCoachHasInterestingPlayers($coach->getId()))) {
						try {
							$aantalScanned = $aantalScanned + 1;
							
							$HT->setOauthToken($coach->getHTuserToken());
							$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
						
							$training = $coach->gettrainingtype();
											
							$TeamPlayers = $HT->getTeamPlayers(null, false);
							$team = $HT->getTeam();
							
							$coach->setleagueID($team->getLeagueId());
						
							$i=1;
							
							myLog($log, $coach->getTeamname().'('.$coach->getId().')');
						
							$idlist	= '';
					
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
											
										$localPlayer = PlayerDB::getPlayer($player->getId());
										$localPlayer->calcIndicesAndUpdateToDB();
									}
										
									$matches = $HT->getSeniorTeamMatches();
									
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
											if ((strtotime($match->getDate()) >= $knownLastTrainingdate) and
													(strtotime($match->getDate()) < $dinsdagMiddagNaTraining)) {
											
												$vMatchType = $match->getType();
											/*										
Value	Description
1	League match
2	Qualification match
3	Cup match (standard league match)
4	Friendly (normal rules)
5	Friendly (cup rules)
6	Not currently in use, but reserved for international competition matches with normal rules (may or may not be implemented at some future point).
7	Hattrick Masters
8	International friendly (normal rules)
9	Internation friendly (cup rules)
10	National teams competition match (normal rules)
11	National teams competition match (cup rules)
12	National teams friendly
50	Tournament League match
51	Tournament Playoff match
100	Youth league match
101	Youth friendly match
102	RESERVED
103	Youth friendly match (cup rules)
104	RESERVED
105	Youth international friendly match
106	Youth international friendly match (Cup rules)
107	RESERVED
*/

												if (($vMatchType == 1) ||
														($vMatchType == 2) ||
														($vMatchType == 3) ||
														($vMatchType == 4) ||
														($vMatchType == 5) ||
														($vMatchType == 6) ||
														($vMatchType == 7) ||
														($vMatchType == 8) ||
														($vMatchType == 9)) {
												  $lineup = $HT->getSeniorLineup($match->getId());
												}
												else {
													$lineup = NULL;
													//myLog($log, 'Geen trainingswedstrijd: '.$match->getId().' type: '.$vMatchType);
												} 
												
												if ($lineup != NULL) {
													$startingLineup = $lineup->getStartingLineup();
													$vPosition = 0;
													
													if ($startingLineup != NULL) {
														$walkover = $startingLineup->getPlayersNumber() < 9;
														
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
															myLog($log, "Rode kaart:".$player->getName()." positie = ".$vPosition);
														}
													}
												}
												//myLog($log, $player->getName().": ".$vPosition." / ".$posGK." / ".$posCD." / ".$posWB." / ".$posIM." / ".$posWG." / ".$posSC);
											}
										}
										
										if ($walkover) {
											$posGK = 0;
											$posCD = 0;
											$posWB = 0;
											$posIM = 0;
											$posWG = 0;
											$posSC = 0;
											myLog($log, "WALKOVER!: ".$player->getName()."(".$player->getId().")");
										}
									
										$localPlayer->setsundayTraining(0);
										
										if (($training == $HT_TR_SP)) {
											if (($posSP < 1) && ($posGK > 0)) {
												$posSP = 0.8 + ($posGK / 90 * 0.2);											
											}
											if ($posSP > 1) {
												$posSP = 1;
											}
											$localPlayer->addSundayTraining($HT_TR_SP, $posSP, $posGK + $posCD + $posWB + $posIM + $posWG + $posSC);	
										}
										else if (($training == $HT_TR_DEF) && (($posCD + $posWB) > 0)) {
											$localPlayer->addSundayTraining($HT_TR_DEF, 1, $posCD + $posWB);	
										}
										else if (($training == $HT_TR_SCO) && ($posSC > 0)) {
											$localPlayer->addSundayTraining($HT_TR_SCO, 1, $posSC);	
										}
										else if (($training == $HT_TR_CRO) && ($posWG > 0)) {
											$localPlayer->addSundayTraining($HT_TR_CRO, 1, $posWG);	
										}
										else if (($training == $HT_TR_CRO) && ($posWB > 0)) {
											if (($posWB + $posWG) > 90) {
												$posWB = $posWB - (($posWB + $posWG) - 90);
											}
											$localPlayer->addSundayTraining($HT_TR_CRO, 0.5, $posWB);	
										}
										else if (($training == $HT_TR_SHO)) {
											$localPlayer->addSundayTraining($HT_TR_SHO, 1, $posGK + $posCD + $posWB + $posIM + $posWG + $posSC);	
										}
										else if (($training == $HT_TR_PAS) && (($posIM + $posWG + $posSC) > 0)) {
											$localPlayer->addSundayTraining($HT_TR_PAS, 1, $posIM + $posWG + $posSC);	
										}
										else if (($training == $HT_TR_PM) && ($posIM > 0)) {
											$localPlayer->addSundayTraining($HT_TR_PM, 1, $posIM);	
										}
										else if (($training == $HT_TR_PM) && ($posWG > 0)) {
											if (($posWG + $posIM) > 90) {
												$posWG = $posWG - (($posWG + $posIM) - 90);
											}
											$localPlayer->addSundayTraining($HT_TR_PM, 0.5, $posWG);	
										}
										else if (($training == $HT_TR_GK) && ($posGK > 0)) {
											$localPlayer->addSundayTraining($HT_TR_GK, 1, $posGK);	
										}
										else if (($training == $HT_TR_OPM) && (($posCD + $posWB + $posIM + $posWG) > 0)) {
											$localPlayer->addSundayTraining($HT_TR_OPM, 1, $posCD + $posWB + $posIM + $posWG);	
										}
										else if (($training == $HT_TR_CTR) && (($posGK + $posCD + $posWB + $posIM + $posWG) > 0)) {
											$localPlayer->addSundayTraining($HT_TR_CTR, 1, $posGK + $posCD + $posWB + $posIM + $posWG);	
										}
										else if (($training == $HT_TR_VLA) && (($posWG + $posSC) > 0)) {
											$localPlayer->addSundayTraining($HT_TR_VLA, 1, $posWG + $posSC);	
										}
										
										$localPlayer->update($coach->getId(), $dateOfBirth, $player->getTsi(), $player->getSalary(), $player->getInjury(), 
											$player->getForm(), $player->getStamina(), $player->getExperience (), $player->getKeeper(), 
											$player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
											$player->getScorer(), $player->getSetPieces(), $player->getACaps(), $player->getU20Caps(), time());
							
										$localPlayer->calcIndicesAndUpdateToDB();
									} 
								}
								$i++;
							}
						
							try {
								$vLastHTlogin = strtotime($team->getLastLoginDate());
								
								if ($vLastHTlogin > 0) {
									$coach->setlastHTlogin($team->getLastLoginDate());
								}
								else {
									$coach->setbot(-1);
								}
								CoachDB::updateCoach($coach);
							
								if (strlen($idlist) == 0) {
									$idlist = "0,";
								}
							
								$idlist = substr($idlist, 0, -1);
								PlayerDB::clearNonExistingPlayer($coach->getId(), $idlist);
							}
							catch(HTError $e) {
								myLog($log, "Error: ".$e);
							}
						}
						catch(HTError $e) {
							$errpos = strpos($e, 'Access is denied');
							if ($errpos !== false) {
								myLog($log, " Access denied voor: ".$coach->getTeamname());
								
								$coach->setHTuserToken('');
								$coach->setHTuserTokenSecret('');
								CoachDB::updateCoach($coach);
							}
							else {
								$errpos = strpos($e, 'An application error occurred on the server');
								if ($errpos !== false) {
									myLog($log, " Application error voor: ".$coach->getTeamname());
									
									$coach->setHTuserToken('');
									$coach->setHTuserTokenSecret('');
									CoachDB::updateCoach($coach);
								}
								else {
									myLog($log, "Error: ".$e);
								}
							}
						}
						$HT->clearTeamsPlayers();
						$HT->clearPlayers();
						$HT->clearSeniorTeamsMatches();
						$HT->clearSeniorMatchesDetails();
						$HT->clearSeniorTeamsArchiveMatches();
						$HT->clearSeniorLineups();
						$HT->clearClub();
						$HT->clearTeams();
						$HT->clearEconomy();
						$HT->clearTraining();
						$HT->clearTrainingStats();
					}
				}
			}
		}
		
		$a = $a + 1;
		header("Location: ".$config['url'].'/scanGespeeld.php?a='.$a);
	}
} catch(HTError $e) {
	myLog($log, $e);
}
	
myLog($log, "Eind aantal scanned: ".$aantalScanned);



ini_set("max_execution_time", "30");
ini_set('memory_limit','128M');
ini_set('output_buffering', 4096);
ini_set('implicit_flush', 0);
?>
