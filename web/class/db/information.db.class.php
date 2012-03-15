<?php
class InformationDB extends DB {
	public static function getInformationById($id) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `naam`, `afkorting`, `content`, `publicatie` FROM `informatie` WHERE id = ? LIMIT 1");
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id']) {
			return new Information($row['id'], $row['naam'], $row['afkorting'], $row['content'], $row['publicatie']);
		}
	}
	
	public static function insertInformation($information) {
		$prepare	=	parent::getConn()->prepare("INSERT INTO `informatie` (`naam`, `afkorting`, `publicatie`) VALUES (?, ?, ?)");
		$prepare->bindParam(1, $information->getNaam());
		$prepare->bindParam(2, $information->getAfkorting());
		$prepare->bindParam(3, $information->getPublicatie());
		$prepare->execute();
	}

	public static function getInformationByAfkorting($afkorting) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `naam`, `afkorting`, `content`, `publicatie` FROM `informatie` WHERE afkorting = ? LIMIT 1");
		$prepare->bindParam(1, $afkorting);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id']) {
			return new Information($row['id'], $row['naam'], $row['afkorting'], $row['content'], $row['publicatie']);
		}
	}

	public static function getInformationList() {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `naam`, `afkorting`, `content`, `publicatie` FROM `informatie` ORDER BY `naam` ASC");
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$informationList[]		=	new Information($row['id'], $row['naam'], $row['afkorting'], $row['content'], $row['publicatie']);
		}
		
		return $informationList;
	}

	public static function getInformationListByPublication($publication) {
		$prepare	=	parent::getConn()->prepare("SELECT `id`, `naam`, `afkorting`, `content`, `publicatie` FROM `informatie` WHERE publicatie = ? ORDER BY `naam` ASC LIMIT 50");
		$prepare->bindParam(1, $publication);
		$prepare->execute();
		
		$informationList = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$informationList[]		=	new Information($row['id'], $row['naam'], $row['afkorting'], $row['content'], $row['publicatie']);
		}
		
		return $informationList;
	}

	public static function updateInformation($information) {
		$prepare	=	parent::getConn()->prepare("UPDATE `informatie` SET `naam` = ?, `afkorting` = ?, `content` = ?, `publicatie` = ? WHERE `id` = ? LIMIT 1");
		$prepare->bindParam(1, $information->getNaam());
		$prepare->bindParam(2, $information->getAfkorting());
		$prepare->bindParam(3, $information->getContent());
		$prepare->bindParam(4, $information->getPublicatie());
		$prepare->bindParam(5, $information->getId(), PDO::PARAM_INT);
		$prepare->execute();
	}

	public static function getSiteStats($aType) {
		$prepare	=	parent::getConn()->prepare("SELECT id, training_running FROM SITE_STATS WHERE ID = 1 LIMIT 1");
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		
		return $row[$aType];
	}
	
	public static function getSiteStatsTrainingRunning() {
		$prepare	=	parent::getConn()->prepare("SELECT count(id) as AANTAL FROM coach WHERE (HTUserToken <> '') AND (HTUserTokenSecret <> '') AND ((LastTrainingDate is null) or (LastTrainingDate <= DATE_SUB(date(now()), INTERVAL 7 DAY)))");
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		$todo = $row['AANTAL'];

		$prepare	=	parent::getConn()->prepare("SELECT count(id) as AANTAL FROM coach WHERE ((HTUserToken <> '') AND (HTUserTokenSecret <> ''))");
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		$alles = $row['AANTAL'];
		$procent = 100 - ceil($todo / $alles * 100);
		return 'progress ('.$procent.'%) todo: '.$todo.' / '.$alles;
	}
	


	
}
?>