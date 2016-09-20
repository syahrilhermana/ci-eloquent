<?php
/**
 * Created by syaharil.hermana@gmail.com
 */

use Eloquent\Model as Model;
use Guard as Security;

class DashboardEntity extends Model {
    protected $table = "mst_akses";
    protected $primary = "mst_akses_id";
    var $CI = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
    }

    public function user(){
        return $this->belongsTo('userEntity', 'mst_akses_id', 'mst_akses_id');
    }

    public function get_capaian(){
        return null;
    }
}