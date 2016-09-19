<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class spji extends CI_Controller {
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

        $this->direct = base_url('ts/spji');
    }

    public function index(){
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

        $this->twiggy->set('this_page', $page);
        $this->twiggy->set('rpsp', TrsRpsp::all());
        $this->twiggy->set('kota', KotaEntity::all());
        $this->twiggy->set('penataan_batas', TrsKkpd::all());
        $this->twiggy->set('lamun', BiofisikEntity::all());
        $this->twiggy->set('mangrove', BiofisikEntity::all());
        $this->twiggy->set('biofisik', BiofisikEntity::all());;
        $this->twiggy->template('transaction/spji/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsStatusPengelolaanJenisIkan();
        $list = $this->model->get_trs_status_pengelolaan_jenis_ikan($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_status_pengelolaan_jenis_ikan_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/spji/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsStatusPengelolaanJenisIkan::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/spji/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsStatusPengelolaanJenisIkan::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsStatusPengelolaanJenisIkan();

                $this->model->trs_status_pengelolaan_jenis_ikan_created_by = 'system';
                $this->model->trs_status_pengelolaan_jenis_ikan_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsStatusPengelolaanJenisIkan::find($this->input->post('id'));

                $this->model->trs_status_pengelolaan_jenis_ikan_update_by = 'system';
                $this->model->trs_status_pengelolaan_jenis_ikan_update_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_status_pengelolaan_jenis_ikan_akses =1;
            $this->model->trs_status_pengelolaan_jenis_ikan_satker =1;
            $this->model->trs_status_pengelolaan_jenis_ikan_biofisik_id =$this->input->post('biofisik');
            $this->model->trs_status_pengelolaan_jenis_ikan_lokasi_perlindungan_status =$this->input->post('lokasi_perlindungan_status');
            $this->model->trs_status_pengelolaan_jenis_ikan_perlindungan_verifikasi =$this->input->post('perlindungan_verifikasi');
            $this->model->trs_status_pengelolaan_jenis_ikan_pengelolaan_verifikasi =$this->input->post('pengelolaan_verifikasi');
            $this->model->trs_status_pengelolaan_jenis_ikan_pengelolaan_status =$this->input->post('pengelolaan_status');
            $this->model->trs_status_pengelolaan_jenis_ikan_aksi_status =$this->input->post('aksi_status');
            $this->model->trs_status_pengelolaan_jenis_ikan_aksi_verifikasi =$this->input->post('aksi_verifikasi');
            $this->model->trs_status_pengelolaan_jenis_ikan_pilot_status =$this->input->post('pilot_status');
            $this->model->trs_status_pengelolaan_jenis_ikan_pilot_lokasi =$this->input->post('pilot_lokasi');
            $this->model->trs_status_pengelolaan_jenis_ikan_pilot_verifikasi =$this->input->post('pilot_verifikasi');

            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

