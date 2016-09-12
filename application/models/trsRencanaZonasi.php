<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class TrsRencaraZonasi extends Model {
    protected $table = "trs_rencana_zonasi-form12";
    protected $primary = "trs_rencana_zonasi_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_trs_rencana_zonasi($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("trs_rencana_zonasi_kota", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_trs_rencana_zonasi_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("trs_rencana_zonasi_kota", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}