<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/Probe/cli.php 'cmd'
class cmd extends CI_Controller {

/**
	* @param
	* @var
	* @return
	*/
	function __construct() {
		// if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
		// 	log_message('warning',  'CLI script access allowed only');
		// 	die();
		// }

		parent::__construct();
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
        $this->load->library('page_manager');

		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/station.php');

		$this->station = new Station();
	}


/**
index() recupere toutes les donnees recuperable sur la station
	* @param
	* @var
	* @return
	*/
	// clear;php5 -f /var/www/Probe/cli.php 'cmd'
	function index($station = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->index($item);
			}
			return false;
		}
		elseif ($station===null && !empty($this->station->stationsList)) {
			// on rapelle cette meme fonction mais avec de vrai parametre : Toutes les stations
			$this->index (array_keys ($this->station->stationsList));
			return false;
		}

		try {
			// on recupere les confs de $station
			$conf = end($this->station->config($station)); // $station est le ID ou le nom
			// on lance la recup des Archives de cette station
			$this->station->AllCollector ($conf);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}


/**

	* @param
	* @var
	* @return
	*/
	function currentsCollectors($station = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		try {
			$item_ID = is_numeric($station) ? array_search($station, $this->station->stationsList) : $station;
			// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
			// on recupere les confs de $station
			$itemConf = end($this->station->config($item_ID)); // $station est le ID ou le nom
			$currents = $this->station->CurrentsCollector ($itemConf);
			return $currents;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}


/**

    * Create a new station
    * clear;php5 -f ~/Probe/cli.php 'cmd/makeNewStation'
    * @return bool
    */
    function makeNewStation()
    {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$formFields = $this->config->item('add-station.form.structure');
		foreach ($formFields as $section => $fields) {
			foreach ($fields as $field => $value) {
				if ($field != 'port') {
					$this->form_validation->set_rules(
						sprintf('%s-%s', $section, $field),
                        i18n(sprintf("configuration-%s.%s.label", $section, $field)),
                        'trim|required'
                    );
				}
			}
		}
		$this->form_validation->set_rules('dbms-password', i18n('configuration-dbms.password.label'), 'minlength[8]');

		if ($this->form_validation->run() == FALSE) {
            $page = new Page_manager();
            $data = $page->addMetadata('configuration-add-station'); // fetch information to build the HTML header
            $data['form'] = $this->config->item('add-station.form.structure');

			$this->load->view('configuration/add-station');
		} else {
            try {
                where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array('debug'));
                include_once(APPPATH.'models/db_builder.php');
                $newID = current ($this->station->availableID()); // prend le 1er ID vide parmis ceux disponible

                /**
                 * TODO: this should be dynamic, based on information provided during installation
                */
                $dbb = new db_builder(
                    $this->input->post('dbms-engine'),
                    $this->input->post('dbms-password'),
                    $this->input->post('dbms-username'),
                    $this->input->post('dbms-host'),
                    $this->input->post('dbms-port'),
                    APP_DB.'_station'.$newID
                );

                $dbb->createAppDb($newID);
                $dsn = $dbb->getDsn();

                $this->station->arrays2dbconfs(
                    $newID,
                    array_merge(
                        array(
                            '_ip' => $this->input->post('network-_ip'),
                            '_port' => $this->input->post('network-_port'),
                            '_name' => $this->input->post('network-_name'),
                            '_type' => $this->input->post('network-_type')
                            ),
                        $dsn
                        )
                    );
                return true; // after, you can read : $this->station->config($newID);
            }
            catch (Exception $e) {
                log_message('warning',  $e->getMessage());
            }

            $this->listStations();
        }

        return false;
	}
}
