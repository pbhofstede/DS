<?php
class Scout {
	private $id;
	private $name;
	
	public function __construct($id, $name) {
		$this->id		=	$id;
		$this->name		=	$name;
	}
	
	public function getPlayerList($forceAllPlayers) {
		$requirements		=	ScoutRequirementsDB::getScoutRequirementsByScout($this->id);
		
		if($requirements != NULL) {
			return PlayerDB::getPlayerByRequirements($requirements, $forceAllPlayers);
		}
	}
		
	public function getScouts() {
		return ScoutDB::getScoutMembers($this->id);
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
}
?>
