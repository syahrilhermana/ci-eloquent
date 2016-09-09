<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class biofisik_kawasan extends CI_Controller {
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

		$this->direct = base_url('ts/biofisik_kawasan');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('satker', SatkerEntity::all());
		$this->twiggy->set('desa', DesaEntity::all());
		$this->twiggy->set('biofisik', BiofisikEntity::all());
		$this->twiggy->set('kondisi', KondisiEntity::all());
		$this->twiggy->set('jenis_biofisik', JenisBiofisikEntity::all());
		$this->twiggy->set('verifikasi', SumberVerifikasiEntity::all());
		$this->twiggy->template('transaction/biofisik-kawasan/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsBiofisikKawasan();
		$list = $this->model->get_trs_biofisik_kawasan($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_biofisik_kawasan_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/biofisik-kawasan/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsBeasiswa::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/biofisik-kawasan/form')->display();
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
				$this->model = new TrsBiofisikKawasan();

				$this->model->trs_biofisik_kawasan_created_by = 'system';
				$this->model->trs_biofisik_kawasan_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsBiofisikKawasan::find($this->input->post('id'));

				$this->model->trs_biofisik_kawasan_update_by = 'system';
				$this->model->trs_biofisik_kawasan_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_biofisik_kawasan_akses = $this->input->post('akses');
			$this->model->trs_biofisik_kawasan_satker_id = $this->input->post('satker');
			$this->model->trs_biofisik_kawasan_desa = $this->input->post('desa');
			$this->model->trs_biofisik_kawasan_biofisik_id = $this->input->post('biofisik');
			$this->model->trs_biofisik_kawasan_name = $this->input->post('nama_kawasan');
			$this->model->trs_biofisik_kawasan_lat = $this->input->post('latitude');
			$this->model->trs_biofisik_kawasan_long = $this->input->post('longitude');
			$this->model->trs_biofisik_kawasan_luas = $this->input->post('luas');
			$this->model->trs_biofisik_kawasan_kondisi_id = $this->input->post('kondisi');
			$this->model->trs_biofisik_kawasan_tutupan = $this->input->post('tutupan');
			$this->model->trs_biofisik_kawasan_jenis_biofisik_id = $this->input->post('jenis_biofisik');
			$this->model->trs_biofisik_kawasan_jenis_biofisik_jumlah = $this->input->post('jumlah_jenis_biofisik');
			$this->model->trs_biofisik_kawasan_pelaksanan = $this->input->post('pelaksana');
			$this->model->trs_biofisik_kawasan_start_date = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));
			$this->model->trs_biofisik_kawasan_end_date = date('Y-m-d H:i:s', strtotime($this->input->post('end_date')));
			$this->model->trs_biofisik_kawasan_verfikasi_id = $this->input->post('keterengan');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

