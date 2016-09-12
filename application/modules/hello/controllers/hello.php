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

	public function menu(){
		$model = new AksesMenuEntity();
		$menu = $model->generate_menu(1, null);

		echo "<pre>";
		foreach($menu as $item) {
			echo "MENU ID : <code>".$item['id']."</code><br />";
			echo "MENU NAME : <code>".$item['name']."</code><br />";
			echo "MENU ICON : <code>".$item['icon']."</code><br />";
			echo "MENU LINK : <code>".$item['link']."</code><br />";
			echo "MENU ORDER : <code>".$item['order']."</code><br />";
			echo "MENU PARENT : <code>".$item['parent']."</code><br />";

			if (!isset($item['parent'])) {
				foreach($item['children'] as $children) {
					echo "&nbsp;&nbsp;&nbsp;&nbsp;MENU ID : <code>".$children['id']."</code><br />";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;MENU NAME : <code>".$children['name']."</code><br />";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;MENU ICON : <code>".$children['icon']."</code><br />";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;MENU LINK : <code>".$children['link']."</code><br />";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;MENU ORDER : <code>".$children['order']."</code><br />";
				}
			}
		}
		echo "</pre>";

		exit;
	}

	public function icon(){
		$this->load->library('icons');

		print_r($this->icons->glyphicons());
	}
}

