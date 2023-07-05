<?php
class Procurement extends CI_Controller {

	function __construct()
	{
            parent::__construct();	
            $this->load->library(array('auth','session','customlib','surplus_sync','dompdf_gen'));
            $this->auth->check_user_authentification();
            $this->load->model('jurnal_model');	
            $this->load->model('akun_model');
            $this->load->model('pajak_model');
            $this->load->model('anggaran_model');
            $this->load->model('Surplus_model');
            $this->load->model('laporankeuangan_model');
            $this->load->helper(array('indodate','date'));
            $this->load->helper(array('finance','terbilang_helper'));
            //$this->load->library(array('fpdf'));
            $this->load->helper(array('date','url'));
             $this->load->helper(array('form'));
             $this->load->library('form_validation');
            $this->lang->load('surplus_lang', get_cookie('my_lang'));
            define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	}
	
	function spp()
	{
            $data['title'] = $this->lang->line('report')." SPP";
            $data['jenis_laporan'] = "SPP";
            $data['main_content'] = 'laporan_blud/spp';		
            $data['months'] = bulan_list(1);
            $data['years'] = tahun_list();
            $data['js_file'] = "spp_js.js";
            $this->anggaran_model->table="as_procurements";
            $this->anggaran_model->primary="id";
            $condition = array();
            $data['genNOSPP'] = $this->GenPONumber("SPP/BLUD");
            $data['procurement'] = $this->db->select('*')->from('as_procurements')
            						->JOIN('as_suppliers','as_suppliers.supplierCode = as_procurements.supplierID')
            						->get()
            						->result_array();

            $data['rpt_title'] = '<h1>Laporan SPP</h1>';
            $this->anggaran_model->table="master_pejabat";
            $condition = array();
            $data['pejabat'] = $this->anggaran_model->get_all($condition)->result_array();

            $this->anggaran_model->table="m_mata_anggaran";
            $condition = array();
            $data['mata_anggaran'] = $this->anggaran_model->get_all($condition)->result_array();

            $this->load->view('template/template_xpanel', $data);
	}	
	function loadDataSPP($id,$JSON=true){
		$procurement = $this->db->query("SELECT
						as_procurements.id,
						as_procurements.supplierID,
						as_procurements.noOrder,
						as_procurements.invoiceNo,
						as_procurements.paymentMethod,
						as_procurements.paymentDue,
						as_procurements.description,
						as_procurements.account,
						as_procurements.request_dept,
						as_procurements.total_purchases,
						as_procurements.total_discount,
						as_procurements.VAT,
						as_procurements.date,
						as_procurements.noSpp,
						as_procurements.id_anggaran,
						as_procurements.mata_anggaran,
						as_procurements.dateSpp,
						as_procurements.uraianSpp,
						as_procurements.noSpm,
						as_procurements.date_spm,
						as_procurements.ppn,
						as_procurements.pph_21,
						as_procurements.pph_22,
						as_procurements.pph_23,
						as_procurements.pph_final,
						as_procurements.id_anggaran,
						as_procurements.mata_anggaran, 
						as_suppliers.supplierName, 
						as_procurements.supplierName,
						as_procurements.supplierBankname,
						as_procurements.supplierBankid,
						as_procurements.supplierNPWP,
						as_suppliers.supplierCode,
						as_suppliers.supplierPhone,
						as_suppliers.supplierAddress,
						as_suppliers.supplierFax,
						master_pejabat.nama as nama_pptk,
						master_pejabat.nip as nip_pptk,
						( SELECT nama FROM master_pejabat WHERE jabatan = 3 LIMIT 0, 1 ) nama_bendahara,
						( SELECT nip FROM master_pejabat WHERE jabatan = 3 LIMIT 0, 1 ) nip_bendahara
						FROM
						as_procurements
						LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_procurements.supplierID
						LEFT JOIN master_pejabat on master_pejabat.id = as_procurements.pptk_id
						WHERE as_procurements.id = '".$id."'
						")->row_array();
		if($JSON==true){
			echo json_encode($procurement);
		}else{
			return $procurement;
		}
	}
	function proses_spp(){
		$this->anggaran_model->table="as_procurements";
		$this->anggaran_model->primary="id";
		if($this->input->post('id_procurements') !=""){
			$anggaran = explode("_", $this->input->post('mata_anggaran'));
		}else{
			$this->session->set_flashdata("message","Anggaran tidak dikenali");
			$anggaran = array('','');
			$this->spp();
		}
		if($this->input->post('id_procurements') !=""){
			$this->anggaran_model->table_update($this->input->post('id_procurements'),array("noSpp"=>$this->input->post('no_spp'),
				"dateSpp"=>nice_date($this->input->post('date_spp'), 'Y-m-d'),
				"uraianSpp"=>$this->input->post('uraian_spp'),
				"id_anggaran"=>$anggaran[0],
				"mata_anggaran"=>$anggaran[1],
				"pptk_id"=>$this->input->post('pptk'),
				"supplierName"=>$this->input->post('supplierName'),
				"supplierBankname"=>$this->input->post('supplierBankname'),
				"supplierBankid"=>$this->input->post('supplierBankid'),
				"supplierNPWP"=>$this->input->post('supplierNPWP'),
				));
			$this->session->set_flashdata("message","SPP created");
			redirect("Procurement/spp");
		}else{
			$this->session->set_flashdata("message","Data SPP tidak dikenali");
			$this->spp();
		}
	}

	function cetak_spp($id){
	
		$this->anggaran_model->table="as_procurements";
		$this->anggaran_model->primary="id";
		$condition = array("id"=>$id);
		
		$data['procurement'] = $this->loadDataSPP($id,false);
		
			 
        $this->load->view('laporan_blud/cetak_spp', $data);
        $html = $this->output->get_output();
        //die($html);

        $this->load->library('dompdf_gen');
        $this->dompdf->load_html($html);

        $this->dompdf->render();
        $this->dompdf->stream($id, array(
            'Attachment' => 0
            ));
	}
	function input_spm($id)
	{
		$data['title'] = $this->lang->line('input')." SPM";
		$data['f_id'] = 1;
		$data['userid']= $this->session->userdata('SESS_USER_ID');
		$data['identity_id']= $this->session->userdata('IDENTITY_ID');
		$data['accounts'] = $this->akun_model->get_data_for_dropdown_kas();	
		$data['accounts1'] = $this->akun_model->get_all_kas();	
		$data['accounts2'] = $this->akun_model->get_all_kas();
		$data['id'] = $id;

		$this->anggaran_model->table="as_procurements";
		$this->anggaran_model->primary="id";
		$condition = array("id"=>$id);
		$data['procurement'] = $this->anggaran_model->get_all($condition)->row_array();
		$ppn = (isset($data['procurement']['ppn'])?$data['procurement']['ppn']:0);
		$pph_21 = (isset($data['procurement']['pph_21'])?$data['procurement']['pph_21']:0);
		$pph_22 = (isset($data['procurement']['pph_22'])?$data['procurement']['pph_22']:0);
		$pph_23 = (isset($data['procurement']['pph_23'])?$data['procurement']['pph_23']:0);
		$pph_final = (isset($data['procurement']['ppn'])?$data['procurement']['pph_final']:0);

		//ambil akun utang
		$data['akunUtang'] = $this->db->select("*")
					->from("akun")
					->where("kode","2110101")
					->get()->row_array();
		if(count($data['akunUtang']) <1){
			show_error("Akun Utang tidak ditemukan");
		}
		//end akun utang

		$data['pajakData'] = array(
                        "ppn"=>array("label"=>"PPN","value"=>$ppn),
                        "pph_21"=>array("label"=>"PPH ps 21","value"=>$pph_21),
                        "pph_22"=>array("label"=>"PPH ps 22","value"=>$pph_22),
                        "pph_23"=>array("label"=>"PPH ps 23","value"=>$pph_23), 
                        "pph_final"=>array("label"=>"PPH Final","value"=>$pph_final));
		$data['main_content'] = 'laporan_blud/input_spm';		
		$this->load->view('template/template_xpanel', $data);
	}
	function proses_input_spm(){
		$this->anggaran_model->table="as_procurements";
		$this->anggaran_model->primary="id";

		if($this->input->post('id_procurements') !=""){
			$dataUpdate = array("noSpm"=>$this->input->post('no_spm'),
                        "date_spm"=>nice_date($this->input->post('tgl_spm'), 'Y-m-d'),
                        "ppn"=>$this->input->post('ppn'),
                        "pph_21"=>$this->input->post('pph_21'),
                        "pph_22"=>$this->input->post('pph_22'),
                        "pph_23"=>$this->input->post('pph_23'),
                        "pph_final"=>$this->input->post('pph_final'),
                        "jumlah_dibayarkan"=>$this->input->post('jumlah_dibayarkan'),
					);
		

		$this->anggaran_model->table_update($this->input->post('id_procurements'),$dataUpdate);

		//proses jurnal pelunasan hutang
		//$this->jurnal_model->fill_data_SPM();
		//if($this->jurnal_model->insert_data())
			$this->session->set_flashdata("message","SPM created");
			//$this->anggaran_model->table="as_buy_transactions";
			//$this->anggaran_model->primary="invoiceBuyID";
			/*$dataUpdate = array('is_pay' =>1 , );
			$this->anggaran_model->table_update($this->input->post('invoiceNo'),$dataUpdate);*/

			redirect("Procurement/register_spm");

		//}else{
		//	$this->session->set_flashdata("message","SPM Created Failed");
		//	$this->input_spm($this->input->post('id_procurements'));
		//}
		}
	}

	function register_spm()
	{
		$data['title'] = $this->lang->line('register')." SPM";
		$data['jenis_laporan'] = "Register_SPM";
		$data['main_content'] = 'laporan_keuangan/form_rev';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('template/template_xpanel', $data);
	}	
	function cetak_spm($id){
            $query = "SELECT as_procurements.*,
            			as_suppliers.supplierName,
            			supplierContactPerson
            			FROM as_procurements LEFT JOIN as_suppliers ON as_suppliers.supplierCode = as_procurements.supplierID WHERE  as_procurements.id = '".$id."'";
		
            $data['procurement'] = $this->db->query($query)->row_array();
            
            $data['pajakData'] = array(
                                "PPN"=>$data['procurement']['ppn'],
                                "PPH ps 21"=>$data['procurement']['pph_21'],
                                "PPH ps 22"=>$data['procurement']['pph_22'],
                                "PPH ps 23"=>$data['procurement']['pph_23'],
                                "PPH Final"=>$data['procurement']['pph_final']);
            if(count($data['procurement']) >1){
				if($data['procurement']['account']==0){
					$data['aktif_anggaran'] = $this->db->query("SELECT * FROM m_mata_anggaran WHERE mata_anggaran  like '%BLUD%' ")->row_array();
				}else{
					$data['aktif_anggaran'] = $this->db->query("SELECT * FROM m_mata_anggaran WHERE mata_anggaran like '%APBD%'  ")->row_array();
				}
			}else{
				$data['aktif_anggaran'] = $this->db->query("SELECT * FROM m_mata_anggaran,m_periode_anggaran 
					WHERE m_periode_anggaran.id_anggaran = m_mata_anggaran.id_anggaran 
					AND m_periode_anggaran.is_aktif='1' ")->row_array();
			}
		
	    $this->load->view('laporan_blud/cetak_spm', $data);
        
        $html = $this->output->get_output();
        //die($html);
        $this->load->library('dompdf_gen');
        
        $this->dompdf->load_html($html);
        
        $this->dompdf->render();
        $this->dompdf->stream($id, array(
            'Attachment' => 0
        )); 
	}
	function load_po($month="",$year=""){
		$this->surplus_sync->month = $month;
		$this->surplus_sync->year = $year;
		$loadData = $this->surplus_sync->sync_po();
		//var_dump($loadData);
		//var_dump($loadData);
		echo json_encode($loadData);
	}
	function load_FO_data($month="",$year=""){
		$this->surplus_sync->month = $month;
		$this->surplus_sync->year = $year;
		$loadData = $this->surplus_sync->sync_po();

		echo json_encode($loadData);
		//var_dump($loadData);
	}
	/*
	function load_FO_data($month="",$year=""){

		// Start session (also wipes existing/previous sessions)
		$this->curl->create($this->config->item("API_SERVER")."/sync_athos/sync_po");
		// Option & Options
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10,
							CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
							CURLOPT_USERPWD        => $this->config->item("API_USER") . ":" . $this->config->item("API_PASS"),
							));

		// Login to HTTP user authentication
		$this->curl->http_login($this->config->item("API_USER"), $this->config->item("API_PASS"));
		$post = array("username"=>'admin', //username aplikasi
						"password"=>"admin", //password aplikasi
						"token"=>"cf4d7f7c57361bcfb33be470ddb90b0d",
						"year"=>(($year=="")?date("Y"):$year),
						"month"=>(($month=="")?date("m"):$month)
						);
		
		$this->curl->post($post);
		try {
			$response = $this->curl->execute();
			if($this->curl->error_code !=0){
				die("failed sync data ".$this->curl->error_string);
			}else{
				//$return = json_decode( $response);
				//echo "<pre>";
				//var_dump($return);
				//die();
				//$data['user']= $return->data;
				echo $response;
			}
		}catch(Exception $ex) {
            //if ($ch != null) curl_close($ch);
            throw new Exception($ex);
        }
	}*/

	function spp_manual(){
		$data['title'] = $this->lang->line('input')." SPP manual";
		$data['jenis_laporan'] = "Register_SPM";
		$data['main_content'] = 'transaksi/spp_manual';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$data['supplier'] = $this->db->query("SELECT supplierID value,supplierName label FROM as_suppliers")->result_array();
		$pptk = $this->db->query("SELECT id value,nama label FROM master_pejabat")->result_array();
		$data['field'] = array(
			'supplierID'=>array("label"=>'Supplier',"type"=>'combo',"data"=>$data['supplier'], 'class' => 'select2-custom-tags'),
			'noOrder'=>'No Order',
			'invoiceNo'=>'No Invoice',
			'paymentMethod'=>'Cara Pembayaran',
			'paymentDue'=>array("label"=>'Jatuh Tempo',"type"=>'date'),
			//'description'=>'Keterangan',
			'total_purchases'=>'Total Pembelian',
			//'total_discount'=>'Total Diskon',
			'VAT'=>'Nilai diskon',
			'date'=>array("label"=>'Tgl Transaksi',"type"=>'date'),
			'noSpp'=>'No SPP',
			'dateSpp'=>array("label"=>'Tgl SPP',"type"=>'date'),
			'uraianSpp'=>'Keterangan SPP',
			'pptk' => array("label"=>'PPTK',"type"=>'combo',"data"=>$pptk, 'empty' => true),
			'ppn' => 'PPN',
			'pph_21' => 'Pph Ps 21',
			'pph_22' => 'Pph Ps 22',
			'pph_23' => 'Pph Ps 23',
			'pph_final' => 'Pph Final Ps 4',
			'supplierBankname' => 'Nama Bank',
			'supplierBankid' => 'No Rekening',
			'supplierNPWP' => 'NPWP'
		);
		$this->load->view('template/template_xpanel', $data);
	}

	function proses_insert_manual(){
		$this->form_validation->set_rules('supplierID', 'Supplier ', 'required');
		$this->form_validation->set_rules('invoiceNo', 'No Invoice', 'required');
		$this->form_validation->set_rules('date', 'Tgl Transaksi', 'required');
		$this->form_validation->set_rules('noSpp', 'No ', 'required');
		$this->form_validation->set_rules('dateSpp', 'Tgl SPP', 'required');

		if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata("message","Input spp gagal ");
			$this->spp_manual();
        }else{

        	// check supplier exist
        	$supp_ID = $this->input->post('supplierID');
        	$supplierType = 0;
        	
        	if ( ! is_numeric( $supp_ID ) ) {
    			$data_sup = array(
        			'supplierCode' => 0,
        			'supplierName' => $supp_ID,
        			'supplierStatus' => 1,
        			'supplierBankname' => $this->input->post('supplierBankname'),
					'supplierBankid' => $this->input->post('supplierBankid'),
					'supplierNPWP' => $this->input->post('supplierNPWP'),
        			'createdDate' => date('Y-m-d')
        		);
        		$this->db->insert( 'as_suppliers', $data_sup );
        		$supp_ID = $this->db->insert_id();
        		$supplierType = 1;
        	}

			$data = array(
				'supplierID'=> $supp_ID,
				'noOrder'=>$this->input->post('noOrder'),
				'invoiceNo'=>$this->input->post('invoiceNo'),
				'paymentMethod'=>$this->input->post('paymentMethod'),
				'paymentDue'=>nice_date($this->input->post('paymentDue'), 'Ymd'),
				'description'=>$this->input->post('description'),
				'total_purchases'=>$this->input->post('total_purchases'),
				'total_discount'=>$this->input->post('total_discount'),
				'VAT'=>$this->input->post('VAT'),
				'date'=>nice_date($this->input->post('date'), 'Y-m-d h:i:s'),
				'noSpp'=>$this->input->post('noSpp'),
				'dateSpp'=>nice_date($this->input->post('dateSpp'), 'Y-m-d h:i:s'),
				'uraianSpp'=>$this->input->post('uraianSpp'),
				'pptk_id' => $this->input->post('pptk'),
				'ppn' => $this->input->post('ppn'),
				'pph_21' => $this->input->post('pph_21'),
				'pph_22' => $this->input->post('pph_22'),
				'pph_23' => $this->input->post('pph_23'),
				'pph_final' => $this->input->post('pph_final'),
				'supplierBankname' => $this->input->post('supplierBankname'),
				'supplierBankid' => $this->input->post('supplierBankid'),
				'supplierNPWP' => $this->input->post('supplierNPWP'),
				'supplierType' => $supplierType
			);

			if($this->db->insert('as_procurements',$data)){
				$data['debt'] = array(
									"invoiceID"=> $this->input->post('invoiceNo'),
									"status"=>"0",
									"createdDate"=>date("y-m-d h:i:s"),
									//"terminDate"=>$value['PAYMENT_DUE'],
									"createdUserID"=> $this->session->userdata('SESS_USER_ID')
							);
				$this->db->insert("as_debts",$data['debt']);

				$supplierNameQr = $this->db->query('select SupplierName from as_suppliers where supplierID = ' . $supp_ID )->row();
				$supplierName = $supplierNameQr ? $supplierNameQr->SupplierName : '';

				$data['trans'] = array(
						//"trxID"=>$value['NO_ORDER'],
						"invoiceBuyID"=> $this->input->post('invoiceNo'),
						"identityID"=>"",
						"supplierID"=> $supp_ID,
						"trxFullName"=> $supplierName,
						"trxDate"=> $this->input->post('date'),
						"trxSubtotal"=> $this->input->post('total_purchases'),
						"trxDiscount"=> $this->input->post('VAT'),
						"trxTotal"=> $this->input->post('total_purchases'),
						"trxAdmin"=>"",
						"trxStatus"=>"",
						"trxTerminDate"=>"",
						"createdDate"=>"",
						"userID"=>"",
						"is_pay"=>"0"
				);
				$this->db->insert("as_buy_transactions",$data['trans']);
				$this->session->set_flashdata("message","Input spp berhasil");
				redirect("procurement/spp_manual");
			}else{
				$this->session->set_flashdata("message","Input spp gagal");
				$this->spp_manual();
			}
		}

	}

	function GenPONumber($jns)
	{
		$trxid = $this->db->query("SELECT * from as_procurements WHERE noSpp <>'' order by noSpp desc limit 1;")->row_array();
		$trxdate = date('Y-m-d');
		$NoUnik = $trxid['noSpp'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($NoUnik, 0, 8);
		//var_dump($produksiIDfil);
		if ($produksiIDfil == "") {
			$trxDate = date('my');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
		} else {
			$trxDate = date('my');
			$trxd = substr($produksiIDfil, 0, 4);
			//var_dump($trxd);
			if ($trxDate == $trxd) {
				$invno = $produksiIDfil + 1;
				$invno = sprintf("%08d", $invno);
			} else {
				$trxDate = date('my');
				$trx = 1;
				$invoice = sprintf("%04d", $trx);
				$invno = $trxDate . $invoice;
			}
		}
		 
		$kode = $invno."/".$jns ."/".date("m")."/".date("Y");
		return $kode;
	}
	
}