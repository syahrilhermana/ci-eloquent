<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class tindak_lanjut extends CI_Controller {
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

        $this->direct = base_url('ts/tindak_lanjut');
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
        $this->twiggy->template('transaction/tindak_lanjut/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsTindakLanjut();
        $list = $this->model->get_trs_tindak_lanjut($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_tindak_lanjut_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/tindak_lanjut/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsTindakLanjut::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/tindak_lanjut/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsTindakLanjut::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsTindakLanjut();

                $this->model->trs_tindak_lanjut_created_by = 'system';
                $this->model->trs_tindak_lanjut_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsTindakLanjut::find($this->input->post('id'));

                $this->model->trs_tindak_lanjut_updated_by = 'system';
                $this->model->trs_tindak_lanjut_updated_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_tindak_lanjut_satker = 1;
            $this->model->trs_tindak_lanjut_hp = $this->input->post('hp');
            $this->model->trs_tindak_lanjut_temuan_saran = $this->input->post('temuan_saran');
            $this->model->trs_tindak_lanjut_temuan_keuangan = $this->input->post('temuan_keuangan');
            $this->model->trs_tindak_lanjut_tindak_lanjut = $this->input->post('tindak_lanjut');
            $this->model->trs_tindak_lanjut_tindak_lanjut_keuangan = $this->input->post('tindak_lanjut_keuangan');
            $this->model->trs_tindak_lanjut_sisa_temuan_saran = $this->input->post('sisa_temuan_saran');
            $this->model->trs_tindak_lanjut_sisa_temuan_keuangan = $this->input->post('sisa_temuan_keuangan');
            $this->model->trs_tindak_lanjut_keterangan = $this->input->post('keterangan');


            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

