<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class auth extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->securityGuard->is_access();
	}
	
	public function index(){
		$this->load->view('index');
	}

}

