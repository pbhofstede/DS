<?php
class PlayerLogDB extends DB {
	public static function insertLog($log) {
		$prepare		=	parent::getConn()->prepare("INSERT INTO playerLog (player, type, old, new, date) VALUES (?, ?, ?, ?, FROM_UNIXTIME(?))");
		
		$id=$log->getPlayer()->getId();
		$type=$log->getType();
		$old=$log->getOld();
		$new=$log->getNew();
		$datum=$log->getDate();
		
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->bindParam(2, $type, PDO::PARAM_STR);
		$prepare->bindParam(3, $old, PDO::PARAM_INT);
		$prepare->bindParam(4, $new, PDO::PARAM_INT);
		$prepare->bindParam(5, $datum, PDO::PARAM_STR);
		$prepare->execute();
	}
	
	public static function insertNLDivisies($id, $naam) {
		$prepare		=	parent::getConn()->prepare("INSERT INTO NL_DIVISIES (id, naam) VALUES (?, ?)");
		
		
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->bindParam(2, $naam, PDO::PARAM_STR);
		$prepare->execute();
	}
	
	
	public static function getDivisiesToScan() {
		$prepare	=	parent::getConn()->prepare(
			"select nl_divisies.id from nl_divisies where (select count(id) from nl_teams where nl_divisie_id = nl_divisies.id) < 8 limit 0, 40");
		$prepare->execute();
		
		$teams = array();
		$count = 0;
		
		$row = $prepare->fetch();
		while ($row['id'] != NULL) {
			$teams[$count] = $row['id'];
			
			$count++;
			$row = $prepare->fetch();
		}
		
		return $teams;
	}
	
	public static function InsertTeam($id, $divisieid, $naam, $isbot, $issupporter, $youthteamid) {
		$prepare		=	parent::getConn()->prepare("INSERT INTO NL_TEAMS (id, nl_divisie_id, naam, isbot, hassupporter, youthteamid) VALUES (?, ?, ?, ?, ?, ?)");
		
		
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->bindParam(2, $divisieid, PDO::PARAM_INT);
		$prepare->bindParam(3, $naam, PDO::PARAM_STR);
		$prepare->bindParam(4, $isbot, PDO::PARAM_INT);
		$prepare->bindParam(5, $issupporter, PDO::PARAM_INT);
		$prepare->bindParam(6, $youthteamid, PDO::PARAM_INT);
		$prepare->execute();
	}
}
?>
