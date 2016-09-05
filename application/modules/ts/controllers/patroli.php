<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class patroli extends CI_Controller {
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

		$this->direct = base_url('ts/patroli');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('produk', JenisProdukEntity::all());
		$this->twiggy->set('verifikasi', SumberVerifikasiEntity::all());
		$this->twiggy->template('transaction/patroli/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsPatroli();
		$list = $this->model->get_trs_patroli($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_patroli_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/patroli/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsPatroli::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/patroli/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsPatroli::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsPatroli();

				$this->model->trs_patroli_created_by = 'system';
				$this->model->trs_patroli_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsPatroli::find($this->input->post('id'));

				$this->model->trs_patroli_update_by = 'system';
				$this->model->trs_patroli_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_patroli_akses = $this->input->post('akses');
			$this->model->trs_patroli_satker = $this->input->post('satker');
            $this->model->trs_patroli_start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));
            $this->model->trs_patroli_end_date = date('Y-m-d H:i:s', strtotime($this->input->post('end_date')));
			$this->model->trs_patroli_lokasi = $this->input->post('lokasi');
			$this->model->trs_patroli_jml_anggota = $this->input->post('jml_anggota');
            $this->model->trs_patroli_start_time = date('H:i:s', strtotime($this->input->post('start_time')));
            $this->model->trs_patroli_end_time = date('H:i:s', strtotime($this->input->post('end_time')));
			$this->model->trs_patroli_jenis_kapal_id = $this->input->post('jenis_kapal');
			$this->model->trs_patroli_pemilik_kapal = $this->input->post('pemilik_kapal');
            $this->model->trs_patroli_jml_pelanggaran = $this->input->post('jml_pelanggaran');
            $this->model->trs_patroli_jenis_pelanggaran_id = $this->input->post('jenis_pelanggaran');
            $this->model->trs_patroli_sumber_id = $this->input->post('sumber');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

