<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class TrsPencetakan extends Model {
    protected $table = "trs_pencetakan-form1";
    protected $primary = "trs_pencetakan_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_trs_percetakan($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("trs_pencetakan_tujuan", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_trs_percetakan_count($search = "")
    {
        $this->CI->db->select($this->id);
        if($search != "") {
            $this->CI->db->like("trs_pencetakan_tujuan", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}