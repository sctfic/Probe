<?php
// require_once APPPATH."/entity/Address.php";

/**
 * Pour être stocké en session, l'user sera sérialisé car PHP ne permet pas de stocker directement des objets en session
 * @author jerep6
 * @ORM\Entity(table=TA_USER)
 */
class User implements Serializable {
	/**
	 * Identifiant technique
     * @ORM\Column(name=USR_ID, type=Integer)
     */
	private $techId;

    /**
     * @ORM\Column(name=USR_USERNAME)
     */
    private $userName;

    /**
     * @ORM\Column(name=USR_FIRST_NAME)
     */
    private $firstName;
    
    /**
     * @ORM\Column(name=USR_FAMILY_NAME)
     */
    private $familyName;
    
    /**
     * @ORM\Column(name=USR_PWD)
     */
    private $pwd;

    /**
     * @ORM\Column(name=USR_EMAIL)
     */
    private $email;

    /**
     * @ORM\Column(name=ROL_ID)
     */
    private $roleId;

	private $authentified;

	public function __construct() { }


	public function serialize() {
		return serialize(array(
			'techId' => $this->techId,
			'userName' => $this->userName,
			'firstName' => $this->firstName,
			'familyName' => $this->familyName,
			'email' => $this->email,
			'pwd' => $this->pwd,
			'roleId' => $this->roleId,
			'authentified' => $this->authentified
		));
	}

	/*
	 * data come from @see ./dao/dao_user.php
	 */
	public function unserialize($data) {
		$d = unserialize($data);
		$this->setTechId($d['techId']);
		$this->setUsername($d['userName']);
		$this->setFirstName($d['firstName']);
		$this->setFamilyName($d['familyName']);
		$this->setEmail($d['email']);
// 		$this->setPwd($d['pwd']);
// 		$this->setRoleId($d['roleId']);
		$this->setAuthentified($d['authentified']);
	}

	public function getClassVars() {
		return get_class_vars(get_class($this));
	}

	/**
	 * Crée une instance d'user à partir d'un résultat de requete SQL. Les names des champs ne doivent
	 * pas avoir été modifié via des "AS"
	 * @param objet $objetResultat ligne correspondant à un résultat
	 * @return objet user
	 */
	public static function fromBD($objetResultat) {
		$u = MyORM::asObject("User", $objetResultat);

// 		$email = new email();
// 		$email->setTechId($objetResultat->ADR_ID);
// 		$email->setVille($objetResultat->ADR_VILLE);
// 		$u->setemail($email);

		return $u;
	}







	public function setTechId($techId) {
	    $this->techId = $techId;
	}
	public function getTechId() {
	    return $this->techId;
	}

	public function setUsername($userName) {
		$this->userName = $userName;
	}
	public function getUsername() {
		return $this->userName;
	}
	
	public function setFamilyName($familyName) {
		$this->familyName = $familyName;
	}
	public function getFamilyName() {
		return $this->familyName;
	}
	
	public function setFirstName($firstName) {
	    $this->firstName = $firstName;
	}
	public function getFirstName() {
	    return $this->firstName;
	}

	public function setPwd($pwd	) {
	    $this->pwd = $pwd;
	}
	public function getPwd() {
	    return $this->pwd;
	}
	
	public function setRoleId($roleId	) {
	    $this->roleId = $roleId;
	}
	public function getRoleId() {
	    return $this->roleId;
	}

	public function setEmail($email) {
		$this->email = $email;
	}
	public function getEmail() {
		return $this->email;
	}
	
	
	public function isAuthentified() {
	    return $this->authentified;
	}

	public function setAuthentified($authentified) {
		$this->authentified = $authentified;
	}

	public function __toString() {
		return "{$this->techId} -- {$this->login} {$this->name}";
	}

	public function __sleep() {
		return array('server', 'userName', 'password', 'db');
	}
}

?>