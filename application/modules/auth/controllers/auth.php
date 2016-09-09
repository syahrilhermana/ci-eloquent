<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	users
 * @author	Syahril Hermana
 * @description	Manage all users
 */

class auth extends CI_Controller {

	protected $direct;

	public function __construct() {
		parent::__construct();

		// init twiggy
		$this->twiggy->title($this->config->item('application'));

		$this->twiggy->meta('keywords', 'codeigniter-plus');
		$this->twiggy->meta('description', 'CodeIgniter Plus');
		$this->twiggy->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1');

		$this->twiggy->layout('authentic');

		// setup csrf token
		$this->twiggy->set('_csrf', $this->security->get_csrf_token_name());
		$this->twiggy->set('_token', $this->security->get_csrf_hash());

		$this->direct = base_url('auth');
	}

	public function index(){
		$this->twiggy->template('dashboard/index')->display();
	}

	public function authenticate(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->twiggy->set('message', 'username atau password yang Anda masukan salah');

		$user = UserEntity::where('mst_user_username', $username)->first();

		if (!empty($user))
		{
			if ($this->bcrypt->check_password($password, $user->mst_user_password))
			{
				// generate session
				$data = array
				(
					'name' => $user->mst_user_name,
					'username' => $user->mst_user_username,
					'akses' => $user->mst_akses_id,
					'satker' => $user->mst_satker_id,
					'logged_in' => TRUE
				);

				$this->session->set_userdata('guard', $data);

				redirect(site_url('dashboard'), 'location', 303);
			}
		}

		redirect($this->direct, 'location', 303);
	}

	public function logout(){
		$data = array
		(
			'name' => null,
			'username' => null,
			'akses' => null,
			'satker' => null,
			'logged_in' => FALSE
		);

		$this->session->unset_userdata('guard', $data);

		redirect($this->direct, 'location', 303);
	}

}

