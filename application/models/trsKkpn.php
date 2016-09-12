<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class TrsKkpn extends Model {
    protected $table = "trs_kkpn-form7-B";
    protected $primary = "trs_kkpn_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_trs_kkpn($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("trs_kkpn_name", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_trs_kkpn_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("trs_kkpn_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}