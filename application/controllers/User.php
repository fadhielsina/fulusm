<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// is_logged_in();
		if (!$this->session->userdata('role_id') == 2 || !$this->session->userdata('role_id') == 3 || !$this->session->userdata('role_id') == 4 || !$this->session->userdata('role_id') == 5) {
			redirect('auth');
		}
		$this->db_back = $this->load->database('back', TRUE);
	}

	public function payment_dummy()
	{
		$id_pendana = $this->db->get_where('pendana', ['email' => $this->session->userdata('email')])->row()->id;
		$data['list_pendanaan'] = $this->db->get_where('pendanaan', ['pendana_id' => $id_pendana])->result_array();
		$this->load->view('test_camera', $data);
	}

	function postPayment($id = null)
	{
		$pendanaan = $this->db->get_where('pendanaan', ['id' => $id])->row();
		$nomor_va = $pendanaan->nomor_va;
		$pendana_id = $pendanaan->pendana_id;
		$id_project = $pendanaan->project_id;

		$this->db->update('pendanaan', ['status' => 1, 'paid_ts' => time()], ['id' => $id]);
		$this->db_back->where('id_project', $id_project)->where('virtual_account', $nomor_va)->where('customer_id', $pendana_id)
			->update('virtual_account', ['response_code' => '000001']);
		redirect('user/payment_dummy');
	}


	public function index()
	{
		$data['title'] = 'Dashboard';
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where("email", $this->session->userdata('email'));
		$this->db->join('user_role', 'user_role.id = user.role_id');
		$coba = $this->db->get()->row_array();
		$data['user_all'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);

		if ($this->session->userdata('role_id') == 2) {
			$this->addPeminjam($data);
		} elseif ($this->session->userdata('role_id') == 3) {
			$this->pilihStatusPendana();
		} elseif ($this->session->userdata('role_id') == 4 || $this->session->userdata('role_id') == 5) {
			$this->addRetail($data);
		}
		$this->load->view('templates/footer');
	}


	public function profile()
	{
		$data['title'] = 'Profil Saya';
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where("email", $this->session->userdata('email'));
		$this->db->join('user_role', 'user_role.id = user.role_id');
		$coba = $this->db->get()->row_array();
		$data['user_all'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer');
	}



	public function rdlpendana()
	{
		$data['title'] = 'Rekening Kustodian';
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where("email", $this->session->userdata('email'));
		$this->db->join('user_role', 'user_role.id = user.role_id');
		$coba = $this->db->get()->row_array();
		$data['user_all'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if ($this->session->userdata('role_id') != 3) {
			redirect('auth');
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/rdlpendana', $data);
		$this->load->view('templates/footer');
	}


	public function edit()
	{
		$data['title'] = 'Ubah Profil';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('name', 'nama lengkap', 'required|trim');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');
		} else {
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			$upload_image = $_FILES['foto']['name'];
			if ($upload_image) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']      = '5048';
				$config['file_name']     = 'profile' . time();

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('foto')) {
					$old_image = $data['user']['image'];
					if ($old_image != 'default.jpg') {
						$file_old = FCPATH . 'assets/img/profile/' . $old_image;
						if (file_exists($file_old)) :
							unlink($file_old);
						endif;
					}
					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					redirect('user/profile');
				}
			}
			$this->db->set('name', $name);
			$this->db->where('email', $email);
			$this->db->update('user');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				profil anda telah berubah!
				</div>');
			redirect('user/profile');
		}
	}


	public function changepassword()
	{
		$data['title'] = 'Ubah Kata Sandi';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
		$this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('user/changepassword', $data);
			$this->load->view('templates/footer');
		} else {
			$current_password = $this->input->post('current_password');
			$new = $this->input->post('new_password1');
			if (!password_verify($current_password, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Wrong current password!
					</div>');
				redirect('user/changepassword');
			} else {
				if ($current_password == $new) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
						New Password should not be same with old password!
						</div>');
					redirect('user/changepassword');
				} else {
					$password_hash = password_hash($new, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$this->db->where('email', $this->session->userdata('email'));
					$this->db->update('user');

					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						Password Change!
						</div>');
					redirect('user/changepassword');
				}
			}
		}
	}


	public function setkota()
	{
		$provinsi = $this->input->post('province');
		$id = $this->db->get_where('provinces', ["name" => $provinsi])->row_array();
		$kota = $this->db->get_where('regencies', ["province_id" => $id["id"]])->result_array();
		print_r(json_encode($kota));
	}

	public function getidpesertakop()
	{
		$koperasi = $this->input->post('mitra');
		$id = $this->db->get_where('koperasi', ["id_koperasi" => $koperasi])->row_array();
		$mitrakoperasi = $this->db->get_where('peserta_koperasi', ["id_koperasi" => $id["id_koperasi"]])->result_array();
		print_r(json_encode($mitrakoperasi));
	}


	public function setkecamatan()
	{
		$kota = $this->input->post('kota');
		$id = $this->db->get_where('regencies', ["name" => $kota])->row_array();
		$kecamatan = $this->db->get_where('districts', ["regency_id" => $id["id"]])->result_array();
		print_r(json_encode($kecamatan));
	}


	// ///////////////////////////////////////////////
	public function addRetail($data)
	{
		$data['peminjam'] = $this->db->get_where('retail', ['user_id' => $data['user']['id']])->row_array();

		if (!$data['peminjam']) {
			$data['provinces'] = $this->db->get('provinces')->result_array();

			$data['mitra'] = $this->db->get('koperasi')->result_array();
			$this->form_validation->set_rules('name', 'Full Name', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('email', 'Email', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('phone', 'Nomor Hp', 'required|callback_phone', array('required' => '* mohon diisi '));
			// 			, 'phone' => '*'
			$this->form_validation->set_rules('address', 'Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('birthplace', 'Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('birthdate', 'Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('provinsi_user', 'Province', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kota_user', 'City', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kecamatan_user', 'Sub Distric', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('agama', 'Religion', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('noktp', 'ID Number', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('nokk', 'Family ID Number', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('pekerjaan', 'Ocupation', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('jenispekerjaan', 'Ocupation Type', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('pendidikan', 'Last Education', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('nama_toko', 'Toko Name', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('alamat_toko', 'Toko Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('jenisusaha', 'Jenis Usaha', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('mitra', 'Koperasi', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('idmitra', 'ID Koperasi', 'required', array('required' => '* mohon diisi '));

			if (empty($_FILES['image']['name'])) {
				$this->form_validation->set_rules('image', 'File KTP', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['imagekk']['name'])) {
				$this->form_validation->set_rules('imagekk', 'File KK', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['imagei']['name'])) {
				$this->form_validation->set_rules('imagei', 'Foto Diri', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['imagei_toko']['name'])) {
				$this->form_validation->set_rules('imagei_toko', 'Foto Toko', 'required', array('required' => '* mohon diisi '));
			}


			if ($this->form_validation->run() == false) {
				$this->load->view('templates/top_bar_no_side', $data);
				$this->load->view('user/isiPeminjamRetail', $data);
			} else {

				$personal = [
					'user_id' => $this->input->post('id'),
					'id_anggota' => $this->input->post('id_anggota'),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'gender' => $this->input->post('gender'),
					'address' => $this->input->post('address'),
					'tempat_lahir' => $this->input->post('birthplace'),
					'tanggal_lahir' => $this->input->post('birthdate'),
					'provinsi' => $this->input->post('provinsi_user'),
					'kota' => $this->input->post('kota_user'),
					'kecamatan' => $this->input->post('kecamatan_user'),
					'agama' => $this->input->post('agama'),
					'ktp' => $this->input->post('noktp'),
					'kk' => $this->input->post('nokk'),
					'nama_toko' => $this->input->post('nama_toko'),
					'alamat_toko' => $this->input->post('alamat_toko'),
					'jenis_usaha' => $this->input->post('jenisusaha'),
					'pekerjaan' => $this->input->post('pekerjaan'),
					'bidang_pekerjaan' => $this->input->post('jenispekerjaan'),
					'pendidikan' => $this->input->post('pendidikan'),
					'id_koperasi' => $this->input->post('mitra'),
					'id_anggota_koperasi' => $this->input->post('idmitra')
				];

				$upload_image = $_FILES['image']['name'];
				$upload_image2 = $_FILES['imagekk']['name'];
				$upload_image3 = $_FILES['imagei']['name'];
				$upload_image4 = $_FILES['imagei_toko']['name'];


				if ($upload_image) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('image')) {
						$new_image = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'file yang gagal di upload : file Kartu Tanda Penduduk</div>');
						print_r("expression");
						redirect('user');
					}

					$personal["ktp_file"] = $new_image;
				}


				if ($upload_image2) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('imagekk')) {
						$new_image2 = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							' file yang gagal di upload : file Kartu Keluarga</div>');
						print_r("expression");
						redirect('user');
					}
					$personal["kk_file"] = $new_image2;
				}
				if ($upload_image3) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'jpg|jpeg';
					$config['max_size']      = '2048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('imagei')) {
						$new_image3 = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						redirect('user');
					}
					$personal["foto_diri"] = $new_image3;

					$this->db->set('image',  $new_image3);
					$this->db->where('id_anggota', $this->input->post('id_anggota'));
					$this->db->update('user'); // gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2

				}

				if ($upload_image4) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'jpg|jpeg';
					$config['max_size']      = '2048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('imagei_toko')) {
						$new_image4 = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						redirect('user');
					}
					$personal["foto_toko"] = $new_image4;
				}


				$this->db->insert('retail', $personal);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Pendaftaran Berhasil! 
					</div>');
				redirect('user');
			}
		} else {



			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$data["project"] = $this->db->get_where('project_retail', ["id_anggota" => $data['user']['id_anggota']])->result_array();
			// 			print_r($data['project']);
			// 			exit();
			$data["pending_project"] =
				$this->db->get_where(
					'project_retail',
					[
						"id_anggota" => $data['user']['id_anggota'],
						"status" => 0
					]
				)->result_array();

			$data["ongoing_project"] =
				$this->db->order_by('create_ts', 'DESC')->get_where(
					'project_retail',
					[
						"id_anggota" => $data['user']['id_anggota'],
						"status" => 1
					]
				)->result_array();

			$data["finished_project"] =

				$this->db->get_where(
					'project_retail',
					[
						"id_anggota" => $data['user']['id_anggota'],
						"status" => 9
					]
				)->result_array();


			// $data["is_eligible"] = $this->db->where('id_anggota', $data['user']['id_anggota'])->or_where('status !=', 1)->or_where('status !=', 2)->or_where('status !=', 5)->or_where('status !=', 6)->or_where('status !=', 7)->or_where('status !=', 0)->get('project_retail');
			$IDANGGOTA = $data['user']['id_anggota'];
			$data["is_eligible"] = $this->db->query("SELECT * FROM `project_retail`  WHERE `id_anggota` =  $IDANGGOTA AND `status` IN ('1','2','5','6','7','0')");
			$data["rejected_project"] =

				$this->db->get_where(
					'project_retail',
					[
						"id_anggota" => $data['user']['id_anggota'],
						"status" => 3
					]
				)->result_array();

			$this->load->view('user/retailDashboard', $data);
		}
	}
	// ///////////////////////////////////////////////////



	public function addPeminjam($data)
	{
		$data['peminjam'] = $this->db->get_where('peminjam', ['user_id' => $data['user']['id']])->row_array();
		if (!$data['peminjam']) {
			$data['provinces'] = $this->db->get('provinces')->result_array();
			$this->form_validation->set_rules('gender', 'Gender', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('name', 'Full Name', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('email', 'Email', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('phone', 'Nomor Hp', 'required|callback_phone', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('address', 'Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('birthplace', 'Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('birthdate', 'Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('provinsi_user', 'Province', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kota_user', 'City', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kecamatan_user', 'Sub Distric', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('agama', 'Religion', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('noktp', 'ID Number', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('pekerjaan', 'Ocupation', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('jenispekerjaan', 'Ocupation Type', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('pendidikan', 'Last Education', 'required', array('required' => '* mohon diisi '));
			if (empty($_FILES['image_profil']['name'])) {
				$this->form_validation->set_rules('image_profil', 'Foto Profil', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['image']['name'])) {
				$this->form_validation->set_rules('image', 'Document', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['image2']['name'])) {
				$this->form_validation->set_rules('image2', 'NPWP', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['image3']['name'])) {
				$this->form_validation->set_rules('image3', 'Coorporate Certificate', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['image4']['name'])) {
				$this->form_validation->set_rules('image4', 'SIUP', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['image5']['name'])) {
				$this->form_validation->set_rules('image5', 'TDP', 'required', array('required' => '* mohon diisi '));
			}
			if (empty($_FILES['image6']['name'])) {
				$this->form_validation->set_rules('image5', 'Profil Perusahaan', 'required', array('required' => '* mohon diisi '));
			}
			//perusahaan
			$this->form_validation->set_rules('idperusahaan', 'ID Company.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('type', 'Company Type.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('perusahaan', 'Company Name.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kategoribisnis', 'Business Category.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('status_kantor', 'Description.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('jumlah_karyawan', 'Jumlah Karyawan.', 'required|callback_angka', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('tahun_berdiri', 'Tahun Berdiri.', 'required|callback_year', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('provinsi', 'Province.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kota', 'City/Regency.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kecamatan', 'Distric.', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('tlpPerusahaan', 'Nomor telepon perusahaan.', 'required|callback_phone', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('nonpwp', 'NPWP', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('rekening_perusahaan', 'Company Bank Account', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('rekening_perusahaan_nama', 'Company Bank Account Name', 'required|matches[perusahaan]', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required', array('required' => '* mohon diisi '));


			if ($this->form_validation->run() == false) {
				$this->load->view('templates/top_bar_no_side', $data);
				$this->load->view('user/isiPeminjam', $data);
			} else {
				$img = $_POST['image_profil'];
				$folderPath = "assets/img/profile/";
				$image_parts = explode(";base64,", $img);
				$image_base64 = base64_decode($image_parts[1]);
				$fileName = 'profile' . $this->input->post('id') . '.png';

				$file_profile = $folderPath . $fileName;
				file_put_contents($file_profile, $image_base64);

				$personal = [
					'user_id' => $this->input->post('id'),
					'name' => $this->input->post('name'),
					'phone' => $this->input->post('phone'),
					'extention' => $this->input->post('extention'),
					'gender' => $this->input->post('gender'),
					'address' => $this->input->post('address'),
					'tempat_lahir' => $this->input->post('birthplace'),
					'tanggal_lahir' => $this->input->post('birthdate'),
					'jenis_pengguna' => 1,
					'provinsi' => $this->input->post('provinsi_user'),
					'kota' => $this->input->post('kota_user'),
					'kecamatan' => $this->input->post('kecamatan_user'),
					'agama' => $this->input->post('agama'),
					'ktp' => $this->input->post('noktp'),
					'pekerjaan' => $this->input->post('pekerjaan'),
					'bidang_pekerjaan' => $this->input->post('jenispekerjaan'),
					'pendidikan' => $this->input->post('pendidikan')
				];
				$company = [
					"id_badan_hukum" => $this->input->post('idperusahaan'),
					"tipe_perusahaan" => $this->input->post('type'),
					"nama_perusahaan" => $this->input->post('perusahaan'),
					"kategori_bisnis" => $this->input->post('kategoribisnis'),
					"status_kantor" => $this->input->post('status_kantor'),
					"jumlah_karyawan" => $this->input->post('jumlah_karyawan'),
					"tahun_berdiri" => $this->input->post('tahun_berdiri'),
					"provinsi" => $this->input->post('provinsi'),
					"kota" => $this->input->post('kota'),
					"kecamatan" => $this->input->post('kecamatan'),
					"no_tlp" => $this->input->post('tlpPerusahaan'),
					"alamat_website" => $this->input->post('alamatWeb'),
					"peminjam_id" => $this->input->post('id'),
					"rekening_perusahaan" => $this->input->post('rekening_perusahaan'),
					"rekening_perusahaan_nama" => $this->input->post('rekening_perusahaan_nama'),
					"bank_name" => $this->input->post('bank_name'),
					"npwp" => $this->input->post('nonpwp')
				];




				$upload_image = $_FILES['image']['name'];
				$upload_image2 = $_FILES['image2']['name'];
				$upload_image3 = $_FILES['image3']['name'];
				$upload_image4 = $_FILES['image4']['name'];
				$upload_image5 = $_FILES['image5']['name'];


				if ($upload_image) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$config['file_name']     = 'ktp' . time();
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('image')) {
						$new_image = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						// 		redirect('user');   
					}

					$personal["ktp_file"] = $new_image;
				}


				if ($upload_image2) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$config['file_name']     = 'npwp' . time();
					$new_image2 = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('image2')) {
						$new_image2 = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						// 		redirect('user');   
					}
					$company["npwp_file"] = $new_image2;
				}
				if ($upload_image3) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$config['file_name']     = 'akta' . time();
					$new_image3 = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('image3')) {
						$new_image3 = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						// 		redirect('user');   
					}
					$company["id_badan_hukum_file"] = $new_image3;
				}

				if ($upload_image4) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$config['file_name']     = 'siup' . time();
					$new_image4 = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('image4')) {
						$new_image4 = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						// 		redirect('user');   
					}
					$company["siup"] = $new_image4;
				}
				if ($upload_image5) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$config['file_name']     = 'tdp' . time();
					$new_image5 = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if ($this->upload->do_upload('image5')) {
						$new_image5 = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						// 		redirect('user');   
					}
					$company["tdp"] = $new_image5;
				}

				$this->db->insert('perusahaan_peminjam', $company);
				$this->db->insert('peminjam', $personal);
				$this->db->update('user', ['image' => $fileName], ['id' => $this->input->post('id')]);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Pendaftaran Berhasil! 
					</div>');
				$role = 2;
				$this->notifToAdmin($role);
				redirect('user');
			}
		} else {

			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$data["project"] = $this->db->get_where('project', ["peminjam_id" => $data['user']['id']])->result_array();
			$data["pending_project"] =
				$this->db->get_where(
					'project',
					[
						"peminjam_id" => $data['user']['id'],
						"status" => 0
					]
				)->result_array();

			$data["ongoing_project"] =
				$this->db->order_by('create_ts', 'DESC')->get_where(
					'project',
					[
						"peminjam_id" => $data['user']['id'],
						"status" => 2
					]
				)->result_array();

			$data["finished_project"] =

				$this->db->get_where(
					'project',
					[
						"peminjam_id" => $data['user']['id'],
						"status" => 5
					]
				)->result_array();


			$data["rejected_project"] =

				$this->db->get_where(
					'project',
					[
						"peminjam_id" => $data['user']['id'],
						"status" => 3
					]
				)->result_array();

			$this->load->view('user/peminjamDashboard', $data);
		}
	}

	public function pilihStatusPendana()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['pendana'] = $this->db->get_where('pendana', ['user_id' => $data['user']['id']])->row_array();
		if (!$data['pendana']) {
			$this->load->view('templates/top_bar_no_side');
			$this->load->view('user/pilihStatusPendana');
		} else {
			$data["project"] = $this->db->get_where('pendanaan', ["pendana_id" => $data['user']['id']])->result_array();
			$data["pending_project"] =
				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['pendana']['id'],
						"status" => 0
					]
				)->result_array();

			$data["ongoing_project"] =
				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['pendana']['id'],
						"status" => 1
					]
				)->result_array();

			$data["canceled_project"] =

				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['pendana']['id'],
						"status" => 2
					]
				)->result_array();

			$data["returned_project"] =

				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['pendana']['id'],
						"status" => 3
					]
				)->result_array();

			$this->db->select('*');
			$this->db->from('user');
			$this->db->where("email", $this->session->userdata('email'));
			$this->db->join('user_role', 'user_role.id = user.role_id');
			$coba = $this->db->get()->row_array();
			$data['user_all'] = $coba;
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

			// $this->db->select("*");
			// $this->db->from('project');
			// $this->db->where("deadline >= ", date("Y-m-d"));
			// $this->db->where("status ", 1);
			// $project = $this->db->get()->result_array();
			// $data['project'] = $project;

			$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
			$this->db->order_by('project.create_ts', 'DESC');
			$this->db->group_by("project.id");
			$this->db->where('project.end_ts >', time());
			$this->db->where('project.status', 1);
			$this->db->where('project.version', 1);
			$this->db->where('(pendanaan.status = 1 or pendanaan.status = 5)');
			$this->db->select('project.*,  COALESCE(sum(pendanaan.nominal), 0) as nominal, 
			COALESCE(sum(pendanaan.nominal)/project.harga_perlot, 0) as jumlah_pendanaan, 
			project_document.prospektus as prospektus');
			$query = $this->db->get('project')->result_array();

			// $this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			// $this->db->order_by('project.create_ts', 'DESC');
			// $this->db->group_by("project.id");
			// $this->db->where('project.end_ts >', time());
			// $this->db->where("project.deadline >= ", date("Y-m-d"));
			// $this->db->where('project.status', 1);
			// $this->db->where('project.version', 1);
			// $this->db->select('project.*, project_document.prospektus as prospektus');
			// $query = $this->db->get('project')->result_array();
			$data['project'] = $query;

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('user/pendanaDashboard', $data);
		}
	}


	public function addPendanaPribadi()
	{
		$data['title'] = 'Add Pendana Pribadi';
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where("email", $this->session->userdata('email'));
		$this->db->join('user_role', 'user_role.id = user.role_id');
		$coba = $this->db->get()->row_array();
		$data['user_all'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['provinces'] = $this->db->get('provinces')->result_array();

		$this->form_validation->set_rules('gender', 'Gender', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('name', 'Full Name', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('email', 'Email', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('address', 'Address', 'required', array('required' => '* mohon diisi '));

		$this->form_validation->set_rules('phone', 'Phone Number', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('source', 'Information Source', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('provinsi_user', 'Province', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('kota_user', 'City', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('kecamatan_user', 'Sub Distric', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('agama', 'Religion', 'required', array('required' => '* mohon diisi '));

		$this->form_validation->set_rules('noktp', 'ID (KTP) Number', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('birthplace', 'Birth Place', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('birthdate', 'Birth Date', 'required', array('required' => '* mohon diisi '));


		$this->form_validation->set_rules('emergencyphone', 'Nomor Telepon Darurat', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('waris', 'Nama Ahli Waris', 'required', array('required' => '* mohon diisi '));


		$this->form_validation->set_rules('pekerjaan', 'Ocupation', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('jenispekerjaan', 'Ocupation Type', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('totalgaji', 'Salary', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('pendidikan', 'Last Education', 'required', array('required' => '* mohon diisi '));

		$this->form_validation->set_rules('rekening', 'Bank Number', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('nama_bank', 'Bank Name', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('nama_akun_bank', 'Bank Account Name', 'required|matches[name]', array('required' => '* mohon diisi '));
		if (empty($_FILES['image']['name'])) {
			$this->form_validation->set_rules('image', 'Document', 'required', array('required' => '* mohon diisi '));
		}

		if (empty($_FILES['slipgaji']['name'])) {
			$this->form_validation->set_rules('slipgaji', 'Slip Gaji', 'required', array('required' => '* mohon diisi '));
		}

		if (empty($_FILES['image_profil']['name'])) {
			$this->form_validation->set_rules('image_profil', 'Foto Profil', 'required', array('required' => '* mohon diisi '));
		}

		if ($this->form_validation->run() === false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/top_bar_no_side', $data);
			$this->load->view('user/isiPendanaPribadi', $data);
			$this->load->view('templates/footer');
		} else {

			$img = $_POST['image_profil'];
			$folderPath = "assets/img/profile/";
			$image_parts = explode(";base64,", $img);
			$image_base64 = base64_decode($image_parts[1]);
			$fileName = 'profile' . $this->input->post('id') . '.png';

			$file_profile = $folderPath . $fileName;
			file_put_contents($file_profile, $image_base64);

			$personal = [
				'user_id' => $this->input->post('id'),
				"gender" => $this->input->post('gender'),
				"full_name" => $this->input->post('name'),
				"email" => $this->input->post('email'),
				"address" => $this->input->post('address'),

				"phone" => $this->input->post('phone'),
				"information_source" => $this->input->post('source'),
				'provinsi' => $this->input->post('provinsi_user'),
				'kota' => $this->input->post('kota_user'),
				'kecamatan' => $this->input->post('kecamatan_user'),
				'agama' => $this->input->post('agama'),

				"ktp" => $this->input->post('noktp'),
				'tempatlahir' => $this->input->post('birthplace'),
				'tanggallahir' => $this->input->post('birthdate'),

				'total_gaji' => $this->input->post('totalgaji'),
				'pekerjaan' => $this->input->post('pekerjaan'),
				'bidang_pekerjaan' => $this->input->post('jenispekerjaan'),
				'pendidikan' => $this->input->post('pendidikan'),

				'custodian' => $this->input->post('custodian'),
				'custodian_name' => $this->input->post('custodian_name'),

				'bank_number' => $this->input->post('rekening'),
				'bank_name' => $this->input->post('nama_bank'),
				'bank_account_name' => $this->input->post('nama_akun_bank'),

				'jenis_pengguna' => 3,
				'type' => 1
			];

			$upload_image = $_FILES['image']['name'];
			if ($upload_image) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '2048';
				$config['file_name']     = 'ktp' . time();
				$new_image = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('image')) {
					$new_image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r("expression");
					redirect('user');
				}
			}
			$personal["ktp_file"] = $new_image;

			$upload_image1 = $_FILES['slipgaji']['name'];
			if ($upload_image1) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '2048';
				$config['file_name']     = 'slipgaji' . time();
				$new_image1 = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('slipgaji')) {
					$new_image1 = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r("expression");
					redirect('user');
				}
			}
			$personal["slipgaji_file"] = $new_image1;


			// 			$upload_image6 = $_FILES['img_prof']['name'];
			// 				if ($upload_image6) {
			// 					$config['upload_path']   = 'assets/img/profile/';
			// 					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
			// 					$config['max_size']      = '2048';
			// 					$new_image6 = '';
			// 					$this->load->library('upload', $config);
			// 					$this->upload->initialize($config);
			// 					if ($this->upload->do_upload('image'))
			// 					{
			// 						$new_image6 = $this->upload->data('file_name');
			// 					}
			// 					else
			// 					{
			// 						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
			// 							. $this->upload->display_errors() .
			// 							'</div>');
			// 						print_r("expression");
			// 				// 		redirect('user');   
			// 					}
			// 				}
			// 					$user["image"] = $new_image6;
			//             $url=	$this->input->post('urlimage');
			//             $data = file_get_contents($url);
			//             $new =  base_url('assets/img/profile/').$this->input->post('id').'foto.jpg';
			//             file_put_contents($new, $data);
			// $this->db->set('image', $user["image"]);
			//             $this->db->where('id', $this->input->post('id'));
			//             $this->db->update('user');

			$this->db->insert('pendana', $personal);
			$this->db->update('user', ['image' => $fileName], ['id' => $this->input->post('id')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Pendaftaran Berhasil! 
				</div>');
			$role = 3;
			$this->notifToAdmin($role);
			redirect('user');
		}
	}


	public function addPendanaPerusahaan()
	{
		// $this->load->helper('form');
		// $this->load->library('form_validation');

		$data['title'] = 'Add Pendana Perusahaan';
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where("email", $this->session->userdata('email'));
		$this->db->join('user_role', 'user_role.id = user.role_id');
		$coba = $this->db->get()->row_array();
		$data['user_all'] = $coba;
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();



		$data['provinces'] = $this->db->get('provinces')->result_array();

		$this->form_validation->set_rules('gender', 'Gender', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('name', 'Full Name', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('email', 'Email', 'required', array('required' => '* mohon diisi '));

		$this->form_validation->set_rules('noktp', 'ID (KTP) Number', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('phonehp', 'Hand Phone Number', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('nip', 'NIP', 'required', array('required' => '* mohon diisi '));

		$this->form_validation->set_rules('namaperusahaan', 'Nama Perusahaan', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('nomoraktaperusahaan', 'Nomor Akta Perusahaan', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('jenisperusahaan', 'Jenis Perusahaan', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('alamatperusahaan', 'Alamat Perusahaan', 'required', array('required' => '* mohon diisi '));


		$this->form_validation->set_rules('provinsi_user', 'Province', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('kota_user', 'City', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('kecamatan_user', 'Sub Distric', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('agama', 'Religion', 'required', array('required' => '* mohon diisi '));


		$this->form_validation->set_rules('pekerjaan', 'Ocupation', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('jenispekerjaan', 'Ocupation Type', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('pendidikan', 'Last Education', 'required', array('required' => '* mohon diisi '));

		$this->form_validation->set_rules('rekening', 'Bank Number', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('nama_bank', 'Bank Name', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('nama_akun_bank', 'Bank Account Name', 'required|matches[namaperusahaan]', array('required' => '* mohon diisi '));

		$this->form_validation->set_rules('custodian', 'Nomor Rekening Custodian', 'required', array('required' => '* mohon diisi '));
		$this->form_validation->set_rules('custodian', 'Nama Pemilik Rekening Custodian', 'required', array('required' => '* mohon diisi '));

		if (empty($_FILES['image']['name'])) {
			$this->form_validation->set_rules('image', 'Document', 'required', array('required' => '* mohon diisi '));
		}

		if (empty($_FILES['image_profil']['name'])) {
			$this->form_validation->set_rules('image_profil', 'Foto Profil', 'required', array('required' => '* mohon diisi '));
		}

		if (empty($_FILES['surat_kuasa']['name'])) {
			$this->form_validation->set_rules('surat_kuasa', 'Document', 'required', array('required' => '* mohon diisi '));
		}

		if (empty($_FILES['akte_perusahaan']['name'])) {
			$this->form_validation->set_rules('akte_perusahaan', 'Document', 'required', array('required' => '* mohon diisi '));
		}

		if ($this->form_validation->run() === false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/top_bar_no_side', $data);
			$this->load->view('user/isiPendanaPerusahaan', $data);
			$this->load->view('templates/footer');
		} else {

			$img = $_POST['image_profil'];
			$folderPath = "assets/img/profile/";
			$image_parts = explode(";base64,", $img);
			$image_base64 = base64_decode($image_parts[1]);
			$fileName = 'profile' . $this->input->post('id') . '.png';

			$file_profile = $folderPath . $fileName;
			file_put_contents($file_profile, $image_base64);

			$personal = [
				'user_id' => $this->input->post('id'),
				"gender" => $this->input->post('gender'),
				"full_name" => $this->input->post('name'),
				"email" => $this->input->post('email'),

				"ktp" => $this->input->post('noktp'),
				"phone" => $this->input->post('phonehp'),
				"phone_company" => $this->input->post('phone'),
				"jabatan" => $this->input->post('jabatan'),
				"nip" => $this->input->post('nip'),

				'namaperusahaan' => $this->input->post('namaperusahaan'),
				'nomoraktaperusahaan' => $this->input->post('nomoraktaperusahaan'),
				'jenisperusahaan' => $this->input->post('jenisperusahaan'),
				'alamatperusahaan' => $this->input->post('alamatperusahaan'),

				'provinsi' => $this->input->post('provinsi_user'),
				'kota' => $this->input->post('kota_user'),
				'kecamatan' => $this->input->post('kecamatan_user'),
				'agama' => $this->input->post('agama'),

				'pekerjaan' => $this->input->post('pekerjaan'),
				'bidang_pekerjaan' => $this->input->post('jenispekerjaan'),
				'pendidikan' => $this->input->post('pendidikan'),

				'bank_number' => $this->input->post('rekening'),
				'bank_name' => $this->input->post('nama_bank'),
				'bank_account_name' => $this->input->post('nama_akun_bank'),

				'jenis_pengguna' => 3,
				'type' => 2,

				'custodian' => $this->input->post('custodian'),
				'custodian_name' => $this->input->post('custodian_name')
			];

			$upload_image = $_FILES['image']['name'];
			if ($upload_image) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '2048';
				$new_image = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('image')) {
					$new_image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r("expression");
					redirect('user');
				}
			}

			$upload_surat_kuasa = $_FILES['surat_kuasa']['name'];
			if ($upload_surat_kuasa) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '2048';
				$new_image1 = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('image')) {
					$new_image1 = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r("expression");
					redirect('user');
				}
			}

			$upload_akte_perusahaan = $_FILES['akte_perusahaan']['name'];
			if ($upload_akte_perusahaan) {
				$config['upload_path']   = 'assets/img/profile/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size']      = '2048';
				$new_image2 = '';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('image')) {
					$new_image2 = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
						. $this->upload->display_errors() .
						'</div>');
					print_r("expression");
					redirect('user');
				}
			}

			$personal["ktp_file"] = $new_image;
			$personal["surat_kuasa_file"] = $new_image1;
			$personal["akte_perusahaan_file"] = $new_image2;
			$this->db->insert('pendana', $personal);
			$this->db->update('user', ['image' => $fileName], ['id' => $this->input->post('id')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Pendaftaran Berhasil! 
				</div>');
			$role = 3;
			$this->notifToAdmin($role);
			redirect('user');
		}
	}

	public function addPemodal($data)
	{
		$data['pendana'] = $this->db->get_where('pendana', ['user_id' => $data['user']['id']])->row_array();
		if (!$data['pendana']) {
			$data['provinces'] = $this->db->get('provinces')->result_array();

			$this->form_validation->set_rules('gender', 'Gender', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('name', 'Full Name', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('email', 'Email', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('address', 'Address', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('phone', 'Phone Number', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('source', 'Information Source', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('provinsi_user', 'Province', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kota_user', 'City', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kecamatan_user', 'Sub Distric', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('agama', 'Religion', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('noktp', 'ID (KTP) Number', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('kk', 'Family ID (KK) Number', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('pekerjaan', 'Ocupation', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('jenispekerjaan', 'Ocupation Type', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('pendidikan', 'Last Education', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('rekening', 'Bank Number', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('nama_bank', 'Bank Name', 'required', array('required' => '* mohon diisi '));
			$this->form_validation->set_rules('nama_akun_bank', 'Bank Account Name', 'required', array('required' => '* mohon diisi '));
			if (empty($_FILES['image']['name'])) {
				$this->form_validation->set_rules('image', 'Document', 'required');
			}

			if ($this->input->post('iscompany') == "on") {
				$this->form_validation->set_rules('idperusahaan', 'ID Company.', 'required');
				$this->form_validation->set_rules('type', 'Company Type.', 'required');
				$this->form_validation->set_rules('perusahaan', 'Company Name.', 'required');
				$this->form_validation->set_rules('kategoribisnis', 'Business Category.', 'required');
				$this->form_validation->set_rules('tipebisnis', 'Business Type.', 'required');
				$this->form_validation->set_rules('deskripsi', 'Office Status.', 'required');
				$this->form_validation->set_rules('status_kantor', 'Description.', 'required');
				$this->form_validation->set_rules('jumlah_karyawan', 'Number of Employee.', 'required|callback_phone');
				$this->form_validation->set_rules('tahun_berdiri', 'Founded Year.', 'required|callback_phone');
				$this->form_validation->set_rules('provinsi', 'Province.', 'required');
				$this->form_validation->set_rules('kota', 'City/Regency.', 'required');
				$this->form_validation->set_rules('kecamatan', 'Distric.', 'required');
				$this->form_validation->set_rules('tlpPerusahaan', 'Company Phone Number.', 'required|callback_phone');
			}

			if ($this->form_validation->run() == false) {
				if ($this->input->post('iscompany') == "on") {
					$data['iscompany'] = True;
					$this->load->view('templates/top_bar_no_side', $data);
					$this->load->view('user/isiPendana', $data);
				} else {
					$data['iscompany'] = False;
					$this->load->view('templates/top_bar_no_side', $data);
					$this->load->view('user/isiPendana', $data);
				}
			} else {

				$personal = [
					'user_id' => $this->input->post('id'),
					"gender" => $this->input->post('gender'),
					"full_name" => $this->input->post('name'),
					"email" => $this->input->post('email'),
					"address" => $this->input->post('address'),
					'provinsi' => $this->input->post('provinsi_user'),
					'kota' => $this->input->post('kota_user'),
					'kecamatan' => $this->input->post('kecamatan_user'),
					'agama' => $this->input->post('agama'),
					"phone" => $this->input->post('phone'),
					"information_source" => $this->input->post('source'),
					"ktp" => $this->input->post('noktp'),
					"kk" => $this->input->post('kk'),
					'pekerjaan' => $this->input->post('pekerjaan'),
					'bidang_pekerjaan' => $this->input->post('jenispekerjaan'),
					'pendidikan' => $this->input->post('pendidikan'),
					'bank_name' => $this->input->post('nama_bank'),
					'bank_number' => $this->input->post('rekening'),
					'bank_account_name' => $this->input->post('nama_akun_bank'),
				];
				$company = [
					"id_badan_hukum" => $this->input->post('idperusahaan'),
					"tipe_perusahaan" => $this->input->post('type'),
					"nama_perusahaan" => $this->input->post('perusahaan'),
					"kategori_bisnis" => $this->input->post('kategoribisnis'),
					"tipe_bisnis" => $this->input->post('tipebisnis'),
					"deskripsi_perusahaan" => $this->input->post('deskripsi'),
					"status_kantor" => $this->input->post('status_kantor'),
					"jumlah_karyawan" => $this->input->post('jumlah_karyawan'),
					"tahun_berdiri" => $this->input->post('tahun_berdiri'),
					"provinsi" => $this->input->post('provinsi'),
					"kota" => $this->input->post('kota'),
					"kecamatan" => $this->input->post('kecamatan'),
					"no_tlp" => $this->input->post('tlpPerusahaan'),
					"alamat_website" => $this->input->post('alamatWeb'),
					"pendana_id" => $this->input->post('id')
				];
				$upload_image = $_FILES['image']['name'];
				if ($upload_image) {
					$config['upload_path']   = 'assets/img/profile/';
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size']      = '2048';
					$new_image = '';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('image')) {
						$new_image = $this->upload->data('file_name');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'
							. $this->upload->display_errors() .
							'</div>');
						print_r("expression");
						redirect('user');
					}
				}
				$personal["ktp_file"] = $new_image;
				$this->db->insert('perusahaan_pendana', $company);
				$this->db->insert('pendana', $personal);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Pendaftaran Berhasil! 
					</div>');
				redirect('user');
			}
		} else {
			$data["project"] = $this->db->get_where('pendanaan', ["pendana_id" => $data['user']['id']])->result_array();
			$data["pending_project"] =
				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['user']['id'],
						"status" => 0
					]
				)->result_array();

			$data["ongoing_project"] =
				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['user']['id'],
						"status" => 1
					]
				)->result_array();

			$data["canceled_project"] =

				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['user']['id'],
						"status" => 2
					]
				)->result_array();

			$data["returned_project"] =

				$this->db->get_where(
					'pendanaan',
					[
						"pendana_id" => $data['user']['id'],
						"status" => 3
					]
				)->result_array();



			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('user/pendanaDashboard', $data);
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
		$this->email->to("chesyah@fulusme.id, sinafadhiel@gmail.com, chesyah@gmail.com");
		$this->email->subject("Notifikasi Pendaftar Baru");
		$this->email->message('<p> Seseorang baru saja bergabung dengan Fulusme sebagai ' . $pendaftar . ', untuk detailnya bisa di cek di backoffice <p>');

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function pendingRetail()
	{
		$data['title'] = 'Retail Tertunda';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project_retail', ['id_anggota' => $data['user']['id_anggota'], 'status' => 0])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_retail', $data);
		$this->load->view('templates/footer');
	}

	public function ongoingRetail()
	{
		$data['title'] = 'Retail Berjalan';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project_retail', ['id_anggota' => $data['user']['id_anggota'], 'status' => 1])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/ongoing_retail', $data);
		$this->load->view('templates/footer');
	}

	public function rejectedRetail()
	{
		$data['title'] = 'Retail Ditolak';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project_retail', ['id_anggota' => $data['user']['id_anggota'], 'status' => 3])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/rejected_retail', $data);
		$this->load->view('templates/footer');
	}

	public function successRetail()
	{
		$data['title'] = 'Retail Berhasil';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project_retail', ['id_anggota' => $data['user']['id_anggota'], 'status' => 2])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/success_retail', $data);
		$this->load->view('templates/footer');
	}


	public function pendingLoan()
	{
		$data['title'] = 'Proyek Tertunda';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project', ['peminjam_id' => $data['user']['id'], 'status' => 0])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_loan', $data);
		$this->load->view('templates/footer');
	}


	public function pendingFunding()
	{
		$data['title'] = 'Pendanaan Tertunda';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$pendana_id = $this->db->get_where('pendana', ['user_id' => $data['user']['id']])->row()->id;
		$data['project'] = $this->db->select('project.*, pendanaan.project_id, pendanaan.nominal, pendanaan.total_lot, pendanaan.nomor_va')
			->from('pendanaan')->join('project', 'pendanaan.project_id = project.id')
			->where(['pendanaan.pendana_id' => $pendana_id, 'pendanaan.status' => 0, 'project.version' => 1])
			->get()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_funding', $data);
		$this->load->view('templates/footer');
	}


	public function rincianLoan($id = null)
	{
		$id = $this->input->get('id');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = 'Detail of Pending Loan';
		$data['project'] = $this->db->get_where('project', ['id' => $id, 'status' => 0])->result_array();
		$data['project_information'] = $this->db->get_where('project_information', ['project_id' => $id])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_loan_det', $data);
		$this->load->view('templates/footer');
	}


	public function rincianOngoingLoan($id = null)
	{
		$id = $this->input->get('id');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = 'Detail of Ongoing Loan';
		$data['project'] = $this->db->get_where('project', ['id' => $id, 'status' => 1])->result_array();
		$data['project_information'] = $this->db->get_where('project_information', ['project_id' => $id])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_loan_det', $data);
		$this->load->view('templates/footer');
	}


	public function rincianRejectedLoan($id = null)
	{
		$id = $this->input->get('id');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = 'Detail of Rejected Loan';
		$data['project'] = $this->db->get_where('project', ['id' => $id, 'status' => 3])->result_array();
		$data['project_information'] = $this->db->get_where('project_information', ['project_id' => $id])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_loan_det', $data);
		$this->load->view('templates/footer');
	}


	public function historyLoan()
	{
		$data['title'] = 'Pembiayaan Berhasil';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project', ['peminjam_id' => $data['user']['id'], 'status' => 2])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/history_loan', $data);
		$this->load->view('templates/footer');
	}

	public function returnedFunding()
	{
		$data['title'] = 'Pengembalian Dana';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('pendanaan', ['pendana_id' => $data['user']['id'], 'status' => 3])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/history_loan', $data);
		$this->load->view('templates/footer');
	}

	public function ongoingLoan()
	{
		$data['title'] = 'Pembiayaan Berjalan';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project', ['peminjam_id' => $data['user']['id'], 'status' => 1])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/ongoing_loan', $data);
		$this->load->view('templates/footer');
	}


	public function ongoingFunding()
	{
		$data['title'] = 'Pengumpulan Dana';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$pendana_id = $this->db->get_where('pendana', ['user_id' => $data['user']['id']])->row()->id;
		$data['project'] = $this->db->select('project.*, pendanaan.project_id, pendanaan.nominal, pendanaan.total_lot, pendanaan.nomor_va')
			->from('pendanaan')->join('project', 'pendanaan.project_id = project.id')
			->where(['pendanaan.pendana_id' => $pendana_id, 'pendanaan.status' => 1, 'project.version' => 1])
			->get()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_funding', $data);
		$this->load->view('templates/footer');
	}


	public function rejectedLoan()
	{
		$data['title'] = 'Pembiayaan ditolak';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project', ['peminjam_id' => $data['user']['id'], 'status' => 3])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/rejected_loan', $data);
		$this->load->view('templates/footer');
	}

	public function cancelledFunding()
	{
		$data['title'] = 'Cancelled Funding';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('pendanaan', ['pendana_id' => $data['user']['id'], 'status' => 2])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/rejected_funding', $data);
		$this->load->view('templates/footer');
	}


	public function rinciDash()
	{
		$id = $this->input->get('id');
		$data['title'] = 'Detail Project';
		// $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project', ['id' => $id, 'status' => 1])->result_array();
		$data['project_information'] = $this->db->get_where('project_information', ['project_id' => $data['project'][0]["id"]])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/pending_loan_det', $data);
		$this->load->view('templates/footer');
	}

	public function PemodalanProject()
	{
		$id = $this->input->get('id');
		$data['title'] = 'Detail Project';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project', ['id' => $id, 'status' => 1])->result_array();
		$data['project_information'] = $this->db->get_where('project_information', ['project_id' => $data['project'][0]["id"]])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/project_pendana', $data);
		$this->load->view('templates/footer');
	}

	function testApi()
	{
		$data_post = ['test' => 'test'];
		// pendanaan OLD API
		$headers = array(
			'Content-Type:application/json'
		);
		$curl = curl_init('url_to_post');
		curl_setopt($curl, CURLOPT_URL, 'https://backoffice.fulusme.id/api/fulusme/create_va');
		curl_setopt($curl, CURLOPT_POST, 1);
		// 		curl_setopt($curl, CURLOPT_USERPWD, "fulusme:fulusme321");
		// curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl);
		curl_close($curl);
	}

	public function formDanai()
	{
		$index = $_POST['button'];
		$id = $this->input->post('id_project' . $index . '');
		$dana = $this->input->post('dana' . $index . '');
		$userID = $this->input->post('user');

		if ($dana < 1) :
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Jumlah tidak boleh kosong!
				</div>');
			redirect('user');
		endif;

		$data['title'] = 'Detail Project';
		$data["id_p"] = $id;
		$data["dana_koma"] = number_format($dana);
		$data["dana_p"] = str_replace(".", "", $dana);

		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['project'] = $this->db->get_where('project', ['id' => $id, 'status' => 1])->result_array();
		$data['peminjam'] = $this->db->get_where('peminjam', ['user_id' => $data['project'][0]['peminjam_id']])->row_array();
		$data['pendana'] = $this->db->get_where('pendana',  ['user_id' => $userID])->row_array();

		// 		die(var_dump($data['project'][0]['nama_project']));

		$data_post = array(
			"project_id" => $id,
			"customer_id" => $data['pendana']["id"],
			"customer_name" => $data['user']['name'],
			"customer_phone" => $data['user']['phone'],
			"customer_email" => $data['user']["email"],
			"trx_amount" => (int) str_replace(".", "", $dana),
			"total_lot" => (int) str_replace(".", "", $dana) / (int) $data['project'][0]['harga_perlot'],
			"borrower_id" => $data['peminjam']["id"],
			"type_project" => ""
		);

		$ch = curl_init('http://178.128.124.100/api_mobile/api/example/frontfulusme');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		// execute!
		$response = curl_exec($ch);
		// close the connection, release resources used
		curl_close($ch);
		$api = json_decode($response);

		$data['va'] = $api->virtual_account;
		// 		update fadhiel 
		$response_code = $api->response_code;
		$id_project = $api->id_project;
		$data["message"] = 'Detail Pembelian Efek telah dikirimkan ke email anda';
		if ($response_code == null) :
			$data["dana_koma"] = number_format($api->trx_amount);
			$data["message"] = "Anda belum melakukan pembayaran untuk transaksi diatas. mohon untuk melakukan pembayaran terlebih dahulu.";
		endif;

		// 		var_dump($result); 
		// 		  print_r ($response);
		// 		exit();


		$this->form_validation->set_rules('jumlah_dana', 'Nominal', 'required');


		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('user/form_danai', $data);
			$this->load->view('templates/footer');
		} else {
			// exit();

			$harga = $this->input->post('jumlah_dana');
			$harga_str = preg_replace("/[^0-9]/", "", $harga);
			// print_r($harga_str);
			// exit();
			$email = $this->session->userdata('email');
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->_sendEmail($token, 'verify');


			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Pemesanan Efek  anda berhasil, silakan cek email anda untuk tahapan lebih lanjut! 
				</div>');
			redirect('user');
		}
	}

	public function testlagi()
	{
		// persiapkan curl
		$ch = curl_init();

		// set url 
		curl_setopt($ch, CURLOPT_URL, "http://178.128.124.100/api_mobile/api/example/cekfulusme");

		// return the transfer as a string 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string 
		$output = curl_exec($ch);

		// tutup curl 
		curl_close($ch);

		// menampilkan hasil curl
		echo $output;
	}

	public function formDanaiRetail()
	{

		$id = $this->input->get('id_project');
		$dana = $this->input->get('dana');
		$userID = $this->input->get('user');


		$data['title'] = 'Detail Project';
		$data["id_p"] = $id;
		$data["dana_koma"] = $dana;
		$data["dana_p"] = str_replace(".", "", $dana);

		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


		$data['project'] = $this->db->get_where('project_retail', ['id_project' => $id, 'status' => 1])->result_array();



		$data['peminjam'] = $this->db->get_where('retail', ['id_anggota' => $data['project'][0]['id_anggota']])->row_array();


		$data['pendana'] = $this->db->get_where('pendana', ['user_id' => $userID])->row_array();


		$this->db->select('*');
		$this->db->from('pendanaan');
		$this->db->where('project_id', $id);
		$this->db->where('pendana_id', $data['pendana']["id"]);
		$this->db->where('status', 0);

		$query = $this->db->get()->row_array();

		//         $this->db->join('pendanaan', 'pendanaan.project_id = project_retail.id', 'left');
		// 		$this->db->order_by('project_retail.create_ts','DESC');
		// 		$this->db->group_by("project_retail.id");
		// // 		$this->db->where('project_retail.id_anggota', $data['user']['id_anggota']);
		// 		$this->db->where('project_retail.status', 1);
		// 		$this->db->select('project_retail.*, sum(pendanaan.nominal) as nominal');
		// 		// $this->db->select_sum('pendanaan.nominal');
		// 		$querysum =$this->db->get('project_retail')->row_array();

		// 	




		if (count($query) != 0) {
			//  header("Location: http://www.example.com/");
			$data['va'] = $query["nomor_va"];
		} else {
			$curl = curl_init('url_to_post');
			curl_setopt($curl, CURLOPT_URL, 'https://backoffice.fintekmadani.id/api/fulusme/create_va');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_USERPWD, "fulusme:fulusme321");
			$headers = array(
				'Content-Type:application/json'
			);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
				"project_id" => $id,
				"customer_id" => $data['pendana']["id"],
				"customer_name" => $data['user']['name'],
				"customer_phone" => "null",
				"customer_email" => $data['user']["email"],
				"trx_amount" => (int) str_replace(".", "", $dana),
				"total_lot" => (int) str_replace(".", "", $dana) / (int) 1000000,
				"borrower_id" => $data['peminjam']["id"],
				"type_project" => "retail"

			)));
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($curl);

			curl_close($curl);
			$api = json_decode($response, true);
			$data['va'] = $api["virtual_account"];

			//  var_dump($result); 
			//print_r ($response);
			// 		    exit();

		}

		//   print_r( $data['va']);
		// exit();

		// 	




		$this->form_validation->set_rules('jumlah_dana', 'Nominal', 'required');


		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('user/form_danai_retail', $data);
			$this->load->view('templates/footer');
		} else {
			// exit();

			$harga = $this->input->post('jumlah_dana');
			$harga_str = preg_replace("/[^0-9]/", "", $harga);
			// print_r($harga_str);
			// exit();
			$email = $this->session->userdata('email');
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->_sendEmail($token, 'verify');


			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Pembelian Efek Anda berhasil, silakan cek email anda untuk tahapan lebih lanjut! 
				</div>');
			redirect('user');
		}
	}





	public function ambil_data()
	{
		/*Menangkap semua data yang dikirimkan oleh client*/
		/*Sebagai token yang yang dikrimkan oleh client, dan nantinya akan
		server kirimkan balik. Gunanya untuk memastikan bahwa user mengklik paging
		sesuai dengan urutan yang sebenarnya */
		$draw = $_REQUEST['draw'];
		/*Jumlah baris yang akan ditampilkan pada setiap page*/
		$length = $_REQUEST['length'];
		/*Offset yang akan digunakan untuk memberitahu database
		dari baris mana data yang harus ditampilkan untuk masing masing page
		*/
		$start = $_REQUEST['start'];
		/*Keyword yang diketikan oleh user pada field pencarian*/
		$search = $_REQUEST['search']["value"];
		/*Menghitung total desa didalam database*/
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data["ongoing_project"] =
			$this->db->order_by('create_ts', 'DESC')->get_where(
				'project',
				[
					"peminjam_id" => $data['user']['id'],
					"status" => 1
				]
			)->result_array();
		$total = count($data["ongoing_project"]);
		/*Mempersiapkan array tempat kita akan menampung semua data
		yang nantinya akan server kirimkan ke client*/
		$output = array();
		/*Token yang dikrimkan client, akan dikirim balik ke client*/
		$output['draw'] = $draw;
		/*
		$output['recordsTotal'] adalah total data sebelum difilter
		$output['recordsFiltered'] adalah total data ketika difilter
		Biasanya kedua duanya bernilai sama, maka kita assignment 
		keduaduanya dengan nilai dari $total
		*/
		$output['recordsTotal'] = $output['recordsFiltered'] = $total;
		/*disini nantinya akan memuat data yang akan kita tampilkan 
		pada table client*/
		$output['data'] = array();
		/*Jika $search mengandung nilai, berarti user sedang telah 
		memasukan keyword didalam filed pencarian*/
		if ($search != "") {
			$this->db->like("nama_project", $search);
		}
		/*Lanjutkan pencarian ke database*/
		$this->db->limit($length, $start);
		/*Urutkan dari alphabet paling terkahir*/
		$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
		$this->db->order_by('project.create_ts', 'DESC');
		$this->db->group_by("project.id");
		$this->db->where('project.peminjam_id', $data['user']['id']);
		$this->db->where('project.end_ts >', 'UNIX_TIMESTAMP()');
		$this->db->where('project.status', 1);
		$this->db->where('project.version', 1);
		$this->db->select('project.*, sum(pendanaan.nominal) as nominal');
		// $this->db->select_sum('pendanaan.nominal');
		$query = $this->db->get('project');
		/*Ketika dalam mode pencarian, berarti kita harus mengatur kembali nilai 
		dari 'recordsTotal' dan 'recordsFiltered' sesuai dengan jumlah baris
		yang mengandung keyword tertentu
		*/
		if ($search != "") {
			$this->db->like("name", $search);
			$jum = $this->db->get('project');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}
		$nomor_urut = $start + 1;
		foreach ($query->result_array() as $desa) {
			$output['data'][] = array(
				$nomor_urut,
				$desa['nama_project'],
				$desa['image'],
				$desa['nominal'],
				$desa['modal_project'],
				$desa['deskripsi_project'],
				$desa['deadline'] = date("d F Y", strtotime($desa['deadline'])),
				date("d F Y"),
				$interval = ((new Datetime(date("d F Y")))->diff(new Datetime(date("d F Y", $desa['create_ts'] + 25200))))->days + 1 / ((new Datetime(date("d F Y", strtotime($desa['deadline']))))->diff(new Datetime(date("d F Y", $desa['create_ts'] + 25200))))->days,
				((new Datetime(date("d F Y")))->diff(new Datetime(date("d F Y", strtotime($desa['deadline'])))))->days - +1,
				((new Datetime(date("d F Y", $desa['create_ts'] + 25200)))->diff(new Datetime(date("d F Y", strtotime($desa['deadline'])))))->days,
				$desa['id']
			);
			$nomor_urut++;
		}
		echo json_encode($output);
	}




	public function ambil_data_retail()
	{
		/*Menangkap semua data yang dikirimkan oleh client*/
		/*Sebagai token yang yang dikrimkan oleh client, dan nantinya akan
		server kirimkan balik. Gunanya untuk memastikan bahwa user mengklik paging
		sesuai dengan urutan yang sebenarnya */
		$draw = $_REQUEST['draw'];
		/*Jumlah baris yang akan ditampilkan pada setiap page*/
		$length = $_REQUEST['length'];
		/*Offset yang akan digunakan untuk memberitahu database
		dari baris mana data yang harus ditampilkan untuk masing masing page
		*/
		$start = $_REQUEST['start'];
		/*Keyword yang diketikan oleh user pada field pencarian*/
		$search = $_REQUEST['search']["value"];
		/*Menghitung total desa didalam database*/
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data["ongoing_project"] =
			$this->db->order_by('create_ts', 'DESC')->get_where(
				'project_retail',
				[
					"id_anggota" => $data['user']['id_anggota'],
					"status" => 1
				]
			)->result_array();
		$total = count($data["ongoing_project"]);
		/*Mempersiapkan array tempat kita akan menampung semua data
		yang nantinya akan server kirimkan ke client*/
		$output = array();
		/*Token yang dikrimkan client, akan dikirim balik ke client*/
		$output['draw'] = $draw;
		/*
		$output['recordsTotal'] adalah total data sebelum difilter
		$output['recordsFiltered'] adalah total data ketika difilter
		Biasanya kedua duanya bernilai sama, maka kita assignment 
		keduaduanya dengan nilai dari $total
		*/
		$output['recordsTotal'] = $output['recordsFiltered'] = $total;
		/*disini nantinya akan memuat data yang akan kita tampilkan 
		pada table client*/
		$output['data'] = array();
		/*Jika $search mengandung nilai, berarti user sedang telah 
		memasukan keyword didalam filed pencarian*/
		if ($search != "") {
			$this->db->like("nama_project", $search);
		}
		/*Lanjutkan pencarian ke database*/
		$this->db->limit($length, $start);
		/*Urutkan dari alphabet paling terkahir*/
		$this->db->join('pendanaan', 'pendanaan.project_id = project_retail.id', 'left');
		$this->db->order_by('project_retail.create_ts', 'DESC');
		$this->db->group_by("project_retail.id");
		$this->db->where('project_retail.id_anggota', $data['user']['id_anggota']);
		$this->db->where('project_retail.status', 1);
		$this->db->where('project.end_ts >', time());
		$this->db->select('project_retail.*, sum(pendanaan.nominal) as nominal');
		// $this->db->select_sum('pendanaan.nominal');
		$query = $this->db->get('project_retail');
		/*Ketika dalam mode pencarian, berarti kita harus mengatur kembali nilai 
		dari 'recordsTotal' dan 'recordsFiltered' sesuai dengan jumlah baris
		yang mengandung keyword tertentu
		*/
		if ($search != "") {
			$this->db->like("name", $search);
			$jum = $this->db->get('project_retail');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}
		$nomor_urut = $start + 1;
		foreach ($query->result_array() as $desa) {
			$output['data'][] = array(
				$nomor_urut,
				$desa['nama_toko'],
				$desa['foto_toko'],
				$desa['no_hp'],
				$desa['nama_pemilik'],
				$desa['jumlah_pinjaman'],
				$desa['tenor'],
				$desa['create_ts'] = date("d F Y", $desa['create_ts']),
				$selisih = (new Datetime(date("d F Y")))->diff(new DateTime($desa['create_ts']))->format('%R%a'),
				$selisihakhir =  3 - $selisih / 3 * 100,

				// $pesan = $selisihakhir < 0 ? "projek kadaluarsa" : $selisihakhir + " hari tersisa", 
				$selisihakhir < 0 ? $selisihakhir . " hari tersisa" : "Proyek kadaluarsa",
				$desa['nominal'],

				$selisih_nominal = $desa['jumlah_pinjaman'] - $desa['nominal'],
				($desa['nominal'] / $desa['jumlah_pinjaman']) * 100,
				$desa['nominal'],



				// $interval = ((new Datetime(date("d F Y")))->diff(new Datetime(date("d F Y", $desa['create_ts']+25200))))->days+1 / ((new Datetime(date("d F Y", strtotime($desa['deadline']))))->diff(new Datetime(date("d F Y", $desa['create_ts']+25200)) ))->days,
				// ((new Datetime(date("d F Y")))->diff(new Datetime(date("d F Y", strtotime($desa['deadline'])))))->days-+1,
				// ((new Datetime(date("d F Y", $desa['create_ts']+25200)))->diff(new Datetime(date("d F Y", strtotime($desa['deadline'])))))->days,
				$desa['id']
			);
			$nomor_urut++;
		}

		// 		die();
		echo json_encode($output);
	}









	public function ambil_data_all_retail_khusus()
	{
		/*Menangkap semua data yang dikirimkan oleh client*/
		/*Sebagai token yang yang dikrimkan oleh client, dan nantinya akan
		server kirimkan balik. Gunanya untuk memastikan bahwa user mengklik paging
		sesuai dengan urutan yang sebenarnya */
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$retail_data = $this->db->get_where('retail', ["user_id" => $user['id']])->result_array()[0];
		$user_data_new = $this->db->get_where('user', ["email" => $retail_data['email']])->result_array()[0];


		$id_anggota_new = $user_data_new['id_anggota'];


		$draw = $_REQUEST['draw'];
		/*Jumlah baris yang akan ditampilkan pada setiap page*/
		$length = $_REQUEST['length'];
		/*Offset yang akan digunakan untuk memberitahu database
		dari baris mana data yang harus ditampilkan untuk masing masing page
		*/
		$start = $_REQUEST['start'];
		/*Keyword yang diketikan oleh user pada field pencarian*/
		$search = $_REQUEST['search']["value"];
		/*Menghitung total desa didalam database*/
		$data['user'] = $this->db->get('user')->row_array();



		$data["ongoing_project"] =
			$this->db->order_by('create_ts', 'DESC')->get_where(
				'project_retail',
				["status" => 1, "end_ts > " => time(), "id_anggota" => $id_anggota_new]
			)->result_array();
		$total = count($data["ongoing_project"]);
		/*Mempersiapkan array tempat kita akan menampung semua data
		yang nantinya akan server kirimkan ke client*/
		$output = array();

		/*Token yang dikrimkan client, akan dikirim balik ke client*/
		$output['draw'] = $draw;
		/*
		$output['recordsTotal'] adalah total data sebelum difilter
		$output['recordsFiltered'] adalah total data ketika difilter
		Biasanya kedua duanya bernilai sama, maka kita assignment 
		keduaduanya dengan nilai dari $total
		*/
		$output['recordsTotal'] = $output['recordsFiltered'] = $total;
		/*disini nantinya akan memuat data yang akan kita tampilkan 
		pada table client*/
		$output['data'] = array();
		/*Jika $search mengandung nilai, berarti user sedang telah 
		memasukan keyword didalam filed pencarian*/
		if ($search != "") {
			$this->db->like("nama_project", $search);
		}
		/*Lanjutkan pencarian ke database*/
		$this->db->limit($length, $start);
		/*Urutkan dari alphabet paling terkahir*/

		$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
		$this->db->order_by('project_retail.create_ts', 'DESC');
		$this->db->group_by("project_retail.id_project");
		$this->db->where('project_retail.id_anggota', $id_anggota_new);
		$this->db->where('project_retail.status', 1);

		$this->db->where('project_retail.end_ts >', time());
		$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
		$query = $this->db->get('project_retail');
		/*Ketika dalam mode pencarian, berarti kita harus mengatur kembali nilai 
		dari 'recordsTotal' dan 'recordsFiltered' sesuai dengan jumlah baris
		yang mengandung keyword tertentu
		*/
		if ($search != "") {
			$this->db->like("name", $search);
			$jum = $this->db->get('project_retail');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}
		$nomor_urut = $start + 1;
		foreach ($query->result_array() as $desa) {

			$output['data'][] = array(
				$nomor_urut,
				$desa['nama_toko'],
				$desa['foto_toko'],
				$desa['no_hp'],
				$desa['nama_pemilik'],
				$desa['jumlah_pinjaman'],
				$desa['tenor'],
				$desa['end_ts'] = date("d F Y", $desa['end_ts']),
				$selisih = (new Datetime(date("d F Y")))->diff(new DateTime($desa['end_ts']))->format('%R%a'),
				$selisihakhir =  (($selisih) / 2 * 100),
				$selisihakhir =  (100 - (($selisih) / 2 * 100)),
				$desa['nominal'],
				$selisih_nominal = $desa['jumlah_pinjaman'] - $desa['nominal'],
				($desa['nominal'] / $desa['jumlah_pinjaman']) * 100, //13
				$desa['nominal'],
				$desa['id_project'],
				$desa['jumlah_pendanaan'],
				3 - $selisihakhir,
				$desa['ujrah'], // 18
				$desa['denom'],
				$desa['nisbah'],
				$desa['pengembalian_dana']
			);
			$nomor_urut++;
		}
		echo json_encode($output);
	}
















	public function ambil_data_all_retail()
	{
		/*Menangkap semua data yang dikirimkan oleh client*/
		/*Sebagai token yang yang dikrimkan oleh client, dan nantinya akan
		server kirimkan balik. Gunanya untuk memastikan bahwa user mengklik paging
		sesuai dengan urutan yang sebenarnya */
		$draw = $_REQUEST['draw'];
		/*Jumlah baris yang akan ditampilkan pada setiap page*/
		$length = $_REQUEST['length'];
		/*Offset yang akan digunakan untuk memberitahu database
		dari baris mana data yang harus ditampilkan untuk masing masing page
		*/
		$start = $_REQUEST['start'];
		/*Keyword yang diketikan oleh user pada field pencarian*/
		$search = $_REQUEST['search']["value"];
		/*Menghitung total desa didalam database*/
		$data['user'] = $this->db->get('user')->row_array();

		$data["ongoing_project"] =
			$this->db->order_by('create_ts', 'DESC')->get_where(
				'project_retail',
				["status" => 1, "end_ts > " => time()]
			)->result_array();
		$total = count($data["ongoing_project"]);
		/*Mempersiapkan array tempat kita akan menampung semua data
		yang nantinya akan server kirimkan ke client*/
		$output = array();

		/*Token yang dikrimkan client, akan dikirim balik ke client*/
		$output['draw'] = $draw;
		/*
		$output['recordsTotal'] adalah total data sebelum difilter
		$output['recordsFiltered'] adalah total data ketika difilter
		Biasanya kedua duanya bernilai sama, maka kita assignment 
		keduaduanya dengan nilai dari $total
		*/
		$output['recordsTotal'] = $output['recordsFiltered'] = $total;
		/*disini nantinya akan memuat data yang akan kita tampilkan 
		pada table client*/
		$output['data'] = array();
		/*Jika $search mengandung nilai, berarti user sedang telah 
		memasukan keyword didalam filed pencarian*/
		if ($search != "") {
			$this->db->like("nama_project", $search);
		}
		/*Lanjutkan pencarian ke database*/
		$this->db->limit($length, $start);
		/*Urutkan dari alphabet paling terkahir*/

		$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
		$this->db->order_by('project_retail.create_ts', 'DESC');
		$this->db->group_by("project_retail.id_project");
		$this->db->where('project_retail.status', 1);
		$this->db->where('project_retail.end_ts >', time());
		$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
		$query = $this->db->get('project_retail');
		/*Ketika dalam mode pencarian, berarti kita harus mengatur kembali nilai 
		dari 'recordsTotal' dan 'recordsFiltered' sesuai dengan jumlah baris
		yang mengandung keyword tertentu
		*/
		if ($search != "") {
			$this->db->like("name", $search);
			$jum = $this->db->get('project_retail');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}
		$nomor_urut = $start + 1;
		foreach ($query->result_array() as $desa) {

			$output['data'][] = array(
				$nomor_urut,
				$desa['nama_toko'],
				$desa['foto_toko'],
				$desa['no_hp'],
				$desa['nama_pemilik'],
				$desa['jumlah_pinjaman'],
				$desa['tenor'],
				$desa['end_ts'] = date("d F Y", $desa['end_ts']),
				$selisih = (new Datetime(date("d F Y")))->diff(new DateTime($desa['end_ts']))->format('%R%a'),
				$selisihakhir =  (($selisih) / 2 * 100),
				$selisihakhir =  (100 - (($selisih) / 2 * 100)),
				$desa['nominal'],
				$selisih_nominal = $desa['jumlah_pinjaman'] - $desa['nominal'],
				($desa['nominal'] / $desa['jumlah_pinjaman']) * 100, //13
				$desa['nominal'],
				$desa['id_project'],
				$desa['jumlah_pendanaan'],
				3 - $selisihakhir,
				$desa['ujrah'], // 18
				$desa['denom'],
				$desa['nisbah'],
				$desa['pengembalian_dana']
			);
			$nomor_urut++;
		}
		echo json_encode($output);
	}



	public function ambil_data_all()
	{
		/*Menangkap semua data yang dikirimkan oleh client*/
		/*Sebagai token yang yang dikrimkan oleh client, dan nantinya akan
		server kirimkan balik. Gunanya untuk memastikan bahwa user mengklik paging
		sesuai dengan urutan yang sebenarnya */
		$draw = $_REQUEST['draw'];
		/*Jumlah baris yang akan ditampilkan pada setiap page*/
		$length = $_REQUEST['length'];
		/*Offset yang akan digunakan untuk memberitahu database
		dari baris mana data yang harus ditampilkan untuk masing masing page
		*/
		$start = $_REQUEST['start'];
		/*Keyword yang diketikan oleh user pada field pencarian*/
		$search = $_REQUEST['search']["value"];
		/*Menghitung total desa didalam database*/
		$data['user'] = $this->db->get('user')->row_array();
		$data["ongoing_project"] =
			$this->db->order_by('create_ts', 'DESC')->get_where(
				'project',
				["status" => 1, "version" => 1, "project.end_ts >" => time()]
			)->result_array();
		$total = count($data["ongoing_project"]);
		/*Mempersiapkan array tempat kita akan menampung semua data
		yang nantinya akan server kirimkan ke client*/
		$output = array();

		/*Token yang dikrimkan client, akan dikirim balik ke client*/
		$output['draw'] = $draw;
		/*
		$output['recordsTotal'] adalah total data sebelum difilter
		$output['recordsFiltered'] adalah total data ketika difilter
		Biasanya kedua duanya bernilai sama, maka kita assignment 
		keduaduanya dengan nilai dari $total
		*/
		$output['recordsTotal'] = $output['recordsFiltered'] = $total;
		/*disini nantinya akan memuat data yang akan kita tampilkan 
		pada table client*/
		$output['data'] = array();
		/*Jika $search mengandung nilai, berarti user sedang telah 
		memasukan keyword didalam filed pencarian*/
		if ($search != "") {
			$this->db->like("nama_project", $search);
		}
		/*Lanjutkan pencarian ke database*/
		$this->db->limit($length, $start);
		/*Urutkan dari alphabet paling terkahir*/

		$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
		$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
		$this->db->order_by('project.create_ts', 'DESC');
		$this->db->group_by("project.id");
		$this->db->where('project.end_ts >', time());
		$this->db->where('project.status', 1);
		$this->db->where('project.version', 1);
		$this->db->select('project.*,  COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.harga_perlot, 0) as jumlah_pendanaan, project_document.prospektus as prospektus');
		$query = $this->db->get('project');

		/*Ketika dalam mode pencarian, berarti kita harus mengatur kembali nilai 
		dari 'recordsTotal' dan 'recordsFiltered' sesuai dengan jumlah baris
		yang mengandung keyword tertentu
		*/
		if ($search != "") {
			$this->db->like("name", $search);
			$jum = $this->db->get('project');
			$output['recordsTotal'] = $output['recordsFiltered'] = $jum->num_rows();
		}
		$nomor_urut = $start + 1;
		foreach ($query->result_array() as $desa) {
			$aliascode = "";
			if ($desa['code_saham_alias']) {
				$aliascode = $desa['code_saham_alias'];
			} else {
				$aliascode = "-";
			}

			$output['data'][] = array(


				//0
				$nomor_urut,

				//1
				$desa['nama_project'],

				//2
				$desa['image'],

				//3 uang terkumpul
				$desa['nominal'],

				//4
				$desa['modal_project'],

				//5
				$desa['deskripsi_project'],

				//6
				$desa['deadline'] = date("d F Y", strtotime($desa['deadline'])),

				//7
				date("d F Y"),

				//8
				$interval = ((new Datetime(date("d F Y")))->diff(new Datetime(date("d F Y", $desa['create_ts'] + 25200))))->days + 1 / ((new Datetime(date("d F Y", strtotime($desa['deadline']))))->diff(new Datetime(date("d F Y", $desa['create_ts'] + 25200))))->days,

				//9
				((new Datetime(date("d F Y")))->diff(new Datetime(date("d F Y", strtotime($desa['deadline'])))))->days - +1,

				//10
				((new Datetime(date("d F Y", $desa['create_ts'] + 25200)))->diff(new Datetime(date("d F Y", strtotime($desa['deadline'])))))->days,


				//11
				$desa['id'],

				//12
				$desa['tenor'],

				//13
				$desa['harga_perlot'],

				//14
				$desa['keuntungan'],

				//15
				$desa['rating'],

				//16 sisa waktu
				($desa['end_ts'] - time() / 86400) < 0 ? 0 : ceil(($desa['end_ts'] - time()) / 86400),

				//17
				(100 - ceil((($desa['end_ts'] - time()) / 86400) / 45 * 100)),

				//18
				(45 - ceil((($desa["end_ts"] - time()) / 86400))) > 45 ? 45 : 45 - ceil((($desa["end_ts"] - time()) / 86400)),

				//19
				$desa['prospektus'],

				//20
				$desa['jumlah_lot'],

				//21
				$desa['jumlah_pendanaan'],

				//22
				$desa['jumlah_lot'] - $desa['jumlah_pendanaan'],

				//23
				$desa['nominal'] / $desa['modal_project'] * 100,

				//24
				$aliascode,

				//25
				$desa['harga_perlembar_shm']
			);
			$nomor_urut++;
		}
		echo json_encode($output);
	}

	private function _sendEmail($token, $type)
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

		$config = [
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://backoffice.fintekmadani.id',
			'smtp_user' => 'admin@backoffice.fintekmadani.id',
			'smtp_pass' => 'Bismillah2812',
			'smtp_port' => 465,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline'   => "\r\n"
		];

		if ($type == 'verify') {
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from("admin@backoffice.fintekmadani.id", "Fintek Madani Info");
			$this->email->to($email = $this->session->userdata('email'));
			$this->email->subject("Verifikasi Pendanaan");
			$this->email->message('<p>terima kasih anda telah mempercayakan pemodalan anda kepada fulusme SCF, apabila anda telah melakukan pembayaran, silakan klik link dibawah </p> 
				<a href="' . base_url('') . 'user/kirimKonfirmasi?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Telah mendanai!</a>');
		} else {
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from("admin@backoffice.fintekmadani.id", "Fulusme Info");
			$this->email->to($email = $this->session->userdata('email'));
			$this->email->subject("Konfirmasi Pembayaran");
			$this->email->message('<p>admin, user ' . $this->session->userdata('email') . ' telah melakukan pembayaran untuk Pendanaan </p>');
		}


		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function kirimKonfirmasi()
	{
		$email = $this->session->userdata('email');
		$token = base64_encode(random_bytes(32));
		$user_token = [
			'email' => $email,
			'token' => $token,
			'date_created' => time()
		];

		$this->_sendEmail($token, 'confirm');
		redirect('');
	}

	public function phone($str)
	{
		if (!preg_match("/^[+]*[[0-9]{1,4}[-0-9]*$/", $str)) {
			$this->form_validation->set_message('phone', '* {field} yang di isi bukan nomor telepon yang valid');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function year($str)
	{
		if (!preg_match("/^[+]*[[0-9]{1,4}[-0-9]*$/", $str)) {
			$this->form_validation->set_message('year', '* {field} bukan input tahun yang benar');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function angka($str)
	{
		if (!preg_match("/^[+]*[[0-9]{1,4}[-0-9]*$/", $str)) {
			$this->form_validation->set_message('angka', '* {field} bukan angka yang benar');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
