<?php

class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
			$this->auth->check_user_authentification(1);
		}
		$this->load->model('user_model');
		$this->load->model('level_model');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
	}

	function index()
	{
		$data['title'] = $this->lang->line('display_pengguna');
		$data['main_content'] = 'user/display';
		$data['user_data'] = $this->user_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}

	function add()
	{
		$data['title'] = $this->lang->line('tambah_pengguna');
		$data['main_content'] = 'user/form';
		$data['act'] = 'add';
		$data['lokasi_data'] = $this->user_model->get_data_lokasi();
		$data['level_data'] = $this->level_model->get_all_data();
		$data['form_act'] = 'insert';
		$data['user_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('lihat_pengguna');
		$data['main_content'] = 'user/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$data['user_data'] = $this->user_model->get_data_by_id($id);
		$data['level_data'] = $this->level_model->get_all_data();
		$data['lokasi_data'] = $this->user_model->get_data_lokasi();
		$this->load->view('template/template_xpanel', $data);
	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('edit_pengguna');
		$data['main_content'] = 'user/form';
		$data['act'] = 'edit';
		$data['form_act'] = 'update/' . $id;
		$data['user_data'] = $this->user_model->get_data_by_id($id);
		$data['level_data'] = $this->level_model->get_all_data();
		$data['lokasi_data'] = $this->user_model->get_data_lokasi();
		$this->load->view('template/template_xpanel', $data);
	}

	function insert()
	{
		$this->user_model->fill_data();
		//Cek Login
		if (!$this->user_model->check_username()) {
			$this->session->set_userdata('message', 'Username telah digunakan');
			$this->add();
		}
		//Insert Data
		elseif ($this->user_model->insert_data()) {
			$this->session->set_userdata('message', 'Register pengguna baru sukses ;)');
			redirect('user');
		}
	}

	function update()
	{
		$id = $this->uri->segment(3);
		$updatePass = (is_null($this->input->post("reset_pass")) ? 0 : $this->input->post("reset_pass"));
		if (!$this->_user_validation($updatePass)) {
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->session->set_flashdata('message', validation_errors());

			$this->edit();
		} else {
			$this->user_model->fill_data();
			//Cek Login
			if (!$this->user_model->check_username($id)) {
				$this->session->set_userdata('ERRMSG_ARR', 'Username telah digunakan');
				$this->edit();
			}
			//Update Data
			elseif ($this->user_model->update_data($id)) {
				$this->session->set_userdata('SUCCESSMSG', 'Update pengguna sukses ;)');
				$this->session->set_flashdata('message', "<h4>Update pengguna sukses !</h4>");
				if (!$this->session->userdata('ADMIN')) {
					redirect('user/edit/' . $id);
				} else {
					redirect('user');
				}
			}
		}
	}

	function delete()
	{
		$id = $this->input->post('id');
		$user_data = $this->user_model->get_data_by_id($id);
		if ($this->user_model->delete_data($id)) {
			$msg = 'S#User ' . $user_data['nama_depan'] . ' ' . $user_data['nama_belakang'] . ' telah dihapus.';
		} else {
			$msg .= 'E#Terjadi kesalahan dalam menghapus data user ' . $user_data['nama_depan'] . ' ' . $user_data['nama_belakang'] . '. Harap coba lagi.';
		}
		echo $msg;
	}

	function _user_validation($edit = 0)
	{
		$this->form_validation->set_rules('fname', 'Nama Depan', 'trim|required');
		$this->form_validation->set_rules('lname', 'Nama Belakang', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		if ($edit != 0) {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[cpassword]');
			$this->form_validation->set_rules('cpassword', 'Ulangi Password', 'trim|required');
		}

		return $this->form_validation->run();
	}

	function token()
	{
		// $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
		$this->form_validation->set_rules('password1', 'Password Baru', 'required|trim|matches[password2]');
		$this->form_validation->set_rules('password2', 'Ulangi Passworrd', 'required|trim|matches[password1]');


		if ($this->form_validation->run() == false) {

			$data['title'] = "Form Auth Password";
			$data['main_content'] = 'user/form_token';
			$this->load->view('template/template_xpanel', $data);
		} else {

			$user = $this->session->userdata['username'];
			$query = $this->db->get_where('login', ['username' => $user])->row();
			$token = base64_decode($query->token);
			$password_lama = $this->input->post('password_lama');
			$password1 = base64_encode($this->input->post('password1'));

			if ($password_lama == $token) {
				$data = [
					'token' => $password1
				];
				$this->db->where('username', $user);
				$this->db->update('login', $data);
				$this->session->set_flashdata('message', '
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					Password Berhasil Diganti
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
				    </button>
					</div>
					');

				redirect('user/token');
			} else {
				$this->session->set_flashdata('message', '
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Password Lama Salah
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
				    </button>
					</div>
					');

				redirect('user/token');
			}
		}
	}
}
/* End of file user.php */
/* Location: ./application/CI_Controllers/user.php */
