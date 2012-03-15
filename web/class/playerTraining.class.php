<?php
class PlayerTraining {
	private $playerId;
	private	$training;
	private	$gemist;
	private $opmerking;

	/*
	* Constructs the player ID
	* @param int $id
	*/
	public function __construct($playerId, $training, $gemist, $opmerking) {
		$this->playerId		=	$playerId;
		$this->training		=	$training;
		$this->gemist		=	$gemist;
		$this->opmerking	=	$opmerking;
	}
	
	/**
	* Returns the player id
	* @return int $id
	*/
	public function getPlayerId() {
		return $this->playerId;
	}
	
	public function getTraining() {
		return $this->training;
	}
	
	public function getGemist () {
		return $this->gemist;
	}
	
	public function getOpmerking() {
		return $this->opmerking;
	}
}
?>
