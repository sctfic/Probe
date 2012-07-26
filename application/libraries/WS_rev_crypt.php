<?php
/**
 * Classe de cryptage réversible de données
 * 
 * Cette classe permet de coder ou décoder une chaïne
 * de caractères

	include('cryptage_decryptage.php');
	$toto = new RevCrypt('clef');
	$resultat = $toto->code('alpha');

 * @author CrazyCat <crazycat@c-p-f.org>
 * @copyright 2007 http://www.g33k-zone.org
 * @package Mephisto
 **/

class Rev_crypt {
	
	/**
	 * Clé utilisée pour générer le cryptage
	 * @var string
	 */
	public $key;
	
	/**
	 * Données à crypter
	 * @var string
	 */
	public $data;
	
	/**
	 * Constructeur de l'objet
	 * @param string $key Clé utilisée pour générer l'encodage
	 */
	public function __construct($key) {
		$this->key = sha1($key);
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
}
?>