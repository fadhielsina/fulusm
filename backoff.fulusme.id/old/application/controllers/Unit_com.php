<?php

class Unit_com extends CI_Controller {

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if(($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID'))
		{
			$this->auth->check_user_authentification(1);
		}
		$this->load->model('unit_model');
		$this->load->model('level_model');		
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
	}
	
	function index()
	{
		$data['title'] = $this->lang->line('display_pengguna');
		$data['main_content'] = 'unit/display';
		$data['user_data'] = $this->unit_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}

	function add()
	{
		$data['title'] = "Tambah Perusahaan / Unit";
		$data['main_content'] = 'unit/form';
		$data['act'] = 'add';
		$data['lokasi_data'] = $this->unit_model->get_data_lokasi();
		$data['form_act'] = 'insert';
		$data['user_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('lihat_pengguna');
		$data['main_content'] = 'unit/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$data['user_data'] = $this->unit_model->get_data_by_id($id);
		$data['lokasi_data'] = $this->unit_model->get_data_lokasi();
		$this->load->view('template/template_xpanel', $data);
	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('edit_pengguna');
		$data['main_content'] = 'unit/form';
		$data['act'] = 'edit';
		$data['form_act'] = 'update/'.$id;
		$data['user_data'] = $this->unit_model->get_data_by_id($id);
		$data['lokasi_data'] = $this->unit_model->get_data_lokasi();
		$this->load->view('template/template_xpanel', $data);
	}

	function insert()
	{
		$this->unit_model->fill_data();
		
		    $this->unit_model->insert_data();
			
				$this->session->set_userdata('message', 'Register pengguna baru sukses ;)');
				redirect('unit_com');
	}

	function update()
	{
		$id = $this->uri->segment(3);
		$this->unit_model->fill_data();
			$this->unit_model->update_data($id);
			$this->session->set_userdata('SUCCESSMSG', 'Update Perusahaan / unit sukses ;)');
			$this->session->set_flashdata('message', "<h4>Update Perusahaan / unit sukses !</h4>");
			redirect('unit_com');
	}

	function delete()
	{
		$id = $this->input->post('id');
		$this->db->where('identityID',$id);
		$this->db->delete(as_identity);
			$this->session->set_userdata('SUCCESSMSG', 'Hapus Perusahaan / unit sukses ;)');
			$this->session->set_flashdata('message', "<h4>Hapus Perusahaan / unit sukses !</h4>");
			redirect('unit_com');
	}

	function _user_validation($edit=0)
	{
		$this->form_validation->set_rules('fname', 'Nama Depan', 'trim|required');
		$this->form_validation->set_rules('lname', 'Nama Belakang', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		if($edit!=0)
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[cpassword]');
			$this->form_validation->set_rules('cpassword', 'Ulangi Password', 'trim|required');
		}

		return $this->form_validation->run();
	}

}
/* End of file user.php */
/* Location: ./application/CI_Controllers/user.php */
