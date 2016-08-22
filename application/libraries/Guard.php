<?php

/**
 * @package	guard
 * @author	Syahril Hermana
 */
class Guard
{
    protected $_table;
    protected $_guard;
    var $CI = NULL;

    function __construct(){
        $this->CI =& get_instance();
        $this->_guard = false;
    }

    public function is_access()
    {
        return (!$this->_guard) ? redirect(site_url('auth')) : true;
    }
}