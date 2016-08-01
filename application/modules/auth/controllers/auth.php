<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	users
 * @author	Syahril Hermana
 * @description	Manage all users
 */

class auth extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
	
	}
	
	public function index(){
		$this->load->view('index');
	}

}

