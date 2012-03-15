<?php
class NationalPlayers {
	
	private $id;
	private $player;
	private $country;
	private $age;
	private $tsi;
	private $stamina;
	private $keeper;
	private $playmaker;
	private $scorer;
	private $passing;
	private $winger;
	private $defender;
	private $setPieces;
	private $caps;
	private $capsU20;
	private $form;
	private $timestamp;
	private $nt;
	private $spec;
	private $xp;
	private $ls;
	private $wage;
	private $injury;

			public function __construct($id, $player, $country, $age, $tsi, $wage, $stamina, $keeper, $playmaker, $scorer, $passing, $winger, $defender, $setPieces, $caps, $capsU20, $form, $timestamp, $nt, $spec, $xp, $ls, $injury) {
		$this->id				=	$id;
		$this->player			=	$player;
		$this->country			=	$country;
		$this->age				=	$age;
		$this->tsi				=	$tsi;
		$this->stamina			=	$stamina;
		$this->keeper			=	$keeper;
		$this->playmaker		=	$playmaker;
		$this->scorer			=	$scorer;
		$this->passing			=	$passing;
		$this->winger			=	$winger;
		$this->defender			=	$defender;
		$this->setPieces		=	$setPieces;
		$this->caps				=	$caps;
		$this->capsU20			=	$capsU20;
		$this->form				=	$form;
		$this->timestamp		=	$timestamp;
		$this->nt				=	$nt;
		$this->spec				=	$spec;
		$this->xp				=	$xp;
		$this->ls				=	$ls;
		$this->wage				=   $wage;
		$this->injury			=	$injury;
	}

	public function getId() {
		return $this->id;
	}
	public function getPlayer() {
		return $this->player;
	}
	public function getCountry() {
		return $this->country;
	}
	public function getAge() {
		return $this->age;
	}
	public function getTsi() {
		return $this->tsi;
	}
	public function getStamina() {
		return $this->stamina;
	}
	public function getKeeper() {
		return $this->keeper;
	}
	public function getPlaymaker() {
		return $this->playmaker;
	}
	public function getScorer() {
		return $this->scorer;
	}
	public function getPassing() {
		return $this->passing;
	}
	public function getWinger() {
		return $this->winger;
	}
	public function getDefender() {
		return $this->defender;
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
	public function getForm() {
		return $this->form;
	}
	public function getTimestamp() {
		return $this->timestamp;
	}
	public function getNt() {
		return $this->nt;
	}
	
	public function getSpec() {
		return $this->spec;
	}
	
	public function getXp() {
		return $this->xp;
	}
	
	public function getLs() {
		return $this->ls;
	}
	
	public function getWage() {
		return $this->wage;
	}
	public function getInjury() {
		return $this->injury;
	}

}
?>