<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}


	public function index()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => 'password don\'t match!',
			'min_length' => 'password too short'
		]);
		$this->form_validation->set_rules('password2', 'Retype Password', 'required|trim|min_length[3]|matches[password1]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('role', 'Role', 'required');


		if ($this->form_validation->run() == false) {
			$data['title'] = 'User';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$this->db->select('*,user.id as userID');
			$this->db->from('user');
			$this->db->join('user_role', 'user_role.id = user.role_id');
			$coba = $this->db->get()->result_array();

			$data['user_all'] = $coba;

			$data['role'] = $this->db->get('user_role')->result_array();
			// var_dump($data['user']);
			// die;
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('admin/index', $data);
			$this->load->view('templates/footer');
		} elseif ($this->input->post('id')) {
			if ($this->input->post('del')) {
				$this->db->where('email', $this->input->post('id'));
				$this->db->delete('user');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			User deleted! 
				</div>');
				redirect('admin');
			} else {
				if ($this->input->post('is_active') && $this->input->post('is_active') == 1) {
					$activation = $this->input->post('is_active');
				} else {
					$activation = 0;
				}
				$data = [
					'name' => htmlspecialchars($this->input->post('name', true)),
					'email' => htmlspecialchars($this->input->post('email', true)),
					'image' => 'default.jpg',
					'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
					'role_id' => $this->input->post('role'),
					'is_active' => $activation,
					'date_created' => time()
				];

				$this->db->where('email', $this->input->post('id'));
				$this->db->update('user', $data);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			User edited! 
				</div>');
				redirect('admin');
			}
		} else {
			$activation = 0;
			if ($this->input->post('is_active')) {
				$activation = $this->input->post('is_active');
			}
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => $this->input->post('role'),
				'is_active' => $activation,
				'date_created' => time()
			];
			$this->db->insert('user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  			New user added! 
			</div>');
			redirect('admin');
		}
	}

	public function video()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		if (empty($_FILES['video']['name'])) {
			$this->form_validation->set_rules('video', 'Video', 'required', ['required' => 'Video tidak boleh kosong']);
		}

		if ($this->form_validation->run() == false) {
			$data['title'] = 'User';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$this->db->select('*');
			$this->db->from('user');
			$this->db->join('user_role', 'user_role.id = user.role_id');
			$coba = $this->db->get()->result_array();

			$data['user_all'] = $coba;

			$this->db->select('*');
			$this->db->from('video_cms');
			$videoall = $this->db->get()->result_array();

			$data['video_all'] = $videoall;

			$data['role'] = $this->db->get('user_role')->result_array();
			// var_dump($data['user']);
			// die;
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('admin/video', $data);
			$this->load->view('templates/footer');
		} else {

			$data = [
				'nama' => htmlspecialchars($this->input->post('nama', true))
			];
			$upload_image = $_FILES['video']['name'];

			if ($upload_image) {
				$config['upload_path']   = 'assets/video/';
				$config['allowed_types'] = 'mp4';
				$config['max_size']      = '31048';
				$new_image = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('video')) {
					$new_image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r("expression");
					redirect('admin/video');
				}

				$data["url"] = "video/" . $new_image;
			}

			$this->db->insert('video_cms', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  			Video Baru Ditambah! 
			</div>');
			redirect('admin/video');
		}
	}

	public function role()
	{

		$this->form_validation->set_rules('role', 'Role', 'required');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Role';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['role'] = $this->db->get('user_role')->result_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer');
		} elseif ($this->input->post('id')) {
			if ($this->input->post('del')) {
				$this->db->where('id', $this->input->post('id'));
				$this->db->delete('user_role');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			Role deleted! 
				</div>');
				redirect('admin/role');
			} else {
				$this->db->set('role', $this->input->post('role'));
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('user_role');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			Role edited! 
				</div>');
				redirect('admin/role');
			}
		} else {
			$this->db->insert('user_role', ['role' => $this->input->post('role')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  			New role added! 
			</div>');
			redirect('admin/role');
		}
	}

	public function roleaccess($role_id)
	{
		$data['title'] = 'Role';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
		$this->db->where('id != ', 1);
		$data['menu'] = $this->db->get('user_menu')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('admin/role-access', $data);
		$this->load->view('templates/footer');
	}

	public function changeAccess()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $this->db->get_where('user_access_menu', $data);

		if ($result->num_rows() < 1) {
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  			Access Change! 
			</div>');
	}

	public function menuname()
	{
		$menu_id = $this->input->post('menu');
		return $menu_id;
	}
}
