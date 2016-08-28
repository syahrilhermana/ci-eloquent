<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class provinsi extends CI_Controller {
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

		$this->direct = base_url('ms/provinsi');
	}
	
	public function index(){
		/**
		 * FIXME
		 * this only temporary set list object data
		 * please switch to ajax request to datatable() method if this page has rendered
		 */

		$this->twiggy->set('list', ProvinsiEntity::all());

		$this->twiggy->template('master/provinsi/index')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = ProvinsiEntity::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('master/provinsi/form')->display();
	}

	public function delete($id){
		if ($id == null) {
			redirect($this->direct, 'location', 303);
		}

		ProvinsiEntity::delete($id);

		redirect($this->direct, 'location', 303);
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new ProvinsiEntity();
			} else {
				$this->model = ProvinsiEntity::find($this->input->post('id'));
			}

			$this->model->mst_propinsi_name	= $this->input->post('name');

			$this->model->save();
		} catch(Exception $e) {
			$e->getMessage();
		}

		redirect($this->direct, 'location', 303);
	}
}

