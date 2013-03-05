<?php
class PlayerLogDB extends DB {
	public static function insertLog($log) {
		$prepare		=	parent::getConn()->prepare("INSERT INTO playerLog (player, type, old, new, date) VALUES (?, ?, ?, ?, FROM_UNIXTIME(?))");
		$prepare->bindParam(1, $log->getPlayer()->getId(), PDO::PARAM_INT);
		$prepare->bindParam(2, $log->getType(), PDO::PARAM_STR);
		$prepare->bindParam(3, $log->getOld(), PDO::PARAM_INT);
		$prepare->bindParam(4, $log->getNew(), PDO::PARAM_INT);
		$prepare->bindParam(5, $log->getDate(), PDO::PARAM_STR);
		$prepare->execute();
	}
	
	public static function getPlayerLogByPlayerByType($id, $type) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `player`, `type`, `old`, `new`, `date` FROM playerLog WHERE player = ? AND `type` = ? ORDER BY date DESC LIMIT 25");
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->bindParam(2, $type);
		$prepare->execute();
		
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]	=	new	PlayerLog($row['id'], $row['player'], $row['type'], $row['old'], $row['new'], strtotime($row['date']));
		}

		return $list;
	}
	
	public static function getPlayerLogByPlayerByDate($id, $date) {
		$prepare	=	parent::getConn()->prepare("SELECT id, player, type, old, new, date FROM playerLog WHERE player = ? AND ((type = 'defender') or (type = 'winger') or (type = 'passing') or (type = 'setPieces') or (type = 'scorer') or (type = 'playmaker') or (type = 'keeper') or (type = 'stamina') or (type = 'experience')) and (new > old) and (date >= FROM_UNIXTIME(?)) ORDER BY date DESC LIMIT 25");
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->bindParam(2, $date, PDO::PARAM_STR);
		$prepare->execute();
		
		$row = $prepare->fetch();
		
		if ($row['id'] != Null) {
			return new PlayerLog($row['id'], $row['player'], $row['type'], $row['old'], $row['new'], strtotime($row['date']));
		}
	}
}
?>
