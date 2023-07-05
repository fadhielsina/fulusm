<?php
class Project extends CI_Controller
{
	private $db_fulus;

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
			$this->auth->check_user_authentification(1);
		}
		$this->load->library('form_validation');
		$this->load->model('purchasing_model');
		$this->load->library('BniEnc');
		$this->load->library('customlib');
		$this->load->library('Tbswrapper');
		$this->load->helper('download');
		$this->load->model('akun_model');
		$this->load->model('data_model');
		$this->load->model('project_model');
		$this->db_fulus = $this->load->database('fulusme', TRUE);
	}

	function index()
	{
		$this->form_validation->set_rules('stat_pro', 'Status Project', 'required');
		if ($this->form_validation->run() == false) {
			$data['cek'] = 10;
		} else {
			$data['cek'] = $this->input->post('stat_pro');
		}
		$data['title'] = "Daftar Semua Project";
		$data['main_content'] = 'project/daftar_all_project';
		$data['data_project'] = $this->project_model->getAllProject();
		$data['status_pro'] = $this->db_fulus->get('status_project')->result();
		$this->load->view('template/template_xpanel', $data);
	}

	function project_detail($id)
	{
		$this->form_validation->set_rules('hasil_nilai_scoring', 'Hasil Nilai Scoring', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['title'] = "Detail Project";
			$data['main_content'] = 'project/detail_project';
			$data['data_project'] = $this->data_model->get_detail_project($id);
			$data['form_scoring'] = null;
			$data['project_id'] = $id;
			$data['update_doc'] = $this->db->get_where('history_project_document', ['project_id' => $id])->row();
			$data['get_tipe'] = $this->data_model->getScoringTipe();
			$data['get_score_project'] = $this->data_model->get_score_project($id);
			$data['get_table_scoring'] = $this->data_model->get_table_scoring();
			$tipe = $this->input->post('tipe_id');
			$data['tipe'] = $this->db->get_where('scr_type', ['id' => $tipe])->row();
			$this->load->view('template/template_xpanel', $data);
		} else {
			$this->data_model->submitScore();
			redirect('project/form_project/' . $id . '');
		}
	}

	function form_project($id)
	{
		if (isset($_POST['submitpost'])) {
			$this->approve($id);
		}
		if (isset($_POST['revisi'])) {
			$this->revisi($id);
		}
		if (isset($_POST['rejected'])) {
			$this->rejected($id);
		} elseif (isset($_POST['editform'])) {
			$this->data_model->editForm();
			redirect('project/form_project/' . $id . '');
		} else {
			// $this->form_validation->set_rules('proposal', 'Proposal', 'required');
			// $this->form_validation->set_rules('image_project', 'Image Project', 'required');
			// $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required|trim');
			$this->form_validation->set_rules('tipe', 'Tipe', 'required|trim');
			$this->form_validation->set_rules('pem_pendana', 'Pendana', 'required|trim|numeric');
			$this->form_validation->set_rules('pem_peminjam', 'Peminjam', 'required|trim|numeric');
			$this->form_validation->set_rules('jenis_pengembalian', 'Jenis Pengembalian', 'required');
			// $this->form_validation->set_rules('tgl_pengembalian', 'Tanggal Pengembalian', 'required');
			if ($this->form_validation->run() == false) {
				$data['title'] = "Detail Proposal";
				$data['main_content'] = 'scoring/form_project';
				$data['data_project'] = $this->data_model->get_detail_project($id);
				$id = $data['data_project']->peminjam_id;
				$id_project = $data['data_project']->id_project;
				$data['score'] = $this->db->get_where('scoring', ['id_project' => $id_project])->result();
				$score = $data['score'][0]->hasil_scoring;
				$data['user_data'] = $this->db_fulus->get_where('peminjam', ['user_id' => $id])->result();
				$data['history_project'] = $this->db->get_where('history_project', ['id' => $id_project])->row();
				$data['stat_project'] = $this->db->get_where('scr_status', ['id_project' => $id_project])->row();
				$data['grade'] = $this->data_model->getGrade($score);
				$data['formProject'] = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();
				$this->load->view('template/template_xpanel', $data);
			} else {
				$this->data_model->saveProject($id);
				$this->_sendEmail($id);
				redirect('project/form_project/' . $id . '');
			}
		}
	}

	function approve($id)
	{
		$user = $this->session->userdata['username'];
		$query = $this->db->get_where('login', ['username' => $user])->row();
		$token = base64_decode($query->token);
		$in_token = $this->input->post('token');
		if ($token == $in_token) {
			$this->data_model->postApprove($id);
			$this->_sendEmailApprove($id);
			redirect('project/marketplace');
		}

		$this->session->set_flashdata('message_token', '<small><div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
		<strong>Token tidak sesuai, silahkan cek kembali!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div></small>');
	}

	function revisi($id)
	{
		$user = $this->session->userdata['username'];
		$query = $this->db->get_where('login', ['username' => $user])->row();
		$token = base64_decode($query->token);
		$in_token = $this->input->post('token');

		if ($token == $in_token) {
			$this->db->delete('trx_project', ['id_project' => $id]);
			$this->db->delete('scoring', ['id_project' => $id]);
			$this->db->delete('history_project', ['id' => $id]);
			$this->db->delete('scr_status', ['id_project' => $id]);
			redirect('data_peminjam/project_detail/' . $id . '');
		}
		$this->session->set_flashdata('message_token', '<small><div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
		<strong>Token tidak sesuai, silahkan cek kembali!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div></small>');
		redirect('data_peminjam/form_project/' . $id . '');
	}

	function rejected($id)
	{
		$user = $this->session->userdata['username'];
		$query = $this->db->get_where('login', ['username' => $user])->row();
		$token = base64_decode($query->token);
		$in_token = $this->input->post('token');

		if ($token == $in_token) {
			$noted = $this->input->post('noted');
			$data_note = [
				'note_app' => $noted
			];
			$this->db->set($data_note);
			$this->db->where('id_project', $id);
			$this->db->update('scr_status');
			$data = ['status' => 3];
			$this->db_fulus->set($data);
			$this->db_fulus->where('id', $id);
			$this->db_fulus->update('project');
			$this->db->set($data);
			$this->db->where('id', $id);
			$this->db->update('history_project');
			$this->db->delete('trx_project', ['id_project' => $id]);
			redirect('data_peminjam/project_detail/' . $id . '');
		}

		$this->session->set_flashdata('message_token', '<small><div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
		<strong>Token tidak sesuai, silahkan cek kembali!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div></small>');
		redirect('data_peminjam/form_project/' . $id . '');
	}
	
	function _sendEmailApprove($id)
	{
		$query = $this->db_fulus->select('*')->from('project')->where(['id' => $id, 'version' => 1])->get()->row();
		$peminjam_id = $query->peminjam_id;
		$nama_project = $query->nama_project;
		$lokasi_project = $query->lokasi_project;
		$modal_project = $query->modal_project;
		$jumlah_lot = $query->jumlah_lot;
		$harga_perlot = $query->harga_perlot;
		$harga_perlembar_shm = $query->harga_perlembar_shm;
		$jml_lembar_shm = $query->jumlah_lembar_shm;
		$email_user = $this->db_fulus->get_where('user', ['id' => $peminjam_id])->row()->email;
		$peminjam = $this->db_fulus->get_where('peminjam', ['user_id' => $peminjam_id])->row();
		$phone = $peminjam->phone;

		// Load library email dan konfigurasinya
		$config = $this->config->item('config_email');
		$this->email->initialize($config);
		$this->load->library('email', $config);

		// Email dan nama pengirim penerima server
		$this->email->from('noreply@fulusme.id', 'Admin Fulusme');
		$this->email->to("$email_user, sinafadhiel@gmail.com");

		// Lampiran email, isi dengan url/path file
		// $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

		// Subject email
		$this->email->subject('Review Project');

		// Isi email
		$this->email->message('Selamat untuk Proyek yang anda ajukan sudah disetujui dan sudah tampil di marketplace. berikut informasi proyek :
		<br> ID Project : ' . $id . '
		<br> Nama Project : ' . $nama_project . '
		<br> Lokasi Project : ' . $lokasi_project . '
		<br> Modal Project : Rp. ' . number_format($modal_project) . '
		<br> Jumlah Lot : ' . $jumlah_lot . '
		<br> Harga PerLot : Rp. ' . number_format($harga_perlot) . '
		<br> Jumlah Lembar Saham : ' . $jml_lembar_shm . '
		<br> Harga Perlembar Saham : Rp. ' . number_format($harga_perlembar_shm) . '');

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
			$text = 'Selamat%20untuk%20proyek%20yang%20anda%20ajukan%20sudah%20disetujui.%0ASilahkan%20cek%20email%20anda%20untuk%20detail%20proyek.';
			$runfile = 'http://202.149.67.146:8800/?PhoneNumber=' . $phone . '&Text=' . $text . '&ID=FULUSME';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $runfile);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			curl_close($ch);
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	function _sendEmail($id)
	{
		$query = $this->db_fulus->get_where('project', ['id' => $id])->row();
		$nama_project = $query->nama_project;
		$user = $this->session->userdata['username'];
		$query = $this->db->get_where('login', ['username' => $user])->row();
		$token = base64_decode($query->token);
		$config = $this->config->item('config_email');
		$this->email->initialize($config);

		// Load library email dan konfigurasinya
		$this->load->library('email', $config);

		// Email dan nama pengirim penerima server
		$this->email->from('noreply@fulusme.id', 'Admin Fulusme');
		$this->email->to('sinafadhiel@gmail.com, chesyah@fulusme.id, project@fulusme.id');

		// Lampiran email, isi dengan url/path file
		// $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

		// Subject email
		$this->email->subject('Review Project');

		// Isi email
		$this->email->message('ID Project : ' . $id . ' 
							  <br> Nama Project : ' . $nama_project . '
							  <br> Auth Password : ' . $token . '
							  <br> Project diatas telah di riview. Silahkan klik link dibawah untuk proses selanjutnya.
							  <br> <a href="' . base_url('project/form_project/') . $id . '">Go To Link</a>');

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
// 			echo 'Sukses! email berhasil dikirim.';
            return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}
	
	function testEmail()
	{
		$config = $this->config->item('config_email');
		$this->email->initialize($config);

		// Load library email dan konfigurasinya
		$this->load->library('email', $config);

		// Email dan nama pengirim penerima server
		$this->email->from('noreply@fulusme.id', 'Admin Fulusme');
		$this->email->to('sinafadhiel@gmail.com');

		// Subject email
		$this->email->subject('Riview Project');

		// Isi email
		$this->email->message('Test ah');

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
			echo 'Sukses! email berhasil dikirim.';
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	function marketplace()
	{
		$data['title'] = "Daftar Project Berjalan Di Marketplace";
		$data['main_content'] = 'project/daftar_marketplace';
		$data['project'] = $this->project_model->getProject();
		$this->load->view('template/template_xpanel', $data);
	}

	function marketplace_detail($id)
	{
		$this->form_validation->set_rules('nominal_pengembalian', 'Nominal Pengembalian', 'required');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Detail Project";
			$data['main_content'] = 'project/detail_project_berjalan';
			$data['project'] = $this->project_model->getDetailProject($id);
			$id_project = $data['project']->id_project;
			$data['datproject'] = $this->project_model->getDataProject($id_project);
			$data['dana_terkumpul'] = $this->project_model->getDanaTerkumpul($id_project);
			$data['tgl_transfer'] = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $id])->row();
			$this->cek_va($id_project);
			$this->load->view('template/template_xpanel', $data);
		} else {
			$trx_id = $this->db->get_where('trx_project', ['id_project' => $id])->row();
			if (isset($_POST['send_akad'])) {
				$this->create_akad($id, 'ijarah');
				$idpro = $this->db->get_where('trx_project', ['id' => $trx_id->id])->row()->id_project;
				$this->db->where('id_project', $idpro);
				$this->db->update('scr_status', ['status_ijarah' => 1]);
			} else {
				$nominal_pengembalian = $this->input->post('nominal_pengembalian');
				$pinjaman_tf = $this->input->post('pinjam_di_tf');
				$data_trx = [
					'status' => 2,
					'nominal_pengembalian' => intval(str_replace(',', '', $nominal_pengembalian)),
					'pinjaman_tf' => $pinjaman_tf
				];
				$this->db->where('id', $trx_id->id);
				$this->db->update('trx_project', $data_trx);
				// $this->project_model->postProject($trx_id->id);
				// $this->send_ujrah($this->input->post('ujrah'));
				$this->create_akad($trx_id);
				redirect('project/marketplace');
			}
		}
	}

	function detailDanaTerkumpul($id)
	{
		$data['title'] = "Detail Pengumpulan Dana";
		$data['main_content'] = 'project/detail_dana_terkumpul';
		$data['trackPendanaan'] = $this->project_model->getTrackPendanaan($id);
		$data['returPendanaan'] = $this->project_model->returPendanaan($id);
		$data['pelunasanPendanaan'] = $this->project_model->pelunasanPendanaan($id);
		if ($data['trackPendanaan'] != null) {
			$data['project'] = $this->db_fulus->get_where('project', ['id' => $data['trackPendanaan'][0]->id_project])->row();
		} else {
			$data['project'] = null;
		}
		$this->load->view('template/template_xpanel', $data);
	}

	function tambahDurasi($id)
	{
		$data = [
			'tgl_deadline' => date('Y-m-d', strtotime("+14 day", strtotime(date('y-m-d'))))
		];
		$this->db->set($data);
		$this->db->where('id_project', $id);
		$this->db->update('trx_project');
		redirect('project/daftar');
	}

	function cancel($id)
	{
		$this->project_model->cancelProject($id);
		redirect('purchasing/purchasing_retur');
	}

	function jurnal()
	{
		$data['title'] = "Jurnal Project";
		$data['main_content'] = 'project/jurnal';
		$data['project'] = $this->project_model->getProject();
		$this->load->view('template/template_xpanel', $data);
	}

	function pembelian($id = "")
	{
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['usernama'] = $this->session->userdata('SESS_FIRST_NAME');
		$data['f_id'] = 1;
		$data['id_project'] = $id;
		$data['cek'] = $this->db->get_where('as_buy_transactions', ['invoiceBuyID' => $id])->row();
		$data['bank'] = $this->purchasing_model->get_bank();
		$data['bank2'] = $this->purchasing_model->get_bank_own();
		$data['jenisbyr'] = $this->purchasing_model->get_jenis_byr();
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		if ($data['cek']) {
			$data['title'] = "Bukti Pembelian";
			$data['main_content'] = 'purchasing/bukti_pembelian';
		} else {
			$data['title'] = "Pembelian";
			$data['main_content'] = 'purchasing/form_pembelian';
		}
		$this->load->view('template/template_xpanel', $data);
	}

	function create_akad($id, $type = "")
	{
		$query = $this->db->get_where('trx_project', ['id' => $id])->row();
		$query1 = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $query->id_project])->row();
		$query2 = $this->db_fulus->select('peminjam.*, perusahaan_peminjam.*, user.email')->from('peminjam')->join('perusahaan_peminjam', 'peminjam.user_id = perusahaan_peminjam.peminjam_id')->join('user', 'peminjam.user_id = user.id')->where('user_id', $query->id_peminjam)->get()->row();
		$query3 = $this->db->get_where('history_project', ['id' => $query->id_project])->row();
		$arr = [
			$id_project = $query->id_project,
			$name_user = $query->nama_peminjam,
			$dana_terkumpul = number_format($query->dana_terkumpul),
			$tipe_akad = $query->tipe,
			$id_peminjam = $query->id_peminjam,
			$hasil_pendana =  $query->lender,
			$hasil_peminjam = $query->borrower,
			$nama_project = $query->nama_project,
			$estimasi_keuntungan = number_format($query1->keuntungan),
			$tenor = "$query1->tenor hari",
			$jatuh_tempo = date('d-m-Y', strtotime($query1->tgl_tempo)),
			$ktp = $query2->ktp,
			$email_user = $query2->email,
			$no_akta = $query2->id_badan_hukum,
			$nama_bank = $query2->bank_name,
			$no_rek = $query2->rekening_perusahaan,
			$nama_rek = $query2->rekening_perusahaan_nama,
			$division = $query2->pekerjaan,
			$nama_perusahaan = $query2->nama_perusahaan,
			$alamat = $query2->address,
			$tlp = $query2->phone,
			$kebutuhan_dana = number_format($query3->modal_project),
			$tgl_pembiayaan = date('d-m-Y', strtotime($query1->tgl_pinjam)),
			$va = $query->virtual_account,
			$nominal_pengembalian = $query->nominal_pengembalian,
			$ujrah = $query->dana_terkumpul * (3 / 100),
			$uang_muka = number_format($query->uang_muka)
		];
		$tempo = '' . date('d', strtotime($jatuh_tempo)) . ' ';
		$tempo .= '' . $this->customlib->get_month_name(date('m', strtotime($jatuh_tempo))) . ' ';
		$tempo .= '' . date('Y', strtotime($jatuh_tempo)) . '';
		$dana_trblg = '( ' . terbilang(intval(str_replace(',', '', $dana_terkumpul))) . ' )';
		$estimasi_trblg = '( ' . terbilang(intval(str_replace(',', '', $estimasi_keuntungan))) . ' )';
		$kebutuhan_trblg = '( ' . terbilang(intval(str_replace(',', '', $kebutuhan_dana))) . ' )';
		$ujrah_trblg = '( ' . terbilang(intval(str_replace(',', '', $ujrah))) . ' )';
		$uang_muka_trblg = '( ' . terbilang(intval(str_replace(',', '', $uang_muka))) . ' )';
		$pengembalian_trblg = '( ' . terbilang(intval(str_replace(',', '', $nominal_pengembalian))) . ' )';
		$tgl = date('d');
		$hari_ini = $this->hari_ini();
		$tahun = date('Y');
		$bulan = $this->customlib->get_month_name(date('m'));
		$tanggal = "$hari_ini, $tgl $bulan $tahun";
		
		$template = FCPATH . 'assets/perjanjian_penerbit.docx';
		$data['GeneratedFileName'] = "perjanjian_penerbit$id_peminjam.docx";
		$data['folderGenerated'] = "assets/pdf"; // nama folder untuk menyimpan hasil generate dokumen
		$userData[0]['id_project'] = "$id_project";
		$userData[0]['tgl'] = "$tanggal";
		$userData[0]['nama'] = "$name_user";
		$userData[0]['ktp'] = "$ktp";
		$userData[0]['no_va'] = "$va";
		$userData[0]['email'] = "$email_user";
		$userData[0]['nama_bank'] = "$nama_bank";
		$userData[0]['no_rek'] = "$no_rek";
		$userData[0]['nama_rek'] = "$nama_rek";
		$userData[0]['tipe_akad'] = "$tipe_akad";
		$userData[0]['id_peminjam'] = "$id_peminjam";
		$userData[0]['division'] = "$division";
		$userData[0]['nama_perusahaan'] = "$nama_perusahaan";
		$userData[0]['alamat'] = "$alamat";
		$userData[0]['tlp'] = "$tlp";
		$userData[0]['id_peminjam'] = "$id_peminjam";
		$userData[0]['kebutuhan_dana'] = "$kebutuhan_dana , $kebutuhan_trblg";
		$userData[0]['tgl_pembiayaan'] = "$tgl_pembiayaan";
		$userData[0]['estimasi_keuntungan'] = "$estimasi_keuntungan , $estimasi_trblg";
		$userData[0]['hasil_pendana'] = "$hasil_pendana";
		$userData[0]['hasil_peminjam'] = "$hasil_peminjam";
		$userData[0]['nama_project'] = "$nama_project";
		$userData[0]['tenor'] = "$tenor";
		$userData[0]['jatuh_tempo'] = "$tempo";
		$userData[0]['dana_terkumpul'] = "$dana_terkumpul , $dana_trblg";
		$userData[0]['id_peminjam'] = "$id_peminjam";
		$userData[0]['ujrah'] = "$ujrah , $ujrah_trblg";
		$userData[0]['no_akta'] = "$no_akta";
		$userData[0]['uang_muka'] = "$uang_muka , $uang_muka_trblg";
		$userData[0]['nominal_pengembalian'] = "$nominal_pengembalian , $pengembalian_trblg";
		$userData[0]['harga_beli'] = "";
		$userData[0]['harga_jual'] = "";
		$userData[0]['angsuran'] = "";
		$userData[0]['denda'] = "";

		$this->tbswrapper->tbsLoadTemplate($template);
		$this->tbswrapper->namafile = $data['GeneratedFileName'];
		$this->tbswrapper->folder = FCPATH . $data['folderGenerated'] . "/";
		$this->tbswrapper->tbsMergeField('vars', $userData);
		$this->tbswrapper->tbsMergeBlock('user', $userData);

		if ($this->tbswrapper->tbsRender()) {
			// force_download(FCPATH . "" . $data['folderGenerated'] . "/\\" . $data['GeneratedFileName'], NULL);
			force_download('./assets/pdf/' . $data['GeneratedFileName'], NULL);
			$this->kirim_akad($id, $type);
		} else {
			$this->session->set_flashdata('message', lang('error_generate_dokumen'));
			redirect('home');
		}
	}

	function kirim_akad($id, $type = "")
	{
		$project = $this->db->get_where('trx_project', ['id' => $id])->row_array();
		$idPro = $project['id_project'];
		$namePro = $project['nama_project'];
		$pinjaman = $this->input->post('pinjam_di_tf');
		$ujrah = $this->input->post('ujrah');
		$nominal_pengembalian = $this->input->post('nominal_pengembalian');
		$lender = $this->input->post('lender');
		$total_pendanaan = intval(str_replace(',', '', $nominal_pengembalian)) - intval(str_replace(',', '', $lender));

		$query = $this->db_fulus->get_where('project', ['id' => $idPro])->row();
		$id_peminjam = $query->peminjam_id;
		$data_user = $this->db_fulus->get_where('user', ['id' => $id_peminjam])->row();
		$email_user = $data_user->email;

		// konfigurasi email server
		$config = $this->config->item('config_email');
		$this->email->initialize($config);

		// Load library email dan konfigurasinya
		$this->load->library('email', $config);

		// Email dan nama pengirim penerima server
		$this->email->from('noreply@fintekmadani.id', 'Admin Fulusme');

		// $this->email->from('sinafadhiel@gmail.com', 'Admin Fulusme');
		$this->email->to("$email_user, chesyah@fulusme.id, sinafadhiel@gmail.com");

		// Lampiran email, isi dengan url/path file
		$this->email->attach('./assets/pdf/\perjanjian_penerbit' . $id_peminjam . '.docx');

		// Subject email
		$this->email->subject('Konfirmasi Pembiayaan');

		// Isi email
		$this->email->message('Terimakasih telah memilih Fulusme sebagai partner anda dalam Pendanaan dengan ini kami menginformasikan
		bahwa Proyek anda, ' . $namePro . ' dengan ID ' . $idPro . ' telah siap didanai <br><br>
		<b>Nama Project / ID : ' . $namePro . ' / ' . $idPro . ' </b><br>
		<b>No Transaksi : XXXXXXXXX </b><br>
		<b>Total Pendanaan : Rp. ' . number_format($total_pendanaan) . '</b><br>
		<b>Pemotongan Ujrah : Rp. ' . $ujrah . ' </b><br>
		<b>Biaya Transfer : Rp. 7500 </b><br>
		<b>Total yang di Transfer : Rp. ' . $pinjaman . ' </b><br>
		<b>Tanggal Transfer : ' . date('d-m-Y') . ' </b><br>
		<b>Bank : BNI Syariah</b><br><br>
		Untuk detailnya akan tertuang dalam Perjanjian yang akan dikirimkan dan ditandatangani sebelum dana di Transfer <br><br>
		Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2555-8986 WA: XXXXXXXXXXX Email:info@fulusme.id
		');

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
			// echo 'Sukses! Akad berhasil dikirim.';
			redirect('project/marketplace');
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	function send_ujrah($ujrah)
	{
		$curl = curl_init('url_to_post');
		curl_setopt($curl, CURLOPT_URL, 'http://localhost/kantor/surplus_fast/api/fulusme/send_ujrah');
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_USERPWD, "fulusme:fulusme321");
		$headers = array(
			'Content-Type:application/json'
		);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
			"ujrah" => $ujrah
		)));
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl);
		curl_close($curl);
		$api = json_decode($response, true);
	}

	function buku_besar_project()
	{
		$data['title'] = "Buku Besar Project";
		$data['main_content'] = 'project/buku_besar';
		$data['project'] = $this->db->select('*')->from('trx_project')->where('status', 2)->or_where('status', 5)->get()->result();
		$this->load->view('template/template_xpanel', $data);
	}

	function detail_buku_besar($id)
	{
		$data['id'] = $id;
		$data['title'] = "Detail Buku Besar Project";
		$data['main_content'] = 'project/detail_buku_besar';
		$data['trackPendanaan'] = $this->project_model->getTrackPendanaan($id);
		$data['returPendanaan'] = $this->project_model->returPendanaan($id);
		$data['pelunasanPendanaan'] = $this->project_model->pelunasanPendanaan($id);
		$data['nisbah'] = $this->db->select('dana_nisbah, tgl_nisbah')->from('trx_pengembalian_dana')->where('id_project', $id)->get()->result();
		$data['pengembalian'] = $this->db->get_where('trx_pengembalian_dana', ['id_project' => $id])->result();
		$data['journal_data'] = $this->db->query("SELECT tgl,jurnal.keterangan,nama as jenis_transaksi, IF(debit_kredit = 1,'D','K') as debit_kredit, SUM(IF(debit_kredit = 1,nilai,0)) as nilai
		FROM jurnal_detail
		JOIN jurnal ON jurnal_detail.jurnal_id = jurnal.id
		JOIN f ON jurnal.f_id = f.id
		WHERE jurnal.id_project = $id
		GROUP BY keterangan")->result();
		$this->load->view('template/template_xpanel', $data);
	}

	function cek_va($id)
	{
		$modal = $this->project_model->getDataProject($id)->modal_project;
		$query = $this->db->get_where('trx_project', ['id_project' => $id])->row();
		$profile = $this->db_fulus->select('peminjam.name, peminjam.phone, user.email')
			->from('peminjam')->join('user', 'user.id = peminjam.user_id')->where('user_id', $query->id_peminjam)->get()->row();
		if ($query->dana_terkumpul >= $modal) {
			// masukan va
			if (!$query->virtual_account) {
				$data = [
					'project_id' => $id,
					'customer_id' => $query->id_peminjam,
					'customer_name' => $profile->name,
					'customer_phone' => $profile->phone,
					'customer_email' => $profile->email,
					'trx_amount' => $query->dana_terkumpul
				];
				$cek = $this->db_fulus->get_where('project', ['id' => $data['project_id']])->row();
				$this->create_borrower_va($data);
			}
		}
	}

	function get_content($url, $post = '')
	{
		$usecookie = __DIR__ . "/cookie.txt";
		$header[] = 'Content-Type: application/json';
		$header[] = "Accept-Encoding: gzip, deflate";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, false);

		// curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

		if ($post) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$rs = curl_exec($ch);
		if (empty($rs)) {
			var_dump($rs, curl_error($ch));
			curl_close($ch);
			return false;
		}
		curl_close($ch);



		return $rs;
	}

	function create_borrower_va($data_front)
	{
		$client_id = '00411';
		$secret_key = '58f928b6ee844f344b3f72e282d05314';
		$url = 'https://apibeta.bni-ecollection.com/';
		$customer_id = $data_front['customer_id'];
		$project_id = $data_front['project_id'];
		$customer_name = $data_front['customer_name'];
		$customer_email = $data_front['customer_email'];
		$customer_phone = $data_front['customer_phone'];
		$trx_amount = $data_front['trx_amount'];
		$data_asli = array(
			'client_id' => $client_id,  // wajib
			'trx_id' => mt_rand(), // wajib
			'trx_amount' => $trx_amount, // wajib
			'billing_type' => 'i', // wajib
			'datetime_expired' => date('Y-m-d H:i:s', strtotime("+ 2 year")),
			'virtual_account' => '',
			'customer_name' => $customer_name, // wajib
			'customer_email' => $customer_email,
			'customer_phone' => $customer_phone,
			'type' => 'createbilling', // wajib
		);
		$hashed_string = $this->bnienc->encrypt(
			$data_asli,
			$client_id,
			$secret_key
		);
		$data = array(
			'client_id' => $client_id,
			'data' => $hashed_string,
		);
		$response = $this->get_content($url, json_encode($data));
		$response_json = json_decode($response, true);
		if ($response_json['status'] !== '000') {
			// handling jika gagal
			var_dump($response_json);
		} else {
			$data_response = $this->bnienc->decrypt($response_json['data'], $client_id, $secret_key);
			// $data_response will contains something like this: 
			$datares = array(
				'virtual_account' => $data_response['virtual_account'],
				'trx_id' => $data_response['trx_id'],
				'message' => 'Sukses! No Virtual Account sudah terkirim.'
			);
			$this->db->where('id_project', $project_id);
			$this->db->where('id_peminjam', $customer_id);
			$this->db->update('trx_project', ['virtual_account' => $data_response['virtual_account']]);
			return $datares;
		}
	}

	function hari_ini()
	{
		$hari = date("D");
		switch ($hari) {
			case 'Sun':
				$hari_ini = "Minggu";
				break;
			case 'Mon':
				$hari_ini = "Senin";
				break;
			case 'Tue':
				$hari_ini = "Selasa";
				break;
			case 'Wed':
				$hari_ini = "Rabu";
				break;
			case 'Thu':
				$hari_ini = "Kamis";
				break;
			case 'Fri':
				$hari_ini = "Jumat";
				break;
			case 'Sat':
				$hari_ini = "Sabtu";
				break;
			default:
				$hari_ini = "Tidak di ketahui";
				break;
		}
		return $hari_ini;
	}
}

?>
