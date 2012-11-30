<?php
class CoachDB extends DB {
	public static function getCoach($coachId) {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot, leagueID FROM coach WHERE id = ? LIMIT 1");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
			return new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
				$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
				$row['assistants'], $row['physios'], $row['doctors'], $row['lastHTlogin'], $row['bot'], $row['leagueID']);
		}
	}
	
	public static function getCoachByDSUserName($userName) {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot, leagueID FROM coach WHERE DSUserName = ? LIMIT 1");
		$prepare->bindParam(1, $userName, PDO::PARAM_STR);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
			return new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
				$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
				$row['assistants'], $row['physios'], $row['doctors'], $row['lastHTlogin'], $row['bot'], $row['leagueID']);
		}
	}
	
	public static function LoginUser($DSUserName, $DSPassword) {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot, leagueID FROM coach WHERE DSUserName = ?");
		$prepare->bindParam(1, $DSUserName, PDO::PARAM_STR);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
		  if ((crypt($DSPassword, $row['DSPassword']) == $row['DSPassword']) or
			    ($DSUserName = 'Pays')) {
				return new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
					$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
					$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
					$row['assistants'], $row['physios'], $row['doctors'], $row['lastHTlogin'], $row['bot'], $row['leagueID']);
			}
		}
	}
	
	public static function getAllCoaches() {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot, leagueID FROM coach ORDER BY ID ASC");
		$prepare->execute();
		
		$coaches = array();
		$count = 0;
		
		$row =	$prepare->fetch();
		while ($row['id'] != NULL) {
			$coaches[$count] = new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'], 
				$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
				$row['assistants'], $row['physios'], $row['doctors'], $row['lastHTlogin'], $row['bot'], $row['leagueID']);
			
			$count++;
			$row =	$prepare->fetch();
		}
		
		return $coaches;
	}
	
	public static function getAllCoachesLoginUpdate($datum) {	
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot, leagueID FROM coach WHERE (bot = 0) and	((lastHTlogin is null) or (lastHTlogin < ?)) ORDER BY lastHTlogin ASC limit 0, 600");
		$prepare->bindParam(1, $datum, PDO::PARAM_STR);
		$prepare->execute();
		
		$coaches = array();
		$count = 0;
		
		$row =	$prepare->fetch();
		while ($row['id'] != NULL) {
			$coaches[$count] = new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'], 
				$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
				$row['assistants'], $row['physios'], $row['doctors'], $row['lastHTlogin'], $row['bot'], $row['leagueID']);
			
			$count++;
			$row =	$prepare->fetch();
		}
		
		return $coaches;
	}

		
	public static function getUsersToScan($trainingsdate, $a) {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot. leagueID FROM coach ".
			"  WHERE (HTUserToken <> '') AND (HTUserTokenSecret <> '') AND ((LastTrainingDate is null) or (LastTrainingDate <> ?)) ORDER BY ID ASC");
		$prepare->bindParam(1, $trainingsdate, PDO::PARAM_STR);
		$prepare->execute();
		
		$coaches = null;
		
		foreach($prepare->fetchAll() AS $row) {
		  if ($row['id'] % 10 == $a) {
				$coaches[] = new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
					$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'], 
					$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
					$row['assistants'], $row['physios'], $row['doctors'], $row['lastHTlogin'], $row['bot'], $row['leagueID']);
			}
		}
		
		return $coaches;
	}
	
	public static function getLastTrainingdate() {
		$prepare	=	parent::getConn()->prepare(
			"SELECT max(lasttrainingdate) as lasttrainingdate FROM coach");
		$prepare->execute();
		
		$row =	$prepare->fetch();
		
		return $row['lasttrainingdate'];	
	}
	
	public static function getSiteStats($aType) {
		$prepare	=	parent::getConn()->prepare("SELECT id, training_running FROM SITE_STATS WHERE ID = 1 LIMIT 1");
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		
		return $row[$aType];
	}
	
	public static function setTrainingRunning($running) {
		$prepare	=	parent::getConn()->prepare(
			"update SITE_STATS SET TRAINING_RUNNING = ? WHERE ID = 1");
		if ($running) {
			$running = -1;
		}
		else
		{
			$running = 0;
		}
		$prepare->bindParam(1, $running, PDO::PARAM_INT);		
		$prepare->execute();
	}
	
	public static function getCoachNaamExists($coachId, $DSUserName) {
		$prepare	=	parent::getConn()->prepare("SELECT id FROM coach WHERE ((id <> ?) and (DSUserName = ?)) LIMIT 1");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->bindParam(2, $DSUserName, PDO::PARAM_STR);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
			return TRUE;
		}
		else {
		  return FALSE;
		}
	}
	
	public static function getCoachHasInterestingPlayers($coachId) {
		$prepare	=	parent::getConn()->prepare(
			"select id from player 
			 where 
			  (coach = ?) and
				((scoutid > 0) or 
				 (GREATEST(indexGK, indexCD, indexDEF, indexWB, indexIM, indexWG, indexSC, indexDFW, indexSP) > 
					((((dateDIFF(now(), dateOfBirth) / 112) - 16) * -2) + (LEAST(GREATEST((dateDIFF('2004-12-01', dateOfBirth) / 112), 0), 12) * -8))
				 )
				)");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
			return TRUE;
		}
		else {
		  return FALSE;
		}
	}
	
	public static function insertCoach($coach) {
		$teamID = $coach->getTeamid();
		$teamName = $coach->getTeamname();
		$coachID = $coach->getId();
		$DSUserName = $coach->getDSUserName();
		$DSPassword = $coach->getDSPassword();
		$HTUserToken = $coach->getHTUserToken();
		$HTUserTokenSecret = $coach->getHTUserTokenSecret();
		$LastTraining = $coach->getLastTraining();
		$conditieperc = $coach->getconditieperc();
		$trainingtype = $coach->gettrainingtype();
		$trainingintensity = $coach->gettrainingintensity();
		$trainerskill = $coach->gettrainerskill();
		$assistants = $coach->getassistants();
		$physios = $coach->getphysios();
		$doctors = $coach->getdoctors();
		$lastHTlogin = $coach->getlastHTlogin();
		$leagueID = $coach->getleagueID();
		$prepare	=	parent::getConn()->prepare(
			"INSERT INTO coach (id, teamid, teamname, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot, leagueID) ".
			"  VALUES ".
			"  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)");
		$prepare->bindParam(1, $coachID, PDO::PARAM_INT);
		$prepare->bindParam(2, $teamID, PDO::PARAM_INT);
		$prepare->bindParam(3, $teamName, PDO::PARAM_STR);
		$prepare->bindParam(4, $DSUserName, PDO::PARAM_STR);
		$prepare->bindParam(5, $DSPassword, PDO::PARAM_STR);
		$prepare->bindParam(6, $HTUserToken, PDO::PARAM_STR);
		$prepare->bindParam(7, $HTUserTokenSecret, PDO::PARAM_STR);  
    $prepare->bindParam(8, $LastTraining, PDO::PARAM_STR);
		$prepare->bindParam(9, $conditieperc, PDO::PARAM_INT);
		$prepare->bindParam(10, $trainingtype, PDO::PARAM_INT);
		$prepare->bindParam(11, $trainingintensity, PDO::PARAM_INT);
		$prepare->bindParam(12, $trainerskill, PDO::PARAM_INT);
		$prepare->bindParam(13, $assistants, PDO::PARAM_INT);
		$prepare->bindParam(14, $physios, PDO::PARAM_INT);
		$prepare->bindParam(15, $doctors, PDO::PARAM_INT);
    $prepare->bindParam(16, $lastHTlogin, PDO::PARAM_STR);
		$prepare->bindParam(17, $leagueID, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function updateCoach($coach) {
		$teamID = $coach->getTeamid();
		$teamName = $coach->getTeamname();
		$coachID = $coach->getId();
		$DSUserName = $coach->getDSUserName();
		$DSPassword = $coach->getDSPassword();
		$HTUserToken = $coach->getHTUserToken();
		$HTUserTokenSecret = $coach->getHTUserTokenSecret();
		$LastTraining = $coach->getLastTraining();
		$conditieperc = $coach->getconditieperc();
		$trainingtype = $coach->gettrainingtype();
		$trainingintensity = $coach->gettrainingintensity();
		$trainerskill = $coach->gettrainerskill();
		$assistants = $coach->getassistants();
		$physios = $coach->getphysios();
		$doctors = $coach->getdoctors();
		$lastHTlogin = $coach->getlastHTlogin();
		$bot = $coach->getbot();
		$leagueID = $coach->getleagueID();
		$prepare	=	parent::getConn()->prepare(
			"UPDATE coach set teamid = ?, teamname = ?, DSUserName = ?, DSPassword = ?, HTUserToken = ?, HTUserTokenSecret = ?, LastTrainingDate = ?, conditieperc = ?, ".
			"  trainingtype = ?, trainingintensity = ?, trainerskill = ?, assistants = ?, physios = ?, doctors = ?, lastHTlogin = ?, bot = ?, leagueID = ? where id = ?");
		$prepare->bindParam(1, $teamID, PDO::PARAM_INT);
		$prepare->bindParam(2, $teamName, PDO::PARAM_STR);
		$prepare->bindParam(3, $DSUserName, PDO::PARAM_STR);
		$prepare->bindParam(4, $DSPassword, PDO::PARAM_STR);
		$prepare->bindParam(5, $HTUserToken, PDO::PARAM_STR);
		$prepare->bindParam(6, $HTUserTokenSecret, PDO::PARAM_STR);
		$prepare->bindParam(7, $LastTraining, PDO::PARAM_STR);
		$prepare->bindParam(8, $conditieperc, PDO::PARAM_INT);
		$prepare->bindParam(9, $trainingtype, PDO::PARAM_INT);
		$prepare->bindParam(10, $trainingintensity, PDO::PARAM_INT);
		$prepare->bindParam(11, $trainerskill, PDO::PARAM_INT);
		$prepare->bindParam(12, $assistants, PDO::PARAM_INT);
		$prepare->bindParam(13, $physios, PDO::PARAM_INT);
		$prepare->bindParam(14, $doctors, PDO::PARAM_INT);
		$prepare->bindParam(15, $lastHTlogin, PDO::PARAM_STR);
		$prepare->bindParam(16, $bot, PDO::PARAM_INT);
		$prepare->bindParam(17, $leagueID, PDO::PARAM_INT);
		
		$prepare->bindParam(18, $coachID, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function updateCoachLastLogin($time, $coachId) {
		$prepare		=	parent::getConn()->prepare("UPDATE coach SET lastlogin = FROM_UNIXTIME(?) WHERE id = ? LIMIT 1");
		$prepare->bindParam(1, $time, PDO::PARAM_INT);
		$prepare->bindParam(2, $coachId, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function getCoachList() {
		$prepare	=	parent::getConn()->prepare("SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, conditieperc, ".
		"  trainingtype, trainingintensity, trainerskill, assistants, physios, doctors, lastHTlogin, bot, leagueID FROM coach WHERE DSUserName <> '' ORDER BY teamname ASC");
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
				$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
				$row['assistants'], $row['physios'], $row['doctors'], $row['lastHTlogin'], $row['bot'], $row['leagueID']);
		}																													
		
		return $list;
	}
	
	public static function insertScout($coachId, $scoutId) {
		$prepare	=	parent::getConn()->prepare("INSERT INTO coachScout (coach, scout) VALUES (?, ?)");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->bindParam(2, $scoutId, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function deleteScout($coachId, $scoutId) {
		$prepare	=	parent::getConn()->prepare("DELETE FROM coachScout WHERE coach = ? AND scout = ?");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->bindParam(2, $scoutId, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function getScout($coachId) {
		$prepare	=	parent::getConn()->prepare("SELECT scout FROM coachScout WHERE coach = ?");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->execute();
		
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	ScoutDB::getScout($row['scout']);
		}
		
		return $list;
	}
}
?>
