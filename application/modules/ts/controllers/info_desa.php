<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class info_desa extends CI_Controller {
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

		$this->direct = base_url('ts/info_desa');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
        $this->twiggy->set('desa', DesaEntity::all());
        $this->twiggy->set('satker', SatkerEntity::all());
        $this->twiggy->set('status_lahan', StatusLahanEntity::all());
        $this->twiggy->set('sumber', SumberVerifikasiEntity::all());
        $this->twiggy->set('ket_kondisi', KetKondisiEntity::all());
		$this->twiggy->template('transaction/info-desa/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsInfoDesa();
		$list = $this->model->get_trs_info_desa($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_info_desa_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/info_desa/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsInfoDesa::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/info_desa/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsInfoDesa::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsInfoDesa();

				$this->model->trs_info_desa_created_by = 'system';
				$this->model->trs_info_desa_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsInfoDesa::find($this->input->post('id'));

				$this->model->trs_info_desa_update_by = 'system';
				$this->model->trs_info_desa_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_info_desa_akses = $this->input->post('akses');
            $this->model->trs_info_desa_satker = $this->input->post('satker');
			$this->model->trs_info_desa_kota = $this->input->post('desa');
			$this->model->trs_info_desa_tahun = $this->input->post('luas');
			$this->model->trs_info_desa_mhs = $this->input->post('lahan');
			$this->model->trs_info_desa_asal_mhs = $this->input->post('fasilitas');
			$this->model->trs_info_desa_pt_id = $this->input->post('jenis_informasi');
			$this->model->trs_info_desa_tingkat = $this->input->post('kegiatan');
			$this->model->trs_info_desa_penelitian = date('Y-m-d H:i:s', strtotime($this->input->post('tgl_peresmian')));
			$this->model->trs_info_desa_sumber_id = $this->input->post('sumber');
			$this->model->trs_info_desa_keterangan = $this->input->post('ket_kondisi');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

