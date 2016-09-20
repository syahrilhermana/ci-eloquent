<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;
use Guard as Security;

class SumberVerifikasiEntity extends Model {
    protected $table = "mst_sumber_verifikasi";
    protected $primary = "mst_sumber_verifikasi_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_sumber_verifikasi($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("mst_sumber_verifikasi_name", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_sumber_verifikasi_count($search = "")
    {
        $this->CI->db->select($this->table.'.*');


        if(Security::get_role() != 'all'){
            $this->CI->db->where('mst_user.mst_role', Security::get_role());
        }

        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("mst_sumber_verifikasi_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}