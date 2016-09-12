<?php

/**
 * @package	icons
 * @author	Syahril Hermana
 */
class Icons
{
    var $CI = NULL;

    function __construct(){
        $this->CI =& get_instance();
    }

    public function glyphicons()
    {
        $glyphicons = array(
            'Home'	=> 'md md-home',
            'Computer'	=>	'md md-computer',
            'Assessment'	=> 'md md-assessment',
            'Email'	=>	'md md-email'
        );

        return $glyphicons;
    }
}