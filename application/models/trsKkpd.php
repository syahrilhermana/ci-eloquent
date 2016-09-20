<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;
use Guard as Security;

class TrsKkpd extends Model {
    protected $table = "trs_kkpd-form7-A";
    protected $primary = "trs_kkpd_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_trs_kkpd($offset, $limit, $search, $sortCol, $sortDir)
    {
        $this->CI->db->select($this->table.'.*');
        $this->CI->db->join('mst_user', 'mst_user.mst_user_id = '.$this->table.'.trs_kkpd_created_by', 'left');

        if(Security::get_role() != 'all'){
            $this->CI->db->where('mst_user.mst_role', Security::get_role());
        }

        if($search != ""){
            $this->CI->db->like("trs_kkpd_kota", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_trs_kkpd_count($search = "")
    {
        $this->CI->db->select($this->id);
        if($search != "") {
            $this->CI->db->like("trs_kkpd_kota", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}