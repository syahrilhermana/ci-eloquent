<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;
use Guard as Security;

class FormEntity extends Model {
    protected $table = "mst_form";
    protected $primary = "mst_form_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_form($offset, $limit, $search, $sortCol, $sortDir)
    {
        $this->CI->db->select($this->table.'.*');

        if(Security::get_role() != 'all'){
            $this->CI->db->where('mst_user.mst_role', Security::get_role());
        }

        if($search != ""){
            $this->CI->db->like("mst_form_name", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_form_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("mst_form_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}