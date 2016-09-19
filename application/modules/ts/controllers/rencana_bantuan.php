<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class rencana_bantuan extends CI_Controller {
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

        $this->direct = base_url('ts/rencana_bantuan');
    }

    public function index(){
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

        $this->twiggy->set('this_page', $page);
        $this->twiggy->set('propinsi', ProvinsiEntity::all());
        $this->twiggy->set('kecamatan', KecamatanEntity::all());
        $this->twiggy->set('rpsp', TrsRpsp::all());
        $this->twiggy->set('kota', KotaEntity::all());
        $this->twiggy->set('desa', DesaEntity::all());
        $this->twiggy->set('penataan_batas', TrsKkpd::all());
        $this->twiggy->set('lamun', BiofisikEntity::all());
        $this->twiggy->set('mangrove', BiofisikEntity::all());
        $this->twiggy->set('biofisik', BiofisikEntity::all());
        $this->twiggy->set('verifikasi', sumberVerifikasiEntity::all());
        $this->twiggy->template('transaction/rencana_bantuan/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsRencanaBantuan();
        $list = $this->model->get_trs_rencana_bantuan($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_rencana_bantuan_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/rencana_bantuan/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsRencanaBantuan::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/rencana_bantuan/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsRencanaBantuan::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsRencanaBantuan();

                $this->model->trs_rencana_bantuan_created_by = 'system';
                $this->model->trs_rencana_bantuan_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsRencanaBantuan::find($this->input->post('id'));

                $this->model->trs_rencana_bantuan_updated_by = 'system';
                $this->model->trs_rencana_bantuan_updated_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_rencana_bantuan_provinsi =$this->input->post('provinsi');
            $this->model->trs_rencana_bantuan_kota =$this->input->post('kota');
            $this->model->trs_rencana_bantuan_kecamatan =$this->input->post('kecamatan');
            $this->model->trs_rencana_bantuan_desa =$this->input->post('desa');
            $this->model->trs_rencana_bantuan_jenis_bantuan =$this->input->post('jenis_bantuan');
            $this->model->trs_rencana_bantuan_jumlah =$this->input->post('jumlah');
            $this->model->trs_rencana_bantuan_penerima =$this->input->post('penerima');
            $this->model->trs_rencana_bantuan_unit =$this->input->post('unit');
            $this->model->trs_rencana_bantuan_satuan =$this->input->post('satuan');






            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

