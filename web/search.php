<?php
include ('header.php');

$specialityArray['0']	=	'Geen';
$specialityArray['1']	=	'Technisch';
$specialityArray['2']	=	'Snel';
$specialityArray['3']	=	'Krachtig';
$specialityArray['4']	=	'Onvoorspelbaar';
$specialityArray['5']	=	'Koppen';
$specialityArray['6']	=	'Regainer';

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

//Functie dropdownmenu level
	function showDropdown($name) {
		$levelArray['0']	=	'niet-bestaand'; // standaard
		$levelArray['1']	=	'Rampzalig';
		$levelArray['2']	=	'Waardeloos';
		$levelArray['3']	=	'Slecht';
		$levelArray['4']	=	'Zwak';
		$levelArray['5']	=	'Matig';
		$levelArray['6']	=	'Redelijk';
		$levelArray['7']	=	'Goed';
		$levelArray['8']	=	'Uitstekend';			
		$levelArray['9']	=	'Formidabel';
		$levelArray['10']	=	'Uitmuntend';
		$levelArray['11']	=	'Briljant';
		$levelArray['12']	=	'Wonderbaarlijk';
		$levelArray['13']	=	'Wereldklasse';
		$levelArray['14']	=	'Bovennatuurlijk';
		$levelArray['15']	=	'Reusachtig';
		$levelArray['16']	=	'Buitenaards';
		$levelArray['17']	=	'Mythisch';
		$levelArray['18']	=	'Magisch';
		$levelArray['19']	=	'Utopisch';
		$levelArray['20']	=	'Goddelijk';
		
		$output		=	'<select name="'.$name.'">';
		
		foreach($levelArray AS $key => $value) {
			if(empty($_GET[$name]) && $key == '0') {
				$output	.=	'<option value="'.$key.'" selected>'.$value.'</option>';
			} elseif(isset($_GET[$name]) && ($key == $_GET[$name])) {
				$output .= '<option value="'.$key.'" selected>'.$value.'</option>';
			} else {
				$output	.= '<option value="'.$key.'">'.$value.'</option>';
			}
		}

		$output		.=	'</select>';
		
		return $output;
	}

	echo '<h1>Spelers zoeken</h1>';
	echo 'Hier is het mogelijk specifieke spelers te zoeken.<br />';
	echo 'De eisen zijn minimum eisen. ';
	echo 'Bij minimalen eisen met veel resultaat zullen slechts de eerste 100 spelers weergegeven worden.';
