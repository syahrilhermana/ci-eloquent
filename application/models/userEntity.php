<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class UserEntity extends Model {
    protected $table = "mst_user";
    protected $primary = "mst_user_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function satker(){
        return $this->belongsTo('satkerEntity', 'mst_satker_id', 'mst_satker_id');
    }

    public function akses(){
        return $this->belongsTo('aksesEntity', 'mst_akses_id', 'mst_akses_id');
    }

    public function get_user($offset, $limit, $search, $sortCol, $sortDir)
    {
        $this->CI->db->select($this->table.'.*, mst_satker.mst_satket_name as \'satker\', mst_akses.mst_akses_name as \'akses\'');
        $this->CI->db->join('mst_akses', 'mst_akses.mst_akses_id = '.$this->table.'.mst_akses_id', 'left');
        $this->CI->db->join('mst_satker', 'mst_satker.mst_satker_id = '.$this->table.'.mst_satker_id', 'left');

        if($search != ""){
            $this->CI->db->like("mst_user_username", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_user_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("mst_satker_name", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }

    public function get_authorities($username)
    {
        $this->CI->db->where("mst_user_username", $username);

        return $this->CI->db->get($this->table);
    }
}