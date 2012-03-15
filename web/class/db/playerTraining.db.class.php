<?php
class PlayerTrainingDB extends DB {

	public static function insertPlayerTrainingList($playerTraining) {
		$prepare	=	parent::getConn()->prepare("INSERT INTO `playerTraining` (playerId, training) VALUES (?, ?)");
		$prepare->bindParam(1, $playerTraining->getPlayerId(), PDO::PARAM_INT);
		$prepare->bindParam(2, $playerTraining->getTraining(), PDO::PARAM_INT);
		$prepare->execute();
	}
	public static function insertPlayerTraining($playerTraining) {
		$prepare	=	parent::getConn()->prepare("INSERT INTO `playerTraining` (playerId, training, gemist, opmerking) VALUES (?, ?, ?, ?)");
		$prepare->bindParam(1, $playerTraining->getPlayerId(), PDO::PARAM_INT);
		$prepare->bindParam(2, $playerTraining->getTraining(), PDO::PARAM_INT);
		$prepare->bindParam(3, $playerTraining->getGemist(), PDO::PARAM_INT);
		$prepare->bindParam(4, $playerTraining->getOpmerking());
		$prepare->execute();
	}
	
	public static function getPlayerTrainingByTraining($training, $playerId) {
		$prepare	=	parent::getConn()->prepare("SELECT `playerId`, `training`, `gemist`, `opmerking` FROM `playerTraining` WHERE training = ? AND playerId = ? LIMIT 1");
		$prepare->bindParam(1, $training, PDO::PARAM_INT);
		$prepare->bindParam(2, $playerId, PDO::PARAM_INT);
		$prepare->execute();

		$row			=	$prepare->fetch();
		if($row['playerId'] != NULL) {
			return new PlayerTraining($row['playerId'], $row['training'], $row['gemist'], $row['opmerking']);
		}
	}

	public static function getPlayerTrainingListByPlayer($playerId) {
		$prepare	=	parent::getConn()->prepare("SELECT `playerId`, `training`, `gemist`, `opmerking` FROM `playerTraining` WHERE playerId = ? LIMIT 50");
		$prepare->bindParam(1, $playerId, PDO::PARAM_INT);
		$prepare->execute();

		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new PlayerTraining($row['playerId'], $row['training'], $row['gemist'], $row['opmerking']);
		}
		
		return $list;
	}

	public static function updatePlayerTraining($training) {
		$prepare		=	parent::getConn()->prepare("UPDATE playerTraining SET gemist = ?, opmerking = ? WHERE playerId = ? AND training = ? LIMIT 1");
		$prepare->bindParam(1, $training->getGemist(), PDO::PARAM_INT);
		$prepare->bindParam(2, $training->getOpmerking());
		$prepare->bindParam(3, $training->getPlayerId(), PDO::PARAM_INT);
		$prepare->bindParam(4, $training->getTraining(), PDO::PARAM_INT);
		$prepare->execute();
	}

}
?>

