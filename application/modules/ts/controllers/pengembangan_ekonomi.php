<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class pengembangan_ekonomi extends CI_Controller {
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

        $this->direct = base_url('ts/pengembangan_ekonomi');
    }

    public function index(){
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

        $this->twiggy->set('this_page', $page);
        $this->twiggy->set('rpsp', TrsRpsp::all());
        $this->twiggy->set('kota', KotaEntity::all());
        $this->twiggy->set('desa', DesaEntity::all());
        $this->twiggy->set('penataan_batas', TrsKkpd::all());
        $this->twiggy->set('lamun', BiofisikEntity::all());
        $this->twiggy->set('mangrove', BiofisikEntity::all());
        $this->twiggy->set('biofisik', BiofisikEntity::all());
        $this->twiggy->set('verifikasi', sumberVerifikasiEntity::all());
        $this->twiggy->template('transaction/pengembangan_ekonomi/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsPengembanganEkonomi();
        $list = $this->model->get_trs_pengembangan_ekonomi($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_pengembangan_ekonomi_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/pengembangan_ekonomi/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsPengembanganEkonomi::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/pengembangan_ekonomi/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsPengembanganEkonomi::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsPengembanganEkonomi();

                $this->model->trs_peng_ekonomi_created_by = 'system';
                $this->model->trs_peng_ekonomi_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsPengembanganEkonomi::find($this->input->post('id'));

                $this->model->trs_peng_ekonomi_update_by = 'system';
                $this->model->trs_peng_ekonomi_update_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_peng_ekonomi_satker =1;
            $this->model->trs_peng_ekonomi_tahun =$this->input->post('tahun');
            $this->model->trs_peng_ekonomi_jenis_pencaharian_alternatif =$this->input->post('jenis_pencaharian_alternatif');
            $this->model->trs_peng_ekonomi_desa =$this->input->post('desa');
            $this->model->trs_peng_ekonomi_tanggal_mulai =date('Y-m-d',strtotime($this->input->post('tanggal_mulai')));
            $this->model->trs_peng_ekonomi_alokasi =$this->input->post('alokasi');
            $this->model->trs_peng_ekonomi_realisasi =$this->input->post('tahun');
            $this->model->trs_peng_ekonomi_jumlah_kelompok =$this->input->post('jumlah_kelompok');
            $this->model->trs_peng_ekonomi_jumlah_angota =$this->input->post('jumlah_anggota');
            $this->model->trs_peng_ekonomi_perkembangan_usaha =$this->input->post('perkembangan_usaha');
            $this->model->trs_peng_ekonomi_verifikasi =$this->input->post('verifikasi');



            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

