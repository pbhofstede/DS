<?php
class PlayerLog {
	private $id;
	private $player;
	private $type;
	private $old;
	private $new;
	private $date;
	
	public function __construct($id, $player, $type, $old, $new, $date) {
		$this->id		=	$id;
		$this->player		=	$player;
		$this->type		=	$type;
		$this->old		=	$old;
		$this->new		=	$new;
		$this->date		=	$date;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getPlayer() {
		return PlayerDB::getPlayer($this->player);
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getOld() {
		return $this->old;
	}
	
	public function getNew() {
		return $this->new;
	}
	
	public function getDate() {
		return $this->date;
	}
}
?>
