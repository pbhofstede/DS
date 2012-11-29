<?php
class PlayerCommentDB extends DB {
	public static function getPlayerCommentById($playerId) {
		$prepare	=	parent::getConn()->prepare("SELECT `playerId`, `scouts`, `coach`FROM `playerComment` WHERE playerId = ? LIMIT 1");
		$prepare->bindParam(1, $playerId, PDO::PARAM_INT);
		$prepare->execute();

		$row			=	$prepare->fetch();
		if($row['playerId'] != NULL) {
			return new PlayerComment($row['playerId'], $row['scouts'], $row['coach']);
		}
	}
	
	public static function insertOrUpdatePlayerComment($playerComment) {
		$scouts=$playerComment->getScouts();
		$coach=$playerComment->getCoach();
		$playerid=$playerComment->getPlayerId();
		
		$prepare	=	parent::getConn()->prepare("SELECT `playerId`, `scouts`, `coach`FROM `playerComment` WHERE playerId = ? LIMIT 1");
		$prepare->bindParam(1, $playerid, PDO::PARAM_INT);
		$prepare->execute();

		$row =	$prepare->fetch();
		
		if($row['playerId'] != NULL) {
			$prepare	=	parent::getConn()->prepare("UPDATE `playerComment` SET scouts = ?, coach = ? WHERE playerId = ? LIMIT 1");
			$prepare->bindParam(1, $scouts);
			$prepare->bindParam(2, $coach);
			$prepare->bindParam(3, $playerid, PDO::PARAM_INT);
			$prepare->execute();
		}
	  else {
			$prepare	=	parent::getConn()->prepare("INSERT INTO `playerComment` (playerId, scouts, coach) VALUES (?, ?, ?)");
			$prepare->bindParam(1, $playerid, PDO::PARAM_INT);
			$prepare->bindParam(2, $scouts);
			$prepare->bindParam(3, $coach);
			$prepare->execute();
		}
	}
}