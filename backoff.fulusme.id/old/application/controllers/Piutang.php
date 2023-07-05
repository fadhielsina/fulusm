<?php
class Piutang extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library(array('auth','session','customlib'));
		$this->auth->check_user_authentification();
		$this->load->model('jurnal_model');	
		$this->load->model('jurnal_template_model');
		$this->load->model('akun_model');
		$this->load->model('pajak_model');
		$this->load->model('laporankeuangan_model');
		$this->load->helper('indodate');
		$this->load->helper('finance');
		$this->load->model('model_master');
		$this->load->model('piutang_model');	
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
		$data['title'] = "Saldo Awal Piutang";
		$data['main_content'] = 'piutang/display';
		$data['piutang_data'] = $this->piutang_model->get_all_data_piutang();
		$this->load->view('template/template_xpanel', $data);
	}
	
		function kartu_piutang($id)
	{
		$q_data2 = $this->db->query("SELECT * FROM as_members WHERE memberID = '".$id."' ");
        $a_data2 = $q_data2->row();
		$data['mem_name'] = $a_data2->memberFullName;
		$identityID=$this->session->userdata('IDENTITY_ID');
		$data['journal_data'] = $this->jurnal_model->get_data_piutang($id);
		$data['title'] = "Kartu Piutang";
		$data['main_content'] = 'piutang/display_kartu_piutang';
		$data['client_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}
	
	function sales_piutang()
	{
		$lokasi    = $this->input->post('lokasi');
		if($lokasi)
		{
			$id= $this->input->post('lokasi');
		}
		else
		{
			$id= $this->session->userdata('IDENTITY_ID');
		}
		

			$data['lokasi'] = $this->model_master->get_identity_lists(true);
			$data['title'] = $this->lang->line('hutang_pembelian');
		$data['main_content'] = 'piutang/display_piutang';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['form_action'] = 'piutang/sales_piutang';
		$data['journal_data'] = $this->piutang_model->get_data_recv($id);

		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	function piutang_detail_debt($id,$id2,$id3)
	{
		$identityID=$this->session->userdata('IDENTITY_ID');
		$akun = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='".$identityID."'")->result_array();	
		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['out']] = $value['nama'];
			}
		}
		$data['bank_data'] = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.nama like 'Bank%' and b.identityID='".$identityID."'")->result();
		
		$data['payno'] =$this->Genpaynumber();
		$data['debtIDtrx'] =$id2;
		$data['form_action'] = 'purchasing/insert_pay_debt';
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');	
		$q_data = $this->db->query("SELECT * FROM as_members WHERE memberID = '".$id."' ");
        $a_data = $q_data->row();
		$data['member'] =$a_data->memberFullName;
		$data['identity'] =$id3;
		$data['memberID'] =$a_data->memberID;
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['title'] = "Pembayaran Piutang";
		$data['template'] = $this->jurnal_template_model->get_all_data();
		$data['main_content'] = 'piutang/form_detail_pay';
		$this->load->view('template/template_xpanel', $data);
	}
	
	function simpan_termin_pay(){
      $debtID    = $this->input->post('debtID');
        $dibayar  = $dibayar  = str_replace(',','',$this->input->post('dibayar'));
		 $payno    = $this->input->post('payno');
        $data=$this->piutang_model->simpan_data_term_pay($debtID,$dibayar,$payno);
        echo json_encode($data);
    }
	
	function insert_pay_recv()
	{
				$memberid=$this->input->post('memberID');
				$q_data = $this->db->query("SELECT * FROM as_members WHERE memberID = '".$memberid."' ");
				$a_data = $q_data->row();
				$memberCode=$a_data->memberCode;
				
		$identity=$this->input->post('identity');
		$jnsjrn=$this->input->post('jnsjrn');
		$bank_akun=$this->input->post('bank_akun');
		
			// Jurnal bayar hutang
			$saldotrx=$this->input->post('total');
			
			$q2     = $this->db->query("SELECT * from tbl_config_akun WHERE con_code = 'pt_01'");

       		 $a2     = $q2->row();

     		   $piutang      = $a2->akun_id;
			   

		$nojur=$this->jurnal_model->GenJpp($identity);
		$fid="16";
		
		$this->jurnal_model->data = array(
			'no' =>  $nojur,
			'tgl' => $this->input->post('tanggalbyr'),
			'f_id' => $fid,
			'invoice_no' => $this->input->post('payno'),
			'keterangan' => $this->input->post('memo'),
			'identityID' => $identity,
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$akun = array();
		$akun[1] = array(
			'akun_id' => $this->input->post('akun_kas'), //kas
			'debit_kredit' => 1,
			'nilai' => $saldotrx,
			'keterangan' => ''
		);

		$akun[] = array(
				'akun_id' => $piutang, // piutang
				'debit_kredit' => 0,
				'nilai' => $saldotrx,
				'keterangan' => ''
			);

		// resorting item key
		foreach( $akun as $key => $v_ak ) {
			$akun[ $key ]['item'] = $key;
		}

		$this->jurnal_model->details = $akun;
		if ($this->jurnal_model->check_no()) {
			$this->jurnal_model->insert_data();
		}
		
			
			redirect('piutang/sales_piutang');
	
	}
	
	function add_saldo()
	{
		$identityID=$this->session->userdata('IDENTITY_ID');
		$data['title'] = "Tambah Saldo Piutang";
		$data['main_content'] = 'piutang/form_saldo';
		 $data['members'] = $this->db->where('identityID', $identityID)->get('as_members')->result();
		 $data['nama_akun'] = $this->akun_model->get_all_data_piutang();
		   $data['nama_akun2'] = $this->akun_model->get_all_data2();
		$data['act'] = 'add';
		$data['form_act'] = 'insert_saldo';
		$data['client_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}
	
	function insert_saldo()
	{
		$this->piutang_model->fill_data();
		$this->piutang_model->insert_data();
		$this->session->set_userdata('SUCCESSMSG', 'Input Saldo sukses ;)');
		redirect('piutang/sales_piutang');			
	}

	function rekap(){
		$data['title'] = $this->lang->line('rekap_piutang');
		$data['jenis_laporan'] = "rekap_piutang";
		$data['main_content'] = 'piutang/form';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();

		$this->load->view('template/template_xpanel', $data);
	}
	function detail($id,$year,$month){
		$data['title'] = $this->lang->line('detail_piutang');
		$data['jenis_laporan'] = "detail_piutang";
		$data['main_content'] = 'piutang/detail';
		$data['years'] = (($year>1)?$year:date("Y"));		
		$data['months'] = (($month>1)?date("M",strtotime("01-".$month."-".$data['years'])):date("M"));
		$data['month'] = (($month>1)?$month:date("m"));
		
		$data['is_detail'] =TRUE;
		$data['url_back'] =site_url("Piutang/rekap");


		$data['dataLaporan'] = $this->db->query("SELECT
                akun.id id_akun,
                akun.nama nama_akun,
                jurnal.*,
                if(jurnal_detail.debit_kredit=1,nilai,0) DEBIT,
                if(jurnal_detail.debit_kredit=0,nilai,0) KREDIT
              	FROM akun LEFT JOIN jurnal_detail on jurnal_detail.akun_id = akun.id
              	LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id
                WHERE 1
                AND (jurnal_detail.akun_id =  '".$id."' )
                AND year(jurnal.tgl) = '".$data['years']."'
                AND month(jurnal.tgl) = '".$data['month']."'
                 
                ORDER BY
                akun.id")->result_array();
			//$this->load->view('piutang/laporan_rekap', $data);
		if(count($data['dataLaporan'])>0){
			$data['title'] = 'Laporan Detail : '.$data['dataLaporan'][0]['nama_akun'];
		}
			$data['main_content'] = 'piutang/laporan_detail_piutang';	
			$this->load->view('template/template_xpanel', $data);
		
	}
	function laporan_piutang(){
		$data['months'] = $this->customlib->get_month_name($this->input->post('bulan'));
		$data['years'] = (($this->input->post('year')!="")?$this->input->post('year'):date("Y"));		
		$data['month'] = (($this->input->post('bulan')!="")?$this->input->post('bulan'):date("m"));
		$data['jenis_laporan'] = $this->input->post('jenis_laporan');
		$data['dataLaporan']="";
		if($data['jenis_laporan'] == "rekap_piutang"){
			$data['dataLaporan'] = $this->db->query("SELECT
									akun.id id_akun,
									akun.kode kode_akun,
									akun.nama nama_akun,
									akun.saldo_awal,
									(last_month_data.kredit - last_month_data.debit) total_last_month,
									SUM( IF ( tbl_jurnal.debit_kredit = 1, nilai, 0 ) ) DEBIT,
									SUM( IF ( tbl_jurnal.debit_kredit = 0, nilai, 0 ) ) KREDIT 
								FROM
									akun
									LEFT JOIN (
								SELECT
									jurnal.id,
									jurnal_detail.akun_id,
									jurnal_detail.debit_kredit,
									jurnal_detail.nilai 
								FROM
									jurnal
									LEFT JOIN jurnal_detail ON jurnal.id = jurnal_detail.jurnal_id 
									AND MONTH ( jurnal.tgl ) = '".$data['month']."' 
									AND YEAR ( jurnal.tgl ) = '".$data['years']."' 
									) tbl_jurnal ON tbl_jurnal.akun_id = akun.id 
									LEFT JOIN (
								SELECT
									kelompok_akun.nama AS nama_kelompok,
									akun.id kode_akun,
									akun.nama AS nama_akun,
									akun.saldo_awal,
									sum( IF ( jurnal_detail.debit_kredit = 0, jurnal_detail.nilai, 0 ) ) AS DEBIT,
									sum( IF ( jurnal_detail.debit_kredit = 1, jurnal_detail.nilai, 0 ) ) AS KREDIT 
								FROM
									akun
									LEFT JOIN kelompok_akun ON akun.kelompok_akun_id = kelompok_akun.id
									LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id
									LEFT JOIN jurnal ON jurnal_detail.jurnal_id = jurnal.id 
								WHERE
									MONTH ( jurnal.tgl ) = MONTH ( DATE_ADD( STR_TO_DATE('1,12,2019','%d,%m,%Y'), INTERVAL - 1 MONTH ) ) 
									AND YEAR ( jurnal.tgl ) = YEAR ( DATE_ADD( STR_TO_DATE('1,".$data['month'].",".$data['years']."','%d,%m,%Y'), INTERVAL - 1 MONTH ) ) 
								GROUP BY
									akun.id 
									) last_month_data ON last_month_data.kode_akun = akun.id 
								WHERE
									1 
									AND ( akun.kode LIKE '113%' OR akun.kode LIKE '114%' ) 
									AND LENGTH( akun.kode ) > 5 
								GROUP BY
									akun.kode 
								ORDER BY
									akun.kode")->result_array();
			$this->load->view('piutang/laporan_rekap', $data);

		}else if($data['jenis_laporan'] == "detail_piutang"){
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
			$this->load->view('piutang/laporan_rekap', $data);
		}else{
			die("laporan tidak ditemukan");
		}
	}
	
	function Genpaynumber()
	{
	
		$trxid = $this->db->query('SELECT * from as_receivables_payment  order by paymentID desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['recvInv'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 10, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 4, 5);
			if ($trxDate == $trxd) {
				$invnoa = $produksiIDfil + 1;
				$invnob = sprintf("%04d", $invnoa);
				$invno = $trxDate ."/". $invnob;
			} else {
				$trxDate = date('m/y');
				$trx = 1;
				$invoice = sprintf("%04d", $trx);
				$invno = $trxDate ."/". $invoice;
			}
		}

		$kode = "SIV-".$invno;
		return $kode;
	}
}