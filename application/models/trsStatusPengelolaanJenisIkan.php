<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class TrsStatusPengelolaanJenisIkan extends Model {
    protected $table = "trs_status_pengelolaan_jenis_ikan-form13";
    protected $primary = "trs_status_pengelolaan_jenis_ikan_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_trs_status_pengelolaan_jenis_ikan($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("trs_status_pengelolaan_jenis_ikan_pilot_lokasi", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_trs_status_pengelolaan_jenis_ikan_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("trs_status_pengelolaan_jenis_ikan_pilot_lokasi", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}