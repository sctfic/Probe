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
     * @ORM\Column(name=USR_LOGIN)
     */
	private $login;

    /**
     * @ORM\Column(name=USR_NAME)
     */
    private $name;

    /**
     * @ORM\Column(name=USR_PWD)
     */
    private $pwd;

    /**
     * @ORM\Column(name=USR_MAIL)
     */
    private $mail;

    /**
     * @ORM\Column(name=ROL_ID)
     */
    private $roleId;

	private $authentified;

	public function __construct() { }


	public function serialize() {
		return serialize(array(
                'techId' => $this->techId,
                'login' => $this->login,
                'name' => $this->name,
                'mail' => $this->mail,
                'roleId' => $this->roleId,
                'authentified' => $this->authentified
            ));
	}
	public function unserialize($data) {
		$d = unserialize($data);
		$this->setTechId($d['techId']);
		$this->setPrename($d['login']);
		$this->setNom($d['name']);
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

// 		$mail = new Mail();
// 		$mail->setTechId($objetResultat->ADR_ID);
// 		$mail->setVille($objetResultat->ADR_VILLE);
// 		$u->setMail($mail);

		return $u;
	}







	public function setMail($mail) {
	    $this->mail = $mail;
	}

	public function getMail() {
	    return $this->mail;
	}

	public function setTechId($techId) {
	    $this->techId = $techId;
	}
	public function getTechId() {
	    return $this->techId;
	}

	public function setLogin($name) {
	    $this->login = $login;
	}

	public function getLogin() {
	    return $this->login;
	}

	public function setName($login) {
	    $this->name = $name;
	}
	public function getName() {
	    return $this->name;
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
		return array('server', 'username', 'password', 'db');
	}
}

?>