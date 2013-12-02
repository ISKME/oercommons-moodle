<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/repository/lib.php');

class repository_oercommons extends repository {

    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array()) {
        parent::__construct($repositoryid, $context, $options);
    }

    public function get_listing($path = null, $page = null) {
    	$callbackurl = new moodle_url('/repository/oercommons/callback.php');

	    $url = $this->get_option('oercommons_url')
	    	. '?return_url='.urlencode($callbackurl);

        $list = array();
        $list['object'] = array();
        $list['object']['type'] = 'text/html';
        $list['object']['src'] = $url;
        $list['nologin']  = true;
        $list['nosearch'] = true;
        $list['norefresh'] = true;
        return $list;
    }

    public function supported_returntypes() {
        return FILE_EXTERNAL | FILE_INTERNAL;
    }

	function supported_filetypes() {
	    return array('web_file', 'document');
	}

	public static function get_instance_option_names() {
	   return array_merge(parent::get_type_option_names(), array('oercommons_url'));
	}

	public static function instance_config_form($mform, $classname = 'repository') {
    	parent::type_config_form($mform, $classname);
        $mform->addElement('text', 'oercommons_url', get_string('oercommonsurl', 'repository_oercommons'));
        $mform->setType('oercommons_url', PARAM_URL);

        $strrequired = get_string('required');
        $mform->addRule('oercommons_url', $strrequired, 'required', null, 'client');
    }

}