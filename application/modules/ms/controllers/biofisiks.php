<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package	dashboard
 * @author	Syahril Hermana
 */

class biofisiks extends CI_Controller {
	protected $model;

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

	}
	
	public function index(){
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
			$this->model = new Biofisik();

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

			print_r($_GET); echo "<br/>";
			print_r($list);exit;
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

	public function edit($id){
		if ($id == null) {
			redirect($this->index());
		}

		$this->model = Biofisik::find($id);
		if ($this->model) {
			$this->twiggy->template('master/biofisik/form')->display();
		} else {
			redirect($this->index());
		}
	}

	public function delete($id){
		if ($id == null) {
			redirect($this->index());
		}

		Biofisik::delete($id);
	}

	public function submit(){
		try {
			if ($this->input->post('id') == null) {
				$this->model = new Biofisik();
			} else {
				$this->model = Biofisik::find($this->input->post('id'));
			}

			$this->model->mst_biofisik_name = $this->input->post('name');

			$this->model->save();
		} catch(Exception $e) {
			$e->getMessage();
		}
	}
}

