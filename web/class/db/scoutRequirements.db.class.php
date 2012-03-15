<?php


class ScoutRequirementsDB extends DB {
	public static function insertScoutRequirements($scoutRequirements) {
		$prepare	=	parent::getConn()->prepare(
			"INSERT INTO scoutRequirements 
			(scout, ageStart, ageEnd, ageCurrentStart, ageCurrentStartDays, ageCurrentEnd, ageCurrentEndDays, 
			 indexGK, indexCD, indexDEF, indexWB, indexIM, indexWG, indexSC, indexDFW, indexSP, u20) 
			 VALUES 
			 (?, FROM_UNIXTIME(?), FROM_UNIXTIME(?), ?, ?, ?, ?, 
			 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		
		$scoutid = $scoutRequirements->getScoutID();
		$agestart = $scoutRequirements->getAgeStart();
		$ageend = $scoutRequirements->getAgeEnd();
		$age_curstart = $scoutRequirements->getAgeCurrentStart(); 
		$age_curstartdays = $scoutRequirements->getAgeCurrentStartDays();
		$age_curend = $scoutRequirements->getAgeCurrentEnd();
		$age_curenddays = $scoutRequirements->getAgeCurrentEndDays();
		
		$indexGK = $scoutRequirements->getIndexGK();
		$indexCD = $scoutRequirements->getIndexCD();
		$indexDEF = $scoutRequirements->getIndexDEF();
		$indexWB = $scoutRequirements->getIndexWB();
		$indexIM = $scoutRequirements->getIndexIM();
		$indexWG = $scoutRequirements->getIndexWG();
		$indexSC = $scoutRequirements->getIndexSC();
		$indexDFW = $scoutRequirements->getIndexDFW();
		$indexSP = $scoutRequirements->getIndexSP();
		
		if ($scoutRequirements->getU20()) {
		  $u20Int = -1;
		}
		else {
		  $u20Int = 0;
		}
		
		$prepare->bindParam(1, $scoutid, PDO::PARAM_INT);
		$prepare->bindParam(2, $agestart, PDO::PARAM_STR);
		$prepare->bindParam(3, $ageend, PDO::PARAM_STR);
		$prepare->bindParam(4, $age_curstart, PDO::PARAM_STR);
		$prepare->bindParam(5, $age_curstartdays, PDO::PARAM_STR);
		$prepare->bindParam(6, $age_curend, PDO::PARAM_STR);
		$prepare->bindParam(7, $age_curenddays, PDO::PARAM_STR);
		
		if ($indexGK != NULL)
		{
			$prepare->bindParam(8, $indexGK, PDO::PARAM_INT);
		}
		else
		{
			$prepare->bindValue(8, NULL, PDO::PARAM_NULL);	
		}
		if ($indexCD != NULL)
		{
			$prepare->bindParam(9, $indexCD, PDO::PARAM_INT);	
		}
		else
		{
			$prepare->bindValue(9, NULL, PDO::PARAM_NULL);
		}
		if ($indexDEF != NULL)
		{
			$prepare->bindParam(10, $indexDEF, PDO::PARAM_INT);
		}
		else
		{
			$prepare->bindValue(10, NULL, PDO::PARAM_NULL);	
		}
		if ($indexWB != NULL)
		{
			$prepare->bindParam(11, $indexWB, PDO::PARAM_INT);
		}
		else
		{
			$prepare->bindValue(11, NULL, PDO::PARAM_NULL);	
		}
		if ($indexIM != NULL)
		{
			$prepare->bindParam(12, $indexIM, PDO::PARAM_INT);	
		}
		else
		{
			$prepare->bindValue(12, NULL, PDO::PARAM_NULL);	
		}
		if ($indexWG != NULL)
		{
			$prepare->bindParam(13, $indexWG, PDO::PARAM_INT);	
		}
		else
		{
			$prepare->bindValue(13, NULL, PDO::PARAM_NULL);	
		}
		if ($indexSC != NULL)
		{
			$prepare->bindParam(14, $indexSC, PDO::PARAM_INT);	
		}
		else
		{
			$prepare->bindValue(14, NULL, PDO::PARAM_NULL);	
		}
		if ($indexDFW != NULL)
		{
			$prepare->bindParam(15, $indexDFW, PDO::PARAM_INT);	
		}	
		else
		{
			$prepare->bindValue(15, NULL, PDO::PARAM_NULL);	
		}
		if ($indexSP != NULL)
		{
			$prepare->bindParam(16, $indexSP, PDO::PARAM_INT);	
		}
		else
		{
			$prepare->bindValue(16, NULL, PDO::PARAM_NULL);	
		}
		$prepare->bindValue(17, $u20Int, PDO::PARAM_INT);	

		$prepare->execute();
		
		if ($doNext)
		{
		 	//echo 'trainingtype'.$trainingtype.'<br>';
			if ($trainingtype == 0)
		 	{
		 		$scoutRequirements->setKeeper($mainskill+1);		
			}
			else if ($trainingtype == 1)
			{
			 	//echo 'defender!<br>';
				$scoutRequirements->setDefender($mainskill+1);	
			}
			else if ($trainingtype == 2)
			{
				$scoutRequirements->setPlaymaker($mainskill+1);	
			}	
			else if ($trainingtype == 3)
			{
				$scoutRequirements->setWinger($mainskill+1);	
			}	
			else if ($trainingtype == 4)
			{
				$scoutRequirements->setPassing($mainskill+1);	
			}
			else if ($trainingtype == 5)
			{
				$scoutRequirements->setScorer($mainskill+1);	
			}
			$scoutRequirements->setAgeCurrentStart($age_curend);
			$scoutRequirements->setAgeCurrentStartDays($age_curenddays);	
			$mainskill = $scoutRequirements->getMainSkill($trainingtype);
			//echo $mainskill.' - '.$trainingtype.'<br>';
			//echo $scoutRequirements->getDefender();
			ScoutRequirementsDB::insertScoutRequirements($scoutRequirements);	
		}
	}
	
	public static function deleteScoutRequirements($scoutRequirementsId) {
		$prepare	=	parent::getConn()->prepare("DELETE FROM scoutRequirements WHERE id = ?");
		$prepare->bindParam(1, $scoutRequirementsId, PDO::PARAM_INT);
		$prepare->execute();
	}
	
	public static function getScoutRequirementsByScout($scoutId) {
		$prepare	=	parent::getConn()->prepare("SELECT id, scout, ageStart, ageEnd, ageCurrentStart, ageCurrentStartDays, ageCurrentEnd, ageCurrentEndDays, indexGK, indexCD, indexDEF,
		indexWB, indexIM, indexWG, indexSC, indexDFW, indexSP, u20 FROM scoutRequirements WHERE scout = ? order by ageCurrentStart, ageCurrentStartDays");
		$prepare->bindParam(1, $scoutId, PDO::PARAM_INT);
		$prepare->execute();
		
		$list = NULL;
		
		foreach($prepare->fetchAll() AS $row) {
			$list[]		=	new ScoutRequirements($row['id'], $row['scout'], strtotime($row['ageStart']), strtotime($row['ageEnd']), $row['ageCurrentStart'], $row['ageCurrentStartDays'], $row['ageCurrentEnd'], $row['ageCurrentEndDays'], 
				$row['indexGK'], $row['indexCD'], $row['indexDEF'], $row['indexWB'], $row['indexIM'], $row['indexWG'], $row['indexSC'], $row['indexDFW'], $row['indexSP'],
				$row['u20']);
		}
		
		return $list;
	}
	
	public static function getNTScoutingFiles() {
		$prepare = parent::getConn()->prepare(
			"SELECT scout.id, scout.name FROM scoutRequirements left join scout on (scout.id = scoutRequirements.scout) where (scoutRequirements.u20 = 0) group by scout.id, scout.name order by scout.name");
		$prepare->execute();
		
		$list = NULL;
		foreach($prepare->fetchAll() AS $row) {
			$list[]	=	new Scout($row['id'], $row['name']);
		}

		return $list;
	}
}
?>
