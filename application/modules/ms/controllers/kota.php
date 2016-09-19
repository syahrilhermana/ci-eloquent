<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class kota extends CI_Controller {
	protected $model;
	protected $direct;

	public function __construct() {
		parent::__construct();

		// init twiggy
		$this->twiggy->title('CodeIgniter Plus');

		$this->twiggy->meta('keywords', 'codeigniter-plus');
		$this->twiggy->meta('description', 'CodeIgniter Plus');
		$this->twiggy->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1');

		// generate csrf
		$this->twiggy->set('_csrf', $this->security->get_csrf_token_name());
		$this->twiggy->set('_token', $this->security->get_csrf_hash());

		$this->direct = base_url('ms/kota');

		$this->guard->is_access();
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('list', ProvinsiEntity::all());
		$this->twiggy->template('master/kota/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new KotaEntity();
		$list = $this->model->get_kota($offset, $limit, $search, null, null);
		$total = $this->model->get_kota_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('master/kota/list')->display();
	}

	public function form($id=null){
		$this->twiggy->set('list', ProvinsiEntity::all());

		if ($id != null) {
			$this->model = KotaEntity::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('master/kota/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			KotaEntity::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new KotaEntity();
			} else {
				$this->model = KotaEntity::find($this->input->post('id'));
			}

			$this->model->mst_propisi_id	= $this->input->post('provinsi');
			$this->model->mst_kota_name		= $this->input->post('name');

			$this->model->save();
		} catch(Exception $e) {
			$e->getMessage();
		}

		redirect($this->direct, 'location', 303);
	}
}

