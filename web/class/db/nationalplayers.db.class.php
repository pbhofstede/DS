<?php
class NationalPlayersDB extends DB {
	
	public static function getNationalPlayersList() {
		$prepare	=	parent::getconn()->prepare("SELECT * FROM nationalplayers WHERE nt = 1 ORDER BY timestamp DESC");
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$nationalPlayersList[]	=	new NationalPlayers($row['id'], $row['player'], $row['country'], $row['age'], $row['tsi'],
			$row['wage'], $row['stamina'], $row['keeper'], $row['playmaker'], $row['scorer'], $row['passing'], $row['winger'], $row['defender'], $row['setPieces'], $row['caps'], $row['capsU20'], $row['form'], strtotime($row['timestamp']), $row['nt'], $row['spec'], $row['xp'], $row['ls'], $row['injured']);
		}
		
		return $nationalPlayersList;
	}

	public static function getU20PlayersList() {
		$prepare	=	parent::getconn()->prepare("SELECT * FROM nationalplayers WHERE nt = 0 ORDER BY timestamp DESC");
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$u20PlayersList[]	=	new NationalPlayers($row['id'], $row['player'], $row['country'], $row['age'], $row['tsi'], 
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
				return new NationalPlayers($row['id'], $row['player'], $row['country'], $row['age'], $row['tsi'],$row['wage'], $row['stamina'], $row['keeper'], $row['playmaker'], $row['scorer'], $row['passing'], $row['winger'], $row['defender'], $row['setPieces'], $row['caps'], $row['capsU20'], $row['form'], strtotime($row['timestamp']), $row['nt'], $row['spec'], $row['xp'], $row['ls'], $row['injured']);
			}
		}
		catch(HTError $e)
		{
			echo $e->getMessage();
		}
	}

	public static function insertNationalPlayers($nationalPlayers) 
	{
		if ($nationalPlayers->getId() > 0) {
			try {
				$prepare	=	parent::getConn()->prepare("INSERT INTO nationalplayers (id, player, country, age, tsi, wage, stamina, keeper, playmaker, scorer, passing, winger, defender, setPieces, caps, capsU20, form, timestamp, nt, spec, xp, ls, injured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?), ?, ?, ?, ?, ?)");
				global $specs;
			
				$playerID = $nationalPlayers->getId();
				$playerName = $nationalPlayers->getPlayer();
				$playerAge = $nationalPlayers->getAge(); 
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
				
				$prepare->execute();
				echo "Speler ".$playerID." toegevoegd ".$spec."<BR>";
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