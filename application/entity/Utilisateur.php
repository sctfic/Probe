<?php
require_once APPPATH."/entity/Adresse.php";

/**
 * Pour être stocké en session, l'utilisateur sera sérialisé car PHP ne permet pas de stocker directement des objets en session
 * @author jerep6
 * @ORM\Entity(table=TA_UTILISATEUR)
 */
class Utilisateur implements Serializable {
	/**
	 * Identifiant technique
     * @ORM\Column(name=UTI_ID, type=Integer)
     */
	private $techid;
	
	/**
     * @ORM\Column(name=UTI_PRENOM)
     */
	private $prenom;
	
	/**
	 * @ORM\Column(name=UTI_NOM)
	 */
	private $nom;
	
	private $authentifie;
	
	private $adresse;
	
	public function __construct() { }

	
	public function serialize() {
		return serialize(array(
                'techid' => $this->techid,
                'prenom' => $this->prenom,				
				'nom' => $this->nom,
                'authentifie' => $this->authentifie
            ));
	}
	public function unserialize($data) {
		$d = unserialize($data);
		$this->setTechid($d['techid']);
		$this->setPrenom($d['prenom']);
		$this->setNom($d['nom']);
		$this->setAuthentifie($d['authentifie']);
	}
	
	public function getClassVars() {
		return get_class_vars(get_class($this));
	}
	
	/**
	 * Crée une instance d'utilisateur à partir d'un résultat de requete SQL. Les noms des champs ne doivent
	 * pas avoir été modifié via des "AS"
	 * @param objet $objetResultat ligne correspondant à un résultat
	 * @return objet utilisateur
	 */
	public static function fromBD($objetResultat) {
		$u = MyORM::asObject("Utilisateur", $objetResultat);
		
// 		$adresse = new Adresse();
// 		$adresse->setTechid($objetResultat->ADR_ID);
// 		$adresse->setVille($objetResultat->ADR_VILLE);
// 		$u->setAdresse($adresse);

		return $u;
	}
	
	
	
	
	
	
	
	public function setAdresse($adresse) {
	    $this->adresse = $adresse;
	}
	
	public function getAdresse() {
	    return $this->adresse;
	}
	
	public function setTechid($techid) {
	    $this->techid = $techid;
	}
	public function getTechid() {
	    return $this->techid;
	}
	
	public function setPrenom($prenom) {
	    $this->prenom = $prenom;
	}
	public function getPrenom() {
	    return $this->prenom;
	}
	
	public function setNom($nom) {
	    $this->nom = $nom;
	}
	public function getNom() {
	    return $this->nom;
	}
	public function isAuthentifie() {
	    return $this->authentifie;
	}
	public function setAuthentifie($authentifie) {
		$this->authentifie = $authentifie;
	}
	
	public function __toString() {
		return "$this->techid -- $this->prenom $this->nom";
	}
	
	public function __sleep() {
		return array('server', 'username', 'password', 'db');
	}
}

?>