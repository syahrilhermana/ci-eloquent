<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class fasilitas_infrastruktur extends CI_Controller {
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

        $this->direct = base_url('ts/fasilitas_infrastruktur');
    }

    public function index(){
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');

        $this->twiggy->set('this_page', $page);
        $this->twiggy->set('infrastruktur', JenisInfrastrukturEntity::all());
        $this->twiggy->set('desa', DesaEntity::all());
        $this->twiggy->template('transaction/fasilitas-infrastruktur/index')->display();
    }

    public function list_data()
    {
        // get pagable data
        $page   = (!$this->input->get('page')) ? 1 : $this->input->get('page');
        $limit  = 25;
        $offset = (($page-1)*$limit);
        $search = "";

        $this->model = new TrsFasilitasInfrastruktur();
        $list = $this->model->get_trs_data_desa($offset, $limit, $search, null, null);
        $total = $this->model->get_trs_data_desa_count($search);

        $this->twiggy->set('list', $list->result());
        $this->twiggy->set('total', $total);
        $this->twiggy->set('totalPage', ceil($total/$limit));
        $this->twiggy->set('size', $list->num_rows());
        $this->twiggy->set('page', $page);
        $this->twiggy->template('transaction/fasilitas-infrastruktur/list')->display();
    }

    public function form($id=null){
        if ($id != null) {
            $this->model = TrsFasilitasInfrastruktur::find($id);
            $this->twiggy->set('object', $this->model);
        }

        $this->twiggy->template('transaction/fasilitas-infrastruktur/form')->display();
    }

    public function delete($id){
        if($this->input->is_ajax_request())
        {
            if ($id == null) {
                redirect($this->direct, 'location', 303);
            }

            TrsFasilitasInfrastruktur::delete($id);

            redirect($this->direct, 'location', 303);
        }
    }

    public function submit(){
        try {
            if ($this->input->post('id') == null) {
                $this->model = new TrsFasilitasInfrastruktur();

                $this->model->trs_fasilitas_infrastruktur_created_by = $this->guard->get_user();
                $this->model->trs_fasilitas_infrastruktur_created_date = date('Y-m-d H:i:s');
            } else {
                $this->model = TrsFasilitasInfrastruktur::find($this->input->post('id'));

                $this->model->trs_fasilitas_infrastruktur_update_by = $this->guard->get_user();
                $this->model->trs_fasilitas_infrastruktur_update_date = date('Y-m-d H:i:s');
            }

            $this->model->trs_fasilitas_infrastruktur_akses = $this->guard->get_akses();
            $this->model->trs_fasilitas_infrastruktur_satker = $this->guard->get_satker();

            $this->model->trs_fasilitas_infrastruktur_jenis_infrastruktur = $this->input->post('jenis_infrastruktur');
            $this->model->trs_fasilitas_infrastruktur_desa = $this->input->post('desa');
            $this->model->trs_fasilitas_infrastruktur_tahun = $this->input->post('tahun');
            $this->model->trs_fasilitas_infrastruktur_status_pemanfaatan = $this->input->post('status');

            $this->model->save();

            redirect($this->direct, 'location', 303);
        } catch(Exception $e) {
            $e->getMessage();
            redirect($this->direct, 'location', 303);
        }
    }
}

