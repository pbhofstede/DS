<?php
include ('header.php');
try {
 	if (isset($_SESSION['dutchscouts'])) {
		$coach = CoachDB::getCoach($_SESSION['dutchscouts']); 	
	} else {
		$coach = CoachDB::getCoach(2705367);	
	}
 	
 	if ($coach != NULL)	
	 { 	 
 	 	if (isset($_GET['NT'])){
 	 	 	$nt = $_GET['NT'];
		} else {
			$nt = 1;
		}
		
		$newPlayers = 0;
	  	$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		
		$HT->setOauthToken($coach->getHTuserToken()); 
		$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
	  	$worlddetails = $HT->getWorldDetails(FALSE);
	  	
	  	$vCount = $worlddetails->getLeagueNumber(); 
		for($i=1; $i<=$vCount; $i++) 
		{
			$vCountry = $worlddetails->getLeague($i);
			if ($vCountry != NULL)
			{
			 	if ($nt == 1)
			 	{
					$NT_Id = $vCountry->getNationalTeamId();
				}
				else
				{
					$NT_Id = $vCountry->getU20TeamId();	
				}
				
				$NT = $HT->getNationalTeamDetail($NT_Id); 
				if ($NT != NULL)
				{
				 	NationalPlayersDB::insertNationalTeamDetails($NT_Id, $NT, $nt);
				 	
					 
					$NTPlayers = $HT->getNationalPlayers($NT_Id);
					$count = $NTPlayers->getNumberPlayers(); 
				 	for($j=1; $j<=$count; $j++)
					{
						$NTPlayer = $NTPlayers->getPlayer($j);
						if ($NTPlayer != NULL)
						{
						 	$PlayerID = $NTPlayer->getId(); 
						 	if ($PlayerID > 0)
						 	{
								$player = $HT->getPlayer($PlayerID);
								if (($player != NULL) && ($player->isSkillsAvailable())) 
								{
									$nationalPlayer = NationalPlayersDB::getNationalPlayer($PlayerID);			
									if($nationalPlayer != Null)
									{
										NationalPlayersDB::deleteNationalPlayers($PlayerID);
									} 
									else 
									{
										$newPlayers = $newPlayers + 1;
									}	
									$wage = $player->getSalary(HTMoney::Nederland);
									if ($player->IsAbroad()) 
									{
										$wage = $wage / 1.2;	
									}
									NationalPlayersDB::insertNationalPlayers(new NationalPlayers(
										$PlayerID, 
										$player->getName(), 
										$NT_Id,
										$vCountry->getCountryName(),
										$player->getAge().'y'.$player->getDays().'d', 
										$player->getTsi(), 
										$wage,
										$player->getStamina(), 
										$player->getKeeper(), 
										$player->getPlaymaker(), 
										$player->getScorer(), 
										$player->getPassing(), 
										$player->getWinger(), 
										$player->getDefender(), 
										$player->getSetPieces(), 
										$player->getACaps(), 
										$player->getU20Caps(), 
										$player->getForm(), 
										time(), 
										$nt, 
										$player->getSpeciality(), 
										$player->getExperience(), 
										$player->getLeadership(),
										$player->getInjury()));
						
								}		
							}	
						} 	
					} 
				 	
				}
			}
		}
		
	}
	
	if (isset($_GET['Callback'])) 
	{
		$callbackurl = $_GET['Callback'];
		redirect($callbackurl.'?NEW='.$newPlayers);	
	}
}
catch(HTError $e) {
	echo $e->getMessage();
} 
?>