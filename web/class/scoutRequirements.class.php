<?php
class ScoutRequirements {
	private $id;
	private $scout;
	
	private $ageStart;
	private $ageEnd;
	private $ageCurrentStart;
	private $ageCurrentStartDays;
	private $ageCurrentEnd;
	private $ageCurrentEndDays;
	
	private $indexGK;
	private $indexCD;
	private $indexDEF;
	private $indexWB;
	private $indexIM;
	private $indexWG;
	private $indexSC;
	private $indexDFW;
	private $indexSP;
	
	private $u20;

	public function __construct($id, $scout, $ageStart, $ageEnd, $ageCurrentStart, $ageCurrentStartDays, $ageCurrentEnd, $ageCurrentEndDays, 
		$indexGK, $indexCD, $indexDEF, $indexWB, $indexIM, $indexWG, $indexSC, $indexDFW, $indexSP, $u20) {
		$this->id			=	$id;
		$this->scout		=	$scout;
		
		$this->ageStart				=	$ageStart;
		$this->ageEnd				=	$ageEnd;
		$this->ageCurrentStart		=	$ageCurrentStart;
		$this->ageCurrentStartDays	=	$ageCurrentStartDays;
		$this->ageCurrentEnd		=	$ageCurrentEnd;
		$this->ageCurrentEndDays	=	$ageCurrentEndDays;
		
		$this->indexGK		= $indexGK;
		$this->indexCD		= $indexCD;
		$this->indexDEF		= $indexDEF;
		$this->indexWB		= $indexWB;
		$this->indexIM		= $indexIM;
		$this->indexWG		= $indexWG;
		$this->indexSC		= $indexSC;
		$this->indexDFW		= $indexDFW;
		$this->indexSP		= $indexSP;
		$this->u20				= $u20;
	}                                                   
	
	public function getId() {
		return $this->id;
	}
	
	public function getIndexGK() {
		return $this->indexGK;
	}
	
	public function setIndexGK($index)
	{
		$this->indexGK = $index;
	}
	
	public function getIndexSP() {
		return $this->indexSP;
	}
	
	public function setIndexSP($index)
	{
		$this->indexSP = $index;
	}
	
	public function getIndexDFW() {
		return $this->indexDFW;
	}
	
	public function setIndexDFW($index)
	{
		$this->indexDFW = $index;
	}
	
	public function getIndexSC() {
		return $this->indexSC;
	}
	
	public function setIndexSC($index)
	{
		$this->indexSC = $index;
	}
	
	public function getIndexWG() {
		return $this->indexWG;
	}
	
	public function setIndexWG($index)
	{
		$this->indexWG = $index;
	}
	
	public function getIndexCD() {
		return $this->indexCD;
	}
	
	public function getIndexIM() {
		return $this->indexIM;
	}
	
	public function setIndexIM($index)
	{
		$this->indexIM = $index;
	}
	
	public function getIndexWB() {
		return $this->indexWB;
	}
	
	public function setIndexWB($index)
	{
		$this->indexWB = $index;
	}
	
	public function setIndexCD($index)
	{
		$this->indexCD = $index;
	}
	
	public function getIndexDEF() {
		return $this->indexDEF;
	}
	
	public function setIndexDEF($index)
	{
		$this->indexDEF = $index;
	}
	
	public function getScout() {
		return ScoutDB::getScout($this->scout);
	}
	
	public function getScoutID() {
		return $this->scout;
	}
	
	public function getAgeStart() {
		return $this->ageStart;
	}
	
	public function getAgeEnd() {
		return $this->ageEnd;
	}
	
	public function getAgeCurrentStart() {
		return $this->ageCurrentStart;
	}
	
	public function setAgeCurrentStart($start) {
		$this->ageCurrentStart = $start;
	}
	
	public function getAgeCurrentStartDays() {
		return $this->ageCurrentStartDays;
	}
	
	public function setAgeCurrentStartDays($startdays) {
		$this->ageCurrentStartDays = $startdays;
	}
	
	public function getAgeCurrentStartRequirement() {
		return (time() - (($this->ageCurrentStart * 112 + $this->ageCurrentStartDays )  * 86400));
	}
	
	public function getAgeCurrentEnd() {
		return $this->ageCurrentEnd;
	}

	public function getAgeCurrentEndDays() {
		return $this->ageCurrentEndDays;
	}
	
	public function getAgeCurrentEndRequirement() {
		return (time() - (($this->ageCurrentEnd * 112 + $this->ageCurrentEndDays ) * 86400) - 86400);
	}
	
	public function getU20() {
		return $this->u20;
	}
	
	public function setU20($u20) {
		if ($u20) {
			echo "u20: JA";
		}
		else {
			echo "u20: Nee";
		}
		$this->u20 = $u20;
	}
}
?>
