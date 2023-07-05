<?php

class login extends CI_Controller {

	function __construct()
	{
		parent::__construct();;
		$this->load->model('user_model');

	}
	
	function index()
	{
		$this->load->view('login_form');
	}
	
	function sms()
	{
	    // set post fields
        $post = [
            'id_project' => 'IDTEST',
            'va' => 'VATEST',
            'trx_amount'   => 28000,
            'phone_user' => '081546810673'
        ];
        
        $ch = curl_init('http://178.128.124.100/api_mobile/api/example/sendSms');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        
        // execute!
        $response = curl_exec($ch);
        
        // close the connection, release resources used
        curl_close($ch);
        
        // do anything you want with your response
        var_dump($response);
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
