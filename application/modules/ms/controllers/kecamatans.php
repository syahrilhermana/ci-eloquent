<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class kecamatans extends CI_Controller {
	protected $model;

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
	}
	
	public function index(){
		$this->twiggy->template('master/biofisik/index')->display();
	}

	public function edit($id){
		if ($id == null) {
			redirect($this->index());
		}

		$this->model = Kecamatan::find($id);
		if ($this->model) {
			$this->twiggy->template('master/biofisik/form')->display();
		} else {
			redirect($this->index());
		}
	}

	public function delete($id){
		if ($id == null) {
			redirect($this->index());
		}

		Kecamatan::delete($id);
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new JenisProduk();
			} else {
				$this->model = Kecamatan::find($this->input->post('id'));
			}

			$this->model->mst_kota_id			= $this->input->post('kota');
			$this->model->mst_kecamatan_name	= $this->input->post('name');

			$this->model->save();
		} catch(Exception $e) {
			$e->getMessage();
		}
	}
}

