<?php

class Adresse {
	/**
	 * Identifiant technique
     * @ORM\Column(name=ADR_ID, type=Integer)
     */
	private $techid;
	
	/**
     * @ORM\Column(name=ADR_VILLE)
     */
	private $ville;
	
	public function setTechid($techid) {
	    $this->techid = $techid;
	}
	
	public function getTechid() {
	    return $this->techid;
	}
	
	public function setVille($ville) {
	    $this->ville = $ville;
	}
	
	public function getVille() {
	    return $this->ville;
	}
	
}

?>