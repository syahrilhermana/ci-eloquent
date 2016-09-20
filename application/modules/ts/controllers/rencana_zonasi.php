<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class rencana_zonasi extends CI_Controller {
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

        $this->direct = base_url('ts/rencana_zonasi');
    }

    public function index(){
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

        $this->twiggy->set('this_page', $page);
        $this->twiggy->set('rpsp', TrsRpsp::all());
        $this->twiggy->set('kota', KotaEntity::all());
        $this->twiggy->set('penataan_batas', TrsKkpd::all());
        $this->twiggy->set('lamun', BiofisikEntity::all());
        $this->twiggy->set('mangrove', BiofisikEntity::all());
        $this->twiggy->set('tk', BiofisikEntity::all());
        $this->twiggy->set('verifikasi', SumberVerifikasiEntity::all());
        $this->twiggy->template('transaction/rencana_zonasi/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsRencanaZonasi();
        $list = $this->model->get_trs_rencana_zonasi($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_rencana_zonasi_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/rencana_zonasi/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsRencanaZonasi::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/rencana_zonasi/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsRencanaZonasi::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsRencanaZonasi();

                $this->model->trs_rencana_zonasi_created_by = 'system';
                $this->model->trs_rencana_zonasi_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsKkpd::find($this->input->post('id'));

                $this->model->trs_rencana_zonasi_update_by = 'system';
                $this->model->trs_rencana_zonasi_update_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_rencana_zonasi_akses = 1;
            $this->model->trs_rencana_zonasi_satker =1;
            $this->model->trs_rencana_zonasi_kota = $this->input->post('kota');
            $this->model->trs_rencana_zonasi_tahun_dok_awal = $this->input->post('tahun_dok_awal');
            $this->model->trs_rencana_zonasi_dok_final = $this->input->post('dok_final');
            $this->model->trs_rencana_zonasi_dok_ranperda= $this->input->post('dok_ranperda');
            $this->model->trs_rencana_zonasi_sumber_id = $this->input->post('sumber');

            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

