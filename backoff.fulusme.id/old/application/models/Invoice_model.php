<?php

class Invoice_model extends CI_Model {

	var $data;
	var $details;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function set_id($id)
	{
		$this->db->where('jurnal.id', $id);
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
		if($unit) $this->db->where("EXTRACT($unit FROM trxDate) $sign", $val);
	}
	
		function tampil_member_json() {
		$this->datatables->select('*');
		$this->datatables->select('as_members.memberID');
		$this->datatables->select('as_members.memberCode');
		$this->datatables->select('as_members.memberFullName');
		$this->datatables->select('as_members.memberAddress');
		$this->datatables->select('as_members.memberPhone');
		$this->datatables->from('as_members');
		$this->datatables->add_column('view', '<a class="btn btn-xs btn-info btn-flat" href="'.base_url().'admin/edit_member/$1"><i class="fa fa-edit"></i></a> <a class="btn btn-xs btn-success btn-flat" href="'.base_url().'admin/detail_member/$1"><i class="fa fa-search"></i></a> <a class="btn btn-xs btn-danger btn-flat" href="'.base_url().'admin/hapus_member/$1"><i class="fa fa-trash"></i> </a>', 'memberID');
		return $this->datatables->generate();
	}
	
	function set_account_id($akun_id)
	{
		$this->db->where('jurnal_detail.akun_id', $akun_id);
	}

	function set_account_group_id($id)
	{
		$this->db->where_in('akun.kelompok_akun_id', $id);
	}
	
/*	function set_f($f)
	{
		$this->db->where_in('jurnal.f_id', $f);
	}
*/

	function set_project($kelompok_akun_id = 0, $proyek_id = '')
	{
		if($kelompok_akun_id) $this->db->where('akun.kelompok_akun_id', $kelompok_akun_id);
		if($proyek_id)
		{
			$this->db->where('jurnal.proyek_id', $proyek_id);
		}
		else
		{
			$this->db->where('jurnal.proyek_id != ', 'NULL');
		}
	}
	
	function get_data_invoice($id1,$id2,$id3)
	{
		$this->db->select('as_sales_transactions.*');
		$this->db->select('jurnal.no as no_jurnal');
		$this->db->select('login.*');
		$this->db->select('as_members.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_sales_transactions');
		$this->db->join('login', 'login.id=as_sales_transactions.userID', 'INNER');
		$this->db->join('as_members', 'as_members.memberID=as_sales_transactions.memberID', 'INNER');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'INNER');
		$this->db->join('jurnal', 'jurnal.invoice_no=as_sales_transactions.invoiceID', 'LEFT');
		if($this->session->userdata('ADMIN')!='1')
		{
		$this->db->where('as_sales_transactions.identityID', $id1);
		}
		else
		{
			if($id1!=' ')
				{
					$this->db->where('as_sales_transactions.identityID', $id1);
				}
				else{
				}
		}
		if($id2)
	 {
		  $this->db->where('as_sales_transactions.trxDate >=', $id2);
	 }
	 
