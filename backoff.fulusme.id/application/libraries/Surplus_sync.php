<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter IDD SSO Class
 *
 * Library for connect to IDD SSO
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Suharyadu
 
 */
class Surplus_sync {

	protected $_ci;                 // CodeIgniter instance
	private $API_SERVER = "http://178.128.124.100/api_staging/api/";  // URL of the server API
	private $API_USER ="athoshr";
	private $API_PASS ="athoshr321";
	public $response = '';       // Contains the  response for debug
	public $Data = array("username"=>"admin", 
					"password"=>"admin",
					"email"=>"admin@admin.com",
					"site"=>"surplus.com",
					"month"=>"",
					"year"=>"");             // Contains Data to post to API
	public $error_code;             // Error code returned as an int
	public $error_string;           // Error message returned as a string
	public $info;                   // Returned after request (elapsed time, etc)
	public $month="";
	public $year="";

	function __construct($url = '')
	{
		$this->_ci = & get_instance();
		$this->Data['month'] = $this->month;
		$this->Data['year'] = $this->year;


//		$this->_ci->load->library('curl');
		log_message('debug', 'Surplus_sync Class Initialized');
		
		if ( ! $this->is_enabled())
		{
			log_message('error', 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
		}

	}
	public function loadDataAPI($function="sync_po"){
		// Start session (also wipes existing/previous sessions)
		$this->_ci->curl->create($this->API_SERVER."/Sync_athos/".$function);
		// Option & Options
		$this->_ci->curl->options(array(CURLOPT_BUFFERSIZE => 10));

		// Login to HTTP user authentication
		$this->_ci->curl->http_login($this->API_USER, $this->API_PASS);
		$this->_ci->curl->post($this->Data);
		$response = $this->_ci->curl->execute();
		if($this->_ci->curl->error_code !=0){
			$return = array("message"=>"failed connect ".$this->_ci->curl->error_string,"data"=>"","error"=>$this->_ci->curl->error_code);
		}else{
			$return = json_decode($response,true);
			
		}
		return $return;
	}
	function sync_po(){
		
		$DataFront = $this->loadDataAPI();
		
		if($DataFront['error'] ==0){
			$result = "";
			$PoData = $DataFront['data'];
			/*var_dump($PoData);
			die();*/
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

						
						$this->_ci->Surplus_model->table= 'as_procurements';
						$this->_ci->Surplus_model->primary= 'noOrder';

						$condition = array('invoiceNo'=>$value['INVOICE_NO'],'noOrder'=>$value['NO_ORDER'],'receiveNo'=>$value['RECEIVE_NO']);

						$q = $this->_ci->Surplus_model->get_all($condition);

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
		                                    "ppn"=>$value['VAT'],
		                                    "request_dept"=>$value['REQUEST_DEPT'],
		                                    "total_purchases"=>$value['TOTAL_PURCHASES'],
		                                    "supplierName"=>$value['DISTRIBUTOR_NAME'],
		                                    "supplierBankname"=>$value['BANK_NAME'],
											"supplierBankid"=>$value['BANK_ACCOUNT_ID'],
											"supplierNPWP"=>$value['TAX_ID'],
		                                    "total_discount"=>$value['TOTAL_DISCOUNT'], 
		                                    "VAT"=>$value['VAT'],
		                                    "date"=>$value['DATE'],
		                                    "receiveNo"=>$value['RECEIVE_NO']
		                            );
		                    $data['debt'][] = array(
									"invoiceID"=>$value['INVOICE_NO'],
									"status"=>"0",
									"createdDate"=>date("y-m-d h:i:s"),
									//"trxTerminDate"=>$value['PAYMENT_DUE'],
									"createdUserID"=>$value['ACCOUNT'],
		                            "receiveNo"=>$value['RECEIVE_NO']
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
									"trxTerminDate"=>$value['PAYMENT_DUE'],
									"createdDate"=>"",
									"userID"=>"",
									"note"=>$value['DESCRIPTION'], 
									"is_pay"=>"0",
									"receiveNo"=>$value['RECEIVE_NO']
							);

							if($value['ACCOUNT']=="0"){
								$akun_debit = "378";//HPP obat
							}else if($value['ACCOUNT']=="1"){
								$akun_debit = "398";//Biaya Barang Inventaris Perala
							}else{
								$akun_debit = "378";//Biaya Barang Inventaris Perala
							}
							$dataHutang = array(
								'tanggal' =>$value['DATE'],
								'invoiceBuyID'=>$value['INVOICE_NO'],
								'keterangan'=>" ".$value['DESCRIPTION'],
								'supplierID'=>$value['VENDOR_ID'],
								'nominal'=>$value['TOTAL_PURCHASES'], 
								'akun_debit'=>$akun_debit,
								'akun_kredit'=>"281" //utang usaha
							);
							$this->_ci->jurnal_model->fill_data_add_hutang($dataHutang);
							$this->_ci->jurnal_model->insert_data();
							
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
		                                    "supplierName"=>$value['DISTRIBUTOR_NAME'], 
		                                    "supplierBankname"=>$value['BANK_NAME'],
											"supplierBankid"=>$value['BANK_ACCOUNT_ID'],
											"supplierNPWP"=>$value['TAX_ID'],
		                                    "VAT"=>$value['VAT'],
		                                    "ppn"=>$value['VAT'],
		                                    "date"=>$value['DATE'],
		                                    "receiveNo"=>$value['RECEIVE_NO']
		                            );

							$dataUpdate['debt'][] = array(
									"invoiceID"=>$value['INVOICE_NO'],
									"status"=>"0",
									"createdDate"=>date("y-m-d h:i:s"),
									//"trxTerminDate"=>$value['PAYMENT_DUE'],
									"createdUserID"=>$value['ACCOUNT'],
		                            "receiveNo"=>$value['RECEIVE_NO']
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
									"trxTerminDate"=>$value['PAYMENT_DUE'],
									"createdDate"=>"",
									"userID"=>"",
									"note"=>$value['DESCRIPTION'], 
									"is_pay"=>"0",
									"receiveNo"=>$value['RECEIVE_NO']
							);

						}
						$qupdate .= " UPDATE PROCUREMENTS_ORDERS SET status = 1 WHERE NO_ORDER = '".$value['NO_ORDER']."' AND RECEIVE_NO='".$value['RECEIVE_NO']."'; ";				
						$x++;
					}
					/*var_dump($dataPO,$dataPOUpdate,$data,$dataUpdate);
					die();*/
					$dataInsert = $this->_ci->Surplus_model->insert_or_duplicate_update_batch($dataPO,$dataPOUpdate,$data,$dataUpdate);
					$result = array("message"=>"Sync Data Success","data"=>$dataInsert,"updated"=>$qupdate,"error"=>"0");
					$this->ExecQueryFront($qupdate);
				}else{
					$result = array("message"=>"ALL PO LOADED","data"=>"","error"=>"1");
				}
			}else{
				$result = array("message"=>"Error Query","data"=>"","error"=>"1");
			}
		}else{
			$result = array("message"=>$DataFront['message'],"data"=>"","error"=>"1");
		}

		return $result;
		
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
		$this->_ci->Surplus_model->table= 'as_suppliers';
		$this->_ci->Surplus_model->primary= 'supplierCode';

		$condition = array('supplierCode'=>$vendor['VENDOR_ID']);
		$q = $this->_ci->Surplus_model->get_all($condition);

		if ( $q->num_rows() > 0 ) 
		{
		   $this->_ci->Surplus_model->table_update($vendor['VENDOR_ID'],$dataSuplier);
		} else {
			$dataSuplier["supplierID"] = $vendor['VENDOR_ID'];
		   	$this->_ci->Surplus_model->table_add($dataSuplier);
		}
	}



	function sync_payment(){
		//$validate = $this->validate_login();
		
		/*if($validate['error']==1){
			$this->set_response($validate['message'], REST_Controller::HTTP_UNAUTHORIZED);
		}*/

		$dataPayment = $this->loadDataAPI("sync_payment");
		/*var_dump($dataPayment);
		die();*/
		$payment = $dataPayment['data'];//$this->Gemss_model->get_payment_unsync($condition)->result();
		$result = "";
		if(is_array($payment) && count($payment) > 0){
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
			$this->ExecQueryFront($qupdate);
		}else{
			//$result = $payment;
		}

		return ($result);
		
	}

	function fetch_tbl_payment($option,$data,$payment_name){
		if($payment_name !=""){ // cek pembayaran apakah dikenali oleh sistem atau tidak
			$dataPost = $data;// ambil data yang diposting ke API
			if(!is_array($dataPost)){
				$message = array("message"=>"Data diposting tidak sesuai format","data"=>$dataPost,"error"=>"1");
			}else{
				//cek payment apakah terdaftar atau tidak
				$this->_ci->Surplus_model->table = "tbl_maping_payment";
				$condition = array("payment_name"=>$payment_name);
				
				$MappingPayment = $this->_ci->Surplus_model->get_all($condition);

				if($MappingPayment->num_rows() > 0){

					$dataPayment = array(
						//"id"=>$data['ID'],
						"no"=>$data['REGISTRATION_CODE'],
						"tgl"=>$data['PAYMENT_DATE'],
						"f_id"=>"1",
						"keterangan"=>"pay_billing_".$payment_name."_".$data['REGISTRATION_CODE'] ,
						"invoice_no"=>$data['PAYMENT_CODE'],
						"login_id"=>$this->_ci->session->userdata("SESS_USER_ID"),
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
					
					$modelData = $this->_ci->Surplus_model;
					$modelData->table = 'jurnal_unpost';
					$modelData->primary = "id";
					

					$cekInvID = $this->_ci->Surplus_model->check_exists(array("invoice_no"=>$dataPayment['invoice_no'],"REGISTRATION_CODE"=>$dataPayment['REGISTRATION_CODE'],"PAYMENT_TYPE"=>$dataPayment['PAYMENT_TYPE'],));
					
					if($cekInvID['respon'] === false)	
					{
						$saveData = $this->proses_fetch_tbl($modelData,$dataPayment,$option); //masukan jurnal
					}else{
						$saveData = array('data'=>$cekInvID['data']->id,'error'=>0,'message'=>""); //ambil id jurnal dari db
					}
					if($saveData['error'] ==0){
						$idJurnal = $saveData['data']; //id yang telah dimasukan kedalam jurnal
						
						//input detail jurnal
						$dataMapping = $MappingPayment->result();
						//foreach($dataPost as $index=>$item){
							
							$debet = "";
							$kredit ="";
							foreach($dataMapping as $Payment_type_db){
								if($data['PAYMENT_TYPE'] === "INSURANCE" && $data['INSURANCE_NAME'] === $Payment_type_db->payment_sub_type ){
									$debet = $Payment_type_db->payment_coa_debet;
									$kredit = $Payment_type_db->payment_coa_kredit;
									break;
								}else if($data['PAYMENT_TYPE'] === $Payment_type_db->payment_type  ){
									$debet = $Payment_type_db->payment_coa_debet;
									$kredit = $Payment_type_db->payment_coa_kredit;
									
								}
							}
							if($debet =="" || $kredit==""){
								//var_dump($data);
								echo ("payment_mapping_not found");
								
							}else{
								$dataDetailJurnalDebet = array(
														'jurnal_id' =>$idJurnal ,
														'item'=>'1',
														'akun_id'=>$debet,
														'debit_kredit'=>1,
														'nilai'=>$data['AMOUNT'],
														'keterangan'=>''
														);
								$dataDetailJurnalKredit = array(
														'jurnal_id' =>$idJurnal ,
														'item'=>'1',
														'akun_id'=>$kredit,
														'debit_kredit'=>0,
														'nilai'=>$data['AMOUNT'],
														'keterangan'=>''
														);
								$this->_ci->Surplus_model->table = "jurnal_unpost_detail";
								$this->_ci->Surplus_model->table_add($dataDetailJurnalDebet);
								$this->_ci->Surplus_model->table_add($dataDetailJurnalKredit);
								
							/*	$this->Gemss_model->table = "trx_payment";*/
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

	
	public function is_enabled()
	{
		return function_exists('curl_init');
	}

	function ExecQueryFront($qupdate){
		// Start session (also wipes existing/previous sessions)
		$this->_ci->curl->create($this->API_SERVER."/Sync_athos/execQuery");
		// Option & Options
		$this->_ci->curl->options(array(CURLOPT_BUFFERSIZE => 10));
		$this->Data = array_merge($this->Data,array("qupdate"=>$qupdate));
		/*var_dump($this->Data);
		die();*/
		// Login to HTTP user authentication
		$this->_ci->curl->http_login($this->API_USER, $this->API_PASS);
		$this->_ci->curl->post($this->Data);
		$response = $this->_ci->curl->execute();
		if($this->_ci->curl->error_code !=0){
			$return = array("message"=>"Error excute Query ,failed connect ".$this->_ci->curl->error_string,"data"=>"","error"=>$this->_ci->curl->error_code);
		}else{
			$return = json_decode($response,true);
			
		}
		return $return;
	}


}

/* End of file Iddsso.php */
/* Location=> ./application/libraries/Iddsso.php */
