<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	hello
 * @author	Syahril Hermana
 */

class hello extends CI_Controller {

	public function __construct() {
		parent::__construct();
	
	}
	
	public function index(){
		$data = array(
			'sample'	=> Sample_model::all()
		);
		$this->load->view('view_hello', $data);
	}

}

