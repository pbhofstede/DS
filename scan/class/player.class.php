<?php
class Player {
	private $id;			//Player Id
	private $coach;			//Id of the coach
	private $name;			//Name of the player
	private $dateOfBirth;
	private $tsi;			//TSI of the player
	private $salary;		//Salary of the player
	private $injury;		//Injury of the player (days to-go, -1 if not injured)
	private $aggressiveness;
	private $agreeability;
	private $honesty;
	private $leadership;
	private $speciality;
	private $form;
	private $stamina;
	private $experience;
	private $keeper;
	private $defender;
	private $playmaker;
	private $winger;
	private $passing;
	private $scorer;
	private $setPieces;
	private $caps;
	private $capsU20;
	private $added;
	private $lastupdate;
	private $indexGK;
	private $indexCD;
	private $indexDEF;
	private $indexWB;
	private $indexIM;
	private $indexWG;
	private $indexSC;
	private $indexDFW;
	private $indexSP;
	private $defenderSubSkill;
	private $scorerSubSkill;
	private $wingerSubSkill;
	private $setPiecesSubSkill;
	private $passingSubSkill;
	private $playmakerSubSkill;
	private $keeperSubSkill;
	private $lasttraining;
	private $u20;
	private $trainingtype;
	private $conditieperc;
	private $trainingintensity;
	private $trainerskill;
	private $assistants;
	private $scoutid;
	private $sundayTraining;
	private $scout; //variabele om de scoutlichting runtime in op te slaan om de beste index te kunnen bepalen
	
	/**
	* Constructs the player ID
	* @param int $id
	* @param int $coach
	* @param String $name
	* @param int $ageYear
	* @param int $ageDays
	* @param int $tsi
	* @param int $salary
	* @param int $injury
	*/
	public function __construct($id, $coach, $name, $dateOfBirth, $tsi, $salary, $injury, $aggressiveness, 
		$agreeability, $honesty, $leadership, $speciality, $form, $stamina, $experience, 
		$keeper, $defender, $playmaker, $winger, $passing, $scorer, $setPieces, 
		$caps, $capsU20, $added, $lastupdate,
		$indexGK, $indexCD, $indexDEF, $indexWB, $indexIM, $indexWG, $indexSC, $indexDFW, $indexSP,
		$keeperSubSkill, $defenderSubSkill, $playmakerSubSkill, $wingerSubSkill, $passingSubSkill, $scorerSubSkill, $setPiecesSubSkill,
		$lasttraining, $u20, $trainingtype, $conditieperc, $trainingintensity, $trainerskill, $assistants, $scoutid, $sundayTraining) {
		$this->id		=	$id;
		$this->coach		=	$coach;
		$this->name		=	$name;
		$this->dateOfBirth	=	$dateOfBirth;
		$this->tsi		=	$tsi;
		$this->salary		=	$salary;
		$this->injury		=	$injury;
		$this->aggressiveness	=	$aggressiveness;
		$this->agreeability	=	$agreeability;
		$this->honesty		=	$honesty;
		$this->leadership	=	$leadership;
		$this->speciality	=	$speciality;
		$this->form		=	$form;
		$this->stamina		=	$stamina;
		$this->experience	=	$experience;
		$this->keeper		=	$keeper;
		$this->defender		=	$defender;
		$this->playmaker	=	$playmaker;
		$this->winger		=	$winger;
		$this->passing		=	$passing;
		$this->scorer		=	$scorer;
		$this->setPieces	=	$setPieces;
		$this->caps		=	$caps;
		$this->capsU20		=	$capsU20;
		$this->added		=	$added;
		$this->lastupdate	=	$lastupdate;
		$this->indexGK = $indexGK;
		$this->indexCD = $indexCD;
		$this->indexDEF = $indexDEF;
		$this->indexWB = $indexWB;
		$this->indexIM = $indexIM;
		$this->indexWG = $indexWG;
		$this->indexSC = $indexSC;
		$this->indexDFW = $indexDFW;  
		$this->indexSP = $indexSP;
		$this->keeperSubSkill	=	$keeperSubSkill;
		$this->defenderSubSkill	=	$defenderSubSkill;
		$this->playmakerSubSkill =	$playmakerSubSkill;
		$this->wingerSubSkill	=	$wingerSubSkill;
		$this->passingSubSkill = $passingSubSkill;
		$this->scorerSubSkill	=	$scorerSubSkill;
		$this->setPiecesSubSkill	=	$setPiecesSubSkill;
		$this->lasttraining = $lasttraining;
		$this->u20 = ($u20 == -1);
		$this->trainingtype = $trainingtype;
		$this->conditieperc = $conditieperc;
		$this->trainingintensity = $trainingintensity;
		$this->trainerskill = $trainerskill;
		$this->assistants = $assistants;
		$this->scoutid = $scoutid;
		$this->sundayTraining = $sundayTraining;
	}
	
