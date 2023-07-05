<?php
class Hutang extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library(array('auth','session','customlib'));
		$this->auth->check_user_authentification();
		$this->load->model('jurnal_model');	
		$this->load->model('akun_model');
		$this->load->model('pajak_model');
		$this->load->model('laporankeuangan_model');
		$this->load->helper('indodate');
		$this->load->helper('finance');
		$this->load->model('hutang_model');	
		//$this->load->library(array('fpdf'));
		$this->load->helper(array('date','url'));
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	}
	
	function index()
	{
		//$this->keuangan();
	}
	
	function saldo_awal()
	{
		$data['title'] = "Saldo Awal Hutang";
		$data['main_content'] = 'hutang/display';
		$data['piutang_data'] = $this->hutang_model->get_all_data_hutang();
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	function kartu_utang($id)
	{
		$q_data2 = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '".$id."' ");
        $a_data2 = $q_data2->row();
		$data['supp_name'] = $a_data2->supplierName;
		$identityID=$this->session->userdata('IDENTITY_ID');
		$data['journal_data'] = $this->jurnal_model->get_data_utang($id);
		$data['title'] = "Kartu Hutang";
		$data['main_content'] = 'hutang/display_kartu_utang';
		$data['client_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}
	
	function add_saldo()
	{
		$identityID=$this->session->userdata('IDENTITY_ID');
		$data['title'] = "Tambah Saldo Hutang";
		$data['main_content'] = 'hutang/form_saldo';
		 $data['suppliers'] = $this->db->where('identityID', $identityID)->get('as_suppliers')->result();
		 $data['nama_akun'] = $this->akun_model->get_all_data_utang();
		  $data['nama_akun2'] = $this->akun_model->get_all_data2();
		$data['act'] = 'add';
		$data['form_act'] = 'insert_saldo';
		$data['client_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}
	
	function insert_saldo()
	{
		$this->hutang_model->fill_data();
		$this->hutang_model->insert_data();
		$this->session->set_userdata('SUCCESSMSG', 'Input Saldo sukses ;)');
		redirect('purchasing/purchasing_utang');			
	}


	function rekap(){
		$data['title'] = $this->lang->line('rekap_hutang');
		$data['jenis_laporan'] = "rekap_hutang";
		$data['main_content'] = 'hutang/form';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();

		$this->load->view('template/template_xpanel', $data);
	}
	function detail(){
		$data['title'] = $this->lang->line('detail_hutang');
		$data['jenis_laporan'] = "detail_hutang";
		$data['main_content'] = 'hutang/form';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();

		$this->load->view('template/template_xpanel', $data);
		
	}
	function laporan_hutang(){
		$data['months'] = $this->customlib->get_month_name($this->input->post('bulan'));
		$data['years'] = $this->input->post('tahun');
		$data['jenis_laporan'] = $this->input->post('jenis_laporan');
		$data['dataLaporan']="";
		if($data['jenis_laporan'] == "rekap_hutang"){
			$data['dataLaporan'] = $this->db->query("SELECT 
										as_buy_transactions.invoiceBuyID,
										as_buy_transactions.no_dokumen,
										as_buy_transactions.supplierID,
										as_buy_transactions.trxFullName,
										as_buy_transactions.trxAddress,
										as_buy_transactions.trxPhone,
										as_buy_transactions.trxDate, 
										as_buy_transactions.note,
										as_buy_transactions.trxTerminDate,
										as_buy_transactions.is_pay,
										SUM(as_buy_transactions.trxTotal) trxTotal,
										as_buy_transactions.invoiceOrderID, 
										as_suppliers.supplierName,
										as_suppliers.supplierAddress,
										as_suppliers.supplierPhone,
										sum(as_debts_payment.debtPay) tot_bayar
										FROM
										as_buy_transactions LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_suppliers.supplierCode
										LEFT JOIN as_debts ON as_debts.invoiceID = as_buy_transactions.invoiceBuyID and as_buy_transactions.receiveNo = as_debts.receiveNo
										LEFT JOIN as_debts_payment ON as_debts_payment.debtID = as_debts.debtID
										WHERE 1
										GROUP BY 
										as_buy_transactions.supplierID,
										as_buy_transactions.invoiceBuyID
										ORDER BY  as_buy_transactions.supplierID")->result_array();
			$this->load->view('hutang/laporan_rekap', $data);

		}else if($data['jenis_laporan'] == "detail_hutang"){
				$data['dataLaporan'] = $this->db->query("SELECT
							kelompok_akun.nama as nama_kelompok,
							akun.nama as nama_akun,
							sum(if(jurnal_detail.debit_kredit =0,jurnal_detail.nilai,0)) AS DEBIT,
							sum(if(jurnal_detail.debit_kredit =1,jurnal_detail.nilai,0)) AS KREDIT
							FROM
							akun
							INNER JOIN kelompok_akun ON akun.kelompok_akun_id = kelompok_akun.id
							left JOIN jurnal_detail on jurnal_detail.akun_id = akun.id
							GROUP BY
							akun.id")->result_array();
			$this->load->view('hutang/laporan_rekap', $data);
		}else{
			die("laporan tidak ditemukan");
		}
	}
	
	
}