<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class StatusLahan extends Model {
    protected $table = "mst_status_lahan";
    protected $primary = "mst_status_lahan_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_biofisik($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("mst_status_lahan_name", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_biofisik_count($search = "")
    {
        $this->CI->db->select($this->id);
        if($search != "") {
            $this->CI->db->like("mst_status_lahan_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}