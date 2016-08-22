<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class biofisik extends CI_Controller {
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

		$this->direct = base_url('ms/biofisik');
	}
	
	public function index(){
		/**
		 * FIXME
		 * this only temporary set list object data
		 * please switch to ajax request to datatable() method if this page has rendered
		 */

		$this->twiggy->set('list', BiofisikEntity::all());

		$this->twiggy->template('master/biofisik/index')->display();
	}

	public function datatable()
	{
		if($this->input->is_ajax_request())
		{
			// variable initialization
			$search = "";
			$start = 0;
			$rows = 10;
			$this->model = new BiofisikEntity();

			// get search value (if any)
			if (isset($_GET['search']['value']) && $_GET['search']['value'] != "" ) {
				$search = $_GET['search']['value'];
			}

			// limit
			$start = $this->datatables->getOffset();
			$rows = $this->datatables->getLimit();

			// sort
//			$sortDir = $this->datatables->getSortDir();
//			$sortCol = $this->datatables->getSortCol(array(""));

			// run query to get user listing
			$list   = $this->model->get_biofisik($start, $rows, $search, null, null);
			$iTotal = $this->model->get_biofisik_count($search);

			if($search != "")$iFilteredTotal = $this->model->get_biofisik_count($search);
			else $iFilteredTotal = $iTotal;

			/*
             * Output
             */
			$output = array(
				"sEcho" => intval($_GET['draw']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
			);

			// get result after running query and put it in array
			$no = $start+1;
			foreach ($list->result_array() as $row) {
				$record = array();

				$record[] = $no++;
				$record[] = $row['mst_biofisik_name'];

				$record[] = '<div class="btn-group">
                               <a href="'.base_url('admin/category/form/'.$row['mst_biofisik_id']).'" title="Ubah" id="edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i></a>
                               <a href="javascript:void(0)" onclick="confirmDirectPopUp(\''.base_url('admin/category/delete/'.$row['mst_biofisik_id']).'\', \'Confirmation\', \'<strong>Are you sure you want to permanently erase the items?</strong> <br/> You can’t undo this action. \', \'Delete it\', \'Cancel\');" title="delete" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
                             </div>';

				$output['aaData'][] = $record;
			}
			// format it to JSON, this output will be displayed in datatable
			echo json_encode($output);
		}else {
			show_404();
		}
	}

	public function form($id=null){
		if ($id != null) {
			$this->model = BiofisikEntity::find($id);
			$this->twiggy->set('object', $this->model);
		}

		$this->twiggy->template('master/biofisik/form')->display();
	}

	public function delete($id){
		if ($id == null) {
			redirect($this->direct, 'location', 303);
		}

		BiofisikEntity::delete($id);

		redirect($this->direct, 'location', 303);
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new BiofisikEntity();
			} else {
				$this->model = BiofisikEntity::find($this->input->post('id'));
			}

			$this->model->mst_biofisik_name = $this->input->post('name');

			$this->model->save();

			redirect($this->direct, 'location', 303);
		} catch(Exception $e) {
			$e->getMessage();
			redirect($this->direct, 'location', 303);
		}
	}
}

