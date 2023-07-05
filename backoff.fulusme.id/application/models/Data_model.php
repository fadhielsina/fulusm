<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends CI_Model
{

	var $data;
	private $db_fulus;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_fulus = $this->load->database('fulusme', TRUE);
	}

	function get_all_data_peminjam()
	{
		return $this->db_fulus->query('SELECT a.*, a.user_id as id_user, b.email as email_user FROM peminjam a JOIN `user` b on a.user_id = b.id')->result();
	}

	function get_all_data_pendana()
	{
	    return $this->db_fulus->query('SELECT a.*, a.id as id_user, a.full_name as name, b.email as email_user FROM pendana a JOIN `user` b on a.user_id = b.id')->result();
	}

	function getPerlot($id)
	{
		$this->db_fulus->select('jumlah_lot, harga_perlot');
		$this->db_fulus->from('project');
		$this->db_fulus->where('id', $id);
		$this->db_fulus->where('version', 1);
		return $this->db_fulus->get()->row();
	}

	function get_all_pendanaan()
	{
		$arr = [];
		$this->db_fulus->select('pendanaan.*, status_pendanaan.status_pendanaan, pendana.full_name');
		$this->db_fulus->from('pendanaan');
		$this->db_fulus->join('status_pendanaan', 'status_pendanaan.id = pendanaan.status');
		// $this->db_fulus->join('peminjam', 'peminjam.id = pendanaan.peminjam_id');
		$this->db_fulus->join('pendana', 'pendana.id = pendanaan.pendana_id');
		$project = $this->db_fulus->get()->result();
		foreach ($project as $key) {
			$id_project = $key->project_id;
			$jenis_pendanaan = $key->jenis_pendanaan;

			if ($jenis_pendanaan == 'retail') {
				$cek_peminjam = $this->db_fulus->get_where('retail', ['id' => $key->peminjam_id])->row();
				if ($cek_peminjam) {
					$nama_peminjam = $cek_peminjam->name;
				} else {
					$nama_peminjam = '';
				}
				$cek_project = $this->db_fulus->get_where('project_retail', ['id_project' => $id_project])->row();
				if ($cek_project) {
					$nama_project = $cek_project->nama_toko;
					$nama_project .= ' (retail)';
				} else {
					$nama_project = '';
				}
			} else {
				$cek_peminjam = $this->db_fulus->get_where('peminjam', ['id' => $key->peminjam_id])->row();
				if ($cek_peminjam) {
					$nama_peminjam = $cek_peminjam->name;
				} else {
					$nama_peminjam = '';
				}
				$cek_project = $this->db_fulus->select('nama_project')->from('project')->where('id', $id_project)->where('version', 0)->get()->row();
				if ($cek_project) {
					$nama_project = $cek_project->nama_project;
				} else {
					$nama_project = '';
				}
			}
			array_push($arr, [
				'id' => $key->id,
				'project_id' => $key->project_id,
				'nama_project' => $nama_project,
				'peminjam_id' => $key->peminjam_id,
				'name' => $nama_peminjam,
				'pendana_id' => $key->pendana_id,
				'full_name' => $key->full_name,
				'nominal' => $key->nominal,
				'nomor_va' => $key->nomor_va,
				'status_pendanaan' => $key->status_pendanaan,
				'jenis_pendanaan' => $key->jenis_pendanaan,
				'create_ts' => $key->create_ts,
				'pending_ts' => $key->pending_ts,
				'paid_ts' => $key->paid_ts,
				'canceled_ts' => $key->canceled_ts,
				'returned_ts' => $key->returned_ts
			]);
		}
		return $arr;
	}

	function get_data_project($id)
	{
		$this->db_fulus->select('project.*, status_project.status');
		$this->db_fulus->from('project');
		$this->db_fulus->join('status_project', 'status_project.id = project.status');
		$this->db_fulus->where('peminjam_id', $id);
		$this->db_fulus->where('version', 0);
		return $this->db_fulus->get()->result();
	}

	function getScoringTipe()
	{
		$current = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('scr_type');
		$this->db->where('tgl_berlaku >=', $current);
		return $this->db->get()->result_array();
	}

	function get_pendanaan_project($id)
	{
		$cek = $this->db_fulus->get_where('pendanaan', ['id' => $id])->row();
		if ($cek->jenis_pendanaan != 'retail') {
			$nama_project = 'project.nama_project';
			$table_project = 'project';
			$relation_project = 'project.id = pendanaan.project_id';
			$nama_peminjam = 'peminjam.name';
			$table_peminjam = 'peminjam';
			$relation_peminjam = 'peminjam.id = pendanaan.peminjam_id';
		} else {
			$nama_project = 'project_retail.nama_toko as nama_project';
			$table_project = 'project_retail';
			$relation_project = 'project_retail.id_project = pendanaan.project_id';
			$nama_peminjam = 'retail.name';
			$table_peminjam = 'retail';
			$relation_peminjam = 'retail.id = pendanaan.peminjam_id';
		}
		$this->db_fulus->select('pendanaan.*, status_pendanaan.status_pendanaan, ' . $nama_project . ', pendana.full_name, ' . $nama_peminjam . '');
		$this->db_fulus->from('pendanaan');
		$this->db_fulus->join('status_pendanaan', 'status_pendanaan.id = pendanaan.status');
		$this->db_fulus->join('' . $table_project . '', '' . $relation_project . '');
		$this->db_fulus->join('pendana', 'pendana.id = pendanaan.pendana_id');
		$this->db_fulus->join('' . $table_peminjam . '', '' . $relation_peminjam . '');
		$this->db_fulus->where('pendanaan.id', $id);
		return $this->db_fulus->get()->row();
	}

	function get_pendanaan_project_retail($id)
	{
		$this->db_fulus->select('pendanaan.*, status_pendanaan.status_pendanaan, project_retail.nama_toko as nama_project, pendana.full_name, retail.name');
		$this->db_fulus->from('pendanaan');
		$this->db_fulus->join('status_pendanaan', 'status_pendanaan.id = pendanaan.status');
		$this->db_fulus->join('project_retail', 'project_retail.id_project = pendanaan.project_id');
		$this->db_fulus->join('pendana', 'pendana.id = pendanaan.pendana_id');
		$this->db_fulus->join('retail', 'retail.id = pendanaan.peminjam_id');
		$this->db_fulus->where('pendanaan.id', $id);
		return $this->db_fulus->get()->row();
	}

	function get_pembayaran_project($id)
	{
		$this->db_fulus->select('pendanaan.*, status_pendanaan.status_pendanaan, project.nama_project, pendana.full_name, peminjam.name');
		$this->db_fulus->from('pendanaan');
		$this->db_fulus->join('status_pendanaan', 'status_pendanaan.id = pendanaan.status');
		$this->db_fulus->join('project', 'project.id = pendanaan.project_id');
		$this->db_fulus->join('pendana', 'pendana.id = pendanaan.pendana_id');
		$this->db_fulus->join('peminjam', 'peminjam.id = pendanaan.peminjam_id');
		$this->db_fulus->where('pendanaan.nomor_va', $id);
		return $this->db_fulus->get()->row();
	}

	function get_pembayaran_project_retail($id)
	{
		$this->db_fulus->select('pendanaan.*, status_pendanaan.status_pendanaan, project_retail.nama_toko as nama_project, pendana.full_name, retail.name');
		$this->db_fulus->from('pendanaan');
		$this->db_fulus->join('status_pendanaan', 'status_pendanaan.id = pendanaan.status');
		$this->db_fulus->join('project_retail', 'project_retail.id_project = pendanaan.project_id');
		$this->db_fulus->join('pendana', 'pendana.id = pendanaan.pendana_id');
		$this->db_fulus->join('retail', 'retail.id = pendanaan.peminjam_id');
		$this->db_fulus->where('pendanaan.nomor_va', $id);
		return $this->db_fulus->get()->row();
	}

	function get_detail_project($id)
	{
		$cek = $this->db->get_where('history_project', ['id' => $id])->row();
		$this->db_fulus->select('project.*, project.id as id_project, status_project.status, project_document.*, peminjam.name');
		$this->db_fulus->from('project');
		$this->db_fulus->join('status_project', 'status_project.id = project.status');
		$this->db_fulus->join('project_document', 'project_document.project_id = project.id', 'left');
		$this->db_fulus->join('peminjam', 'peminjam.user_id = project.peminjam_id');
		$this->db_fulus->where('project.id', $id);
		if ($cek) {
			$this->db_fulus->where('version', 1);
		}
		return $this->db_fulus->get()->row();
	}

	function get_data_project_pendana($id)
	{
		$this->db_fulus->select('pendanaan.*, status_pendanaan.status_pendanaan, project.nama_project, peminjam.name');
		$this->db_fulus->from('pendanaan');
		$this->db_fulus->join('status_pendanaan', 'status_pendanaan.id = pendanaan.status');
		$this->db_fulus->join('project', 'project.id = pendanaan.project_id');
		$this->db_fulus->join('peminjam', 'peminjam.id = pendanaan.peminjam_id');
		$this->db_fulus->where('pendanaan.pendana_id', $id);
		$this->db_fulus->where('version', 0);
		return $this->db_fulus->get()->result();
	}

	function get_identitas_peminjam($id)
	{
		$this->db_fulus->select('peminjam.*, perusahaan_peminjam.*, user.image, user.email as email');
		$this->db_fulus->from('peminjam');
		$this->db_fulus->join('perusahaan_peminjam', 'perusahaan_peminjam.peminjam_id = peminjam.user_id', 'left');
		$this->db_fulus->join('user', 'user.id = peminjam.user_id', 'left');
		$this->db_fulus->where('user_id', $id);
		$result = $this->db_fulus->get();
		return $result->row_array();
	}

	function get_identitas_pendana($id)
	{
		$this->db_fulus->select('pendana.*, pendana.bank_name as nama_bank, perusahaan_pendana.*');
		$this->db_fulus->from('perusahaan_pendana');
		$this->db_fulus->join('pendana', 'pendana.id = perusahaan_pendana.pendana_id', 'right');
		$this->db_fulus->where('pendana.id', $id);
		$result = $this->db_fulus->get();
		return $result->result_array();
	}

	function get_table_scoring()
	{
		$tipe = $this->input->post('tipe_id');
		return $this->db->get_where('scr_detail_tipe', ['tipe_id' => $tipe])->result_array();
	}

	function get_score_project($idpro)
	{
		// $id_project = $this->input->post('id_project');
		$this->db->select('scoring.*, scr_detail_tipe.nama_detail_tipe');
		$this->db->from('scoring');
		$this->db->join('scr_detail_tipe', 'scr_detail_tipe.id = scoring.detail_tipe_id');
		$this->db->where('scoring.id_project', $idpro);
		$result = $this->db->get()->result();
		return $result;
	}

	function edit_document()
	{
		$id_project = $this->input->post('id_project');

		// 		$config['upload_path']          = '../devfront.fulusme.com/assets/img/profile/';
		$config['upload_path']          = '../assets/img/profile';
		$config['allowed_types']        = 'pdf|gif|jpg|png';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('spk_file')) {
			$error = array('error' => $this->upload->display_errors());
			$spk_file = $this->input->post('spk');
		} else {
			$data = array('upload_data' => $this->upload->data());
			$spk_file = $data['upload_data']['file_name'];
		}

		if (!$this->upload->do_upload('loa_file')) {
			$error = array('error' => $this->upload->display_errors());
			$loa_file = $this->input->post('loa');
		} else {
			$dataPro = array('upload_data' => $this->upload->data());
			$loa_file = $dataPro['upload_data']['file_name'];
		}

		if (!$this->upload->do_upload('kontrak_file')) {
			$error = array('error' => $this->upload->display_errors());
			$kontrak_file = $this->input->post('kontrak');
		} else {
			$dataPro = array('upload_data' => $this->upload->data());
			$kontrak_file = $dataPro['upload_data']['file_name'];
		}

		if (!$this->upload->do_upload('rekening_koran_file')) {
			$error = array('error' => $this->upload->display_errors());
			$rekening_koran_file = $this->input->post('rekening_koran');
		} else {
			$dataPro = array('upload_data' => $this->upload->data());
			$rekening_koran_file = $dataPro['upload_data']['file_name'];
		}

		if (!$this->upload->do_upload('profil_perusahaan_file')) {
			$error = array('error' => $this->upload->display_errors());
			$profil_perusahaan_file = $this->input->post('profil_perusahaan');
		} else {
			$dataPro = array('upload_data' => $this->upload->data());
			$profil_perusahaan_file = $dataPro['upload_data']['file_name'];
		}

		if (!$this->upload->do_upload('laporan_keuangan_file')) {
			$error = array('error' => $this->upload->display_errors());
			$laporan_keuangan_file = $this->input->post('laporan_keuangan');
		} else {
			$dataPro = array('upload_data' => $this->upload->data());
			$laporan_keuangan_file = $dataPro['upload_data']['file_name'];
		}

		if (!$this->upload->do_upload('dokumen_pendukung_file')) {
			$error = array('error' => $this->upload->display_errors());
			$dokumen_pendukung_file = $this->input->post('dokumen_pendukung');
		} else {
			$dataPro = array('upload_data' => $this->upload->data());
			$dokumen_pendukung_file = $dataPro['upload_data']['file_name'];
		}

		$dataEdit = [
			'project_id' => $id_project,
			'spk' => $spk_file,
			'loa' => $loa_file,
			'kontrak' => $kontrak_file,
			'rekening_koran' => $rekening_koran_file,
			'profil_perusahaan' => $profil_perusahaan_file,
			'laporan_keuangan' => $laporan_keuangan_file,
			'prospektus' => $dokumen_pendukung_file
		];

		$cek = $this->db->get_where('history_project_document', ['project_id' => $id_project])->row();

		if ($cek) {
			$this->db->set($dataEdit);
			$this->db->where('project_id', $id_project);
			$this->db->update('history_project_document');
		} else {
			$this->db->insert('history_project_document', $dataEdit);
		}
	}

	function submitScore()
	{
		if (isset($_POST['submitscore'])) {
			$id_project = $_POST['id_project'];
			$hasil_scoring = $_POST['hasil_nilai_scoring'];
			$nama_tipe = $_POST['nama_detail_tipe'];
			$nama_sub_tipe = $_POST['nama_sub_detail'];
			$persent = $_POST['persent'];
			$nilai = $_POST['nilai'];
			$nilai_scoring = $_POST['nilai-scoring'];
			$note_score = $this->input->post('note_score');
			$arr = array();
			$i = 0;

			foreach ($nama_sub_tipe as $dataNama) {
				array_push($arr, [
					'id_project' => $id_project,
					'detail_tipe_id' => $nama_tipe[$i],
					'nama_sub_tipe' => $dataNama,
					'persent' => $persent[$i],
					'nilai' => $nilai[$i],
					'nilai_scoring' => $nilai_scoring[$i],
					'hasil_scoring' => $hasil_scoring
				]);
				$i++;
			}

			$this->db->insert_batch('scoring', $arr);

			$data = [
				'id_project' => $id_project,
				'score_st' => 1,
				'edit_st' => 0,
				'note_score' => $note_score
			];

			$dataScor = [
				'scoring_ts' => time()
			];
		}
		$this->db_fulus->set($dataScor);
		$this->db_fulus->where('id', $id_project);
		$this->db_fulus->update('project');
		$this->db->insert('scr_status', $data);
	}

	function getGrade($score)
	{
		$this->db->select('*');
		$this->db->from('tbl_rating');
		$this->db->where('score_min <=', $score);
		$this->db->where('score_max >=', $score);
		return $this->db->get()->row();
	}

	function editForm()
	{
		$id = $this->input->post('id');
		$modal_project = $this->input->post('modal_project');
		$perlembar_saham = $this->input->post('perlembar_saham');
		$keuntungan = $this->input->post('keuntungan');
		$jumlah_lembar_shm = $this->input->post('jumlah_lembar_shm');
		$harga_perlot = $this->input->post('harga_perlot');
		$rating = $this->input->post('rating');
		$code_saham = $this->input->post('code_saham');
		$note = $this->input->post('note');
		$jumlah_lot = (int)$jumlah_lembar_shm / 100;

		$query_project = $this->db_fulus->get_where('project', ['id' => $id])->row();
		$data = [
			'id' => $id,
			'peminjam_id' => $query_project->peminjam_id,
			'nama_project' => $query_project->nama_project,
			'deskripsi_project' => $query_project->deskripsi_project,
			'deadline' => $query_project->deadline,
			'lokasi_project' => $query_project->lokasi_project,
			'nilai_project' => $query_project->nilai_project,
			'modal_project' => intval(str_replace(',', '', $modal_project)),
			'crowdfound_period' => $query_project->crowdfound_period,
			'tenor' => $query_project->tenor,
			'keuntungan' => $keuntungan,
			'status' => $query_project->status,
			'create_ts' => time(),
			'scoring_ts' => $query_project->scoring_ts,
			'end_ts' => $query_project->end_ts,
			'image' => $query_project->image,
			'jumlah_lot' => $jumlah_lot,
			'harga_perlot' => intval(str_replace(',', '', $harga_perlot)),
			'rating' => $rating,
			'version' => 1,
			'harga_perlembar_shm' => intval(str_replace(',', '', $perlembar_saham)),
			'code_saham_alias' => $code_saham,
			'jumlah_lembar_shm' => $jumlah_lembar_shm
		];
		$this->db->insert('history_project', $data);
		$this->db_fulus->insert('project', $data);

		// $this->db_fulus->where('id', $id);
		// $this->db_fulus->where('version', 0);
		// $this->db_fulus->update('project', ['status' => 6]);

		$cek = $this->db->get_where('scr_status', ['id_project' => $id])->row();
		if ($cek) {
			$dataPro = [
				'edit_st' => 1,
				'note' => $note
			];
			$this->db->set($dataPro);
			$this->db->where('id_project', $id);
			$this->db->update('scr_status');
		} else {
			$dataProj = [
				'id_project' => $id,
				'edit_st' => 1
			];
			$this->db->insert('scr_status', $dataProj);
		}
	}

	function saveProject($id)
	{
		$tipe = $this->input->post('tipe');
		$tipe_pengembalian = $this->input->post('jenis_pengembalian');
		$tempo_perbulan = $this->input->post('jatuh_tempo');
		$tempo_akhir = $this->input->post('tgl_pengembalian');

		$id_project = $id;
		$id_peminjam = $this->input->post('id_peminjam');
		$nama_peminjam = $this->input->post('nama_peminjam');
		$nama_project = $this->input->post('nama_project');
		$persent_keuntungan = $this->input->post('keuntungan');
		$tenor = $this->input->post('tenor');

		$pem_pendana = $this->input->post('pem_pendana');
		$pem_peminjam = $this->input->post('pem_peminjam');

		// $this->cekVersion($id_project);

		if ($tipe == 1) {
			$tipe_bayar = 'Equitas';
		}
		if ($tipe == 2) {
			$tipe_bayar = 'Pendaan';
		}

		if ($tipe_pengembalian == 0) {
			$tipe_kembali = strtotime($tempo_akhir);
		}
		if ($tipe_pengembalian == 1) {
			$tipe_kembali = $tempo_perbulan;
		}

		$data_jurnal = [
			'id_project' => $id_project,
			'nama_peminjam' => $nama_peminjam,
			'nama_project' => $nama_project,
			'ujrah' => 3,
			'lender' => $pem_pendana,
			'borrower' => $pem_peminjam,
			'tipe' => $tipe_bayar,
			'persentasi_keuntungan' => $persent_keuntungan,
			'angsuran' => $tipe_kembali,
			'status' => 0,
			'tenor' => $tenor,
			'id_peminjam' => $id_peminjam
		];
		$this->db->insert('trx_project', $data_jurnal);

		$this->upload_img($id_project);
		$this->upload_file($id_project);
		$this->send_token($id_project);
	}

	function cekVersion($id)
	{
		$query = $this->db->get_where('history_project', ['id' => $id])->row();
		if (!$query) {
			$project = $this->db_fulus->get_where('project', ['id' => $id])->row();
			$data = [
				'id' => $id,
				'peminjam_id' => $project->peminjam_id,
				'nama_project' => $project->nama_project,
				'deskripsi_project' => $project->deskripsi_project,
				'deadline' => $project->deadline,
				'lokasi_project' => $project->lokasi_project,
				'nilai_project' => $project->nilai_project,
				'modal_project' => $project->modal_project,
				'crowdfound_period' => $project->crowdfound_period,
				'tenor' => $project->tenor,
				'keuntungan' => $project->keuntungan,
				'status' => $project->status,
				'create_ts' => $project->create_ts,
				'scoring_ts' => $project->scoring_ts,
				'end_ts' => $project->end_ts,
				'image' => $project->image,
				'jumlah_lot' => $project->jumlah_lot,
				'harga_perlot' => $project->harga_perlot,
				'rating' => $project->rating,
				'version' => 1
			];
			$this->db_fulus->insert('project', $data);
		}
	}

	function upload_img($id_project)
	{
		// 		$config['upload_path'] = '../public_html/assets/img/profile/';
		$config['upload_path']          = '../assets/img/profile/';
		$config['allowed_types']        = 'pdf|gif|jpg|png';
		$config['file_name']            = 'foto_project_'.time().'';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('image_project')) {
			$error = array('error' => $this->upload->display_errors());
			$image_project = '';
		} else {
			$data = array('upload_data' => $this->upload->data());
			$image_project = $data['upload_data']['file_name'];
		}

		$data_img = [
			'image' => $image_project
		];
		$this->db_fulus->set($data_img);
		$this->db_fulus->where('id', $id_project);
		$this->db_fulus->update('project');

		$this->db->set($data_img);
		$this->db->where('id', $id_project);
		$this->db->update('history_project');
	}

	function upload_file($id_project)
	{
		// 		$config['upload_path'] = '../public_html/assets/file_user/prospektus/';
		$config['upload_path']          = '../assets/file_user/prospektus/';
		$config['allowed_types']        = 'pdf|gif|jpg|png';
		$config['file_name']            = 'prospektus_'.time().'';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('proposal')) {
			$error = array('error' => $this->upload->display_errors());
			$porposal_file = '';
		} else {
			$dataPro = array('upload_data' => $this->upload->data());
			$porposal_file = $dataPro['upload_data']['file_name'];
		}

		$data_prospektus = [
			'prospektus' => $porposal_file
		];
		$this->db_fulus->set($data_prospektus);
		$this->db_fulus->where('project_id', $id_project);
		$this->db_fulus->update('project_document');
	}

	function send_token($id_project)
	{
		$random = rand();
		$data = [
			'token_app' => $random
		];
		$this->db->set($data);
		$this->db->where('id_project', $id_project);
		$this->db->update('scr_status');
	}

	function postApprove($id)
	{
		$noted = $this->input->post('noted');
		$uang_muka = intval(str_replace(',', '', $this->input->post('uang_muka')));

		$dataTrx = [
			'tgl_app' => date('y-m-d'),
			'status' => 1,
			'tgl_deadline' => date('Y-m-d', strtotime("+45 days", strtotime(date('y-m-d')))),
			'uang_muka' => $uang_muka
		];

		$data = [
			'status' => 1,
			'end_ts' => strtotime('+45 days')
		];

		$data_note = [
			'note_app' => $noted
		];

		$cek = $this->db_fulus->select('*')->from('project')->where('id', $id)->where('version', 1)->get()->row();

		$this->db->set($data_note);
		$this->db->where('id_project', $id);
		$this->db->update('scr_status');

		$this->db_fulus->set($data);
		$this->db_fulus->where('id', $id);
		if ($cek != null) {
			$this->db_fulus->where('version', 1);
		}
		$this->db_fulus->update('project');

		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('history_project');

		$this->db->set($dataTrx);
		$this->db->where('id_project', $id);
		$this->db->update('trx_project');
	}
}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
