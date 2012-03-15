<?php
class Training {
	private $id;
	private	$coachId;
	private	$van;
	private	$tot;
	private $training;
	private	$ti;
	private	$conditie;
	private	$assistenten;
	private	$fysios;

	/*
	* Constructs the player ID
	* @param int $id
	*/
	public function __construct($id, $coachId, $van, $tot, $training, $ti, $conditie, $assistenten, $fysios) {
		$this->id			=	$id;
		$this->coachId		=	$coachId;
		$this->van			=	$van;
		$this->tot			=	$tot;
		$this->training		=	$training;
		$this->ti			=	$ti;
		$this->conditie		=	$conditie;
		$this->assistenten	=	$assistenten;
		$this->fysios		=	$fysios;
	}
	
	
	/**
	* Returns the player id
	* @return int $id
	*/
	public function getId() {
		return $this->id;
	}
	
	public function getCoachId() {
		return $this->coachId;
	}
	
	public function getVan() {
		return $this->van;
	}
	
	public function getTot() {
		return $this->tot;
	}
	
	public function getTraining() {
		return $this->training;
	}
	
	public function getTi() {
		return $this->ti;
	}
	
	public function getConditie() {
		return $this->conditie;
	}
	
	public function getAssistenten() {
		return $this->assistenten;
	}
	
	public function getFysios() {
		return $this->fysios;
	}
}
?>
