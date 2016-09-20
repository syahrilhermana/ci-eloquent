<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class users extends CI_Controller {
	protected $model;
	protected $direct;

	public function __construct() {
		parent::__construct();

		// init twiggy
		$this->twiggy->title($this->config->item('application'));

		$this->twiggy->meta('keywords', 'codeigniter-plus');
		$this->twiggy->meta('description', 'CodeIgniter Plus');
		$this->twiggy->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1');

		// generate csrf
		$this->twiggy->set('_csrf', $this->security->get_csrf_token_name());
		$this->twiggy->set('_token', $this->security->get_csrf_hash());

		$this->direct = base_url('ms/users');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('satker', SatkerEntity::all());
		$this->twiggy->set('akses', AksesEntity::all());
		$this->twiggy->template('master/users/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new UserEntity();
		$list = $this->model->get_user($offset, $limit, $search, null, null);
		$total = $this->model->get_user_count($search);


		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('master/users/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = UserEntity::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('master/users/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			UserEntity::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new UserEntity();
			} else {
				$this->model = UserEntity::find($this->input->post('id'));
			}

			$username = $this->input->post('username');
			$user = UserEntity::where('mst_user_username', $username)->first();

			if (empty($user))
			{
				$this->model->mst_user_password = $this->bcrypt->hash_password('123456');
				$this->model->mst_user_is_access = 1;

				$this->model->mst_user_name = $this->input->post('name');
				$this->model->mst_user_username = $username;
				$this->model->mst_akses_id = $this->input->post('akses');
				$this->model->mst_satker_id = $this->input->post('satker');
				$this->model->mst_role = $this->input->post('role');

				$this->model->save();
			} else {
				$this->session->set_flashdata('error', 'username sudah dipakai.');
			}

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

