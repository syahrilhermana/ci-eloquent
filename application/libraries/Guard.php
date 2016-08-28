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

        $this->CI->load->library('jwt');
    }

    public function is_access()
    {
        return (!$this->_guard) ? redirect(site_url('auth')) : true;
    }

    public function token_valid($token)
    {
        try {
            $this->CI->jwt->decode($token, $this->CI->config->item('jwt_secret'));
        } catch(Exception $e) {
            $data['status'] = 'token invalid';
            $data['code'] = '500';
            $this->CI->response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function generate_token($user_id)
    {
        return $this->CI->jwt->encode(array(
            'consumerKey'=>$this->CI->config->item('jwt_key'),
            'userId'=>$user_id,
            'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
            'ttl'=>$this->CI->config->item('jwt_ttl')
        ), $this->CI->config->item('jwt_secret'));
    }
}