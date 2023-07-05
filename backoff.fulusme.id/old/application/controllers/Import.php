<?php

class Import extends CI_Controller {

	public $identity_id;

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if(($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID'))
		{
			$this->auth->check_user_authentification(1);
		}
		$this->load->model('jurnal_model');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));

		$this->identity_id = $this->session->userdata('IDENTITY_ID');
	}
	
	function index()
	{
		$data['title'] = 'Import Data Jurnal';
		$data['main_content'] = 'import/display';
		$data['form_action'] = site_url( 'import/import_exl' );
		$this->load->view('template/template_xpanel', $data);
	}

	public function import_exl()
	{
		$this->load->library('upload');

		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'xlsx';
		$config['max_size']             = 100;
		$this->upload->initialize($config); //

		if ( ! $this->upload->do_upload('file_upload')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata("message", "upload Gagal...!!!");
			redirect('import');

		}else{
			$data = array('upload_data' => $this->upload->data());
			
			$this->read_exl($data['upload_data']['full_path']);

			$this->session->set_flashdata("message", 'Import Berhasil... Silahkan check data jurnal anda !!!');

			redirect('import');

		}
	}

	public function read_exl( $path )
	{
		$this->load->library('phpexcel');
		
		$object = PHPExcel_IOFactory::load($path);

		foreach($object->getWorksheetIterator() as $worksheet){
			 $highestRow = $worksheet->getHighestRow();
			 $highestColumn = $worksheet->getHighestColumn();
			 $data = array();

			 for($row=2; $row<=$highestRow; $row++){
			 	$data[] = array(
			 		'date' => $worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue(),
				 	'doc_num' => trim( $worksheet->getCellByColumnAndRow(1, $row)->getValue() ),
				 	'coa' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
				 	'desc' => trim( $worksheet->getCellByColumnAndRow(3, $row)->getValue() ),
				 	'debit' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
				 	'kredit' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
				 	'jumlah' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
				 	'doc_po' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
				 	'unit_code' => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
				 	'cust_code' => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
				 	'ven_code' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
				 	'prod_code' => $worksheet->getCellByColumnAndRow(11, $row)->getValue(),
				 	'house' => $worksheet->getCellByColumnAndRow(12, $row)->getValue()
			 	);
			 }

			 if ( count( $data ) > 0 ) {

			 	$data_detail_jurnal = array();
			 	$data_jurnal = array();

			 	$data_receivables = array();
			 	$data_sales_trx = array();

			 	foreach( $data as $key => $d ) {

			 		if ( $d['debit'] > 0 ) {
			 			$jumlah = $d['debit'];
			 			$db = 1;
			 		} else {
			 			$jumlah = $d['kredit'];
			 			$db = 0;
			 		}

			 		$akun_id = $this->db->query("SELECT id FROM akun WHERE kode = '". $d['coa'] ."'")->row();

			 		$data_detail_jurnal[ $d['doc_num'] ][] = array(
			 			'akun_id' => $akun_id->id,
			 			'debit_kredit' => $db,
			 			'nilai' => $jumlah,
			 			'keterangan' => $d['desc']
			 		);

			 		$data_jurnal[ $d['doc_num'] ] = array(
			 			'tgl' => date('Y-m-d', strtotime( $d['date'] )),
						'f_id' => 1,
						'invoice_no' => $d['doc_num'],
						'keterangan' => $d['desc'],
						'login_id' => $this->session->userdata('SESS_USER_ID'),
						'waktu_post' => date("Y-m-d H:i:s"),
						'identityID' => $this->identity_id
			 		);

			 		if ( ! empty( $d['cust_code'] ) ) {

			 			$member_id = $this->db->query("SELECT memberID FROM as_members WHERE memberCode='". $d['cust_code'] ."'")->row();
			 			$sales_trx = array(
				 			'memberID' => $member_id->memberID,
			 				'invoiceID' => $d['doc_num'],
			 				'trxDate' => date('Y-m-d', strtotime( $d['date'] )),
			 				'trxSubtotal' => $jumlah,
			 				'trxTotal' => $jumlah,
			 				'trxStatus' => 1
				 		);

				 		if ( preg_match('/^112/', $d['coa'] ) || preg_match('/^113/', $d['coa'] ) ) {
				 			$sales_trx['trxStatus'] = 2;

				 			$data_receivables[ $d['doc_num'] ] = array(
				 				'invoiceID' => $d['doc_num'],
				 				'createdDate' => date('Y-m-d H:i:s')
				 			);
				 		}
				 		$data_sales_trx[ $d['doc_num'] ] = $sales_trx;
			 		}

			 	}

				// [1] INSERT INTO JURNAL
				foreach( $data_jurnal as $k_jur => $jur ) {
					$jur['no'] = $this->jurnal_model->GenJurNumber();
					$akuns = array();
					foreach( $data_detail_jurnal[ $k_jur ] as $k_jur_det => $det_jur ) {
						$det_jur['item'] = $k_jur_det + 1;
						$akuns[ $k_jur_det + 1 ] = $det_jur;
					}

					$this->jurnal_model->data = $jur;
					$this->jurnal_model->details = $akuns;
					
					$this->jurnal_model->insert_data();
				}

				// [2] INSERT INTO SALES TRX
				if ( count( $data_sales_trx ) > 0 ) {
					$this->db->insert_batch('as_sales_transactions', $data_sales_trx );
				}

				// [3] INSERT INTO PIUTANG
				if ( count( $data_receivables ) > 0 ) {
					$this->db->insert_batch('as_receivables', $data_receivables );
				}


			}
		}
	}

}
/* End of file import.php */
/* Location: ./application/CI_Controllers/import.php */
