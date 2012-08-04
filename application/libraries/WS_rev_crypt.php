<?php
/**
 * Classe de cryptage réversible de données
 * 
 * Cette classe permet de coder ou décoder une chaïne
 * de caractères

	include(APPPATH.'libraries/WS_rev_crypt.php');
	$crypt = new WS_rev_crypt('database_root');
//	$crypt->write('P@$$w0rd');
	$config['ws:db.root.password'] = $crypt->read();
	unset($crypt);

	WARNING WARNING WARNING 
	add *.credential in ~/.gitignore
	$ cat ~/.gitignore
		.*.*~
		*~
		*.kate-swp
		*.old
		*.bak
		*.credential
	WARNING WARNING WARNING 

 * @author CrazyCat <crazycat@c-p-f.org>
 * @copyright 2007 http://www.g33k-zone.org
 * @package Mephisto
 * @improve by alopez 2012 add : read(), write()
 **/

class WS_rev_crypt {
	
	/**
	 * Clé utilisée pour générer le cryptage
	 * @var string
	 */
	public $key;
	public $file;
	
	/**
	 * Données à crypter
	 * @var string
	 */
	public $data;
	
	/**
	 * Constructeur de l'objet
	 * @param string $key Clé utilisée pour générer l'encodage
	 */
	public function __construct($file) {
		$this->file = APPPATH.'passwords/'.$file.'.credential';
		$this->key = sha1($file);
	}
	
	/**
	 * Encodeur de chaîne
	 * @param string $string Chaîne à coder
	 * @return string Chaîne codée
	 */
	public function code($string) {
		$this->data = '';
		for ($i = 0; $i<strlen($string); $i++) {
			$kc = substr($this->key, ($i%strlen($this->key)) - 1, 1);
			$this->data .= chr(ord($string{$i})+ord($kc));
		}
		$this->data = base64_encode($this->data);
		return $this->data;
	}
	
	/**
	 * Décodeur de Chaîne
	 * @param string $string Chaîne à décoder
	 * @return string
	 */
	public function decode($string) {
		$this->data = '';
		$string = base64_decode($string);
		for ($i = 0; $i<strlen($string); $i++) {
			$kc = substr($this->key, ($i%strlen($this->key)) - 1, 1);
			$this->data .= chr(ord($string{$i})-ord($kc));
		}
		return $this->data;
	}
	/**
	 * lit decode et retourne la Chaîne contenue dans le fichier credential
	 * @param string $string Chaîne à décoder
	 * @return string
	 */
	public function read() {
		if (is_file($this->file)){
			log_message('crypt','read password in : '.$this->file);
			return $this->decode (file_get_contents ($this->file));
		}
		log_message('warning','file : '.$this->file.' do not exit');
		return false;
	}
	/**
	 * code et ecrit la chaine dans le fichier credential
	 * @param string $string Chaîne à décoder
	 * @return string
	 */
	public function write($string) {
		log_message('crypt','write password in : '.$this->file);
		return file_put_contents ($this->file, $this->code($string));
	}
}