<?php

class Level extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		if(($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID'))
		{
			$this->auth->check_user_authentification(1);
		}
		$this->load->model(array('level_model','level_model','menu_model'));
		$this->load->helper('form');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
	}
	
	function index()
	{
		$data['title'] = $this->lang->line('level_user');
		$data['main_content'] = 'level/display';
		$data['add_act'] = 'level/add';
		//set tabel to manage
		$this->level_model->table = "as_level";
		$this->level_model->primary = "id_level" ;
		$data['asset_data'] = $this->level_model->get_all_data();
		$data['field'] = array(
							'nama_level'=> $this->lang->line('nama_level'),
							//'akses'=> $this->lang->line('hak_akses')
							);
		$this->load->view('template/template_xpanel', $data);
	}

	function add()
	{
		$data['title'] = $this->lang->line('tambah_level');
		$data['main_content'] = 'level/form';
		$data['sub_content'] = 'level/sub_form';
		$data['sub_content_data'] = $this->sub_content();
		$data['act'] = 'add';
		//$data['lokasi_data'] = $this->level_model->get_data_lokasi();
		$data['form_act'] = 'level/insert';
		$data['asset_data'] = FALSE;
		$data['menu_data'] = $this->level_model->get_data_menu();
		$data['dataParentMenu'] = $this->menu_model->get_parent_menu();
		$data['field'] = array(
							'nama_level'=> $this->lang->line('nama_level'),
							'akses'=> $this->lang->line('hak_akses')
							);
		$this->load->view('template/template_xpanel', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('lihat_level');
		$data['main_content'] = 'level/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$data['asset_data'] = $this->level_model->get_data_by_id($id);
		$data['lokasi_data'] = $this->level_model->get_data_lokasi();
		$data['menu_data'] = $this->level_model->get_data_menu();
		$data['dataParentMenu'] = $this->menu_model->get_parent_menu();
		$data['field'] = array(
							'nama_level'=> $this->lang->line('nama_level'),
							'akses'=> $this->lang->line('hak_akses')
							);
		$this->load->view('template/template_xpanel', $data);
	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('edit_level');
		$data['main_content'] = 'level/form';
		$data['act'] = 'edit';
		$data['form_act'] = 'level/update/'.$id;
		$data['asset_data'] = $this->level_model->get_data_by_id($id);
		$data['lokasi_data'] = $this->level_model->get_data_lokasi();
		$data['menu_data'] = $this->level_model->get_data_menu();
		$data['dataParentMenu'] = $this->menu_model->get_parent_menu();
		$data['field'] = array(
							'nama_level'=> $this->lang->line('nama_level'),
							'akses'=> $this->lang->line('hak_akses')
							);
		$this->load->view('template/template_xpanel', $data);
	}

	function insert()
	{
		if (!$this->_asset_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->add();
		}
		else
		{
			//$this->level_model->fill_data();
			//Cek Login
			$this->level_model->table = "as_level";
			$data = array("nama_level" => $this->input->post("nama_level"),
							"akses"=>json_encode($this->input->post("UserMenu")),
							);
			if(!$this->level_model->check_username())
			{
				$this->session->set_userdata('ERRMSG_ARR', 'Username telah digunakan');
				$this->add();
			}
			//Insert Data
			elseif($this->level_model->insert_data($data)) 
			{
				$this->session->set_userdata('SUCCESSMSG', 'Register Level baru sukses ;)');
				redirect("level");
			}
		}
	}

	function update()
	{
		$id = $this->uri->segment(3);

		$menu = json_encode($this->input->post('UserMenu'));
		$nama_level = $this->input->post('nama_level');

		$update = $this->db->query("UPDATE as_level set nama_level ='".$nama_level."', akses='".$menu."' WHERE id_level='".$id."'");
		if($update){
			$this->session->set_flashdata("message","Update level berhasil");
		}else{
			$this->session->set_flashdata("message","Update level gagal");
		}

		redirect("level");

		
	}

	function delete()
	{
		$id = $this->input->post('id');
		$asset_data = $this->level_model->get_data_by_id($id);
		if($this->level_model->delete_data($id))
		{
			$msg = 'Data telah dihapus.';
		}
		else
		{
			$msg .= 'E#Terjadi kesalahan dalam menghapus data , Harap coba lagi.';
		}
		echo $msg;
	}
	function _asset_validation(){

		return true;

	}
	function sub_content(){
		$parent = $this->menu_model->get_parent_menu();
		foreach($parent as $item){
			$sub_content[]	= $item;//form_checkbox($item['nama_menu'], $item['id_menu'], FALSE,"class='custom-control-input'")." ".$item['menu_label'] ;
			$child = $this->menu_model->get_parent_menu($item['id_menu']);
			foreach($child as $childitem){
				//$sub_content[]	= $childitem;//form_checkbox($childitem['nama_menu'], $item['id_menu'], FALSE,"class='custom-control-input'");
			}
		}
		
		return $sub_content;
	}


}
/* End of file asset.php */
/* Location: ./application/CI_Controllers/asset.php */
