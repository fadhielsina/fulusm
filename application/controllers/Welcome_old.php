<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function index_lama()
	{
		$this->load->view('web_profile/header_v2.php');
		$this->load->view('web_profile/underconstruction');
		$this->load->view('web_profile/footer_v2.php');
		// $this->load->view('templates/footer');
	}

	public function digisign()
	{
		$auth = 'd2qZ3feM6uynXVwCuXB3VzKQ4jJC1hJlalaWW18rjGxysZLjSvBKN9LFQ5JvcZ';
		$data = array(
			"userid" => "adminfulusme@tandatanganku.com",
			"alamat" => "jl citepus 2 RT 07/06",
			"jenis_kelamin" => "laki-laki",
			"kecamatan" => "cicendo",
			"kelurahan" => "pajajaran",
			"kode-pos" => "40173",
			"kota" => "bandung",
			"nama" => "fadhiel ibnu sina",
			"tlp" => "62881022285499",
			"tgl_lahir" => "28-07-1997",
			"provinci" => "jawa barat",
			"idktp" => "3273062807970001",
			"tmp_lahir" => "bandung",
			"email" => "sinafadhiel@gmail.com",
			"npwp" => "",
			"redirect" => true,
		);
		$jsonField = array("JSONFile" => $data);

		$data_string_json = json_encode($jsonField);

		$selfie = new CURLFile('./assets/img/profile/a2.jpg', 'image/jpg', 'file');
		$ektp = new CURLFile('./assets/img/profile/a20.jpg', 'image/jpg', 'file');
		$ttd = new CURLFile('./assets/img/profile/a21.jpg', 'image/jpg', 'file');
		$npwp = new CURLFile('./assets/img/profile/a22.jpg', 'image/jpg', 'file');

		die(var_dump(json_encode(array('jsonfield' => $data_string_json, 'fotodiri' => $selfie, 'fotoktp' => $ektp, 'ttd' => $ttd, 'npwp' => $npwp))));

		$ch = curl_init('https://api.tandatanganku.com/REG-MITRA.html');
		curl_setopt($ch, CURLOPT_URL, "https://api.tandatanganku.com/REG-MITRA.html");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('jsonfield' => $data_string_json, 'fotodiri' => $selfie, 'fotoktp' => $ektp, 'ttd' => $ttd, 'npwp' => $npwp)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
				'Authorization: Bearer ' . $auth,
				'Content-Type: multipart/form-data',
				'content-type: multipart/form-data; boundary=----011000010111000001101001',
			)
		);

		$result = curl_exec($ch);
		$err = curl_error($ch);

		curl_close($ch);


		if ($err) {
			echo "<pre>$err</pre>";
		} else {
			echo "<pre>$result</pre>";
		}
	}

	public function sms()
	{
		$phone = '081546810673';
		$text = 'Hi,%20terimakasih%20telah%20bergabung%20dengan%20SCF%20Fulusme%20Layanan%20Urun%20Dana';
		$runfile = 'http://202.149.67.146:8800/?PhoneNumber=' . $phone . '&Text=' . $text . '&ID=FULUSME';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $runfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($ch);
		curl_close($ch);
		var_dump($runfile);
	}

	public function index_v2()
	{

		if ($this->session->userdata('email')) {
			$this->db->select('*');
			$this->db->from('video_cms');
			$this->db->group_by("id", "desc");
			$video = $this->db->get()->result_array();
			$data['video_cms'] = $video;
			if (!isset($data['video_cms'][1])) {
				$data['video_cms'][1] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			if (!isset($data['video_cms'][2])) {
				$data['video_cms'][2] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			$this->db->select('*');
			$this->db->from('user');
			$this->db->where("email", $this->session->userdata('email'));
			$this->db->join('user_role', 'user_role.id = user.role_id');
			$coba = $this->db->get()->row_array();
			$data['user_all'] = $coba;
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.harga_perlot, 0) as jumlah_pendanaan, project_document.prospektus as prospektus");
			$this->db->from('project');
			$this->db->where("project.end_ts >= ", time());
			$this->db->where("project.status ", 1);
			$this->db->where("project.version ", 1);
			$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
			$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			$this->db->order_by('project.create_ts', 'DESC');
			$this->db->group_by("project.id");


			$project = $this->db->get()->result_array();
			$data['project'] = $project;
			$data['role_user'] = $this->session->userdata('role_id');




			$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
			$this->db->order_by('project_retail.create_ts', 'DESC');
			$this->db->group_by("project_retail.id_project");
			$this->db->where('project_retail.status', 1);
			$this->db->limit(3, 0);
			$this->db->where('project_retail.end_ts >', time());
			$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
			$query1 = $this->db->get('project_retail')->result_array();

			$data['project_retail'] = $query1;


			$this->load->view('web_profile/header_web_profile.php', $data);
			$this->load->view('web_profile/index', $data);
			$this->load->view('web_profile/footer_web_profile.php', $data);
		} else {
			$this->db->select('*');
			$this->db->from('video_cms');
			$this->db->group_by("id", "desc");
			$video = $this->db->get()->result_array();
			$data['video_cms'] = $video;
			if (!isset($data['video_cms'][1])) {
				$data['video_cms'][1] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			if (!isset($data['video_cms'][2])) {
				$data['video_cms'][2] = [
					"nama" => "cek",
					"url" => "video/dealfintech.jpg"
				];
			}
			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, sum(pendanaan.nominal)/project.harga_perlot as jumlah_pendanaan, project_document.prospektus as prospektus");
			$this->db->from('project');
			$this->db->where("project.end_ts >= ", time());
			$this->db->where("project.status ", 1);
			$this->db->where("project.version ", 1);
			$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
			$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			$this->db->order_by('project.create_ts', 'DESC');
			$this->db->group_by("project.id");
			$project = $this->db->get()->result_array();
			$data['project'] = $project;



			$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
			$this->db->order_by('project_retail.create_ts', 'DESC');
			$this->db->group_by("project_retail.id_project");
			$this->db->where('project_retail.status', 1);
			$this->db->limit(3, 0);
			$this->db->where('project_retail.end_ts >', time());
			$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
			$query1 = $this->db->get('project_retail')->result_array();

			$data['project_retail'] = $query1;

			$this->load->view('web_profile/header_web_profile.php', $data);
			$this->load->view('web_profile/index', $data);
			$this->load->view('web_profile/footer_web_profile.php', $data);
		}



		// $this->load->view('templates/footer');
	}

	public function index()
	{

		if ($this->session->userdata('email')) {
			$this->db->select('*');
			$this->db->from('video_cms');
			$this->db->group_by("id", "desc");
			$video = $this->db->get()->result_array();
			$data['video_cms'] = $video;
			if (!isset($data['video_cms'][1])) {
				$data['video_cms'][1] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			if (!isset($data['video_cms'][2])) {
				$data['video_cms'][2] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			$this->db->select('*');
			$this->db->from('user');
			$this->db->where("email", $this->session->userdata('email'));
			$this->db->join('user_role', 'user_role.id = user.role_id');
			$coba = $this->db->get()->row_array();
			$data['user_all'] = $coba;
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

			// 			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.harga_perlot, 0) as jumlah_pendanaan, project_document.prospektus as prospektus");
			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.modal_project, 0) as jumlah_pendanaan, project_document.prospektus as prospektus, ,(datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\"))-datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), current_date())) as sisawaktu, datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\")) as totalhari,
			(datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\"))-datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), current_date()))/datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\")) as persensisa");
			$this->db->from('project');
			$this->db->where("project.end_ts >= ", time());
			$this->db->where("project.status ", 1);
			$this->db->where("project.version ", 1);
			$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
			$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			$this->db->order_by('project.create_ts', 'DESC');
			$this->db->group_by("project.id");

			$project = $this->db->get()->result_array();
			$data['project'] = $project;
			$data['role_user'] = $this->session->userdata('role_id');

			$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
			$this->db->order_by('project_retail.create_ts', 'DESC');
			$this->db->group_by("project_retail.id_project");
			$this->db->where('project_retail.status', 1);
			$this->db->limit(4, 0);
			$this->db->where('project_retail.end_ts >', time());
			$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
			$query1 = $this->db->get('project_retail')->result_array();

			$data['project_retail'] = $query1;


			$this->load->view('web_profile/header_web_profile.php', $data);
			// 			$this->load->view('web_profile/index_new', $data);
			$this->load->view('web_profile/tryfront', $data);
			$this->load->view('web_profile/footer_web_profile.php', $data);
		} else {
			$this->db->select('*');
			$this->db->from('video_cms');
			$this->db->group_by("id", "desc");
			$video = $this->db->get()->result_array();
			$data['video_cms'] = $video;
			if (!isset($data['video_cms'][1])) {
				$data['video_cms'][1] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			if (!isset($data['video_cms'][2])) {
				$data['video_cms'][2] = [
					"nama" => "cek",
					"url" => "video/dealfintech.jpg"
				];
			}
			// 			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, sum(pendanaan.nominal)/project.harga_perlot as jumlah_pendanaan, project_document.prospektus as prospektus");

			// 			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.harga_perlot, 0) as jumlah_pendanaan, project_document.prospektus as prospektus");
			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.modal_project, 0) as jumlah_pendanaan, project_document.prospektus as prospektus, ,(datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\"))-datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), current_date())) as sisawaktu, datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\")) as totalhari,
			(datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\"))-datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), current_date()))/datediff(FROM_UNIXTIME(`project`.end_ts, \"%Y-%m-%d\"), FROM_UNIXTIME(`project`.scoring_ts, \"%Y-%m-%d\")) as persensisa");
			$this->db->from('project');
			$this->db->where("project.end_ts >= ", time());
			$this->db->where("project.status ", 1);
			$this->db->where("project.version ", 1);
			$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
			$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			$this->db->order_by('project.create_ts', 'DESC');
			$this->db->group_by("project.id");
			$project = $this->db->get()->result_array();
			$data['project'] = $project;

			// 			$data['inii'] = $this->db->last_query();  

			$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
			$this->db->order_by('project_retail.create_ts', 'DESC');
			$this->db->group_by("project_retail.id_project");
			$this->db->where('project_retail.status', 1);
			$this->db->limit(4, 0);
			$this->db->where('project_retail.end_ts >', time());
			$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
			$query1 = $this->db->get('project_retail')->result_array();

			$data['project_retail'] = $query1;

			$this->load->view('web_profile/header_web_profile.php', $data);
			// 			$this->load->view('web_profile/index_new', $data);
			$this->load->view('web_profile/tryfront', $data);
			$this->load->view('web_profile/footer_web_profile.php', $data);
		}



		// $this->load->view('templates/footer');
	}

	public function index_coba()
	{

		if ($this->session->userdata('email')) {
			$this->db->select('*');
			$this->db->from('video_cms');
			$this->db->group_by("id", "desc");
			$video = $this->db->get()->result_array();
			$data['video_cms'] = $video;
			if (!isset($data['video_cms'][1])) {
				$data['video_cms'][1] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			if (!isset($data['video_cms'][2])) {
				$data['video_cms'][2] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			$this->db->select('*');
			$this->db->from('user');
			$this->db->where("email", $this->session->userdata('email'));
			$this->db->join('user_role', 'user_role.id = user.role_id');
			$coba = $this->db->get()->row_array();
			$data['user_all'] = $coba;
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.harga_perlot, 0) as jumlah_pendanaan, project_document.prospektus as prospektus");
			$this->db->from('project');
			$this->db->where("project.end_ts >= ", time());
			$this->db->where("project.status ", 1);
			$this->db->where("project.version ", 1);
			$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
			$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			$this->db->order_by('project.create_ts', 'DESC');
			$this->db->group_by("project.id");


			$project = $this->db->get()->result_array();
			$data['project'] = $project;


			$data['role_user'] = $this->session->userdata('role_id');




			$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
			$this->db->order_by('project_retail.create_ts', 'DESC');
			$this->db->group_by("project_retail.id_project");
			$this->db->where('project_retail.status', 1);
			$this->db->limit(4, 0);
			$this->db->where('project_retail.end_ts >', time());
			$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
			$query1 = $this->db->get('project_retail')->result_array();

			$data['project_retail'] = $query1;


			$this->load->view('web_profile/header_web_profile.php', $data);
			$this->load->view('web_profile/tryfront', $data);
			$this->load->view('web_profile/footer_web_profile.php', $data);
		} else {
			$this->db->select('*');
			$this->db->from('video_cms');
			$this->db->group_by("id", "desc");
			$video = $this->db->get()->result_array();
			$data['video_cms'] = $video;
			if (!isset($data['video_cms'][1])) {
				$data['video_cms'][1] = [
					"nama" => "cek",
					"url" => "base_url('assetsprofile')/asset/images/dealfintech.jpg"
				];
			}
			if (!isset($data['video_cms'][2])) {
				$data['video_cms'][2] = [
					"nama" => "cek",
					"url" => "video/dealfintech.jpg"
				];
			}
			$this->db->select("project.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, sum(pendanaan.nominal)/project.harga_perlot as jumlah_pendanaan, project_document.prospektus as prospektus");
			$this->db->from('project');
			$this->db->where("project.end_ts >= ", time());
			$this->db->where("project.status ", 1);
			$this->db->where("project.version ", 1);
			$this->db->join('pendanaan', 'pendanaan.project_id = project.id', 'left');
			$this->db->join('project_document', 'project_document.project_id = project.id', 'left');
			$this->db->order_by('project.create_ts', 'DESC');
			$this->db->group_by("project.id");
			$project = $this->db->get()->result_array();
			$data['project'] = $project;



			$this->db->join('(select * from pendanaan where paid_ts > 0 or pending_ts > UNIX_TIMESTAMP()) as pendanaan', 'pendanaan.project_id = project_retail.id_project', 'left');
			$this->db->order_by('project_retail.create_ts', 'DESC');
			$this->db->group_by("project_retail.id_project");
			$this->db->where('project_retail.status', 1);
			$this->db->limit(4, 0);
			$this->db->where('project_retail.end_ts >', time());
			$this->db->select('project_retail.*, COALESCE(sum(pendanaan.nominal), 0) as nominal, CAST(COALESCE(sum(pendanaan.nominal)/1000000, 0) AS SIGNED) as jumlah_pendanaan');
			$query1 = $this->db->get('project_retail')->result_array();

			$data['project_retail'] = $query1;

			print_r($data['project']);
			exit();
			$this->load->view('web_profile/header_web_profile.php', $data);
			$this->load->view('web_profile/tryfront', $data);
			$this->load->view('web_profile/footer_web_profile.php', $data);
		}



		// $this->load->view('templates/footer');
	}

	public function perusahaan()
	{
		$this->load->view('web_profile/header_web_profile.php');
		$this->load->view('web_profile/perusahaan');
		$this->load->view('web_profile/footer_web_profile.php');
		// $this->load->view('templates/footer');
	}

	public function ceodantim()
	{
		$this->load->view('web_profile/ceodantim');
		// $this->load->view('templates/footer');
	}

	public function perusahaanpartner()
	{
		$this->load->view('web_profile/perusahaanpartner');
		// $this->load->view('templates/footer');

	}

	public function blog()
	{
		$this->load->view('web_profile/blog');
		// $this->load->view('templates/footer');
	}

	public function alurbisnispeminjam()
	{
		$this->load->view('web_profile/header_web_profile.php');
		$this->load->view('web_profile/alurbisnispeminjam');
		$this->load->view('web_profile/footer_web_profile.php');
		// $this->load->view('templates/footer');
	}

	public function pasarsekunder()
	{
		$this->load->view('web_profile/header_web_profile.php');
		$this->load->view('web_profile/pasarsekunder');
		$this->load->view('web_profile/footer_web_profile.php');
		// $this->load->view('templates/footer');
	}

	public function alurbisnispendana()
	{
		$this->load->view('web_profile/header_web_profile.php');
		$this->load->view('web_profile/alurbisnispendana');
		$this->load->view('web_profile/footer_web_profile.php');
		// $this->load->view('templates/footer');
	}

	public function resikoinvestasi()
	{
		$this->load->view('web_profile/header_web_profile.php');
		$this->load->view('web_profile/resikoinvestasi');
		$this->load->view('web_profile/footer_web_profile.php');
		// $this->load->view('templates/footer');
	}

	public function helpdesk()
	{
		$this->load->view('web_profile/helpdesk');
	}

	public function faq()
	{
		$this->load->view('web_profile/faq');
		// $this->load->view('templates/footer');
	}

	public function sk()
	{
		$this->load->view('web_profile/sk');
		// $this->load->view('templates/footer');
	}
}