//Zoeken	
	echo '<h2>Zoekopdracht</h2>';
	echo '<form action="" method="GET">';
	echo '<TABLE>';
	echo '<TR><TD><label>Leeftijd Min</label></TD><TD>';
	if(!empty($_GET['ageMinimum'])) {
		echo '<input type="text" name="ageMinimum" value="'.$_GET['ageMinimum'].'" size="3" />';
	} else {
		echo '<input type="text" name="ageMinimum" value="17" size="3" />';
	}
	echo '</TD><TD><label>Index GK >=</label></TD><TD>';
	if(!empty($_GET['indexGK'])) {
		echo '<input type="text" name="indexGK" value="'.$_GET['indexGK'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexGK" value="" size="5" />';
	}
	echo '</TD></TR>';	
	
	echo '<TR><TD><label>Leeftijd Max</label></TD><TD>';
	if(!empty($_GET['ageMaximum'])) {
		echo '<input type="text" name="ageMaximum" value="'.$_GET['ageMaximum'].'" size="3" />';
	} else {
		echo '<input type="text" name="ageMaximum" value="36" size="3" />';
	}
	echo '</TD><TD><label>Index CD >=</label></TD><TD>';
	if(!empty($_GET['indexCD'])) {
		echo '<input type="text" name="indexCD" value="'.$_GET['indexCD'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexCD" value="" size="5" />';
	}
	echo '</TD></TR>';
	
	echo '<TR><TD><label>Specialiteit</label></TD><TD>';
	echo '<select name="speciality">';
			foreach($specialityArray AS $key => $value) {
				if(empty($_GET['speciality']) && $key == '0') {
					echo '<option value="'.$key.'" selected>'.$value.'</option>';
				} elseif($key == $_GET['speciality']) {
					echo '<option value="'.$key.'" selected>'.$value.'</option>';
				} else {
					echo '<option value="'.$key.'">'.$value.'</option>';
				}
			}
	echo '</select></TD><TD><label>Index DEF >=</label></TD><TD>';
	if(!empty($_GET['indexDEF'])) {
		echo '<input type="text" name="indexDEF" value="'.$_GET['indexDEF'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexDEF" value="" size="5" />';
	}
	echo '</TD></TR>';
	
	echo '<TR><TD><label>Keepen</label></TD><TD>'.showDropdown('keeper').'</TD><TD><label>Index WB >=</label></TD><TD>';
	if(!empty($_GET['indexWB'])) {
		echo '<input type="text" name="indexWB" value="'.$_GET['indexWB'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexWB" value="" size="5" />';
	}
	echo '</TD></TR>';
	echo '<TR><TD><label>Verdedigen</label></TD><TD>'.showDropdown('defender').'</TD><TD><label>Index IM >=</label></TD><TD>';
	if(!empty($_GET['indexIM'])) {
		echo '<input type="text" name="indexIM" value="'.$_GET['indexIM'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexIM" value="" size="5" />';
	}
	echo '</TD></TR>';
	echo '<TR><TD><label>Positiespel</label></TD><TD>'.showDropdown('playmaker').'</TD><TD><label>Index WG >=</label></TD><TD>';
	if(!empty($_GET['indexWG'])) {
		echo '<input type="text" name="indexWG" value="'.$_GET['indexWG'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexWG" value="" size="5" />';
	}
	echo '</TD></TR>';
	
	echo '<TR><TD><label>Vleugelspel</label></TD><TD>'.showDropdown('winger').'</TD><TD><label>Index SC >=</label></TD><TD>';
	if(!empty($_GET['indexSC'])) {
		echo '<input type="text" name="indexSC" value="'.$_GET['indexSC'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexSC" value="" size="5" />';
	}
	echo '</TD></TR>';
	
	
	echo '<TR><TD><label>Passen</label></TD><TD>'.showDropdown('passing').'</TD><TD><label>Index DFW >=</label></TD><TD>';
	if(!empty($_GET['indexDFW'])) {
		echo '<input type="text" name="indexDFW" value="'.$_GET['indexDFW'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexDFW" value="" size="5" />';
	}
	echo '</TD></TR>';
	
	echo '<TR><TD><label>Scoren</label></TD><TD>'.showDropdown('scorer').'</TD><TD><label>Index SP >=</label></TD><TD>';
	if(!empty($_GET['indexSP'])) {
		echo '<input type="text" name="indexSP" value="'.$_GET['indexSP'].'" size="5" />';
	} else {
		echo '<input type="text" name="indexSP" value="" size="5" />';
	}
	echo '</TD></TR>';

	echo '<TR><TD><label>Spelhervatten</label></TD><TD>'.showDropdown('setPieces').'</TD><TD></TD><TD></TD></TR>';
	
	echo '<TR><TD><label>Speler ID</label></TD><TD>';
	if (isset($_GET['playerId'])) {
		echo '<input type="text" name="playerId" size="30" value="'.$_GET['playerId'].'"/>';
	}
	else
	{
		echo '<input type="text" name="playerId" size="30" value=""/>';
	}
	echo '<TD></TD><TD></TD></TR>';
	echo '<TR><TD><label>Spelernaam</label></TD><TD>';
	if (isset($_GET['playerName'])) {
		echo '<input type="text" name="playerName" size="30" value="'.$_GET['playerName'].'"/>';
	}
	else
	{
		echo '<input type="text" name="playerName" size="30" value=""/>';
	}
	echo '<TD></TD><TD></TD></TR>';
	
	echo '<TR><TD><label>U20</label></TD><TD>';
	if ((isset($_GET['u20'])) && 
	    ($_GET['u20'])) {		
		echo '<input type="checkbox" name="u20" CHECKED/>';
	}
	else
	{
		echo '<input type="checkbox" name="u20"/>';
	}
	
	echo '<TD><label>Incl. update ouder 16wk</label></TD><TD>';
	if ((isset($_GET['inclOLD'])) && 
	    ($_GET['inclOLD'])) {		
		echo '<input type="checkbox" name="inclOLD" CHECKED/>';
	}
	else
	{
		echo '<input type="checkbox" name="inclOLD"/>';
	}
	echo '</TD></TR>';

	echo '</TABLE>';
			
	echo '<label>&nbsp;</label>';
	echo '<input type="submit" name="submit" value="Zoek!" />';
	echo '</p>';
//Als gezocht
	if ((isset($_GET['submit'])) || isset($_GET['orderby'])){
		echo '<h2>Resultaat</h2>';
		if(!empty($_GET['playerId']) && !ctype_digit(trim($_GET['playerId']))) {
			echo '<script type="text/javascript">';
				echo 'alert(\'Ingevulde waarde is geen getal\');';
			echo '</script>';
// Als gezocht op speler ID			
		} else if(!empty($_GET['playerId'])) {
			$player		=	PlayerDB::getPlayer(trim($_GET['playerId']));
			if (($player != NULL) &&
          ((time() - $player->getLastupdate()) <= (8 * 86400))) {
				header("Location: ".$config['url']."/player/".$player->getId()."/");
			} 
			else {
			 	if (isset($_SESSION['dutchscouts'])) {
					$coach = CoachDB::getCoach($_SESSION['dutchscouts']); 
					$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
					$HT->setOauthToken($coach->getHTuserToken()); 
					$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());	
			 		try {
						$HTplayer = $HT->getPlayer($_GET['playerId']);
						
						if (($HTplayer != NULL) && ($HTplayer->getNativeCountryId() == 12)) {
							$aantalDagen = ($HTplayer->getAge() * 112) + $HTplayer->getDays();
							$dateOfBirth =	strtotime('today -'.$aantalDagen.' days');
						 	
							$teamID = $HTplayer->getTeamId();
							$userID = 0;
							//echo "teamID = ".$teamID."<BR>";
							if ($teamID <= 0) {
								//echo "player deleted<BR>";
								PlayerDB::deletePlayer($player->getId());
								
								echo 'Speler niet gevonden';
							}
							else {
								$team = $HT->getTeam($teamID);
								$userID = $team->getUserId();
								//echo "userID = ".$userID."<BR>";
								
								if ($player != NULL) {
									if ($HTplayer->isSkillsAvailable()) {
										$player->update($userID, $dateOfBirth, $HTplayer->getTsi(), $HTplayer->getSalary(), $HTplayer->getInjury(), 
											$HTplayer->getForm(), $HTplayer->getStamina(), $HTplayer->getExperience (), $HTplayer->getKeeper(), 
											$HTplayer->getDefender(), $HTplayer->getPlaymaker(), $HTplayer->getWinger(), $HTplayer->getPassing(), 
											$HTplayer->getScorer(), $HTplayer->getSetPieces(), $HTplayer->getACaps(), $HTplayer->getU20Caps(), time());
									}
									else {
										$player->update($userID, $dateOfBirth, $HTplayer->getTsi(), $HTplayer->getSalary(), $HTplayer->getInjury(), 
											$HTplayer->getForm(), $HTplayer->getStamina(), $HTplayer->getExperience (), $player->getKeeper(), 
											$player->getDefender(), $player->getPlaymaker(), $player->getWinger(), $player->getPassing(), 
											$player->getScorer(), $player->getSetPieces(), $player->getCaps(), $player->getCapsU20(), $player->getLastupdate());
									}
								}
								
								$playercoach = CoachDB::getCoach($userID);
								if ($playercoach == NULL) {
									if ($team != NULL) {
										if ($team->isBot()) {
											CoachDB::insertCoach(new Coach($userID, $teamID, $HTplayer->getTeamname(), 
												"user", "", "", "", "", "",
												0, 0, 0, 0, 0, 0, 0, 0, 0, -1));
										}
										else {
											CoachDB::insertCoach(new Coach($userID, $teamID, $HTplayer->getTeamname(), 
												"user", "", "", "", "", "",
												0, 0, 0, 0, 0, 0, 0, 0, $team->getLastLoginDate(), 0));
										}
										
									}
									else {
										CoachDB::insertCoach(new Coach($userID, $teamID, $HTplayer->getTeamname(), 
											"user", "", "", "", "", "",
											0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
									}
									
									$playercoach = CoachDB::getCoach($userID);
								}
								else {
									if ($team != NULL) {
										if ($team->isBot()) {
											$playercoach->setbot(-1);
											$playercoach->setlastHTlogin(date("d-m-y H:i", 0));
										}
										else {
											$playercoach->setbot(0);
											$playercoach->setlastHTlogin($team->getLastLoginDate());
										}
										CoachDB::updateCoach($playercoach);
									}
								}
								
								if ($playercoach != NULL) {
									$coachID = $playercoach->getId();
								}
								else {
									$coachID = 0;
								}
								
								if ($player == Null) {
									if ($HTplayer->isSkillsAvailable()) {
										$player = new Player($HTplayer->getId(), $coachID, $HTplayer->getName(), $dateOfBirth, 
											$HTplayer->getTsi(), $HTplayer->getSalary(), $HTplayer->getInjury(), $HTplayer->getAggressiveness(), 
											$HTplayer->getAgreeability(), $HTplayer->getHonesty(), $HTplayer->getLeadership(), $HTplayer->getSpeciality(), 
											$HTplayer->getForm(), $HTplayer->getStamina(), $HTplayer->getExperience (), $HTplayer->getKeeper(), 
											$HTplayer->getDefender(), $HTplayer->getPlaymaker(), $HTplayer->getWinger(), $HTplayer->getPassing(), 
											$HTplayer->getScorer(), $HTplayer->getSetPieces(), $HTplayer->getACaps(), $HTplayer->getU20Caps(),
											time(),time(),
											0, 0, 0, 0, 0, 0, 0, 0, 0,
											0, 0, 0, 0, 0, 0, 0,
											0, 0, 0, 0, 0, 0, 0,
											0, 0);

										$player->setU20($player->getHasU20Age() <> '');

										PlayerDB::insertPlayer($player); 
									}
								}
								
								if ($player != Null) {
									$player->calcIndicesAndUpdateToDB();
									
									header("Location: ".$config['url']."/player/".$HTplayer->getId()."/");
								}
								else {
									echo 'Speler niet gevonden';
								}
							}
						}
						else {
							if ($player != NULL)  {
								header("Location: ".$config['url']."/player/".$player->getId()."/");
							}
							else {
								echo 'Speler niet gevonden';
							}
						}		
					}
					catch(HTError $e)
					{
						
					}
				}
				else
				{
					echo 'Speler niet gevonden';
				}
			}
// Als gezocht op eisen			
		} else {
		
			$vIndexStr = '';
			$vFoundIndex = -400;
			
			if (isset($_GET['indexGK']) && ($_GET['indexGK'] <> '') && ($_GET['indexGK'] > $vFoundIndex)) {
			  $vIndexStr = 'Index GK';
				$vFoundIndex = $_GET['indexGK'];
				$orderBY = 'indexGK';
			}
			elseif (isset($_GET['indexCD']) && ($_GET['indexCD'] <> '') && ($_GET['indexCD'] > $vFoundIndex)) {
			  $vIndexStr = 'Index CD';
				$vFoundIndex = $_GET['indexCD'];
				$orderBY = 'indexCD';
			}
			elseif (isset($_GET['indexDEF']) && ($_GET['indexDEF'] <> '') && ($_GET['indexDEF'] > $vFoundIndex)) {
			  $vIndexStr = 'Index DEF';
				$vFoundIndex = $_GET['indexDEF'];
				$orderBY = 'indexDEF';
			}
			elseif (isset($_GET['indexWB']) && ($_GET['indexWB'] <> '') && ($_GET['indexWB'] > $vFoundIndex)) {
			  $vIndexStr = 'Index WB';
				$vFoundIndex = $_GET['indexWB'];
				$orderBY = 'indexWB';
			}
			else if (isset($_GET['indexIM']) && ($_GET['indexIM'] <> '') && ($_GET['indexIM'] > $vFoundIndex)) {
			  $vIndexStr = 'Index IM';
				$vFoundIndex = $_GET['indexIM'];
				$orderBY = 'indexIM';
			}
			else if (isset($_GET['indexWG']) && ($_GET['indexWG'] <> '') && ($_GET['indexWG'] > $vFoundIndex)) {
			  $vIndexStr = 'Index WG';
				$vFoundIndex = $_GET['indexWG'];
				$orderBY = 'indexWG';
			}
			else if (isset($_GET['indexSC']) && ($_GET['indexSC'] <> '') && ($_GET['indexSC'] > $vFoundIndex)) {
			  $vIndexStr = 'Index SC';
				$vFoundIndex = $_GET['indexSC'];
				$orderBY = 'indexSC';
			}
			else if (isset($_GET['indexDFW']) && ($_GET['indexDFW'] <> '') && ($_GET['indexDFW'] > $vFoundIndex)) {
			  $vIndexStr = 'Index DFW';
				$vFoundIndex = $_GET['indexDFW'];
				$orderBY = 'indexDFW';
			}
		  else if (isset($_GET['indexSP']) && ($_GET['indexSP'] <> '') && ($_GET['indexSP'] > $vFoundIndex)) {
			  $vIndexStr = 'Index SP';
				$vFoundIndex = $_GET['indexSP'];
				$orderBY = 'indexSP';
			} else {
			  $vIndexStr = 'Index';
				$vFoundIndex = '';
				$orderBY = 'dateOfBirth';
			}
			
			if (isset($_GET['orderby'])) {
				if ($_GET['orderby'] == 'Leeftijd') {
					$orderBY = 'dateOfBirth';
				}
				else if ($_GET['orderby'] == 'Index') {
					
				}
			}

			if(!empty($_GET['playerName'])) {
				$results =	PlayerDB::getPlayerByName('%'.$_GET['playerName'].'%');
			}
			else {
				$results	=	PlayerDB::searchPlayer(
					(time() - ($_GET['ageMinimum'] * 112 * 86400)), 
					(time() - (($_GET['ageMaximum'] + 1) * 112 * 86400)), 
					$_GET['keeper'], $_GET['defender'], $_GET['playmaker'], $_GET['winger'], $_GET['passing'], $_GET['scorer'], $_GET['setPieces'], 
					$_GET['speciality'], $_GET['indexGK'], $_GET['indexCD'], $_GET['indexDEF'], $_GET['indexWB'], $_GET['indexIM'],
					$_GET['indexWG'], $_GET['indexSC'], $_GET['indexDFW'], $_GET['indexSP'], $orderBY, isset($_GET['u20']), isset($_GET['inclOLD']));
			}
			
			if($results != NULL) {
				$resultaatAantal = 0;			
				
				echo '<table width="100%" class="list">';
				echo '<tr>';
					echo '<th colspan="19">Gevonden spelers</th>';
				echo '</tr>';
					echo '<tr class="niveau1">';
						echo '<td>Speler</td>';
						echo '<td>Cond%</td>';
						echo '<td>TI</td>';
						echo '<td>Trnr</td>';
						echo '<td>Ass</td>';
						echo '<td>Training</td>';
						echo '<td>% trn</td>';
						echo '<td>Ke</td>';
						echo '<td>Ve</td>';
						echo '<td>Po</td>';
						echo '<td>Vl</td>';
						echo '<td>Pa</td>';
						echo '<td>Sc</td>';
						echo '<td>Sp</td>';
						echo '<td>&nbsp;</td>';
						echo '<td><input type="submit" name="orderby" value="Leeftijd" style="background:none;border:0;color:#000000;font-weight:bold"></td>';
						echo '<td>U20</td>';
						echo '<td><input type="submit" name="orderby" value="Index" style="background:none;border:0;color:#000000;font-weight:bold"></td>';
						echo '<td>Update</td>';
					echo '</tr>';
					foreach($results AS $player) {
						$resultaatAantal = $resultaatAantal + 1;
						$vIndex = '';
						
						if ($vIndexStr == 'Index GK') {
							$vIndex = $player->getindexGK();
						}
						elseif ($vIndexStr == 'Index CD') {
							$vIndex = $player->getindexCD();
						}
						elseif ($vIndexStr == 'Index DEF') {
							$vIndex = $player->getindexDEF();
						}
						elseif ($vIndexStr == 'Index WB') {
							$vIndex = $player->getindexWB();
						}
						elseif ($vIndexStr == 'Index IM') {
							$vIndex = $player->getindexIM();
						}
						elseif ($vIndexStr == 'Index WG') {
							$vIndex = $player->getindexWG();
						}
						elseif ($vIndexStr == 'Index SC') {
							$vIndex = $player->getindexSC();
						}
						elseif ($vIndexStr == 'Index DFW') {
							$vIndex = $player->getindexDFW();
						}
						elseif ($vIndexStr == 'Index SP') {
							$vIndex = $player->getindexSP();
						}
						else {
							$vIndex = $player->getBestIndex();
						}
						
						echo '<tr onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
							echo '<td>'.$player->getName().'</td>';
							
							echo '<td>'.$player->getconditieperc().'</td>';
							echo '<td>'.$player->gettrainingintensity().'</td>';
							echo '<td>'.$player->gettrainerskill().'</td>';
							echo '<td>'.$player->getassistants().'</td>';
							echo '<td>'.$language[$player->gettrainingtype()].'</td>';
							echo '<td>'.$player->getlasttraining().'</td>';
							
							echo '<td>'.$player->getKeeperStr().'</td>';
							echo '<td bgcolor="DCDCDC">'.$player->getDefenderStr().'</td>';
							echo '<td>'.$player->getPlaymakerStr().'</td>';
							echo '<td bgcolor="DCDCDC">'.$player->getWingerStr().'</td>';
							echo '<td>'.$player->getPassingStr().'</td>';
							echo '<td bgcolor="DCDCDC">'.$player->getScorerStr().'</td>';
							echo '<td>'.$player->getSetPiecesStr().'</td>';
							echo '<td>'.$specs[$player->getSpeciality()].'</td>';							
							echo '<td>'.$player->getLeeftijdStr().'</td>';
							echo '<td>'.$player->getHasU20Age().'</td>';
							echo '<td>'.$vIndex.'</td>';							
							echo '<td>'.date("d-m-y", $player->getLastUpdate()).'</td>';
						echo '</tr>';
					}
				echo '</table>';
				if($resultaatAantal == 100) {
					echo '<script type="text/javascript">';
						echo 'alert(\'Letop! Slechts de eerste 100 spelers zijn weergegeven.\');';
					echo '</script>';
				}
			} else {
				echo 'Geen spelers gevonden die aan de eisen voldoen';
			}
		}
	}
	
	echo '</form>';
} else {
	redirect($config['url'].'/', 0);
}
include('footer.php');
?>
