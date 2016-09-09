<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class beasiswa extends CI_Controller {
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

		$this->direct = base_url('ts/beasiswa');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('list', PerguruanTinggiEntity::all());
		$this->twiggy->template('transaction/beasiswa/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsBeasiswa();
		$list = $this->model->get_trs_percetakan($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_percetakan_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/beasiswa/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsBeasiswa::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/beasiswa/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsBeasiswa::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsBeasiswa();

				$this->model->trs_beasiswa_created_by = 'system';
				$this->model->trs_beasiswa_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsBeasiswa::find($this->input->post('id'));

				$this->model->trs_beasiswa_update_by = 'system';
				$this->model->trs_beasiswa_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_beasiswa_akses = $this->input->post('akses');
			$this->model->trs_beasiswa_kota = $this->input->post('kota');
			$this->model->trs_beasiswa_tahun = $this->input->post('tahun');
			$this->model->trs_beasiswa_mhs = $this->input->post('mahasiswa');
			$this->model->trs_beasiswa_asal_mhs = $this->input->post('asal');
			$this->model->trs_beasiswa_pt_id = $this->input->post('pt');
			$this->model->trs_beasiswa_tingkat = $this->input->post('tingkat');
			$this->model->trs_beasiswa_penelitian = $this->input->post('penelitian');
			$this->model->trs_beasiswa_lokasi_penelitian = $this->input->post('lokasi_penelitian');
			$this->model->trs_beasiswa_penerima_laki = $this->input->post('penerima_l');
			$this->model->trs_beasiswa_penerima_wanita = $this->input->post('penerima_w');
			$this->model->trs_beasiswa_strart_date = date('Y-m-d H:i:s', strtotime($this->input->post('tgl_produksi')));
			$this->model->trs_beasiswa_end_date = date('Y-m-d H:i:s', strtotime($this->input->post('tgl_distribusi')));
			$this->model->trs_beasiswa_masa = $this->input->post('masa');
			$this->model->trs_beasiswa_sumber_id = $this->input->post('sumber');
			$this->model->trs_beasiswa_keterangan = $this->input->post('keterengan');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

