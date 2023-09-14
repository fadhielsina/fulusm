<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('email');
	}


	public function index()
	{
		if ($this->session->userdata('email')) {
			if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 6) {
				redirect('admin');
			} else {

				redirect('user');
			}
		}
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Fulusme - Login';
			// 			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login', $data);
			// 			$this->load->view('templates/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			if ($user['is_active'] == 1) {
				if (password_verify($password, $user['password'])) {
					if ($user['login_status'] == 0) {
						$this->db->update('user', ['login_status' => 1, 'last_login' => time()], ['email' => $email]);
						$this->db->insert('history_login', [
							'id_user' => $user['id'],
							'name' => $user['name'],
							'datetime' => date('Y-m-d H:i:s'),
							'ip' => $this->input->ip_address(),
							'email' => $user['email']
						]);
						$data = [
							'id' => $user['id'],
							'email' => $user['email'],
							'name' => $user['name'],
							'role_id' => $user['role_id']
						];
						$this->session->set_userdata($data);

						if ($user['role_id'] == 6) {
							redirect('admin');
						} elseif ($user['role_id'] == 1) {
							redirect('user');
						} elseif ($user['role_id'] == 2) {
							redirect('user');
						} else {
							redirect('user');
						}
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
								Akun sedang digunakan, silahkan logout di perangkat lain.
								</div>');
						redirect('auth');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
							Email dan Password Salah.
							</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Silahkan aktivasi email Anda terlebih dahulu
					</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Email Anda belum terdaftar 
				</div>');
			redirect('auth');
		}
	}

	public function registration()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('role_id', 'Role', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', ['is_unique' => 'this email is already registered']);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
			'matches' => 'password don\'t match!',
			'min_length' => 'password too short, minimum 8 character'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
		$this->form_validation->set_rules('setuju', 'Persyaratan ', 'required', ['required' => 'pernyataan harus di setujui']);
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Fulusme - Registration';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
		} else {

			$email = $this->input->post('email', true);
			$phone = strval($this->input->post('phone'));
			$role = $this->input->post('role_id');
			$is_umkm = 0;
			if ($this->input->post('role_id') == "5") {
				$role = 2;
				$is_umkm = 1;
			}

			$data = [
				// 'id_anggota' => "0".$this->input->post('role_id').date("d").date("y")., 
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($email),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => $this->input->post('role_id'),
				'phone' => $this->input->post('phone'),
				'is_active' => 0,
				'is_umkm' => $is_umkm,
				'date_created' => time()
			];


			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  			Selamat,  silahkan cek email Anda dan segera aktivasi Email Anda!
			</div>');

			// print_r($user);

			$this->db->select('id');
			$this->db->from('user');
			$this->db->order_by("id", "desc");
			$last_id = $this->db->get()->result_array();
			$id_num = $last_id[0]["id"] + 1;
			$id_anggota_number = $invID = str_pad($id_num, 4, '0', STR_PAD_LEFT);
			$data['id_anggota'] = "0" . $this->input->post('role_id') . date("d") . date("m") . date("y") . $id_anggota_number;

			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()

			];

			if ($this->db->insert('user', $data));
			$this->db->insert('user_token', $user_token);

			$this->_sendEmail($token, 'verify', $data['id_anggota']);
			// 			$this->notifToAdmin($role);
			// $runfile = 'http://60.253.96.2:8800/?PhoneNumber=' . $phone . '&Text=Hi,%20terimakasih%20telah%20bergabung%20dengan%20SCF%20Fulusme%20Layanan%20Urun%20Dana&ID=FULUSME';
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_URL, $runfile);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// $content = curl_exec($ch);
			// curl_close($ch);
			redirect('auth');
		}
	}

	public function _sendEmail($token, $type, $idanggota)
	{
		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'ssl',
			'smtp_host' => 'fulusme.id',
			'smtp_user' => 'noreply@fulusme.id',
			'smtp_pass' => 'fulusme2022',
			'smtp_port' => 465,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];
		$this->email->initialize($config);
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from('noreply@fulusme.id', 'fulusme Info');
		$this->email->to($this->input->post('email'), "project@fulusme.id");

		if ($type == 'verify') {
			$this->email->subject("Verifikasi Email ");
			$this->email->message('<p> Selamat datang ' . $this->input->post('name') . ', Terima kasih Anda telah bergabung bersama Kami, dengan No ID :  ' . $idanggota . ' <br> Untuk saat ini Data anda sedang dalam Prosess Verifikasi mohon ditunggu Max 3 X 24 Jam untuk aktivasi akun anda. <br> Fulusme adalah Layanan Urun Dana (SCF) yang berbasis Teknologi <br>Silahkan klik tautan aktivasi Email dibawah ini : <br> </p> 
				<a href="' . base_url('') . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi!</a> <br> Regards <br> Fulusme');
		} else if ($type == 'forgot') {
			$this->email->subject("Reset Password");
			$this->email->message('<p> Hello ' . $this->input->post('name') . ', click this link to reset your password ! </p> 
				<a href="' . base_url('') . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
		}


		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	function notifToAdmin($role)
	{
		$pendaftar = 'peminjam';
		if ($role == 3) {
			$pendaftar = 'pemodal';
		}

		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'ssl',
			'smtp_host' => 'fulusme.id',
			'smtp_user' => 'noreply@fulusme.id',
			'smtp_pass' => 'fulusme2022',
			'smtp_port' => 465,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];
		$this->email->initialize($config);
		$this->email->from('noreply@fulusme.id', 'fulusme Info');
		$this->email->to("chesyah@fulusme.id, chesyah@gmail.com, sinafadhiel@gmail.com");
		$this->email->subject("Notifikasi Pendaftar Baru");
		$this->email->message('<p> Seseorang baru saja bergabung dengan Fulusme sebagai ' . $pendaftar . ', untuk detailnya bisa di cek di backoffice <p>');

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {

				if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('user');
					$this->db->delete('user_token', ['email' => $email]);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						' . $email . ' Email Anda telah aktif, untuk saat ini data Anda sedang dalam Prosess Verifikasi mohon ditunggu Max 3 X 24 Jam untuk aktivasi akun Anda. <br> silahkan login kembali 
						</div>');
					redirect('auth');
				} else {
					$this->db->delete('user', ['email' => $email]);
					$this->db->delete('user_token', ['email' => $email]);
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
						aktivasi anda gagal, Token kadaluarsa! Silahkan daftar ulang email anda.
						</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Activation Failed, Wrong Token!
					</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Activation Failed, Wrong email!
				</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$email = $this->session->userdata('email');
		$this->db->update('user', ['login_status' => 0], ['email' => $email]);
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			anda telah logout, silakan login kembali!  
			</div>');
		redirect('auth');
	}

	public function blocked()
	{
		$this->load->view('auth/bloked');
	}


	public function forgotPassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Fulusme  - Forgot Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');
		} else {
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);
				$this->_sendEmail($token, 'forgot', '');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					please check your email to reset your password !
					</div>');
				redirect('auth/forgotPassword');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					email is not registered of activated!
					</div>');
				redirect('auth/forgotPassword');
			}
		}
	}

	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Reset Password Failed, Wrong Token!
					</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Reset Password Failed, Wrong email!
				</div>');
			redirect('auth');
		}
	}

	public function changePassword()
	{

		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		} else {
			$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
				'matches' => 'password don\'t match!',
				'min_length' => 'password too short'
			]);
			$this->form_validation->set_rules('password2', 'Retype Password', 'required|trim|min_length[3]|matches[password1]');
			if ($this->form_validation->run() == false) {
				$data['title'] = 'Fulusme - Change Password';
				$this->load->view('templates/auth_header', $data);
				$this->load->view('auth/reset-password');
				$this->load->view('templates/auth_footer');
			} else {
				$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
				$email = $this->session->userdata('reset_email');
				$this->db->set('password', $password);
				$this->db->where('email', $email);
				$this->db->update('user');
				$this->db->delete('user_token', ['email' => $email]);
				$this->session->unset_userdata('reset_email');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Password has been change, please login!
					</div>');
				redirect('auth');
			}
		}
	}
}
