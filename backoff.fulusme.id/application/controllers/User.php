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
        $this->db_fulus = $this->load->database('fulusme', TRUE);
	}
	
	public function payment_dummy()
	{
		$data['list_pendanaan'] = $this->db_fulus->get('pendanaan')->result_array();
		$this->load->view('dummy_payment', $data);
	}

	function postPayment($id = null)
	{
		$pendanaan = $this->db_fulus->get_where('pendanaan', ['id' => $id])->row();
		$nomor_va = $pendanaan->nomor_va;
		$pendana_id = $pendanaan->pendana_id;
		$id_project = $pendanaan->project_id;
		$nominal = $pendanaan->nominal;
		$jumlah_lot = $pendanaan->total_lot;

		$pendana = $this->db_fulus->get_where('pendana', ['id' => $pendana_id])->row();
		$email_user = $pendana->email;
		$fullname = $pendana->full_name;
		$perusahaan = $pendana->namaperusahaan;
		$phone = $pendana->phone;

		$project = $this->db_fulus->select('*')->from('project')->where('id', $id_project)->where('version', 1)->get()->row();
		$nama_project = $project->nama_project;
		$kode_efek = $project->code_saham_alias;

		// konfigurasi email server
		$config = $this->config->item('config_email');
		$this->email->initialize($config);
		// Load library email dan konfigurasinya
		$this->load->library('email', $config);
		// Email dan nama pengirim penerima server
		$this->email->from('noreply@fulusme.id', 'Admin Fulusme');
		$this->email->to("$email_user, sinafadhiel@gmail.com");
		// Subject email
		$this->email->subject('Konfirmasi Pembelian');
		// Isi email
		$this->email->message('Terimakasih Pembayaran Anda berhasil berikut kami sampaikan Informasi pembelian efek anda : <br><br>
        <b>Pembyaran : Rp. ' . number_format($nominal) . '</b><br>
		<b>ID Proyek : ' . $id_project . ' </b><br>
        <b>Nama Proyek : ' . $nama_project . ' </b><br>
        <b>Kode Efek : ' . $kode_efek . '</b><br>
        <b>ID Pemodal : ' . $pendana_id . '</b><br>
		<b>Nama : ' . $fullname . '</b><br>
		<b>Perusahaan : ' . $perusahaan . '</b><br>
        <b>Email : ' . $email_user . '</b><br>
		<b>Jumalh Lot : ' . $jumlah_lot . '</b><br>
        Terimakasih<br>
        Salam Hangat<br>Fulusme
        <br><br>
        Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2555-8986 WA: XXXXXXXXXXX Email:info@fulusme.id
        ');

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
			$this->db_fulus->update('pendanaan', ['status' => 1, 'paid_ts' => time()], ['id' => $id]);
			$this->db->where('id_project', $id_project)->where('virtual_account', $nomor_va)->where('customer_id', $pendana_id)
				->update('virtual_account', ['response_code' => '000001']);
			// send sms$this->db_fulus->update('pendanaan', ['status' => 1, 'paid_ts' => time()], ['id' => $id]);
			$this->db->where('id_project', $id_project)->where('virtual_account', $nomor_va)->where('customer_id', $pendana_id)
				->update('virtual_account', ['response_code' => '000001']);
			// send sms
			$nama_project = str_replace(' ', '%20', $nama_project);
			$fullname = str_replace(' ', '%20', $fullname);
			$perusahaan =  str_replace(' ', '%20', $perusahaan);
			$text = 'Terimakasih%20pembayaran%20anda%20berhasil%20berikut%20kami%20sampaikan%20informasi%20pembelian%20ekfek%20anda%20:%0APembayaran%20:%20Rp.%20' . number_format($nominal) . '%0AID%20Proyek%20:%20' . $id_project . '%0ANama%20Proyek%20:%20' . $nama_project . '%0AID%20Pemodal%20:%20' . $pendana_id . '%0ANama%20:%20' . $fullname . '%0APerusahaan%20:%20' . $perusahaan . '%0AEmail%20:%20' . $email_user . '%0AJumlah%20Lot%20:%20' . $jumlah_lot . '%0ATerimakasih,Salam%20hangat%20Fulusme';
			$runfile = 'http://202.149.67.146:8800/?PhoneNumber=' . $phone . '&Text=' . $text . '&ID=FULUSME';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $runfile);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			curl_close($ch);
			redirect('user/payment_dummy');
		} else {
			echo $this->email->print_debugger();
			die;
		}
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
