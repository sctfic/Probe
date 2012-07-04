<?php
require_once "i18n.phpc";
require_once "toolbox.phpc";
require_once "html.phpc";
require_once "html5.phpc";
require_once "microFormat.phpc";
// require_once "abbr.php";

// $me = $GLOBALS['me']
// function _cv($str) { return dgettext($GLOBALS['me']->getUserName(), $str); }
function _cv($str) { return @$GLOBALS['me']->_cv($str); }
function _ncv($str) { return @$GLOBALS['me']->_ncv($str); }
// $tb = new toolbox();

define("ICONS_PATH", '/_files/icons_themes/icons/silk');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));
define("TIMC_IMAG", '<abbr title="Techniques de l"Ingénierie Médicale et de la Complexité">TIMC</abbr>-<abbr title="Informatique, Mathématiques et Applications de Grenoble">IMAG</abbr>');
// define("AMA_TIMC_IMAG", sprintf(_('<a href="%s">team %s</a> of %s'), "http://www-timc.imag.fr/rubrique52.html?lang=fr", AMA, TIMC_IMAG));
define('ACO', sprintf('<a href="%s"><abbr title="%s">%s</abbr></a>', _("http://en.wikipedia.org/wiki/Ant_colony_optimization"), _('Ant Colony Optimization'), _('ACO')));
  $ACP = new abbr(_('PCA'), _("Principal Component Analysis"));
define('ACP', $ACP->buildOutput());

