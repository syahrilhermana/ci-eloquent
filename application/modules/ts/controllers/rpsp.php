<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class rpsp extends CI_Controller {
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

		$this->direct = base_url('ts/rpsp');

		$this->guard->is_access();
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('satker', SatkerEntity::all());
		$this->twiggy->set('verifikasi', SumberVerifikasiEntity::all());
        $this->twiggy->set('desa', DesaEntity::all());
		$this->twiggy->template('transaction/rpsp/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsRpsp();
		$list = $this->model->get_trs_rpsp($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_rpsp_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/rpsp/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsRpsp::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/rpsp/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsRpsp::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsRpsp();

				$this->model->trs_rpsp_created_by = 'system';
				$this->model->trs_rpsp_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsRpsp::find($this->input->post('id'));

				$this->model->trs_rpsp_update_by = 'system';
				$this->model->trs_rpsp_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_rpsp_akses = $this->input->post('akses');
			$this->model->trs_rpsp_satker_id = $this->input->post('satker');
			$this->model->trs_rpsp_name = $this->input->post('name');
            $this->model->trs_rpsp_desa = $this->input->post('desa');
			$this->model->trs_rpsp_no_sk = $this->input->post('no_sk');
			$this->model->trs_rpsp_tgl_penetapan = date('Y-m-d H:i:s', strtotime($this->input->post('tgl_penetapan')));
            $this->model->trs_rpsp_musrenbang = $this->input->post('musrenbang');
            $this->model->trs_rpsp_usulan = $this->input->post('usulan');
			$this->model->trs_rpsp_zonasi = $this->input->post('zonasi');
            $this->model->trs_rpsp_sumber_id = $this->input->post('sumber');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

