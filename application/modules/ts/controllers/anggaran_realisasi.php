<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class anggaran_realisasi extends CI_Controller {
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

        $this->direct = base_url('ts/anggaran_realisasi');
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
        $this->twiggy->template('transaction/anggaran_realisasi/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsAnggaranRealisasi();
        $list = $this->model->get_trs_anggaran_realisasi($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_anggaran_realisasi_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/anggaran_realisasi/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsAnggaranRealisasi::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/anggaran_realisasi/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsAnggaranRealisasi::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsAnggaranRealisasi();

                $this->model->trs_anggaran_created_by = 'system';
                $this->model->trs_anggaran_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsAnggaranRealisasi::find($this->input->post('id'));

                $this->model->trs_anggaran_updated_by = 'system';
                $this->model->trs_anggaran_updated_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_anggaran_satker_id = 1;
            $this->model->trs_anggaran_tahun = $this->input->post('tahun');
            $this->model->trs_anggaran_alokasi_loan = $this->input->post('alokasi_loan');
            $this->model->trs_anggaran_realisasi_loan = $this->input->post('realisasi_loan');
            $this->model->trs_anggaran_alokasi_grand = $this->input->post('alokasi_grand');
            $this->model->trs_anggaran_realisasi_grand = $this->input->post('realisasi_grand');
            $this->model->trs_anggaran_alokasi_dana_penunjang = $this->input->post('alokasi_dana_penunjang');
            $this->model->trs_anggaran_realisasi_dana_penunjang = $this->input->post('realisasi_dana_penunjang');


            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

