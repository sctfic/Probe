<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class i18n {
    private $DEFAULT_LOCALE = 'en';
    private $CURRENT_LOCALE;
    private $LOCALE_PATH = null;
    private $ISO639 = array(
      'cn' => 'zh_CN',
      'en' => 'en_US',
      'fr' => 'fr_FR',
      'tw' => 'zh_TW'
    );
    private $EXCEPTION = array(
      'br' => 'pt_BR',
      'gb' => 'en_GB',
    );
    private $LOCALE_AVAILABLE = array('en', 'fr');


private function gettext_domain($lang) {// return language code.
    $this->ISO639 =  $this->EXCEPTION + $this->ISO639;

    if (isset($this->ISO639 [$lang])==TRUE)
    {
      $result = $this->ISO639 [$lang];
    } else
    {
      $result = $lang;
    }

    return $result;
  }

public function getRequestedLang() {
    if (isset($_REQUEST['lang']) and !empty($_REQUEST['lang']))
    {
      $lang = strtolower($_REQUEST['lang']);
    } else
    {
      $lang = $this->getDefaultLocale();
    }

    return $lang;
  }

public function setDefaultLocale($value) {
    $this->DEFAULT_LOCALE = $value; }
public function getDefaultLocale() {
    return $this->DEFAULT_LOCALE; }

public function setCurrentLocale($value) {
    if (array_key_exists($value, $this->ISO639)) {
        $this->CURRENT_LOCALE = $value;
    } else {
        $this->CURRENT_LOCALE = $this->DEFAULT_LOCALE;
    }

    }
public function getCurrentLocale() {
    return $this->CURRENT_LOCALE; }


public function setLocaleEnv($localeIso639, $textdomain = null) {
    $this->setCurrentLocale($localeIso639);
    $localepath = $this->getLocalePath();
//     $codeiso = $this->getRequestedLang();
    $codeiso = $this->getCurrentLocale();
    $locale = $this->ISO639[$codeiso].'.UTF-8';
//     $locale = $this->ISO639[$codeiso];

    putenv('LC_ALL='.$locale);
    setlocale(LC_ALL, $locale);
// phpinfo();

    bindtextdomain($textdomain, $localepath);
    bind_textdomain_codeset($textdomain, 'UTF-8');
    textdomain($textdomain).'/'.$textdomain;


}


private function get_i18n_key($trans, $dico = 'i18n') {// return the key of a translation
    //echo 'get_i18n:'; dump(array_search($trans, $GLOBALS[$dico]));
  // 	dump($trans);
    return array_search(strtolower($trans), $GLOBALS[$dico]);
  }


public function setLocalePath($value) {
    $this->LOCALE_PATH = $value;
}
public function getLocalePath() {
    return $this->LOCALE_PATH; }

public function isCurrentLocale($lang) {//
    $result = '';
    if ($lang == $this->getRequestedLang()) {
      $result = "class='active'";
    }

    return $result;
}


public function addLocaleAvailable($value) {
  $this->LOCALE_AVAILABLE[] = $value; }
public function setLocaleAvailable($value) {
  $this->LOCALE_AVAILABLE = $value; }
public function getLocaleAvailable() {
  return $this->LOCALE_AVAILABLE; }


public function __construct()
  {
    $this->ISO639  =  $this->EXCEPTION + $this->ISO639;
    $this->setLocalePath(APPPATH.'language/locales/');
  }


}/* class end */

