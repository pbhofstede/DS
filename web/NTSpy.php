<?php

error_reporting(E_ALL);
ini_set("max_execution_time", "9000");
ini_set('memory_limit','128M');

include ('header.php');
require ('../scan/class/log.class.php');

function myLog($log, $aStr) 
{
	$log->lwrite($aStr);
//	echo $aStr.'<BR>';
}

try {
 	if (isset($_SESSION['dutchscouts'])) {
		$coach = CoachDB::getCoach($_SESSION['dutchscouts']); 	
	} else {
		$coach = CoachDB::getCoach(2705367);	
	}
 	
 	if ($coach != NULL)	
	{ 
	  	$a = 0;
		if(isset($_GET['a'])) {
		  $a = $_GET['a'];
		}
		  
		$log = new Logging();
		$log->lfile('../scan/log/NTSpy');
		
		if ($a == 0)
		{
			if( !ini_get('safe_mode') )
			{
				myLog($log, "Safe mode off: setting time limit = 0");
				set_time_limit(0);
			} 
			else {
				myLog($log, "Safe mode...");
			}	
	  	}	 
		$start = $a * 10; // 10 landen per keer
	  
	  	$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
		
		$HT->setOauthToken($coach->getHTuserToken()); 
		$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
	  	$worlddetails = $HT->getWorldDetails(FALSE);
	  	
	  	$vCount = $worlddetails->getTotalLeague(); 
	  	
	  	if ($a == 0)
	  	{
			myLog($log, $vCount.' countries');	
		}
	  	
	  	if ($start < $vCount)
	 	{
	 	 	$vMax = $start + 10;
	 	 	if ($vMax > $vCount)
	 	 	{
				$vMax = $vCount;
			}
	 	 	
			for($i=$start+1; $i<=$vMax; $i++) 
			{
				$vCountry = $worlddetails->getLeague($i);
				myLog($log, '');
				myLog($log, $i.' '.$vCountry->getCountryName());
				if ($vCountry != NULL)
				{
					$NT_Id = $vCountry->getNationalTeamId();
					
					$NT = $HT->getNationalTeamDetail($NT_Id); 
					if ($NT != NULL)
					{
					 	if (NationalPlayersDB::insertNationalTeamDetails($NT_Id, $NT, 1) == TRUE)
					 	{
							myLog($log, 'Teamdetails NT inserted');	
						}
					 	
						 
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
									 	echo $PlayerID.' '.$player->getName().' ('.$vCountry->getCountryName().') [NT]<br>';
									 	myLog($log, $PlayerID.' '.$player->getName());
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
											1, 
											$player->getSpeciality(), 
											$player->getExperience(), 
											$player->getLeadership(),
											$player->getInjury()));
							
									}		
								}	
							} 	
						} 
					 	
					}
					$U20_Id = $vCountry->getU20TeamId(); 
					$U20 = $HT->getNationalTeamDetail($U20_Id); 
					if ($U20 != NULL)
					{
					 	if (NationalPlayersDB::insertNationalTeamDetails($U20_Id, $U20, 0) == TRUE)
					 	{
							myLog($log, 'Teamdetails U20 inserted');	
						}
					 
					 	$U20Players = $HT->getNationalPlayers($U20_Id);
					 	$count = $U20Players->getNumberPlayers();
						for($j=1; $j<=$count; $j++)
						{
							$U20Player = $U20Players->getPlayer($j);
							if ($U20Player != NULL)
							{
							 	$PlayerID = $U20Player->getId(); 
							 	if ($PlayerID > 0)
							 	{
									$player = $HT->getPlayer($PlayerID);
									if (($player != NULL) && ($player->isSkillsAvailable())) 
									{
									 	echo $PlayerID.' '.$player->getName().' ('.$vCountry->getCountryName().') [U20]<br>';
									 	myLog($log, $PlayerID.' '.$player->getName());
										$nationalPlayer = NationalPlayersDB::getNationalPlayer($PlayerID);			
										if($nationalPlayer != Null){
											NationalPlayersDB::deleteNationalPlayers($PlayerID);
										} else {
											$newPlayers = $newPlayers + 1;
										}	
										$wage = $player->getSalary(HTMoney::Nederland);
										if ($player->IsAbroad()) {
											$wage = $wage / 1.2;	
										}
										
										NationalPlayersDB::insertNationalPlayers(new NationalPlayers(
											$PlayerID, 
											$player->getName(),
											$U20_Id, 
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
											0, 
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
			$a = $a + 1;
			header("Location: ".$config['url'].'/NTSpy.php?a='.$a);
		}
	} 
}
catch(HTError $e) {
	myLog($log, $e->getMessage());
} 

ini_set("max_execution_time", "30");
ini_set('memory_limit','128M');
ini_set('output_buffering', 4096);
ini_set('implicit_flush', 0);

?>