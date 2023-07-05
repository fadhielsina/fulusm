<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Customlib Class
 *
 * 
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Suharyadi
 
 */
class Customlib {


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
	public function get_combo_tahun(){
		$curYear = date("Y");
		
		for($x=$curYear;$x>($curYear-10);$x--){
			$tahun[$x] =$x;	
		}

		return $tahun;
	}
	public function get_combo_bulan(){
		
		for($x=1;$x<=12;$x++){
			$bulan[$x] = 	$this->get_month_name($x);
		}

		return $bulan;
	}
	function get_month_name($index=""){
		$active = get_cookie('my_lang');
		if ($active == 'english'){
			$month=array("January","February","March","April","May","June","July","August","September","October","November","December");
		} else {
			$month=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		}
		
		if($index!=""){
			return $month[$index-1];
		}else{
			return $month;
		}

	}

	function date_indo($date,$separator="-",$format="d-m-y")
	{

		$dateExplode = explode($separator,$date);

		if(!is_array($dateExplode)){
			die("Error format date");
		}else{
			if($format = "m".$separator."d".$separator."y"){
				return $dateExplode[1]." ".$this->get_month_name($dateExplode[0])." ".$dateExplode[2];
			}else{
				return $dateExplode[2]." ".$this->get_month_name($dateExplode[1])." ".$dateExplode[0];
			}
		}
	}
	
	public function is_enabled()
	{
		return function_exists('curl_init');
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


}

/* End of file Iddsso.php */
/* Location=> ./application/libraries/Iddsso.php */
