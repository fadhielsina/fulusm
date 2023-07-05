<?php

class Jurnal_unpost_model extends CI_Model {

	var $data;
	var $details;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function set_id($id)
	{
		$this->db->where('jurnal_unpost.id', $id);
	}

	function set_month_year($month, $year, $sign = '=')
	{
		$unit = '';
		$val = '';
		if($year !== '0')
		{
			$unit = 'YEAR';
			$val = $year;
		} 
		if($month !== '0')
		{
			$unit = ($unit) ? $unit.'_MONTH' : 'MONTH';
			$val .= $month;
 		}
 		if($unit) $this->db->where("EXTRACT($unit FROM tgl) $sign", $val);
	}

	function set_account_id($akun_id)
	{
		$this->db->where('jurnal_unpost_detail.akun_id', $akun_id);
	}

	function set_account_group_id($id)
	{
		$this->db->where_in('akun.kelompok_akun_id', $id);
	}
	
/*	function set_f($f)
	{
		$this->db->where_in('jurnal_unpost.f_id', $f);
	}
*/

	function set_project($kelompok_akun_id = 0, $proyek_id = '')
	{
		if($kelompok_akun_id) $this->db->where('akun.kelompok_akun_id', $kelompok_akun_id);
		if($proyek_id)
		{
			$this->db->where('jurnal_unpost.proyek_id', $proyek_id);
		}
		else
		{
			$this->db->where('jurnal_unpost.proyek_id != ', 'NULL');
		}
	}

