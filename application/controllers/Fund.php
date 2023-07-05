<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fund extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		
	}

	public function index(){



		$data['title'] = 'Daftar Pengajuan Tertunda';
		$this->db->select('*');
		$this->db->from('project');
		$this->db->where('status', 0);
		$this->db->join('project_information', 'project_information.project_id = project.id');
		$this->db->join('user', 'user.id = project.peminjam_id');
		$coba = $this->db->get()->result_array();

		$data['project'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('fund/index', $data);
		$this->load->view('templates/footer');
	}


	public function ongoing(){



		$data['title'] = 'Daftar Pengajuan yang Berjalan';
		$this->db->select('*');
		$this->db->from('project');
		$this->db->where('status', 1);
		$this->db->join('project_information', 'project_information.project_id = project.id');
		$this->db->join('user', 'user.id = project.peminjam_id');
		$coba = $this->db->get()->result_array();
		$data['project'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('fund/indexOngoing', $data);
		$this->load->view('templates/footer');
	}



	public function rejected(){


		$data['title'] = 'Daftar Pengajuan yang Ditolak';
		$this->db->select('*');
		$this->db->from('project');
		$this->db->where('status', 3);
		$this->db->join('project_information', 'project_information.project_id = project.id');
		$this->db->join('user', 'user.id = project.peminjam_id');
		$coba = $this->db->get()->result_array();

		$data['project'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('fund/indexRejected', $data);
		$this->load->view('templates/footer');
	}




	public function app(){

	}


	public function rincianproject(){
		$data['title'] = 'Rincian Pengajuan';
		$this->db->select('*');
		$this->db->from('project');
		$this->db->where('project_id', $this->input->get('id'));
		$this->db->join('project_information', 'project_information.project_id = project.id');
		$this->db->join('user', 'user.id = project.peminjam_id');
		$coba = $this->db->get()->result_array();
		$data['project'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('id', 'Id', 'required');
		$this->form_validation->set_rules('modal_project', 'Modal Project', 'required');
		$this->form_validation->set_rules('range_project', 'Range Project', 'required');
		$this->form_validation->set_rules('presentasi_keuntungan', 'Presentasi Keuntungan', 'required');
		if (empty($_FILES['image']['name']))
		{
			$this->form_validation->set_rules('image', 'Project Photo', 'required');
		}

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('fund/rincian_project', $data);
			$this->load->view('templates/footer');

		}else{
			if($this->input->post("reject")){
				$this->db->set('status', 3);
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('project');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Project ditolak! 
					</div>');
				redirect('fund');
			}else{
				$upload_image = $_FILES['image']['name'];
				$perubahan = [
					"modal_project" => $this->input->post('modal_project'),
					"range_project" => $this->input->post('range_project'),
					"keuntungan" => $this->input->post('presentasi_keuntungan'),
					"status" => 1
				];

				if ($upload_image) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size']      = '2048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('image'))
					{
						$new_image = $this->upload->data('file_name');
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						redirect('fund');   
					}

					$perubahan["image"] = $new_image;
				}
				$this->db->set($perubahan);
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('project');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Project disetujui! 
					</div>');
				redirect('fund');

			}



		}
	}

	public function rincianacc(){
		$data['title'] = 'Rincian Pengajuan Berjalan';
		$this->db->select('*');
		$this->db->from('project');
		$this->db->where('status', 1);
		$this->db->where('project_id', $this->input->get('id'));
		$this->db->join('project_information', 'project_information.project_id = project.id');
		$this->db->join('user', 'user.id = project.peminjam_id');
		$coba = $this->db->get()->result_array();
		$data['project'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('id', 'Id', 'required');
		$this->form_validation->set_rules('spk', 'SPK', 'required');
		$this->form_validation->set_rules('bast', 'BAST', 'required');
		$this->form_validation->set_rules('kontrak', 'Kontrak', 'required');
		$this->form_validation->set_rules('invoice', 'Invoice', 'required');
		$this->form_validation->set_rules('rekening_koran', 'Rekening Koran', 'required');
		$this->form_validation->set_rules('profil_perusahaan', 'Profil Perusahaan', 'required');
		$this->form_validation->set_rules('laporan_keuangan', 'Laporan Keuangan', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('fund/rincian_project', $data);
			$this->load->view('templates/footer');

		}else{
			if($this->input->post("reject")){
				$this->db->set('status', 3);
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('project');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Proyek ditolak! 
					</div>');
				redirect('fund');
			}else{

				$dokumen = [
					"spk" => 1,
					"bast" => 1,
					"kontrak" => 1,
					"invoice" => 1,
					"rekening_koran" =>1,
					"profil_perusahaan" => 1,
					"laporan_keuangan" => 1,
					"dokumen_pendukung" => 1,
					"project_id" => $this->input->post('id')
				];
				print_r($dokumen);
				die;
				$this->db->insert('project_document', $dokumen);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Project disetujui! 
					</div>');
				redirect('fund');

			}



		}
	}

	public function rincianreject(){
		$data['title'] = 'Daftar Pengajuan Ditolak';
		$this->db->select('*');
		$this->db->from('project');
		$this->db->where('status', 3);
		$this->db->where('project_id', $this->input->get('id'));
		$this->db->join('project_information', 'project_information.project_id = project.id');
		$this->db->join('user', 'user.id = project.peminjam_id');
		$coba = $this->db->get()->result_array();
		$data['project'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('id', 'Id', 'required');
		$this->form_validation->set_rules('spk', 'SPK', 'required');
		$this->form_validation->set_rules('bast', 'BAST', 'required');
		$this->form_validation->set_rules('kontrak', 'Kontrak', 'required');
		$this->form_validation->set_rules('invoice', 'Invoice', 'required');
		$this->form_validation->set_rules('rekening_koran', 'Rekening Koran', 'required');
		$this->form_validation->set_rules('profil_perusahaan', 'Profil Perusahaan', 'required');
		$this->form_validation->set_rules('laporan_keuangan', 'Laporan Keuangan', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('fund/rincian_project', $data);
			$this->load->view('templates/footer');

		}else{
			if($this->input->post("reject")){
				$this->db->set('status', 3);
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('project');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Project ditolak! 
					</div>');
				redirect('fund');
			}else{

				$dokumen = [
					"spk" => 1,
					"bast" => 1,
					"kontrak" => 1,
					"invoice" => 1,
					"rekening_koran" =>1,
					"profil_perusahaan" => 1,
					"laporan_keuangan" => 1,
					"dokumen_pendukung" => 1,
					"project_id" => $this->input->post('id')
				];
				print_r($dokumen);
				die;
				$this->db->insert('project_document', $dokumen);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Project disetujui! 
					</div>');
				redirect('fund');

			}



		}
	}
}