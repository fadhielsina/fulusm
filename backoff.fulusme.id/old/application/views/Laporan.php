<?php
class Laporan extends CI_Controller {

	public $identity_id;

	function __construct()
	{
		parent::__construct();	
		$this->load->library(array('auth','session','customlib', 'dompdf_gen'));
		$this->auth->check_user_authentification();
		$this->load->model('jurnal_model');	
		$this->load->model('akun_model');
		$this->load->model('pajak_model');
		$this->load->model('anggaran_model');
		$this->load->model('laporankeuangan_model');
		$this->load->helper('indodate');
		$this->load->helper('finance');
		$this->load->model('harta_model');
		$this->load->model('model_master');
		//$this->load->library(array('fpdf'));
		$this->load->helper(array('date','url'));
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));

		$this->identity_id = $this->session->userdata('IDENTITY_ID');
	}
	
	function index()
	{
		$this->keuangan();
	}
	function neraca2()
	{
		$data['title'] = $this->lang->line('laporan_neraca');
		$data['jenis_laporan'] = "neraca";
		$data['main_content'] = 'laporan_keuangan/form_rev2';
		$data['file_laporan'] = 'laporan_keuangan/laporan_neraca';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		
		$this->load->view('template/template_xpanel', $data);
	}	
	function neraca_saldo()
	{
		$data['title'] = $this->lang->line('laporan_neraca');
		$data['jenis_laporan'] = "neraca";
		$data['main_content'] = 'laporan_keuangan/form';
		$data['file_laporan'] = 'laporan_keuangan/laporan_neraca';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		
		$this->load->view('template/template_xpanel', $data);
	}	
	function neraca_lajur()
	{
		$data['title'] = $this->lang->line('laporan_neraca_lajur');
		$data['jenis_laporan'] = "neraca_lajur";
		$data['main_content'] = 'laporan_keuangan/form';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}
		
	function operasional()
	{
		$data['title'] = $this->lang->line('laporan_operasional');
		$data['jenis_laporan'] = "Operasional";
		$data['main_content'] = 'laporan_keuangan/form';
		$data['file_laporan'] = 'laporan_keuangan/laporan_operasional';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}	
	function arus_kas2()
	{
		$data['title'] = $this->lang->line('laporan_arus_kas');
		$data['jenis_laporan'] = "arus_kas";
		$data['main_content'] = 'laporan_keuangan/form_rev2';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}	
	function ekuitas2()
	{
		$data['title'] = $this->lang->line('perubahan_ekuitas');
		$data['jenis_laporan'] = "Ekuitas";
		$data['main_content'] = 'laporan_keuangan/form';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}	

	function laporan_keuangan(){
		$data['months'] = $this->customlib->get_month_name($this->input->post('bulan'));
		$data['years'] = $this->input->post('tahun');
		$data['start'] = $this->input->post('start');
		$data['end'] = $this->input->post('end');
		$data['periode'] = date("d M Y",strtotime($this->input->post('start'))).' - '.date("d M Y",strtotime($this->input->post('end')));
		$data['jenis_laporan'] = $this->input->post('jenis_laporan');
		//report title
		if(!is_array($data['months'])){
			$rptPeriode = $data['months'];
		}else{
			$rptPeriode = $data['periode'];
		}
		$data['rpt_title'] = '<h1 align="center">Laporan '.str_replace("_"," ", $data['jenis_laporan']).'</h1>';
		$data['rpt_title'] .= '<h3 align="center"> Periode :'.$rptPeriode.'</h3>';
		$data['dataLaporan']="";
		if($data['jenis_laporan'] == "neraca"){
		$data['dataLaporan'] = $this->db->query("SELECT  
					kode_sub_akun.nama_subakun , kelompok_akun.nama AS nama_kelompok, akun.nama AS nama_akun,  akun.saldo, akun.kode 
					FROM
						akun
					LEFT JOIN (
					SELECT
						akun.nama AS nama_subakun,
						akun.kelompok_akun_id,
						akun.id AS akunid,
						akun.kode,
						akun.parent_akun 
					FROM
						akun ) kode_sub_akun ON kode_sub_akun.kode = SUBSTRING(akun.kode,1,2) 						
						INNER JOIN kelompok_akun ON akun.kelompok_akun_id = kelompok_akun.id
						LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id
						LEFT JOIN jurnal ON jurnal_detail.jurnal_id = jurnal.id
						WHERE
						YEAR ( jurnal.tgl ) = '2019' 
						AND kelompok_akun.id IN ( 1, 2, 3 ) 
					GROUP BY
						akun.id
			")->result_array();
		$data['dataLaporanS'] = $this->db->query("SELECT
				kode_sub_akun.nama_subakun, kelompok_akun.nama AS nama_kelompok,
				akun.nama AS nama_akun, akun.saldo , akun.kode			
				FROM
				akun
				LEFT JOIN (
				SELECT
					akun.nama AS nama_subakun,
					akun.kelompok_akun_id,
					akun.id AS akunid,
					akun.kode,
					akun.parent_akun 
				FROM
					akun ) kode_sub_akun ON kode_sub_akun.kode = SUBSTRING(akun.kode,1,2) 						
				INNER JOIN kelompok_akun ON akun.kelompok_akun_id = kelompok_akun.id
				LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
                LEFT JOIN jurnal ON jurnal_detail.jurnal_id = jurnal.id 						
				WHERE 
				YEAR(jurnal.tgl) = year(DATE_ADD( CONCAT_WS('-', '".$this->input->post("tahun")."', '01', '01'), INTERVAL -1 YEAR))
				AND 
				kelompok_akun.id  IN (1,2,3) 
				GROUP BY
					akun.id
			")->result_array();
			$dataL = array ();
			foreach ( $data['dataLaporan'] as $lap ) {
				$dataL[$lap['nama_kelompok']] [$lap['nama_subakun']] [$lap['kode']]  = array ('nama_akun' => $lap['nama_akun'], 'stahunsekarang' => $lap['saldo']); 
			} 
			foreach ( $data['dataLaporanS'] as $lap ) {
				$dataL[$lap['nama_kelompok']] [$lap['nama_subakun']] [$lap['kode']] ['stahunsebelumnya'] = $lap['saldo']; 
			}

			//echo '<pre>'; print_r($dataL);  echo '</pre>';
			$data['output']= $dataL;			
			$this->load->view('laporan_keuangan/laporan_neraca', $data);
		}else if($data['jenis_laporan'] == "neraca_lajur"){
		$data['dataLaporan'] = $this->db->query("SELECT
							kelompok_akun.nama as nama_kelompok,
							akun.nama as nama_akun,
							sum(if(jurnal_detail.debit_kredit =0,jurnal_detail.nilai,0)) AS DEBIT,
							sum(if(jurnal_detail.debit_kredit =1,jurnal_detail.nilai,0)) AS KREDIT
							FROM
							akun
							INNER JOIN kelompok_akun ON akun.kelompok_akun_id = kelompok_akun.id
							left JOIN jurnal_detail on jurnal_detail.akun_id = akun.id
                                                        LEFT JOIN jurnal ON jurnal_detail.jurnal_id = jurnal.id 
                                                        WHERE 1
                                                        AND MONTH(jurnal.tgl) = '".$this->input->post("bulan")."'
                                                        AND YEAR(jurnal.tgl) = '".$this->input->post("tahun")."'
							GROUP BY
							akun.id")->result_array();
			$this->load->view('laporan_keuangan/laporan_neraca', $data);

		}else if($data['jenis_laporan'] == "Operasional"){
			$dataOperasional = $this->db->query("SELECT 'kegiatan Operasional' header,'1. pendapatan' as grouping, 			akun.*,sum(if(debit_kredit=0,nilai,0)) debit, sum(if(debit_kredit=1,nilai,0)) kredit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) ='2019' AND MONTH(jurnal.tgl) ='11'
					WHERE kelompok_akun_id=4
					AND kode not like '45%'
					GROUP BY akun.parent_akun
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'2. Beban Operasi' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) debit, sum(if(debit_kredit=1,nilai,0)) kredit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) ='2019' AND MONTH(jurnal.tgl) ='11'
					WHERE kelompok_akun_id=5  
					AND KODE like '51%'
					GROUP BY akun.parent_akun
					UNION 
					SELECT 'kegiatan Non Operasional' header,'3. kegiatan Non Operasional' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) debit, sum(if(debit_kredit=1,nilai,0)) kredit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) ='2019' AND MONTH(jurnal.tgl) ='11'
					WHERE kelompok_akun_id=4
					AND kode like '45%'
					GROUP BY akun.parent_akun
					UNION 
					SELECT 'Pos Luas Biasa' header,'4. Pos Luas Biasa' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) debit, sum(if(debit_kredit=1,nilai,0)) kredit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) ='2019' AND MONTH(jurnal.tgl) ='11'
					WHERE kelompok_akun_id=6 
					GROUP BY akun.parent_akun
					ORDER BY kode")->result_array();
 
			$data['dataLaporan'] = $dataOperasional;$dataOps;
			$this->load->view('laporan_keuangan/laporan_operasional', $data);
		}else if($data['jenis_laporan'] == "Ekuitas"){
			$data['dataLaporan'] = array(
								"EKUITAS AWAL"=>array("100000000","120000000"),			
								"SURPLUS/DEFISIT-LO"=>array("80000000","0"),
								"DAMPAK KUMULATIF PERUBAHAN KEBIJAKAN/KESALAHAN MENDASAR:"=>array("300000","3600000"),
								"   KOREKSI NILAI PERSEDIAAN"=>array("100000","1200000"),
								"   SELISIH REVALUASI ASET TETAP"=>array("100000","1200000"),
								"   SELISIH REVALUASI ASET TETAP"=>array("100000","1200000"),
								"EKUITAS AKHIR"=>array("180000000","120000000")
							);
			$this->load->view('laporan_keuangan/laporan_ekuitas', $data);
		}else if($data['jenis_laporan'] == "arus_kas"){
			$data['dataLaporan'] = $this->db->query("SELECT 
									'Kas_Arus' header,'Arus kas Dari Aktivitas Operasi' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
									FROM `akun` 
									LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
									LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
									WHERE kelompok_akun_id=4
									AND YEAR(jurnal.tgl) ='".$this->input->post("tahun")."'
									AND kode LIKE '4%'  
									GROUP BY  jurnal_detail.debit_kredit
								UNION									
									SELECT 
									'Kas_Arus' header,'Arus kas Dari Aktivitas Investasi' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
									FROM `akun` 
									LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
									LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
									WHERE kelompok_akun_id=4
									AND YEAR(jurnal.tgl) ='".$this->input->post("tahun")."'
									AND kode LIKE '51%'  
									AND kode not LIKE '512%'
									GROUP BY  jurnal_detail.debit_kredit
								UNION
									SELECT 
									'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
									FROM `akun` 
									LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
									LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
									WHERE kelompok_akun_id=4
									AND YEAR(jurnal.tgl) ='".$this->input->post("tahun")."'
									AND kode LIKE '319%'  
									GROUP BY  jurnal_detail.debit_kredit
								UNION
									SELECT 
									'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
									FROM `akun` 
									LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
									LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
									WHERE kelompok_akun_id=4
									AND YEAR(jurnal.tgl) ='".$this->input->post("tahun")."'
									AND kode LIKE '512%'  
									GROUP BY  jurnal_detail.debit_kredit"							
								)->result_array();	
			$data['dataLaporanS'] = $this->db->query("SELECT 
								'Kas_Arus' header,'Arus kas Dari Aktivitas Operasi' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
								FROM `akun` 
								LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
								LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
								WHERE kelompok_akun_id=4
								AND YEAR(jurnal.tgl) = year(DATE_ADD( CONCAT_WS('-', '".$this->input->post("tahun")."', '01', '01'), INTERVAL -1 YEAR))
								AND kode LIKE '4%'  
								GROUP BY  jurnal_detail.debit_kredit
							UNION									
								SELECT 
								'Kas_Arus' header,'Arus kas Dari Aktivitas Investasi' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
								FROM `akun` 
								LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
								LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
								WHERE kelompok_akun_id=4
								AND YEAR(jurnal.tgl) = year(DATE_ADD( CONCAT_WS('-', '".$this->input->post("tahun")."', '01', '01'), INTERVAL -1 YEAR))
								AND kode LIKE '51%'  
								AND kode not LIKE '512%'
								GROUP BY  jurnal_detail.debit_kredit
							UNION
								SELECT 
								'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
								FROM `akun` 
								LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
								LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
								WHERE kelompok_akun_id=4
								AND YEAR(jurnal.tgl) = year(DATE_ADD( CONCAT_WS('-', '".$this->input->post("tahun")."', '01', '01'), INTERVAL -1 YEAR))
								AND kode LIKE '319%'  
								GROUP BY  jurnal_detail.debit_kredit
							UNION
								SELECT 
								'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, jurnal_detail.debit_kredit
								FROM `akun` 
								LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
								LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
								WHERE kelompok_akun_id=4
								AND YEAR(jurnal.tgl) = year(DATE_ADD( CONCAT_WS('-', '".$this->input->post("tahun")."', '01', '01'), INTERVAL -1 YEAR))
								AND kode LIKE '512%'  
								GROUP BY  jurnal_detail.debit_kredit"							
							)->result_array();	
							$dataL = array ();
							foreach ( $data['dataLaporan'] as $lap ) {
								$dataL[$lap['grouping']] [$lap['debit_kredit']] [$lap['kode']]  = array ('nama_akun' => $lap['nama_akun'], 'stahunsekarang' => $lap['saldo']); 
							} 
							foreach ( $data['dataLaporanS'] as $lap ) {
								$dataL[$lap['grouping']] [$lap['debit_kredit']] [$lap['kode']] ['stahunsebelumnya'] = $lap['saldo']; 
							}
				
							//echo '<pre>'; print_r($dataL);  echo '</pre>';
							$data['output']= $dataL;
			$this->load->view('laporan_keuangan/laporan_arus_kas', $data); 
		}else if($data['jenis_laporan'] == "Inpatient"){
			$data['dataLaporan'] = $this->db->query('SELECT
                                                    jurnal_unpost.id,
                                                    jurnal_unpost.no,
                                                    jurnal_unpost.tgl,
                                                    jurnal_unpost.f_id,
                                                    jurnal_unpost.REGISTRATION_TYPE,
                                                    concat("Terima Uang Setoran Dari ",jurnal_unpost.DEPARTMENT_NAME) keterangan,
                                                    sum(if(jurnal_unpost_detail.debit_kredit=1,jurnal_unpost_detail.nilai,0)) debit,
                                                    sum(if(jurnal_unpost_detail.debit_kredit=0,jurnal_unpost_detail.nilai,0)) kredit
                                                    FROM
                                                    jurnal_unpost LEFT JOIN jurnal_unpost_detail ON jurnal_unpost_detail.jurnal_id = jurnal_unpost.id
                                                    WHERE
                                                    REGISTRATION_TYPE =\''.$data['jenis_laporan'].'\'
                                                    AND tgl BETWEEN \''.$this->input->post("start").'\' and \''.$this->input->post("end").'\'
                                                    GROUP BY
                                                    jurnal_unpost.id
                                                    ')->result_array();	
			//$this->load->view('laporan_keuangan/Outpatient', $data); 
		}else if($data['jenis_laporan'] == "Outpatient"){
			$data['dataLaporan'] = $this->db->query('SELECT
                                                    jurnal_unpost.id,
                                                    jurnal_unpost.no,
                                                    jurnal_unpost.tgl,
                                                    jurnal_unpost.f_id,
                                                    jurnal_unpost.REGISTRATION_TYPE,
                                                    concat("Terima Uang Setoran Dari ",jurnal_unpost.DEPARTMENT_NAME) keterangan,
                                                    (if(jurnal_unpost_detail.debit_kredit=1,jurnal_unpost_detail.nilai,0)) debit,
                                                    (if(jurnal_unpost_detail.debit_kredit=0,jurnal_unpost_detail.nilai,0)) kredit
                                                    FROM
                                                    jurnal_unpost LEFT JOIN jurnal_unpost_detail ON jurnal_unpost_detail.jurnal_id = jurnal_unpost.id
                                                    WHERE
                                                    REGISTRATION_TYPE =\''.$data['jenis_laporan'].'\'
                                                    AND tgl BETWEEN \''.$this->input->post("start").'\' and \''.$this->input->post("end").'\'
                                                    AND jurnal_unpost.is_posting=1
                                                    GROUP BY
                                                    jurnal_unpost.id')->result_array();	
			$this->load->view('laporan_keuangan/Outpatient', $data); 
		}else if($data['jenis_laporan'] == "IGD"){
			$data['dataLaporan'] = $this->db->query('SELECT
                                                    jurnal_unpost.id,
                                                    jurnal_unpost.no,
                                                    jurnal_unpost.tgl,
                                                    jurnal_unpost.f_id,
                                                    jurnal_unpost.REGISTRATION_TYPE,
                                                    concat("Terima Uang Setoran Dari ",jurnal_unpost.DEPARTMENT_NAME) keterangan,
                                                    (if(jurnal_unpost_detail.debit_kredit=1,jurnal_unpost_detail.nilai,0)) debit,
                                                    (if(jurnal_unpost_detail.debit_kredit=0,jurnal_unpost_detail.nilai,0)) kredit
                                                    FROM
                                                    jurnal_unpost LEFT JOIN jurnal_unpost_detail ON jurnal_unpost_detail.jurnal_id = jurnal_unpost.id
                                                    WHERE
                                                    REGISTRATION_TYPE =\''.$data['jenis_laporan'].'\'
                                                    AND tgl BETWEEN \''.$this->input->post("start").'\' and \''.$this->input->post("end").'\'
                                                    AND jurnal_unpost.is_posting=1
                                                    GROUP BY
                                                    jurnal_unpost.id')->result_array();	
			$this->load->view('laporan_keuangan/IGD', $data); 
		}else if($data['jenis_laporan'] == "Panjar"){
			$data['dataLaporan'] = $this->db->query("SELECT
							akun.id,akun.nama,akun.kode,akun.kelompok_akun_id,
							akun.pajak,akun.saldo_awal,	
                            akun.saldo,akun.keterangan,
							jurnal_detail.jurnal_id,
                            jurnal_detail.item,
                            (if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) debit,
                            (if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) kredit,
							jurnal_detail.nilai,jurnal.no,jurnal.tgl,jurnal.f_id,
							jurnal.keterangan uraian,jurnal.proyek_id,jurnal.invoice_no,
							jurnal.waktu_post,jurnal.is_posting
							FROM
							akun
							INNER JOIN jurnal_detail ON akun.id = jurnal_detail.akun_id
							INNER JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
							WHERE
							akun.kode LIKE '11504%'
							AND jurnal.tgl BETWEEN '".nice_date($this->input->post('start'),"Y-m-d")."'
							AND '".nice_date($this->input->post('end'),"Y-m-d")."'
							 ")->result_array();
			$this->load->view('laporan_blud/laporan_blud', $data);
		}else if($data['jenis_laporan'] == "Register_Bank"){
			$data['dataLaporan'] = $this->db->query("SELECT
							akun.id,akun.nama,akun.kode,akun.kelompok_akun_id,
							akun.pajak,akun.saldo_awal,	akun.saldo,akun.keterangan,
							jurnal_detail.jurnal_id,jurnal_detail.item,
                                                        (if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) debit,
                                                        (if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) kredit,
							jurnal_detail.nilai,jurnal.no,jurnal.tgl,jurnal.f_id,
							jurnal.keterangan uraian,jurnal.proyek_id,jurnal.invoice_no,
							jurnal.waktu_post,jurnal.is_posting
							FROM
							akun
							INNER JOIN jurnal_detail ON akun.id = jurnal_detail.akun_id
							INNER JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
							WHERE
							akun.kode LIKE '1110%'
							AND jurnal.tgl BETWEEN '".nice_date($this->input->post('start'),"Y-m-d")."'
							AND '".nice_date($this->input->post('end'),"Y-m-d")."'
							 ")->result_array();
			$this->load->view('laporan_blud/laporan_blud_r_bank', $data);
		}else if($data['jenis_laporan'] == "Register_SPM"){
			$data['dataLaporan'] = $this->db->query("select * from as_procurements 
							WHERE 
							not ISNULL(noSpm ) 
							AND date_spm BETWEEN '".nice_date($this->input->post('start'),"Y-m-d")."'
							AND '".nice_date($this->input->post('end'),"Y-m-d")."'
							 ")->result_array();
			$this->load->view('laporan_blud/laporan_spm', $data);
		}else if($data['jenis_laporan'] == "SPP"){
			$data['dataLaporan'] = $this->db->query("SELECT
							akun.id,akun.nama,akun.kode,akun.kelompok_akun_id,
							akun.pajak,akun.saldo_awal,	akun.saldo,akun.keterangan,
							jurnal_detail.jurnal_id,
                                                        jurnal_detail.item,
                                                        (if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) debit,
                                                        (if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) kredit,
							jurnal_detail.nilai,jurnal.no,jurnal.tgl,jurnal.f_id,
							jurnal.keterangan uraian,jurnal.proyek_id,jurnal.invoice_no,
							jurnal.waktu_post,jurnal.is_posting
							FROM
							akun
							INNER JOIN jurnal_detail ON akun.id = jurnal_detail.akun_id
							INNER JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
							WHERE
							akun.nama LIKE 'Bank%'
							AND MONTH(jurnal.tgl) = '".$this->input->post("bulan")."'
							AND YEAR(jurnal.tgl) = '".$this->input->post("tahun")."'
							 ")->result_array();
			$this->load->view('laporan_blud/laporan_spm', $data);
		}else if($data['jenis_laporan'] == "buku_pajak"){
			$data['dataLaporan'] = $this->db->query("SELECT
							akun.id,akun.nama,akun.kode,akun.kelompok_akun_id,
							akun.pajak,akun.saldo_awal,	akun.saldo,akun.keterangan,
							jurnal_detail.jurnal_id,jurnal_detail.item,
                                                        (if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) debit,
                                                        (if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) kredit,
							jurnal_detail.nilai,jurnal.no,jurnal.tgl,jurnal.f_id,
							jurnal.keterangan uraian,jurnal.proyek_id,jurnal.invoice_no,
							jurnal.waktu_post,jurnal.is_posting
							FROM
							akun
							INNER JOIN jurnal_detail ON akun.id = jurnal_detail.akun_id
							INNER JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
							WHERE
							akun.nama LIKE '%pajak%'
							AND jurnal.tgl BETWEEN '".nice_date($this->input->post('start'),"Y-m-d")."'
							AND '".nice_date($this->input->post('end'),"Y-m-d")."'
							 ")->result_array();
			$this->load->view('laporan_blud/laporan_pajak_r', $data);
		}else if($data['jenis_laporan'] == "Penerimaan_BLUD"){
			$data['p_bulan'] = $this->input->post('bulan');
			$data['p_tahun'] = $this->input->post('tahun');
			$data['dataLaporan'] = $this->db->query("SELECT
							`m_periode_anggaran`.`id_periode`,
							`m_mata_anggaran`.`id_anggaran`,
							`m_mata_anggaran`.`id_mata_anggaran`,
							`m_mata_anggaran`.`mata_anggaran`,
							`m_periode_anggaran`.`nama_periode`,
							`m_periode_anggaran`.`tanggal_awal`,
							`m_periode_anggaran`.`tanggal_akhir`,
							`m_periode_anggaran`.`is_aktif`,
							`m_mapping_anggaran`.`id_akun`,
							`m_mapping_anggaran`.`nominal`,
							`akun`.`nama` nama_akun,
							jurnal_data.debit_kredit,
							jurnal_data.debit,
							jurnal_data.kredit,
							jurnal_data_last.debit last_debit,
							jurnal_data_last.kredit last_kredit,
							jurnal_data_todate.debit todate_debit,
							jurnal_data_todate.kredit todate_kredit 
						FROM
							( m_periode_anggaran )
							INNER JOIN `m_mapping_anggaran` ON `m_periode_anggaran`.`id_periode` = `m_mapping_anggaran`.`id_periode`
							INNER JOIN `m_mata_anggaran` ON `m_mata_anggaran`.`id_mata_anggaran` = `m_periode_anggaran`.`id_mata_anggaran`
							LEFT JOIN `akun` ON `m_mapping_anggaran`.`id_akun` = `akun`.`id`
							LEFT JOIN (
						SELECT
							jurnal.`no`,
							jurnal.tgl,
							jurnal.invoice_no,
							jurnal_detail.id,
							jurnal_detail.jurnal_id,
							jurnal_detail.item,
							jurnal_detail.akun_id,
							jurnal_detail.debit_kredit,
							sum( IF ( jurnal_detail.debit_kredit = 1, jurnal_detail.nilai, 0 ) ) debit,
							sum( IF ( jurnal_detail.debit_kredit = 0, jurnal_detail.nilai, 0 ) ) kredit 
						FROM
							jurnal
							INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id 
						WHERE
							1 
							AND MONTH ( jurnal.tgl ) = '".$this->input->post("bulan")."'
							AND YEAR ( jurnal.tgl ) = '".$this->input->post("tahun")."'
						GROUP BY
							jurnal_detail.jurnal_id,
							jurnal_detail.akun_id 
							) jurnal_data ON jurnal_data.akun_id = akun.id
							LEFT JOIN (
						SELECT
							jurnal.`no`,
							jurnal.tgl,
							jurnal.invoice_no,
							jurnal_detail.id,
							jurnal_detail.jurnal_id,
							jurnal_detail.item,
							jurnal_detail.akun_id,
							jurnal_detail.debit_kredit,
							sum( IF ( jurnal_detail.debit_kredit = 1, jurnal_detail.nilai, 0 ) ) debit,
							sum( IF ( jurnal_detail.debit_kredit = 0, jurnal_detail.nilai, 0 ) ) kredit 
						FROM
							jurnal
							INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id 
						WHERE
							1 
							AND MONTH ( jurnal.tgl ) = MONTH ( DATE_ADD( CONCAT_WS( '-', '".$this->input->post("tahun")."', '".$this->input->post("bulan")."', '01' ), INTERVAL - 1 MONTH ) ) 
							AND YEAR ( jurnal.tgl ) = YEAR ( DATE_ADD( CONCAT_WS( '-', '".$this->input->post("tahun")."', '".$this->input->post("bulan")."', '01' ), INTERVAL - 1 MONTH ) ) 
						GROUP BY
							jurnal_detail.jurnal_id,
							jurnal_detail.akun_id 
							) jurnal_data_last ON jurnal_data_last.akun_id = akun.id
							LEFT JOIN (
						SELECT
							jurnal.`no`,
							jurnal.tgl,
							jurnal.invoice_no,
							jurnal_detail.id,
							jurnal_detail.jurnal_id,
							jurnal_detail.item,
							jurnal_detail.akun_id,
							jurnal_detail.debit_kredit,
							sum( IF ( jurnal_detail.debit_kredit = 1, jurnal_detail.nilai, 0 ) ) debit,
							sum( IF ( jurnal_detail.debit_kredit = 0, jurnal_detail.nilai, 0 ) ) kredit 
						FROM
							jurnal
							INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id 
						WHERE
							1 
							AND jurnal.tgl <= CONCAT_WS( '-', '".$this->input->post("tahun")."', '".$this->input->post("bulan")."', '01') 
						GROUP BY
							jurnal_detail.jurnal_id,
							jurnal_detail.akun_id 
							) jurnal_data_todate ON jurnal_data_todate.akun_id = akun.id 
						WHERE
							`m_periode_anggaran`.`id_periode` = ( SELECT m_periode_anggaran.id_periode FROM m_periode_anggaran WHERE is_aktif = 1 LIMIT 0, 1 ) 
						GROUP BY
							`m_periode_anggaran`.`id_periode`,
							`m_mapping_anggaran`.`id_akun`")->result_array();

			//var_dump( $this->db->last_query() );
			$this->load->view('laporan_blud/laporan_penerimaan_blud', $data);
		}else{	
			die("Laporan ".$data['jenis_laporan']  ." tidak ditemukan");
		}

		//$this->load->view('laporan_keuangan/laporan'.$jenis_laporan, $data);
	}

	
	function kasir()
	{
		$data['title'] = $this->lang->line('laporan_pendapatan_kasir');
		$data['nama_laporan'] = "kasir";
		$data['main_content'] = 'laporan_pendapatan/form_kasir';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		

		$this->load->view('template/template_xpanel', $data);

	}
	
	function ruangan()
	{
		$data['title'] = $this->lang->line('laporan_pendapatan_ruangan');
		$data['nama_laporan'] = "ruangan";
		$data['main_content'] = 'laporan_pendapatan/form_ruangan';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);

	}	

	function poli()
	{
		$data['title'] = $this->lang->line('laporan_pendapatan_poli');
		$data['nama_laporan'] = "poli";
		$data['main_content'] = 'laporan_pendapatan/form_poli';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);

	}

	function laporan_harian(){

		$data['jns_laporan'] = $this->input->post('jenis_laporan');
		$data['start'] = $this->input->post('start');
		$data['end'] = $this->input->post('end');
		$data['nama_kasir'] = $this->input->post('nama_kasir');
		$data['periode'] = date("d M Y",strtotime($this->input->post('start'))).' - '.date("d M Y",strtotime($this->input->post('end')));
		$data['poli'] = $this->input->post('jenis_poli');
		$data['title'] = strtoupper(str_replace("_", " ", $data['jns_laporan']));
		$data['error'] = "";
		$queryDaily = 'SELECT
                        jurnal_unpost.id,
                        jurnal_unpost.no,
                        jurnal_unpost.tgl,
                        jurnal_unpost.f_id,
                        jurnal_unpost.REGISTRATION_TYPE,
                        concat("Terima Uang Setoran Dari ",jurnal_unpost.DEPARTMENT_NAME) keterangan,
                        sum(if(jurnal_unpost_detail.debit_kredit=1,jurnal_unpost_detail.nilai,0)) debit,
                        sum(if(jurnal_unpost_detail.debit_kredit=0,jurnal_unpost_detail.nilai,0)) kredit
                        FROM
                        jurnal_unpost LEFT JOIN jurnal_unpost_detail ON jurnal_unpost_detail.jurnal_id = jurnal_unpost.id
                        WHERE
                        REGISTRATION_TYPE =\''.$this->input->post("nama_laporan").'\'
                        AND jurnal_unpost.is_posting=1
                         
                        AND tgl BETWEEN \''.nice_date($this->input->post('start'),"Y-m-d").'\' and \''.nice_date($this->input->post('end'),"Y-m-d").'\' ';
        if($data['poli'] !=""){
        	$queryDaily .= "AND jurnal_unpost.DEPARTMENT_NAME='".$data['poli']."' ";
        }                
        $queryDaily .='               
                        GROUP BY
                        jurnal_unpost.tgl,
                        jurnal_unpost.DEPARTMENT_CODE
                        ';
        $data['dataLaporan'] = $this->db->query($queryDaily)->result_array();	

                                                    
		$data['nama_laporan'] = $this->input->post('nama_laporan');

		if(strlen($data['start'])<=0 || strlen($data['end'])<=0){
			$data['error'] = $this->lang->line('valid_tgl_kosong');
		}else{
			$data['main_content'] = 'laporan_pendapatan/pendapatan_'.$data['nama_laporan'];
		}

		$this->load->view('laporan_pendapatan/laporan_harian', $data);

	}
	function laporan_bulanan(){
		$data['jns_laporan'] = $this->input->post('jenis_laporan');
		$data['start'] = $this->input->post('start');
		$data['end'] = $this->input->post('end');
		$data['nama_kasir'] = $this->input->post('nama_kasir');
		$periode = date("M Y",strtotime($this->input->post('start')));
		$data['periode'] = $periode;
		$data['poli'] = $this->input->post('jenis_poli');
		$data['title'] = strtoupper(str_replace("_", " ", $data['jns_laporan']));
		$data['error'] = "";	
		$data['nama_laporan'] = $this->input->post('nama_laporan');
		$queryMonthly = 'SELECT
                        jurnal_unpost.id,
                        jurnal_unpost.no,
                        jurnal_unpost.tgl,
                        jurnal_unpost.f_id,
                        jurnal_unpost.REGISTRATION_TYPE,
                        concat("Terima Uang Setoran Dari ",jurnal_unpost.DEPARTMENT_NAME) keterangan,
                        sum(if(jurnal_unpost_detail.debit_kredit=1,jurnal_unpost_detail.nilai,0)) debit,
                        sum(if(jurnal_unpost_detail.debit_kredit=0,jurnal_unpost_detail.nilai,0)) kredit
                        FROM
                        jurnal_unpost LEFT JOIN jurnal_unpost_detail ON jurnal_unpost_detail.jurnal_id = jurnal_unpost.id

                        WHERE
                        REGISTRATION_TYPE =\''.$data['nama_laporan'].'\'
                        AND jurnal_unpost.is_posting=1
                                      
                        AND MONTH(tgl) =  \''.nice_date($this->input->post('start'),"m").'\'
                        AND YEAR(tgl) =  \''.nice_date($this->input->post('start'),"Y").'\'
                        ';
        if($data['poli']!=""){
        	$queryMonthly .= 'AND jurnal_unpost.DEPARTMENT_NAME=\''.$data['poli'].'\' ';
        }
        $queryMonthly .= 'GROUP BY
                        jurnal_unpost.tgl,
                        jurnal_unpost.DEPARTMENT_CODE
                        ';
        $data['dataLaporan'] = $this->db->query($queryMonthly)->result_array();	
		
		if(strlen($data['start'])==0 ){
			$data['error'] = $this->lang->line('valid_tgl_kosong');
		}else{
			$data['main_content'] = 'laporan_pendapatan/pendapatan_'.$data['nama_laporan'];
		}
		

		$this->load->view('laporan_pendapatan/laporan_harian', $data);
	}
	function laporan_ri(){
		$data['title'] = "Report Inpatient";//$this->lang->line('laporan_pendapatan_ruangan');
		$data['nama_laporan'] = "Inpatient";
		$data['main_content'] = 'laporan_pendapatan/form_kasir';
                
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}
	function laporan_rj(){
		$data['title'] = "Report Outpatient";//$this->lang->line('laporan_pendapatan_ruangan');
		$data['nama_laporan'] = "Outpatient";
		$data['main_content'] = 'laporan_pendapatan/form_poli';
		$data['listInsurance'] = $this->db->query("SELECT * FROM view_insurance")->result_array();
		$data['listPoli'] = $this->db->query("SELECT * FROM view_department")->result_array();
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}
	function laporan_igd(){
		$data['title'] = "Report IGD";//$this->lang->line('laporan_pendapatan_ruangan');
		$data['nama_laporan'] = "IGD";
		$data['main_content'] = 'laporan_pendapatan/form_kasir';
                
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}
	function panjar()
	{
		$data['title'] = $this->lang->line('panjar');
		$data['jenis_laporan'] = "Panjar";
		$data['main_content'] = 'laporan_keuangan/form_rev';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}
	function register_bank()
	{
		$data['title'] = $this->lang->line('register')." Bank";
		$data['jenis_laporan'] = "Register_Bank";
		$data['main_content'] = 'laporan_keuangan/form_rev';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}
	
	function pajak()
	{
            $data['title'] = $this->lang->line('buku_pajak');
            $data['jenis_laporan'] = "buku_pajak";
            $data['main_content'] = 'laporan_keuangan/form_rev';		
            $data['months'] = bulan_list(1);
            $data['years'] = tahun_list();
            $this->load->view('template/template_xpanel', $data);
	}
    function penerimaan_blud(){
        $data['title'] = $this->lang->line('penerimaan_blud');
        $data['jenis_laporan'] = "Penerimaan_BLUD";
        $data['main_content'] = 'laporan_keuangan/form';		
        $data['months'] = bulan_list(1);
        $data['years'] = tahun_list();
        $this->load->view('template/template_xpanel', $data);
    }
	function penutupan_kas(){
        $data['title'] = $this->lang->line('penutupan_kas');
        $data['main_content'] = 'laporan_blud/penutupan_kas';		
        $data['months'] = bulan_list(1);
        $data['years'] = tahun_list();
        $this->load->view('template/template_xpanel', $data);
    }
    function proses_penutupan_kas(){
		$dataInput = array("tgl_penutupan"=>$this->input->post("tgl_penutupan"),
							"nama_petugas"=>$this->input->post("nama_petugas"),
							"tgl_penutupan_lalu"=>$this->input->post("tgl_penutupan_lalu"),
							"periode_penerimaan"=>$this->input->post("periode_penerimaan"),
							"jml_penerimaan"=>$this->input->post("jml_penerimaan"),
							"periode_pengeluaran"=>$this->input->post("periode_pengeluaran"),
							"jml_pengeluaran"=>$this->input->post("jml_pengeluaran"),
							"saldo_bank"=>$this->input->post("saldo_bank"),
							"saldo_tunai"=>$this->input->post("saldo_tunai"),
							"saldo_panjar"=>$this->input->post("saldo_panjar"),
							"pecahan_100000"=>$this->input->post("pecahan_100000"),
							"pecahan_50000"=>$this->input->post("pecahan_50000"),
							"pecahan_20000"=>$this->input->post("pecahan_20000"),
							"pecahan_10000"=>$this->input->post("pecahan_10000"),
							"pecahan_5000"=>$this->input->post("pecahan_5000"),
							"pecahan_2000"=>$this->input->post("pecahan_2000"),
							"pecahan_1000"=>$this->input->post("pecahan_1000"),
							"pecahan_koin_1000"=>$this->input->post("pecahan_koin_1000"),
							"pecahan_koin_500"=>$this->input->post("pecahan_koin_500"),
							"pecahan_koin_200"=>$this->input->post("pecahan_koin_200"),
							"pecahan_koin_100"=>$this->input->post("pecahan_koin_100"),
							"pecahan_koin_50"=>$this->input->post("pecahan_koin_50"),
							"pecahan_koin_25"=>$this->input->post("pecahan_koin_25")						
						);

		$this->db->insert("as_penutupan_kas",$dataInput);
		//$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert"> Register Pneutupan Kas Berhasil Ditambahkan!</div>');
		
		$this->_jurnal_penyusutan_assets();

		$this->penutupan_kas();
    }

    public function _jurnal_penyusutan_assets()
    {
    	$assets = $this->harta_model->get_aktiva_tetap();

    	if ( $assets ) {
    		foreach( $assets as $as ) {
    			$tahun_start = date('Y', strtotime( $as['trxDate'] ) );
    			$tahun_end = $tahun_start + $as['umur_ekonomis'];
    			$tahun_now = $as['last_periode'] + $tahun_start;
    			$next_periode = $as['last_periode'] + 1;

    			if ( $tahun_now <= $tahun_end ) {
    				$nilai_penyusutan = $as['detailBuySubtotal'] - $as['residu'] / $as['umur_ekonomis'];
    				// Jurnal the data
			        $this->jurnal_model->data = array(
			            'no' =>  $this->jurnal_model->GenJurNumber(),
			            'tgl' => date('Y-m-d'),
			            'f_id' => 1,
			            'invoice_no' => $as['detailBuyCode'],
			            'keterangan' => 'Jurnal Penyusutan untuk aktiva tetap ' . $as['detailBuyCode'],
			            'login_id' => $this->session->userdata('SESS_USER_ID'),
			            'waktu_post' => date("Y-m-d H:i:s")
			        );
			        $akun = array();
			        $akun[1] = array(
		                'akun_id' => $as['akun_depresiasi'], 
		                'debit_kredit' => 1,
		                'nilai' => $nilai_penyusutan,
		                'keterangan' => ''
		            );
		            $akun[] = array(
		                'akun_id' => $as['akun_akumulasi'], // kas id
		                'debit_kredit' => 0,
		                'nilai' => $nilai_penyusutan,
		                'keterangan' => ''
		            );
			        
			        // resorting item key
			        foreach( $akun as $key => $v_ak ) {
			            $akun[ $key ]['item'] = $key;
			        }

			        $this->jurnal_model->details = $akun;
			        if ($this->jurnal_model->check_no()) {
			            $this->jurnal_model->insert_data();

			            $this->db->query('UPDATE as_buy_detail_transactions SET last_periode = '. $next_periode .'  WHERE detailBuyCode= "'. $as['detailBuyCode'].'"');
			        }
    			}
    		}
    	}

    }

    public function cetak_print( $type = 'penerimaan_blud', $bulan = '', $tahun = '' )
    {
    	$bulan = '' === $bulan ? date('m') : $bulan;
    	$tahun = '' === $tahun ? date('Y') : $tahun;
    	$this->cetak_layout( $type, $bulan, $tahun );
    }

    protected function cetak_layout($type = 'penerimaan_blud', $bulan = '', $tahun )
    {
    	$data = array();
    	$data['months'] = $this->customlib->get_month_name( $bulan );
		$data['years'] = $tahun;
		$data['start'] = $this->input->post('start');
		$data['end'] = $this->input->post('end');
		$data['periode'] = date("d M Y",strtotime($this->input->post('start'))).' - '.date("d M Y",strtotime($this->input->post('end')));
		$data['jenis_laporan'] = $this->input->post('jenis_laporan');
    	
    	if ( 'penerimaan_blud' === $type ) {
	    	$data['dataLaporan'] = $this->db->query("SELECT
				`m_periode_anggaran`.`id_periode`,
				`m_mata_anggaran`.`id_anggaran`,
				`m_mata_anggaran`.`id_mata_anggaran`,
				`m_mata_anggaran`.`mata_anggaran`,
				`m_periode_anggaran`.`nama_periode`,
				`m_periode_anggaran`.`tanggal_awal`,
				`m_periode_anggaran`.`tanggal_akhir`,
				`m_periode_anggaran`.`is_aktif`,
				`m_mapping_anggaran`.`id_akun`,
				`m_mapping_anggaran`.`nominal`,
				`akun`.`nama` nama_akun,
				jurnal_data.debit_kredit,
				jurnal_data.debit,
				jurnal_data.kredit,
				jurnal_data_last.debit last_debit,
				jurnal_data_last.kredit last_kredit,
				jurnal_data_todate.debit todate_debit,
				jurnal_data_todate.kredit todate_kredit 
			FROM
				( m_periode_anggaran )
				INNER JOIN `m_mapping_anggaran` ON `m_periode_anggaran`.`id_periode` = `m_mapping_anggaran`.`id_periode`
				INNER JOIN `m_mata_anggaran` ON `m_mata_anggaran`.`id_mata_anggaran` = `m_periode_anggaran`.`id_mata_anggaran`
				LEFT JOIN `akun` ON `m_mapping_anggaran`.`id_akun` = `akun`.`id`
				LEFT JOIN (
			SELECT
				jurnal.`no`,
				jurnal.tgl,
				jurnal.invoice_no,
				jurnal_detail.id,
				jurnal_detail.jurnal_id,
				jurnal_detail.item,
				jurnal_detail.akun_id,
				jurnal_detail.debit_kredit,
				sum( IF ( jurnal_detail.debit_kredit = 1, jurnal_detail.nilai, 0 ) ) debit,
				sum( IF ( jurnal_detail.debit_kredit = 0, jurnal_detail.nilai, 0 ) ) kredit 
			FROM
				jurnal
				INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id 
			WHERE
				1 
				AND MONTH ( jurnal.tgl ) = '".$bulan."'
				AND YEAR ( jurnal.tgl ) = '".$tahun."'
			GROUP BY
				jurnal_detail.jurnal_id,
				jurnal_detail.akun_id 
				) jurnal_data ON jurnal_data.akun_id = akun.id
				LEFT JOIN (
			SELECT
				jurnal.`no`,
				jurnal.tgl,
				jurnal.invoice_no,
				jurnal_detail.id,
				jurnal_detail.jurnal_id,
				jurnal_detail.item,
				jurnal_detail.akun_id,
				jurnal_detail.debit_kredit,
				sum( IF ( jurnal_detail.debit_kredit = 1, jurnal_detail.nilai, 0 ) ) debit,
				sum( IF ( jurnal_detail.debit_kredit = 0, jurnal_detail.nilai, 0 ) ) kredit 
			FROM
				jurnal
				INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id 
			WHERE
				1 
				AND MONTH ( jurnal.tgl ) = MONTH ( DATE_ADD( CONCAT_WS( '-', '".$tahun."', '".$bulan."', '01' ), INTERVAL - 1 MONTH ) ) 
				AND YEAR ( jurnal.tgl ) = YEAR ( DATE_ADD( CONCAT_WS( '-', '".$tahun."', '".$bulan."', '01' ), INTERVAL - 1 MONTH ) ) 
			GROUP BY
				jurnal_detail.jurnal_id,
				jurnal_detail.akun_id 
				) jurnal_data_last ON jurnal_data_last.akun_id = akun.id
				LEFT JOIN (
			SELECT
				jurnal.`no`,
				jurnal.tgl,
				jurnal.invoice_no,
				jurnal_detail.id,
				jurnal_detail.jurnal_id,
				jurnal_detail.item,
				jurnal_detail.akun_id,
				jurnal_detail.debit_kredit,
				sum( IF ( jurnal_detail.debit_kredit = 1, jurnal_detail.nilai, 0 ) ) debit,
				sum( IF ( jurnal_detail.debit_kredit = 0, jurnal_detail.nilai, 0 ) ) kredit 
			FROM
				jurnal
				INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id 
			WHERE
				1 
				AND jurnal.tgl <= CONCAT_WS( '-', '".$tahun."', '".$bulan."', '01') 
			GROUP BY
				jurnal_detail.jurnal_id,
				jurnal_detail.akun_id 
				) jurnal_data_todate ON jurnal_data_todate.akun_id = akun.id 
			WHERE
				`m_periode_anggaran`.`id_periode` = ( SELECT m_periode_anggaran.id_periode FROM m_periode_anggaran WHERE is_aktif = 1 LIMIT 0, 1 ) 
			GROUP BY
				`m_periode_anggaran`.`id_periode`,
				`m_mapping_anggaran`.`id_akun`")->result_array();
			$this->load->view('laporan_blud/cetak_laporan_penerimaan_blud', $data);

		}
    }

    public function cetak_pdf( $type = 'penerimaan_blud', $bulan = '', $tahun = '' )
    {

    	$this->cetak_layout( $type, $bulan, $tahun );

    	//$this->load->library('curl');
		//$html = $this->curl->simple_get( 'http://surplus.test/laporan/cetak_print/penerimaan_blud');
    	
    	$html = $this->output->get_output();
        //die($html);
        $this->load->library('dompdf_gen');
        
        $this->dompdf->set_option('isRemoteEnabled', TRUE);
        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
        $this->dompdf->load_html($html);
        
        $this->dompdf->render();
        $this->dompdf->stream($type, array(
            'Attachment' => 0
        ));	
    }
	public function cetak_pdf_from_table()
    {
    	$pathGen = "generated/";
    	//clean file has been generated
    	$this->delete_oldfiles($pathGen,(60 * 30));


    	$html = $this->input->post('table');
    	$rpt_name = (($this->input->post('rpt_name')!="")?$this->input->post('rpt_name'):"Report_".date("YmdHis"));
    	//die($html);
    	//$this->load->library('curl');
		//$html = $this->curl->simple_get( 'http://surplus.test/laporan/cetak_print/penerimaan_blud');
    	
    	//$html = $this->output->get_output();
        //die($html);
        $head ="<html>
        <head>
        	<link type='text/css' href='".base_url()."assets/css/export_css.css' rel='stylesheet'> 
        	<style> 
        	#report_area td,#report_area th{
        		padding:2px;
        		border-bottom:1px solid #e9ecef;
        	}
        	#report_area{
        		width:100%;
        	}
        	</style>
        	</head>
        	<body>
        	";
        $footer ="</body></html>";	
        $pageLayout = $head.' '.$html.' '.$footer;
        $this->load->library('dompdf_gen');
        
        $this->dompdf->set_option('isRemoteEnabled', TRUE);
        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
        $this->dompdf->load_html($pageLayout);
        
        $this->dompdf->render();
        $output = $this->dompdf->output();
        $file = $pathGen."".$rpt_name.'.pdf';
    	if(file_put_contents($file, $output)){
    		$respon = array("message"=>"Cetak report  sukses","data"=>$file,"error"=>"0");
    	}else{
    		$respon = array("message"=>"Cetak report gagal","data"=>"","error"=>"1");
    	}


    	echo json_encode($respon);   
    

	}
	function delete_oldfiles($dir,$secs,$pattern = "/*")
	{
	    $now = time();
	    foreach(glob("$dir$pattern") as $f) {
	      if (is_file($f) && ($now - filemtime($f) > $secs)) unlink($f);
	    }
	}

	public function lb_standard()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Laba/Rugi (Standard)';
		$data['main_content'] = 'laporan_keuangan/laporan_laba_rugi';
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y', strtotime('-1 months') );
     	$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');
		$data['form_action'] = 'laporan/lb_standard';

		$data['data'] = array();
		$data['saldo'] = '';

		if ( 'post' === $this->input->method() ){
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ) );
			$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ) );
			$data['data'] = $this->db->query("SELECT 'kegiatan Operasional' header,'Pendapatan' as grouping, akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
				sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."'
					WHERE kelompok_akun_id=4 
					AND kode not like '45%'
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'HPP' as grouping, akun.*,
					 sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
					 sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."'
					WHERE kelompok_akun_id=5
					AND akun.id IN (85) 
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'Beban Operasional' as grouping, akun.*,
					 sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
					 sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."'
					WHERE kelompok_akun_id=5
					AND KODE not like '66%' AND akun.id not IN (85) 
					GROUP BY akun.kode
					UNION 
					SELECT 'kegiatan Non Operasional' header,'Beban Non Operasional' as grouping, akun.*,
					sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
					sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."'
					WHERE kelompok_akun_id=5
					AND kode like '66%'
					GROUP BY akun.kode
					UNION 
					SELECT 'Pos Luas Biasa' header,'Pos Luas Biasa' as grouping, akun.*,
					sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
					sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."'
					WHERE kelompok_akun_id=6
					GROUP BY akun.kode")->result_array();
			
				//var_dump( $this->db->last_query() ); die();
				$this->load->view('laporan_keuangan/laporan_laba_rugi__cetak', $data);

				if ( 'pdf' === $this->input->post('cetak_type') ) {
					$html = $this->output->get_output();
			        //die($html);
			        $this->load->library('dompdf_gen');
			        
			        $this->dompdf->set_option('isRemoteEnabled', TRUE);
			        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
			        $this->dompdf->load_html($html);
			        
			        $this->dompdf->render();
			        $this->dompdf->stream('laba-rugi-standard', array(
			            'Attachment' => 1
			        ));
		    	}
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function lb_periode()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Laba/Rugi (Multi Periode)';
		$data['main_content'] = 'laporan_keuangan/laporan_laba_rugi_periode';
		$data['start_tahun']    = $this->input->post('start_tahun');
		$data['end_tahun']    = $this->input->post('end_tahun');
		$data['form_action'] = 'laporan/lb_periode';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);

		$data['data'] = array();
		
		if ( 'post' === $this->input->method() ){
			$start_date = sprintf( '%d-01-01', $this->input->post('start_tahun') );
			$end_date = sprintf( '%d-01-01', $this->input->post('end_tahun') );

			$data['date_periodes'] = $this->_date_range($start_date, $end_date, "+1 year");
			$query_tgl = array();
			if ( count( $data['date_periodes'] ) > 0 ) {
				foreach( $data['date_periodes'] as $dt ) {
					$qr_debit = sprintf( "sum(if(debit_kredit=0 and year(tgl)=%d,nilai,0)) 'kredit_%s'", date('Y', strtotime($dt)), $dt );
					$qr_kredit = sprintf( "sum(if(debit_kredit=1 and year(tgl)=%d,nilai,0)) 'debit_%s'", date('Y', strtotime($dt)), $dt );
					array_push( $query_tgl, $qr_debit );
					array_push( $query_tgl, $qr_kredit );
				}
			}
			$query_print = implode(',', $query_tgl);

			$data['data'] = $this->db->query("SELECT 'kegiatan Operasional' header,'Pendapatan' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit, ". $query_print." 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) >=".$data['start_tahun']." AND YEAR(jurnal.tgl) <= ".$data['end_tahun']."
					WHERE kelompok_akun_id=4 
					AND kode not like '45%'
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'HPP' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit, ". $query_print." 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) >=".$data['start_tahun']." AND YEAR(jurnal.tgl) <= ".$data['end_tahun']."
					WHERE kelompok_akun_id=5
					AND kode IN (470)
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'Beban Operasional' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit, ". $query_print." 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) >=".$data['start_tahun']." AND YEAR(jurnal.tgl) <= ".$data['end_tahun']."
					WHERE kelompok_akun_id=5
					AND KODE not like '66%' AND kode NOT IN (470)
					GROUP BY akun.kode
					UNION 
					SELECT 'kegiatan Non Operasional' header,'Beban Non Operasional' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit, ". $query_print." 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) >=".$data['start_tahun']." AND YEAR(jurnal.tgl) <= ".$data['end_tahun']."
					WHERE kelompok_akun_id=5
					AND kode like '66%'
					GROUP BY akun.kode
					UNION 
					SELECT 'Pos Luas Biasa' header,'Pos Luas Biasa' as grouping, akun.*,sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit, ". $query_print." 
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) >=".$data['start_tahun']." AND YEAR(jurnal.tgl) <= ".$data['end_tahun']."
					WHERE kelompok_akun_id=6
					GROUP BY akun.kode")->result_array();

			//var_dump( $this->db->last_query() ); die();
			$this->load->view('laporan_keuangan/laporan_laba_rugi_periode__cetak', $data);

			if ( 'pdf' === $this->input->post('cetak_type') ) {
				$html = $this->output->get_output();
		        //die($html);
		        $this->load->library('dompdf_gen');
		        
		        $this->dompdf->set_option('isRemoteEnabled', TRUE);
		        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
		        $this->dompdf->load_html($html);
		        
		        $this->dompdf->render();
		        $this->dompdf->stream('laba-rugi-standard', array(
		            'Attachment' => 1
		        ));
	    	}
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function lb_departemen()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Laba/Rugi Departemen';
		$data['main_content'] = 'laporan_keuangan/laporan_laba_rugi_departemen';
		$data['tanggal1']    = $this->input->post('start');
		$data['tanggal2']    = $this->input->post('end');
		$data['form_action'] = 'laporan/lb_departemen';

		$data['data'] = array();
		$data['saldo'] = '';

		if ( 'post' === $this->input->method() ){

		}

		$this->load->view('template/template_xpanel', $data);
	}

	public function lb_anggaran()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Laba/Rugi Anggaran';
		$data['main_content'] = 'laporan_keuangan/laporan_laba_rugi_anggaran';
		$data['tanggal1']    = $this->input->post('start');
		$data['tanggal2']    = $this->input->post('end');
		$data['form_action'] = 'laporan/lb_anggaran';

		$data['data'] = array();
		$data['saldo'] = '';

		if ( 'post' === $this->input->method() ){

		}

		$this->load->view('template/template_xpanel', $data);
	}

	public function lb_unit()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Laba/Rugi Konsolidasi';
		$data['main_content'] = 'laporan_keuangan/laporan_laba_rugi_unit';
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y');
		$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');
		$data['form_action'] = 'laporan/lb_unit';

		$data['data'] = array();
		$data['saldo'] = '';

		if ( 'post' === $this->input->method() ){
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ) );

			$data['identities'] = $this->db->query("SELECT identityID, identityName FROM as_identity WHERE identityID NOT IN (1)")->result();

			$unit_query = array();
			foreach( $data['identities'] as $ident ) {
				$unit_query[] = "sum(if(debit_kredit=0 AND YEAR(jurnal.tgl) = YEAR('". $start_qr."') AND MONTH(jurnal.tgl) = MONTH('". $start_qr."') AND jurnal.identityID = ". $ident->identityID.",nilai,0)) kredit_unit_". $ident->identityID; 
				$unit_query[] = "sum(if(debit_kredit=1 AND YEAR(jurnal.tgl) = YEAR('". $start_qr."') AND MONTH(jurnal.tgl) = MONTH('". $start_qr."') AND jurnal.identityID = ". $ident->identityID.",nilai,0)) debit_unit_". $ident->identityID;
			}
			$unit_query = implode(',', $unit_query);
			
			$data['data'] = $this->db->query("SELECT 'kegiatan Operasional' header,'Pendapatan' as grouping, akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit,
				". $unit_query ."
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id 
					WHERE kelompok_akun_id=4 
					AND kode like '41%'
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'BIAYA' as grouping, akun.*,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit,
				". $unit_query ."
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id 
					WHERE kelompok_akun_id=5
					AND kode like '5%' 
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'HPP' as grouping, akun.*,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit,
				". $unit_query ."
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id 
					WHERE kelompok_akun_id=1
					AND kode like '1143%' 
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'HPPJ' as grouping, akun.*,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit,
				". $unit_query ."
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id 
					WHERE kelompok_akun_id=1
					AND kode like '1144%' 
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'BIAYA_USAHA' as grouping, akun.*,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit,
				". $unit_query ."
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id 
					WHERE kelompok_akun_id=6
					AND kode like '6%' 
					GROUP BY akun.kode
					UNION 
					SELECT 
					 'kegiatan Operasional' header,'PENDAPATAN_LL' as grouping, akun.*,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
					 sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit,
				". $unit_query ."
					FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id 
					WHERE kelompok_akun_id=9
					AND kode like '9%' 
					GROUP BY akun.kode")->result_array();
				
				//echo '<pre>';
				//print_r( $this->db->last_query() );
				//echo '</pre>'; die();
				//var_dump( $this->db->last_query() ); die();
				$this->load->view('laporan_keuangan/laporan_laba_rugi_unit__cetak', $data);
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function neraca()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Neraca (Standard)';
		$data['main_content'] = 'laporan_keuangan/laporan_neraca_std';
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y');
		$data['tanggal2']    = $this->input->post('end');
		$data['form_action'] = 'laporan/neraca';

		$data['data'] = array();
		$data['saldo'] = '';
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['lokasi'][0] = 'Tampilkan Semua';

		if ( 'post' === $this->input->method() ){
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ) );
			$this->identity_id = $this->input->post('lokasi');
			$show_all = 1 == $this->identity_id ? '' : "AND akun_saldo.identityID=". $this->identity_id;

			$data['data'] = $this->db->query("
				SELECT 'ASET LANCAR' as grouping, 
				akun.*,sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit 
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID 
				WHERE kelompok_akun_id=1 and kode REGEXP '^(1|2|3|4)' AND length(kode) > 3 ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'ASET TIDAK LANCAR' as grouping, 
				akun.*,sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit 
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID 
				WHERE kode REGEXP '^(4,)' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'KEWAJIBAN' as grouping, 
				akun.*,sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit 
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID 
				WHERE kode REGEXP '^(50|5,)' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'EKUITAS' as grouping, 
				akun.*,sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit 
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID 
				WHERE kode REGEXP '^(6,)' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'LABA' as grouping, 
				akun.*,sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit 
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID 
				WHERE kelompok_akun_id IN (4,5,9) ". $show_all ." GROUP BY akun.kode
			")->result_array();

			//echo '<pre>';
			//print_r( $this->db->last_query() );
			//echo '</pre>';	die();

			$this->load->view('laporan_keuangan/laporan_neraca_std__cetak', $data);

			if ( 'pdf' === $this->input->post('cetak_type') ) {
				$html = $this->output->get_output();
		        //die($html);
		        $this->load->library('dompdf_gen');
		        
		        $this->dompdf->set_option('isRemoteEnabled', TRUE);
		        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
		        $this->dompdf->load_html($html);
		        
		        $this->dompdf->render();
		        $this->dompdf->stream('neraca-standard', array(
		            'Attachment' => 1
		        ));
	    	}
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function neraca_periode()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Neraca (Multi Periode)';
		$data['main_content'] = 'laporan_keuangan/laporan_neraca_periode';

		$data['start_bulan']    = $this->input->post('start_bulan');
		$data['start_tahun']    = $this->input->post('start_tahun');
		$data['end_bulan']    = $this->input->post('end_bulan');
		$data['end_tahun']    = $this->input->post('end_tahun');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['form_action'] = 'laporan/neraca_periode';
		$tampil_tahunan = $this->input->post('tampil_data_tahunan');

		$data['data'] = array();
		
		if ( 'post' === $this->input->method() ){
			
			$query_tgl = array();
			if ( $tampil_tahunan ) {
				$start_date = sprintf( '%d-01-01', $this->input->post('start_tahun') );
				$end_date = sprintf( '%d-01-01', $this->input->post('end_tahun') );
				$data['date_periodes'] = $this->_date_range($start_date, $end_date, "+1 year");
				$data['format_date'] = 'Y';
				$data['format_date_label'] = 'Y';
				$data['periode_awal'] = date('Y', strtotime( $start_date ) );
				$data['periode_akhir'] = date('Y', strtotime( $end_date ) );

				if ( count( $data['date_periodes'] ) > 0 ) {
					foreach( $data['date_periodes'] as $dt ) {
						$qr_debit = sprintf( "sum(if(debit_kredit=0 and year(tgl)=%d,nilai,0)) 'kredit_%s'", date('Y', strtotime($dt)), $dt );
						$qr_kredit = sprintf( "sum(if(debit_kredit=1 and year(tgl)=%d,nilai,0)) 'debit_%s'", date('Y', strtotime($dt)), $dt );
						array_push( $query_tgl, $qr_debit );
						array_push( $query_tgl, $qr_kredit );
					}
				}
				$query_join = "LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND YEAR(jurnal.tgl) >=".$data['start_tahun']." AND YEAR(jurnal.tgl) <= ".$data['end_tahun'];
			} else {
				$start_date = sprintf( '%d-%d-01', $this->input->post('start_tahun'), $this->input->post('start_bulan') );
				$end_date = sprintf( '%d-%d-01', $this->input->post('end_tahun'), $this->input->post('end_bulan') );
				$data['date_periodes'] = $this->_date_range($start_date, $end_date, "+1 month");
				$data['format_date'] = 'm';
				$data['format_date_label'] = 'F Y';
				$data['periode_awal'] = date('F Y', strtotime( $start_date ) );
				$data['periode_akhir'] = date('F Y', strtotime( $end_date ) );

				if ( count( $data['date_periodes'] ) > 0 ) {
					foreach( $data['date_periodes'] as $dt ) {
						$qr_debit = sprintf( "sum(if(debit_kredit=0 and month(tgl)=%d and year(tgl)=%d,nilai,0)) 'kredit_%s'", date('m', strtotime($dt)), date('Y', strtotime($dt)), $dt );
						$qr_kredit = sprintf( "sum(if(debit_kredit=1 and month(tgl)=%d and year(tgl)=%d,nilai,0)) 'debit_%s'", date('m', strtotime($dt)), date('Y', strtotime($dt)), $dt );
						array_push( $query_tgl, $qr_debit );
						array_push( $query_tgl, $qr_kredit );
					}
				}
				$query_join = "LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."')";
			}

			$query_print = implode(',', $query_tgl);
			$data['data'] = $this->db->query("
				SELECT 'ASET LANCAR' as grouping, 
				akun.*, ". $query_print." 
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				". $query_join ." 
				WHERE kelompok_akun_id=1 and kode LIKE '11%' and length(kode) > 3 AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
				UNION
				SELECT 'ASET TIDAK LANCAR' as grouping, 
				akun.*, ". $query_print." 
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				". $query_join ." 
				WHERE kelompok_akun_id=1 and kode REGEXP '^(12|13)' AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
				UNION
				SELECT 'KEWAJIBAN' as grouping, 
				akun.*, ". $query_print." 
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				". $query_join ." 
				WHERE kelompok_akun_id=2 AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
				UNION
				SELECT 'EKUITAS' as grouping, 
				akun.*, ". $query_print." 
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				". $query_join ." 
				WHERE kelompok_akun_id=3 AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
				UNION
				SELECT 'LABA' as grouping, 
				akun.*, ". $query_print." 
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				". $query_join ."  
				WHERE kelompok_akun_id IN (4,5) AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
			")->result_array();
			//var_dump( $this->db->last_query() );	die();

			$this->load->view('laporan_keuangan/laporan_neraca_periode__cetak', $data);

			if ( 'pdf' === $this->input->post('cetak_type') ) {
				$html = $this->output->get_output();
		        //die($html);
		        $this->load->library('dompdf_gen');
		        
		        $this->dompdf->set_option('isRemoteEnabled', TRUE);
		        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
		        $this->dompdf->load_html($html);
		        
		        $this->dompdf->render();
		        $this->dompdf->stream('neraca-periode', array(
		            'Attachment' => 1
		        ));
	    	}
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function arus_kas()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Arus Kas';
		$data['main_content'] = 'laporan_keuangan/laporan_arus_kas_new';
		$data['start_bulan']    = $this->input->post('start_bulan');
		$data['start_tahun']    = $this->input->post('start_tahun');
		$data['end_bulan']    = $this->input->post('end_bulan');
		$data['end_tahun']    = $this->input->post('end_tahun');
		$data['form_action'] = 'laporan/arus_kas';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);

		$data['data'] = array();
		
		if ( 'post' === $this->input->method() ){
			$start_date = sprintf( '%d-%d-01', $this->input->post('start_tahun'), $this->input->post('start_bulan') );
			$end_date = sprintf( '%d-%d-01', $this->input->post('end_tahun'), $this->input->post('end_bulan') );

			$data['data'] = $this->db->query("
				SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Operasi' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."')
					WHERE kelompok_akun_id=4 
					AND kode LIKE '4%' AND jurnal.identityID=". $this->identity_id." 
					GROUP BY akun.kode
				UNION									
					SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Investasi' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."')
					WHERE kelompok_akun_id=1 AND jurnal.identityID=". $this->identity_id."
					AND kode LIKE '121%'  
					GROUP BY akun.kode
				UNION
					SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."') 
					WHERE kelompok_akun_id=2
					AND kode LIKE '222%' AND jurnal.identityID=". $this->identity_id."
					GROUP BY akun.kode
				UNION
					SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."') 
					WHERE kelompok_akun_id=3
					AND kode LIKE '311%' AND jurnal.identityID=". $this->identity_id."  
					GROUP BY akun.kode
				")->result_array();		

			//var_dump( $this->db->last_query() ); die();

			$this->load->view('laporan_keuangan/laporan_arus_kas__cetak', $data);

			if ( 'pdf' === $this->input->post('cetak_type') ) {
				$html = $this->output->get_output();
		        //die($html);
		        $this->load->library('dompdf_gen');
		        
		        $this->dompdf->set_option('isRemoteEnabled', TRUE);
		        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
		        $this->dompdf->load_html($html);
		        
		        $this->dompdf->render();
		        $this->dompdf->stream('arus-kas', array(
		            'Attachment' => 1
		        ));
	    	}
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function neraca_lj()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Neraca Lajur';
		$data['main_content'] = 'laporan_keuangan/laporan_neraca_lj';
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y');
		$data['tanggal2']    = $this->input->post('end');
		$data['form_action'] = 'laporan/neraca_lj';

		$data['data'] = array();
		$data['saldo'] = '';
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['lokasi'][1] = 'Tampilkan Semua';

		if ( 'post' === $this->input->method() ){
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ) );
			$this->identity_id = $this->input->post('lokasi');
			$show_all = 1 == $this->identity_id ? '' : "AND akun_saldo.identityID=". $this->identity_id;

			$data['data'] = $this->db->query("
				SELECT 'ASET LANCAR' as grouping, 
				akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID
				WHERE kelompok_akun_id=1 and kode REGEXP '^(10|1,|11)' ". $show_all ." GROUP BY akun.kode 
				UNION
				SELECT 'ASET TIDAK LANCAR' as grouping, 
				akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID
				WHERE kode LIKE '4,%' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'LIA_PENDEK' as grouping, 
				akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID
				WHERE kelompok_akun_id=2 AND kode REGEXP '^(50|5,0|5,1|51)' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'LIA_PANJANG' as grouping, 
				akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit 
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID
				WHERE kelompok_akun_id=2 AND kode REGEXP '^(52|5,2)' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'EKUITAS' as grouping, 
				akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID
				WHERE kode LIKE '6,%' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'PENGENDALI' as grouping, 
				akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID
				WHERE kelompok_akun_id=9 AND kode = '9900000' ". $show_all ." GROUP BY akun.kode
				UNION
				SELECT 'LABA' as grouping, 
				akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl <= '". $start_qr."',nilai,0)) kredit, sum(if(debit_kredit=1 AND jurnal.tgl <= '". $start_qr."',nilai,0)) debit,
				sum(if(debit_kredit=0 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_kredit,
				sum(if(debit_kredit=1 AND jurnal.tgl <= DATE_FORMAT( '". $start_qr."' - INTERVAL 1 MONTH, '%Y/%m/01' ),nilai,0)) last_debit
				FROM `akun` 
				LEFT JOIN akun_saldo ON akun_saldo.akun_id = akun.id 
				left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.identityID = akun_saldo.identityID
				WHERE kelompok_akun_id IN (4,5,9) ". $show_all ." GROUP BY akun.kode
			")->result_array();

			//var_dump( $this->db->last_query() );	die();

			$this->load->view('laporan_keuangan/laporan_neraca_lj__cetak', $data);

			if ( 'pdf' === $this->input->post('cetak_type') ) {
				$html = $this->output->get_output();
		        //die($html);
		        $this->load->library('dompdf_gen');
		        
		        $this->dompdf->set_option('isRemoteEnabled', TRUE);
		        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
		        $this->dompdf->load_html($html);
		        
		        $this->dompdf->render();
		        $this->dompdf->stream('neraca-lajur', array(
		            'Attachment' => 1
		        ));
	    	}
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function ekuitas()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Ekuitas';
		$data['main_content'] = 'laporan_keuangan/laporan_ekuitas_new';
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y', strtotime('-1 months') );
     	$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');
		$data['form_action'] = 'laporan/ekuitas';

		$data['data'] = array();
		$data['saldo'] = '';

		if ( 'post' === $this->input->method() ){
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ) );
			$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ) );

			$data['data'] = $this->db->query("
				SELECT 'KEWAJIBAN' as grouping, akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
				sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit  
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."' 
				WHERE kelompok_akun_id=2 AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
				UNION
				SELECT 'EKUITAS' as grouping, akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
				sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit  
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."'
				WHERE kelompok_akun_id=3 AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
				UNION
				SELECT 'LABA' as grouping, akun.*,
				sum(if(debit_kredit=0 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) kredit, 
				sum(if(debit_kredit=1 AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."',nilai,0)) debit
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='". $start_qr ."' AND jurnal.tgl <='". $end_qr ."'
				WHERE kelompok_akun_id IN (4,5) AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
			")->result_array();

			//var_dump( $this->db->last_query() );	die();

			$this->load->view('laporan_keuangan/laporan_ekuitas__cetak', $data);

		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function histori_bank()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Histori Bank';
		$data['main_content'] = 'laporan_keuangan/laporan_kas_bank';
		$data['tanggal1']    = $this->input->post('start');
		$data['tanggal2']    = $this->input->post('end');
		$data['form_action'] = 'laporan/histori_bank';
		$akun = $this->db->query("SELECT *
								FROM akun 
								WHERE kode 
								LIKE '112%'")->result_array();	
		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['id']] = $value['nama'].' - '.$value['kode'];
			}
		$idLap=$this->input->post('nama');
		$data['data'] = array();
		$data['saldo'] = '';
		//var_dump($idLap);

		if ( 'post' === $this->input->method() ){
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ) );
			$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ) );
			if ( $idLap !== ''){
				$data['s_akhir'] = $this->db->query("SELECT
										akun.nama AS grouping,
										sum( IF ( jurnal_detail.debit_kredit = 1, nilai, 0 ) ) as tambah,
										sum( IF ( jurnal_detail.debit_kredit = 0, nilai, 0 ) ) as kurang
									FROM
										`akun`
										LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id
										LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
									WHERE
										kelompok_akun_id = 1 
										AND akun.id = '".$idLap."' 
										AND jurnal.tgl BETWEEN '2015-01-01' AND ADDDATE('". $start_qr ."', INTERVAL - 1 DAY)
										AND jurnal.identityID=". $this->identity_id."
									GROUP BY
										jurnal_detail.jurnal_id")->result_array();	
				$data['data'] = $this->db->query("SELECT
									akun.nama AS grouping, akun.kode, akun.saldo_awal, akun.saldo,
									sum( IF ( debit_kredit = 1, nilai, 0 ) ) debit,
									sum( IF ( debit_kredit = 0, nilai, 0 ) ) kredit,
									jurnal.NO, jurnal.invoice_no, jurnal.tgl, jurnal_detail.keterangan 
								FROM
									`akun`
									LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id
									LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id 
								WHERE
									kelompok_akun_id = 1 
									AND akun.id = '".$idLap."' 
									AND jurnal.tgl BETWEEN '". $start_qr ."' 
									AND jurnal.identityID=". $this->identity_id."
									AND '". $end_qr ."' 
								GROUP BY
									jurnal_detail.jurnal_id
					")->result_array();
				$data['kop'] = $this->db->query("SELECT akun.nama as grouping, akun.kode, akun.saldo_awal FROM akun WHERE akun.id='".$idLap."' 
				")->result_array();
				//var_dump( $data );	die();
				$this->load->view('laporan_keuangan/laporan_hbank_cetak', $data);

			} elseif ( 'pdf' === $this->input->post('cetak_type') ) {
				$html = $this->output->get_output();
		        //die($html);
		        $this->load->library('dompdf_gen');
		        
		        $this->dompdf->set_option('isRemoteEnabled', TRUE);
		        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
		        $this->dompdf->load_html($html);
		        
		        $this->dompdf->render();
		        $this->dompdf->stream('histori-bank', array(
		            'Attachment' => 1
		        ));
	    	}
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
		}
	}

	public function aruskas_perakun()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Arus Kas per Akun';
		$data['main_content'] = 'laporan_keuangan/laporan_kas_bank';
		$data['tanggal1'] = $this->input->post('start');
		$data['tanggal2'] = $this->input->post('end');
		$data['form_action'] = 'laporan/aruskas_perakun';
		$akun = $this->db->query("SELECT * FROM akun WHERE kode LIKE '111%'")->result_array();
		if(count($akun)>0){
			foreach ($akun as $key => $value){
				$value = (array)$value;
				$data['akun'][$value['id']] = $value['nama'].'-'.$value['kode'];
			}
			$data['akunid'] = $this->input->post('nama');
			$idLap = $this->input->post('nama');
			$data['data'] = array();
			if( 'post' === $this->input->method() ){
				$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ));
				$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ));
					$mdata = $this->db->query("SELECT jurnal.invoice_no FROM akun
					INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
					INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
					INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
					WHERE akun.id= '". $idLap ."' AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' 
					AND jurnal.identityID=". $this->identity_id."
					GROUP BY jurnal_detail.jurnal_id
					")->result_array();
					if ( count($mdata)>0 ){
						for ($i = 0; $i < count($mdata);) {
						$dt[] = implode(',', $mdata[$i]); $i++ ;
						if (count($dt)>0){
							for ($i = 0; $i < count($dt);) {
					    $dat = implode("','", $dt); $i++;
					  	}
						}
					  }									
					//var_dump($dat);die();
					$data['data'] =  $this->db->query("SELECT
					akun.nama,	jurnal.tgl,
					  jurnal.invoice_no, dok
					  jurnal.keterangan,
					  tbl_trans_kas.akun AS tipe_transaksi,
					  jurnal_detail.debit_kredit as dk,
					  jurnal_detail.nilai, akun.id as akunid
				  FROM
					  jurnal
					  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
					  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
					  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
					  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
				  WHERE
					  jurnal.invoice_no IN ('" .$dat. "') 
					  AND jurnal.identityID=". $this->identity_id."
				  UNION
					SELECT
					'Saldo Awal Akun' AS nama,akun.tanggal AS tgl,	jurnal.invoice_no AS invoice_no,	akun.keterangan,	'Saldo Awal' AS tipe_transaksi,	 0 as dk ,	jurnal_detail.nilai, 0 as akunid
				FROM
					akun
					INNER JOIN jurnal_detail ON akun.id = jurnal_detail.akun_id 
					INNER JOIN jurnal ON jurnal_detail.jurnal_id = jurnal.id
				WHERE
					akun.id = '". $idLap ."' AND (SUBSTR(invoice_no FROM 1 FOR 2))='SA'
					AND akun.tanggal BETWEEN '". $start_qr ."' AND '". $end_qr ."' 
					AND jurnal.identityID=". $this->identity_id."
				ORDER BY
					tgl")->result_array(); }
					$data['line1'] = $this->db->query("SELECT akun.nama as nama_bank FROM akun WHERE akun.id = '". $idLap ."'")->result_array(); 	
					$this->load->view('laporan_keuangan/laporan_akpa_cetak', $data);
				} elseif ( 'pdf' === $this->input->post('cetak_type') ) {
					$html = $this->output->get_output();
					//die($html);
					$this->load->library('dompdf_gen');
					
					$this->dompdf->set_option('isRemoteEnabled', TRUE);
					$this->dompdf->set_option('isJavascriptEnabled', TRUE);
					$this->dompdf->load_html($html);
					
					$this->dompdf->render();
					$this->dompdf->stream('aruskas-perakun', array(
						'Attachment' => 1
					));
				} else {
					$this->load->view('template/template_xpanel', $data);
				}
			}
	}
	
	public function rincbayar_perbank()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Rincian Pembayaran per Bank';
		$data['main_content'] = 'laporan_keuangan/laporan_kas_bank';
		$data['tanggal1'] = $this->input->post('start');
		$data['tanggal2'] = $this->input->post('end');
		$data['form_action'] = 'laporan/rincbayar_perbank';
		$akun = $this->db->query("SELECT * FROM akun WHERE kode LIKE '111%'")->result_array();
		if(count($akun)>0){
			foreach ($akun as $key => $value){
				$value = (array)$value;
				$data['akun'][$value['id']] = $value['nama'].'-'.$value['kode'];
			}
			$data['akunid'] = $this->input->post('nama');
			$idLap = $this->input->post('nama');
			$data['data'] = array();
			if( 'post' === $this->input->method() ){
				$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ));
				$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ));
				$mdata = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pengeluaran%' AND akun.id= '". $idLap ."'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."'
				GROUP BY jurnal_detail.jurnal_id
				")->result_array();
				if ( count($mdata)>0 ){
					for ($i = 0; $i < count($mdata); ) {
					$dt[] = implode(",", $mdata[$i]); $i++;
					if (count($dt)>0){
						for ($i = 0; $i < count($dt);) {
						$dat = implode("','", $dt); $i++;
					}
					}
					}										
					//var_dump($dt);die();
				$data['data'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl,
				  jurnal.invoice_no,
				  jurnal.keterangan, dok,
				  tbl_trans_kas.akun AS tipe_transaksi,
				  jurnal_detail.debit_kredit as dk,
				  jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat. "') 
			  ORDER BY
			      tgl")->result_array(); }
					$data['line1'] = $this->db->query("SELECT akun.nama as nama_bank FROM akun WHERE akun.id = '". $idLap ."'")->result_array();
					$this->load->view('laporan_keuangan/laporan_rppa_cetak', $data);
				} elseif ( 'pdf' === $this->input->post('cetak_type') ) {
					$html = $this->output->get_output();
					//die($html);
					$this->load->library('dompdf_gen');
					
					$this->dompdf->set_option('isRemoteEnabled', TRUE);
					$this->dompdf->set_option('isJavascriptEnabled', TRUE);
					$this->dompdf->load_html($html);
					
					$this->dompdf->render();
					$this->dompdf->stream('rincbayar_perbank', array(
						'Attachment' => 1
					));
				} else {
					$this->load->view('template/template_xpanel', $data);
				}
		}
	}

	public function rpembayaran_bank()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Ringkasan Pembayaran per Bank';
		$data['main_content'] = 'laporan_keuangan/laporan_ringkasan_bank';
		$data['tanggal1'] = $this->input->post('start');
		$data['tanggal2'] = $this->input->post('end');
		$data['form_action'] = 'laporan/rpembayaran_bank';	
		$akun = $this->db->query("SELECT akun.id FROM akun WHERE kode LIKE '111%'")->result_array();	
			$data['data1'] = array();$data['data2'] = array();
			$data['data3'] = array();	$data['data4'] = array(); 
			if( 'post' === $this->input->method() ){
				$data['title'] = 'Ringkasan Pembayaran per Bank';
				$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ));
				$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ));
				$mdata1 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pengeluaran%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='4'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				$data['countKB'] =  count($mdata1);
				if ( count($mdata1)>0 ){
					for ($i = 0; $i < count($mdata1); ) {
						$dt1[] = implode(",", $mdata1[$i]); $i++;
						if (count($dt1)>0){
							for ($i = 0; $i < count($dt1);) {
								$dat1 = implode("','", $dt1); $i++;
							}}}	//var_dump($mdata1);die();
							$data['data1'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat1. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
				$mdata2 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pengeluaran%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='6'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				if ( count($mdata2)>0 ){
					for ($i = 0; $i < count($mdata2); ) {
						$dt2[] = implode(",", $mdata2[$i]); $i++;
						if (count($dt2)>0){
							for ($i = 0; $i < count($dt2);) {
								$dat2 = implode("','", $dt2); $i++;
							}}}	//var_dump($dt);die();
							$data['data2'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat2. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
				$data['countBM'] =  count($mdata2);
				//var_dump($data['countBM']);die();
				$mdata3 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pengeluaran%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='7'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				if ( count($mdata3)>0 ){
					for ($i = 0; $i < count($mdata3); ) {
						$dt3[] = implode(",", $mdata3[$i]); $i++;
						if (count($dt3)>0){
							for ($i = 0; $i < count($dt3);) {
								$dat3 = implode("','", $dt3); $i++;
							}}}	//var_dump($dt);die();
							$data['data3'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat3. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
				$data['countBNI'] =  count($mdata3);
				$mdata4 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pengeluaran%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='8'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				if ( count($mdata4)>0 ){
					for ($i = 0; $i < count($mdata4); ) {
						$dt4[] = implode(",", $mdata4[$i]); $i++;
						if (count($dt4)>0){
							for ($i = 0; $i < count($dt4);) {
								$dat4 = implode("','", $dt4); $i++;
							}}}	//var_dump($dt);die();
							$data['data4'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat4. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
			  $data['countBCA'] =  count($mdata4);
					$this->load->view('laporan_keuangan/laporan_ringkasan_pembayaranbank', $data);
				} elseif ( 'pdf' === $this->input->post('cetak_type') ) {
					$html = $this->output->get_output();
					//die($html);
					$this->load->library('dompdf_gen');					
					$this->dompdf->set_option('isRemoteEnabled', TRUE);
					$this->dompdf->set_option('isJavascriptEnabled', TRUE);
					$this->dompdf->load_html($html);					
					$this->dompdf->render();
					$this->dompdf->stream('rpembayaran_bank', array(
						'Attachment' => 1
					));
				} else {
					$this->load->view('template/template_xpanel', $data);
				}		
			}
			
			
	public function rpenerimaan_bank(){
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Ringkasan Penerimaan per Bank';
		$data['main_content'] = 'laporan_keuangan/laporan_ringkasan_bank';
		$data['tanggal1'] = $this->input->post('start');
		$data['tanggal2'] = $this->input->post('end');
		$data['form_action'] = 'laporan/rpenerimaan_bank';	
		$akun = $this->db->query("SELECT akun.id FROM akun WHERE kode LIKE '111%'")->result_array();	
			$data['data1'] = array();$data['data2'] = array();
			$data['data3'] = array();	$data['data4'] = array(); 
			if( 'post' === $this->input->method() ){
				$data['title'] = 'Ringkasan Penerimaan per Bank';
				$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ));
				$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ));
				$mdata1 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pemasukan%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='4'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				$data['countKB'] =  count($mdata1);
				if ( count($mdata1)>0 ){
					for ($i = 0; $i < count($mdata1); ) {
						$dt[] = implode(",", $mdata1[$i]); $i++;
						if (count($dt)>0){
							for ($i = 0; $i < count($dt);) {
								$dat = implode("','", $dt); $i++;
							}}}	//var_dump($dt);die();
							$data['data1'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
				$mdata2 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pemasukan%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='6'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				if ( count($mdata2)>0 ){
					for ($i = 0; $i < count($mdata2); ) {
						$dt[] = implode(",", $mdata2[$i]); $i++;
						if (count($dt)>0){
							for ($i = 0; $i < count($dt);) {
								$dat = implode("','", $dt); $i++;
							}}}	//var_dump($dt);die();
							$data['data2'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
				$data['countBM'] =  count($mdata2);
				//var_dump($data['countBM']);die();
				$mdata3 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pemasukan%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='7'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				if ( count($mdata3)>0 ){
					for ($i = 0; $i < count($mdata3); ) {
						$dt[] = implode(",", $mdata3[$i]); $i++;
						if (count($dt)>0){
							for ($i = 0; $i < count($dt);) {
								$dat = implode("','", $dt); $i++;
							}}}	//var_dump($dt);die();
							$data['data3'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
				$data['countBNI'] =  count($mdata3);
				$mdata4 = $this->db->query("SELECT jurnal.invoice_no FROM akun
				INNER JOIN jurnal_detail ON akun.id=jurnal_detail.akun_id
				INNER JOIN jurnal ON jurnal_detail.jurnal_id=jurnal.id
				INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas=jurnal.invoice_no
				WHERE tbl_trans_kas.akun LIKE 'Pemasukan%'  AND jurnal.tgl BETWEEN '". $start_qr ."' AND '". $end_qr ."' AND akun.id='8'
				GROUP BY jurnal_detail.jurnal_id ")->result_array();
				if ( count($mdata4)>0 ){
					for ($i = 0; $i < count($mdata4); ) {
						$dt[] = implode(",", $mdata4[$i]); $i++;
						if (count($dt)>0){
							for ($i = 0; $i < count($dt);) {
								$dat = implode("','", $dt); $i++;
							}}}	//var_dump($dt);die();
							$data['data4'] =  $this->db->query("SELECT
				akun.nama,	jurnal.tgl, jurnal.invoice_no, jurnal.keterangan, dok, tbl_trans_kas.akun AS tipe_transaksi,  jurnal_detail.debit_kredit as dk, jurnal_detail.nilai, akun.id as akunid
			  FROM
				  jurnal
				  INNER JOIN jurnal_detail ON jurnal_detail.jurnal_id = jurnal.id
				  INNER JOIN akun ON jurnal_detail.akun_id = akun.id
				  INNER JOIN tbl_trans_kas ON tbl_trans_kas.no_trx_kas = jurnal.invoice_no
				  LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no 
			  WHERE
				  jurnal.invoice_no IN ('" .$dat. "') 
			  GROUP BY dok
			  ORDER BY
				  tgl")->result_array(); }
			  $data['countBCA'] =  count($mdata4);
					$this->load->view('laporan_keuangan/laporan_ringkasan_pembayaranbank', $data);
				} elseif ( 'pdf' === $this->input->post('cetak_type') ) {
					$html = $this->output->get_output();
					//die($html);
					$this->load->library('dompdf_gen');					
					$this->dompdf->set_option('isRemoteEnabled', TRUE);
					$this->dompdf->set_option('isJavascriptEnabled', TRUE);
					$this->dompdf->load_html($html);					
					$this->dompdf->render();
					$this->dompdf->stream('rpenerimaan_bank', array(
						'Attachment' => 1
					));
				} else {
					$this->load->view('template/template_xpanel', $data);
				}		
	}

	public function proyeksi_kas()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Proyeksi Kas Per Bulan';
		$data['main_content'] = 'laporan_keuangan/laporan_proyeksi_kas';
		$data['start_bulan']    = $this->input->post('start_bulan');
		$data['start_tahun']    = $this->input->post('start_tahun');
		$data['end_bulan']    = $this->input->post('end_bulan') ? $this->input->post('end_bulan') : date('m', strtotime('+3 month') );
		$data['end_tahun']    = $this->input->post('end_tahun') ? $this->input->post('end_tahun') : date('Y', strtotime('+3 month') );
		$data['form_action'] = 'laporan/proyeksi_kas';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1, -5, 5);

		$data['data'] = array();
		
		if ( 'post' === $this->input->method() ){
			$start_date = sprintf( '%d-%d-01', $this->input->post('start_tahun'), $this->input->post('start_bulan') );
			$end_date = sprintf( '%d-%d-01', $this->input->post('end_tahun'), $this->input->post('end_bulan') );

			$data['date_periodes'] = $this->_date_range($start_date, $end_date, "+1 month");
			$query_saldo = array();
			$query_piutang = array();
			$query_hutang = array();
			
			if ( count( $data['date_periodes'] ) > 0 ) {
				foreach( $data['date_periodes'] as $dt ) {
					// saldo
					$qr_debit = sprintf( "sum(if(debit_kredit=1,nilai,0)) 'debit_%s'", $dt );
					$qr_kredit = sprintf( "sum(if(debit_kredit=0,nilai,0)) 'kredit_%s'", $dt );
					array_push( $query_saldo, $qr_debit );
					array_push( $query_saldo, $qr_kredit );

					// Piutang
					$qr_debit = sprintf( "sum(if(MONTH(trxTerminDate) = '%s' AND YEAR(trxTerminDate) = '%s',trxTotal,0)) as 'debit_%s'", date('m', strtotime($dt)), date('Y', strtotime($dt)), $dt);
					$qr_kredit = sprintf( "'kredit' as 'kredit_%s'", date('Ymd', strtotime($dt)));
					array_push( $query_piutang, $qr_debit );
					array_push( $query_piutang, $qr_kredit );

					// Hutang
					$qr_debit = sprintf( "'0' as 'debit_%s'", date('Ymd', strtotime($dt)) );
					$qr_kredit = sprintf( "sum(if(MONTH(trxTerminDate) = '%s' AND YEAR(trxTerminDate) = '%s',trxTotal,0)) as 'kredit_%s'", date('m', strtotime($dt)), date('Y', strtotime($dt)), $dt);
					array_push( $query_hutang, $qr_debit );
					array_push( $query_hutang, $qr_kredit );

				}
			}

			$data['data'] = $this->db->query("
				SELECT 'SALDO KAS' as grouping, ". implode(',', $query_saldo)."
				FROM `akun` left JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
				LEFT JOIN jurnal on jurnal.id = jurnal_detail.jurnal_id AND MONTH(jurnal.tgl) <= '12' AND YEAR(jurnal.tgl) <= '2019' 
				WHERE kelompok_akun_id=1 and kode LIKE '111%' OR kode LIKE '112%' AND jurnal.identityID=". $this->identity_id." GROUP BY akun.kode
				UNION
				SELECT 'PIUTANG' as grouping, ". implode(',', $query_piutang)."
				FROM as_receivables
				LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID=as_receivables.invoiceID
				WHERE status = 0 AND as_sales_transactions.identityID=". $this->identity_id."
				UNION
				SELECT 'HUTANG' as grouping, ".implode(',', $query_hutang)."
				FROM as_buy_transactions WHERE is_pay = 0 AND identityID=". $this->identity_id."
			")->result_array();		

			//var_dump( $this->db->last_query() ); die();

			$this->load->view('laporan_keuangan/laporan_proyeksi_kas__cetak', $data);
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}

	public function laba_ditahan()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Laba Ditahan';
		$data['main_content'] = 'laporan_keuangan/laporan_laba_ditahan';
		$data['start_bulan']    = $this->input->post('start_bulan');
		$data['start_tahun']    = $this->input->post('start_tahun');
		$data['end_bulan']    = $this->input->post('end_bulan');
		$data['end_tahun']    = $this->input->post('end_tahun');
		$data['form_action'] = 'laporan/laba_ditahan';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);

		$data['data'] = array();
		
		if ( 'post' === $this->input->method() ){
			$start_date = sprintf( '%d-%d-01', $this->input->post('start_tahun'), $this->input->post('start_bulan') );
			$end_date = sprintf( '%d-%d-01', $this->input->post('end_tahun'), $this->input->post('end_bulan') );

			$data['data'] = $this->db->query("
				SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Operasi' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."')
					WHERE kelompok_akun_id=4 
					AND kode LIKE '4%' AND jurnal.identityID=". $this->identity_id."  
					GROUP BY akun.kode
				UNION									
					SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Investasi' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."')
					WHERE kelompok_akun_id=1 
					AND kode LIKE '121%' AND jurnal.identityID=". $this->identity_id." 
					GROUP BY akun.kode
				UNION
					SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."') 
					WHERE kelompok_akun_id=2
					AND kode LIKE '222%' AND jurnal.identityID=". $this->identity_id." 
					GROUP BY akun.kode
				UNION
					SELECT 
					'Kas_Arus' header,'Arus kas Dari Aktivitas Pendanaan' as grouping, akun.nama as nama_akun, akun.*, sum(if(debit_kredit=0,nilai,0)) kredit, sum(if(debit_kredit=1,nilai,0)) debit
					FROM `akun` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = akun.id 
					LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id AND jurnal.tgl >='".$start_date."' AND jurnal.tgl <= LAST_DAY('".$end_date."') 
					WHERE kelompok_akun_id=3
					AND kode LIKE '311%' AND jurnal.identityID=". $this->identity_id."  
					GROUP BY akun.kode
				")->result_array();		

			//var_dump( $this->db->last_query() ); die();

			$this->load->view('laporan_keuangan/laporan_laba_ditahan__cetak', $data);
			
		} else {
			$this->load->view('template/template_xpanel', $data);
		}
	}
	
	public function histori_piutang()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Histori Piutang';
		$data['main_content'] = 'laporan_keuangan/laporan_ringkasan_bank';
		$data['tanggal1'] = $this->input->post('start');
		$data['tanggal2'] = $this->input->post('end');
		$data['form_action'] = 'laporan/histori_piutang';
		if( 'post' === $this->input->method() ){
			$data['title'] = 'Ringkasan Penerimaan per Bank';
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ));
			$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ));
			$data['laporan_'] =  $this->db->query("SELECT
			as_receivables.invoiceID,keterangan,trxDate,trxTotal,INSURANCE_NAME,PAYMENT_TYPE 
		FROM
			as_receivables
			LEFT JOIN as_sales_transactions ON as_receivables.invoiceID = as_sales_transactions.invoiceID
			LEFT JOIN jurnal_unpost ON as_sales_transactions.invoiceID = jurnal_unpost.invoice_no 
		WHERE
			PAYMENT_TYPE LIKE 'INSURANCE%' AND trxDate BETWEEN '". $start_qr ."' AND '". $end_qr ."' UNION
		SELECT
			'' AS invoiceID,as_receivables.invoiceID AS keterangan,DATE( as_receivables_payment.createdDate ) AS trxDate,receivablePay AS trxTotal,INSURANCE_NAME,PAYMENT_TYPE 
		FROM
			as_receivables_payment
			LEFT JOIN as_receivables ON as_receivables_payment.receivableID = as_receivables.receivableID
			LEFT JOIN as_sales_transactions ON as_receivables.invoiceID = as_sales_transactions.invoiceID
			LEFT JOIN jurnal_unpost ON as_sales_transactions.invoiceID = jurnal_unpost.invoice_no 
		WHERE
			DATE( as_receivables_payment.createdDate ) BETWEEN '". $start_qr ."' AND '". $end_qr ."'
		ORDER BY
			INSURANCE_NAME")->result_array();
			$dataL = array ();
			foreach ( $data['laporan_'] as $lap ) {
				$dataL[$lap['INSURANCE_NAME']] [$lap['invoiceID']] = array ('keterangan' => $lap['keterangan'], 'tanggal' => $lap['trxDate'], 'nominal' => $lap['trxTotal']); 
			}
			echo '<pre>'; print_r($dataL);  echo '</pre>';
			$data['output']= $dataL;
		}	elseif( 'pdf' === $this->input->post('cetak_type') ) {
			$html = $this->output->get_output();
			//die($html);
			$this->load->library('dompdf_gen');					
			$this->dompdf->set_option('isRemoteEnabled', TRUE);
			$this->dompdf->set_option('isJavascriptEnabled', TRUE);
			$this->dompdf->load_html($html);					
			$this->dompdf->render();
			$this->dompdf->stream('histori_piutang', array(
				'Attachment' => 1
			));
		} else {
			$this->load->view('template/template_xpanel', $data);
		}		
	}

	private function _date_range($first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
            $dates = array();
            $current = strtotime($first);
            $last = strtotime($last);

            while( $current <= $last ) {    
                $dates[] = date($format, $current);
                $current = strtotime($step, $current);
            }
            return $dates;
    }

    public function laporan_pendapatan()
	{
		$id = $this->session->userdata('SESS_USER_ID');
		$data['title'] = 'Pendapatan';
		$data['main_content'] = 'laporan_keuangan/laporan_pendapatan_std';
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y', strtotime('-1 month'));
     	$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');
		$data['form_action'] = 'laporan/laporan_pendapatan';
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $this->input->post('lokasi');
		$data['rpt_title'] = '<h1 align=\'center\'>Laporan Pendapatan</h1>';

		$data['data'] = array();
		$data['saldo'] = '';

		if ( 'post' === $this->input->method() ){
			$start_qr = date('Y-m-d', strtotime( $data['tanggal1'] ) );
			$end_qr = date('Y-m-d', strtotime( $data['tanggal2'] ) );
			$cabang_id = $this->input->post('lokasi');

			$data['data'] = $this->db->query("SELECT a.*, c.memberFullName, d.identityName FROM as_sales_transactions a 
				LEFT JOIN as_vehicle b ON b.nopol = a.nopol 
				LEFT JOIN as_members c ON c.memberID = b.memberID
				LEFT JOIN as_identity d ON d.identityID = a.identityID
				WHERE a.trxInDate >='". $start_qr ."' AND a.trxInDate <='". $end_qr ."' AND d.identityID = ". $cabang_id ."
				ORDER BY trxID DESC")->result_array();
			
				//var_dump( $this->db->last_query() ); die();
		}
		$this->load->view('template/template_xpanel', $data);
	}

	public function asset_tetap()
	{
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = 'Laporan Asset Tetap';
		$data['main_content'] = 'harta/lap_asset_tetap';
		$month = (($this->input->post('month') != "") ? $this->input->post('month') : date("m"));
		$year = (($this->input->post('year') != "") ? $this->input->post('year') : date("Y"));
		$data['form_action'] = 'laporan/asset_tetap';
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $this->input->post('lokasi');
		$data['tanggal1']    = $this->input->post('start_date') ? $this->input->post('start_date') : date('m/d/Y');
     	$data['data'] = $this->harta_model->get_harta_lists( $data['tanggal1'], $this->input->post('lokasi') ); //ambil data yang

		$this->load->view('template/template_xpanel', $data);
	}

	
}

?>