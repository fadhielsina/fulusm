<?php

class Purchasing_model extends CI_Model
{

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
		if ($year !== '0') {
			$unit = 'YEAR';
			$val = $year;
		}
		if ($month !== '0') {
			$unit = ($unit) ? $unit . '_MONTH' : 'MONTH';
			$val .= $month;
		}
		if ($unit) $this->db->where("EXTRACT($unit FROM trxDate) $sign", $val);
	}

	function tampil_member_json()
	{
		$this->datatables->select('*');
		$this->datatables->select('as_members.memberID');
		$this->datatables->select('as_members.memberCode');
		$this->datatables->select('as_members.memberFullName');
		$this->datatables->select('as_members.memberAddress');
		$this->datatables->select('as_members.memberPhone');
		$this->datatables->from('as_members');
		$this->datatables->add_column('view', '<a class="btn btn-xs btn-info btn-flat" href="' . base_url() . 'admin/edit_member/$1"><i class="fa fa-edit"></i></a> <a class="btn btn-xs btn-success btn-flat" href="' . base_url() . 'admin/detail_member/$1"><i class="fa fa-search"></i></a> <a class="btn btn-xs btn-danger btn-flat" href="' . base_url() . 'admin/hapus_member/$1"><i class="fa fa-trash"></i> </a>', 'memberID');
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
		if ($kelompok_akun_id) $this->db->where('akun.kelompok_akun_id', $kelompok_akun_id);
		if ($proyek_id) {
			$this->db->where('jurnal.proyek_id', $proyek_id);
		} else {
			$this->db->where('jurnal.proyek_id != ', 'NULL');
		}
	}

	function get_data_invoice($id1, $id2, $id3)
	{
		$this->db->select('as_buy_transactions .*');
		$this->db->select('jurnal.no as no_jurnal');
		$this->db->select('login.*');
		$this->db->select('as_suppliers.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_buy_transactions');
		$this->db->join('login', 'login.id=as_buy_transactions.userID', 'LEFT');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID=as_buy_transactions.supplierID', 'LEFT');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'LEFT');
		$this->db->join('jurnal', 'jurnal.invoice_no=as_buy_transactions.invoiceBuyID', 'LEFT');
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('as_buy_transactions.identityID', $id1);
		} else {
			if ($id1 != ' ') {
				$this->db->where('as_buy_transactions.identityID', $id1);
			} else {
			}
		}
		if ($id2) {
			$this->db->where('as_buy_transactions.trxDate >=', $id2);
		}

		if ($id3) {
			$this->db->where('as_buy_transactions.trxDate <= ', $id3);
		}
		$this->db->order_by('as_buy_transactions.trxID', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_po_byno($id)
	{
		$this->db->select('login.*');
		$this->db->select('as_buy_transactions.*');
		$this->db->select('as_suppliers.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_buy_transactions');
		$this->db->join('login', 'login.id=as_buy_transactions.userID', 'LEFT');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID=as_buy_transactions.supplierID', 'LEFT');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'LEFT');
		$this->db->where('as_buy_transactions.invoiceBuyID', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
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
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->order_by('as_sales_transactions.trxID', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_data_debt($id1, $id2, $id3, $paid = "")
	{
		$this->db->select('as_debts.*');
		$this->db->select('as_order_transactions.*');
		$this->db->select('as_order_transactions.identityID as idenID');
		$this->db->select('as_suppliers.*');
		$this->db->select('as_debts.debtID as iddebt');
		$this->db->select('as_debts_payment.*');
		$this->db->select('sum(as_debts_payment.debtPay) as totalbyr');
		$this->db->select('sum(DISTINCT(as_order_transactions.trxTotal)) as totaltrx');
		$this->db->select('as_order_transactions.*');
		$this->db->from('as_debts');
		$this->db->join('as_order_transactions', 'as_debts.invoiceID=as_order_transactions.invoiceOrderID', 'left');
		$this->db->join('as_debts_payment', 'as_debts_payment.debtID=as_debts.debtID', 'left');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID = `as_order_transactions`.`supplierID`', 'left');
		$this->db->where('as_order_transactions.identityID', $id1);
		$this->db->group_by('as_order_transactions.supplierID', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	function get_data_debt_aset($id1)
	{
		$this->db->select('as_debts.*');
		$this->db->select('as_buy_transactions.*');
		$this->db->select('as_buy_transactions.identityID as idenID');
		$this->db->select('as_suppliers.*');
		$this->db->select('as_debts.debtID as iddebt');
		$this->db->select('as_debts_payment.*');
		$this->db->select('sum(as_debts_payment.debtPay) as totalbyr');
		$this->db->select('sum(DISTINCT(as_buy_transactions.trxTotal)) as totaltrx');
		$this->db->select('as_buy_transactions.*');
		$this->db->from('as_debts');
		$this->db->join('as_buy_transactions', 'as_debts.invoiceID=as_buy_transactions.invoiceBuyID', 'left');
		$this->db->join('as_debts_payment', 'as_debts_payment.debtID=as_debts.debtID', 'left');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID = `as_buy_transactions`.`supplierID`', 'left');
		$this->db->where('as_buy_transactions.identityID', $id1);
		$this->db->group_by('as_buy_transactions.supplierID', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	function simpan_data_term_pay($debtID, $dibayar, $payno)
	{
		$datepay = date('Y-m-d h:i:s');
		$hasil = $this->db->query("INSERT INTO as_debts_payment (debtID,debtPay,debtDate,debtInv)VALUES('$debtID','$dibayar','$datepay','$payno')");
		return $hasil;
	}

	function get_data_debt_pay_list($id)
	{
		$this->db->select('as_debts_payment.*');
		$this->db->select('as_tipe_bayar.name as nm_tipe');
		$this->db->select('as_bank.name as nm_bank');
		$this->db->from('as_debts_payment');
		$this->db->join('as_debts', 'as_debts_payment.debtID=as_debts.debtID', 'left');
		$this->db->join('as_buy_transactions', 'as_buy_transactions.invoiceBuyID=as_debts.invoiceID', 'left');
		$this->db->join('as_tipe_bayar', 'as_debts_payment.payMethod=as_tipe_bayar.id', 'left');
		$this->db->join('as_bank', 'as_debts_payment.bank=as_bank.id', 'left');
		$this->db->where('as_buy_transactions.trxID', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_data_debt_by_id($id)
	{
		$this->db->select('as_debts.debtID as iddebt');
		$this->db->select('as_debts.*');
		$this->db->select('as_debts_payment.*');
		$this->db->select('sum(as_debts_payment.debtPay) as totalbyr');
		$this->db->select('as_buy_transactions.*');
		$this->db->select('login.*');
		$this->db->select('as_tipe_bayar.name as met_bayar');
		$this->db->from('as_debts');
		$this->db->join('as_buy_transactions', 'as_buy_transactions.invoiceBuyID=as_debts.invoiceID', 'left');
		$this->db->join('as_debts_payment', 'as_debts_payment.debtID=as_debts.debtID', 'left');
		$this->db->join('as_tipe_bayar', 'as_tipe_bayar.id=as_debts_payment.payMethod', 'left');
		$this->db->join('login', 'login.id=as_buy_transactions.userID', 'left');
		$this->db->where('as_buy_transactions.trxID', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}



	function get_data_debt_pay($id)
	{
		$this->db->select('as_debts.debtID as iddebt');
		$this->db->select('as_debts.*');
		$this->db->select('as_debts_payment.*');
		$this->db->select('as_tipe_bayar.name as met_bayar');
		$this->db->from('as_debts_payment');
		$this->db->join('as_debts', 'as_debts_payment.debtID=as_debts.debtID', 'left');
		$this->db->join('as_tipe_bayar', 'as_tipe_bayar.id=as_debts_payment.payMethod', 'left');
		$this->db->where('as_debts_payment.debtID', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
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
		$this->db->select('login.*');
		$this->db->from('as_receivables');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=as_receivables.invoiceID', 'left');
		$this->db->join('login', 'login.id=as_sales_transactions.userID', 'INNER');
		$this->db->join('as_receivables_payment', 'as_receivables_payment.receivableID=as_receivables.receivableID', 'left');
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->where('as_receivables.invoiceID', $id);
		$this->db->order_by('as_sales_transactions.trxID', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
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
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->where('as_receivables_payment.receivableID', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_bank()
	{
		$this->db->select('*');
		$this->db->from('as_bank');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_bank_own()
	{
		$this->db->select('*');
		$this->db->from('as_bank');
		$this->db->where('is_own', 1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_jenis_byr()
	{
		$this->db->select('*');
		$this->db->from('as_tipe_bayar');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_data_id($id)
	{
		$this->db->select('as_buy_transactions .*');
		$this->db->select('as_buy_transactions .supplierID as id_vendor');
		$this->db->select('jurnal.no as no_jurnal');
		$this->db->select('login.*');
		$this->db->select('as_suppliers.*');
		$this->db->select('as_identity.identityName');
		$this->db->from('as_buy_transactions');
		$this->db->join('login', 'login.id=as_buy_transactions.userID', 'LEFT');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID=as_buy_transactions.supplierID', 'LEFT');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'LEFT');
		$this->db->join('jurnal', 'jurnal.invoice_no=as_buy_transactions.invoiceBuyID', 'LEFT');
		$this->db->where('as_buy_transactions.trxID', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
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
		$this->db->where_in('kelompok_akun.id', array(4, 5));
		$this->db->where('extract(year_month from jurnal.tgl) > extract(year_month from (date_sub(curdate(), interval 1 year)))');
		$this->db->group_by(array('MONTH(jurnal.tgl)', 'YEAR(jurnal.tgl)', 'kelompok_akun.id', 'jurnal_detail.debit_kredit'));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$result[$row->month][$row->year][$row->kelompok_akun][$row->debit_kredit] = $row->nilai;
			}
			return $result;
		} else {
			return FALSE;
		}
	}


	function get_all_data()
	{
		$this->db->select('akun.id, akun.nama, akun.kode, akun.saldo_awal, akun.saldo, akun.kelompok_akun_id, kelompok_akun.nama AS groups_name');
		$this->db->from('akun');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id=kelompok_akun.id', 'INNER');
		$this->db->where('akun.id in(1,15,16,17,21,22,23,24,27,43,59,60,61,62,63,64,68,69,71,87,88,89,90)');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	function get_data_for_dropdown()
	{
		$data = $this->get_all_data();
		if ($data) {
			foreach ($data as $row) {
				$akun[$row->id] = $row->nama . ' - ' . $row->kode;
			}
			return $akun;
		} else {
			return FALSE;
		}
	}

	function fill_data_pay()
	{
		$this->data = array(
			'no' => $this->GenJurPo(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('nomorinvoice'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++) {
			$debit = $this->input->post('debit' . $i);
			$kredit = $this->input->post('kredit' . $i);
			if (($debit != '') || ($kredit != '')) {
				if ($debit != '') {
					$dk = 1;
					$value = $debit;
				} else {
					$dk = 0;
					$value = $kredit;
				}
				$this->details[$i] = array(
					'item' => $i,
					'akun_id' => $akun[$i - 1],
					'debit_kredit' => $dk,
					'nilai' => $value
				);
			}
		}
	}

	function check_no_pay()
	{
		$this->db->where('no', $this->data['no']);
		$query = $this->db->get('jurnal');

		if ($query->num_rows() > 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function insert_data_pay()
	{
		$this->db->trans_start();
		$this->db->insert('jurnal', $this->data);
		$jurnal_id = $this->db->insert_id();
		for ($i = 1; $i <= count($this->details); $i++) {
			$this->details[$i]['jurnal_id'] = $jurnal_id;
			$this->db->insert('jurnal_detail', $this->details[$i]);
			$op = ($this->details[$i]['debit_kredit']) ? '+' : '-';
			$this->db->query('UPDATE akun SET saldo = saldo' . $op . $this->details[$i]['nilai'] . ' WHERE id = ' . $this->details[$i]['akun_id']);
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function get_data_lokasi()
	{
		$this->db->select('*');
		$this->db->from('as_identity');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//Check for duplicate no
	function check_no()
	{
		$this->db->where('no', $this->data['no']);
		$query = $this->db->get('jurnal');

		if ($query->num_rows() > 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function insert_data()
	{
		$this->db->trans_start();
		$this->db->insert('jurnal', $this->data);
		$jurnal_id = $this->db->insert_id();
		for ($i = 1; $i <= count($this->details); $i++) {
			$this->details[$i]['jurnal_id'] = $jurnal_id;
			$this->db->insert('jurnal_detail', $this->details[$i]);
			$op = ($this->details[$i]['debit_kredit']) ? '+' : '-';
			$this->db->query('UPDATE akun SET saldo = saldo' . $op . $this->details[$i]['nilai'] . ' WHERE id = ' . $this->details[$i]['akun_id']);
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	//select table
	public function getSelectedData($table, $data)
	{
		return $this->db->get_where($table, $data);
	}

	//update table
	function updateData($table, $data, $field_key)
	{
		$this->db->update($table, $data, $field_key);
	}
	function deleteData($table, $data)
	{
		$this->db->delete($table, $data);
	}

	function insertData($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function delete_debt_detail($id)
	{
		$this->db->where('debtID', $id);
		$delete = $this->db->delete('as_debts_payment');
		return $delete;
	}

	function delete_debt($id)
	{
		$this->db->where('invoiceID', $id);
		$delete = $this->db->delete('as_debts');
		return $delete;
	}

	function GenJurPo()
	{

		$trxid = mysql_fetch_array(mysql_query('SELECT * from jurnal order by id desc limit 1;'));
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$l_jurno = strlen($produksiID);
		if ($l_jurno == 14) {
			$produksiIDfil = substr($produksiID, 10, 4);
		} else if ($l_jurno == 15) {
			$produksiIDfil = substr($produksiID, 10, 5);
		} else if ($l_jurno == 16) {
			$produksiIDfil = substr($produksiID, 10, 6);
		}

		if ($produksiIDfil == "") {
			$trxDate = date('my');
			$trx = 1;

			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
		} else {
			$trxDate = date('my');
			$invno_1 = $produksiIDfil + 1;

			$invno_last = $trxDate . $invno_1;

			if ($l_jurno == 14) {
				$invno_cek = sprintf("%04d", $invno_1);
				$trxidtmp = mysql_fetch_array(mysql_query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 4)=' . $invno_cek . ';'));
			} else if ($l_jurno == 15) {
				$invno_cek = sprintf("%05d", $invno_1);
				$trxidtmp = mysql_fetch_array(mysql_query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 5)=' . $invno_cek . ';'));
			} else if ($l_jurno == 16) {
				$invno_cek = sprintf("%06d", $invno_1);
				$trxidtmp = mysql_fetch_array(mysql_query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 6)=' . $invno_cek . ';'));
			}



			if ($trxidtmp) {
				$trxid2 = mysql_fetch_array(mysql_query('SELECT no,CONVERT(SUBSTRING(no,11),UNSIGNED INTEGER) AS num from jurnal_temp order by num desc limit 1;'));
				$produksiID2 = $trxid2['no'];
				$l_jurno2 = strlen($produksiID2);
				if ($l_jurno2 == 14) {
					$produksiIDfil2 = substr($produksiID2, 10, 4);
				} else if ($l_jurno2 == 15) {
					$produksiIDfil2 = substr($produksiID2, 10, 5);
				} else if ($l_jurno2 == 16) {
					$produksiIDfil2 = substr($produksiID2, 10, 6);
				}
				$produksiIDfil3 = ltrim($produksiIDfil2, '0');
				$invnoc = $produksiIDfil3 + 1;
				$l_jurno3 = strlen($produksiID2);
				if ($l_jurno3 == 14) {
					$invoice2 = sprintf("%04d", $invnoc);
				} else if ($l_jurno3 == 15) {
					$invoice2 = sprintf("%05d", $invnoc);
				} else if ($l_jurno3 == 16) {
					$invoice2 = sprintf("%06d", $invnoc);
				}

				$invno = $trxDate . $invoice2;
			} else {

				if ($l_jurno == 14) {
					$invno_cek = sprintf("%04d", $invno_1);
				} else if ($l_jurno == 15) {
					$invno_cek = sprintf("%05d", $invno_1);
				} else if ($l_jurno == 16) {
					$invno_cek = sprintf("%06d", $invno_1);
				}
				$invno_last = $trxDate . $invno_cek;
				$invno = $invno_last;
			}
		}

		$kode = "JPO" . date('d') . "-" . $invno;
		return $kode;
	}

	public function delete_data_trx($id)
	{
		return $this->db->delete('as_buy_transactions', array('trxID' => $id));
	}

	function get_data_hutang($id = '', $tgl, $status)
	{
		$idPro = $this->input->post('projectId');
		if ($tgl == null) {
			$tgl = date('Y-');
		}
		if ($id != '') {
			return $this->db->query("SELECT a.*, b.user_id, b.full_name, b.bank_number, c.nama_project
									FROM fintekma_backend.trx_pendanaan a
									JOIN fintekma_prod.pendana b ON b.id = a.id_pendana 
									JOIN fintekma_backend.trx_project c ON c.id_project = a.id_project
									WHERE a.id = $id")->row();
		} else {
			if ($idPro) {
				return $this->db->query("SELECT a.*, b.user_id, b.full_name, b.bank_number, c.nama_project
				FROM fintekma_backend.trx_pendanaan a
				JOIN fintekma_prod.pendana b ON b.id = a.id_pendana
				JOIN fintekma_backend.trx_project c ON c.id_project = a.id_project
				WHERE a.status = $status
				AND a.id_project = $idPro ")->result();
			} else {
				// return $this->db->query("SELECT fintekma_backend.trx_pendanaan.*, fintekma_prod.pendana.user_id, fintekma_prod.pendana.full_name, fintekma_prod.pendana.bank_number
				// FROM fintekma_backend.trx_pendanaan
				// JOIN fintekma_prod.pendana
				// ON fintekma_prod.pendana.id = fintekma_backend.trx_pendanaan.id_pendana
				// WHERE trx_pendanaan.status = $status
				// AND trx_pendanaan.create_ts LIKE '$tgl%' ")->result();
			}
		}
	}

	function get_dibayar($id)
	{
		$this->db->select("(SELECT SUM(trx_hutang_payment.nominal) 
		FROM trx_hutang_payment 
		WHERE trx_hutang_payment.trx_id=$id) AS nominal", FALSE);
		$query = $this->db->get('trx_hutang_payment');
		return $query->row();
	}
}
/* End of file jurnal_model.php */
/* Location: ./application/models/jurnal_model.php */