	public function update($coach, $dateOfBirth, $tsi, $salary, $injury, $form, $stamina, $experience, 
		$keeper, $defender, $playmaker, $winger, $passing, $scorer, $setPieces, $caps, $capsU20, $newUpdateDate) {
		$this->dateOfBirth	=	$dateOfBirth;
		$this->tsi		=	$tsi;
		$this->salary		=	$salary;
		$this->injury		=	$injury;
		$this->caps		=	$caps;
		$this->capsU20		=	$capsU20;
		
		if($coach != $this->coach) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'coach', $this->coach, $coach, time()));
			$this->coach		=	$coach;
		}
		
		if($form != $this->form) {
			//PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'form', $this->form, $form, time()));
			$this->form		=	$form;
		}
		
		if($stamina != $this->stamina) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'stamina', $this->stamina, $stamina, time()));
			$this->stamina		=	$stamina;
		}
		
		if($experience != $this->experience) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'experience', $this->experience, $experience, time()));
			$this->experience	=	$experience;
		}
		
		if($keeper != $this->keeper) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'keeper', $this->keeper, $keeper, time()));
			
			if ($keeper > $this->keeper) {
				$this->keeperSubSkill = 0;
			}
			else
			{
				$this->keeperSubSkill = floor($keeper * 2 / 3);
			}
			$this->keeper	=	$keeper;
		}
		
		if($defender != $this->defender) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'defender', $this->defender, $defender, time()));
			
			if ($defender > $this->defender) {
				$this->defenderSubSkill = 0;
			}
			else
			{
				$this->defenderSubSkill = $defender;
			}
			$this->defender	=	$defender;
		}
		
		if($playmaker != $this->playmaker) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'playmaker', $this->playmaker, $playmaker, time()));
			
			if ($playmaker > $this->playmaker) {
				$this->playmakerSubSkill = 0;
			}
			else
			{
				$this->playmakerSubSkill = $playmaker;
			}
			$this->playmaker =	$playmaker;
		}
		
		if($winger != $this->winger) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'winger', $this->winger, $winger, time()));
			
			if ($winger > $this->winger) {
				$this->wingerSubSkill = 0;
			}
			else
			{
				$this->wingerSubSkill = floor($winger * 2 / 3);
			}
			$this->winger	=	$winger;
		}
		
		if($passing != $this->passing) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'passing', $this->passing, $passing, time()));
			
			if ($passing > $this->passing) {
				$this->passingSubSkill = 0;
			}
			else
			{
				$this->passingSubSkill = floor($passing * 2 / 3);
			}
			$this->passing =	$passing;
		}
		
		if($scorer != $this->scorer) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'scorer', $this->scorer, $scorer, time()));
			
			if ($scorer > $this->scorer) {
				$this->scorerSubSkill = 0;
			}
			else
			{
				$this->scorerSubSkill = $scorer - 2;
			}
			$this->scorer	=	$scorer;
		}
		
		if($setPieces != $this->setPieces) {
			PlayerLogDB::insertLog(new PlayerLog(NULL, $this->id, 'setPieces', $this->setPieces, $setPieces, time()));
			
			if ($setPieces > $this->setPieces) {
				$this->setPiecesSubSkill = 0;
			}
			else
			{
				if ($setPieces >= 18) {
					$this->setPiecesSubSkill = 3;
				}
				else if ($setPieces >= 14) {
					$this->setPiecesSubSkill = 2;
				}
				else {
					$this->setPiecesSubSkill = 1;
				}
			}
			$this->setPieces = $setPieces;
		}
		
		$this->lastupdate	=	$newUpdateDate;
		PlayerDB::updatePlayer($this);
	}
	
	public function addSubSkill($training, $training_weight, $mins) {
		//oh boy.. als je de globale constantes in deze functie wilt gebruiken moet je deze éénmalig met global aanroepen..
		global $HT_TR_SP, $HT_TR_DEF, $HT_TR_SCO, $HT_TR_CRO, $HT_TR_SHO, $HT_TR_PAS, $HT_TR_PM, $HT_TR_GK, $HT_TR_OPM, $HT_TR_CTR, $HT_TR_VLA;
		
		if ($mins > 90) {
		  $mins = 90;
		}
		$this->lasttraining = $mins / 90 * $training_weight * 100;
		
		if ($training == $HT_TR_SP) {
		  $this->setPiecesSubSkill = $this->getSetPiecesSubSkill() + ($mins / 90 * $training_weight);
		}
		else if ($training == $HT_TR_DEF) {
		  $this->defenderSubSkill = $this->getDefenderSubSkill() + ($mins / 90 * $training_weight);
		}
		else if ($training == $HT_TR_SCO) {
		  $this->scorerSubSkill = $this->getScorerSubSkill() + ($mins / 90 * $training_weight);
		}
		else if ($training == $HT_TR_CRO) {
		  $this->wingerSubSkill = $this->getWingerSubSkill() + ($mins / 90 * $training_weight);
		}
		else if ($training == $HT_TR_SHO) {
		  $this->scorerSubSkill = $this->getScorerSubSkill() + ($mins / 90 * $training_weight * 0.5);
		  $this->setPiecesSubSkill = $this->getSetPiecesSubSkill() + ($mins / 90 * $training_weight * 0.1);
		}
		else if ($training == $HT_TR_PAS) {
		  $this->passingSubSkill = $this->getPassingSubSkill() + ($mins / 90 * $training_weight);
		}
		else if ($training == $HT_TR_PM) {
		  $this->playmakerSubSkill = $this->getPlaymakerSubSkill() + ($mins / 90 * $training_weight);
		}
		else if ($training == $HT_TR_GK) {
		  $this->keeperSubSkill = $this->getKeeperSubSkill() + ($mins / 90 * $training_weight);
		}
		else if ($training == $HT_TR_OPM) {
		  $this->passingSubSkill = $this->getPassingSubSkill() + ($mins / 90 * $training_weight * 0.8);
		}
		else if ($training == $HT_TR_CTR) {
		  $this->defenderSubSkill = $this->getDefenderSubSkill() + ($mins / 90 * $training_weight * 0.5);
		}
		else if ($training == $HT_TR_VLA) {
		  $this->wingerSubSkill = $this->getWingerSubSkill() + ($mins / 90 * $training_weight * 0.7);
		}
	}
	
	public function addSundayTraining($training, $training_weight, $mins) {		
		if ($mins > 90) {
		  $mins = 90;
		}
		$this->sundayTraining = $mins / 90 * $training_weight * 100;
	}
	
	/**
	* Returns the player id
	* @return int $id
	*/
	public function getId() {
		return $this->id;
	}
	
	/**
	* Returns the coach object
	* @return Coach $coach
	*/
	public function getCoach() {
		return CoachDB::getCoach($this->coach);
	}
	
	public function getCoachId() {
	  return $this->coach;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDateOfBirth() {
		return $this->dateOfBirth;
	}
	
	public function getTsi() {
		return $this->tsi;
	}
	
	public function getSalary() {
		return $this->salary;
	}
	
	public function getInjury() {
		return $this->injury;
	}
	
	public function getAggressiveness() {
		return $this->aggressiveness;
	}
	
	public function getAgreeability() {
		return $this->agreeability;
	}
	
	public function getHonesty() {
		return $this->honesty;
	}
	
	public function getLeadership() {
		return $this->leadership;
	}
	
	public function getSpeciality() {
		return $this->speciality;
	}
	
	public function getForm() {
		return $this->form;
	}
	
	public function getStamina() {
		return $this->stamina;
	}
	
	public function getExperience() {
		return $this->experience;
	}
	
	public function getKeeper() {
		return $this->keeper;
	}
	
	public function getDefender() {
		return $this->defender;
	}
	
	public function getPlaymaker() {
		return $this->playmaker;
	}
	
	public function getWinger() {
		return $this->winger;
	}
	
	public function getPassing() {
		return $this->passing;
	}
	
	public function getScorer() {
		return $this->scorer;
	}
	
	public function getSetPieces() {
		return $this->setPieces;
	}
	
	public function getCaps() {
		return $this->caps;
	}
	
	public function getCapsU20() {
		return $this->capsU20;
	}
	
	public function getAdded() {
		return $this->added;
	}
	
	public function getLastupdate() {
		return $this->lastupdate;
	}
	
	public function getIndexGK() {
		return Round($this->indexGK, 2);
	}
	public function setIndexGK($index) {
		$this->indexGK = $index;
	}
	
	public function getIndexCD() {
		return Round($this->indexCD, 2);
	}
	public function setIndexCD($index) {
		$this->indexCD = $index;
	}
	
	public function getIndexDEF() {
		return Round($this->indexDEF, 2);
	}
	public function setIndexDEF($index) {
		$this->indexDEF = $index;
	}
	
	public function getIndexWB() {
		return Round($this->indexWB, 2);
	}
	public function setIndexWB($index) {
		$this->indexWB = $index;
	}
	
	public function getIndexIM() {
		return Round($this->indexIM, 2);
	}
	public function setIndexIM($index) {
		$this->indexIM = $index;
	}
	
	public function getIndexWG() {
		return Round($this->indexWG, 2);
	}
	public function setIndexWG($index) {
		$this->indexWG = $index;
	}
	
	public function getIndexSC() {
		return Round($this->indexSC, 2);
	}
	public function setIndexSC($index) {
		$this->indexSC = $index;
	}
	
	public function getIndexDFW() {
		return Round($this->indexDFW, 2);
	}
	public function setIndexDFW($index) {
		$this->indexDFW = $index;
	}
	
	public function getIndexSP() {
		return Round($this->indexSP, 2);
	}
	public function setIndexSP($index) {
		$this->indexSP = $index;
	}
	
	public function getBestIndexScoutName() {
	  $indexWaarde = $this->getBestIndexScout();
		
		return $this->getIndexNameByValue($indexWaarde);
	}
	
	public function getBestIndexScout() {
		if ($this->scout == NULL) {
		  $maxIndex = $this->getBestIndex();
		}
		else {
			$indices = explode(',', $this->scout->getIndices());
			$maxIndex = -400;
			
			foreach($indices AS $indexName) {
				if ($indexName == 'GK') {
					if ($this->getIndexGK() > $maxIndex) {
						$maxIndex = $this->getIndexGK();
					}
				}
				else if ($indexName == 'DEF') {
					if ($this->getIndexDEF() > $maxIndex) {
						$maxIndex = $this->getIndexDEF();
					}
				}
				else if ($indexName == 'CD') {
					if ($this->getIndexCD() > $maxIndex) {
						$maxIndex = $this->getIndexCD();
					}
				}
				else if ($indexName == 'WB') {
					if ($this->getIndexWB() > $maxIndex) {
						$maxIndex = $this->getIndexWB();
					}
				}
				else if ($indexName == 'IM') {
					if ($this->getIndexIM() > $maxIndex) {
						$maxIndex = $this->getIndexIM();
					}
				}
				else if ($indexName == 'WG') {
					if ($this->getIndexWG() > $maxIndex) {
						$maxIndex = $this->getIndexWG();
					}
				}
				else if ($indexName == 'SC') {
					if ($this->getIndexSC() > $maxIndex) {
						$maxIndex = $this->getIndexSC();
					}
				}
				else if ($indexName == 'DFW') {
					if ($this->getIndexDFW() > $maxIndex) {
						$maxIndex = $this->getIndexDFW();
					}
				}
				else if ($indexName == 'SP') {
					if ($this->getIndexSP() > $maxIndex) {
						$maxIndex = $this->getIndexSP();
					}
				}
			}
		}
		return $maxIndex;
	}
	
	public function getBestIndex() {
	  return max($this->getIndexGK(), $this->getIndexCD(), $this->getIndexDEF(), $this->getIndexWB(), $this->getIndexIM(), 
							 $this->getIndexWG(), $this->getIndexSC(), $this->getIndexDFW(), $this->getIndexSP());  
	}
	
	public function getBestIndexName() {
	  $vMax = $this->getBestIndex();  
		
		return $this->getIndexNameByValue($vMax);
	}
	
	private function getIndexNameByValue($indexValue) {
		if ($indexValue == $this->getIndexGK()) {
			return 'GK';
		}
		else if ($indexValue == $this->getIndexDEF()) {
			return 'DEF';
		}
		else if ($indexValue == $this->getIndexCD()) {
			return 'CD';
		}
		else if ($indexValue == $this->getIndexWB()) {
			return 'WB';
		}
		else if ($indexValue == $this->getIndexIM()) {
			return 'IM';
		}
		else if ($indexValue == $this->getIndexWG()) {
			return 'WG';
		}
		else if ($indexValue == $this->getIndexSC()) {
			return 'SC';
		}
		else if ($indexValue == $this->getIndexDFW()) {
			return 'DFW';
		}
		else if ($indexValue == $this->getIndexSP()) {
			return 'SP';
		}
		else {
		  return '';
		}
	}
	
	public function getIndexByName($indexName) {
		if ($indexName == 'GK') {
			return $this->getIndexGK();
		}
		else if ($indexName == 'DEF') {
			return $this->getIndexDEF();
		}
		else if ($indexName == 'CD') {
			return $this->getIndexCD();
		}
		else if ($indexName == 'WB') {
			return $this->getIndexWB();
		}
		else if ($indexName == 'IM') {
			return $this->getIndexIM();
		}
		else if ($indexName == 'WG') {
			return $this->getIndexWG();
		}
		else if ($indexName == 'SC') {
			return $this->getIndexSC();
		}
		else if ($indexName == 'DFW') {
			return $this->getIndexDFW();
		}
		else if ($indexName == 'SP') {
			return $this->getIndexSP();
		}
	}
	
	public function getIsInteresting() {
	  $datum = strtotime("2004-12-01 00:00:00");
	  $afwijking = ((((getDayInt(0) - getDayInt($this->getDateOfBirth())) / 112) - 15) * -2) + (min(max((getDayInt($datum) - getDayInt($this->getDateOfBirth())) / 112, 0), 12) * -8);
		if ($this->getU20()) {
			$afwijking = $afwijking - 3;
		}
		
		Return ($this->getBestIndex() >= $afwijking);
	}
	
	
	public function getDefenderSubSkill() {
		return Round($this->defenderSubSkill, 2);
	}
	public function setDefenderSubSkill($subskill) {
		$this->defenderSubSkill = $subskill;
	}
	
	public function getScorerSubSkill() {
		return Round($this->scorerSubSkill, 2);
	}
	public function setScorerSubSkill($subskill) {
		$this->scorerSubSkill = $subskill;
	}
	
	public function getWingerSubSkill() {
		return Round($this->wingerSubSkill, 2);
	}		
	public function setWingerSubSkill($subskill) {
		$this->wingerSubSkill = $subskill;
	}
	
	public function getSetPiecesSubSkill() {
		return Round($this->setPiecesSubSkill, 2);
	}	
	public function setSetPiecesSubSkill($subskill) {
		$this->setPiecesSubSkill = $subskill;
	}
	
	public function getPassingSubSkill() {
		return Round($this->passingSubSkill, 2);
	}
	public function setPassingSubSkill($subskill) {
		$this->passingSubSkill = $subskill;
	}

	public function getPlaymakerSubSkill() {
		return Round($this->playmakerSubSkill, 2);
	}
	public function setPlaymakerSubSkill($subskill) {
		$this->playmakerSubSkill = $subskill;
	}
	
	public function getKeeperSubSkill() {
		return Round($this->keeperSubSkill, 2);
	}
	public function setKeeperSubSkill($subskill) {
		$this->keeperSubSkill = $subskill;
	}
	
	public function getlasttraining() {
		return Round($this->lasttraining, 2);
	}
	
	public function getU20AfwijkingDagen() {
		$currentSeason = ceil((time() - 1010275200) / 19353600);
		$aantalseizoenen = 0;
		$QWC = FALSE;
		$FWC = FALSE;
		$verjaardag = getDayInt($this->dateOfBirth) + (21 * 112);
		
		//echo 'verjaardag:'.$verjaardag.'<BR>';	
		$resultaat_int = 0;
		
		if ($verjaardag >= getDayInt(0)) {
			$resultaat = FALSE;
			
			while (($resultaat == FALSE) &&
						 ($aantalseizoenen < 4)) {
				$vMinDag = getFinalDaySearch($currentSeason + $aantalseizoenen) - 114; //QWC = 114 dagen voor de finale!
				$vMaxDag = $vMinDag + 114;
			
				//echo 'min:'.$vMinDag.'<BR>';
				//echo 'max:'.$vMaxDag.'<BR>';		 
				
				if (($verjaardag >= $vMinDag) && ($verjaardag <= $vMaxDag)) {
					$resultaat_int = $vMinDag - $verjaardag;

					$resultaat = TRUE;
					$QWC = TRUE;
				}
				
				
				$vMinDag = getFinalDaySearch($currentSeason + $aantalseizoenen);
				//Maximaal 110 erbij, want dan zitten we alweer in de volgende Q-lichting (114 dagen voor finale, dus ook 110 dagen na de finale..)
				$vMaxDag = $vMinDag + 110;
			
				if (($verjaardag >= $vMinDag) && ($verjaardag <= $vMaxDag)) {
					$resultaat_int = $vMinDag - $verjaardag;

					$resultaat = TRUE;
					$FWC = TRUE;
				}
				
				if ($resultaat == FALSE) {
					$aantalseizoenen++;
				}
			}
		}
		else {
		  //echo ' te oud';
			$resultaat = FALSE;
		}
		
		if (($resultaat_int < -80) &&
       	($resultaat_int >= -132))	{
			if ($QWC) {
				$resultaat_int = $resultaat_int + 114;
			}
			else if ($FWC) {
				$resultaat_int = $resultaat_int + 110;
			}
		}
		
		return $resultaat_int;
	}
	
	public function getHasU20Age() {
		$currentSeason = ceil((time() - 1010275200) / 19353600);
		$aantalseizoenen = 0;
		$verjaardag = getDayInt($this->dateOfBirth) + (21 * 112);
		$resultaat_str = '';
		
		if ($verjaardag >= getDayInt(0)) {
			$resultaat = FALSE;
			
			while (($resultaat == FALSE) &&
						 ($aantalseizoenen < 4)) {
				$vMinDag = getFinalDaySearch($currentSeason + $aantalseizoenen) - 114; //QWC = 114 dagen voor de finale!
				$vMaxDag = $vMinDag + 24;
			
				if (($verjaardag >= $vMinDag) && ($verjaardag <= $vMaxDag)) {
					//echo 'Kwalificatie '.$currentSeason;
					$resultaat_str = 'QWC'.($currentSeason + $aantalseizoenen);
					$resultaat = TRUE;
				}
				
				$vMinDag = getFinalDaySearch($currentSeason + $aantalseizoenen);
				$vMaxDag = $vMinDag + 21;
			
				if (($verjaardag >= $vMinDag) && ($verjaardag <= $vMaxDag)) {
					//echo 'Finale '.$currentSeason;
					$resultaat_str = 'FWC'.($currentSeason + $aantalseizoenen);
				
					$resultaat = TRUE;
				}
				
				if ($resultaat == FALSE) {
					$aantalseizoenen++;
				}
			}
		}
		else {
		  //echo ' te oud';
			$resultaat = FALSE;
		}
		return $resultaat_str;
	}
	
	public function getU20() {
	  return $this->u20;
	}
	
	public function setU20($u20) {
		$this->u20 = $u20;
	}
	
	public function getLeeftijdStr() {
		$aantalDagen = getDayInt(0) - getDayInt($this->getDateOfBirth());
		
		return floor($aantalDagen / 112).'.'.$aantalDagen % 112;
	}
	
	public function getLeeftijdJaar() {
		$aantalDagen = getDayInt(0) - getDayInt($this->getDateOfBirth());
		
		return floor($aantalDagen / 112);
	}
	
	public function getLeeftijdWeken() {
		$aantalDagen = getDayInt(0) - (getDayInt($this->getDateOfBirth()) + (17 * 112));
		
		return floor($aantalDagen / 7);
	}
	
	public function getDefenderStr() {
	  if ($this->getDefenderSubSkill() > 0) {
		  return $this->getDefender().' +'.Round($this->getDefenderSubSkill(), 1);
		}
		else {
		  return $this->getDefender();
		}
	}
	
	public function getPlaymakerStr() {
	  if ($this->getPlaymakerSubSkill() > 0) {
		  return $this->getPlaymaker().' +'.Round($this->getPlaymakerSubSkill(), 1);
		}
		else {
		  return $this->getPlaymaker();
		}
	}	
	
	public function getKeeperStr() {
	  if ($this->getKeeperSubSkill() > 0) {
		  return $this->getKeeper().' +'.Round($this->getKeeperSubSkill(), 1);
		}
		else {
		  return $this->getKeeper();
		}
	}	
	
	public function getWingerStr() {
	  if ($this->getWingerSubSkill() > 0) {
		  return $this->getWinger().' +'.Round($this->getWingerSubSkill(), 1);
		}
		else {
		  return $this->getWinger();
		}
	}	
	
	public function getPassingStr() {
	  if ($this->getPassingSubSkill() > 0) {
		  return $this->getPassing().' +'.Round($this->getPassingSubSkill(), 1);
		}
		else {
		  return $this->getPassing();
		}
	}	
	
	public function getScorerStr() {
	  if ($this->getScorerSubSkill() > 0) {
		  return $this->getScorer().' +'.Round($this->getScorerSubSkill(), 1);
		}
		else {
		  return $this->getScorer();
		}
	}	
	
	public function getSetPiecesStr() {
	  if ($this->getSetPiecesSubSkill() > 0) {
		  return $this->getSetPieces().' +'.Round($this->getSetPiecesSubSkill(), 1);
		}
		else {
		  return $this->getSetPieces();
		}
	}
	
	public function getTrainingtype() {
		if ($this->trainingtype == '') {
		  return 0;
		}
		else {
			return $this->trainingtype;
		}
	}
	
	public function getConditieperc() {
		return $this->conditieperc;
	}

	public function getTrainingintensity() {
		return $this->trainingintensity;
	}

	public function getTrainerskill() {
		return $this->trainerskill;
	}

	public function getAssistants() {
		return $this->assistants;
	}	
	
	public function calcIndicesAndUpdateToDB() {
		//index berekenen ahv datum laatste update!
		$aVergLeeftijdDagen = getDayInt($this->getLastupdate()) - getDayInt($this->getDateOfBirth());
		
		if ($this->getU20()) {
			$afwijking = $this->getU20AfwijkingDagen();

			if ($afwijking < 0) {
			  $aVergLeeftijdDagen = $aVergLeeftijdDagen - $afwijking;
				//echo $this->getName()."  ".$afwijking."<BR>";
			}
		}
		
		//Keeper
		if ($this->getU20()) {
		  $index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				7, 5, 0, 0, 0, 0, 5,
				$this->getKeeper(), min($this->getDefender(), 7), 0,  0, 0, 0, min($this->getSetPieces(), 15));

			if ($this->getDefender() > 7) {
			  $index = $index 
								 + (($this->getDefender() - 7) * 2)
								 + min($this->getDefenderSubSkill(), 2);
			}
			else {
				$index = $index + $this->getDefenderSubSkill();
			}
			
			if ($this->getSetPieces() > 15) {
			  $index = $index + (($this->getSetPieces() - 15) * 1);
			}
			else {
				$index = $index + $this->getSetPiecesSubSkill();
			}
			$this->setIndexGK($index + 
				$this->getKeeperSubSkill());
		}
		else {
			$this->setIndexGK(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				3, 8, 0, 0, 5, 0, 6,
				$this->getKeeper(), min($this->getDefender(), 16), 0,  0, min($this->getPassing(), 7), 0, $this->getSetPieces()) 
				+ 
				$this->getKeeperSubSkill() + $this->getDefenderSubSkill() + $this->getPassingSubSkill() + $this->getSetPiecesSubSkill());
		}
		
		//CounterDEF
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 0, 0, 7, 0, 0,
				0, $this->getDefender(), 0,  0, min($this->getPassing(), 10), 0, 0);
			
			if ($this->getPassing() > 10) {
			  $index = $index 
								 + (($this->getPassing() - 10) * 2)
								 + min($this->getPassingSubSkill(), 2);
			}
			else {
				$index = $index + $this->getPassingSubSkill();
			}
			
			$this->setIndexCD($index + 
				($this->getPlaymaker() - 3) +
				$this->getDefenderSubSkill());
		}
		else {
			$this->setIndexCD(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 5, 0, 8, 0, 0,
				0, $this->getDefender(), min($this->getPlaymaker(), 10),  0, min($this->getPassing(), 15), 0, 0)
				+ 
				$this->getDefenderSubSkill() + $this->getPlaymakerSubSkill() + $this->getPassingSubSkill());
		}
		
		//Verdediger
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 6, 0, 0, 0, 0,
				0, $this->getDefender(), min($this->getPlaymaker(), 12),  0, 0, 0, 0);
			
			if ($this->getPlaymaker() > 12) {
			  $index = $index 
								 + (($this->getPlaymaker() - 12) * 4)
								 + min($this->getPlaymakerSubSkill(), 4);
			}
			else {
				$index = $index + $this->getPlaymakerSubSkill();
			}
			
			$this->setIndexDEF($index + 
				($this->getPassing() - 3) +
				$this->getDefenderSubSkill());
		}
		else {		
			$this->setIndexDEF(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 7, 0, 5, 0, 0,
				0, $this->getDefender(), $this->getPlaymaker(), 0, min($this->getPassing(), 10), 0, 0)
				+ 
				$this->getDefenderSubSkill() + $this->getPlaymakerSubSkill() + $this->getPassingSubSkill());
		}
		
		//Wingback
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 0, 7, 0, 0, 0,
				0, $this->getDefender(), 0, min($this->getWinger(), 12), 0, 0, 0);
			
			if ($this->getWinger() > 12) {
			  $index = $index 
								 + (($this->getWinger() - 12) * 2)
								 + min($this->getWingerSubSkill(), 2);
			}
			else {
				$index = $index + $this->getWingerSubSkill();
			}
			
			$this->setIndexWB($index + 
				($this->getPlaymaker() - 4) +
				($this->getPassing() - 3) +
				$this->getDefenderSubSkill());
		}
		else {
			$this->setIndexWB(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 5, 6, 5, 0, 0,
				0, $this->getDefender(), min($this->getPlaymaker(), 8), $this->getWinger(), min($this->getPassing(), 12), 0, 0)
				+ 
				$this->getDefenderSubSkill() + $this->getPlaymakerSubSkill() + $this->getWingerSubSkill() + $this->getPassingSubSkill());
		}
		
		//IM
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 0, 7, 0, 0, 0, 0,
				0, 0, $this->getPlaymaker(), 0, 0, 0, 0);
				
			$this->setIndexIM($index 
												+ ($this->getDefender() - 5)
												+ (($this->getPassing() - 5) * 2)
												+ min($this->getPassingSubSkill(), 2)
												+ $this->getPlaymakerSubSkill());
		}
		else {
			$this->setIndexIM(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 5, 7, 0, 7, 0, 0,
				0, min($this->getDefender(), 16), $this->getPlaymaker(), 0, min($this->getPassing(), 16), 0, 0)
				+ 
				$this->getDefenderSubSkill() + $this->getPlaymakerSubSkill() + $this->getPassingSubSkill());
		}
		
		//Winger
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 0, 6, 7, 4, 0, 0,
				0, 0, min($this->getPlaymaker(), 11), $this->getWinger(), min($this->getPassing(), 6), 0, 0);
			
			if ($this->getPlaymaker() > 11) {
			  $index = $index 
								 + (($this->getPlaymaker() - 11) * 4)
								 + min($this->getPlaymakerSubSkill(), 4);
			}
			else {
			  $index = $index + $this->getPlaymakerSubSkill();
			}
			
			//3 weken per lvl passen boven redelijk
			if ($this->getPassing() > 6) {
			  $index = $index 
								 + (($this->getPassing() - 6) * 3)
								 + min($this->getPassingSubSkill(), 3);
			}
			else {
			  $index = $index + $this->getPassingSubSkill();
			}
			
			$this->setIndexWG($index 
												+ $this->getWingerSubSkill());				
		}
		else {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 0, 7, 7, 6, 0, 0,
				0, 0, $this->getPlaymaker(), $this->getWinger(), $this->getPassing(), 0, 0)
				+ 
				$this->getPlaymakerSubSkill() + $this->getWingerSubSkill() + $this->getPassingSubSkill();
			
			if ($this->getDefender() >= 3) {
			  $index = $index 
								 + (($this->getDefender() - 3) * 2)
								 + min($this->getDefenderSubSkill(), 2);
			}
			else {
			  $index = $index 
								 - (3 - $this->getDefender())
								 + min($this->getDefenderSubSkill(), 1);
			}
			$this->setIndexWG($index);
		}
		
		//SC
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 0, 0, 0, 7, 7, 0,
				0, 0, 0, 0, min($this->getPassing(), 9), $this->getScorer(), 0);
			
			if ($this->getPassing() > 9) {
			  $index = $index 
								 + (($this->getPassing() - 9) * 3)
								 + min($this->getPassingSubSkill(), 3);
			}
			else {
			  $index = $index + $this->getPassingSubSkill();
			}
			
			$this->setIndexSC($index +
				max($this->getWinger() - 3, 0) +
				$this->getScorerSubSkill());
		}
		else {
			$this->setIndexSC(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 0, 0, 6, 7, 7, 0,
				0, 0, 0, $this->getWinger(), $this->getPassing(), $this->getScorer(), 0)
				+ 
				$this->getWingerSubSkill() + $this->getPassingSubSkill() + $this->getScorerSubSkill());
		}
		
		//DFW
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 0, 7, 0, 6, 6, 0,
				0, 0, $this->getPlaymaker(), 0, min($this->getPassing(), 12), min($this->getScorer(), 8), 0);
			
			if ($this->getPassing() > 12) {
			  $index = $index 
								 + (($this->getPassing() - 12) * 2)
								 + min($this->getPassingSubSkill(), 2);
			}
			else {
			  $index = $index + $this->getPassingSubSkill();
			}
			
			if ($this->getScorer() > 8) {
			  $index = $index 
								 + (($this->getScorer() - 8) * 3)
								 + min($this->getScorerSubSkill(), 3);
			}
			else {
			  $index = $index + $this->getScorerSubSkill();
			}
			
			if ($this->getWinger() <= 3) {
			  $index = $index + $this->getWinger();
			}
			else {
			  $index = $index + 3 + (($this->getWinger() - 3) * 1.5);
			}
			$index = $index + min($this->getWingerSubSkill(), 1);
			
			$this->setIndexDFW($index	+ 
				$this->getPlaymakerSubSkill());
		}
		else {
			$this->setIndexDFW(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 0, 6, 5, 7, 7, 0,
				0, 0, $this->getPlaymaker(), min($this->getWinger(), 14), $this->getPassing(), min($this->getScorer(), 16), 0)
				+ 
				$this->getPlaymakerSubSkill() + $this->getWingerSubSkill() + $this->getPassingSubSkill() + $this->getScorerSubSkill());
		}
		
		if ($this->getU20()) {
			$index = CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 0, 0, 0, 0, 7,
				0, $this->getDefender(), 0, 0, 0, 0, $this->getSetPieces());
				
			$this->setIndexSP($index +
				max($this->getWinger() - 5, 0) +
				(max($this->getPlaymaker() - 5, 0) * 2) +
				$this->getDefenderSubSkill() + $this->getSetPiecesSubSkill());
		}
		else {
			$this->setIndexSP(CalculateTrainingWeeks($aVergLeeftijdDagen, 
				0, 7, 7, 0, 5, 0, 7,
				0, $this->getDefender(), $this->getPlaymaker(), 0, min($this->getPassing(), 15), 0, $this->getSetPieces()) 
				+ 
				$this->getDefenderSubSkill() + $this->getPlaymakerSubSkill() + $this->getPassingSubSkill() + $this->getSetPiecesSubSkill());
		}
		
		PlayerDB::updatePlayer($this);
	}
	
	public function getscoutid() {
	  return $this->scoutid;
	}
	
	public function getsundayTraining() {
	  return $this->sundayTraining;
	}
	public function setsundayTraining($value) {
	  return $this->sundayTraining = $value;
	}
	
	public function setScout($scout) {
	  $this->scout = $scout;
	}
}

function getDayInt($aDate)
{	
	$resultaat = 0;
	if ($aDate == 0) {
		$aDate = time();
	}
	
	if (date('I', $aDate) == 1) {
		//wintertijd: + 2 uur
		$resultaat = floor(($aDate + 7200) / 86400); 
	}
	else {
		//zomertijd: +1 uur
		$resultaat = floor(($aDate + 3600) / 86400); 
	}
	
	return $resultaat;
}

function getFinalDaySearch($season) {
	return getDayInt(1029715200 + (($season - 1) * 19353600));
}
?>
