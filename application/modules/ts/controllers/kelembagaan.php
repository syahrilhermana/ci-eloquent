<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class kelembagaan extends CI_Controller {
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

        $this->direct = base_url('ts/kelembagaan');
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
        $this->twiggy->set('verifikasi', sumberVerifikasiEntity::all());
        $this->twiggy->template('transaction/kelembagaan/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsKelembagaan();
        $list = $this->model->get_trs_data_desa($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_data_desa_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/kelembagaan/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsKelembagaan::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/kelembagaan/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsKelembagaan::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsKelembagaan();

                $this->model->trs_kelembagaan_created_by = $this->guard->get_user();
                $this->model->trs_kelembagaan_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsKelembagaan::find($this->input->post('id'));

                $this->model->trs_kelembagaan_update_by = $this->guard->get_user();
                $this->model->trs_kelembagaan_update_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_kelembagaan_satker = $this->guard->get_satker();
            $this->model->trs_kelembagaan_akses = $this->guard->get_akses();
            $this->model->trs_kelembagaan_name = $this->input->post('name');
            $this->model->trs_kelembagaan_no_sk = $this->input->post('no_sk');
            $this->model->trs_kelembagaan_tgl_dibentuk =  date('Y-m-d',strtotime($this->input->post('tgl_dibentuk')));
            $this->model->trs_kelembagaan_nama_direktur= $this->input->post('nama_direktur');
            $this->model->trs_kelembagaan_jml_staff_fulltime = $this->input->post('jml_staff_fulltime');
            $this->model->trs_kelembagaan_jml_staff_parttime = $this->input->post('jml_staff_parttime');
            $this->model->trs_kelembagaan_jml_staff_pria = $this->input->post('jml_staff_pria');
            $this->model->trs_kelembagaan_jml_staff_wanita = $this->input->post('jml_staff_wanita');
            $this->model->trs_kelembagaan_tahun = $this->input->post('tahun');
            $this->model->trs_kelembagaan_sumber_id = $this->input->post('sumber');
            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

