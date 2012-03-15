<?php
include ('config.php');
require ('calcTraining.php');

//set_time_limit(0);

$count = 0;

//$va = $_GET['id'];
/*
for ($i = 0; $i<=9; $i++) {
	$v = $i.$va;
	$allPlayers = PlayerDB::getAllPlayers($v);

	if ($allPlayers != Null) {
		foreach($allPlayers AS $player) {
			if ($player != Null) {
				//if (! ($player->getu20()) &&
				//	 ($player->getHasU20Age() <> '')) {
				//	$player->setu20(TRUE);
				//if ($player->getu20()) { 	
					$player->calcIndices();
					PlayerDB::updatePlayer($player);
					
					$count++;
				//}
			}
		}
  }
}
echo $count.' spelers geupdate';
*/
/*
$datum = strtotime("-6 days", time());

$allCoaches = CoachDB::getAllCoachesLoginUpdate(date("Y-m-d", $datum));
if ($allCoaches != Null) {
	$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		
	$coach = CoachDB::LoginUser('Pays', '');
	$HT->setOauthToken($coach->getHTuserToken());
	$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());

	foreach($allCoaches AS $coach) {
		if ($coach != Null) {
			$team = $HT->getTeam($coach->getTeamid());
			echo $coach->getTeamid(). " ";
			if ($team != Null) {
				$vLastHTlogin = strtotime($team->getLastLoginDate());
				
				if ($vLastHTlogin > 0) {
					$coach->setlastHTlogin($team->getLastLoginDate());
					echo date("d-m-y H:i", $vLastHTlogin)."<BR>";
					CoachDB::updateCoach($coach);
				}
				else {
					echo "BOT<BR>";
					$coach->setbot(-1);
					CoachDB::updateCoach($coach);
				}
			}
		}
	}
}

echo "Eind coachHTlogin: ".time());
*/

/*
$allCoaches = CoachDB::getCoachList();
if ($allCoaches != Null) {
	$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');

	foreach($allCoaches AS $coach) {
		if ($coach != Null) {
		  if ($coach->getHTuserToken() <> '') {
				echo $coach->getTeamname().'('.$coach->getId().')<BR>';	
			
				$HT->setOauthToken($coach->getHTuserToken());
				$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
				
				try {
					$club = $HT->getClub();
					
					if ($club != Null) {
						$specialists = $club->getSpecialists();
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
						
						$team = $HT->getTeam();
						
						$coach->setlastHTlogin($team->getLastLoginDate());
						
						CoachDB::updateCoach($coach);
					}
				}
				catch(HTError $e) {
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
*/

$allPlayers = PlayerDB::getPlayerWithoutCoach();
if ($allPlayers != Null) {
	$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		
	$coach = CoachDB::LoginUser('Pays', '');
	$HT->setOauthToken($coach->getHTuserToken());
	$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());

	foreach($allPlayers AS $player) {
		if ($player != Null) {
			echo "playerID = ".$player->getId()."<BR>";
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
						echo "player deleted<BR>";
						PlayerDB::deletePlayer($player->getId());
					}
					else {
						$userID = 0;
						echo "teamID = ".$teamID."<BR>";
						if ($teamID > 0) {
							$team = $HT->getTeam($teamID);
							$userID = $team->getUserId();
							
							if ($userID <= 0) {
							  $userID = -1;
							}
							echo "userID = ".$userID."<BR>";
						}
						else {
							echo "userID = onbekend<BR>";
						}
						
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
						
						if ($userID > 0) {
							$playercoach = CoachDB::getCoach($userID);
							if ($playercoach == NULL) {
								if ($team != NULL) {
									if ($team->isBot()) {
										CoachDB::insertCoach(new Coach($userID, $teamID, $HTplayer->getTeamname(), 
											"user", "", "", "", "", "",
											0, 0, 0, 0, 0, 0, 0, 0, 0, -1));										}
									else {
										echo "Last Login = ".$team->getLastLoginDate()."<BR>";
										CoachDB::insertCoach(new Coach($userID, $teamID, $HTplayer->getTeamname(), 
											"user", "", "", "", "", "",
											0, 0, 0, 0, 0, 0, 0, 0, $team->getLastLoginDate(), 0));
									}
									
								}
							}
							else {
								if ($team != NULL) {
									if ($team->isBot()) {
										$playercoach->setbot(-1);
										$playercoach->setlastHTlogin(date("d-m-y H:i", 0));
									}
									else {
										$playercoach->setbot(0);
										echo "last login = ".$team->getLastLoginDate()."<BR>";
										$playercoach->setlastHTlogin($team->getLastLoginDate());
									}
									CoachDB::updateCoach($playercoach);
								}
							}
						}
					}
				}
			}
			catch(HTError $e) {
				echo "player deleted<BR>";
				PlayerDB::deletePlayer($player->getId());
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
?>