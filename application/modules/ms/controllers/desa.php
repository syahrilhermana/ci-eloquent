<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class desa extends CI_Controller {
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

		$this->direct = base_url('ms/desa');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('list', KecamatanEntity::all());

		$this->twiggy->template('master/desa/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 3;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new DesaEntity();
		$list = $this->model->get_desa($offset, $limit, $search, null, null);
		$total = $this->model->get_desa_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('master/desa/list')->display();
	}

	public function form($id=null){
		$this->twiggy->set('list', KecamatanEntity::all());

		if ($id != null) {
			$this->model = DesaEntity::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('master/desa/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			DesaEntity::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
                $this->model = new DesaEntity();
			} else {
                $this->model = DesaEntity::find($this->input->post('id'));
			}

            $this->model->mst_desa_name	= $this->input->post('name');
            $this->model->mst_kecamatan_id	= $this->input->post('kecamatan');

            $this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

