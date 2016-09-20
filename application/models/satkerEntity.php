<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;
use Guard as Security;

class SatkerEntity extends Model {
    protected $table = "mst_satker";
    protected $primary = "mst_satker_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function user(){
        return $this->belongsTo('userEntity', 'mst_satker_id', 'mst_satker_id');
    }

    public function get_satker($offset, $limit, $search, $sortCol, $sortDir)
    {

        $this->CI->db->select($this->table.'.*');


        if(Security::get_role() != 'all'){
            $this->CI->db->where('mst_user.mst_role', Security::get_role());
        }

        if($search != ""){
            $this->CI->db->like("mst_satker_name", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_satker_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("mst_satker_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }
}