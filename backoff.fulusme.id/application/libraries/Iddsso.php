<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter IDD SSO Class
 *
 * Library for connect to IDD SSO
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Suharyadu
 
 */
class Iddsso {

	protected $_ci;                 // CodeIgniter instance
	private $API_SERVER = "http://localhost/idd_SSO/index.php/Idsso_api";  // URL of the server API
	private $API_USER ="api-iddsso";
	private $API_PASS ="@pi-1dd550";
	public $response = '';       // Contains the  response for debug
	public $Data = array("username"=>"admin", "password"=>"admin","email"=>"admin@admin.com","site"=>"athos-hr.com");             // Contains Data to post to API
	public $error_code;             // Error code returned as an int
	public $error_string;           // Error message returned as a string
	public $info;                   // Returned after request (elapsed time, etc)

	function __construct($url = '')
	{
		$this->_ci = & get_instance();
//		$this->_ci->load->library('curl');
		log_message('debug', 'IDD SSO Class Initialized');
		
		if ( ! $this->is_enabled())
		{
			log_message('error', 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
		}

	}
	public function login(){
		// Start session (also wipes existing/previous sessions)
		$this->_ci->curl->create($this->API_SERVER."/login");
		// Option & Options
		$this->_ci->curl->options(array(CURLOPT_BUFFERSIZE => 10));

		// Login to HTTP user authentication
		$this->_ci->curl->http_login($this->API_USER, $this->API_PASS);
		$this->_ci->curl->post($this->Data);
		$response = $this->_ci->curl->execute();
		if($this->_ci->curl->error_code !=0){
			$return = array("message"=>"failed connect ".$this->_ci->curl->error_string,"data"=>"","error"=>$this->_ci->curl->error_code);
		}else{
			$return = json_decode($response,true);
			
		}
		return $return;
	}
	
	public function is_enabled()
	{
		return function_exists('curl_init');
	}


}

/* End of file Iddsso.php */
/* Location=> ./application/libraries/Iddsso.php */
