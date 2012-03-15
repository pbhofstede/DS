<?php
class Information {
	private $id;
	private $naam;
	private $afkorting;
	private $content;
	private $publicatie;
	
	public function __construct($id, $naam, $afkorting, $content, $publicatie) {
		$this->id			=	$id;
		$this->naam			=	$naam;
		$this->afkorting	=	$afkorting;
		$this->content		=	$content;
		$this->publicatie	=	$publicatie;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getNaam() {
		return $this->naam;
	}
	
	public function getAfkorting() {
		return $this->afkorting;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function getPublicatie() {
		return $this->publicatie;
	}
	
	public function update($naam, $afkorting, $content, $publicatie) {
		if($naam)
			$this->naam			=	$naam;
		
		if($afkorting)
			$this->afkorting	=	$afkorting;
		
		if($content)
			$this->content		=	$content;
		
		if($publicatie)
			$this->publicatie	=	$publicatie;

		InformationDB::updateInformation($this);
	}

	
}

?>