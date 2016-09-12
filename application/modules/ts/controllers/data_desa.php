<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class data_desa extends CI_Controller {
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

		$this->direct = base_url('ts/data_desa');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
        $this->twiggy->set('satker', SatkerEntity::all());
        $this->twiggy->set('desa', DesaEntity::all());
        $this->twiggy->set('sumber', SumberVerifikasiEntity::all());
		$this->twiggy->template('transaction/data-desa/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsDataDesa();
		$list = $this->model->get_trs_data_desa($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_data_desa_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/data-desa/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsDataDesa::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/data-desa/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsDataDesa::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsDataDesa();

				$this->model->trs_data_desa_created_by = 'system';
				$this->model->trs_data_desa_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsDataDesa::find($this->input->post('id'));

				$this->model->trs_data_desa_update_by = 'system';
				$this->model->trs_data_desa_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_data_desa_akses = $this->input->post('akses');
			$this->model->trs_data_desa_satker = $this->input->post('satker');
			$this->model->trs_data_desa_desa = $this->input->post('desa');
			$this->model->trs_data_desa_tahun_coremap = $this->input->post('tahun_coremap');
			$this->model->trs_data_desa_luas = $this->input->post('luas');
			$this->model->trs_data_desa_type_hukum_adat = $this->input->post('type_hukum_adat');
			$this->model->trs_data_desa_hukum_adat_nama = $this->input->post('hukum_adat_nama');
			$this->model->trs_data_desa_penduduk_laki = $this->input->post('penduduk_laki');
			$this->model->trs_data_desa_penduduk_wanita = $this->input->post('penduduk_wanita');
			$this->model->trs_data_desa_jumlah_nelayan = $this->input->post('jumlah_nelayan');
			$this->model->trs_data_desa_jumlah_non_nelayan = $this->input->post('jumlah_non_nelayan');
			$this->model->trs_data_desa_sumber_id = $this->input->post('sumber');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

