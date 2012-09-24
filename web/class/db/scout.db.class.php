<?php
class ScoutDB extends DB {
	
	public static function getScout($scoutId) {
		$prepare		=	parent::getConn()->prepare("SELECT id, name, indices FROM scout WHERE id = ?");
		$prepare->bindParam(1, $scoutId, PDO::PARAM_INT);
		$prepare->execute();
		
		$row			=	$prepare->fetch();
		if($row['id'] != NULL) {
			$scout = new Scout($row['id'], $row['name']);
			$scout->setIndices($row['indices']);
			return $scout;
		}
	}
	
	public static function insertScout($scout) {
	 	$scoutname = $scout->getName();
	 
		$prepare		=	parent::getConn()->prepare("INSERT INTO scout (name) VALUES (?)");
		$prepare->bindParam(1, $scoutname, PDO::PARAM_STR);
		$prepare->execute();
	}
	
	public static function updateScout($scout) {
	 	$scoutname = $scout->getName();
	 	$scoutindices = $scout->getIndices();
	 	$scoutID = $scout->getID();
	 
		$prepare		=	parent::getConn()->prepare("update scout set name = ?, indices = ? where id = ?");
		$prepare->bindParam(1, $scoutname, PDO::PARAM_STR);
		$prepare->bindParam(2, $scoutindices, PDO::PARAM_STR);
		$prepare->bindParam(3, $scoutID, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function deleteScout($scoutId) {
		$prepare		=	parent::getConn()->prepare("DELETE FROM scoutRequirements WHERE scout = ?");
		$prepare->bindParam(1, $scoutId, PDO::PARAM_STR);
		$prepare->execute();
		
		$prepare		=	parent::getConn()->prepare("DELETE FROM coachScout WHERE scout = ?");
		$prepare->bindParam(1, $scoutId, PDO::PARAM_STR);
		$prepare->execute();
		
		$prepare		=	parent::getConn()->prepare("DELETE FROM scout WHERE id = ?");
		$prepare->bindParam(1, $scoutId, PDO::PARAM_STR);
		$prepare->execute();
	}
	
	public static function getScoutList() {
		$prepare		=	parent::getConn()->prepare("SELECT id, name FROM scout ORDER BY name ASC");
		$prepare->execute();
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new Scout($row['id'], $row['name']);
		}
		
		return $list;
	}
	
	public static function getScoutMembers($scoutId) {
		$prepare		=	parent::getConn()->prepare("SELECT coach FROM coachScout WHERE scout = ?");
		$prepare->bindParam(1, $scoutId, PDO::PARAM_INT);
		$prepare->execute();
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	CoachDB::getCoach($row['coach']);
		}
		
		return $list;
	}
}
?>
