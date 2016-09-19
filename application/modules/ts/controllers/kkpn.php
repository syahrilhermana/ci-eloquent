<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class kkpn extends CI_Controller {
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

		$this->direct = base_url('ts/kkpn');

		$this->guard->is_access();
	}
	
	public function index(){
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

		$this->twiggy->set('this_page', $page);
		$this->twiggy->set('rpsp', TrsRpsp::all());
		$this->twiggy->set('penataan_batas', TrsKkpd::all());
        $this->twiggy->set('lamun', BiofisikEntity::all());
        $this->twiggy->set('mangrove', BiofisikEntity::all());
        $this->twiggy->set('tk', BiofisikEntity::all());
		$this->twiggy->template('transaction/kkpn/index')->display();
	}

	public function list_data()
	{
		// get pagable data
		$page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$limit  = 25;
		$offset = (($page-1)*$limit);
		$search = "";

		$this->model = new TrsKkpn();
		$list = $this->model->get_trs_kkpn($offset, $limit, $search, null, null);
		$total = $this->model->get_trs_kkpn_count($search);

		$this->twiggy->set('list', $list->result());
		$this->twiggy->set('total', $total);
		$this->twiggy->set('totalPage', ceil($total/$limit));
		$this->twiggy->set('size', $list->num_rows());
		$this->twiggy->set('page', $page);
		$this->twiggy->template('transaction/kkpn/list')->display();
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = TrsKkpn::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('transaction/kkpn/form')->display();
	}

	public function delete($id){
		if($this->input->is_ajax_request())
		{
			if ($id == null) {
				redirect($this->direct, 'location', 303);
			}

			TrsKkpn::delete($id);

			redirect($this->direct, 'location', 303);
		}
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new TrsKkpn();

				$this->model->trs_kkpn_created_by = 'system';
				$this->model->trs_kkpn_created_date = date('Y-m-d H:i:s');
			} else {
				$this->model = TrsKkpn::find($this->input->post('id'));

				$this->model->trs_kkpn_update_by = 'system';
				$this->model->trs_kkpn_update_date = date('Y-m-d H:i:s');
			}

			$this->model->trs_kkpn_akses = $this->input->post('akses');
			$this->model->trs_kkpn_name = $this->input->post('name');
			$this->model->trs_kkpn_sk_mkp = $this->input->post('sk_mkp');
			$this->model->trs_kkpn_rencana_pengelolaan = $this->input->post('rencana_pengelolaan');
			$this->model->trs_kkpn_penataan_batas = $this->input->post('penataan_batas');
			$this->model->trs_kkpn_luas_kkpd = $this->input->post('luas_kkpd');
            $this->model->trs_kkpn_lamun = $this->input->post('lamun');
            $this->model->trs_kkpn_lamun_luas = $this->input->post('lamun_luas');
            $this->model->trs_kkpn_mangrove = $this->input->post('mangrove');
            $this->model->trs_kkpn_mangrove_luas = $this->input->post('mangrove_luas');
            $this->model->trs_kkpn_tk = $this->input->post('tk');
            $this->model->trs_kkpn_tk_luas = $this->input->post('tk_luas');
            $this->model->trs_kkpn_keterangan = $this->input->post('keterangan');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

