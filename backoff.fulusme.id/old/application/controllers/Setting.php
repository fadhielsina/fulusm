<?php
class Setting extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library(array('auth','session','customlib'));
		$this->auth->check_user_authentification();
		$this->load->model('setting_model');
		$this->load->helper('indodate');
		$this->load->helper('finance');
		//$this->load->library(array('fpdf'));
		$this->load->helper(array('date','url'));
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	}
	
	function index()
	{
		redirect("/");
	}

	function Currency(){
		$this->setting_model->table="tbl_currency";
		$this->setting_model->primary="id_currency";
		
		$data['main_content'] = 'setting/currency_list';
		$data['add_act'] = 'setting/add_currency';
	
		$data['currency_data'] = $this->setting_model->get_all_data()->result_array();
		$this->load->view('template/template_xpanel', $data);
	}
	function Currency_aktiv($id){
		if($this->db->query("UPDATE tbl_currency SET is_aktif=0")){
			$this->db->query("UPDATE tbl_currency SET is_aktif=1 WHERE id_currency='".$id."'");
		}

		redirect("setting/currency");
	}
	function Company(){
		$qCompany = "SELECT
					as_company.id_company,
					as_company.name_company,
					as_company.company_address,
					as_company.company_phone,
					as_division.division_name,
					as_division.division_coa,
					as_departement.departement_name,
					as_departement.departement_coa
					FROM
					as_company
					LEFT JOIN as_division ON as_division.id_company = as_company.id_company
					LEFT JOIN as_departement ON as_departement.id_division = as_division.id_division and as_departement.id_company = as_division.id_company
					ORDER BY
					as_company.id_company , as_division.id_division ASC
					";


		$data['company_data'] = $this->db->query($qCompany)->result_array();
		$data['title'] = "List Hospital";
		$data['main_content'] = 'setting/company_list';

		$this->setting_model->table="as_company";
		$data['dataCompany'] = $this->setting_model->get_all_data()->result_array();
		
		$this->load->view('template/template_xpanel', $data);

	}
	function add_company(){
		$arrayData= array(
			"name_company"=>$this->input->post('company_name'),
			"company_address"=>$this->input->post('company_address'),
			"company_phone"=>$this->input->post('company_phone'),
		);
		$this->setting_model->table="as_company";
		if($this->setting_model->table_add($arrayData)){
			$this->session->set_flashdata("message","Hospital Created");
			redirect("setting/company");
		}

	}
	function loadDivision($idCompany){
		$dataDivision = $this->db->query("SELECT id_division as id,division_name as text 
						FROM as_division 
						WHERE id_company='".$idCompany."'")->result_array();

		echo json_encode($dataDivision);
	}
	function add_division(){
		$arrayData= array(
			"id_company"=>$this->input->post('id_company'),
			"division_name"=>$this->input->post('division_name'),
			"division_coa"=>$this->input->post('division_coa'),
		);
		$this->setting_model->table="as_division";
		if($this->setting_model->table_add($arrayData)){
			$this->session->set_flashdata("message","Hospital Division Created");
			redirect("setting/company");
		}

	}
	function add_departement(){
		$arrayData= array(
			"id_company"=>$this->input->post('id_company2'),
			"id_division"=>$this->input->post('id_division'),
			"departement_name"=>$this->input->post('departement_name'),
			"departement_coa"=>$this->input->post('departement_coa'),
		);
		$this->setting_model->table="as_departement";
		if($this->setting_model->table_add($arrayData)){
			$this->session->set_flashdata("message","Hospital Departement Created");
			redirect("setting/company");
		}

	}
	function loadDepartement($idCompany,$idDivision){
		$dataDepartement = $this->db->query("SELECT id_departement as id,departement_name as text 
						FROM as_departement 
						WHERE id_company='".$idCompany."' AND id_division='".$idDivision."' ")->result_array();

		echo json_encode($dataDepartement);	
	}
}