<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class menu extends CI_Controller {
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

		$this->direct = base_url('ms/menu');
		$this->load->library('icons');

		$this->guard->is_access();
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('list', FormEntity::all());
		$this->twiggy->set('icons', $this->icons->glyphicons());
		$this->twiggy->template('master/menu/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new MenuEntity();
		$list = $this->model->get_menu($offset, $limit, $search, null, null);
		$total = $this->model->get_menu_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('master/menu/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = MenuEntity::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('master/menu/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			MenuEntity::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new MenuEntity();
			} else {
				$this->model = MenuEntity::find($this->input->post('id'));
			}

			$this->model->mst_menu_name = $this->input->post('name');
			$this->model->mst_menu_icon = $this->input->post('icon');
			$this->model->mst_menu_parent = $this->input->post('parent');
			$this->model->mst_menu_order = $this->input->post('order');
			$this->model->mst_menu_form_id = $this->input->post('form');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

