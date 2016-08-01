<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	hello
 * @author	Syahril Hermana
 */

class hello extends CI_Controller {

	protected $header;

	public function __construct() {
		parent::__construct();

		$this->header = apache_request_headers();
	
	}
	
	public function index(){
//		$data = array(
//			'sample'	=> Sample_model::all()
//		);
//		$this->load->view('view_hello', $data);

		$this->load->library("JWT");
		$CONSUMER_KEY = 'some-key';
		$CONSUMER_SECRET = 'some-secret';
		$CONSUMER_TTL = 86400;
		$jwt =  $this->jwt->encode(array(
			'consumerKey'=>$CONSUMER_KEY,
			'userId'=>45,
			'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
			'ttl'=>$CONSUMER_TTL
		), $CONSUMER_SECRET);

		echo json_encode($this->jwt->decode($jwt, $CONSUMER_SECRET));
	}

	public function generate_token($user_id){
		$this->load->library("JWT");
		$CONSUMER_KEY = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
		$CONSUMER_SECRET = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
		$CONSUMER_TTL = 86400;
		echo $this->jwt->encode(array(
			'consumerKey'=>$CONSUMER_KEY,
			'userId'=>$user_id,
			'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
			'ttl'=>$CONSUMER_TTL
		), $CONSUMER_SECRET);
	}
}

