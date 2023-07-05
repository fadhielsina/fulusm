<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Athoslib Class
 *
 * Library for connect to IDD SSO
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Suharyadi
 
 */
class Athoslib {

	protected $_ci;                 // CodeIgniter instance
	private $API_SERVER = "";  // URL of the server API
	private $API_USER ="";
	private $API_PASS ="";
	public $tableSelect = "";

	function __construct()
	{
		$this->_ci = & get_instance();
		$this->API_SERVER = $this->_ci->config->item("API_SERVER");
		$this->API_USER = $this->_ci->config->item("API_USER");
		$this->API_PASS = $this->_ci->config->item("API_PASS");
//		$this->_ci->load->library('curl');
		log_message('debug', 'Athoslib Class Initialized');
		
		if ( ! $this->is_enabled())
		{
			log_message('error', 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
		}

	}
	function delete_emp_gemss($iduser){
		$url = $this->API_SERVER."/sync_athos/delete_user/".$iduser;
		
		return $this->delete_data($url);
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
	function post_data($url,$post_array="",$primary_key="",$option=""){
		// Start session (also wipes existing/previous sessions)
		$this->_ci->curl->create($url);
		// Option & Options
		$this->_ci->curl->options(array(CURLOPT_BUFFERSIZE => 10));

		// Login to HTTP user authentication
		$this->_ci->curl->http_login($this->API_USER, $this->API_PASS);
		$post = array("username"=>"admin", //username aplikasi
						"password"=>"admin", //password aplikasi
						"data"=>$post_array,
						"option"=>$option,
						"id"=>$primary_key,
						"table"=>$this->tableSelect
						);
		
		$this->_ci->curl->post($post);
		
		$response = $this->_ci->curl->execute();
		//echo "<pre>";
		//var_dump($this->_ci->curl);
		//die();
		if($this->_ci->curl->error_code !=0){
			$respon  = array("message" =>"Tidak dapat terhubung dengan server ".$this->_ci->curl->error_string,"data"=>"","error"=>1);
			return ((object)$respon);
		}else{
			$return = json_decode( $response);
			return $return;
		}
		
	}
	function delete_data($url,$post_array="",$primary_key="",$option=""){
		// Start session (also wipes existing/previous sessions)
		$this->_ci->curl->create($url);
		// Option & Options
		$this->_ci->curl->options(array(CURLOPT_BUFFERSIZE => 10));

		// Login to HTTP user authentication
		$this->_ci->curl->http_login($this->API_USER, $this->API_PASS);
		$post = array("username"=>"admin", //username aplikasi
						"password"=>"admin", //password aplikasi
						"data"=>$post_array,
						"option"=>$option,
						"id"=>$primary_key,
						"table"=>$this->tableSelect
						);
		
		$this->_ci->curl->delete($post);
		
		$response = $this->_ci->curl->execute();
		//echo "<pre>";
		//var_dump($this->_ci->curl);
		//die();
		if($this->_ci->curl->error_code !=0){
			$respon  = array("message" =>"Tidak dapat terhubung dengan server ".$this->_ci->curl->error_string,"data"=>"","error"=>1);
			return ((object)$respon);
		}else{
			$return = json_decode( $response);
			return $return;
		}
		
	}
function activeLang(){
	$active = get_cookie('my_lang');
	$lisLang = $this->listLanguage();
	if($active !=""){
		return $lisLang[$active];
	}else{
		return $lisLang[$this->_ci->config->item("language")];
	}
}
function listLanguage(){
	return $this->_ci->config->item("language_availabel");
}
function loadLanguage($lang){
	if($lang ==""){ 
		$lang = $this->_ci->config->item("language");
	} 
    $folder = 'application/language/';
    $languagefiles = scandir($folder);

    if(in_array($lang, $languagefiles)){
        $cookie = array(
            'name'   => 'lang',
            'value'  => $lang,
            'expire' => '31536000',
            'prefix' => 'my_',
            'secure' => false
        );

        $this->_ci->input->set_cookie($cookie);
    }

    $this->_ci->config->set_item('language', $lang);

    redirect($_SERVER["HTTP_REFERER"]);
}

}

/* End of file Athoslib.php */
/* Location=> ./application/libraries/Athoslib.php */
