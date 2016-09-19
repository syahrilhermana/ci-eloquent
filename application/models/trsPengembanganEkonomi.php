<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class TrsPengembanganEkonomi extends Model {
    protected $table = "trs_pengembangan_ekonomi-form16";
    protected $primary = "trs_peng_ekonomi_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_trs_pengembangan_ekonomi($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("trs_pengembangan_ekonomi", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_trs_pengembangan_ekonomi_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("trs_pengembangan_ekonomi", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}