<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class JenisKapalEntity extends Model {
    protected $table = "mst_jenis_kapal";
    protected $primary = "mst_jenis_kapal_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_jenis_kapal($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("mst_jenis_kapal_name", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_jenis_kapal_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("mst_jenis_kapal_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}