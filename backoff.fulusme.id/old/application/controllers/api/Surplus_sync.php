<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
 
class Surplus_sync extends REST_Controller {
	//public $sync_tbl = array("employee","deptment");
	public $API_SERVER = "";
	public $API_USER = "";
	public $API_PASS = "";
	private $tableSelect ="";
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		//load the models
		$this->load->model("Employees_model");
		$this->load->model("Surplus_model");
		$this->load->model("User_model");
		$this->load->helper('form');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
		$this->load->library(array('session','curl'));
		$this->load->dbforge();
		$this->API_SERVER = $this->config->item("API_SERVER");
		$this->API_USER = $this->config->item("API_USER");
		$this->API_PASS = $this->config->item("API_PASS");
		$this->output->set_header('Access-Control-Allow-Origin: *');
    }
	function index_get(){

		
	}
	
	function sync_payment_post(){
		$validate = $this->validate_login();
		
		if($validate['error']==1){
			$this->set_response($validate['message'], REST_Controller::HTTP_UNAUTHORIZED);
		}

		$this->Gemss_model->table = "trx_payment";
		$this->Gemss_model->primary = "ID";
		$year = ($this->post("year")=="")?date("Y"):$this->post("year");
		$month = ($this->post("month")=="")?date("m"):$this->post("month");

		$condition = array("trx_payment.STATUS"=>"0","YEAR(PAYMENT_DATE)"=>$year,"MONTH(PAYMENT_DATE)"=>$month);
		$payment = $this->Gemss_model->get_payment_unsync($condition)->result();
		$result = "";
		if(count($payment) > 0){
			$x=0;
			$qupdate="";
			$result = array("succes"=>array());
			$result = array("failed"=>array());
			foreach ($payment as $key => $value) {
				$value = (array)$value;
				$respon = $this->fetch_tbl_payment("add",$value,$value['REGISTRATION_TYPE']);
				if($respon['error']=="0"){
					$qupdate .= $respon['data'];
					$result['succes'][] = $respon;
				}else{
					$result['failed'][] = $respon;	
				}
				
				$x++;
			}
			//var_dump($qupdate);
			//die();
			$this->Gemss_model->exec_query($qupdate);
		}else{
			//$result = $payment;
		}

		$this->set_response($result, REST_Controller::HTTP_OK);
		
	}


	function list_user(){
		$this->Athoshr_model->table = "xin_employees";
		$this->Athoshr_model->primary = "user_id";
		$condition = array("sync_status"=>"0");
		$employee = $this->Athoshr_model->get_all($condition)->result();

		$messageResult =array("succes"=>"","failed"=>"");	
		foreach($employee as $item){
			$message = $this->save_user($item);
			if($message['error'] ==1){
				$messageResult["failed"][] =  $message;
			}else{
				$messageResult["succes"][] =  $message;
			}
		}
		//echo "<pre>";
		//var_dump($messageResult);

		if(is_array($messageResult["succes"])){
			foreach($messageResult["succes"] as $item){
				$this->Athoshr_model->table_update($item['data']['ID'], array("sync_status"=>1));
			}
		}

		$this->set_response($messageResult, REST_Controller::HTTP_OK);

	}
	
	function save_user($data){
		$this->Gemss_model->table = "employee";
		$this->Gemss_model->primary = "ID";
		$dataEmp = array(
				"ID"=>$data->user_id,
				"USER_ID"=>$data->username,
				"USER_NAME"=>$data->first_name." ".$data->last_name,
				//"PASSWORD"=>$this->input->get("pass_text"),
				"DEPT_ID"=>$data->department_id,
				//"STATUS"=>1
		);
		$this->form_validation->set_data($dataEmp);
		$this->form_validation->set_rules('ID','ID Pengguna', 'trim|required|is_unique[employee.ID]', array('is_unique' => 'ID Pengguna telah terdaftar sebelumnya'));
		
		if ($this->form_validation->run() === FALSE) 
		{
			$cek = $this->Gemss_model->table_update($dataEmp['ID'], $dataEmp);
			if($cek === true){
				$message = array("Message"=>"Data berhasil diubah","data"=>$dataEmp,"error"=>"0");
			}else{
				$message = array("Message"=>$cek,"data"=>"","error"=>"1");
			}
			
		}
		else
		{
			if(!$this->Gemss_model->table_add($dataEmp))
			{
				$message = array("Message"=>"Error menambahkan Data","data"=>$dataEmp,"error"=>"1");
				//die();
			}else{
				$message = array("Message"=>"Simpan data sukses","data"=>$dataEmp,"error"=>"0");
			} 
		}

		return $message;
	}

	function delete_user_delete($id){
		$this->Gemss_model->table = "employee";
		$this->Gemss_model->primary = "ID";

		if($this->Gemss_model->delete($id) >0)
		{
			$message = array("message"=>"Delete Data Berhasil","data"=>"","error"=>"");
			
		}
		else
		{
			$message = array("message"=>"Gagal Delete Data","data"=>"","error"=>"");
		}

		$this->set_response($message, REST_Controller::HTTP_OK);

	}
	function fetch_tbl_payment($option,$data,$payment_name){
		if($payment_name !=""){ // cek pembayaran apakah dikenali oleh sistem atau tidak
			$dataPost = $data;// ambil data yang diposting ke API
			if(!is_array($dataPost)){
				$message = array("message"=>"Data diposting tidak sesuai format","data"=>$dataPost,"error"=>"1");
			}else{
				//cek payment apakah terdaftar atau tidak
				$this->Surplus_model->table = "tbl_maping_payment";
				$condition = array("payment_name"=>$payment_name);
				
				$MappingPayment = $this->Surplus_model->get_all($condition);

				if($MappingPayment->num_rows() > 0){

					$dataPayment = array(
						//"id"=>$data['ID'],
						"no"=>$data['REGISTRATION_CODE'],
						"tgl"=>$data['PAYMENT_DATE'],
						"f_id"=>"1",
						"keterangan"=>"pay_billing_".$payment_name."_".$data['REGISTRATION_CODE'] ,
						"invoice_no"=>$data['PAYMENT_CODE'],
						"login_id"=>$this->session->userdata("SESS_USER_ID"),
						"waktu_post"=>date("Y-m-d H:i:s"),
                                                'REGISTRATION_CODE'=>$data['REGISTRATION_CODE'],
                                                'PATIENT_NAME'=>$data['PATIENT_NAME'],
                                                'REGISTRATION_TYPE'=>$data['REGISTRATION_TYPE'],
                                                'PAYMENT_CODE'=>$data['PAYMENT_CODE'],
                                                'CLASS'=>$data['CLASS'],
                                                'PATIENT_TYPE'=>$data['PATIENT_TYPE'],
                                                'INSURANCE_CODE'=>$data['INSURANCE_CODE'],
                                                'INSURANCE_NAME'=>$data['INSURANCE_NAME'],
                                                'DEPARTMENT_CODE'=>$data['DEPARTMENT_CODE'],
                                                'DEPARTMENT_NAME'=>$data['DEPARTMENT_NAME'],
                                                'PAYMENT_TYPE'=>$data['PAYMENT_TYPE'],
                                                'ADMINISTRATION_PAYMENT_FEE'=>$data['ADMINISTRATION_PAYMENT_FEE'],
                                                'AMOUNT'=>$data['AMOUNT'],
                                                'CASHIER_CODE'=>$data['CASHIER_CODE'],
                                                'CASHIER_NAME'=>$data['CASHIER_NAME'],
                                                'SHIFT'=>$data['SHIFT'],
                                                'PAYMENT_DATE'=>$data['PAYMENT_DATE'],
                                                'CREATED_AT'=>$data['CREATED_AT']
					);
					
					$modelData = $this->Surplus_model;
					$modelData->table = 'jurnal_unpost';
					$modelData->primary = "id";
					

					$cekInvID = $this->Surplus_model->check_exists(array("invoice_no"=>$dataPayment['invoice_no'],"REGISTRATION_CODE"=>$dataPayment['REGISTRATION_CODE'],"PAYMENT_TYPE"=>$dataPayment['PAYMENT_TYPE'],));
					
					if($cekInvID['respon'] === false)	
					{
						$saveData = $this->proses_fetch_tbl($modelData,$dataPayment,$option);
					}else{
						
						$saveData = array('data'=>$cekInvID['data']->id,'error'=>0,'message'=>"");
					}
					if($saveData['error'] ==0){
						$idJurnal = $saveData['data']; //id yang telah dimasukan kedalam jurnal
						
						//input detail jurnal
						$dataMapping = $MappingPayment->result();
						//foreach($dataPost as $index=>$item){
							
							$debet = "";
							$kredit ="";
							foreach($dataMapping as $Payment_type_db){
								if($data['PAYMENT_TYPE'] == $Payment_type_db->payment_type){
									$debet = $Payment_type_db->payment_coa_debet;
									$kredit = $Payment_type_db->payment_coa_kredit;
								}
							}
							if($debet =="" || $kredit==""){
								var_dump($data);
								echo ("payment_mapping_not found");
								
							}else{
								$dataDetailJurnalDebet = array(
														'jurnal_id' =>$idJurnal ,
														'item'=>'1',
														'akun_id'=>$debet,
														'debit_kredit'=>0,
														'nilai'=>$data['AMOUNT'],
														'keterangan'=>''
														);
								$dataDetailJurnalKredit = array(
														'jurnal_id' =>$idJurnal ,
														'item'=>'1',
														'akun_id'=>$kredit,
														'debit_kredit'=>1,
														'nilai'=>$data['AMOUNT'],
														'keterangan'=>''
														);
								$this->Surplus_model->table = "jurnal_unpost_detail";
								$this->Surplus_model->table_add($dataDetailJurnalDebet);
								$this->Surplus_model->table_add($dataDetailJurnalKredit);
								
								$this->Gemss_model->table = "trx_payment";
								$QPaymentupdate = " UPDATE trx_payment SET status ='1' Where ID='".$data['ID']."'; ";

								$message = array("message"=>"Post Jurnal berhasil","data"=>$QPaymentupdate,"error"=>"0");
							}

						//}
						
					}else{
						$message = array("message"=>"Gagal Menyimpan Data Jurnal","data"=>"","error"=>"1");
					}
				
				}else{
					$message = array("message"=>"Jenis Pembayaran tidak dikenali","data"=>$dataPayment,"error"=>"1");
				}
			}

		}else{
			$message = array("message"=>"Jenis Pembayaran tidak boleh kosong","data"=>"","error"=>"1");
		}
		return $message;
	}
	function proses_fetch_tbl($modelData,$data,$option){
		$message = array("message"=>"","data"=>"","error"=>"");
		if($option =="add"){
			$response = $modelData->table_add($data);
			if($response === FALSE){
				$message = array("message"=>"Sync Data Failed","data"=>$data,"error"=>"1");
			}else{
				$message = array("message"=>"Sync Data Succes","data"=>$response,"error"=>"0");
			}
		}else if($option =="update"){
			$id = $this->post('id');	
			$response = $modelData->table_update($id,$data);
			
			if($response === true){
				$message = array("message"=>"Sync Data Succes","data"=>$data,"error"=>"0");
			}else{
				$message = array("message"=>"Sync Data Failed","data"=>$response,"error"=>"1");
			}
		}
		
		return $message;
	}

	function sync_po_post(){
		
		$validate = $this->validate_login();
		$result = array("message"=>"","data"=>"","error"=>"1");

		if($validate['error']==1){
			$this->set_response($validate['message'], REST_Controller::HTTP_UNAUTHORIZED);
		}

		$this->Gemss_model->table = "PROCUREMENTS_ORDERS";
		$this->Gemss_model->primary = "ID";
		$year = ($this->post("year")=="")?date("Y"):$this->post("year");
		$month = ($this->post("month")=="")?date("m"):$this->post("month");
		$query = "SELECT * FROM PROCUREMENTS_ORDERS 
				WHERE YEAR(DATE)='".$year."' AND MONTH(DATE)='".$month."' 
				AND PROCUREMENTS_ORDERS.ID not in (SELECT
	            REFERENCE_ID  FROM trx_delete_record 
	            WHERE trx_delete_record.REFERENCE_TABLE= 'PROCUREMENTS_ORDERS')
				" ;

		//$condition = array("YEAR(DATE)"=>$year,"MONTH(DATE) <="=>$month, "status"=>"0");
		$PoData = $this->Gemss_model->exec_query($query)->result_array();
		$result = "";
		if(is_array($PoData)){
			if(count($PoData) > 0){
				$x=0;
				$qupdate="";
				$dataPO=array();
				$data=array();
				$dataPOUpdate=array();
				$dataUpdate=array();

				foreach ($PoData as $key => $value) {
					$value = (array)$value;
					$this->validate_vendor($value); // save terlebih dahulu data vendor

					
					$this->Surplus_model->table= 'as_procurements';
					$this->Surplus_model->primary= 'noOrder';

					$condition = array('invoiceNo'=>$value['INVOICE_NO']);
					$q = $this->Surplus_model->get_all($condition);

					if ( $q->num_rows() <= 0 ) 
					{
	                    $dataPO[] = array(
	                                    "supplierID"=>$value['VENDOR_ID'],
	                                    "noOrder"=>$value['NO_ORDER'],
	                                    "invoiceNo"=>$value['INVOICE_NO'],
	                                    "paymentMethod"=>$value['PAYMENT_METHOD'],
	                                    "paymentDue"=>$value['PAYMENT_DUE'],
	                                    "description"=>$value['DESCRIPTION'],
	                                    "account"=>$value['ACCOUNT'],
	                                    "request_dept"=>$value['REQUEST_DEPT'],
	                                    "total_purchases"=>$value['TOTAL_PURCHASES'],
	                                    "total_discount"=>$value['TOTAL_DISCOUNT'],
	                                    "VAT"=>$value['VAT'],
	                                    "date"=>$value['DATE']
	                            );
	                    $data['debt'][] = array(
								"invoiceID"=>$value['INVOICE_NO'],
								"status"=>"0",
								"createdDate"=>date("y-m-d h:i:s"),
								//"terminDate"=>$value['PAYMENT_DUE'],
								"createdUserID"=>$value['ACCOUNT']
						);

						$data['trans'][] = array(
								//"trxID"=>$value['NO_ORDER'],
								"invoiceBuyID"=>$value['INVOICE_NO'],
								"identityID"=>"",
								"supplierID"=>$value['VENDOR_ID'],
								"trxFullName"=>$value['DISTRIBUTOR_NAME'],
								"trxDate"=>$value['DATE'],
								"trxSubtotal"=>$value['TOTAL_PURCHASES'],
								"trxDiscount"=>$value['TOTAL_DISCOUNT'],
								"trxTotal"=>$value['TOTAL_PURCHASES'],
								"trxAdmin"=>"",
								"trxStatus"=>"",
								"trxTerminDate"=>"",
								"createdDate"=>"",
								"userID"=>"",
								"is_pay"=>"0"
						);
						
					}else{
						$dataPOUpdate[] = array(
	                                    "supplierID"=>$value['VENDOR_ID'],
	                                    "noOrder"=>$value['NO_ORDER'],
	                                    "invoiceNo"=>$value['INVOICE_NO'],
	                                    "paymentMethod"=>$value['PAYMENT_METHOD'],
	                                    "paymentDue"=>$value['PAYMENT_DUE'],
	                                    "description"=>$value['DESCRIPTION'],
	                                    "account"=>$value['ACCOUNT'],
	                                    "request_dept"=>$value['REQUEST_DEPT'],
	                                    "total_purchases"=>$value['TOTAL_PURCHASES'],
	                                    "total_discount"=>$value['TOTAL_DISCOUNT'],
	                                    "VAT"=>$value['VAT'],
	                                    "date"=>$value['DATE']
	                            );

						$dataUpdate['debt'][] = array(
								"invoiceID"=>$value['INVOICE_NO'],
								"status"=>"0",
								"createdDate"=>date("y-m-d h:i:s"),
								//"terminDate"=>$value['PAYMENT_DUE'],
								"createdUserID"=>$value['ACCOUNT']
						);
						$dataUpdate['trans'][] = array(
								//"trxID"=>$value['NO_ORDER'],
								"invoiceBuyID"=>$value['INVOICE_NO'],
								"identityID"=>"",
								"supplierID"=>$value['VENDOR_ID'],
								"trxFullName"=>$value['DISTRIBUTOR_NAME'],
								"trxDate"=>$value['DATE'],
								"trxSubtotal"=>$value['TOTAL_PURCHASES'],
								"trxDiscount"=>$value['TOTAL_DISCOUNT'],
								"trxTotal"=>$value['TOTAL_PURCHASES'],
								"trxAdmin"=>"",
								"trxStatus"=>"",
								"trxTerminDate"=>"",
								"createdDate"=>"",
								"userID"=>"",
								"is_pay"=>"0"
						);

					}
					$qupdate .= " UPDATE PROCUREMENTS_ORDERS SET status = 1 WHERE NO_ORDER = '".$value['NO_ORDER']."'; ";				
					$x++;
				}
				
				$dataInsert = $this->Surplus_model->insert_or_duplicate_update_batch($dataPO,$dataPOUpdate,$data,$dataUpdate);
				$result = array("message"=>"Sync Data Success","data"=>$dataInsert,"error"=>"0");
				$this->Gemss_model->exec_query($qupdate);
			}else{
				$result = array("message"=>"ALL PO LOADED","data"=>"","error"=>"1");
			}
		}else{
			$result = array("message"=>"Error QUery","data"=>"","error"=>"1");
		}

		$this->set_response($result, REST_Controller::HTTP_OK);
		
	}

	function validate_vendor($vendor){
		$dataSuplier = array(
		"supplierCode"=>$vendor['VENDOR_ID'],
		"supplierName"=>$vendor['DISTRIBUTOR_NAME'],
		"supplierBankname"=>$vendor['BANK_NAME'],
		"supplierBankid"=>$vendor['BANK_ACCOUNT_ID'],
		"supplierNPWP"=>$vendor['TAX_ID'],
		"supplierStatus"=>"1",
		"createdDate"=>date("Y-m-d")
		);
		$this->Surplus_model->table= 'as_suppliers';
		$this->Surplus_model->primary= 'supplierCode';

		$condition = array('supplierCode'=>$vendor['VENDOR_ID']);
		$q = $this->Surplus_model->get_all($condition);

		if ( $q->num_rows() > 0 ) 
		{
		   $this->Surplus_model->table_update($vendor['VENDOR_ID'],$dataSuplier);
		} else {
			$dataSuplier["supplierID"] = $vendor['VENDOR_ID'];
		   	$this->Surplus_model->table_add($dataSuplier);
		}
	}

	function validate_login(){
		
		$username = $this->post('username');
		$password = $this->post('password');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array("message"=>"","data"=>"","error"=>"", 'csrf_hash'=>'');
		
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($username==='') {
			$Return['message'] = "Username tidak boleh kosong";
			$Return['error'] = "1";
		} elseif($password===''){
			$Return['message'] = "Password tidak boleh kosong";
			$Return['error'] = "1";
		}
		if($Return['error']=='1'){
			return $Return;
		}

		
		$query = $this->User_model->validate_login($username, $password);
		
		
		if($query->num_rows() == 1)
		{
				$row = $query->row();
				$data = array(
					'SESS_USER_ID' => $row->id,
					'SESS_FIRST_NAME' => $row->nama_depan,
					'SESS_LAST_NAME' => $row->nama_belakang,
					'IDENTITY_ID' => $row->identity_id,
					'IDENTITY_CODE' => $row->identityCode,
					'ADMIN' => $row->administrator
				);
				$this->session->set_userdata($data);
				$Return = array("message"=>"Login sukses","data"=>$data,"error"=>"0", 'csrf_hash'=>'');
				
				return $Return;
				
			} else {
				$Return['message'] = "Data User tidak ditemukan";
				$Return['error'] = "1";
				/*Return*/
				$Return['csrf_hash'] = $this->security->get_csrf_hash();
				
				return $Return;
			}
		
	}
	
	
}