<?php

class Jurnal_template extends CI_Controller {

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if(($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID'))
		{
			$this->auth->check_user_authentification(1);
		}
		$this->load->model('jurnal_template_model');
		$this->load->model('akun_model');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
	}
	
	function index()
	{
		$data['title'] = 'Jurnal Template';
		$data['main_content'] = 'jurnal_template/display';
		$data['user_data'] = $this->jurnal_template_model->get_all_data();
		$data['type_template'] = array( 1 => 'Regular', 2 => 'Penyesuaian' );
		
		$this->load->view('template/template_xpanel', $data);
	}

	function add()
	{
		$data['title'] = 'Tambah Template';
		$data['jabatan'] = $this->db->get('as_jabatan')->result_array();
		foreach($data['jabatan'] as $item){
			$data['data_jabatan'][$item['id_jabatan']] = $item['nama_jabatan'];
		}
		$data['main_content'] = 'jurnal_template/form';
		$data['act'] = 'add';
		$data['form_act'] = 'insert';
		$data['user_data'] = FALSE;
		$accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['positions'] = array( 'Kredit', 'Debit' );
		$data['type_template'] = array( 1 => 'Regular', 2 => 'Penyesuaian' );

		$this->load->view('template/template_xpanel', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = 'Lihat Template';
		$data['main_content'] = 'jurnal_template/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$data['user_data'] = $this->jurnal_template_model->get_data_by_id($id);
		$accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['positions'] = array( 'Kredit', 'Debit' );
		$this->load->view('template/template_xpanel', $data);
	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = 'Edit Template';
		$data['main_content'] = 'jurnal_template/form';
		$data['act'] = 'edit';
		$data['form_act'] = 'update/'.$id;
		$data['user_data'] = $this->jurnal_template_model->get_data_by_id($id);
		$accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['positions'] = array( 'Kredit', 'Debit' );
		$data['type_template'] = array( 1 => 'Regular', 2 => 'Penyesuaian' );

		$this->load->view('template/template_xpanel', $data);
	}

	function insert()
	{
		if (!$this->_user_validation())
		{
			$this->session->set_flashdata('message', validation_errors());
			$this->add();
		}
		else
		{
			
			$this->jurnal_template_model->fill_data();
			//Insert Data
			if($this->jurnal_template_model->insert_data()) 
			{
				$this->session->set_flashdata('message', 'Register template baru sukses ;)');
				redirect('jurnal_template');
			}
		}
	}

	function update()
	{
		$id = $this->uri->segment(3);
		$this->jurnal_template_model->fill_data();
		//Update Data
		if($this->jurnal_template_model->update_data($id))
		{
			$this->session->set_flashdata('message', "Update template sukses ;)");
			if(!$this->session->userdata('ADMIN'))
			{
				redirect('jurnal_template/edit/'.$id);
			}
			else
			{
				redirect('jurnal_template');
			}
		}
	}

	function delete()
	{
		$id = $this->input->post('id');
		$user_data = $this->jurnal_template_model->get_data_by_id($id);
		if($this->jurnal_template_model->delete_data($id))
		{
			$msg = 'S#Template '.$user_data['nama_template'].' telah dihapus.';
		}
		else
		{
			$msg .= 'E#Terjadi kesalahan dalam menghapus data template '.$user_data['nama_template'].'. Harap coba lagi.';
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
