<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// is_logged_in();
		if (!$this->session->userdata('role_id') == 2 || !$this->session->userdata('role_id') == 3 || !$this->session->userdata('role_id') == 4) {
			redirect('auth');
		}
	}
	public function index()
	{
	}

	// public function addproyek($type = null)
	// {
	// 	if ($type > 2) {
	// 		redirect('user');
	// 	}
	// 	$this->__addproject($type);
	// }

	public function addproyekretail()
	{
		$this->__addprojectretail();
	}


	public function addproyek($type = null)
	{
		if ($type > 2) {
			redirect('user');
		}
		if ($type == 2) :
			$this->form_validation->set_rules('pemberi_project', 'Pemberi Proyek', 'required', ['required' => 'Masukan Nama Proyek tidak boleh kosong']);
			$this->form_validation->set_rules('jenis_instansi_project', 'Jenis Instansi Pemberi Proyek', 'required', ['required' => 'Masukan Lokasi Proyek tidak boleh kosong']);
			$this->form_validation->set_rules('kota_pemberi_project', 'Kota Project', 'required', ['required' => 'Masukan Asal Kota Pemberi Proyek tidak boleh kosong']);
			$this->form_validation->set_rules('alamat_pemberi_project', 'alamat  Pemberi proyek', 'required', ['required' => 'Data tidak boleh kosong']);
			$this->form_validation->set_rules('web_pemberi_project', 'Keuntungan Project', 'required', ['required' => 'Data tidak boleh kosong']);
			if (empty($_FILES['spk']['name'])) {
				$this->form_validation->set_rules('spk', 'SPK', 'required', ['required' => 'SPK tidak boleh kosong']);
			}
			if (empty($_FILES['loa']['name'])) {
				$this->form_validation->set_rules('loa', 'LOA', 'required', ['required' => 'Loa tidak boleh kosong']);
			}
			if (empty($_FILES['kontrak']['name'])) {
				$this->form_validation->set_rules('kontrak', 'Contract', 'required', ['required' => 'Kontrak tidak boleh kosong']);
			}
			if (empty($_FILES['sert_file']['name'])) {
				$this->form_validation->set_rules('sert_file', 'Support Document (proposal)', 'required', ['required' => 'File sertifikat tidak boleh kosong']);
			}
		endif;
		// 1
		if (empty($_FILES['rekening_koran']['name'])) {
			$this->form_validation->set_rules('rekening_koran', 'Bank Statement', 'required', ['required' => 'Rekening Koran tidak boleh kosong']);
		}
		// 2
		if (empty($_FILES['profil_perusahaan']['name'])) {
			$this->form_validation->set_rules('profil_perusahaan', 'Company Profile', 'required', ['required' => 'Profil perusahaan tidak boleh kosong']);
		}
		// 3
		if (empty($_FILES['laporan_keuangan']['name'])) {
			$this->form_validation->set_rules('laporan_keuangan', 'Financial Report', 'required', ['required' => 'Laporan keuangan tidak boleh kosong']);
		}
		// 4
		if (empty($_FILES['dokumen_pendukung']['name'])) {
			$this->form_validation->set_rules('dokumen_pendukung', 'Support Document (proposal)', 'required', ['required' => 'Dokumen pendukung tidak boleh kosong']);
		}
		$this->form_validation->set_rules('nama_project', 'Nama Project', 'required', ['required' => 'Masukan Nama Proyek tidak boleh kosong']);
		$this->form_validation->set_rules('deskripsi_project', 'Deskripsi Project', 'required', ['required' => 'Masukan Deskripsi Proyek tidak boleh kosong']);
		$this->form_validation->set_rules('deadline', 'Deadline Project', 'required', ['required' => 'Masukan Deadline Proyek tidak boleh kosong']);
		$this->form_validation->set_rules('lokasi_project', 'Lokasi Project', 'required', ['required' => 'Masukan Lokasi Proyek tidak boleh kosong']);

		$this->form_validation->set_rules('modal_project', 'Modal Project', 'required|callback_numeric_wcomma', ['required' => 'Data tidak boleh kosong']);
		$this->form_validation->set_rules('keuntungan', 'Keuntungan Project', 'required|callback_numeric_wcomma', ['required' => 'Data tidak boleh kosong']);
		$this->form_validation->set_rules('range', 'Hari Pinjaman', 'required|callback_phone', ['required' => 'Data tidak boleh kosong']);
		$this->form_validation->set_rules('jenis_jaminan', 'Jenis Jaminan', 'required', ['required' => 'Jenis jaminan tidak boleh kosong']);
		$this->form_validation->set_rules('nomor_sertifikat', 'Jenis Jaminan', 'required', ['required' => 'Jenis jaminan tidak boleh kosong']);



		if ($this->form_validation->run() == false) {
			if ($type == 1) :
				$data['title'] = 'Tambah Proyek efek ekuitas';
			else :
				$data['title'] = 'Tambah Proyek efek hutang';
			endif;
			$data['type'] = $type;
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['role'] = $this->db->get('user_role')->result_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('project/add', $data);
			$this->load->view('templates/footer');
		} else {
			list($day, $month, $year) = explode('/', $this->input->post('deadline'));
			$usedob = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));

			$id_pro =  $this->randomNumber(12);
			$project = [
				"id" => $id_pro,
				"peminjam_id" => $this->input->post('id'),
				"nama_project" => $this->input->post('nama_project'),
				"deskripsi_project" => $this->input->post('deskripsi_project'),
				"deadline" => $usedob,
				"lokasi_project" => $this->input->post('lokasi_project'),
				"create_ts" => time(),
				"modal_project" => str_replace(".", "", $this->input->post('modal_project')),
				"keuntungan" => $this->input->post('keuntungan'),
				"crowdfound_period" => 14,
				"tenor" => $this->input->post('range'),
				"status" => 0,
				"type" => $this->input->post('type')
			];

			if ($type == 2) :
				$project_info = [
					"project_id" => $id_pro,
					"pemberi_project" => $this->input->post('pemberi_project'),
					"jenis_instansi_project" => $this->input->post('jenis_instansi_project'),
					"kota_pemberi_project" => $this->input->post('kota_pemberi_project'),
					"alamat_pemberi_project" => $this->input->post('alamat_pemberi_project'),
					"web_pemberi_project" => $this->input->post('web_pemberi_project'),
					"jenis_jaminan" => $this->input->post('jenis_jaminan'),
					"no_sertifikat" => $this->input->post('nomor_sertifikat'),

				];
			else :
				$project_info = [
					"project_id" => $id_pro,
					"pemberi_project" => null,
					"jenis_instansi_project" => null,
					"kota_pemberi_project" => null,
					"alamat_pemberi_project" => null,
					"web_pemberi_project" => null,
					"jenis_jaminan" => $this->input->post('jenis_jaminan'),
					"no_sertifikat" => $this->input->post('nomor_sertifikat'),

				];
			endif;

			$project_document = [
				"project_id" => $id_pro
			];

			// ekuitas
			$upload_image4 = $_FILES['rekening_koran']['name'];
			$upload_image5 = $_FILES['profil_perusahaan']['name'];
			$upload_image6 = $_FILES['laporan_keuangan']['name'];
			$upload_image7 = $_FILES['dokumen_pendukung']['name'];


			if ($type == 2) :
				$upload_image = $_FILES['spk']['name'];
				if ($upload_image) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '6048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('spk')) {
						$new_image = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r($this->upload->display_errors());
						// 	redirect('user');   
					}

					$project_document["spk"] = $new_image;
				}

				$upload_image2 = $_FILES['loa']['name'];
				if ($upload_image2) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '6048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('loa')) {
						$new_image = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r($this->upload->display_errors());
						// 	redirect('user');   
					}

					$project_document["loa"] = $new_image;
				}

				$upload_image3 = $_FILES['kontrak']['name'];
				if ($upload_image3) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '6048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('kontrak')) {
						$new_image = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r($this->upload->display_errors());
						// 	redirect('user');   
					}

					$project_document["kontrak"] = $new_image;
				}

				$upload_image8 = $_FILES['sert_file']['name'];
				if ($upload_image8) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '6048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('sert_file')) {
						$new_image = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r($this->upload->display_errors());
						// 	redirect('user');   
					}

					$project_document["jaminan"] = $new_image;
				}

			endif;

			// ekuitas
			if ($upload_image4) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '6048';
				$new_image = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('rekening_koran')) {
					$new_image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r($this->upload->display_errors());
					// 	redirect('user');   
				}

				$project_document["rekening_koran"] = $new_image;
			}

			if ($upload_image5) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '6048';
				$new_image = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('profil_perusahaan')) {
					$new_image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r($this->upload->display_errors());
					// 	redirect('user');   
				}

				$project_document["profil_perusahaan"] = $new_image;
			}

			if ($upload_image6) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '6048';
				$new_image = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('laporan_keuangan')) {
					$new_image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r($this->upload->display_errors());
					// 	redirect('user');   
				}

				$project_document["laporan_keuangan"] = $new_image;
			}


			if ($upload_image7) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '6048';
				$new_image = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('dokumen_pendukung')) {
					$new_image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r($this->upload->display_errors());
					// 	redirect('user');   
				}

				$project_document["dokumen_pendukung"] = $new_image;
			}

			// print_r($project_document);
			$this->db->insert('project', $project);
			$this->db->insert('project_information', $project_info);
			$this->db->insert('project_document', $project_document);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Project added! 
				</div>');
			$this->_sendEmailAdmin($id_pro, $this->input->post('nama_project'));
			redirect('user');
		}
	}




	public function __addprojectretail()
	{


		$this->form_validation->set_rules('jumlah_pinjaman', 'Jumlah Pinjaman', 'required|callback_phone', ['required' => 'data tidak boleh kosong']);
		$this->form_validation->set_rules('tenor', 'Tenor', 'required', ['required' => 'tenor tidak boleh kosong']);



		if ($this->form_validation->run() == false) {
			$data['title'] = 'Tambah Proyek';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['role'] = $this->db->get('user_role')->result_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('project/add_retail', $data);
			$this->load->view('templates/footer');
		} else {

			$id_pro =  $this->randomNumber(12);
			$project = [
				"id_project" => $id_pro,
				"retail_id" => $this->input->post('id'),
				"id_anggota" => $this->input->post('id_anggota'),
				"status" => 0,
				"nama_toko" => $this->input->post('nama_toko'),
				"nama_pemilik" => $this->input->post('nama_pemilik'),
				"jumlah_pinjaman" => $this->input->post('jumlah_pinjaman'),
				"no_hp" => $this->input->post('no_hp'),
				"tenor" => $this->input->post('tenor'),
				"foto_toko" => $this->input->post('foto_toko'),
				"create_ts" => time(),
				"ujrah" => $this->input->post('ujrah_pro'),
				"denom" => $this->input->post('denom_pro'),
				"nisbah" => $this->input->post('nisbah_pro'),
				"pengembalian_dana" => $this->input->post('pengembalian_dana_pro')
			];


			$this->db->insert('project_retail', $project);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Selamat, Proyek baru berhasil di tambahkan! 
				</div>');
			$this->_sendEmailAdmin($id_pro, $this->input->post('nama_project'));
			redirect('user');
		}
	}



	private function _sendEmailAdmin($id, $nama)
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

		$id_proyek = $id;
		$nama_proyek = $nama;
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from("noreply@fulusme.id", "fulusme Info");
		$this->email->to("project@fulusme.id");


		$this->email->subject('Konfirmasi Proyek Baru ' . $id_proyek . ', ' . $nama_proyek);
		$this->email->message('<p> Hi Admin Fulusme, silakan cek proyek baru dengan <br>
			ID : ' . $id_proyek . ' <br> 
			Nama Proyek : ' . $nama_proyek . ' <br> 
			Proyek baru ini mohon untuk di Proses di <br>
			<a href="http://devback.fulusme.com/data_peminjam/project_detail/' . $id_proyek . '"></a> backend webapp
			</p>');



		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	// $this->_sendEmail();
	private function _sendEmail()
	{
		// 		$config = [
		// 			'protocol' => 'smtp',
		// 			'smtp_host'=> 'ssl://smtp.googlemail.com',
		// 			'smtp_user'=> 'info.fulusme@gmail.com',
		// 			'smtp_pass'=> 'fulus_Me3',
		// 			'smtp_port'=> 465,
		// 			'mailtype' => 'html',
		// 			'charset'  => 'utf-8',
		// 			'newline'  => "\r\n"
		// 		];

		//     $config = [
		//  'protocol'  => 'smtp',
		//  'smtp_host' => 'ssl://backoffice.fintekmadani.id',
		//  'smtp_user' => 'admin@backoffice.fintekmadani.id',
		//  'smtp_pass' => 'Bismillah2812',
		//         'smtp_port' => 465,
		//         'mailtype'  => 'html',
		//         'charset'   => 'utf-8',
		//         'newline'   => "\r\n"
		//     ];




		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'mail.fulusme.id',
			'smtp_user' => 'noreply@fulusme.id',    // Ganti dengan email gmail kamu
			'smtp_pass' => 'fulusme2021',      // Password gmail kamu
			'smtp_port' => 587,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];

		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from("noreply@fulusme.id", "fulusme Info");
		$this->email->to($this->session->userdata('email'));


		$this->email->subject("Data Project Information");
		$this->email->message('<p> Hello ' . $this->session->userdata('name') . ', silakan upload dukumen dokumen terlampir di bawah ini untuk proses verifikasi kami, dokumen yang di butuhkan : 	

			<br> 1. SPK	<br>2. BAST	<br>3. Kontrak	<br>4. Invoice	<br>5. Rekening Koran	<br>6. Profil Perusahaan	<br>7. Laporan Keuangan	<br>8. Dokumen Pendukung, <br> Terimakasih <br> <br>

			fulusme.com
			</p>');



		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function adddokumen()
	{
		if (empty($_FILES['spk']['name'])) {
			$this->form_validation->set_rules('spk', 'SPK', 'required');
		}
		if (empty($_FILES['bast']['name'])) {
			$this->form_validation->set_rules('bast', 'BAST', 'required');
		}
		if (empty($_FILES['kontrak']['name'])) {
			$this->form_validation->set_rules('kontrak', 'Kontrak', 'required');
		}
		if (empty($_FILES['invoice']['name'])) {
			$this->form_validation->set_rules('invoice', 'Invoice', 'required');
		}
		if (empty($_FILES['rekening_koran']['name'])) {
			$this->form_validation->set_rules('rekening_koran', 'Rekening Koran', 'required');
		}
		if (empty($_FILES['profil_perusahaan']['name'])) {
			$this->form_validation->set_rules('profil_perusahaan', 'Profil Perusahaan', 'required');
		}
		if (empty($_FILES['laporan_keuangan']['name'])) {
			$this->form_validation->set_rules('laporan_keuangan', 'Laporan Keuangan', 'required');
		}
		if (empty($_FILES['dokumen_pendukung']['name'])) {
			$this->form_validation->set_rules('dokumen_pendukung', 'Dokumen Pendukung', 'required');
		}

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Add Project Document';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['project'] = $this->db->get_where('project', ['peminjam_id' => $data['user']['id']])->row_array();
			$data['role'] = $this->db->get('user_role')->result_array();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('project/add_dokumen', $data);
			$this->load->view('templates/footer');
		} else {
			$upload_image = $_FILES['spk']['name'];
			if ($upload_image) {
				$config['upload_path']   = base_url() . '/assets/file_user/spk/';
				$config['allowed_types'] = 'pdf';
				$config['max_size']      = '6048';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('spk')) {
					$spk = $this->upload->data('spk');
					$this->db->set('spk', $spk);
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					redirect('user');
				}
			}
		}
	}


	function randomNumber($length)
	{
		$result = '';

		for ($i = 0; $i < $length; $i++) {
			if ($i == 1) {
				$result .= mt_rand(1, 9);
			} else {
				$result .= mt_rand(0, 9);
			}
		}

		return $result;
	}



	public function phone($str)
	{
		if (!preg_match("/^[[0-9]{1,4}[-0-9]*$/", $str)) {
			$this->form_validation->set_message('phone', 'Masukan {field} tidak dalam format yang benar');
			return FALSE;
		} else {
			return TRUE;
		}
	}


	function numeric_wcomma($str)
	{
		if (preg_match('/^[0-9.]+$/', $str)) {
			return $str;
		};
	}
}
