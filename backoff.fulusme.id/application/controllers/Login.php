<?php

class login extends CI_Controller {

	function __construct()
	{
		parent::__construct();;
		$this->load->model('user_model');
		$this->db_fulus = $this->load->database('fulusme', TRUE);

	}
	
	function index()
	{
		$this->load->view('login_form');
	}
	
	function sms($id = 44)
	{
	    
	    $pendana = $this->db_fulus->get_where('pendana', ['id' => $id])->row();
		$email_user = $pendana->email;
		$full_name = $pendana->full_name;
		$fullname = $str = str_replace(' ','%20',$full_name);
// 		$phone = $pendana->phone;
        $phone = '085771618422';
		
	    $data['custodian'] = 'Company';
	    $data['max_pendanaan'] = 28000;
	    $text = 'TEST MASUK';
		$runfile = 'http://202.149.67.146:8800/?PhoneNumber=' . $phone . '&Text=' . $text . '&ID=FULUSME';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $runfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($ch);
		curl_close($ch);
	}

	function login_exec()
	{
		

		if (!$this->_user_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->index();
		}
		else
		{
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$query = $this->user_model->validate_login($username, $password);
			
			if($query->num_rows() == 1)
			{
				$row = $query->row();
				$data = array(
					'SESS_USER_ID' => $row->id,
					'username' => $row->username,
					'SESS_FIRST_NAME' => $row->nama_depan,
					'SESS_LAST_NAME' => $row->nama_belakang,
					'IDENTITY_ID' => $row->identity_id,
					'identityCode' => $row->identityCode,
					'identityName' => $row->identityName,
					'IDENTITY_CODE' => $row->identityID,
					'menu_akses' => $row->akses,
					'ADMIN' => $row->administrator
				);

				$this->session->set_userdata($data);
				
				redirect('home');
			}
			else // incorrect username or password
			{
				$data = array(
					'SESS_LOGIN_STATEMENT' => 'Login Gagal ;)',
					'ERRMSG_ARR' => "Username dan/atau Password salah !"
				);
				$this->session->set_userdata($data);
				redirect('login');
			}
		}
	}

	function _user_validation()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		return $this->form_validation->run();
	}

	function logout()
	{
		session_destroy();
		$this->session->unset_userdata('SESS_USER_ID');
		$this->session->unset_userdata('SESS_FIRST_NAME');
		$this->session->unset_userdata('SESS_LAST_NAME');
		$this->session->unset_userdata('IDENTITY_ID');
		$this->session->unset_userdata('ERRMSG_ARR');
		$this->session->set_userdata('SESS_LOGIN_STATEMENT', 'Anda Telah Logout ;)');
		//var_dump($this->session->all_userdata());
		redirect('login');
	}

}

/* End of file login.php */
/* Location: ./application/CI_Controllers/login.php */
