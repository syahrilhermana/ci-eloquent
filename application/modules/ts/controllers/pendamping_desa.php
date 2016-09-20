<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class pendamping_desa extends CI_Controller {
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

        $this->direct = base_url('ts/pendamping_desa');
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
        $this->twiggy->template('transaction/pendamping_desa/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsPendampingDesa();
        $list = $this->model->get_trs_pendamping_desa($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_pendamping_desa_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/pendamping_desa/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsPendampingDesa::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/pendamping_desa/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsPendampingDesa::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsPendampingDesa();

                $this->model->trs_pendamping_desa_created_by = 'system';
                $this->model->trs_pendamping_desa_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsPendampingDesa::find($this->input->post('id'));

                $this->model->trs_pendamping_desa_updated_by = 'system';
                $this->model->trs_pendamping_desa_updated_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_pendamping_desa_satker = 1;
            $this->model->trs_pendamping_desa_pendamping = $this->input->post('pendamping');
            $this->model->trs_pendamping_desa_alamat_asal = $this->input->post('alamat_asal');
            $this->model->trs_pendamping_desa_lokasi_tugas = $this->input->post('lokasi_tugas');
            $this->model->trs_pendamping_desa_tanggal_mulai = date('Y-m-d',strtotime($this->input->post('tanggal_mulai')));
            $this->model->trs_pendamping_desa_tanggal_selesai= date('Y-m-d',strtotime($this->input->post('tanggal_selesai')));
            $this->model->trs_pendamping_desa_waktu_tempuh = $this->input->post('waktu_tempuh');
            $this->model->trs_pendamping_desa_alat_transport = $this->input->post('alat_transport');
            $this->model->trs_pendamping_desa_verifikasi = $this->input->post('verifikasi');

            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

