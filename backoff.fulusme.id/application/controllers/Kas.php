<?php

class Kas extends CI_Controller
{

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->helper(array('url', 'form'));
		$this->load->model('kas_model');
		$this->load->model('akun_model');
		$this->load->model('jurnal_model');
		$this->load->model('jurnal_unpost_model');
		$this->load->model('model_master');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
	}


	function transfer_kas()
	{
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = $this->lang->line('transfer_kas');
		$data['main_content'] = 'kas/display_transfer';
		$data['kas_data'] = $this->kas_model->get_all_data_trf($id);
		$this->load->view('template/template_xpanel', $data);
	}

	function transfer_kas_excel()
	{
		$this->load->library('phpexcel');
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = $this->lang->line('transfer_kas');
		$data['main_content'] = 'kas/display_transfer';

		$a['kas_data'] = $this->kas_model->get_all_data_trf($id);
		$data['nama_akun'] = $this->akun_model->get_all_data();
		$html = $this->load->view('kas/display_transfer_excel', $a);

		// Put the html into a temporary file
		$tmpfile = time() . '.html';
		file_put_contents($tmpfile, $html);

		// Read the contents of the file into PHPExcel Reader class
		$reader = new PHPExcel_Reader_HTML;
		$content = $reader->load($tmpfile);

		// Pass to writer and output as needed
		$objWriter = PHPExcel_IOFactory::createWriter($content, 'Excel2007');
		$objWriter->save('excelfile.xlsx');

		// Delete temporary file
		unlink($tmpfile);
	}


	function detail_data_transfer($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;
		$cek_post = $a_data->posting;
		if ($cek_post == '1') {
			$data['disabled'] = 'readonly';
			$data['disabled2'] = 'disabled';
			$data['tipe_trx'] = 'edit';
		} else {
			$data['disabled'] = '';
			$data['disabled2'] = '';
			$data['tipe_trx'] = 'edit';
		}
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['accounts1'] = $this->akun_model->get_all_kas();
		$data['accounts2'] = $this->akun_model->get_all_kas();
		$data['id_trx'] = $id;
		$data['id_trx_kas'] = $id_trx;
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['nama_akun'] = $this->akun_model->get_all_data();
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id_trx);
		$data['kas_data'] = $this->kas_model->get_all_data_in_byid($id);
		$data['title'] = $this->lang->line('detail_kas_keluar');
		$data['main_content'] = 'kas/detail_kas_transfer';
		$this->load->view('template/template_xpanel', $data);
	}


	function unpost_data_kas_trf($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id_trx . "' ");
		$a_data2 = $q_data2->row();
		$id_jurnal = $a_data2->id;

		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);

		$object2    = array(
			'posting' => 0
		);
		$this->db->where('id', $id);
		$this->db->update('tbl_trans_kas', $object2);


		redirect('kas/detail_data_transfer/' . $id, 'refresh');
	}

	function kas_keluar()
	{
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = $this->lang->line('kas_keluar');
		$data['main_content'] = 'kas/display_k_out';
		//$data['kas_data'] = $this->kas_model->get_all_data_out($id);

		$data['form_action'] = 'kas/kas_masuk';
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y', strtotime('-1 month'));
     	$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');

		$this->load->view('template/template_xpanel', $data);
	}


	function add_kas_out()
	{
		$data['f_id'] = 1;
		$data['f_id'] = 1;
		$identityID=$this->session->userdata('IDENTITY_ID');
		$akun = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='".$identityID."'")->result_array();	
		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['out']] = $value['nama'];
			}
		}
		$data['bank_data'] = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='".$identityID."'")->result();
		
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown_kas_bank();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['nama_akun'] = $this->akun_model->get_data_for_dropdown_umum();
		$data['title'] = $this->lang->line('tambah_kas_keluar');
		$data['main_content'] = 'kas/add_kas_keluar';
		$this->load->view('template/template_xpanel', $data);
	}

	function detail_data_out($id)
	{
		$identityID=$this->session->userdata('IDENTITY_ID');
		$akun = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='".$identityID."'")->result_array();	
		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['out']] = $value['nama'];
			}
		}
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;
		$cek_post = $a_data->posting;
		if ($cek_post == '1') {
			$data['disabled'] = 'readonly';
			$data['tipe_trx'] = 'edit';
		} else {
			$data['disabled'] = '';
			$data['tipe_trx'] = 'edit';
		}
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['id_trx'] = $id;
		$data['id_trx_kas'] = $id_trx;
		$data['jurnal_data'] = $this->jurnal_model->get_data_jur_kas($id_trx);
		$data['kas_data'] = $this->kas_model->get_all_data_in_byid($id);
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['nama_akun'] = $this->akun_model->get_data_for_dropdown_umum();
		$data['title'] = $this->lang->line('detail_kas_keluar');
		$data['main_content'] = 'kas/detail_kas_keluar';
		$this->load->view('template/template_xpanel', $data);
	}

	function report_kas_keluar()
	{
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = $this->lang->line('kas_keluar');

		$data['main_content'] = 'kas/report_k_out';
		$data['tanggal1']    = $this->input->post('start');
		$data['tanggal2']    = $this->input->post('end');
		$data['kas_data'] = $this->kas_model->get_all_data_out_custom($id, 1, $data['tanggal1'], $data['tanggal2']); //ambil data yang sudah diposting
		$data['saldo'] = $this->kas_model->get_saldo_out();
		$this->load->view('template/template_xpanel', $data);
	}
	function report_kas_masuk_old()
	{
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = $this->lang->line('kas_masuk');
		$data['main_content'] = 'kas/report_k_in';
		$month = (($this->input->post('month') != "") ? $this->input->post('month') : date("m"));
		$year = (($this->input->post('year') != "") ? $this->input->post('year') : date("Y"));
		$data['kas_data'] = $this->kas_model->get_all_data_in($id, 1, $month, $year); //ambil data yang sudah diposting
		$data['kas_data_last'] = $this->kas_model->get_all_data_in_last_month($id, '', $month, $year); //ambil data yang 
		$this->load->view('template/template_xpanel', $data);
	}
	function report_kas_masuk()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Buku Kas Bendahara Penerimaan';
		$data['main_content'] = 'kas/report_k_in_custom';
		$data['tanggal1']    = $this->input->post('start');
		$data['tanggal2']    = $this->input->post('end');

		$data['kas_data'] = $this->kas_model->get_all_data_in_custom($id, 1, $data['tanggal1'], $data['tanggal2']); //ambil data yang sudah diposting

		$data['saldo'] = $this->kas_model->get_saldo_in();
		//var_dump( $data['saldo'] ); die();
		$this->load->view('template/template_xpanel', $data);
	}
	function kas_masuk()
	{
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = $this->lang->line('kas_masuk');
		$data['main_content'] = 'kas/display_k_in';
		$month = (($this->input->post('month') != "") ? $this->input->post('month') : date("m"));
		$year = (($this->input->post('year') != "") ? $this->input->post('year') : date("Y"));
		//$data['kas_data'] = $this->kas_model->get_all_data_in($id, '', $month, $year); //ambil data yang
		$data['form_action'] = 'kas/kas_masuk';
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y', strtotime('-1 month'));
     	$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');

		$this->load->view('template/template_xpanel', $data);
	}

	public function kas_view_data_table()
	{
		$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
		$limit = $_POST['length']; // Ambil data limit per page
		$start = $_POST['start']; // Ambil data start
		$order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
		$order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
		$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
		$lokasi = $this->input->post('lokasi');
		$date_start = $this->input->post('tgl1');
		$date_end = $this->input->post('tgl2');
		$jns_trans = $this->input->post('jns_trans');

		$sql_total = $this->kas_model->count_all( $order_field, $order_ascdesc, $lokasi, $jns_trans ); // Panggil fungsi count_all pada SiswaModel
		$sql_data = $this->kas_model->filter($search, $limit, $start, $order_field, $order_ascdesc, $lokasi, $date_start, $date_end, $jns_trans); // Panggil fungsi filter pada SiswaModel
		$sql_filter = $this->kas_model->count_filter($search, $order_field, $order_ascdesc, $lokasi, $date_start, $date_end, $jns_trans); // Panggil fungsi count_filter pada SiswaModel

		$callback = array(
		    'draw'=>$_POST['draw'], // Ini dari datatablenya
		    'recordsTotal'=>$sql_total,
		    'recordsFiltered'=>$sql_filter,
		    'data'=>$sql_data
		);

		header('Content-Type: application/json');
		echo json_encode($callback); die(); // Convert array $callback ke json
	}

	function add_kas_in()
	{
		$data['f_id'] = 1;
		$identityID=$this->session->userdata('IDENTITY_ID');
		$akun = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='".$identityID."'")->result_array();	
		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['out']] = $value['nama'];
			}
		}
		$data['bank_data'] = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='".$identityID."'")->result();
		
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown_kas_bank();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['nama_akun'] = $this->akun_model->get_data_for_dropdown_umum();
		$data['title'] = $this->lang->line('tambah_kas_masuk');
		$data['main_content'] = 'kas/add_kas_masuk';
		$this->load->view('template/template_xpanel', $data);
	}

	function detail_data_in($id)
	{
		$identityID=$this->session->userdata('IDENTITY_ID');
		$akun = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='".$identityID."'")->result_array();	
		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['out']] = $value['nama'];
			}
		}
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;
		$cek_post = $a_data->posting;
		if ($cek_post == '1') {
			$data['disabled'] = 'readonly';
			$data['tipe_trx'] = 'edit';
		} else {
			$data['disabled'] = '';
			$data['tipe_trx'] = 'edit';
		}
		
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['id_trx'] = $id;
		$data['id_trx_kas'] = $id_trx;
		$data['nama_akun'] = $this->akun_model->get_data_for_dropdown_umum();
		$data['jurnal_data'] = $this->jurnal_model->get_data_jur_kas($id_trx);
		$data['kas_data'] = $this->kas_model->get_all_data_in_byid($id);
		$data['title'] = $this->lang->line('detail_kas_masuk');
		$data['main_content'] = 'kas/detail_kas_masuk';
		$this->load->view('template/template_xpanel', $data);
	}

	function unpost_data_kas($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id_trx . "' ");
		$a_data2 = $q_data2->row();
		$id_jurnal = $a_data2->id;

		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);

		$object2    = array(
			'posting' => 0
		);
		$this->db->where('id', $id);
		$this->db->update('tbl_trans_kas', $object2);


		redirect('kas/detail_data_in/' . $id, 'refresh');
	}

	function unpost_data_kas_out($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id_trx . "' ");
		$a_data2 = $q_data2->row();
		$id_jurnal = $a_data2->id;

		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);

		$object2    = array(
			'posting' => 0
		);
		$this->db->where('id', $id);
		$this->db->update('tbl_trans_kas', $object2);


		redirect('kas/detail_data_out/' . $id, 'refresh');
	}
	


	function unpost_data_insurance($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id_trx . "' ");
		$a_data2 = $q_data2->row();
		$id_jurnal = $a_data2->id;

		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);

		$object2 = array(
			'posting' => 0
		);
		$this->db->where('id', $id);
		$this->db->update('tbl_trans_kas', $object2);


		redirect('kas/detail_data_insurance/' . $id, 'refresh');
	}
 

	function delete_data_kas($id, $id2)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id_trx . "' ");
		$a_data2 = $q_data2->row();
		$id_jurnal = $a_data2->id;

		$this->kas_model->delete_data($id);
		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);


		if ($id2 == 'km') {
			redirect('kas/kas_masuk', 'refresh');
		} else if ($id2 == 'kk') {
			redirect('kas/kas_keluar', 'refresh');
		} else if ($id2 == 'tk') {
			redirect('kas/transfer_kas', 'refresh');
		}
	}

	function nota($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$a['jurnal_data'] = $this->jurnal_model->get_data_id_debit($id_trx);
		$a['kas_data'] = $this->kas_model->get_all_data_in_byid($id);

		$this->load->view('kas/nota', $a);

		$html = $this->output->get_output();

		$this->load->library('dompdf_gen');

		$this->dompdf->load_html($html);

		$this->dompdf->render();
		$this->dompdf->stream($id_trx, array(
			'Attachment' => 0
		));
	}


	function nota_out($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$a['jurnal_data'] = $this->jurnal_model->get_data_id_kredit($id_trx);
		$a['kas_data'] = $this->kas_model->get_all_data_in_byid($id);

		$this->load->view('kas/nota_out', $a);

		$html = $this->output->get_output();

		$this->load->library('dompdf_gen');

		$this->dompdf->load_html($html);

		$this->dompdf->render();
		$this->dompdf->stream($id_trx, array(
			'Attachment' => 0
		));
	}


	function nota_transfer($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;

		$a['jurnal_data'] = $this->jurnal_model->get_data_id_kredit($id_trx);
		$a['kas_data'] = $this->kas_model->get_all_data_trf_byid($id);

		$this->load->view('kas/nota_transfer', $a);

		$html = $this->output->get_output();

		$this->load->library('dompdf_gen');

		$this->dompdf->load_html($html);

		$this->dompdf->render();
		$this->dompdf->stream($id_trx, array(
			'Attachment' => 0
		));
	}

	function rekap_bank()
	{
		$this->load->helper('indodate');
		$this->load->helper('finance');
		$this->load->library(array('auth', 'session', 'customlib'));

		$data['title'] = $this->lang->line('rekap_bank');
		$data['jenis_laporan'] = "rekap_bank";
		$data['main_content'] = 'kas/form_bank';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();

		$this->load->view('template/template_xpanel', $data);
	}

	function laporan_rekap_bank()
	{
		$this->load->library(array('auth', 'session', 'customlib'));

		$data['months'] = $this->customlib->get_month_name($this->input->post('bulan'));
		$data['years'] = $this->input->post('tahun');
		$data['jenis_laporan'] = $this->input->post('jenis_laporan');
		$data['dataLaporan'] = "";
		if ($data['jenis_laporan'] == "rekap_bank") {
			$data['dataLaporan'] = $this->db->query("SELECT
										akun.id id_akun,
										akun.nama nama_akun,
										akun.kode id,
										akun.saldo_awal,
										SUM(if(jurnal_detail.debit_kredit=1,nilai,0)) DEBIT,
										SUM(if(jurnal_detail.debit_kredit=0,nilai,0)) KREDIT
										FROM
										akun LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id
										WHERE 1
										AND akun.kode like '1120%'
										GROUP BY 
											akun.id
										ORDER BY
										akun.id")->result_array();
			$this->load->view('kas/laporan_rekap_bank', $data);
		} else {
			die("laporan tidak ditemukan");
		}
	}

	function detail_bank($id)
	{
		$this->load->helper('indodate');
		$this->load->helper('finance');
		$this->load->library(array('auth', 'session', 'customlib'));

		$data['title'] = $this->lang->line('rekap_bank');
		$data['jenis_laporan'] = "detail_bank";
		$data['main_content'] = 'kas/laporan_detail_bank';
		$data['dataLaporan'] = $this->db->query("SELECT
										jurnal_detail.id id,
										jurnal_detail.item,
										jurnal_detail.debit_kredit,
										jurnal_detail.nilai,
										jurnal.tgl,
										jurnal.keterangan,
										jurnal.invoice_no
										FROM
										jurnal_detail LEFT JOIN jurnal ON  jurnal_detail.jurnal_id = jurnal.id
			
										WHERE jurnal_detail.akun_id = $id")->result_array();
		$this->load->view('template/template_xpanel', $data);
	}

	function insurance()
	{
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = $this->lang->line('kas_masuk') . " " . $this->lang->line('insurance');
		$data['main_content'] = 'kas/display_insurance';
		$data['kas_data'] = $this->kas_model->get_all_data_insurance($id);
		$this->load->view('template/template_xpanel', $data);
	}
	function add_kas_insurance()
	{
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['title'] = $this->lang->line('tambah_kas_masuk') . " " . $this->lang->line('insurance');;
		$data['main_content'] = 'kas/add_kas_insurance';
		$this->load->view('template/template_xpanel', $data);
	}
	function detail_data_insurance($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->no_trx_kas;
		$cek_post = $a_data->posting;
		if ($cek_post == '1') {
			$data['disabled'] = 'readonly';
			$data['tipe_trx'] = 'edit';
		} else {
			$data['disabled'] = '';
			$data['tipe_trx'] = 'edit';
		}
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['id_trx'] = $id;
		$data['id_trx_kas'] = $id_trx;
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id_trx);
		$data['kas_data'] = $this->kas_model->get_all_data_in_byid($id);
		$data['title'] = $this->lang->line('detail_insurance');
		$data['main_content'] = 'kas/detail_data_insurance';
		$this->load->view('template/template_xpanel', $data);
	}

	function add_kas_transfer()
	{
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$data['accounts'] = $this->akun_model->get_data_for_dropdown_kas_bank();
		$data['title'] = $this->lang->line('tambah_transfer_kas');
		$data['main_content'] = 'kas/add_kas_transfer';
		$this->load->view('template/template_xpanel', $data);
	}

	public function add_kas_transfer_to_bendahara()
	{
		$data['f_id'] = 1;
		$data['tf_ke'] = 136; // kas bendahara penerima
		$data['tf_dari'] = 642; // kas kasir
		$data['type_trx'] = 'Pemasukan';
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['title'] = 'Form Setor Kasir Ke Bendahara Penerimaan';
		$data['main_content'] = 'kas/add_kas_transfer_to_bendahara';
		$data['total_setor'] = $this->jurnal_unpost_model->get_total_setoran_kasir();

		$this->load->view('template/template_xpanel', $data);
	}

	public function add_kas_setor_bank()
	{
		$data['f_id'] = 1;
		$data['tf_dari'] = 136; // kas bendahara penerimaan
		$data['type_trx'] = 'Transfer';
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown(null, '111010');
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['title'] = 'Form Setor Bank';
		$data['main_content'] = 'kas/add_kas_setor_bank';
		$data['total_setor'] = $this->jurnal_unpost_model->get_total_setoran_kasir();

		$this->load->view('template/template_xpanel', $data);
	}

	public function add_penerimaan_kasir_lain()
	{
		$data['f_id'] = 1;
		$data['tf_ke'] = 4; // coa kas kasir
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown(4);
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['title'] = 'Form Penerimaan Lain-lain';
		$data['main_content'] = 'kas/add_penerimaan_kasir_lain';
		$data['total_setor'] = $this->jurnal_unpost_model->get_total_setoran_kasir();

		$this->load->view('template/template_xpanel', $data);
	}

	public function history_kas()
	{
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['nama_akun'] = $this->akun_model->get_all_data();
		$data['title'] = "Histori Kas ";
		$data['main_content'] = 'kas/histori_kas';

		$akun = $this->input->post('akun');
		$data['selected_akun'] = $akun;
		$tgl_awal = $this->input->post('tgl1');
		$tgl_akhir = $this->input->post('tgl2');
		$data['akun'] = $akun;
		$data['account_data'] = $this->akun_model->get_data_by_id_saldo($akun);
		$data['histori_data'] = $this->kas_model->getHistori($akun, $tgl_awal, $tgl_akhir);
		$data['saldo_akun'] = $this->db->select('akun_saldo.saldo')->from('akun_saldo')->where('akun_id', $akun)->where('akun_id', $akun)->get()->row();
		$this->load->view('template/template_xpanel', $data);
	}

	public function rekonsiliasi()
	{
		$data['f_id'] = 1;
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$data['all_kas'] = $this->akun_model->get_all_kas();
		$data['nama_akun'] = $this->akun_model->get_all_data();
		$data['title'] = "Rekonsiliasi Bank";
		$data['main_content'] = 'kas/rekonsiliasi';

		$akun = $this->input->post('akun');
		$tgl_awal = $this->input->post('tgl1');
		$tgl_akhir = $this->input->post('tgl2');
		$data['histori_data'] = $this->kas_model->getHistori($akun, $tgl_awal, $tgl_akhir);
		$data['saldo_akun'] = $this->db->select('akun.saldo')->from('akun')->where('id', $akun)->get()->row();
		$this->load->view('template/template_xpanel', $data);
	}
}
