<?php
class PlayerComment {
	private $playerId;
	private $scouts;
	private $coach;
	
	public function __construct($playerId, $scouts, $coach) {
		$this->playerId		=	$playerId;
		$this->scouts		=	$scouts;
		$this->coach		=	$coach;
	}
	
	public function getPlayerId() {
		return $this->playerId;
	}
	
	public function getScouts() {
		return $this->scouts;
	}
	
	public function getCoach() {
		return $this->coach;
	}
}
?>