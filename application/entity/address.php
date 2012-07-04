<?php

class Address {
	/**
	 * Identifiant technique
     * @ORM\Column(name=ADR_ID, type=Integer)
     */
	private $techId;

	/**
     * @ORM\Column(name=ADR_CITY)
     */
	private $city;

	public function setTechId($techId) {
	    $this->techId = $techId;
	}

	public function getTechId() {
	    return $this->techId;
	}

	public function setCity($city) {
	    $this->city = $city;
	}

	public function getCity() {
	    return $this->city;
	}

}
