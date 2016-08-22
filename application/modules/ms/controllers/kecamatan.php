<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class kecamatan extends CI_Controller {
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

		$this->direct = base_url('ms/kecamatan');
	}
	
	public function index(){
		/**
		 * FIXME
		 * this only temporary set list object data
		 * please switch to ajax request to datatable() method if this page has rendered
		 */

		$this->twiggy->set('list', KecamatanEntity::all());

		$this->twiggy->template('master/kecamatan/index')->display();
	}

	public function form($id=null){
		$this->twiggy->set('list', KotaEntity::all());

		if ($id != null) {
			$this->model = KecamatanEntity::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('master/kecamatan/form')->display();
	}

	public function delete($id){
		if ($id == null) {
			redirect($this->direct, 'location', 303);
		}

		KecamatanEntity::delete($id);

		redirect($this->direct, 'location', 303);
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new KecamatanEntity();
			} else {
				$this->model = KecamatanEntity::find($this->input->post('id'));
			}

			$this->model->mst_kota_id			= $this->input->post('kota');
			$this->model->mst_kecamatan_name	= $this->input->post('name');

			$this->model->save();
		} catch(Exception $e) {
			$e->getMessage();
		}

		redirect($this->direct, 'location', 303);
	}
}

