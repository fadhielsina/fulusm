<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

    function check_user_authentification($admin_only = 0)
    {
    	$this->clear_cache();
		$CI =& get_instance();
		$CI->load->library('session');
		
		if(!$CI->session->userdata('SESS_USER_ID'))
		{
			$data = array(
				'SESS_LOGIN_STATEMENT' => 'Akses Ditolak ;)',
				'ERRMSG_ARR' => 'Anda harus login terlebih dahulu !'
			);
			$CI->session->set_userdata($data);
			redirect('login');
 		}
 		elseif($admin_only && (!$CI->session->userdata('ADMIN')))
 		{
			$data = array(
				'SESS_LOGIN_STATEMENT' => 'Akses Ditolak ;)',
				'ERRMSG_ARR' => 'Anda harus login sebagai admin untuk dapat mengakses bagian management'
			);
			$CI->session->set_userdata($data);
			redirect('login');
		}
		
    }
    function clear_cache()
	{
		$CI =& get_instance();
	    $CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
	    $CI->output->set_header("Pragma: no-cache");
	}
}

?>