//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));
define('AJAX', "<abbr title='Asynchronous Javascript And XML'>AJAX</abbr>");
define('aka', "<abbr title='also known as'>a.k.a.</abbr>");
define('ALAO', '<abbr title="Apprentissage des langues assisté par ordinateur">ALAO</abbr>');
define('apps', _('application'));
define('Astar', sprintf('<abbr title="%s">A*</abbr>', _("A star")));
define('ASTAR', sprintf('<a href="%s">%s%s</a>', _("http://en.wikipedia.org/wiki/A*"), Astar, _(" algorithm")));
define('AT', _('at'));
// //define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('BDX', 'Bordeaux, France'); #
define("BDX2", sprintf('<abbr title="%s">%s</abbr>', sprintf(_('Victor Segalen University (%s)'), 'Bordeaux'), 'Bdx&thinsp;II'));
define("uBDX2", sprintf('<a href="%s">%s</a>', "http://www.u-bordeaux2.fr/en/", BDX2));
define("xBDX2", sprintf( _('Victor Segalen University (%s)'), uBDX2));
define("BDX3", sprintf('<abbr title="%s">%s</abbr>', sprintf(_('Michel de Montaigne University (%s)'), 'Bordeaux'), 'Bdx&thinsp;III'));
define("xBDX3", sprintf(_('Michel de Montaigne University (%s)'), BDX3));
define("uBDX3", sprintf('<a href="%s">%s</a>', "http://www.u-bordeaux3.fr/en/", BDX3));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('C', sprintf('<abbr title="%s">C</abbr>', _('Compiled programming language')));
define("CC_BY_NC_SA", sprintf('<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.%s"><abbr title="%s">by-nc-sa</abbr></a>', _("en"), _("by Attribution-NonCommercial-ShareAlike 3.0 Unported")));
define('CPP', sprintf('<abbr title="%s">C++</abbr>', _('Object Oriented improvement of C programming language')));
define("C2I", sprintf('<abbr title="%s">C2i</abbr>', _('Computing &amp; Internet Certificate')));
define('CEFR', sprintf('<abbr title="%s">%s</abbr>', _('Common European Framework of Reference for Languages'), _('CEFR')));
define('CFDICT', sprintf('<abbr title="%s">CFDICT</abbr>', _('Chinese-French Dictionary (under CC licence)')));
define('uCFDICT', sprintf('<a href="http://cfdict.fr/">%s</a>', CFDICT));
define('CJK', '<abbr title="Chinese, Japanese, Korean">CJK</abbr>');
define('CS', sprintf('<a href="%s">%s</a>', _("http://en.wikipedia.org/wiki/Complex_system"), _("Complex system")));
define('CSS', '<abbr title="Cascading StyleSheet">CSS</abbr>');
define('CV', '<abbr title="Curriculum Vitæ">CV</abbr>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('DBMS', sprintf('<abbr title="%s">%s</abbr>', _('DataBase Management System'), _('DBMS')));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('EAO', '<abbr title="Enseignement Assisté par Ordinateur">EAO</abbr>');
define('EIAH', '<abbr title="Environnements Informatiques pour l"Apprentissage Humain">EIAH</abbr>');
$environnement =  _('environnement');
define('ERM', '<abbr title="Entity-relationship model">ERM</abbr>');
define('ERIM', sprintf('<abbr title="%s">ERIM</abbr>', _('stands (in French) for Network-based Environment for Multimodal Interpreting.')));
define('ENSC', sprintf('<abbr title="%s">%s</abbr>', _("École Nationale Supérieure de Cognitique"), _('ENSC')));
define('uENSC', sprintf('<a href="http://www.ensc.fr/">%s</a>', ENSC));
define('xENSC', sprintf('%s (%s)', _('École Nationale Supérieure de Cognitique'), uENSC));
define('etc', '<abbr title="et cetera">etc</abbr>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('fr', '<img class="flag" src="/_files/icons_themes/icons/flags/fr.png" title="Français" alt="Français"/>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('GIF', '<abbr title="Graphics Interchange Format">GIF</abbr>');
define('GDOCS', '<abbr title="Google Docs">gDocs</abbr>');

// define('GRADUATE', sprintf("<img src='/_files/icons_themes/icons/silk/tick.png' title='%s' title='%1$s' /><span class='graduate'>%1$s </span>", _("Graduate of")));
define('GRADUATE', sprintf("<span class='graduate'>%s </span>", _("Graduate of")));
define('GRENOBLE', 'Grenoble, France');
define('mGRENOBLE', '<a href="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Grenoble,+France&amp;sll=45.172765,5.728576&amp;sspn=0.008169,0.015407&amp;ie=UTF8&amp;hq=&amp;hnear=Grenoble,+Is%C3%A8re,+Rh%C3%B4ne-Alpes,+France&amp;t=h&amp;z=12">Grenoble, France</a>');
define('GUI', sprintf('<abbr title="%s">GUI</abbr>', _('Graphic User Interface')));
define('GWT', '<abbr title="/gweet/, Google Web Toolkit">GWT</abbr>');
define("GENIE_LOG", 'Software Engineering');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define("漢字", sprintf('<abbr lang="zh" title="Hanzi">漢字</abbr>'));
define('HTML', '<abbr title="HyperText Markup Language">HTML</abbr>');
define('HCI',  sprintf('<abbr title="%s">%s</abbr>', _('Human-Computer Interface'), _("HCI")));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('IA',  sprintf('<abbr title="%s">%s</abbr>', _('Artificial Intelligence'), _('AI')));
define('xIA', _('Artificial Intelligence'));
define('IT', sprintf('<abbr title="%s">%s</abbr>', _('Information Technology'), _("IT")));
//define('XXXX', sprintf('%s', _()));

define('JSTARGLOBAL', sprintf('<a href="http://www.jstarservice.com/">Jstar Global <abbr title="%s">Inc.</abbr></a>', _('Incorporation')));
//define('XXXX', sprintf('%s', _()));

define("_ie", '<abbr title="For instance">i.e.</abbr>');
define("i18n", '<abbr title="Internationalization">i18n</abbr>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('JAVA', 'Java');
define("JAVA_EE", 'Java <abbr title="Enterprise Edition">EE</abbr>');
define('JS', 'JavaScript');//'<abbr title="JavaScript">JS</abbr>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define("l10n", '<abbr title="'._("Localization").'">l10n</abbr>');
define('LSA', sprintf('<abbr title="%s">LSA</abbr>', _('Latent Semantic Analysis: relationships between documents and terms')));
//define('XXXX', sprintf('%s', _()));

//define('XXXX', sprintf('%s', _()));
define('MATHML', '<abbr title="Mathematics Markup Language">MathML</abbr>');
define('MANDRIVA', sprintf('Mandriva<ins><sup><abbr title="%s Mageia">?</abbr></sup></ins>', _('now called')));
define("M1_ICPS", _('Master degree'));
define("M2_ICPS", _('Master degree'));
//define('XXXX', sprintf('%s', _()));


define('NCHU', sprintf('<a href="%s"><abbr lang="zh-py" title="國立中興大學 / %s">NCHU</abbr></a>', "http://www.nchu.edu.tw/en-index.php", _('National Chung-Hisng University')));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('OS', '<abbr title="Operating System">OS</abbr>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('aPDF', " PDF (Adobe Acrobat)");
define('PDF', "<abbr title='Portable Document Format (Adobe Acrobat)'>PDF</abbr>");
define('PROJECT', _('project'));
$phd = new abbr(_('Ph.D.'), _('Doctor of Philosophy'));
define('PhD', $phd->buildOutput());
define('PHP', "<abbr title='PHP: Hypertext Preprocessor'>PHP</abbr>");
define('Perl', "Perl");
define('PNG', '<abbr title="Portable Network Graphic">PNG</abbr>');
define('PPT', sprintf('<abbr title="%s">PPT</abbr>', _('Power Point presentation')));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('QCM', '<abbr title="Questions à  Choix Multiples">QCM</abbr>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('RSS', '<abbr title="Really Simple Syndication">RSS</abbr>');
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('SEX_MALE', sprintf("<img class='np' src='%s/male.png' title='%s' alt='".'%2$s'."' />", ICONS_PATH, _('sex: male')));
define('SEX_FEMALE', sprintf("<img class='np' src='%s/female.png' title='%s' alt='".'%2$s'."' />", ICONS_PATH, _('sex: female')));
define('SCILAB', sprintf('<abbr title="%s">Scilab</abbr>', _('numerical computing environment similar to MATLAB')));
  $SEO = new abbr(_('SEO'), _("Search Engine Optimization"));
define('SEO', $SEO->buildOutput());
define('SFTP', '<abbr title="SSH File Transfer Protocol">SFTP</abbr>');
define('SMIL', "<abbr title='Synchronized Multimedia Integration Language'>SMIL</abbr>");
define('SQL', '<abbr title="Structured Query Language">SQL</abbr>');
define('STENDHAL', _('University Grenoble&thinsp;3'));
define('SVG', "<abbr title='Scalable Vector Graphics'>SVG</abbr>");
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('TAIZHONG', '<abbr lang="zh-py" title="台灣台中市">Taizhōng Taiwan</abbr>');
define('TAIWAN', sprintf('<abbr lang="zh-py" title="台灣">%s</abbr>', _('Taiwan')));
define('TAL', '<abbr title="Traitement Automatique des Langues">TAL</abbr>');
define('TER', '<abbr title="Study Research">TER</abbr>');
define('TIC', '<abbr title="Technologies de l"Information et de la Communication">TIC</abbr>');
define('TICE', '<abbr title="Technologies de l"Information et de la Communication pour l"éducation">TICE</abbr>');
  $TOEIC = new abbr('TOEIC', _("Test of English for International Communication"));
define('TOEIC', $TOEIC->buildOutput());
  $TOEIC_2010 = new abbr('TOEIC', '[2010] '._("Test of English for International Communication"));
define('TOEIC_2010', $TOEIC_2010->buildOutput());
define('TLFI', '<abbr title="Trésor de la Langue Française informatisée">TLFi</abbr>');
define('TSP', sprintf('<a href="%s">%s</a>', _("http://en.wikipedia.org/wiki/Travelling_salesman_problem"), _("Travelling salesman problem")));
define('TYR', _('South of Landes High school'));
define('TXT', sprintf('<abbr title="%s">TXT</abbr>', _("text")));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('UI', sprintf('<abbr title="%s">UI</abbr>', _('User Interface')));
define('UJF', sprintf('<abbr title="%s">UJF</abbr>', _("University Joseph Fourrier")));
define('uUJF', sprintf('<a href="%s"><abbr title="%s">UJF</abbr></a>', _("http://www.ujf-grenoble.fr/"), _("University Joseph Fourrier")));
define('UPMF', sprintf('<abbr title="%s">UPMF</abbr>', _("University Pierre Mendès-France")));
define('uUPMF', sprintf('<a href="%s"><abbr title="%s">UPMF</abbr></a>', "http://www.upmf-grenoble.fr/", _("University Pierre Mendès-France")));
define('xUPMF', sprintf(_("University Pierre Mendès-France (%s)"), uUPMF));
define('UML', '<abbr title="Unified Modeling Language">UML</abbr>');
define('UNICODE', '<a href="http://www.unicode.org/">Unicode</a>');
define('URL', '<abbr title="Universal Ressource Locator">URL</abbr>');
define('UX', sprintf('<abbr title="%s">UX</abbr>', _('User eXperience')));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('vs', sprintf('<abbr title="%s">vs.</abbr>', _('versus, against')));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

define('WCAG', '<abbr title="Web Content Accessibility Guidelines">WCAG</abbr>');
define('wCpp', sprintf(_(' (written in %s)'), "C++"));
define('wJava', sprintf(_(' (written in %s)'), "Java"));
define('wPerl', sprintf(_(' (written in %s)'), Perl));
define('wPHP', sprintf(_('written in %s'), PHP));
define('wPython', sprintf(_(' (written in %s)'), "Python"));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));

//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));
//define('XXXX', sprintf('%s', _()));
define('XHTML', '<abbr title="eXtensible HyperText Markup Language">XHTML</abbr>');
define('XML', '<abbr title="eXtensible Markup Language">XML</abbr>');
define("X_HTML", "<abbr title='(Extensible) HyperText Markup Language'>(X)HTML</abbr>");
define('XSL', "<abbr title='Extensible Stylesheet Language'>XSL</abbr>");
define('XSLT', "<abbr title='Extensible Stylesheet Language Transformations'>XSLT</abbr>");
define("XSL_T", "<abbr title='Extensible Stylesheet Language (Transformations)'>XSL(T)</abbr>");
define('XUL', "<abbr title='XML User Interface Language'>XUL</abbr>");
//define('XXXX', sprintf('%s', _()));
define('ZHENGZHOU', sprintf("<abbr title='%s'><a href='%s'>%s</a></abbr>", '郑州市 第四十七 中学', 'http://zz47z.zzedu.net.cn/', _('Zhengzhou n°&thinsp;47 Middle School')));

// META-CONSTANT
define('AMA', sprintf(_('<a href="%s">team <abbr title="%s">%s</abbr></a> of %s'), "http://www-timc.imag.fr/rubrique52.html?lang=fr", _('Apprentissage: Modèles et Algorithmes'), _('AMA'), uUJF));
define("BAC_S", sprintf(_('High School diploma with Advanced Science')));
define("BAC_S_TYR", sprintf('<strong>%s%s</strong> <span class="place">%s</span>',
          BAC_S,
          sprintf('<a class="what" href="%s">[?]</a>', _('http://en.wikipedia.org/wiki/Baccalaur%C3%A9at#S.C3.A9rie_scientifique_.28S.29')),
          TYR)
        );
          
define('ICPS', sprintf('<a href="%s"><abbr title="%s">%s</abbr></a>',
          'http://imss.upmf-grenoble.fr/63164000/0/fiche___formation/&RH=U2IMSS_FORM',
          sprintf("%s (%s %s)", _cv('Web, Computing and Knowledge'), _cv('previously'), _cv(' Engineering in Person-System Communication')),
          _cv('WCK')
        ));
// 'Web, Informatique et Connaissance anciennement Ingénierie de la Communication Personne-Système',
define("MASTER_ICPS", _('Master of Engineering in <em>Web, Computing and Knowledge</em>'));
define("MASTER_ICPS_UPMF", sprintf('<strong>%s</strong> <span class="place">%s %s %s</span>',
          MASTER_ICPS, ICPS, AT, xUPMF));
          
  $SCICO = new abbr(_('SciCo'), _('Sciences Cognitives'), _('http://www.sm.u-bordeaux2.fr/ufr/licenceMASS.html'));
define('SCICO', $SCICO->buildOutput());

  $MASS = new abbr(_('MASS'), _('Mathématiques Appliquées aux Sciences Sociales'));
define('MASS', $MASS->buildOutput());
define("LICENCE_SCICO", _('Bachelor of Science in <em>Cognitive Sciences</em>')." &amp; ".MASS);
define("LICENCE_SCICO_BDX2", sprintf('<strong>%s</strong> <span class="place">%s %s %s</span>',
            LICENCE_SCICO, SCICO, AT, BDX2
        ));


/*
À la <strong>recherche d'un emploi</strong> dans le domaine du développement web. Je suis intéressé par&nbsp;: le <strong><span lang='en'>Front-End</span> développement</strong>, l'<strong>ergonomie</strong> et l'<strong>accessibilité web</strong>.
Également familier des projets <strong>pluridisciplinaires</strong> et des environnements <strong>anglophones</strong>, je suis ouvert aux cultures Asiatiques et souhaite consolider tous mes acquis.
*/
define("JOB_HUNTING", sprintf(
_cv("I'm <strong>looking for a job</strong> in the field of web development. I'm interested by <strong>Front-End development</strong>, <strong>usability</strong> and <strong>web accessibility</strong>").".<br/>".
_cv("Not afraid of <strong>interdisciplinary</strong> and <strong>English speaking</strong> environment, I'm open to Asians' culture and wish to improve. ")));
// define('NOW', JOB_HUNTING);
define('NOW', _cv('cv.now.job-hunting'));

// <form action="http://www.google.com/cse" id="cse-search-box">
//   <fieldset id="search-engine">
//     <input type="hidden" name="cx" value="015142198597702415657:hs4ykw6_tva" />
//     <input type="hidden" name="ie" value="UTF-8" />
//     <label id="search-tip" for="search-input">%s</label>
//     <input id="search-input" type="text" name="q" size="25" maxlength="125" value="" />
//     <input type="submit" name="sa" value="%s" />
//   </fieldset>
// </form>

// define("SEARCH_ENGINE", sprintf('
//   <div id="cse">
//     <label id="search-tip" for="search-input">%s</label>
//     Loading
//   </div>',
//   sprintf(_('search in %s'), $_SERVER['HTTP_HOST'])
//   )
// );
define("SEARCH_ENGINE", sprintf(
<<<GCSE
<div id="cse" >Loading&hellip;
  <label id="search-tip" for="search-input">%s</label>
</div>

GCSE
, sprintf(_('search in %s'), $_SERVER['HTTP_HOST'])
  )
);



define('QA_OPEN',  sprintf('<ul class="quick-access">'));
define('QA_END',    sprintf('</ul>'));
define('QA_HOME', sprintf('
  <li>
    <a href="/">%s</a></li>'
  , _('home')
));
define('QA_CORE', sprintf('
  <li>
    <a href="/cv">%s</a></li>
  <li>
    <a href="/portfolio">portfolio</a></li>
  <li>
    <del><a href="/fac">fac</a></del></li>
  <li>
    <a href="/labo">labo</a></li>
  <li>
    <ins><a href="/wiki">wiki</a></ins></li>
</ul>'
, CV)
);

define('QA_SUBMENU',  sprintf('%s%s%s%s<span class="drawer-vertical-bottom" />', QA_OPEN,  ''            ,  QA_CORE, QA_END));
define('PRINTER_FRIENDLY', sprintf('
  <a href="#print-me"><img src="./_files/icons_themes/icons/silk/printer.png" alt="%2$s" title="%3$s" /></a>
  <p class="more">%s%s</p>', 
  _('This page is '),
  _('printer friendly'),
  _("Open 'Print' dialog box")
) );
define('PRINTER_FRIENDLY_FOOTER', sprintf('
  <p class="printer-me printer-friendly pointer" title="%3$s">
    <a href="#print-me"><img src="/_files/icons_themes/icons/printer-friendly-bottom.png" alt="%2$s" title="%3$s" /></a>
    %s %s.
  </p>',
  _('This page is '),
  _('printer friendly'),
  _("Open 'Print' dialog box")
));
define('QA_FOOTER',     
  sprintf('%s%s%s%s%s', 
    QA_OPEN,  
    QA_HOME,  
    QA_CORE, 
    PRINTER_FRIENDLY_FOOTER,
    QA_END
));

@define("BREAD_CRUMB_OPEN",      sprintf('<header><nav id="breadcrumb">
  <h1 class="h">%s</h1>
    <h2 class="h">%s</h2>
    <ol class="hd" title="%s">
      <li class="has-sub">⌘ <a href="/">%s</a>
      %s'
    , $fullName, _("Bread crumb"), _("Bread crumb"), $fullName, ($user=='ed' ? QA_SUBMENU : false))
);

define("BREAD_CRUMB_END",           sprintf('</li></ol>%s</nav></header>', SEARCH_ENGINE));
define("BREAD_CRUMB",                  sprintf(BREAD_CRUMB_OPEN . BREAD_CRUMB_END, ''));
define("BREAD_CRUMB_CV",             sprintf('%s</li><li class="step">%s%s', BREAD_CRUMB_OPEN, _('CV'), BREAD_CRUMB_END));
define("BREAD_CRUMB_PORTFOLIO", sprintf('%s</li><li class="step">%s', BREAD_CRUMB_OPEN, _('Portfolio'), BREAD_CRUMB_END));
define("BREAD_CRUMB_PROJECT",     BREAD_CRUMB_OPEN.'</li><li class="step"><a href="/portfolio">%s</a></li><li class="step">%s'.BREAD_CRUMB_END);

define('GOOGLE_ANALYTICS', <<<GA
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-15879983-4']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
GA
);
define("GOOGLE_CUSTOM_SEARCH", <<<CSE
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
  google.load('search', '1', {language : 'en'});
  google.setOnLoadCallback(function() {
    var customSearchControl = new google.search.CustomSearchControl('004795620528235449016:qjbqtwj25d4');
    customSearchControl.setResultSetSize(google.search.Search.SMALL_RESULTSET);
    var options = new google.search.DrawOptions();
    options.setAutoComplete(true);
    customSearchControl.draw('cse', options);
  }, true);
</script>
CSE
);
@define("_footer", sprintf('<footer id="srv-footer">%s</footer>%s', QA_FOOTER, GOOGLE_CUSTOM_SEARCH, GOOGLE_ANALYTICS));
@define("footer_NOT_printer_friendly", sprintf('<footer id="srv-footer">%s</footer>%s', QA_FOOTER, GOOGLE_CUSTOM_SEARCH, GOOGLE_ANALYTICS));
function getFooter($printerFriendly = false)
{ 
  if ($printerFriendly)
    { return _footer; }
  else
    { return footer_NOT_printer_friendly; }
}

?>
