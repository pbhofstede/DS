<?php
include ('header.php');

try {
	$coach = CoachDB::getCoach(2705367);	
	$test = NULL;
	$pagina = file_get_contents('http://www.goanoei.nl/goht/gonat/gonat01.php?sort=x0x1player_name');	
	
	preg_match_all('#\</colgroup\>(.*?)\</table\>#si', $pagina, $tabel);
	for($i=0; $i<count($tabel[0]); $i++) {
		$test .= $tabel[0][$i];
	}
	
	$test = preg_replace('#\</colgroup\>#si', "", $test);
	$test = preg_replace('#\<h1\>(.*?)\</h1\>#si', "", $test);
	$test = preg_replace('#\<a(.*?)\>#si', "", $test);
	$test = preg_replace('#\</a\>#si', "", $test);
	$test = preg_replace('#title=\'(.*?)\'\>#si', ">\\1", $test);
	$test = preg_replace('#\<img(.*?)\>#si', "", $test);
	$test = preg_replace('#\<td class=left\>#si', "", $test);
	$test = preg_replace('#\<td class=right\>#si', "", $test);
	$test = preg_replace('#\<td class=skill\>#si', "", $test);
	$test = preg_replace('#\<td\>#si', "", $test);
	$test = preg_replace('#\<tr\>#si', "", $test);
	$test = preg_replace('#\</tr\>\</table\>#si', "", $test);
	$test = explode("</tr>", $test);
 
	$HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak');
	
	$HT->setOauthToken($coach->getHTuserToken()); 
	$HT->setOauthTokenSecret($coach->getHTuserTokenSecret());
	$newPlayers = 0;
	
	foreach($test AS $tst) {
		$tst = explode("</td>", $tst);
		$playerID = $tst[0];		
	
		if ($playerID > 0){
			$player = $HT->getPlayer($playerID);
			if (($player != NULL) && ($player->isSkillsAvailable())) {	
				$playerID = $player->getId();			
				$nationalPlayer = NationalPlayersDB::getNationalPlayer($playerID);			
				if($nationalPlayer != Null){
					NationalPlayersDB::deleteNationalPlayers($playerID);
				} else {
					$newPlayers = $newPlayers + 1;
				}	
				$wage = $player->getSalary(HTMoney::Nederland);
				if ($player->IsAbroad()) {
					$wage = $wage / 1.2;	
				}
				$details = $HT->getWorldDetails();
				$league = $details->getLeagueByCountryId($player->getNativeCountryID());
				$country = $league->getCountryName();
				
				NationalPlayersDB::insertNationalPlayers(new NationalPlayers(
					$playerID, 
					$player->getName(), 
					$country,
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
catch(HTError $e) {
	echo $e->getMessage();
} 
?>