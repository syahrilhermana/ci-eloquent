<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class pencetakan extends CI_Controller {
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

		$this->direct = base_url('ts/pencetakan');

		$this->guard->is_access();
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('produk', JenisProdukEntity::all());
		$this->twiggy->set('verifikasi', SumberVerifikasiEntity::all());
		$this->twiggy->template('transaction/pencetakan/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsPencetakan();
		$list = $this->model->get_trs_percetakan($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_percetakan_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/pencetakan/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsPencetakan::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/pencetakan/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsPencetakan::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsPencetakan();

				$this->model->trs_pencetakan_created_by = $this->guard->get_user();
				$this->model->trs_pencetakan_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsPencetakan::find($this->input->post('id'));

				$this->model->trs_pencetakan_update_by = $this->guard->get_user();
				$this->model->trs_pencetakan_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_pencetakan_akses = $this->guard->get_akses();
			$this->model->trs_pencetakan_kota = $this->input->post('kota');
			$this->model->trs_pencetakan_jenis_produk_id = $this->input->post('jenis_produk');
			$this->model->trs_pencetakan_tujuan = $this->input->post('tujuan');
			$this->model->trs_pencetakan_sasaran = $this->input->post('sasaran');
			$this->model->trs_pencetakan_penyusun = $this->input->post('penyusun');
			$this->model->trs_pencetakan_tgl_produksi = date('Y-m-d H:i:s', strtotime($this->input->post('tgl_produksi')));
			$this->model->trs_pencetakan_jumlah_produksi = $this->input->post('jumlah_produksi');
			$this->model->trs_pencetakan_tgl_distribusi = date('Y-m-d H:i:s', strtotime($this->input->post('tgl_distribusi')));
			$this->model->trs_pencetakan_jumlah_terdistribusi = $this->input->post('jumlah_distribusi');
			$this->model->trs_pencetakan_penerima = $this->input->post('penerima');
			$this->model->trs_pencetakan_sumber_verifikasi_id = $this->input->post('sumber_verifikasi');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

