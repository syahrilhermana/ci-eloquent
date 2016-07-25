<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/*
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Ardhitya Wiedha Irawan.
 * Website : wwww.blog.gulangguling.com
 * Email : ardhityawiedhairawan@gmail.com
 * Description : Codeigniter 3.x + HMVC
 * ***************************************************************
 */

class hello extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
	
	}
	
	public function index(){
		$this->load->view('view_hello');
	}

}

