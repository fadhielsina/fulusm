<?php
class logoutapp extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library(array('auth','session'));
		$this->auth->check_user_authentification();
		$this->load->model('jurnal_model');	
		$this->load->model('akun_model');
		$this->load->model('pajak_model');
		$this->load->model('laporankeuangan_model');
		$this->load->helper('indodate');
		$this->load->helper('finance');
		//$this->load->library(array('fpdf'));
		$this->load->helper(array('date','url'));
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	}
	
	function index()
	{
		redirect("login");
	}
}