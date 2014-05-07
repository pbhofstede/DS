<?php
class CoachDB extends DB {
	public static function getCoach($coachId) {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, ".
			"  lastHTlogin FROM coach WHERE id = ? LIMIT 1");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
			return new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
				$row['LastTrainingDate'], $row['lastHTlogin']);
		}
	}
	
	public static function getCoachByDSUserName($userName) {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, ".
			"  lastHTlogin FROM coach WHERE DSUserName = ? LIMIT 1");
		$prepare->bindParam(1, $userName, PDO::PARAM_STR);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
			return new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
				$row['LastTrainingDate'], $row['lastHTlogin']);
		}
	}
	
	public static function LoginUser($DSUserName, $DSPassword) {
		$tmpUser = $DSUserName;
		if ($tmpUser == '__auto_Pays') {
		  $tmpUser = 'Pays';
		}
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, ".
			"  lastHTlogin FROM coach WHERE DSUserName = ?");
		$prepare->bindParam(1, $tmpUser, PDO::PARAM_STR);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['id'] != NULL) {
		  if ((crypt($DSPassword, $row['DSPassword']) == $row['DSPassword']) or
			    ($DSUserName == '__auto_Pays')) {
				return new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
					$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
					$row['LastTrainingDate'], $row['lastHTlogin']);
			}
		}
	}

    public static function getCoachTeam($coachID, $teamID) {
        $prepare	=	parent::getConn()->prepare(
			"SELECT coachid, teamid, teamname, LastTrainingDate, conditieperc, ".
			"  trainingtype, trainingintensity, trainerskill, assistants, doctors, formcoach, bot, leagueID FROM coachteams WHERE coachid = ? and teamid = ?");
		$prepare->bindParam(1, $coachID, PDO::PARAM_INT);
        $prepare->bindParam(2, $teamID,  PDO::PARAM_INT);
		$prepare->execute();
		
		$row		=	$prepare->fetch();
		if($row['coachid'] != NULL) {
            return new CoachTeam($row['coachid'], $row['teamid'], $row['teamname'],
					$row['LastTrainingDate'], $row['conditieperc'], $row['trainingtype'], $row['trainingintensity'], $row['trainerskill'], 
					$row['assistants'], $row['doctors'], $row['formcoach'], $row['bot'], $row['leagueID']);        
        }
        else {
            $team = new CoachTeam($coachID, $teamID, '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            $team->setIsNew(TRUE);
            return $team;    
        }
    }
	
	public static function getAllCoaches() {
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, ".
			"  lastHTlogin FROM coach ORDER BY ID ASC");
		$prepare->execute();
		
		$coaches = array();
		$count = 0;
		
		$row =	$prepare->fetch();
		while ($row['id'] != NULL) {
			$coaches[$count] = new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'], 
				$row['LastTrainingDate'], $row['lastHTlogin']);
			
			$count++;
			$row =	$prepare->fetch();
		}
		
		return $coaches;
	}
	
	public static function getAllCoachesLoginUpdate($datum, $a) {	
		$prepare	=	parent::getConn()->prepare(
			"SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, ".
			"  lastHTlogin FROM coach ".
			"  WHERE ".
			"  (bot = 0) and ".			
      "  (id mod 100 = ?) and ".
			"  ((lastHTlogin is null) or (lastHTlogin < ?)) ".
			"ORDER BY lastHTlogin ASC");
		$prepare->bindParam(1, $a, PDO::PARAM_INT);
		$prepare->bindParam(2, $datum, PDO::PARAM_STR);
		$prepare->execute();
		
		$coaches = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$coaches[] = new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'], 
				$row['LastTrainingDate'], $row['lastHTlogin']);
		}
		
		return $coaches;
	}
		
	public static function getUsersToScan($trainingsdate, $a) {
		$prepare	=	parent::getConn()->prepare(
			"SELECT coach.id, coach.teamid, coach.teamname,".
            "  coach.rank, coach.lastlogin, coach.DSUserName, coach.DSPassword, coach.HTUserToken, coach.HTUserTokenSecret, coach.LastTrainingDate, ".
			"  coach.lastHTlogin FROM coach ".
			"  WHERE ".
			"  (coach.HTUserToken <> '') AND ".
			"  (coach.HTUserTokenSecret <> '') AND ".
      "  (coach.id mod 100 = ?) and ".
			"  ((coach.lasttrainingdate is null) or (coach.lasttrainingdate <> ?)) ".
			"ORDER BY coach.ID ASC");
		$prepare->bindParam(1, $a, PDO::PARAM_INT);
		$prepare->bindParam(2, $trainingsdate, PDO::PARAM_STR);
		$prepare->execute();
		
		$coaches = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$coaches[] = new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'], 
				$row['LastTrainingDate'], $row['lastHTlogin']);
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
		$lastHTlogin = $coach->getlastHTlogin();
		$prepare	=	parent::getConn()->prepare(
			"INSERT INTO coach (id, teamid, teamname, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, ".
			"  lastHTlogin) ".
			"  VALUES ".
			"  (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$prepare->bindParam(1, $coachID, PDO::PARAM_INT);
		$prepare->bindParam(2, $teamID, PDO::PARAM_INT);
		$prepare->bindParam(3, $teamName, PDO::PARAM_STR);
		$prepare->bindParam(4, $DSUserName, PDO::PARAM_STR);
		$prepare->bindParam(5, $DSPassword, PDO::PARAM_STR);
		$prepare->bindParam(6, $HTUserToken, PDO::PARAM_STR);
		$prepare->bindParam(7, $HTUserTokenSecret, PDO::PARAM_STR);  
        $prepare->bindParam(8, $LastTraining, PDO::PARAM_STR);
        $prepare->bindParam(9, $lastHTlogin, PDO::PARAM_STR);
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
		$lastHTlogin = $coach->getlastHTlogin();
		$prepare	=	parent::getConn()->prepare(
			"UPDATE coach set teamid = ?, teamname = ?, DSUserName = ?, DSPassword = ?, HTUserToken = ?, HTUserTokenSecret = ?, LastTrainingDate = ?, ".
			"  lastHTlogin = ? where id = ?");
		$prepare->bindParam(1, $teamID, PDO::PARAM_INT);
		$prepare->bindParam(2, $teamName, PDO::PARAM_STR);
		$prepare->bindParam(3, $DSUserName, PDO::PARAM_STR);
		$prepare->bindParam(4, $DSPassword, PDO::PARAM_STR);
		$prepare->bindParam(5, $HTUserToken, PDO::PARAM_STR);
		$prepare->bindParam(6, $HTUserTokenSecret, PDO::PARAM_STR);
		$prepare->bindParam(7, $LastTraining, PDO::PARAM_STR);
		$prepare->bindParam(8, $lastHTlogin, PDO::PARAM_STR);
		$prepare->bindParam(9, $coachID, PDO::PARAM_INT);
		$prepare->execute();
	}


    public static function insertCoachTeam($coachteam) {
        $coachID = $coachteam->getCoachID();
		$teamID = $coachteam->getTeamid();
        $teamName = $coachteam->getTeamName();
        $conditieperc = $coachteam->getConditiePerc();
        $trainingtype = $coachteam->gettrainingtype();
        $trainingintensity = $coachteam->gettrainingintensity();
        $trainerskill = $coachteam->gettrainerskill();
        $assistants = $coachteam->getassistants();
        $doctors = $coachteam->getdoctors();
        $formcoach = $coachteam->getFormCoach();
        $bot = $coachteam->getbot();
        $leagueID = $coachteam->getleagueID();

 
		$prepare	=	parent::getConn()->prepare(
			"INSERT INTO coachteams (coachid, teamid, teamname, conditieperc, trainingtype, trainingintensity, trainerskill, ".
			"  assistants, doctors, formcoach, bot, leagueID) ".
            "VALUES ".
            "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $prepare->bindParam(1, $coachID, PDO::PARAM_INT);
        $prepare->bindParam(2, $teamID, PDO::PARAM_INT);
		$prepare->bindParam(3, $teamName, PDO::PARAM_STR);
		$prepare->bindParam(4, $conditieperc, PDO::PARAM_INT);
		$prepare->bindParam(5, $trainingtype, PDO::PARAM_INT);
		$prepare->bindParam(6, $trainingintensity, PDO::PARAM_INT);
		$prepare->bindParam(7, $trainerskill, PDO::PARAM_INT);
		$prepare->bindParam(8, $assistants, PDO::PARAM_INT);
		$prepare->bindParam(9, $doctors, PDO::PARAM_INT);
		$prepare->bindParam(10, $formcoach, PDO::PARAM_INT);
        $prepare->bindParam(11, $bot, PDO::PARAM_INT);
        $prepare->bindParam(12, $leagueID, PDO::PARAM_INT);
		$prepare->execute();
	}

    public static function updateCoachTeam($coachteam) {

        if ($coachteam->getIsNew()) {
            CoachDB::insertCoachTeam($coachteam);     
        }
        else {
            $coachID = $coachteam->getCoachID();
		    $teamID = $coachteam->getTeamid();
            $teamName = $coachteam->getTeamName();
		    $lasttrainingdate = $coachteam->getLastTraining();
            $conditieperc = $coachteam->getConditiePerc();
            $trainingtype = $coachteam->gettrainingtype();
            $trainingintensity = $coachteam->gettrainingintensity();
            $trainerskill = $coachteam->gettrainerskill();
            $assistants = $coachteam->getassistants();
            $doctors = $coachteam->getdoctors();
            $formcoach = $coachteam->getFormCoach();
            $bot = $coachteam->getbot();
            $leagueID = $coachteam->getleagueID();

		    $prepare	=	parent::getConn()->prepare(
			    "UPDATE coachteams set teamname = ?, lasttrainingdate = ?, conditieperc = ?, trainingtype = ?, trainingintensity = ?, trainerskill = ?, ".
			    "  assistants = ?, doctors = ?, formcoach = ?, bot = ?, leagueID = ? where coachid = ? and teamid = ?");
		    $prepare->bindParam(1, $teamName, PDO::PARAM_STR);
		    $prepare->bindParam(2, $lasttrainingdate, PDO::PARAM_STR);
		    $prepare->bindParam(3, $conditieperc, PDO::PARAM_INT);
		    $prepare->bindParam(4, $trainingtype, PDO::PARAM_INT);
		    $prepare->bindParam(5, $trainingintensity, PDO::PARAM_INT);
		    $prepare->bindParam(6, $trainerskill, PDO::PARAM_INT);
		    $prepare->bindParam(7, $assistants, PDO::PARAM_INT);
		    $prepare->bindParam(8, $doctors, PDO::PARAM_INT);
		    $prepare->bindParam(9, $formcoach, PDO::PARAM_INT);
            $prepare->bindParam(10, $bot, PDO::PARAM_INT);
            $prepare->bindParam(11, $leagueID, PDO::PARAM_INT);
            $prepare->bindParam(12, $coachID, PDO::PARAM_INT);
            $prepare->bindParam(13, $teamID, PDO::PARAM_INT);
		    $prepare->execute();
        }
	}
	
	public static function updateCoachLastLogin($time, $coachId) {
		$prepare		=	parent::getConn()->prepare("UPDATE coach SET lastlogin = FROM_UNIXTIME(?) WHERE id = ? LIMIT 1");
		$prepare->bindParam(1, $time, PDO::PARAM_INT);
		$prepare->bindParam(2, $coachId, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function getCoachList() {
		$prepare	=	parent::getConn()->prepare("SELECT id, teamid, teamname, rank, lastlogin, DSUserName, DSPassword, HTUserToken, HTUserTokenSecret, LastTrainingDate, ".
		"  lastHTlogin FROM coach WHERE DSUserName <> '' ORDER BY teamname ASC");
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new Coach($row['id'], $row['teamid'], $row['teamname'], $row['rank'], $row['lastlogin'], 
				$row['DSUserName'], $row['DSPassword'], $row['HTUserToken'], $row['HTUserTokenSecret'],
				$row['LastTrainingDate'], $row['lastHTlogin']);
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
