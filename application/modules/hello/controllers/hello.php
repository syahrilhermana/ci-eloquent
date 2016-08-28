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
		$headers = apache_request_headers();

		if(!isset($headers["Authorization"]) || empty($headers["Authorization"]))
		{
			$this->response(NULL, REST_Controller::HTTP_UNAUTHORIZED);
		}

		try {
			$jwt = $this->jwt->decode($headers["Authorization"], $this->config->item('jwt_secret'));

			echo json_encode($jwt);
		} catch(Exception $e) {
			$e->getMessage();

			echo "token error";
		}
	}

	public function generate_token($user_id){
		echo $this->jwt->encode(array(
			'consumerKey'=>$this->config->item('jwt_key'),
			'userId'=>$user_id,
			'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
			'ttl'=>$this->config->item('jwt_ttl')
		), $this->config->item('jwt_secret'));
	}
}