	 if($id3)
	 {
		  $this->db->where('as_sales_transactions.trxDate <= ', $id3);
	 }
		$this->db->order_by('as_sales_transactions.trxID', 'desc');
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
	
	
	function get_data()
	{
		$this->db->select('as_sales_transactions.*');
		$this->db->select('jurnal.no as no_jurnal');
		$this->db->select('login.*');
		$this->db->select('as_members.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_sales_transactions');
		$this->db->join('login', 'login.id=as_sales_transactions.userID', 'INNER');
		$this->db->join('as_members', 'as_members.memberID=as_sales_transactions.memberID', 'INNER');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'INNER');
		$this->db->join('jurnal', 'jurnal.invoice_no=as_sales_transactions.invoiceID', 'LEFT');
		if($this->session->userdata('ADMIN')!='1')
		{
		 $this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->order_by('as_sales_transactions.trxID', 'desc');
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
	
	function get_data_pending($id1,$id2,$id3)
	{
		$this->db->select('as_sales_transactions.*');
		$this->db->select('sum(as_pending_pay.amount) as totalbyr');
		$this->db->select('login.*');
		$this->db->select('as_members.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_sales_transactions');
		$this->db->join('login', 'login.id=as_sales_transactions.userID', 'INNER');
		$this->db->join('as_members', 'as_members.memberID=as_sales_transactions.memberID', 'INNER');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'INNER');
		$this->db->join('as_pending_pay', 'as_pending_pay.invoiceID=as_sales_transactions.invoiceID', 'INNER');
		if($this->session->userdata('ADMIN')!='1')
		{
		$this->db->where('as_sales_transactions.identityID', $id1);
		}
		else
		{
			if($id1!=' ')
				{
					$this->db->where('as_sales_transactions.identityID', $id1);
				}
				else{
				}
		}
		if($id2)
	 {
		  $this->db->where('as_sales_transactions.trxDate >=', $id2);
	 }
	 
	 if($id3)
	 {
		  $this->db->where('as_sales_transactions.trxDate <= ', $id3);
	 }
		$this->db->where('as_sales_transactions.is_pending',0);
		$this->db->group_by('as_pending_pay.invoiceID');
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
	
	function get_data_pending_id($id)
	{
		$this->db->select('as_sales_transactions.*');
		$this->db->select('as_tipe_bayar.name as nm_tipe');
		$this->db->select('as_bank.name as nm_bank');
		$this->db->select('as_pending_pay.amount');
		$this->db->select('sum(as_pending_pay.amount) as totalbyr');
		$this->db->select('login.*');
		$this->db->select('as_members.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_sales_transactions');
		$this->db->join('login', 'login.id=as_sales_transactions.userID', 'INNER');
		$this->db->join('as_members', 'as_members.memberID=as_sales_transactions.memberID', 'INNER');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'INNER');
		$this->db->join('as_pending_pay', 'as_pending_pay.invoiceID=as_sales_transactions.invoiceID', 'INNER');
		$this->db->join('as_tipe_bayar', 'as_sales_transactions.trxbankmethod=as_tipe_bayar.id', 'left');
		$this->db->join('as_bank', 'as_sales_transactions.trxbankmember=as_bank.id', 'left');

		if($this->session->userdata('ADMIN')!='1')
		{
		 $this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->where('as_sales_transactions.invoiceID',$id);
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
	
	function get_data_pending_id_detail($id)
	{
		$this->db->select('as_pending_pay.*');
		$this->db->select('as_tipe_bayar.name as nm_tipe');
		$this->db->select('as_bank.name as nm_bank');
		$this->db->from('as_pending_pay');
		$this->db->join('as_sales_transactions', 'as_pending_pay.invoiceID=as_sales_transactions.invoiceID', 'left');
		$this->db->join('as_tipe_bayar', 'as_pending_pay.tipe_bayar=as_tipe_bayar.id', 'left');
		$this->db->join('as_bank', 'as_pending_pay.bank_id=as_bank.id', 'left');
		if($this->session->userdata('ADMIN')!='1')
		{
		 $this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->where('as_sales_transactions.invoiceID',$id);
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
	
	
	
	function get_data_piutang($id1,$id2,$id3)
	{
		$this->db->select('as_receivables.*');
		$this->db->select('as_receivables.status as statuslunas');
		$this->db->select('as_sales_transactions.*');
		//$this->db->select('jurnal_unpost.INSURANCE_NAME, jurnal_unpost.no, jurnal_unpost.CLASS');
		$this->db->from('as_receivables');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=as_receivables.invoiceID', 'left');
		//$this->db->join('jurnal_unpost', 'jurnal_unpost.invoice_no=as_receivables.invoiceID', 'left');
		$this->db->join('as_receivables_payment', 'as_receivables_payment.receivableID=as_receivables.receivableID', 'left');
		$this->db->where('as_sales_transactions.identityID', $id1);
		if($id2)
	 {
		  $this->db->where('as_sales_transactions.trxDate >=', $id2);
	 }
	 
	 if($id3)
	 {
		  $this->db->where('as_sales_transactions.trxDate <= ', $id3);
	 }
		$this->db->order_by('as_sales_transactions.trxID', 'desc');
		$this->db->group_by('as_receivables.receivableID', 'desc');
		$this->db->limit(1000);
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
	
	function get_data_piutang_id($id)
	{
		$this->db->select('as_receivables.*');
		$this->db->select('as_receivables.status as status_piutang');
		$this->db->select('sum(as_receivables_payment.receivablePay) as totalbyr');
		$this->db->select('as_receivables.status as statuslunas');
		$this->db->select('as_sales_transactions.*');
		$this->db->select('login.nama_depan');
		$this->db->from('as_receivables');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=as_receivables.invoiceID', 'left');
		$this->db->join('login', 'login.id=as_sales_transactions.userID', 'INNER');
		$this->db->join('as_receivables_payment', 'as_receivables_payment.receivableID=as_receivables.receivableID', 'left');
		if($this->session->userdata('ADMIN')!='1')
		{
		 $this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->where('as_receivables.invoiceID',$id);
		$this->db->order_by('as_sales_transactions.trxID', 'desc');
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
	
	function get_data_piutang_id_detail($id)
	{
		$this->db->select('as_receivables_payment.*');
		$this->db->select('as_tipe_bayar.name as nm_tipe');
		$this->db->select('as_bank.name as nm_bank');
		$this->db->from('as_receivables_payment');
		$this->db->join('as_receivables', 'as_receivables_payment.receivableID=as_receivables.receivableID', 'left');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=as_receivables.invoiceID', 'left');
		$this->db->join('as_tipe_bayar', 'as_receivables_payment.payMethod=as_tipe_bayar.id', 'left');
		$this->db->join('as_bank', 'as_receivables_payment.bankcus=as_bank.id', 'left');
		if($this->session->userdata('ADMIN')!='1')
		{
		 $this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->where('as_receivables_payment.receivableID',$id);
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
	
	function get_bank()
	{
		$this->db->select('*');
		$this->db->from('as_bank');
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
	
	function get_bank_own()
	{
		$this->db->select('*');
		$this->db->from('as_bank');
		$this->db->where('is_own',1);
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
	
	function get_jenis_byr()
	{
		$this->db->select('*');
		$this->db->from('as_tipe_bayar');
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
	
	function get_data_id($id)
	{
		$this->db->select('as_sales_transactions.*');
		$this->db->select('login.*');
		$this->db->select('as_members.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_sales_transactions');
		$this->db->join('login', 'login.id=as_sales_transactions.userID', 'INNER');
		$this->db->join('as_members', 'as_members.memberID=as_sales_transactions.memberID', 'INNER');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'INNER');
		$this->db->where('as_sales_transactions.trxID',$id);
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
		$this->db->select('MONTH(jurnal.tgl) AS month, YEAR(jurnal.tgl) AS year, kelompok_akun.id AS kelompok_akun, jurnal_detail.debit_kredit, SUM(jurnal_detail.nilai) AS nilai');
		$this->db->from('jurnal');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id AND jurnal.f_id != 3', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id = kelompok_akun.id', 'INNER');
		$this->db->where_in('kelompok_akun.id', array( 4, 5 ) );
		$this->db->where('extract(year_month from jurnal.tgl) > extract(year_month from (date_sub(curdate(), interval 1 year)))');		
		$this->db->group_by(array('MONTH(jurnal.tgl)', 'YEAR(jurnal.tgl)', 'kelompok_akun.id', 'jurnal_detail.debit_kredit'));
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
			'no' => $this->input->post('nomor'),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		if($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
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
					'nilai' => $value
					);
			}
		}
	}
	
	function get_data_lokasi()
	{
		$this->db->select('*');
		$this->db->from('as_identity');
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
	
	//select table
	public function getSelectedData($table,$data)
	{
		return $this->db->get_where($table, $data);
	}
	
	//update table
	function updateData($table,$data,$field_key)
	{
		$this->db->update($table,$data,$field_key);
	}
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	
	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}
	
public function delete_data_trx($id)
	{
		return $this->db->delete('as_sales_transactions', array('invoiceID' => $id));
	}

	public function get_data_piutang_member($id1,$id2,$id3)
	{
		$this->db->select('as_receivables.*');
		$this->db->select('as_receivables.status as statuslunas');
		$this->db->select('as_sales_transactions.*');
		//$this->db->select('jurnal_unpost.INSURANCE_NAME, jurnal_unpost.no, jurnal_unpost.CLASS');
		$this->db->from('as_receivables');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=as_receivables.invoiceID', 'left');
		//$this->db->join('jurnal_unpost', 'jurnal_unpost.invoice_no=as_receivables.invoiceID', 'left');
		$this->db->join('as_receivables_payment', 'as_receivables_payment.receivableID=as_receivables.receivableID', 'left');
		$this->db->where('as_sales_transactions.memberID', $id1);
		if($id2)
		{
			$this->db->where('as_sales_transactions.trxDate >=', $id2);
		}
	 
		if($id3)
		{
			$this->db->where('as_sales_transactions.trxDate <= ', $id3);
		}
		$this->db->order_by('as_sales_transactions.trxID', 'desc');
		$this->db->group_by('as_receivables.receivableID', 'desc');
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
}
/* End of file jurnal_model.php */
/* Location: ./application/models/jurnal_model.php */
