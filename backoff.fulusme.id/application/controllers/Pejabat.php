<?php

class Pejabat extends CI_Controller {

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if(($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID'))
		{
			$this->auth->check_user_authentification(1);
		}
		$this->load->model('pejabat_model');		
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
	}
	
	function index()
	{
		$data['title'] = $this->lang->line('display_pejabat');
		$data['main_content'] = 'pejabat/display';
		$data['user_data'] = $this->pejabat_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}

	function add()
	{
		$data['title'] = $this->lang->line('tambah_pejabat');
		$data['jabatan'] = $this->db->get('as_jabatan')->result_array();
		foreach($data['jabatan'] as $item){
			$data['data_jabatan'][$item['id_jabatan']] = $item['nama_jabatan'];
		}
		$data['main_content'] = 'pejabat/form';
		$data['act'] = 'add';
		$data['form_act'] = 'insert';
		$data['user_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('lihat_pejabat');
		$data['jabatan'] = $this->db->get('as_jabatan')->result_array();
		foreach($data['jabatan'] as $item){
			$data['data_jabatan'][$item['id_jabatan']] = $item['nama_jabatan'];
		}
		$data['main_content'] = 'pejabat/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$data['user_data'] = $this->pejabat_model->get_data_by_id($id);
		$this->load->view('template/template_xpanel', $data);
	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['jabatan'] = $this->db->get('as_jabatan')->result_array();
		foreach($data['jabatan'] as $item){
			$data['data_jabatan'][$item['id_jabatan']] = $item['nama_jabatan'];
		}
		$data['title'] = $this->lang->line('edit_pejabat');
		$data['main_content'] = 'pejabat/form';
		$data['act'] = 'edit';
		$data['form_act'] = 'update/'.$id;
		$data['user_data'] = $this->pejabat_model->get_data_by_id($id);
		$this->load->view('template/template_xpanel', $data);
	}

	function insert()
	{
		if (!$this->_user_validation())
		{
			$this->session->set_userdata('message', validation_errors());
			$this->add();
		}
		else
		{
			$this->pejabat_model->fill_data();
			//Insert Data
			if($this->pejabat_model->insert_data()) 
			{
				$this->session->set_userdata('message', 'Register data baru sukses ;)');
				redirect('pejabat');
			}
		}
	}

	function update()
	{
		$id = $this->uri->segment(3);
		$this->pejabat_model->fill_data();
		//Update Data
		if($this->pejabat_model->update_data($id))
		{
			$this->session->set_userdata('SUCCESSMSG', 'Update pejabat sukses ;)');
			if(!$this->session->userdata('ADMIN'))
			{
				redirect('pejabat/edit/'.$id);
			}
			else
			{
				redirect('pejabat');
			}
		}
	}

	function delete()
	{
		$id = $this->input->post('id');
		$user_data = $this->pejabat_model->get_data_by_id($id);
		if($this->pejabat_model->delete_data($id))
		{
			$msg = 'S#Pejabat '.$user_data['nama'].' telah dihapus.';
		}
		else
		{
			$msg .= 'E#Terjadi kesalahan dalam menghapus data pejabat '.$user_data['nama'].'. Harap coba lagi.';
		}
		echo $msg;
	}

	function _user_validation($edit=0)
	{
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		return $this->form_validation->run();
	}

}
/* End of file pejabat.php */
/* Location: ./application/CI_Controllers/pejabat.php */
