<?php

class PlayerDB extends DB {
	
	public static function getPlayer($playerId) {
		global $const_player_sql;
		$prepare		=	parent::getConn()->prepare(
			$const_player_sql."WHERE player.id = ? LIMIT 1");
		$prepare->bindParam(1, $playerId, PDO::PARAM_INT);
		$prepare->execute();
		
		$row =	$prepare->fetch();
		if($row['id'] != NULL) {
			return new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), 
				$row['tsi'], $row['salary'], $row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], 
				$row['leadership'], $row['speciality'], $row['form'], $row['stamina'], $row['experience'], 
				$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
				$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
				$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
				$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
				$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
		}
	}
	
	public static function deletePlayer($playerId) {
		$prepare		=	parent::getConn()->prepare(
			"delete from player WHERE player.id = ?");
		$prepare->bindParam(1, $playerId, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function getPlayerByName($playerName) {
		global $const_player_sql;
		$prepare		=	parent::getConn()->prepare(
			$const_player_sql."WHERE player.name LIKE ? LIMIT 100");
		$prepare->bindParam(1, $playerName, PDO::PARAM_STR);
		$prepare->execute();
		
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), 
				$row['tsi'], $row['salary'], $row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], 
				$row['leadership'], $row['speciality'], $row['form'], $row['stamina'], $row['experience'], 
				$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
				$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
				$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
				$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
				$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
		}
		
		return $list;
	}
	
	public static function getAllPlayers($idEndsWith) {	
		global $const_player_sql;
		$prepare		=	parent::getConn()->prepare(
			$const_player_sql."WHERE player.ID like '%".$idEndsWith."'");
		$prepare->execute();
		
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), 
				$row['tsi'], $row['salary'], $row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], 
				$row['leadership'], $row['speciality'], $row['form'], $row['stamina'], $row['experience'], 
				$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
				$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
				$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
				$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
				$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
		}
		
		return $list;
	}
	
	
	public static function insertPlayer($player) {
		$prepare		=	parent::getConn()->prepare("INSERT INTO player (id, coach, name, dateOfBirth, tsi, salary, injury, aggressiveness, agreeability, honesty, leadership, speciality, form, stamina, experience, keeper, defender, playmaker, winger, passing, scorer, setPieces, caps, capsU20, added, lastupdate, u20) VALUES (?, ?, ?, FROM_UNIXTIME(?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?), FROM_UNIXTIME(?), ?)");
		$id=$player->getId();
		$coachID=$player->getCoachId();
		$name=$player->getName();
		$gebdat=$player->getDateOfBirth();
		$tsi=$player->getTsi();
		$salary=$player->getSalary();
		$injury=$player->getInjury();
		$aggr=$player->getAggressiveness();
		$agre=$player->getAgreeability();
		$hone=$player->getHonesty();
		$lead=$player->getLeadership();
		$spec=$player->getSpeciality();
		$form=$player->getForm();
		$stamina=$player->getStamina();
		$exp=$player->getExperience();
		$keep=$player->getKeeper();
		$def=$player->getDefender();
		$pm=$player->getPlaymaker();
		$wing=$player->getWinger();
		$pass=$player->getPassing();
		$sco=$player->getScorer();
		$sp=$player->getSetPieces();
		$caps=$player->getCaps();
		$U20caps=$player->getCapsU20();
		$dateAdded=$player->getAdded();
		$lastupdate=$player->getLastupdate();
		
		if (! ($player->getU20()) && 
		    ($player->getHasU20Age() <> ''))
		{
      $player->setU20(TRUE);
		}
		if ($player->getu20()) {
			$u20Int = -1;
    }
    else {
			$u20Int = 0;
    }
		
		$prepare->bindParam(1, $id, PDO::PARAM_INT);
		$prepare->bindParam(2, $coachID, PDO::PARAM_INT);
		$prepare->bindParam(3, $name, PDO::PARAM_STR);
		$prepare->bindParam(4, $gebdat, PDO::PARAM_INT);
		$prepare->bindParam(5, $tsi, PDO::PARAM_INT);
		$prepare->bindParam(6, $salary, PDO::PARAM_INT);
		$prepare->bindParam(7, $injury, PDO::PARAM_INT);
		$prepare->bindParam(8, $aggr, PDO::PARAM_INT);
		$prepare->bindParam(9, $agre, PDO::PARAM_INT);
		$prepare->bindParam(10, $hone, PDO::PARAM_INT);
		$prepare->bindParam(11, $lead, PDO::PARAM_INT);
		$prepare->bindParam(12, $spec, PDO::PARAM_INT);
		$prepare->bindParam(13, $form, PDO::PARAM_INT);
		$prepare->bindParam(14, $stamina, PDO::PARAM_INT);
		$prepare->bindParam(15, $exp, PDO::PARAM_INT);
		$prepare->bindParam(16, $keep, PDO::PARAM_INT);
		$prepare->bindParam(17, $def, PDO::PARAM_INT);
		$prepare->bindParam(18, $pm, PDO::PARAM_INT);
		$prepare->bindParam(19, $wing, PDO::PARAM_INT);
		$prepare->bindParam(20, $pass, PDO::PARAM_INT);
		$prepare->bindParam(21, $sco, PDO::PARAM_INT);
		$prepare->bindParam(22, $sp, PDO::PARAM_INT);
		$prepare->bindParam(23, $caps, PDO::PARAM_INT);
		$prepare->bindParam(24, $U20caps, PDO::PARAM_INT);
		$prepare->bindParam(25, $dateAdded, PDO::PARAM_STR);
		$prepare->bindParam(26, $lastupdate, PDO::PARAM_STR);
    $prepare->bindParam(27, $u20Int, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function updatePlayerScout($playerID, $scoutID){
		$prepare		=	parent::getConn()->prepare("UPDATE player SET scoutid = ? where id = ?");
		
		
		$prepare->bindParam(1, $scoutID, PDO::PARAM_INT);
		$prepare->bindParam(2, $playerID, PDO::PARAM_INT);
		
		$prepare->execute();
	}

	public static function updatePlayer($player) {
		$prepare		=	parent::getConn()->prepare("UPDATE player SET coach = ?, tsi = ?, salary = ?, injury = ?, form = ?, stamina = ?, experience = ?,".
			"keeper = ?, defender = ?, playmaker = ?, winger = ?, passing = ?, scorer = ?, setPieces = ?,".
			"caps = ?, capsU20 = ?, dateOfBirth = FROM_UNIXTIME(?), lastupdate = FROM_UNIXTIME(?), ".
			"indexGK = ?, indexCD = ?, indexDEF = ?, indexWB = ?, indexIM = ?, indexWG = ?, indexSC = ?, indexDFW = ?, indexSP = ?, ".
			"keeperSubSkill = ?, defenderSubSkill = ?, playmakerSubSkill = ?, wingerSubSkill = ?, passingSubSkill = ?, scorerSubSkill = ?, setPiecesSubSkill = ?, ".
			"lasttraining = ?, u20 = ?, sundayTraining = ? ".
			"WHERE id = ? LIMIT 1");
		
		$id=$player->getId();
		$coachID=$player->getCoachId();
		$name=$player->getName();
		$gebdat=$player->getDateOfBirth();
		$tsi=$player->getTsi();
		$salary=$player->getSalary();
		$injury=$player->getInjury();
		$aggr=$player->getAggressiveness();
		$agre=$player->getAgreeability();
		$hone=$player->getHonesty();
		$lead=$player->getLeadership();
		$spec=$player->getSpeciality();
		$form=$player->getForm();
		$stamina=$player->getStamina();
		$exp=$player->getExperience();
		$keep=$player->getKeeper();
		$def=$player->getDefender();
		$pm=$player->getPlaymaker();
		$wing=$player->getWinger();
		$pass=$player->getPassing();
		$sco=$player->getScorer();
		$sp=$player->getSetPieces();
		$caps=$player->getCaps();
		$U20caps=$player->getCapsU20();
		$dateAdded=$player->getAdded();
		$lastupdate=$player->getLastupdate();
		$keepSubSkill=$player->getKeeperSubSkill();
		$defSubSkill=$player->getDefenderSubSkill();
		$pmSubSkill=$player->getPlaymakerSubSkill();
		$wingSubSkill=$player->getWingerSubSkill();
		$passSubSkill=$player->getPassingSubSkill();
		$scoSubSkill=$player->getScorerSubSkill();
		$spSubSkill=$player->getSetPiecesSubSkill();	
		$lasttraining=$player->getlasttraining();	 
		if ($player->getu20()) {
			$verjaardag = getDayInt($player->getDateOfBirth()) + (21 * 112);
			
			//controleren of speler ondertussen 21 is geworden.
			if ($verjaardag >= getDayInt(0)) {
				$u20Int = -1;
			}
			else {
				//speler is 21 geworden, U20 uit zetten en NT-indexes berekenen
				$player->setu20(FALSE);
				$player->calcIndicesAndUpdateToDB();
				$u20Int = 0;
			}
    }
    else {
			$u20Int = 0;
    }
		
		$indexGK=$player->getIndexGK();
		$indexCD=$player->getIndexCD();
		$indexDEF=$player->getIndexDEF();
		$indexWB=$player->getIndexWB();
		$indexIM=$player->getIndexIM();
		$indexWG=$player->getIndexWG();
		$indexSC=$player->getIndexSC();
		$indexDFW=$player->getIndexDFW();    
		$indexSP=$player->getIndexSP();
		$sundayTraining=$player->getsundayTraining();
		
		$prepare->bindParam(1, $coachID, PDO::PARAM_INT);
		$prepare->bindParam(2, $tsi, PDO::PARAM_INT);
		$prepare->bindParam(3, $salary, PDO::PARAM_INT);
		$prepare->bindParam(4, $injury, PDO::PARAM_INT);
		$prepare->bindParam(5, $form, PDO::PARAM_INT);
		$prepare->bindParam(6, $stamina, PDO::PARAM_INT);
		$prepare->bindParam(7, $exp, PDO::PARAM_INT);
		$prepare->bindParam(8, $keep, PDO::PARAM_INT);
		$prepare->bindParam(9, $def, PDO::PARAM_INT);
		$prepare->bindParam(10, $pm, PDO::PARAM_INT);
		$prepare->bindParam(11, $wing, PDO::PARAM_INT);
		$prepare->bindParam(12, $pass, PDO::PARAM_INT);
		$prepare->bindParam(13, $sco, PDO::PARAM_INT);
		$prepare->bindParam(14, $sp, PDO::PARAM_INT);
		$prepare->bindParam(15, $caps, PDO::PARAM_INT);
		$prepare->bindParam(16, $U20caps, PDO::PARAM_INT);
		$prepare->bindParam(17, $gebdat, PDO::PARAM_STR);
		$prepare->bindParam(18, $lastupdate, PDO::PARAM_STR);
		$prepare->bindParam(19, $indexGK, PDO::PARAM_STR);
		$prepare->bindParam(20, $indexCD, PDO::PARAM_STR);
		$prepare->bindParam(21, $indexDEF, PDO::PARAM_STR);
		$prepare->bindParam(22, $indexWB, PDO::PARAM_STR);
		$prepare->bindParam(23, $indexIM, PDO::PARAM_STR);
		$prepare->bindParam(24, $indexWG, PDO::PARAM_STR);
		$prepare->bindParam(25, $indexSC, PDO::PARAM_STR);
		$prepare->bindParam(26, $indexDFW, PDO::PARAM_STR);   
		$prepare->bindParam(27, $indexSP, PDO::PARAM_STR);
		$prepare->bindParam(28, $keepSubSkill, PDO::PARAM_STR);
		$prepare->bindParam(29, $defSubSkill, PDO::PARAM_STR);
		$prepare->bindParam(30, $pmSubSkill, PDO::PARAM_STR);
		$prepare->bindParam(31, $wingSubSkill, PDO::PARAM_STR);
		$prepare->bindParam(32, $passSubSkill, PDO::PARAM_STR);
		$prepare->bindParam(33, $scoSubSkill, PDO::PARAM_STR);
		$prepare->bindParam(34, $spSubSkill, PDO::PARAM_STR);
		$prepare->bindParam(35, $lasttraining, PDO::PARAM_STR); 
		$prepare->bindParam(36, $u20Int, PDO::PARAM_INT);
		$prepare->bindParam(37, $sundayTraining, PDO::PARAM_INT); 
		
		$prepare->bindParam(38, $id, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function searchPlayer($ageMinimum, $ageMaximum, 
		$keeper, $defender, $playmaker, $winger, $passing, $scorer, $setPieces, $speciality, 
		$indexGK, $indexCD, $indexDEF, $indexWB, $indexIM, $indexWG, $indexSC, $indexDFW, $indexSP, $orderBy, $u20, $inclOld) {
		
		if ($indexGK == '') {
		  $indexGK = -400;
		} 
		if ($indexCD == '') {
		  $indexCD = -400;
		} 
		if ($indexDEF == '') {
		  $indexDEF = -400;
		} 
		if ($indexWB == '') {
		  $indexWB = -400;
		} 
		if ($indexIM == '') {
		  $indexIM = -400;
		} 
		if ($indexWG == '') {
		  $indexWG = -400;
		} 
		if ($indexSC == '') {
		  $indexSC = -400;
		} 
		if ($indexDFW == '') {
		  $indexDFW = -400;
		}
    if ($indexSP == '') {
		  $indexSP = -400;
		}
		global $const_player_sql;
		
		$csql = 
		  $const_player_sql.
			' WHERE keeper >= ? AND defender >= ? AND playmaker >= ? AND winger >= ? AND passing >= ? AND scorer >= ? AND setPieces >= ? '.
			' AND dateOfBirth < FROM_UNIXTIME(?) AND dateOfBirth > FROM_UNIXTIME(?) AND u20 = ?';
			
		if ($speciality > 0) {
			$csql = $csql.' AND speciality = '.$speciality.' ';
		}
		
		if (! $inclOld) {
			$datum = strtotime("-119 days", time());
			$csql = $csql.' AND lastupdate >= "'.date("Y-m-d", $datum).'" ';
		}
			
		$csql = $csql.
			' AND indexGK >= ? AND indexCD >= ? AND indexDEF >= ? AND indexWB >= ? AND indexIM >= ? AND indexWG >= ? AND indexSC >= ? AND indexDFW >= ? AND indexSP >= ? ';
		
		if ($orderBy <> '') {
			$csql = $csql.' ORDER BY '.$orderBy.' DESC LIMIT 100';
		}
		else
		{
			$csql = $csql.' ORDER BY lastupdate DESC LIMIT 100';
		}
		
		$prepare =	parent::getConn()->prepare($csql);
		$prepare->bindParam(1, $keeper, PDO::PARAM_INT);
		$prepare->bindParam(2, $defender, PDO::PARAM_INT);
		$prepare->bindParam(3, $playmaker, PDO::PARAM_INT);
		$prepare->bindParam(4, $winger, PDO::PARAM_INT);
		$prepare->bindParam(5, $passing, PDO::PARAM_INT);
		$prepare->bindParam(6, $scorer, PDO::PARAM_INT);
		$prepare->bindParam(7, $setPieces, PDO::PARAM_INT);
		$prepare->bindParam(8, $ageMinimum, PDO::PARAM_STR);
		$prepare->bindParam(9, $ageMaximum, PDO::PARAM_STR);
		
    if ($u20) {
			$u20Int = -1;
    }
    else {
			$u20Int = 0;
    }
		$prepare->bindParam(10, $u20Int, PDO::PARAM_INT);
		$prepare->bindParam(11, $indexGK, PDO::PARAM_INT);
		$prepare->bindParam(12, $indexCD, PDO::PARAM_INT);
		$prepare->bindParam(13, $indexDEF, PDO::PARAM_INT);
		$prepare->bindParam(14, $indexWB, PDO::PARAM_INT);
		$prepare->bindParam(15, $indexIM, PDO::PARAM_INT);
		$prepare->bindParam(16, $indexWG, PDO::PARAM_INT);
		$prepare->bindParam(17, $indexSC, PDO::PARAM_INT);
		$prepare->bindParam(18, $indexDFW, PDO::PARAM_INT);
		$prepare->bindParam(19, $indexSP, PDO::PARAM_INT);

		$prepare->execute();
		
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), $row['tsi'], $row['salary'], 
				$row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], $row['leadership'], $row['speciality'], 
				$row['form'], $row['stamina'], $row['experience'], 
				$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
				$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
				$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
				$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
				$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
		}
		
		return $list;
	}
	
	public static function clearNonExistingPlayer($coachId, $idlist) {
		$prepare		=	parent::getConn()->prepare("update player set coach = 0 where ((coach = ?) and (id not in(".$idlist.")))");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function clearLastTraining() {
		$prepare		=	parent::getConn()->prepare("update player set lasttraining = NULL");
		$prepare->execute();
	}
	
	public static function clearsundayTraining() {
		$prepare		=	parent::getConn()->prepare("update player set sundayTraining = NULL");
		$prepare->execute();
	}

	public static function getPlayerListByCoach($coachId) {
		global $const_player_sql;
		$prepare		=	parent::getConn()->prepare(
			$const_player_sql."WHERE player.coach = ? ORDER BY player.dateOfBirth DESC, player.lastupdate DESC");
		$prepare->bindParam(1, $coachId, PDO::PARAM_INT);
		$prepare->execute();
		
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {	
			$list[] =	new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), $row['tsi'], $row['salary'], 
				$row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], $row['leadership'], $row['speciality'],
				$row['form'], $row['stamina'], $row['experience'], 
				$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
				$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
				$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
				$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
				$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
		}
		
		return $list;
	}
	
	public static function getPlayerWithoutCoach($a) {
		global $const_player_sql;
		$prepare		=	parent::getConn()->prepare(
			$const_player_sql."WHERE player.coach <= 0");
		$prepare->execute();
		
		$list = null;
		
		foreach($prepare->fetchAll() AS $row) {
			if ($row['id'] % 100 == $a) {
				$list[] =	new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), $row['tsi'], $row['salary'], 
					$row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], $row['leadership'], $row['speciality'],
					$row['form'], $row['stamina'], $row['experience'], 
					$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
					$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
					$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
					$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
					$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
			}
		}
		
		//de topspelers die wel een coach hebben maar geen DS-login		
		$prepare		=	parent::getConn()->prepare(
			$const_player_sql.
			  "WHERE ".
				"  (player.coach > 0) AND ".
				"  (player.lastupdate > ?) AND ".
				"  (coach.HTUserToken = '') AND ".
				"  ((scoutid > 0) or ".
				"   (GREATEST(indexGK, indexCD, indexDEF, indexWB, indexIM, indexWG, indexSC, indexDFW, indexSP) >  ".
				"   	((((dateDIFF(now(), dateOfBirth) / 112) - 16) * -4) + (LEAST(GREATEST((dateDIFF('2004-12-01', dateOfBirth) / 112), 0), 12) * -8)))) ".
				"ORDER BY player.ID ASC");
		
		$prepare->bindParam(1, date("Y-m-d", strtotime("-200 days", time())), PDO::PARAM_STR);
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
			if ($row['id'] % 100 == $a) {
				$list[] =	new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), $row['tsi'], $row['salary'], 
					$row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], $row['leadership'], $row['speciality'],
					$row['form'], $row['stamina'], $row['experience'], 
					$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
					$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
					$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
					$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
					$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
			}
		}
		
		
		return $list;
	}
	
	public static function getPlayerByRequirements($requirements, $forceAllPlayers, $scout) {	
		global $const_player_sql;
		$datum = strtotime("-119 days", time());
		
		$prepare_index		=	parent::getConn()->prepare(
			$const_player_sql.
			"WHERE (u20 = ?) and ".			
			'(lastupdate >= "'.date("Y-m-d", $datum).'") AND '.
			"((scoutID = ?) or ".
			" (indexGK >= ? OR ".
			"  indexCD >= ? OR ".
			"  indexDEF >= ? OR ".
			"  indexWB >= ? OR ".
			"  indexIM >= ? OR ".
			"  indexWG >= ? OR ".
			"  indexSC >= ? OR ".
			"  indexDFW >= ? OR ".
			"  indexSP >= ?)) AND ".
			"dateOfBirth < FROM_UNIXTIME(?) AND dateOfBirth > FROM_UNIXTIME(?) AND dateOfBirth <= FROM_UNIXTIME(?) AND dateOfBirth >= FROM_UNIXTIME(?) ORDER BY dateOfBirth");
		
		$list = null;
		
		foreach($requirements AS $requirement) 
		{
		 	$agestart = $requirement->getAgeCurrentStartRequirement();
		 	$ageend = $requirement->getAgeCurrentEndRequirement();
			if ($requirement->getU20()) {
				$u20Int = -1;
			}
			else {
				$u20Int = 0;
			}
			$scoutID = $requirement->getScoutID();
		 	$indexGK = $requirement->getIndexGK();
	 		$indexCD = $requirement->getIndexCD();
	 		$indexDEF = $requirement->getIndexDEF();
	 		$indexWB = $requirement->getIndexWB();
	 		$indexIM = $requirement->getIndexIM();
	 		$indexWG = $requirement->getIndexWG();
	 		$indexSC = $requirement->getIndexSC();
	 		$indexDFW = $requirement->getIndexDFW();
	 		$indexSP = $requirement->getIndexSP();
	 		
			$requirementStart = $requirement->getAgeStart() + (2 * 86400);
			$requirementsEnd = $requirement->getAgeEnd() - 86400;
			
			if ($indexGK == NULL)
			{
				$indexGK = 100;	
			}
			if ($indexCD == NULL)
			{
				$indexCD = 100;	
			}
			if ($indexDEF == NULL)
			{
				$indexDEF = 100;	
			}
			if ($indexWB == NULL)
			{
				$indexWB = 100;	
			}
			if ($indexIM == NULL)
			{
				$indexIM = 100;	
			}
			if ($indexWG == NULL)
			{
				$indexWG = 100;	
			}
			if ($indexSC == NULL)
			{
				$indexSC = 100;	
			}
			if ($indexDFW == NULL)
			{
				$indexDFW = 100;	
			}
			if ($indexSP == NULL)
			{
				$indexSP = 100;	
			}
				
			$prepare_index->bindParam(1, $u20Int, PDO::PARAM_INT);
			$prepare_index->bindParam(2, $scoutID, PDO::PARAM_INT);
			$prepare_index->bindParam(3, $indexGK, PDO::PARAM_INT);
			$prepare_index->bindParam(4, $indexCD, PDO::PARAM_INT);
			$prepare_index->bindParam(5, $indexDEF, PDO::PARAM_INT);
			$prepare_index->bindParam(6, $indexWB, PDO::PARAM_INT);
			$prepare_index->bindParam(7, $indexIM, PDO::PARAM_INT);
			$prepare_index->bindParam(8, $indexWG, PDO::PARAM_INT);
			$prepare_index->bindParam(9, $indexSC, PDO::PARAM_INT);
			$prepare_index->bindParam(10, $indexDFW, PDO::PARAM_INT);
			$prepare_index->bindParam(11, $indexSP, PDO::PARAM_INT);
			$prepare_index->bindParam(12, $requirementStart, PDO::PARAM_STR);
			$prepare_index->bindParam(13, $requirementsEnd, PDO::PARAM_STR);
			$prepare_index->bindParam(14, $agestart, PDO::PARAM_STR);
			$prepare_index->bindParam(15, $ageend, PDO::PARAM_STR);
			$prepare_index->execute();
			
			foreach($prepare_index->fetchAll() AS $row) {
				if (($forceAllPlayers) ||
				    ($row['scoutid'] == $requirement->getScoutID()) ||
				    ($row['scoutid'] == 0) ||
						($row['scoutid'] == '')) {
					$player	=	new Player($row['id'], $row['coach'], $row['name'], strtotime($row['dateOfBirth']), $row['tsi'], $row['salary'], 
						$row['injury'], $row['aggressiveness'], $row['agreeability'], $row['honesty'], $row['leadership'], $row['speciality'],
						$row['form'], $row['stamina'], $row['experience'], 
						$row['keeper'], $row['defender'], $row['playmaker'], $row['winger'], $row['passing'], $row['scorer'], $row['setPieces'], 
						$row['caps'], $row['capsU20'], strtotime($row['added']), strtotime($row['lastupdate']),
						$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'], 
						$row['keeperSubSkill'], $row['defenderSubSkill'], $row['playmakerSubSkill'], $row['wingerSubSkill'], $row['passingSubSkill'], $row['scorerSubSkill'], $row['setPiecesSubSkill'],
						$row['lasttraining'], $row['u20'], $row['trainingtype'], $row['conditieperc'], $row['trainingintensity'], $row['trainerskill'], $row['assistants'], $row['scoutid'], $row['sundayTraining']);
					
					$player->setScout($scout);
					
					if($list != NULL && !in_array($player, $list)) {
						$list[]		=	$player;
					} elseif($list == NULL) {
						$list[]		=	$player;
					}
				}
			}
		}
		
		return $list;	
	}
	
	public static function getScoutPosition($playerId, $u20, $leeftijdjaren, $aIndexName) {
		$columnName = 'index'.$aIndexName;
		
		$datum = strtotime("-119 days", time());
		
		$sql =
			"SELECT COUNT(DOEL.ID) as AANTAL ".
			"FROM player BRON ".
			"LEFT JOIN player DOEL ON (";
			
		if ($u20) {
			$sql = $sql."  (abs(datediff(DOEL.dateOfBirth, BRON.dateOfBirth)) < 50) AND ";
		}
		else {
		  if ($leeftijdjaren < 28) {
				$sql = $sql."  (abs(datediff(DOEL.dateOfBirth, BRON.dateOfBirth)) < 112) AND ";
			}
			else {
				$dagen = ($leeftijdjaren - 28 + 1) * 112 * -1;
				
			  $sql = $sql."  (datediff(BRON.dateOfBirth, DOEL.dateOfBirth) > ".$dagen.") AND";
			}
		}
		
		$sql = $sql.
			"  (DOEL.".$columnName." > BRON.".$columnName.") AND".
			"  (DOEL.u20 = BRON.u20) AND".
			"  ((DOEL.scoutID = BRON.scoutID) or (BRON.scoutID IS NULL) or (DOEL.scoutID IS NULL))) ".
			"WHERE ".
			"  (BRON.ID = ?) AND".
			"  (DOEL.lastupdate >= '".date("Y-m-d", $datum)."')";
			
		$prepare		=	parent::getConn()->prepare($sql);
		
		$prepare->bindParam(1, $playerId, PDO::PARAM_INT);
		$prepare->execute();
		
		$row = $prepare->fetch();
			
		return $row['AANTAL'] + 1;
	
	}
	
	public static function getScoutPositionConcurrenten($playerId, $u20, $leeftijdjaren, $aIndexName) {
		$columnName = 'index'.$aIndexName;
		
		$datum = strtotime("-119 days", time());
		
		$sqlBeter =
			"SELECT DOEL.ID ".
			"FROM player BRON ".
			"LEFT JOIN player DOEL ON (";
			
		if ($u20) {
			$sqlBeter = $sqlBeter."  (abs(datediff(DOEL.dateOfBirth, BRON.dateOfBirth)) < 50) AND ";
		}
		else {
		  if ($leeftijdjaren < 28) {
				$sqlBeter = $sqlBeter."  (abs(datediff(DOEL.dateOfBirth, BRON.dateOfBirth)) < 112) AND ";
			}
			else {
				$dagen = ($leeftijdjaren - 28 + 1) * 112 * -1;
				
			  $sqlBeter = $sqlBeter."  (datediff(BRON.dateOfBirth, DOEL.dateOfBirth) > ".$dagen.") AND";
			}
		}
		
		$sqlBeter = $sqlBeter.
			"  (DOEL.".$columnName." > BRON.".$columnName.") AND".
			"  (DOEL.u20 = BRON.u20) AND".
			"  ((DOEL.scoutID = BRON.scoutID) or (BRON.scoutID IS NULL) or (DOEL.scoutID IS NULL))) ".
			"WHERE ".
			"  (BRON.ID = ?) AND".
			"  (DOEL.lastupdate >= '".date("Y-m-d", $datum)."') ".
			"ORDER BY DOEL.".$columnName." ASC ".
			"LIMIT 5";
			
		$prepare		=	parent::getConn()->prepare($sqlBeter);
		
		$prepare->bindParam(1, $playerId, PDO::PARAM_INT);
		$prepare->execute();
		
		$list = NULL;
		$listUnsorted = NULL;
		
		foreach($prepare->fetchAll() AS $row) {
	    $listUnsorted[] = PlayerDB::getPlayer($row['ID']);
		}
		
		if ($listUnsorted != Null) {
			for ($i = sizeof($listUnsorted) - 1; $i >= 0; $i--) {
				$list[] = $listUnsorted[$i];
			}
		}
		
		$sqlMinder =
			"SELECT DOEL.ID ".
			"FROM player BRON ".
			"LEFT JOIN player DOEL ON (";
			
		if ($u20) {
			$sqlMinder = $sqlMinder."  (abs(datediff(DOEL.dateOfBirth, BRON.dateOfBirth)) < 50) AND ";
		}
		else {
			if ($leeftijdjaren < 28) {
				$sqlMinder = $sqlMinder."  (abs(datediff(DOEL.dateOfBirth, BRON.dateOfBirth)) < 112) AND ";
			}
			else {
				$dagen = ($leeftijdjaren - 28 + 1) * 112 * -1;
				
			  $sqlMinder = $sqlMinder."  (datediff(BRON.dateOfBirth, DOEL.dateOfBirth) > ".$dagen.") AND";
			}
		}
		
		$sqlMinder = $sqlMinder.
			"  (DOEL.".$columnName." <= BRON.".$columnName.") AND".
			"  (DOEL.u20 = BRON.u20) AND".
			"  ((DOEL.scoutID = BRON.scoutID) or (BRON.scoutID IS NULL) or (DOEL.scoutID IS NULL))) ".
			"WHERE ".
			"  (BRON.ID = ?) AND".
			"  (DOEL.lastupdate >= '".date("Y-m-d", $datum)."') ".
			"ORDER BY DOEL.".$columnName." DESC ".
			"LIMIT 6";
			
		$prepare		=	parent::getConn()->prepare($sqlMinder);
		
		$prepare->bindParam(1, $playerId, PDO::PARAM_INT);
		$prepare->execute();
		
		foreach($prepare->fetchAll() AS $row) {
	    $list[] = PlayerDB::getPlayer($row['ID']);
		}
		
		return $list;
	}
}
?>
