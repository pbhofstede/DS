<?php

class TeamDetail{
    private $update;
    private $ts;
    private $tc;
    private $xp253;
    private $xp343;
    private $xp352;
    private $xp433;
    private $xp442;
    private $xp451;
    private $xp523;
    private $xp532;
    private $xp541;
    private $xp550;
 	
	public function __construct($update, $ts, $tc, $xp253, $xp343, $xp352, $xp433, $xp442, $xp451, $xp523, $xp532, $xp541, $xp550) 
	{
		$this->update			=	$update;
		$this->ts				=	$ts;
		$this->tc				=	$tc;
		$this->xp253			=	$xp253;
		$this->xp343			=	$xp343;
		$this->xp352			=	$xp352;
		$this->xp433			=	$xp433;
		$this->xp442			=	$xp442;
		$this->xp451			=	$xp451;
		$this->xp523			=	$xp523;
		$this->xp532			=	$xp532;
		$this->xp541			=	$xp541;
		$this->xp550			=	$xp550;
	}
	
	public function getXP550() {
		return $this->xp550;
	}
	
	public function getXP541() {
		return $this->xp541;
	}
	
	public function getXP532() {
		return $this->xp532;
	}
	
	public function getXP523() {
		return $this->xp523;
	}
	
	public function getXP451() {
		return $this->xp451;
	}
	
	public function getXP442() {
		return $this->xp442;
	}
	
	public function getXP433() {
		return $this->xp433;
	}
	
	public function getXP352() {
		return $this->xp352;
	}
	
	public function getXP343() {
		return $this->xp343;
	}
	
	public function getXP253() {
		return $this->xp253;
	}
	
	public function getTC() {
		return $this->tc;
	}
	
	public function getTS() {
		return $this->ts;
	}
	
	public function getUpdate() {
		return $this->update;
	}
}

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
	private $teamid;

	public function __construct($id, $player, $teamid, $country, $age, $tsi, $wage, $stamina, $keeper, $playmaker, $scorer, $passing, $winger, $defender, $setPieces, $caps, $capsU20, $form, $timestamp, $nt, $spec, $xp, $ls, $injury) {
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
		$this->teamid			=   $teamid;
	}
	
	public function getTeamID() {
		return $this->teamid;
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