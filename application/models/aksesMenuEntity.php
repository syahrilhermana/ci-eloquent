<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;

class AksesMenuEntity extends Model {
    protected $table = "mst_akses_menu";
    protected $primary = "mst_akses_menu_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function get_akses_menu($offset, $limit, $search, $sortCol, $sortDir)
    {
        if($search != ""){
            $this->CI->db->like("mst_akses_id", $search);
        }
        if($sortCol != "") $this->CI->db->order_by($sortCol, $sortDir);

        return $this->CI->db->get($this->table, $limit, $offset);
    }

    public function get_akses_menu_count($search = "")
    {
        $this->CI->db->select($this->primary);
        if($search != "") {
            $this->CI->db->like("mst_akses_id", $search);
        }

        return $this->CI->db->count_all_results($this->table);
    }

    public function generate_menu($access, $parent)
    {
        $this->CI->db->select('mst_menu.mst_menu_id as id, mst_menu.mst_menu_name as \'name\', mst_menu.mst_menu_icon as icon, mst_menu.mst_menu_order as \'order\', mst_form.mst_form_target as link, mst_menu.mst_menu_parent as parent');
        $this->CI->db->from($this->table);
        $this->CI->db->join('mst_menu', 'mst_menu.mst_menu_id = '.$this->table.'.mst_menu_id', 'left');
        $this->CI->db->join('mst_akses', 'mst_akses.mst_akses_id = '.$this->table.'.mst_akses_id', 'left');
        $this->CI->db->join('mst_form', 'mst_form.mst_form_id = mst_menu.mst_menu_form_id', 'left');
        $this->CI->db->where($this->table.'.mst_akses_id', $access);

        if ($parent != null) {
            $this->CI->db->where('mst_menu.mst_menu_parent', $parent);
        } else {
            $this->CI->db->where('mst_menu.mst_menu_parent is null', null, true);
        }

        $this->CI->db->order_by('mst_menu.mst_menu_order', 'ASC');

        $query = $this->CI->db->get();


        if ($query->num_rows() > 0)
        {
            $result = $query->result_array();

            foreach (array_keys($result) as $key)
            {
                $result[$key]['children'] = $this->generate_menu($access, $result[$key]['id']);
            }

            return $result;
        }

        return $query;

    }
}