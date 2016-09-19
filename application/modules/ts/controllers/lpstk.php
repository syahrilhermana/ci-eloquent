<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class lpstk extends CI_Controller {
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

		$this->direct = base_url('ts/lpstk');

		$this->guard->is_access();
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('desa', DesaEntity::all());
		$this->twiggy->set('verifikasi', SumberVerifikasiEntity::all());
		$this->twiggy->template('transaction/lpstk/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsLpstk();
		$list = $this->model->get_trs_lpstk($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_lpstk_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/lpstk/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsLpstk::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/lpstk/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsLpstk::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsLpstk();

				$this->model->trs_lpstk_created_by = 'system';
				$this->model->trs_lpstk_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsLpstk::find($this->input->post('id'));

				$this->model->trs_lpstk_update_by = 'system';
				$this->model->trs_lpstk_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_lpstk_akses = 1;
			$this->model->trs_lpstk_satker_id = 1;
			$this->model->trs_lpstk_name = $this->input->post('name');
			$this->model->trs_lpstk_desa = $this->input->post('desa');
            $this->model->trs_lpstk_tgl = date('Y-m-d H:i:s', strtotime($this->input->post('tgl')));
			$this->model->trs_lpstk_kegiatan = $this->input->post('kegiatan');
			$this->model->trs_lpstk_ketua = $this->input->post('ketua');
			$this->model->trs_lpstk_pria = $this->input->post('pria');
            $this->model->trs_lpstk_wanita = $this->input->post('wanita');
            $this->model->trs_lpstk_sumber_id = $this->input->post('sumber');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

