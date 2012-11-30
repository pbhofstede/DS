<?php
class TrainingDB extends DB {
/*	public static function getTrainingListByPlayer($playerId) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `playerId`, `coachId`, `van`, `tot`, `training`, `ti`, `conditie`, `fysios`, `gemist`, `opmerking` FROM `playerTraining` WHERE playerId = ? ORDER BY `van` DESC LIMIT 50");
		$prepare->bindParam(1, $playerid, PDO::PARAM_INT);
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new PlayerTraining($row['id'], $row['playerId'], $row['coachID'], $row['van'], $row['tot'], $row['training'], $row['ti'], $row['conditie'], $row['fysios'], $row['gemist'], $row['opmerking']);
		}
		
		return $list;
	}

	public static function getTrainingListByPlayerAndCoach($playerId, $coachId) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `playerId`, `coachId`, `van`, `tot`, `training`, `ti`, `conditie`, `fysios`, `gemist`, `opmerking` FROM `playerTraining` WHERE playerId = ? AND coachId = ? ORDER BY `van` DESC LIMIT 50");
		$prepare->bindParam(1, $playerid, PDO::PARAM_INT);
		$prepare->bindParam(2, $coachid, PDO::PARAM_INT);
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new PlayerTraining($row['id'], $row['playerId'], $row['coachID'], $row['van'], $row['tot'], $row['training'], $row['ti'], $row['conditie'], $row['fysios'], $row['gemist'], $row['opmerking']);
		}
		
		return $list;
	}
*/	
	public static function getTrainingById($id) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `coachId`, `van`, `tot`, `training`, `ti`, `conditie`, `assistenten`, `fysios` FROM `training` WHERE id = ? LIMIT 1");
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->execute();
		
		$row			=	$prepare->fetch();
		if($row['id'] != NULL) {
			return new Training($row['id'], $row['coachId'], strtotime($row['van']), strtotime($row['tot']), $row['training'], $row['ti'], $row['conditie'], $row['assistenten'], $row['fysios']);
		}
	}

	public static function getTrainingByIdAndCoach($id, $coachId) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `coachId`, `van`, `tot`, `training`, `ti`, `conditie`, `assistenten`, `fysios` FROM `training` WHERE id = ? AND coachId = ?LIMIT 1");
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->bindParam(2, $coachId, PDO::PARAM_INT);
		$prepare->execute();
		
		$row			=	$prepare->fetch();
		if($row['id'] != NULL) {
			return new Training($row['id'], $row['coachId'], strtotime($row['van']), strtotime($row['tot']), $row['training'], $row['ti'], $row['conditie'], $row['assistenten'], $row['fysios']);
		}
	}


	public static function getTrainingListByCoach($coachId) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `coachId`, `van`, `tot`, `training`, `ti`, `conditie`, `assistenten`, `fysios` FROM `training` WHERE coachId = ? ORDER BY `van` ASC LIMIT 50");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->execute();
		
		$list = Null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new Training($row['id'], $row['coachId'], strtotime($row['van']), strtotime($row['tot']), $row['training'], $row['ti'], $row['conditie'], $row['assistenten'], $row['fysios']);
		}
		
		return $list;
	}

	public static function insertTraining($training) {
		$prepare	=	parent::getConn()->prepare("INSERT INTO `training` (coachId, van, tot, training, ti, conditie, assistenten, fysios) VALUES (?, FROM_UNIXTIME(?), FROM_UNIXTIME(?), ?, ?, ?, ?, ?)");
		$prepare->bindParam(1, $training->getCoachId(), PDO::PARAM_INT);
		$prepare->bindParam(2, $training->getVan(), PDO::PARAM_INT);
		$prepare->bindParam(3, $training->getTot(), PDO::PARAM_INT);
		$prepare->bindParam(4, $training->getTraining(), PDO::PARAM_INT);
		$prepare->bindParam(5, $training->getTi(), PDO::PARAM_INT);
		$prepare->bindParam(6, $training->getConditie(), PDO::PARAM_INT);
		$prepare->bindParam(7, $training->getAssistenten(), PDO::PARAM_INT);
		$prepare->bindParam(8, $training->getFysios(), PDO::PARAM_INT);
		$prepare->execute();
		
		return parent::getConn()->lastInsertId();
	}
	
	public static function updateTraining($training) {
		$prepare		=	parent::getConn()->prepare("UPDATE training SET van = FROM_UNIXTIME(?), tot = FROM_UNIXTIME(?), training = ?, ti = ?, conditie = ?, assistenten = ?, fysios = ? WHERE id = ? AND coachId = ? LIMIT 1");
		$prepare->bindParam(1, $training->getVan(), PDO::PARAM_INT);
		$prepare->bindParam(2, $training->getTot(), PDO::PARAM_INT);
		$prepare->bindParam(3, $training->getTraining(), PDO::PARAM_INT);
		$prepare->bindParam(4, $training->getTi(), PDO::PARAM_INT);
		$prepare->bindParam(5, $training->getConditie(), PDO::PARAM_INT);
		$prepare->bindParam(6, $training->getAssistenten(), PDO::PARAM_INT);
		$prepare->bindParam(7, $training->getFysios(), PDO::PARAM_INT);
		$prepare->bindParam(8, $training->getId(), PDO::PARAM_INT);
		$prepare->bindParam(9, $training->getCoachId(), PDO::PARAM_INT);
		$prepare->execute();
	}

}
?>