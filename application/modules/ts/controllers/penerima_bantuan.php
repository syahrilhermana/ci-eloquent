<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class penerima_bantuan extends CI_Controller {
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

		$this->direct = base_url('ts/penerima_bantuan');
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('satker', SatkerEntity::all());
		$this->twiggy->set('bantuan', JenisBantuanEntity::all());
        $this->twiggy->set('kota', KotaEntity::all());
        $this->twiggy->set('desa', DesaEntity::all());
		$this->twiggy->template('transaction/penerima-bantuan/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsPenerimaBantuan();
		$list = $this->model->get_trs_penerima_bantuan($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_penerima_bantuan_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/penerima-bantuan/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsPenerimaBantuan::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/penerima_bantuan/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsPenerimaBantuan::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsPenerimaBantuan();

				$this->model->trs_penerima_bantuan_created_by = 'system';
				$this->model->trs_penerima_bantuan_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsPenerimaBantuan::find($this->input->post('id'));

				$this->model->trs_penerima_bantuan_update_by = 'system';
				$this->model->trs_penerima_bantuan_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_penerima_bantuan_akses = $this->input->post('akses');
			$this->model->trs_penerima_bantuan_satker_id = $this->input->post('satker');
			$this->model->trs_penerima_bantuan_kota = $this->input->post('kota');
			$this->model->trs_penerima_bantuan_desa = $this->input->post('desa');
			$this->model->trs_penerima_bantuan_laki = $this->input->post('laki');
			$this->model->trs_penerima_bantuan_wanita = $this->input->post('wanita');
            $this->model->trs_penerima_bantuan_jenis_bantuan_id = $this->input->post('jenis_bantuan');
            $this->model->trs_penerima_bantuan_manfaat = $this->input->post('manfaat');
            $this->model->trs_penerima_bantuan_tahun = $this->input->post('tahun');
            $this->model->trs_penerima_bantuan_metode = $this->input->post('metode');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

