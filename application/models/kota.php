<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class Kota extends Model {
    protected $table = "mst_kota";
    protected $primary = "mst_kota_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_kota($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("mst_kota_name", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_kota_count($search = "")
    {
        $this->CI->db->select($this->id);
        if($search != "") {
            $this->CI->db->like("mst_kota_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}