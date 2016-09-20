<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class pelatihan_sdm extends CI_Controller {
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

		$this->direct = base_url('ts/pelatihan_sdm');

		$this->guard->is_access();
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->template('transaction/pelatihan-sdm/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsPelatihanSdm();
		$list = $this->model->get_trs_pelatihan_sdm($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_pelatihan_sdm_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/pelatihan-sdm/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsPelatihanSdm::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/pelatihan-sdm/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsPelatihanSdm::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsPelatihanSdm();

				$this->model->trs_pelatihan_sdm_created_by = $this->guard->get_user();
				$this->model->trs_pelatihan_sdm_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsPelatihanSdm::find($this->input->post('id'));

				$this->model->trs_pelatihan_sdm_update_by = $this->guard->get_user();
				$this->model->trs_pelatihan_sdm_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_pelatihan_sdm_akses = $this->guard->get_akses();
			$this->model->trs_pelatihan_sdm_kota = $this->input->post('kota');
			$this->model->trs_pelatihan_sdm_nama_pelatihan = $this->input->post('pelatih');
			$this->model->trs_pelatihan_sdm_tujuan = $this->input->post('tujuan');
			$this->model->trs_pelatihan_sdm_output = $this->input->post('output');
			$this->model->trs_pelatihan_sdm_outcome = $this->input->post('outcome');
			$this->model->trs_pelatihan_sdm_lokasi = '';
			$this->model->trs_pelatihan_sdm_pelaksana = $this->input->post('pelaksana');
			$this->model->trs_pelatihan_sdm_tgl = date('Y-m-d H:i:s', strtotime($this->input->post('tanggal')));
			$this->model->trs_pelatihan_sdm_peserta_l = $this->input->post('peserta_l');
			$this->model->trs_pelatihan_sdm_peserta_w = $this->input->post('peserta_w');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

