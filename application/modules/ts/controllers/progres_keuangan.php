<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class progres_keuangan extends CI_Controller {
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

        $this->direct = base_url('ts/progres_keuangan');
    }

    public function index(){
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

        $this->twiggy->set('this_page', $page);
        $this->twiggy->set('rpsp', TrsRpsp::all());
        $this->twiggy->set('kota', KotaEntity::all());
        $this->twiggy->set('penataan_batas', TrsKkpd::all());
        $this->twiggy->set('lamun', BiofisikEntity::all());
        $this->twiggy->set('mangrove', BiofisikEntity::all());
        $this->twiggy->set('biofisik', BiofisikEntity::all());
        $this->twiggy->set('verifikasi', sumberVerifikasiEntity::all());
        $this->twiggy->template('transaction/progres_keuangan/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsProgresKeuangan();
        $list = $this->model->get_trs_progres_keuangan($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_progres_keuangan_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/progres_keuangan/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsProgresKeuangan::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/progres_keuangan/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsProgresKeuangan::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsProgresKeuangan();

                $this->model->trs_progres_keuangan_created_by = 'system';
                $this->model->trs_progres_keuangan_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsProgresKeuangan::find($this->input->post('id'));

                $this->model->trs_progres_keuangan_updated_by = 'system';
                $this->model->trs_progres_keuangan_updated_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_progres_keuangan_jenis =$this->input->post('jenis');
            $this->model->trs_progres_keuangan_judul_kegiatan =$this->input->post('judul_kegiatan');
            $this->model->trs_progres_keuangan_lokasi =$this->input->post('lokasi');
            $this->model->trs_progres_keuangan_penyerapan_kumulatif =$this->input->post('penyerapan_kumulatif');
            $this->model->trs_progres_keuangan_sumber_dana =$this->input->post('sumber_dana');
            $this->model->trs_progres_keuangan_jenis_sumber_dana =$this->input->post('jenis_sumber_dana');
            $this->model->trs_progres_keuangan_kategori_kegiatan =$this->input->post('kategori_kegiatan');
            $this->model->trs_progres_keuangan_pagu_anggaran =$this->input->post('pagu_anggaran');
            $this->model->trs_progres_keuangan_jenis_pengadaan =$this->input->post('jenis_pengadaan');
            $this->model->trs_progres_keuangan_metode_pengadaan =$this->input->post('metode_pengadaan');
            $this->model->trs_progres_keuangan_metode_pembayaran =$this->input->post('metode_pembayaran');
            $this->model->trs_progres_keuangan_hps =$this->input->post('hps');
            $this->model->trs_progres_keuangan_nilai_kontrak =$this->input->post('nilai_kontrak');
            $this->model->trs_progres_keuangan_periode_kontrak =$this->input->post('periode_kontrak');
            $this->model->trs_progres_keuangan_realisasi =$this->input->post('realisasi');
            $this->model->trs_progres_keuangan_b1 =$this->input->post('b1');
            $this->model->trs_progres_keuangan_b2 =$this->input->post('b2');
            $this->model->trs_progres_keuangan_b3 =$this->input->post('b3');
            $this->model->trs_progres_keuangan_b4 =$this->input->post('b4');
            $this->model->trs_progres_keuangan_b5 =$this->input->post('b5');
            $this->model->trs_progres_keuangan_b6 =$this->input->post('b6');
            $this->model->trs_progres_keuangan_b7 =$this->input->post('b7');
            $this->model->trs_progres_keuangan_b8 =$this->input->post('b8');
            $this->model->trs_progres_keuangan_b9 =$this->input->post('b9');
            $this->model->trs_progres_keuangan_b10 =$this->input->post('b10');
            $this->model->trs_progres_keuangan_b11 =$this->input->post('b11');
            $this->model->trs_progres_keuangan_b12 =$this->input->post('b12');
            $this->model->trs_progres_keuangan_total_penyerapan =$this->input->post('total_penyerapan');
            $this->model->trs_progres_keuangan_sisa_anggaran =$this->input->post('sisa_anggaran');
            $this->model->trs_progres_keuangan_ket =$this->input->post('ket');


            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

