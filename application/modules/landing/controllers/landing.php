<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->twiggy->title($this->config->item('application'));

		$this->twiggy->meta('keywords', 'codeigniter-plus');
		$this->twiggy->meta('description', 'CodeIgniter Plus');
		$this->twiggy->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1');

		$this->twiggy->layout('landing');
	}
	
	public function index(){
		// setup csrf token
		$this->twiggy->set('_csrf', $this->security->get_csrf_token_name());
		$this->twiggy->set('_token', $this->security->get_csrf_hash());
		$this->twiggy->template('dashboard/index')->display();
	}

}

