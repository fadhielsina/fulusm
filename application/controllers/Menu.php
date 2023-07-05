<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}
	public function index()
	{

		$this->form_validation->set_rules('menu', 'Menu', 'required');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Menu Management';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['menu'] = $this->db->get('user_menu')->result_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('menu/index', $data);
			$this->load->view('templates/footer');
		}elseif($this->input->post('id')) {
			if($this->input->post('del')){
				$this->db->where('id', $this->input->post('id'));
				$this->db->delete('user_menu');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			Menu deleted! 
				</div>');
				redirect('menu');
			}else{
				$this->db->set('menu', $this->input->post('menu') );
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('user_menu');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			Menu edited! 
				</div>');
				redirect('menu');
			}
		} else{
			$this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  			New menu added! 
			</div>');
			redirect('menu');
		}
		
	}


	public function submenu()
	{
		$data['title'] = 'Submenu Management';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->model('Menu_model', 'menu');
		$data['subMenu'] = $this->menu->getSubMenu();
		$data['menu'] = $this->db->get('user_menu')->result_array();

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('menu_id', 'Menu', 'required');
		$this->form_validation->set_rules('url', 'URL', 'required');
		$this->form_validation->set_rules('icon', 'Icon', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('menu/submenu', $data);
			$this->load->view('templates/footer');
		}elseif($this->input->post('id')) {
			

			if($this->input->post('del')){
				$this->db->where('id', $this->input->post('id'));
				$this->db->delete('user_sub_menu');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			Sub menu deleted! 
				</div>');
				redirect('menu/submenu');

			}else{
				$activation = 0;
			if($this->input->post('is_active')){
				$activation = $this->input->post('is_active');
			}

				$data = [
					'title' => $this->input->post('title'),
					'menu_id' => $this->input->post('menu_id'),
					'url' => $this->input->post('url'),
					'icon' => $this->input->post('icon'),
					'is_active' => $activation
				];

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('user_sub_menu', $data);


				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
	  			Sub menu edited! 
				</div>');
				redirect('menu/submenu');
			}
		}else{
			$activation = 0;
			if($this->input->post('is_active')){
				$activation = $this->input->post('is_active');
			}
			$data = [
				'title' => $this->input->post('title'),
				'menu_id' => $this->input->post('menu_id'),
				'url' => $this->input->post('url'),
				'icon' => $this->input->post('icon'),
				'is_active' => $activation
			];
			$this->db->insert('user_sub_menu', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  			New sub menu added! 
			</div>');
			redirect('menu/submenu');

		}
	}
}