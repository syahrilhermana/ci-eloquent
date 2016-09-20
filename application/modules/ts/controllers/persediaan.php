<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class persediaan extends CI_Controller {
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

        $this->direct = base_url('ts/persediaan');
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
        $this->twiggy->template('transaction/persediaan/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsPersediaan();
        $list = $this->model->get_trs_persediaan($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_persediaan_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/persediaan/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsProgresKeuangan::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/persediaan/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsPersediaan::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsPersediaan();

                $this->model->trs_persediaan_created_by = 'system';
                $this->model->trs_persediaan_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsPersediaan::find($this->input->post('id'));

                $this->model->trs_persediaan_updated_by = 'system';
                $this->model->trs_persediaan_updated_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_persediaan_jenis_persediaan =$this->input->post('jenis_persediaan');
            $this->model->trs_persediaan_akun_belanja =$this->input->post('akun_belanja');
            $this->model->trs_persediaan_satker =1;
            $this->model->trs_persediaan_jenis_barang =$this->input->post('jenis_barang');
            $this->model->trs_persediaan_kode_barang =$this->input->post('kode_barang');
            $this->model->trs_persediaan_nama_barang =$this->input->post('nama_barang');
            $this->model->trs_persediaan_harga_pasar =$this->input->post('harga_pasar');
            $this->model->trs_persediaan_satuan =$this->input->post('satuan');
            $this->model->trs_persediaan_register =$this->input->post('register');
            $this->model->trs_persediaan_keterangan =$this->input->post('keterangan');

            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

