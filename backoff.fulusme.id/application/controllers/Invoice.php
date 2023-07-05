<?php

class Invoice extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('invoice_model');
		$this->load->model('jurnal_model');
		$this->load->model('akun_model');
		$this->load->helper('finance');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
	}

	function index()
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
		
		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['lokasi_data'] = $this->invoice_model->get_data_lokasi();
		$data['title'] = "Invoice";
		$data['main_content'] = 'invoice/display';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['journal_data'] = $this->invoice_model->get_data_invoice($id,$tanggal1,$tanggal2);
		$this->load->view('template/template_xpanel', $data);
	}
	
	function search()
	{
		$result = $this->_search_invoice();
		if($result) {
			foreach ($result as $row)
			{
				
				$data = '[';
				$data .= "'".$row->invoiceID."',";
				$data .= "'".$row->trxDate."',";
				$data .= "'".$row->invoiceIDmanual."',";
				$data .= "'".$row->trxFullName."',";
				$data .= "'".$row->trxTotal."',";
				$data .= "'".$row->note."',";
				$data .= "'".anchor(site_url()."invoice/invoice_detail/".$row->trxID, 'Detail')."'";
				$data .= ']';
				$nvoice_data[] = $data;
			}
		}
		echo '['.implode(',',$nvoice_data).']';
	}

	function _search_invoice()
	{
		$month = ($this->input->post('bulan') !== FALSE) ? $this->input->post('bulan') : date("m");
		$year = ($this->input->post('tahun') !== FALSE) ? $this->input->post('tahun') : date("Y");
		$this->invoice_model->set_month_year($month, $year);
		return $this->invoice_model->get_data();
	}

	
		function invoice_add()
	{
		$data['userid']= $this->session->userdata('SESS_USER_ID');
		$data['usernama']= $this->session->userdata('SESS_FIRST_NAME');
		
		$data['bank'] = $this->invoice_model->get_bank();
		$data['bank2'] = $this->invoice_model->get_bank_own();
		$data['jenisbyr'] = $this->invoice_model->get_jenis_byr();
		$data['title'] = "Tambah Invoice";
		$data['main_content'] = 'invoice/form';
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	 public function insert_data()
  {

    $cek = $this->session->userdata('SESS_USER_ID');
    if(!empty($cek)){

	  $edit_type=$this->input->post('edit_type');
      $up['memberID']=$this->input->post('memberID');
      $up['trxTerminDate']=$this->input->post('trxTerminDate');
      $up['trxFullName']=$this->input->post('trxFullName');
      $up['trxAddress']=$this->input->post('trxAddress');
      $up['trxPhone']=$this->input->post('trxPhone');
      $up['trxDate']=$this->input->post('trxDate');
      $up['trxStatus']=$this->input->post('trxStatus');

      $up['trxInDate']=$this->input->post('trxInDate');
      $up['trxOutDate']=$this->input->post('trxOutDate');
      $up['vehicleID']=$this->input->post('merkid');
      $up['car_merk']=$this->input->post('merk');
	  $up['trxcartype']=$this->input->post('type');
	  $up['trxcarseries']=$this->input->post('series');
      $up['trxcarno']=$this->input->post('nopol');
	  $up['chasis_no']=$this->input->post('chasis_no');
	  $up['engine_no']=$this->input->post('engine_no');
	  $up['car_year']=$this->input->post('year_vech');
      $up['kilometer']=$this->input->post('kilometer');
      $up['note']=$this->input->post('note');
      $up['invoiceIDmanual']=$this->input->post('invoiceIDmanual');
	  $up['trxInstalasiTotal']= str_replace(',','',$this->input->post('trxInstalasiTotal'));
      $up['trxJasaTotal']=str_replace(',','',$this->input->post('trxJasaTotal'));
      $up['trxSparepartTotal']=str_replace(',','',$this->input->post('trxSparepartTotal'));
      $up['userID']=$this->session->userdata('SESS_USER_ID');
	  $up['identityID']= $this->session->userdata('IDENTITY_ID');
	  $up['is_publish']= 0;
      $up['trxSubtotal']= str_replace(',','',$this->input->post('trxSubtotal'));
      $up['trxDiscount']= str_replace(',','',$this->input->post('trxDiscount'));
      $up['trxPPN']= str_replace(',','',$this->input->post('trxPPN'));
      $up['trxTotal']= str_replace(',','',$this->input->post('trxTotal'));
	  
	 
	  $up['trxbankadmin']=str_replace(',','',$this->input->post('b_admin'));
	  
      $id['trxID']=$this->input->post('trxID');
	   $stsbyr=$this->input->post('stsbyr');
	 
	  
	  if($edit_type=='e') {
	  $invid=$this->input->post('noinvoice_gab');
	  $invupid=array('invoiceID' => $invid);
	  
	   if($up['trxStatus'] ==  2){
		$up['trxPay']=0;
		 $up['trxbankmethod']=0;
		$up['trxbankmember']=0;
		$up['trxbanknorek']=0;
		$up['trxbankedc']=0;
		$up['isfinish']= 0;
       $tb_receive = $this->invoice_model->getSelectedData("as_receivables",$invupid);
      
       $piut['status']= 1;
       if($tb_receive->num_rows()>0){
         $piut['modifiedDate']= date('Y-m-d');
         $piut['modifiedUserID']= $this->session->userdata('SESS_USER_ID');
         $this->invoice_model->updateData("as_receivables",$piut,$invupid);
       }else{ 
	    $piut['invoiceID']=$invid;
        $piut['createdUserID']= $this->session->userdata('SESS_USER_ID');
        $piut['createdDate']= date('Y-m-d');
        $this->invoice_model->insertData("as_receivables",$piut);
      }
	   $this->invoice_model->deleteData("as_pending_pay",$invupid);
    }
	else {
		 $this->invoice_model->deleteData("as_receivables",$invupid);
		
		 $up['trxPay']= str_replace(',','',$this->input->post('trxTotalbyr'));
	    $up['trxbankmethod']=$this->input->post('jns_bayar');
		$up['trxbankmember']=$this->input->post('bankcus');
		$up['trxbanknorek']=$this->input->post('no_kar');
		$up['trxbankedc']=$this->input->post('bankedc');
	    $up['isfinish']= 0;
	   
	   
	}
	  
	  
	  	  if($stsbyr!='2')
	  {
		  $up['isfinish']= 1; 
		   $up['is_pending']= 1; 
	  }
	  else
	  {
		  $up['isfinish']= 0;
		   $up['is_pending']= 0; 
		  $type=$this->input->post('jns_bayar');
		 $bankcus          = $this->input->post('bankcus');
		  $totalbayar= str_replace(',','',$this->input->post('trxTotalbyr'));
		if($type=='1'){
			 $object       = array(
            'invoiceID' =>  $invid ,
            'amount' => $totalbayar,
			'tipe_bayar' => 1,
			'bank_id' =>  0,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
		else
		{
         $object       = array(
            'invoiceID' =>  $invid ,
            'amount' => $totalbayar,
            'tipe_bayar' => $type,
			'bank_id' =>  $bankcus,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
        $this->db->insert('as_pending_pay', $object);
		$this->invoice_model->deleteData("as_receivables",$invupid);
		$up['trxPay']= str_replace(',','',$this->input->post('trxTotalbyr'));
	  }
	  
	  
	   
    $data = $this->invoice_model->getSelectedData("as_sales_transactions",$invupid);
    if($data->num_rows()>0){
		 $up['is_update']=1;
	  $invupid=array('invoiceID' => $invid);
      $this->invoice_model->updateData("as_sales_transactions",$up,$invupid);
      $this->session->set_flashdata('message', "<span class='badge badge-info'>Update Data Berhasil</span>");
	   redirect('invoice', 'refresh');
	  }}
	  else{
	   $up['invoiceID'] = $this->GenInvNumber();	
	   $inID=array('invoiceID' =>  $up['invoiceID']);

	       if($up['trxStatus'] ==  2){
	   
	   $up['trxPay']=0;
		 $up['trxbankmethod']=0;
	  $up['trxbankmember']=0;
	  $up['trxbanknorek']=0;
      $up['trxbankedc']=0;
	   
	   $inID=array('invoiceID' =>  $up['invoiceID']);
       $tb_receive = $this->invoice_model->getSelectedData("as_receivables",$inID);
       $piut['invoiceID']=$up['invoiceID'];
       $piut['status']= 1;
       if($tb_receive->num_rows()>0){
         $piut['modifiedDate']= date('Y-m-d');
         $piut['modifiedUserID']= $this->session->userdata('SESS_USER_ID');
         $this->invoice_model->updateData("as_receivables",$piut,$inID);
       }else{
        $piut['createdUserID']= $this->session->userdata('SESS_USER_ID');
        $piut['createdDate']= date('Y-m-d');
        $this->invoice_model->insertData("as_receivables",$piut);
      }
    }
	 else {
		  $up['trxPay']= str_replace(',','',$this->input->post('trxTotalbyr'));
	    $up['trxbankmethod']=$this->input->post('jns_bayar');
	  $up['trxbankmember']=$this->input->post('bankcus');
	  $up['trxbanknorek']=$this->input->post('no_kar');
      $up['trxbankedc']=$this->input->post('bankedc');
	   $up['isfinish']= 0;
	    $this->invoice_model->deleteData("as_receivables",$inID);
		
	 
	}
	
		     if($stsbyr!='2')
	  {
		  $up['isfinish']= 1; 
		   $up['is_pending']= 1; 
	  }
	  else
	  {
		  $up['isfinish']= 0;
		   $up['is_pending']= 0; 
		  $type=$this->input->post('jns_bayar');
		 $bankcus          = $this->input->post('bankcus');
		  $totalbayar= str_replace(',','',$this->input->post('trxTotalbyr'));
		if($type=='1'){
			 $object       = array(
            'invoiceID' =>  $up['invoiceID'] ,
            'amount' => $totalbayar,
			'tipe_bayar' => 1,
			'bank_id' =>  0,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
		else
		{
         $object       = array(
            'invoiceID' =>  $up['invoiceID'] ,
            'amount' => $totalbayar,
            'tipe_bayar' => $type,
			'bank_id' =>  $bankcus,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
        $this->db->insert('as_pending_pay', $object);
	  }
	  
      $this->invoice_model->insertData("as_sales_transactions",$up);
	 
	  
	  $this->session->set_flashdata('message', "<h4 class='badge badge-info'>Penyimpanan Data Berhasil no Invoice : <b>".$up['invoiceID']." </b> </h4>");
	  redirect('invoice', 'refresh');
    }
	
	
        // redirect('invoice');

  }else{
    header('location:'.base_url());
  }

  }
  
  
  function invoice_detail($id,$id2)
		{
		$data['f_id'] = 1;
		$data['kode_up'] = $id2;
		$data['bank'] = $this->invoice_model->get_bank();
		$data['bank2'] = $this->invoice_model->get_bank_own();
		$data['jenisbyr'] = $this->invoice_model->get_jenis_byr();
		$data['userid']= $this->session->userdata('SESS_USER_ID');
		$data['usernama']= $this->session->userdata('SESS_FIRST_NAME');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');	
		$data['invoice_data'] = $this->invoice_model->get_data_id($id);
		$data['title'] = "Detail Invoice";
		
		$data['main_content'] = 'invoice/form_detail';
		$this->load->view('template/template_xpanel', $data);
			
		}
	
	 function get_customer() {
        
        $kode = strtolower($_GET['term']); 
        //$query = $this->mauto->get_bahan($kode);
		$query = $this->db->from('as_members')->like('memberFullName',$kode)->limit(10)->get();		
 
        $bahan       =  array();
        foreach ($query->result() as $d) {
            $bahan[]     = array(
                 'label' => $d->memberCode." - ". $d->memberFullName." - ".$d->memberAddress, 
                'memberID' => $d->memberID,
                'memberCode' => $d->memberCode,
				'memberFullName' => $d->memberFullName,
				'memberAddress' => $d->memberAddress,
				'memberPhone' => $d->memberPhone
            );
        }
        echo json_encode($bahan);    
		
    }
	
	function get_customer_json()
		{
		header('Content-Type: application/json');
		echo $this->invoice_model->tampil_member_json();
		}
	
	
	
	function invoice_kasir()
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
		
		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['lokasi_data'] = $this->invoice_model->get_data_lokasi();
		$data['title'] = "Invoice Pending";
		$data['main_content'] = 'invoice/display_pay';
		$data['journal_data'] = $this->invoice_model->get_data_pending($id,$tanggal1,$tanggal2);
		$this->load->view('template/template_xpanel', $data);
	}
	
	function invoice_piutang()
	{
		$lokasi = $this->input->post('lokasi');
		if($lokasi)
		{
			$id= $this->input->post('lokasi');
		}
		else
		{
			$id= $this->session->userdata('IDENTITY_ID');
		}
		
		$data['tanggal1']    = $this->input->post('tanggal1');
		$data['tanggal2']    = $this->input->post('tanggal2');
		$data['lokasi_data'] = $this->invoice_model->get_data_lokasi();
		$data['selected_lokasi'] = $id;
		$data['title'] = $this->lang->line('piutang_invoice');
		$data['main_content'] = 'invoice/display_piutang';
		$data['journal_data'] = $this->invoice_model->get_data_piutang($id,$data['tanggal1'],$data['tanggal2']);
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	
	function invoice_pay_termin($id)
	{
		$data['f_id'] = 1;
		 $q_data = $this->db->query("SELECT * FROM as_receivables WHERE invoiceID = '".$id."' ");
        $j_data = $q_data->num_rows();
        $a_data = $q_data->row();
		$piutangid=$a_data->receivableID;
		$data['piutangid'] = $piutangid;
		$data['bank'] = $this->invoice_model->get_bank();
		$data['bank2'] = $this->invoice_model->get_bank_own();
		$data['jenisbyr'] = $this->invoice_model->get_jenis_byr();
		$data['invoice_data_detail'] = $this->invoice_model->get_data_piutang_id_detail($piutangid);
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id);
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');	
		$data['invoice_data'] = $this->invoice_model->get_data_piutang_id($id);
		$data['title'] = "Pembayaran Invoice Termin";
		$data['main_content'] = 'invoice/form_detail_termin';
		$this->load->view('template/template_xpanel', $data);
	}
	
	function termin_pay_data()
    {
		 $stsbyr    = $this->input->post('stsbyr');
		 $receivableID    = $this->input->post('receivableID');
        $nomorinvoice    = $this->input->post('nomorinvoice');
        $totalbayar  = $totalbayar  = str_replace(',','',$this->input->post('trxTotalbyr'));
        $type  = $this->input->post('jns_bayar');
        $bankedc          = $this->input->post('bankedc');
		$bankcus          = $this->input->post('bankcus');
		
		if($type=='1'){
			  $object       = array(
            'receivableID' =>  $receivableID,
            'receivablePay' => $totalbayar,
            'payMethod' => $type,
			'bankedc' =>  0,
			'bankcus' =>  0,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
		else
		{
          $object       = array(
            'receivableID' =>  $receivableID,
            'receivablePay' => $totalbayar,
            'payMethod' => $type,
			'bankedc' =>  $bankedc,
			'bankcus' =>  $bankcus,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
       
        $this->db->insert('as_receivables_payment', $object);
        if($stsbyr=="2")
		{
			 $object2    = array(
            'status' => 2,
        );
        $this->db->where('invoiceID', $nomorinvoice);
        $this->db->update('as_receivables', $object2);
		}
        redirect('invoice/invoice_pay_termin/'.$nomorinvoice, 'refresh');
    }

    function bulk_termin_pay_data()
    {
    	$stsbyr    = $this->input->post('stsbyr');
		$nomor_cust = $this->input->post('nomor_cust');
		$receivableIDs    = $this->input->post('piutang_id');
        $nomorinvoices    = $this->input->post('inv_id');
        $trx_totals    = $this->input->post('trx_total');
        
        $totalbayar  = str_replace(',','',$this->input->post('jumlah_bayar'));
        $type  = $this->input->post('jns_bayar');
        $object = array();
        
        if ( $receivableIDs ) {
		  	foreach( $receivableIDs as $key => $val ) {
		  		$object_ins = array(
			        'receivableID' => $val,
			        'receivablePay' => $trx_totals[ $key ],
			        'payMethod' => $type,
					'createdDate'=>date('Y-m-d h:i:s')
	        	);
	        	array_push($object, $object_ins);
		  	}
        }

        if ( count( $object ) > 0 ) {
        	$this->db->insert_batch('as_receivables_payment', $object);

        	if($stsbyr=="2")
			{
				$object2    = array(
		            'status' => 2,
		        );
	        	$this->db->where_in('invoiceID', $nomorinvoices);
	        	$this->db->update('as_receivables', $object2);
			}
    	}

    	redirect('invoice/detail_custumer_inv/'.$nomor_cust, 'refresh');

    }
	
	function batal_trx_payment($id,$id2)
	{
		
		 $this->invoice_model->delete_data_trx_payment($id);
		  redirect('invoice/invoice_pay_termin/'.$id2, 'refresh');
	}
	
	
	
	function koreksi_termin_pay()
	{
		 $id    = $this->input->post('inv');
		 $object2    = array(
            'status' => 1
        );
        $this->db->where('invoiceID', $id);
        $this->db->update('as_receivables', $object2);
		redirect('invoice/invoice_pay_termin/'.$id, 'refresh');
	}
	
	function nota($id)
	{
		
		$q_data = $this->db->query("SELECT * FROM as_sales_transactions WHERE invoiceID = '".$id."' ");
        $j_data = $q_data->num_rows();
        $a_data = $q_data->row();
		$a['noinv'] =$a_data->invoiceID;
		$a['customer'] =$a_data->trxFullName;
		$a['total'] =$a_data->trxTotal;
		$a['tgltrx'] =$a_data->trxDate;
		$a['note'] =$a_data->note;
		
		   $this->load->view('invoice/print', $a);
            
            $html = $this->output->get_output();
            
            $this->load->library('dompdf_gen');
            
            $this->dompdf->load_html($html);
            
            $this->dompdf->render();
            $this->dompdf->stream($invoiceID, array(
                'Attachment' => 0
            ));
			
	}
	
	function invoice_pay($id)
	{
		$data['f_id'] = 1;
		$data['no_invoice'] = $id;
		$data['bank'] = $this->invoice_model->get_bank();
		$data['bank2'] = $this->invoice_model->get_bank_own();
		$data['jenisbyr'] = $this->invoice_model->get_jenis_byr();
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id);
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');	
		$data['invoice_data'] = $this->invoice_model->get_data_pending_id($id);
		$data['invoice_data_detail'] = $this->invoice_model->get_data_pending_id_detail($id);
		$data['title'] = "Pembayaran Invoice Pending";
		$data['main_content'] = 'invoice/form_detail_pay';
		$this->load->view('template/template_xpanel', $data);
	}
	
	function update_pph23()
	{
		 $id    = $this->input->post('pph23_inv');
        $pph23    = str_replace(',','',$this->input->post('pph23'));
		$q_data = $this->db->query("SELECT * FROM as_sales_transactions WHERE invoiceID = '".$id."' ");
        $a_data = $q_data->row();
		$total =$a_data->trxTotal;
		$total_up=$total-$pph23;
		 $object2    = array(
            'pph23' => $pph23,
			'trxTotal' => $total_up
        );
        $this->db->where('invoiceID', $id);
        $this->db->update('as_sales_transactions', $object2);
		redirect('invoice/invoice_pay_termin/'.$id, 'refresh');
	}
	
	function batal_pph23()
	{
		 $id    = $this->input->post('pph23_inv');
        $pph23    = $this->input->post('pph23');
		$q_data = $this->db->query("SELECT * FROM as_sales_transactions WHERE invoiceID = '".$id."' ");
        $a_data = $q_data->row();
		$total =$a_data->trxTotal;
		$total_up=$total+$pph23;
		 $object2    = array(
            'pph23' => null,
			'trxTotal' => $total_up
        );
        $this->db->where('invoiceID', $id);
        $this->db->update('as_sales_transactions', $object2);
		redirect('invoice/invoice_pay_termin/'.$id, 'refresh');
	}
	
	function update_disc_bayar()
	{
		 $id    = $this->input->post('disc_bayar_inv');
        $disc_bayar    = str_replace(',','',$this->input->post('disc_bayar'));
		$q_data = $this->db->query("SELECT * FROM as_sales_transactions WHERE invoiceID = '".$id."' ");
        $a_data = $q_data->row();
		$total =$a_data->trxTotal;
		$total_up=$total-$disc_bayar;
		 $object2    = array(
            'diskon_bayar' => $disc_bayar,
			'trxTotal' => $total_up
        );
        $this->db->where('invoiceID', $id);
        $this->db->update('as_sales_transactions', $object2);
		redirect('invoice/invoice_pay_termin/'.$id, 'refresh');
	}
	
	
	function batal_disc_bayar()
	{
		 $id    = $this->input->post('disc_bayar_inv');
        $disc_bayar    = $this->input->post('disc_bayar');
		$q_data = $this->db->query("SELECT * FROM as_sales_transactions WHERE invoiceID = '".$id."' ");
        $a_data = $q_data->row();
		$total =$a_data->trxTotal;
		$total_up=$total+$disc_bayar;
		 $object2    = array(
            'diskon_bayar' => null,
			'trxTotal' => $total_up
        );
        $this->db->where('invoiceID', $id);
        $this->db->update('as_sales_transactions', $object2);
		redirect('invoice/invoice_pay_termin/'.$id, 'refresh');
	}
	
	function batal_trx($id)
	{
		
		 $this->invoice_model->delete_data_trx($id);
		 redirect('invoice', 'refresh');
	}
	
	
	    function pending_pay_data()
    {
		$stsbyr    = $this->input->post('stsbyr');
        $nomorinvoice    = $this->input->post('nomorinvoice');
        $totalbayar  = str_replace(',','',$this->input->post('trxTotalbyr'));
        $type  = $this->input->post('jns_bayar');
        $bankcus          = $this->input->post('bankcus');
		if($type=='1'){
			 $object       = array(
            'invoiceID' =>  $nomorinvoice,
            'amount' => $totalbayar,
			'tipe_bayar' => 1,
			'bank_id' =>  0,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
		else
		{
         $object       = array(
            'invoiceID' =>  $nomorinvoice,
            'amount' => $totalbayar,
            'tipe_bayar' => $type,
			'bank_id' =>  $bankcus,
			'createdDate'=>date('Y-m-d h:i:s')
        );
		}
        $this->db->insert('as_pending_pay', $object);
        if($stsbyr=="2")
		{
			 $object2    = array(
            'isfinish' => 1,
        );
        $this->db->where('invoiceID', $nomorinvoice);
        $this->db->update('as_sales_transactions', $object2);
		}
        redirect('invoice/invoice_pay/'.$nomorinvoice, 'refresh');
    }
    
	
	 
	
	function GenInvNumber()
		{
		$codeidentity=$this->session->userdata('IDENTITY_CODE');
		$trxid = mysql_fetch_array(mysql_query('SELECT * from as_sales_transactions order by trxID desc limit 1;'));
		
		$produksiID = $trxid['invoiceID'];
		$produksiIDfil = substr($produksiID, 7, 8);
		if ($produksiIDfil == "")
			{ 
			$trx = 1;
			$invoice = sprintf("%08d", $trx);
			$invno = $invoice;
			}
		  else
			{
				
			$trxd = substr($produksiID,3, 2);
			$trd = date('y');
			if ($trd == $trxd)
				{
				$invno = $produksiIDfil + 1;
				$invno = sprintf("%08d", $invno);
				}
			  else
				{
				$trx = 1;
				$invoice = sprintf("%08d", $trx);
				$invno =$invoice;
				}
			}

		$kode = $codeidentity."-".date('y')."-". $invno;
		return $kode;
		}
		
	function GenJurNumber()
		{
		$trxid = mysql_fetch_array(mysql_query('SELECT * from jurnal order by id desc limit 1;'));
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 6, 8);
		if ($produksiIDfil == "")
			{ 
			$trxDate = date('my');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
			}
		  else
			{
			$trxDate = date('my');
			$trxd = substr($produksiIDfil, 0, 4);
			if ($trxDate == $trxd)
				{
				$invno = $produksiIDfil + 1;
				$invno = sprintf("%08d", $invno);
				}
			  else
				{
				$trxDate = date('my');
				$trx = 1;
				$invoice = sprintf("%04d", $trx);
				$invno = $trxDate . $invoice;
				}
			}

		$kode = "JI-". date('d')."-". $invno;
		return $kode;
		}
	function insert_jurnal()
	{
		$goto = $this->input->post('goto');
		if(!$this->_jurnal_validation())
		{
			$this->session->set_flashdata('ERRMSG_ARR', validation_errors());
			redirect($goto);
		}
		else
		{
			$error_message = $this->_detail_validation();
			if($error_message != '')
			{
				$this->session->set_flashdata('ERRMSG_ARR', $error_message);
				redirect($goto);
			}
			else
			{
				$this->jurnal_model->fill_data();
				//Check for duplicate no
				if(!$this->jurnal_model->check_no())
				{
					$this->session->set_flashdata('ERRMSG_ARR', $this->lang->line('no_jurnal_used'));
					redirect($goto);
				}
				//Insert Data
				elseif($this->jurnal_model->insert_data())
				{
					$this->session->set_flashdata('SUCCESSMSG', $this->lang->line('akun_sukses'));
					redirect($goto);
				}
			}
		}
	}
	function _jurnal_validation()
	{
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++)
		{
			$this->form_validation->set_rules('debit'.$i, 'Debit', 'trim|is_natural');
			$this->form_validation->set_rules('kredit'.$i, 'Kredit', 'trim|is_natural');
		}

		return $this->form_validation->run();
	}
	function _detail_validation()
	{
		$error_message = '';
		if($this->input->post('f_id') != 3)
		{
			if (($this->input->post('debit1') == '' && $this->input->post('kredit1') == '') || ($this->input->post('debit2') == '' && $this->input->post('kredit2') == ''))
			{
				$error_message = $this->lang->line('error_akun_min');
			}
			else
			{
				$akun_exist = array();
				$debit_sum = 0;
				$kredit_sum = 0;
				$akun = $this->input->post('akun');
				for ($i = 1; $i <= count($akun); $i++)
				{
					$debit = $this->input->post('debit'.$i);
					$kredit =$this->input->post('kredit'.$i);
					// akun tidak boleh ada yang sama
					if(in_array($akun[$i-1],$akun_exist))
					{
						$error_message = $this->lang->line('duplicate_detail');
					}
					else
					{
						$akun_exist[count($akun_exist)] = $akun[$i-1];
					}
					// hitung jumlah debit
					if ($debit != '') $debit_sum += $debit;
					// hitung jumlah kredit
					if ($kredit != '') $kredit_sum += $kredit;
				}
				if($debit_sum == 0 || $kredit_sum == 0)
				{
					if($error_message) $error_message .= '<br/>';
					$error_message .= $this->lang->line("jumlah_kosong");
				}
				if($debit_sum != $kredit_sum)
				{
					if($error_message) $error_message .= '<br/>';
					$error_message .= $this->lang->line("nominal_tidak_sama");
				}
			}
		}
		return $error_message;
	}

	public function detail_custumer_inv( $id )
	{
		
		$data['tanggal1']    = $this->input->post('tanggal1');
		$data['tanggal2']    = $this->input->post('tanggal2');
		$data['title'] = $this->lang->line('piutang_invoice');
		$data['main_content'] = 'invoice/display_member_piutang';
		$data['jenisbyr'] = $this->invoice_model->get_jenis_byr();
		$data['accounts'] = $this->akun_model->get_data_for_dropdown_kas_bank();
		$data['journal_data'] = $this->invoice_model->get_data_piutang_member($id,$data['tanggal1'],$data['tanggal2']);
		$data['nomor_cust'] = $id;
		$this->load->view('template/template_xpanel', $data);
	}	
}
/* End of file jurnal.php */
/* Location: ./application/controllers/jurnal.php */