	function get_data($option="penggajian",$paymentCode="", $paymentType = '')
	{
		$this->db->select('jurnal_unpost.id, 
			jurnal_unpost.tgl, jurnal_unpost.no, 
			jurnal_unpost.keterangan,
			jurnal_unpost.CLASS,
			jurnal_unpost.INSURANCE_NAME, 
			jurnal_unpost.f_id AS f_id, 
			jurnal_unpost.is_posting,
			jurnal_unpost.is_setor,
			f.nama AS f_name, 
			jurnal_unpost.proyek_id,
			jurnal_unpost.invoice_no,
			jurnal_unpost.PAYMENT_TYPE,
			as_sales_transactions.invoiceID, 
			sum(jurnal_unpost_detail.item) item, 
			jurnal_unpost_detail.akun_id, 
			akun.nama as account_name, 
			akun.kelompok_akun_id, 
			sum(if(jurnal_unpost_detail.debit_kredit=1,jurnal_unpost_detail.nilai,0))debet,
			sum(if(jurnal_unpost_detail.debit_kredit=0,jurnal_unpost_detail.nilai,0))kredit
			',FALSE);
		$this->db->from('jurnal_unpost');
		$this->db->join('f', 'jurnal_unpost.f_id=f.id', 'INNER');
		$this->db->join('jurnal_unpost_detail', 'jurnal_unpost_detail.jurnal_id=jurnal_unpost.id', 'INNER');
		$this->db->join('akun', 'jurnal_unpost_detail.akun_id=akun.id', 'INNER');
		$this->db->join('as_sales_transactions', 'jurnal_unpost.invoice_no=as_sales_transactions.invoiceID', 'LEFT');
		if($this->session->userdata('ADMIN')!='1')
		{
		 //$this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}

		if($paymentCode!=""){
			$this->db->where('jurnal_unpost.invoice_no', $paymentCode);
		}

		if($paymentType!=""){
			$this->db->where('jurnal_unpost.PAYMENT_TYPE', $paymentType);
		}
		
		if($option == "penggajian"){
			$this->db->like('jurnal_unpost.keterangan','penggajian','AFTER',false);
		}else if($option == "billing"){
			$this->db->like('jurnal_unpost.keterangan','pay_billing','AFTER',false);
		}

		if($paymentType =="CASH"){
			$this->db->where('jurnal_unpost.is_setor',0);
		}

		$this->db->group_by("jurnal_unpost.id");
		$this->db->order_by('jurnal_unpost.tgl', 'asc');

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	function get_data_id($id,$detail=false)
	{
		$querySql ="SELECT jurnal_unpost.id,
				jurnal_unpost.`no`,
				jurnal_unpost.tgl,
				jurnal_unpost.proyek_id,
				jurnal_unpost.invoice_no,
				jurnal_unpost.login_id,
				jurnal_unpost.waktu_post,
				jurnal_unpost.REGISTRATION_CODE,
				jurnal_unpost.PATIENT_NAME,
				jurnal_unpost.REGISTRATION_TYPE,
				jurnal_unpost.PAYMENT_CODE,
				jurnal_unpost.CLASS,
				jurnal_unpost.PATIENT_TYPE,
				jurnal_unpost.INSURANCE_CODE,
				jurnal_unpost.INSURANCE_NAME,
				jurnal_unpost.DEPARTMENT_CODE,
				jurnal_unpost.DEPARTMENT_NAME,
				jurnal_unpost.PAYMENT_TYPE,
				jurnal_unpost.ADMINISTRATION_PAYMENT_FEE,
				jurnal_unpost.AMOUNT,
				jurnal_unpost.CASHIER_CODE,
				jurnal_unpost.CASHIER_NAME,
				jurnal_unpost.SHIFT,
				jurnal_unpost.PAYMENT_DATE,
				jurnal_unpost.CREATED_AT,
				jurnal_unpost.is_posting,
				jurnal_unpost.keterangan,
				jurnal_unpost_detail.jurnal_id,
				jurnal_unpost_detail.item,
				jurnal_unpost_detail.akun_id,
				jurnal_unpost_detail.debit_kredit,
				jurnal_unpost_detail.nilai,
				f.nama AS nama_kelompok,
				jurnal_unpost.f_id,
				akun.nama AS nama_akun,
				akun.parent_akun,
				akun.id_departement,
				akun.kode,
				akun.pajak,
				akun.kelompok_akun_id,
				akun.saldo_awal,
				akun.saldo
			FROM
				`jurnal_unpost`
				INNER JOIN `f` ON `jurnal_unpost`.`f_id` = `f`.`id`
				INNER JOIN `jurnal_unpost_detail` ON `jurnal_unpost_detail`.`jurnal_id` = `jurnal_unpost`.`id`
				INNER JOIN `akun` ON `jurnal_unpost_detail`.`akun_id` = `akun`.`id` 
			WHERE
				`jurnal_unpost`.`id` = '".$id."' ";
		if($detail==false){
		 	$querySql .="	GROUP BY
				`jurnal_unpost`.`invoice_no` ";
		}
			$querySql .= "	ORDER BY
				`jurnal_unpost`.`tgl` ASC";
		/*$this->db->select('jurnal_unpost.id,
						jurnal_unpost.`no`,
						jurnal_unpost.tgl,
						jurnal_unpost.proyek_id,
						jurnal_unpost.invoice_no,
						jurnal_unpost.login_id,
						jurnal_unpost.waktu_post,
						jurnal_unpost.REGISTRATION_CODE,
						jurnal_unpost.PATIENT_NAME,
						jurnal_unpost.REGISTRATION_TYPE,
						jurnal_unpost.PAYMENT_CODE,
						jurnal_unpost.CLASS,
						jurnal_unpost.PATIENT_TYPE,
						jurnal_unpost.INSURANCE_CODE,
						jurnal_unpost.INSURANCE_NAME,
						jurnal_unpost.DEPARTMENT_CODE,
						jurnal_unpost.DEPARTMENT_NAME,
						jurnal_unpost.PAYMENT_TYPE,
						jurnal_unpost.ADMINISTRATION_PAYMENT_FEE,
						jurnal_unpost.AMOUNT,
						jurnal_unpost.CASHIER_CODE,
						jurnal_unpost.CASHIER_NAME,
						jurnal_unpost.SHIFT,
						jurnal_unpost.PAYMENT_DATE,
						jurnal_unpost.CREATED_AT,
						jurnal_unpost.is_posting,
						jurnal_unpost.keterangan,
						jurnal_unpost_detail.id,
						jurnal_unpost_detail.jurnal_id,
						jurnal_unpost_detail.item,
						jurnal_unpost_detail.akun_id,
						jurnal_unpost_detail.debit_kredit,
						jurnal_unpost_detail.nilai,
						f.id,
						f.nama nama_kelompok,
						jurnal_unpost.f_id,
						akun.nama nama_akun,
						akun.parent_akun,
						akun.id_departement,
						akun.kode,
						akun.pajak,
						akun.kelompok_akun_id,
						akun.saldo_awal,
						akun.saldo
							');
		$this->db->from('jurnal_unpost');
		$this->db->join('f', 'jurnal_unpost.f_id=f.id', 'INNER');
		$this->db->join('jurnal_unpost_detail', 'jurnal_unpost_detail.jurnal_id=jurnal_unpost.id', 'INNER');
		$this->db->join('akun', 'jurnal_unpost_detail.akun_id=akun.id', 'INNER');
		$this->db->where('jurnal_unpost.id', $id);
		$this->db->order_by('jurnal_unpost.tgl', 'asc');
		 $this->db->group_by('jurnal_unpost.invoice_no');*/
		
		$query = $this->db->query($querySql);
		if ($query->num_rows() > 0)
		{
			return ($query->result());
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_data_id_debit($id)
	{
		$this->db->select('jurnal_unpost.id, jurnal_unpost.tgl, jurnal_unpost.no, jurnal_unpost.invoice_no, jurnal_unpost.keterangan, jurnal_unpost.f_id AS f_id, f.nama AS f_name, jurnal_unpost.proyek_id, proyek.nama as project_name, jurnal_unpost_detail.item, jurnal_unpost_detail.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_unpost_detail.debit_kredit, jurnal_unpost_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal_unpost.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_unpost_detail.jurnal_id=jurnal_unpost.id', 'INNER');
		$this->db->join('akun', 'jurnal_unpost_detail.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal_unpost.proyek_id=proyek.id', 'LEFT');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=jurnal_unpost.invoice_no', 'LEFT');
		$this->db->where('jurnal_unpost.invoice_no', $id);
		$this->db->where('jurnal_unpost_detail.debit_kredit', 1);
		$this->db->order_by('jurnal_unpost.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	function get_data_id_kredit($id)
	{
		$this->db->select('jurnal_unpost.id, jurnal_unpost.tgl, jurnal_unpost.no, jurnal_unpost.invoice_no, jurnal_unpost.keterangan, jurnal_unpost.f_id AS f_id, f.nama AS f_name, jurnal_unpost.proyek_id, proyek.nama as project_name, jurnal_unpost_detail.item, jurnal_unpost_detail.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_unpost_detail.debit_kredit, jurnal_unpost_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal_unpost.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_unpost_detail.jurnal_id=jurnal_unpost.id', 'INNER');
		$this->db->join('akun', 'jurnal_unpost_detail.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal_unpost.proyek_id=proyek.id', 'LEFT');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=jurnal_unpost.invoice_no', 'LEFT');
		$this->db->where('jurnal_unpost.invoice_no', $id);
		$this->db->where('jurnal_unpost_detail.debit_kredit', 0);
		$this->db->order_by('jurnal_unpost.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function get_laba_rugi_data()
	{
		$this->db->select('MONTH(jurnal_unpost.tgl) AS month, YEAR(jurnal_unpost.tgl) AS year, kelompok_akun.id AS kelompok_akun, jurnal_unpost_detail.debit_kredit, SUM(jurnal_unpost_detail.nilai) AS nilai');
		$this->db->from('jurnal');
		$this->db->join('jurnal_detail', 'jurnal_unpost_detail.jurnal_id=jurnal_unpost.id AND jurnal_unpost.f_id != 3', 'INNER');
		$this->db->join('akun', 'jurnal_unpost_detail.akun_id=akun.id', 'INNER');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id = kelompok_akun.id', 'INNER');
		$this->db->where_in('kelompok_akun.id', array( 4, 5 ) );
		$this->db->where('extract(year_month from jurnal_unpost.tgl) > extract(year_month from (date_sub(curdate(), interval 1 year)))');		
		$this->db->group_by(array('MONTH(jurnal_unpost.tgl)', 'YEAR(jurnal_unpost.tgl)', 'kelompok_akun.id', 'jurnal_unpost_detail.debit_kredit'));
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$result[$row->month][$row->year][$row->kelompok_akun][$row->debit_kredit] = $row->nilai;
			}
			return $result;
		}
		else
		{
			return FALSE;
		}
	}

	function fill_data()
	{
		$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('nomorinvoice'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$object  = array(
                'is_publish' => 1
            );
            $this->db->where('invoiceID', $this->data['invoice_no']);
            $this->db->update('as_sales_transactions', $object);
		if($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
			$keterangan =$this->input->post('keterangan'.$i);
			if(($debit != '') || ($kredit != ''))
			{
				if($debit != '')
				{
					$dk = 1;
					$value = $debit;
				}
				else
				{
					$dk = 0;
					$value = $kredit;
				}
				$this->details[$i] = array(
					'item' => $i,
					'akun_id' => $akun[$i-1],
					'debit_kredit' => $dk,
					'nilai' => $value,
					'keterangan' => $keterangan
					);
			}
		}
	}
	
	
	
	function fill_data_transfer()
	{
		
		$tipe_trx= $this->input->post('tipe_trx');
		
		
		
			if($tipe_trx=='add'){
				$no_kas= $this->GenKasNumber($this->input->post('jns'));
				$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $no_kas,
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		
				
				$object  = array(    
			'no_trx_kas' =>  $no_kas,
			 'tgl_catat' => date("Y-m-d"),
			 'jumlah' => str_replace(',','',$this->input->post('jumlah')),
			 'keterangan' => $this->input->post('catatan'),
			 'jns_trans' => $this->input->post('jns'),
			 'dari_kas_id' => $this->input->post('akun_dari'),
			 'untuk_kas_id' => $this->input->post('akun_untuk'),
			 'posting' => 1,
			 'identity_id' => $this->input->post('identity_id'),
			 'user' => $this->input->post('userid')
            );
            $this->db->insert('tbl_trans_kas', $object);
			}
			else if($tipe_trx=='edit')
			{
			$id_trx_kas=$this->input->post('id_trx_kas');
				$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $id_trx_kas,
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
				
				$id_trx= $this->input->post('id_trx');
				$object  = array(    
			 'update_data' => date("Y-m-d"),
			 'jumlah' => str_replace(',','',$this->input->post('jumlah')),
			 'keterangan' => $this->input->post('catatan'),
			 'jns_trans' => $this->input->post('jns'),
			 'dari_kas_id' => $this->input->post('akun_dari'),
			 'untuk_kas_id' => $this->input->post('akun_untuk'),
			 'posting' => 1,
			 'update_user' => $this->input->post('userid')
            );
		   $this->db->where('id', $id_trx);
            $this->db->update('tbl_trans_kas', $object);
			}
		if($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
			$keterangan =$this->input->post('keterangan'.$i);
			if(($debit != '') || ($kredit != ''))
			{
				if($debit != '')
				{
					$dk = 1;
					$value = $debit;
				}
				else
				{
					$dk = 0;
					$value = $kredit;
				}
				$this->details[$i] = array(
					'item' => $i,
					'akun_id' => $akun[$i-1],
					'debit_kredit' => $dk,
					'nilai' => $value,
					'keterangan' => $keterangan
					);
			}
		}
	}
	
	function fill_data_kas_in()
	{
		
		$tipe_trx= $this->input->post('tipe_trx');
		
		
		
			if($tipe_trx=='add'){
				$no_kas= $this->GenKasNumber($this->input->post('jns'));
				$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $no_kas,
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		
				
				$object  = array(    
			'no_trx_kas' =>  $no_kas,
			 'tgl_catat' => date("Y-m-d"),
			 'jumlah' => str_replace(',','',$this->input->post('jumlah')),
			 'keterangan' => $this->input->post('catatan'),
			 'jns_trans' => $this->input->post('jns'),
			 'dari' => $this->input->post('dari'),
			 'dok' => $this->input->post('dokumen'),
			 'posting' => 1,
			 'no_dok' => $this->input->post('no_dokumen'),
			 'identity_id' => $this->input->post('identity_id'),
			 'user' => $this->input->post('userid')
            );
            $this->db->insert('tbl_trans_kas', $object);
			}
			else if($tipe_trx=='edit')
			{
			$id_trx_kas=$this->input->post('id_trx_kas');
				$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $id_trx_kas,
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
				
				$id_trx= $this->input->post('id_trx');
				$object  = array(    
			 'update_data' => date("Y-m-d"),
			 'jumlah' => str_replace(',','',$this->input->post('jumlah')),
			 'keterangan' => $this->input->post('catatan'),
			 'jns_trans' => $this->input->post('jns'),
			 'dari' => $this->input->post('dari'),
			 'dok' => $this->input->post('dokumen'),
			 'posting' => 1,
			 'no_dok' => $this->input->post('no_dokumen'),
			 'update_user' => $this->input->post('userid')
            );
		   $this->db->where('id', $id_trx);
            $this->db->update('tbl_trans_kas', $object);
			}
		if($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
			$keterangan =$this->input->post('keterangan'.$i);
			if(($debit != '') || ($kredit != ''))
			{
				if($debit != '')
				{
					$dk = 1;
					$value = $debit;
				}
				else
				{
					$dk = 0;
					$value = $kredit;
				}
				$this->details[$i] = array(
					'item' => $i,
					'akun_id' => $akun[$i-1],
					'debit_kredit' => $dk,
					'nilai' => $value,
					'keterangan' => $keterangan
					);
			}
		}
	}
	
	
	function fill_data_pembelian()
	{
		
		$tipe_trx= $this->input->post('tipe_trx');
		
		
		
			if($tipe_trx=='add'){
				$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('invoiceIDmanual'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		
			$status_trx=$this->input->post('trxStatus');
				if($status_trx=='2')
			{
				$pay="0";
			}
			else
			{
				$pay="1";
			}
				$object  = array(    
				'invoiceBuyID' => $this->input->post('invoiceIDmanual'),
			'trxFullName' => $this->input->post('trxFullName'),
			'trxAddress' => $this->input->post('trxAddress'),
			'trxPhone' => $this->input->post('trxPhone'),
			'supplierID' => $this->input->post('memberCode'),
			'trxDate' => $this->input->post('trxDate'),
			'note' => $this->input->post('note'),
			'trxTotal' =>str_replace(',','',$this->input->post('trxTotal')),
			'userID' => $this->session->userdata('SESS_USER_ID'),
			'identityID' => $this->session->userdata('IDENTITY_ID'),
			'trxStatus' => $this->input->post('trxStatus'),
			'trxTerminDate' => $this->input->post('trxTerminDate'),
			'trxbankmethod' => $this->input->post('jns_bayar'),
			'trxAdmin' => str_replace(',','',$this->input->post('b_admin')),
			'posting' =>1,
			'is_pay' =>$pay,
			'createdDate' => date("Y-m-d H:i:s")
            );
            $this->db->insert('as_buy_transactions', $object);
			
			if($status_trx=='2')
			{
			$object  = array(    
			'invoiceID' => $this->input->post('invoiceIDmanual'),
			'status' => 1,
			'createdDate' => date("Y-m-d H:i:s")
            );
            $this->db->insert('as_debts', $object);	
			}
			}
			else if($tipe_trx=='edit')
			{
				$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('invoiceIDmanual'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
				
				$id_trx= $this->input->post('id_trx');
				$status_trx=$this->input->post('trxStatus');
				if($status_trx=='2')
			{
				$pay="0";
			}
			else
			{
				$pay="1";
			}
				$object  = array(    
			'trxFullName' => $this->input->post('trxFullName'),
			'trxAddress' => $this->input->post('trxAddress'),
			'trxPhone' => $this->input->post('trxPhone'),
			'supplierID' => $this->input->post('memberCode'),
			'trxDate' => $this->input->post('trxDate'),
			'note' => $this->input->post('note'),
			'trxTotal' =>str_replace(',','',$this->input->post('trxTotal')),
			'modifiedUserID' => $this->session->userdata('SESS_USER_ID'),
			'identityID' => $this->session->userdata('IDENTITY_ID'),
			'trxStatus' => $this->input->post('trxStatus'),
			'trxTerminDate' => $this->input->post('trxTerminDate'),
			'trxbankmethod' => $this->input->post('jns_bayar'),
			'trxAdmin' => str_replace(',','',$this->input->post('b_admin')),
			'posting' =>1,
			'is_pay' =>$pay,
			'is_update' =>1,
			'modifiedDate' => date("Y-m-d H:i:s")
            );
		   $this->db->where('trxID', $id_trx);
            $this->db->update('as_buy_transactions', $object);
			}
		if($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
			$keterangan =$this->input->post('keterangan'.$i);
			if(($debit != '') || ($kredit != ''))
			{
				if($debit != '')
				{
					$dk = 1;
					$value = $debit;
				}
				else
				{
					$dk = 0;
					$value = $kredit;
				}
				$this->details[$i] = array(
					'item' => $i,
					'akun_id' => $akun[$i-1],
					'debit_kredit' => $dk,
					'nilai' => $value,
					'keterangan' => $keterangan
					);
			}
		}
	}
	
	
	
	
	function fill_data_pembelian_pay()
	{
		
		$trxStatus= $this->input->post('trxStatus');
		
		
		    $this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('nomorinvoice'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		
			
				$object  = array(    
				'debtID' => $this->input->post('debtID'),
			'debtDate' => date("Y-m-d H:i:s"),
			'debtPay' => str_replace(',','',$this->input->post('trxTotalbyr')),
			'b_admin' => str_replace(',','',$this->input->post('b_admin')),
			'createdUserID' => $this->session->userdata('SESS_USER_ID'),
			'payMethod' => $this->input->post('jns_bayar'),
			'bank' => $this->input->post('bank'),
			'bank_v' => $this->input->post('bankven')
            );
            $this->db->insert('as_debts_payment', $object);
			
			if($trxStatus=='2')
			{
			$object  = array(    
			
			'is_pay' => 1
            );
             $this->db->where('invoiceBuyID', $this->input->post('nomorinvoice'));
            $this->db->update('as_buy_transactions', $object);
			}
			
			
		if($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
			$keterangan =$this->input->post('keterangan'.$i);
			if(($debit != '') || ($kredit != ''))
			{
				if($debit != '')
				{
					$dk = 1;
					$value = $debit;
				}
				else
				{
					$dk = 0;
					$value = $kredit;
				}
				$this->details[$i] = array(
					'item' => $i,
					'akun_id' => $akun[$i-1],
					'debit_kredit' => $dk,
					'nilai' => $value,
					'keterangan' => $keterangan
					);
			}
		}
	}
	//Check for duplicate no
	function check_no()
	{
		$this->db->where('no', $this->data['no']);
		$query = $this->db->get('jurnal');

		if ($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}	

	function insert_data()
	{
		$this->db->trans_start();
		$this->db->insert('jurnal', $this->data);
		$jurnal_id = $this->db->insert_id();
		for ($i = 1; $i <= count($this->details); $i++)
		{
			$this->details[$i]['jurnal_id'] = $jurnal_id;
			$this->db->insert('jurnal_detail', $this->details[$i]);
			$op = ($this->details[$i]['debit_kredit']) ? '+' : '-';
			$this->db->query('UPDATE akun SET saldo = saldo'.$op.$this->details[$i]['nilai'].' WHERE id = '.$this->details[$i]['akun_id']);
		}
		$this->db->trans_complete();	
		return $this->db->trans_status();
	}
	
	public function tampil_member()
	{
		return $this->db->get('as_members');
	}
	
		public function hapus_jurnal($id,$idjurnal)
	{
		return $this->db->delete('jurnal_detail', array('jurnal_id' => 12));
		return $this->db->delete('jurnal', array('invoice_no' => $id));
	}
	
	function GenJurNumber()
		{

		$trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1;')->row_array();
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
		
		function GenKasNumber($jns)
		{
		$trxid = mysql_fetch_array(mysql_query('SELECT * from tbl_trans_kas order by id desc limit 1;'));
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no_trx_kas'];
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

		$kode = $jns."-".date('d')."-". $invno;
		return $kode;
		}
	function posting_data($id_jurnal){
		$jurnalData =$this->get_data_id($id_jurnal,true);
		//echo '<pre>';
	//var_dump($this->get_data_id($id_jurnal));
	//die();
		if($jurnalData > 0 ){
			$jurnalDataTemp = (array)$jurnalData[0];
			
			$data = array(
				'no' =>  $this->GenJurNumber(),
				'tgl' => $jurnalDataTemp['tgl'],
				'f_id' => $jurnalDataTemp['f_id'],
				'invoice_no' => $jurnalDataTemp['invoice_no'],
				'keterangan' => $jurnalDataTemp['keterangan'],
				'login_id' => $jurnalDataTemp['login_id'],
				'waktu_post' => date("Y-m-d")
			);
		
			if($this->db->insert("jurnal",$data)){
				$lastID = $this->db->insert_id();

				if($lastID!=""){
					$query = false;
					foreach($jurnalData as $index=>$item){
						$item = (array)$item;
						$details = array(
							'jurnal_id' => $lastID,
							'item' => $item['item'],
							'akun_id' => $item['akun_id'],
							'debit_kredit' => $item['debit_kredit'],
							'nilai' => $item['nilai'],
							'keterangan' => $item['keterangan'],
							);
						$query = $this->db->insert("jurnal_detail",$details);
						$queryUpdateSaldo =  $this->db->query("UPDATE akun set saldo = (saldo+ ".$item['nilai'].") WHERE akun.id='".$item['akun_id']."' ");
					}
					if($query){
						//$DB = $this->db();
						$this->db->where('id', $jurnalDataTemp['id']);
						$this->db->update("jurnal_unpost",array("is_posting"=>1));
						if($jurnalDataTemp['PAYMENT_TYPE']=="INSURANCE"){//jika dia insurance masukan ke piutang
							//insert into receivable
							$this->db->insert("as_receivables",array(
													"invoiceID"=>$jurnalDataTemp['invoice_no'],
													"status"=>"0",
													"createdDate"=>date("y-m-d h:i:s"),
													"createdUserID"=>$this->session->userdata('IDENTITY_ID'),
													));

							//insert into transaction
							$this->db->insert("as_sales_transactions",array(
													"invoiceID"=>$jurnalDataTemp['invoice_no'],
													"memberID"=>"0",
													"trxTime"=>date("y-m-d h:i:s"),
													"trxDate"=>date("y-m-d"),
													"trxSubtotal"=>"",
													"trxPPN"=>"",
													"trxTotal"=>$item['nilai'],
													"trxStatus"=>0,
													"userID"=>$jurnalDataTemp['login_id'],
													"createdDate"=>date("y-m-d h:i:s"),
													"createdUserID"=>$this->session->userdata('IDENTITY_ID'),
													));
						}

						return true;
					}else{
						return false;
					}

					
				}else{
					return false;
				}
			}else{
				return false;
			}

			
		}
		

	}

	function posting_cash(){
		$DataCash = $this->db->select("*")
			->from('jurnal_unpost')
			->where("is_posting", 0)
			->where_in("PAYMENT_TYPE", array('CASH'))
			->get()->result_array();

		$TotalSetor = 0;
		foreach ($DataCash as $key => $value) {
			 $TotalSetor +=  $value['AMOUNT	'];
		}
		$no_kas= $this->GenKasNumber("KM");
		$object  = array(
			'no_trx_kas' => $no_kas,
			'tgl_catat' => date("y-m-d"),
			'jumlah' => $TotalSetor,
			'keterangan' => "Penerimaan Cash dari kasir tgl :".date("y-m-d"),
			'jns_trans' => "KM",
			'akun' => "pemasukan",
			'dari' => 'Kasir',
			'posting' => 1,
			'identity_id' => $this->input->post('identity_id'),
			'user' => $this->input->post('userid')
		);
		$this->db->insert('tbl_trans_kas', $object);

	}

	public function get_total_setoran_kasir()
	{
		$yesterday = date('Y-m-d',strtotime("-1 days"));
		$this->db->select_sum('AMOUNT')
			->where('PAYMENT_TYPE', 'CASH')
			//->where('tgl', $yesterday)
			//->where('is_posting', 0)
			->where('is_setor', 0);
		$result = $this->db->get('jurnal_unpost')->row();  
		return $result->AMOUNT;
	}

	public function update_status_setoran($jurnalid="")
	{
		//$yesterday = date('Y-m-d',strtotime("-1 days"));
		$this->db->where('PAYMENT_TYPE', 'CASH')
			//->where('tgl', $yesterday)
			->where('is_setor', 0);
		if($jurnalid!==""){
			$this->db->update("jurnal_unpost",array("is_setor" => 1,"no"=>$jurnalid));
		}else{
			$this->db->update("jurnal_unpost",array("is_setor" => 1));
		}
	}

	public function has_setoran_kasir()
	{
		return $this->get_total_setoran_kasir() > 0;
	}

	public function fill_data_penerimaan_lain()
	{
		
		$this->data = array(
			'no' =>  date('YmdHis'),
			'tgl' => $this->input->post('tgl_trx'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('no_bukti'),
			'keterangan' => 'pay_billing_lainnya',
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s"),
			'PATIENT_NAME' => $this->input->post('dari'),
			'PAYMENT_TYPE' => 'CASH',
			'AMOUNT' => str_replace(',','',$this->input->post('jumlah')),
			'CLASS' => $this->input->post('keterangan'),
			'is_posting' => 1
		);
			
		if($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		
		$akun = array();
		$akun[1] = array(
			'item' => 1,
			'akun_id' => $this->input->post('tf_dari'),
			'debit_kredit' => 0,
			'nilai' => str_replace(',','',$this->input->post('jumlah')),
			'keterangan' => ''
		);
		$akun[2] = array(
			'item' => 2,
			'akun_id' => $this->input->post('tf_ke'),
			'debit_kredit' => 1,
			'nilai' => str_replace(',','',$this->input->post('jumlah')),
			'keterangan' => ''
		);
		$this->details = $akun;
	}

	function insert_data_unpost()
	{
		$this->db->trans_start();
		$this->db->insert('jurnal_unpost', $this->data);
		$jurnal_id = $this->db->insert_id();
		for ($i = 1; $i <= count($this->details); $i++)
		{
			$this->details[$i]['jurnal_id'] = $jurnal_id;
			$this->db->insert('jurnal_unpost_detail', $this->details[$i]);
			//$op = ($this->details[$i]['debit_kredit']) ? '+' : '-';
			//$this->db->query('UPDATE akun SET saldo = saldo'.$op.$this->details[$i]['nilai'].' WHERE id = '.$this->details[$i]['akun_id']);
		}
		$this->db->trans_complete();	
		return $this->db->trans_status();
	}

	function check_no_unpost()
	{
		$this->db->where('invoice_no', $this->data['invoice_no']);
		$query = $this->db->get('jurnal_unpost');

		if ($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
}
/* End of file jurnal_model.php */
/* Location: ./application/models/jurnal_model.php */
