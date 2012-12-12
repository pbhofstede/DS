<?php
class NationalPlayersDB extends DB {
	
	public static function getNationalPlayersList($country) {
		$prepare	=	parent::getconn()->prepare("SELECT * FROM nationalplayers WHERE nt = 1 AND teamid = (select max(teamid) from nationalteams where country = ? and nt = 1) ORDER BY timestamp DESC");
		$prepare->bindParam(1, $country, PDO::PARAM_STR);
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$nationalPlayersList[]	=	new NationalPlayers($row['id'], $row['player'], $row['teamid'], $row['country'], $row['age'], $row['tsi'],
			$row['wage'], $row['stamina'], $row['keeper'], $row['playmaker'], $row['scorer'], $row['passing'], $row['winger'], $row['defender'], $row['setPieces'], $row['caps'], $row['capsU20'], $row['form'], strtotime($row['timestamp']), $row['nt'], $row['spec'], $row['xp'], $row['ls'], $row['injured']);
		}
		
		return $nationalPlayersList;
	}
	
	public static function getCountryList($nt) {
	  $prepare =	parent::getConn()->prepare("SELECT distinct country FROM nationalteams where NT = ? order by country");
		$prepare->bindParam(1, $nt, PDO::PARAM_INT);
		$prepare->execute();
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	$row['country'];
		}
		
		return $list;
	}

	public static function getU20PlayersList($country) {
		$prepare	=	parent::getconn()->prepare("SELECT * FROM nationalplayers WHERE nt = 0 AND teamid = (select max(teamid) from nationalteams where country = ? and nt = 0) ORDER BY timestamp DESC");
		$prepare->bindParam(1, $country, PDO::PARAM_STR);
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$u20PlayersList[]	=	new NationalPlayers($row['id'], $row['player'], $row['teamid'], $row['country'], $row['age'], $row['tsi'], 
			$row['wage'], $row['stamina'], $row['keeper'], $row['playmaker'], $row['scorer'], $row['passing'], $row['winger'], $row['defender'], $row['setPieces'], $row['caps'], $row['capsU20'], $row['form'], strtotime($row['timestamp']), $row['nt'], $row['spec'], $row['xp'], $row['ls'], $row['injured']);
		}
		
		return $u20PlayersList;
	}

	public static function getNationalPlayer($id) {
		try {
			$prepare	=	parent::getConn()->prepare("SELECT * FROM nationalplayers WHERE id = ? LIMIT 1");
			$prepare->bindParam(1, $id, PDO::PARAM_INT);
			$prepare->execute();
			
			$row		=	$prepare->fetch();
			if ($row['id'] != NULL) {
				return new NationalPlayers($row['id'], $row['player'], $row['teamid'], $row['country'], $row['age'], $row['tsi'],$row['wage'], $row['stamina'], $row['keeper'], $row['playmaker'], $row['scorer'], $row['passing'], $row['winger'], $row['defender'], $row['setPieces'], $row['caps'], $row['capsU20'], $row['form'], strtotime($row['timestamp']), $row['nt'], $row['spec'], $row['xp'], $row['ls'], $row['injured']);
			}
		}
		catch(HTError $e)
		{
			echo $e->getMessage();
		}
	}
	
	public static function getTeamDetails($country, $NT) 
	{
		$prepare	=	parent::getconn()->prepare("SELECT * FROM nationalteams WHERE nt = ? AND country = ? ORDER BY scandate DESC");
		$prepare->bindParam(1, $NT, PDO::PARAM_INT);
		$prepare->bindParam(2, $country, PDO::PARAM_STR);
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$teamDetailList[]	=	new TeamDetail(strtotime($row['scandate']), $row['ts'], $row['tc'], $row['xp253'], 
			$row['xp343'], $row['xp352'], $row['xp433'], $row['xp442'], $row['xp451'], $row['xp523'], $row['xp532'], $row['xp541'], $row['xp550']);
		} 
		
		return $teamDetailList;
	}

	public static function insertNationalTeamDetails($teamid, $team, $isNT)
	{	
	 	$vAdded = FALSE;
		$country = $team->getShortTeamName();
		$ts = $team->getTeamSpirit();
		$tc = $team->getSelfConfidence();
		$xp253 = $team->get253Experience();
		$xp343 = $team->get343Experience();
		$xp352 = $team->get352Experience();
		$xp433 = $team->get433Experience();
		$xp442 = $team->get442Experience();
		$xp451 = $team->get451Experience();
		$xp523 = $team->get523Experience();
		$xp532 = $team->get532Experience();
		$xp541 = $team->get541Experience();
		$xp550 = $team->get550Experience();
		$scandate = time();
		
		$inserttest = parent::getConn()->prepare("SELECT * from nationalteams where teamid = ? and ts = ? and tc = ? and xp253 = ? and xp343 = ? and xp352 = ? and xp433 = ? and xp442 = ? and xp451 = ? and xp523 = ? and xp532 = ? and xp541 = ? and xp550 = ? and nt = ? and scandate = (select max(scandate) from nationalteams where teamid = ? and nt = ?)");
		$inserttest->bindParam(1, $teamid, PDO::PARAM_INT);
		$inserttest->bindParam(2, $ts, PDO::PARAM_INT);
		$inserttest->bindParam(3, $tc, PDO::PARAM_INT);
		$inserttest->bindParam(4, $xp253, PDO::PARAM_INT);
		$inserttest->bindParam(5, $xp343, PDO::PARAM_INT);
		$inserttest->bindParam(6, $xp352, PDO::PARAM_INT);
		$inserttest->bindParam(7, $xp433, PDO::PARAM_INT);
		$inserttest->bindParam(8, $xp442, PDO::PARAM_INT);
		$inserttest->bindParam(9, $xp451, PDO::PARAM_INT);
		$inserttest->bindParam(10, $xp523, PDO::PARAM_INT);
		$inserttest->bindParam(11, $xp532, PDO::PARAM_INT);
		$inserttest->bindParam(12, $xp541, PDO::PARAM_INT);
		$inserttest->bindParam(13, $xp550, PDO::PARAM_INT);
		$inserttest->bindParam(14, $isNT, PDO::PARAM_INT);
		$inserttest->bindParam(15, $teamid, PDO::PARAM_INT);
		$inserttest->bindParam(16, $isNT, PDO::PARAM_INT);
		
		$inserttest->execute();
		$row		=	$inserttest->fetch();
						
		if ($row['teamid'] == NULL)
		{
			$prepare	=	parent::getConn()->prepare("INSERT INTO nationalteams (teamid, country, ts, tc, xp253, xp343, xp352, xp433, 	xp442,xp451, xp523, xp532, xp541, xp550, nt, scandate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp)");
				
			$prepare->bindParam(1, $teamid, PDO::PARAM_INT);
			$prepare->bindParam(2, $country, PDO::PARAM_STR);
			$prepare->bindParam(3, $ts, PDO::PARAM_INT);
			$prepare->bindParam(4, $tc, PDO::PARAM_INT);
			$prepare->bindParam(5, $xp253, PDO::PARAM_INT);
			$prepare->bindParam(6, $xp343, PDO::PARAM_INT);
			$prepare->bindParam(7, $xp352, PDO::PARAM_INT);
			$prepare->bindParam(8, $xp433, PDO::PARAM_INT);
			$prepare->bindParam(9, $xp442, PDO::PARAM_INT);
			$prepare->bindParam(10, $xp451, PDO::PARAM_INT);
			$prepare->bindParam(11, $xp523, PDO::PARAM_INT);
			$prepare->bindParam(12, $xp532, PDO::PARAM_INT);
			$prepare->bindParam(13, $xp541, PDO::PARAM_INT);
			$prepare->bindParam(14, $xp550, PDO::PARAM_INT);
			$prepare->bindParam(15, $isNT, PDO::PARAM_INT);
					
			$prepare->execute();
			$vAdded = TRUE;
		}

		return $vAdded;
	} 

	public static function insertNationalPlayers($nationalPlayers) 
	{
		if ($nationalPlayers->getId() > 0) {
			try {
				$prepare	=	parent::getConn()->prepare("INSERT INTO nationalplayers (id, player, country, age, tsi, wage, stamina, keeper, playmaker, scorer, passing, winger, defender, setPieces, caps, capsU20, form, timestamp, nt, spec, xp, ls, injured, teamid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?), ?, ?, ?, ?, ?, ?)");
				global $specs;
			
				$playerID = $nationalPlayers->getId();
				$playerName = $nationalPlayers->getPlayer();
				$playerAge = $nationalPlayers->getAge();
				$teamID = $nationalPlayers->getTeamID();
				$playerCountry = $nationalPlayers->getCountry(); 
				$playerTSI = $nationalPlayers->getTsi();
				$wage = $nationalPlayers->getWage();
				$stamina = $nationalPlayers->getStamina(); 
				$keeper = $nationalPlayers->getKeeper(); 
				$playmaker = $nationalPlayers->getPlaymaker(); 
				$scorer = $nationalPlayers->getScorer();
				$passing = $nationalPlayers->getPassing();
				$winger = $nationalPlayers->getWinger();
				$defender = $nationalPlayers->getDefender();
				$setpieces = $nationalPlayers->getSetPieces();
				$NTCaps = $nationalPlayers->getCaps();
				$U20Caps = $nationalPlayers->getCapsU20();
				$playerForm = $nationalPlayers->getForm();
				$lastUpdate = $nationalPlayers->getTimestamp();
				$isNT = $nationalPlayers->getNt();
				$spec = $specs[$nationalPlayers->getSpec()];
				$playerXP = $nationalPlayers->getXp();
				$playerLS = $nationalPlayers->getLs();
				$injury = $nationalPlayers->getInjury();
				
				if ($injury == -1)
				{
					$injury = NULL;	
				}
			
				$prepare->bindParam(1, $playerID, PDO::PARAM_INT);
				$prepare->bindParam(2, $playerName, PDO::PARAM_STR);
				$prepare->bindParam(3, $playerCountry, PDO::PARAM_STR);
				$prepare->bindParam(4, $playerAge, PDO::PARAM_STR);
				$prepare->bindParam(5, $playerTSI, PDO::PARAM_INT);
				$prepare->bindParam(6, $wage, PDO::PARAM_INT);
				$prepare->bindParam(7, $stamina, PDO::PARAM_INT);
				$prepare->bindParam(8, $keeper, PDO::PARAM_INT);
				$prepare->bindParam(9, $playmaker, PDO::PARAM_INT);
				$prepare->bindParam(10, $scorer, PDO::PARAM_INT);
				$prepare->bindParam(11, $passing, PDO::PARAM_INT);
				$prepare->bindParam(12, $winger, PDO::PARAM_INT);
				$prepare->bindParam(13, $defender, PDO::PARAM_INT);
				$prepare->bindParam(14, $setpieces, PDO::PARAM_INT);
				$prepare->bindParam(15, $NTCaps, PDO::PARAM_INT);
				$prepare->bindParam(16, $U20Caps, PDO::PARAM_INT);
				$prepare->bindParam(17, $playerForm, PDO::PARAM_INT);
				$prepare->bindParam(18, $lastUpdate, PDO::PARAM_STR);
				$prepare->bindParam(19, $isNT, PDO::PARAM_INT);
				$prepare->bindParam(20, $spec, PDO::PARAM_STR);
				$prepare->bindParam(21, $playerXP, PDO::PARAM_INT);
				$prepare->bindParam(22, $playerLS, PDO::PARAM_INT);
				$prepare->bindParam(23, $injury, PDO::PARAM_INT);
				$prepare->bindParam(24, $teamID, PDO::PARAM_INT);
				
				$prepare->execute();
			}
			catch(HTError $e)
			{
			echo $e->getMessage();
			}
		}
	}
	
	public static function deleteNationalPlayers($id) {
		try
		{
			$prepare	=	parent::getConn()->prepare("DELETE FROM nationalplayers WHERE id = ?");
			$prepare->bindParam(1, $id, PDO::PARAM_INT);
			$prepare->execute();
		}
		catch(HTError $e)
		{
			echo $e->getMessage();
		} 
	}
}
?>