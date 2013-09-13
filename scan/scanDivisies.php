<?php
include ('config.php');

set_time_limit(0);

try {
	$divisies = PlayerLogDB::getDivisiesToScan();
	
	if (count($divisies) == 0) {
		echo "Klaar!";
	}
	else {
		$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		
		$coach = CoachDB::LoginUser('__auto_Pays', '');
		$HT->setOauthToken($coach->getHTuserToken());
		$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());

	
				/*
			$searchresults = $HT->searchSerieByName('VIII.', 14);
			for ($i = 0; $i < count($searchresults); $i++) {
				for($count = 0; $count <= $searchresults[$i]->getResultNumber(); $count++) {
					$result = $searchresults[$i]->getResult($count);
				
					if ($result != null) {
						echo $result->getId().':'.$result->getValue().'<BR>'; 
						PlayerLogDB::insertNLDivisies($result->getId(), $result->getValue());
					}
				}
			}
			*/

		for($count = 0; $count < count($divisies); $count++) {
		  $league = $HT->getLeague($divisies[$count]);
			
			sleep(2);
			if ($league != null) {
				for($i = 1; $i<=8; $i++) {
					$HT->clearClub();
					$HT->clearTeams();
			    
					$leagueteam = $league->getTeam($i);
					
					if ($leagueteam != null) {
						$teamID = $leagueteam->getTeamid();
					
						if ($teamID > 0) {
							$team = $HT->getTeam($teamID);
						
							if ($team != null) {
								PlayerLogDB::InsertTeam($teamID, $divisies[$count], $team->getLoginName(), $team->isBot(), $team->isHtSupporter(), $team->getYouthTeamId());
								echo $team->getLoginName()."<BR>";
							}
						}
					}
				}
			}
		}
		sleep(10);
		header('Location: http://localhost/DutchScouts/scan/scanDivisies.php?q='.$teamID);
	}
} catch(HTError $e) {
	echo $e;
}
?>
