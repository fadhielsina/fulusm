<?php

class Jurnal_model extends CI_Model
{

	var $data;
	var $details;

	public $identity_id;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->identity_id = $this->session->userdata('IDENTITY_ID');
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
		if ($unit) $this->db->where("EXTRACT($unit FROM tgl) $sign", $val);
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

	function get_data()
	{
		$this->db->select('jurnal.id, jurnal.tgl, jurnal.no,invoice_no, jurnal.keterangan, jurnal.f_id AS f_id, f.nama AS f_name, jurnal.proyek_id, jurnal_detail.item, jurnal_detail.akun_id, akun.nama as account_name, akun.kelompok_akun_id, akun.kode, jurnal_detail.debit_kredit, jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		//$this->db->join('as_sales_transactions', 'jurnal.invoice_no=as_sales_transactions.invoiceID', 'LEFT');
		//$this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		$this->db->where('jurnal.identityID', $this->session->userdata('IDENTITY_ID') );
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	
	function get_data_piutang($id)
	{
		$this->db->select('jurnal.id, jurnal.tgl, jurnal.keterangan as ket_jur, jurnal.no,invoice_no, jurnal.keterangan, jurnal.f_id AS f_id, f.nama AS f_name, jurnal.proyek_id,as_sales_transactions.invoiceID,as_sales_transactions.note, jurnal_detail.item, jurnal_detail.akun_id, akun.nama as account_name, akun.*, jurnal_detail.debit_kredit, jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		$this->db->join('as_sales_transactions', 'jurnal.invoice_no=as_sales_transactions.invoiceID', 'LEFT');
		$this->db->where('akun.kelompok_akun_id',1 );
		$this->db->where('jurnal.sc_id',$id );
		$this->db->where('jurnal.identityID', $this->session->userdata('IDENTITY_ID'));
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	
	function get_data_utang($id)
	{
		$this->db->select('jurnal.id, jurnal.tgl, jurnal.keterangan as ket_jur, jurnal.no,invoice_no, jurnal.keterangan, jurnal.f_id AS f_id, f.nama AS f_name, jurnal.proyek_id,as_order_transactions.invoiceOrderID,as_order_transactions.note, jurnal_detail.item, jurnal_detail.akun_id, akun.nama as account_name, akun.*, jurnal_detail.debit_kredit, jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'LEFT');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'LEFT');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'LEFT');
		$this->db->join('as_order_transactions', 'jurnal.invoice_no=as_order_transactions.invoiceOrderID', 'LEFT');
		$this->db->where('akun.kelompok_akun_id',2 );
		$this->db->where('jurnal.sc_id',$id );
		$this->db->where('jurnal.identityID', $this->session->userdata('IDENTITY_ID'));
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	
	function get_data_akun()
	{
		$this->db->select('jurnal.id, 
				jurnal.tgl, jurnal.no, 
				jurnal.keterangan, 
				jurnal.f_id AS f_id, 
				f.nama AS f_name, 
				jurnal.proyek_id,
				as_sales_transactions.invoiceID, 
				jurnal_detail.item, 
				jurnal_detail.akun_id, 
				akun.nama as account_name, 
				akun.kelompok_akun_id, 
				`akun`.saldo_awal,
				jurnal_detail.debit_kredit, 
				jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		$this->db->join('as_sales_transactions', 'jurnal.invoice_no=as_sales_transactions.invoiceID', 'LEFT');
		if ($this->session->userdata('ADMIN') != '1') {
			// $this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->group_by('akun.id');
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	function get_data_rekap()
	{
		$this->db->select('jurnal.id, 
				jurnal.tgl, 
				jurnal.no, 
				jurnal.keterangan, 
				jurnal.f_id AS f_id, 
				f.nama AS f_name
				');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');;
		if ($this->session->userdata('ADMIN') != '1') {
			//$this->db->where('as_sales_transactions.identityID', $this->session->userdata('IDENTITY_ID'));
		}
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	function get_data_id($id)
	{
		$this->db->select('jurnal.id,jurnal.id jrnl_id, jurnal.tgl, jurnal.no, jurnal.invoice_no, jurnal.keterangan, jurnal.f_id AS f_id, f.nama AS f_name, jurnal.proyek_id, proyek.nama as project_name, jurnal_detail.item, jurnal_detail.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_detail.debit_kredit, jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal.proyek_id=proyek.id', 'LEFT');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=jurnal.invoice_no', 'LEFT');
		$this->db->where('jurnal.invoice_no', $id);
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	function get_data_jur_kas($id)
	{
		$this->db->select('jurnal.id,jurnal.id jrnl_id, jurnal.tgl, jurnal.no, jurnal.invoice_no, jurnal.keterangan, jurnal.f_id AS f_id, f.nama AS f_name, jurnal_detail.item, jurnal_detail.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_detail.debit_kredit, jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		$this->db->join('tbl_trans_kas', 'tbl_trans_kas.no_trx_kas=jurnal.invoice_no', 'LEFT');
		$this->db->where('tbl_trans_kas.no_trx_kas', $id);
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_data_id_debit($id)
	{
		$this->db->select('jurnal.id, jurnal.tgl, jurnal.no, jurnal.invoice_no, jurnal.keterangan, jurnal.f_id AS f_id, f.nama AS f_name, jurnal.proyek_id, proyek.nama as project_name, jurnal_detail.item, jurnal_detail.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_detail.debit_kredit, jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal.proyek_id=proyek.id', 'LEFT');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=jurnal.invoice_no', 'LEFT');
		$this->db->where('jurnal.invoice_no', $id);
		$this->db->where('jurnal_detail.debit_kredit', 1);
		$this->db->order_by('jurnal.tgl', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	function get_data_id_kredit($id)
	{
		$this->db->select('jurnal.id, jurnal.tgl, jurnal.no, jurnal.invoice_no, jurnal.keterangan, jurnal.f_id AS f_id, f.nama AS f_name, jurnal.proyek_id, proyek.nama as project_name, jurnal_detail.item, jurnal_detail.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_detail.debit_kredit, jurnal_detail.nilai');
		$this->db->from('jurnal');
		$this->db->join('f', 'jurnal.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal.proyek_id=proyek.id', 'LEFT');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=jurnal.invoice_no', 'LEFT');
		$this->db->where('jurnal.invoice_no', $id);
		$this->db->where('jurnal_detail.debit_kredit', 0);
		$this->db->order_by('jurnal.tgl', 'asc');
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
	
	function fill_data_koreksi()
	{
	
		$identity = $this->session->userdata('IDENTITY_ID');
		$this->data = array(
			'no' =>  $this->GenJkor(),
			'invoice_no' => $this->input->post('invoice'),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => 14,
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s"),
			'identityID' => $identity
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

	function fill_data()
	{
		$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('nomorinvoice'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s"),
			'identityID' => $this->identity_id
		);
		$object  = array(
			'is_publish' => 1
		);
		$this->db->where('invoiceID', $this->data['invoice_no']);
		$this->db->update('as_sales_transactions', $object);
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++) {
			$debit = $this->input->post('debit' . $i);
			$kredit = $this->input->post('kredit' . $i);
			$keterangan = $this->input->post('keterangan' . $i);
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
					'nilai' => $value,
					'keterangan' => $keterangan
				);
			}
		}
	}

	function fill_data_transfer()
	{
		$tipe_trx = $this->input->post('tipe_trx');
		$nojur=$this->jurnal_model->GenJtrfKB();
		if ($tipe_trx == 'add') {
			$no_kas = $this->GenKasNumber($this->input->post('jns'));
			$this->data = array(
				'no' => $nojur,
				'tgl' => $this->input->post('tanggal'),
				'f_id' => 12,
				'invoice_no' => $no_kas,
				'keterangan' => $this->input->post('catatan'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s"),
				'identityID' => $this->identity_id
			);

			$object  = array(
				'no_trx_kas' =>  $no_kas,
				'tgl_catat' => date("Y-m-d"),
				'jumlah' => str_replace(',', '', $this->input->post('jumlah')),
				'keterangan' => $this->input->post('catatan'),
				'akun' => 'Transfer',
				'jns_trans' => $this->input->post('jns'),
				'dari_kas_id' => $this->input->post('akun_dari'),
				'untuk_kas_id' => $this->input->post('akun_untuk'),
				'posting' => 1,
				'identity_id' => $this->input->post('identity_id'),
				'user' => $this->input->post('userid'),
				'no_dok' => $this->input->post('no_dok')
			);
			$this->db->insert('tbl_trans_kas', $object);
		} else if ($tipe_trx == 'edit') {
			$id_trx_kas = $this->input->post('id_trx_kas');
			$this->data = array(
				'no' => $nojur,
				'tgl' => $this->input->post('tanggal'),
				'f_id' => 12,
				'invoice_no' => $id_trx_kas,
				'keterangan' => $this->input->post('deskripsi'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);

			$id_trx = $this->input->post('id_trx');
			$object  = array(
				'update_data' => date("Y-m-d"),
				'jumlah' => str_replace(',', '', $this->input->post('jumlah')),
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
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$this->details[1] = array(
			'item' => 1,
			'akun_id' => $this->input->post('akun_dari'),
			'debit_kredit' => 0,
			'nilai' => str_replace(',', '', $this->input->post('jumlah')),
			'keterangan' => $this->input->post('catatan')
		);
		$this->details[2] = array(
			'item' => 1,
			'akun_id' => $this->input->post('akun_untuk'),
			'debit_kredit' => 1,
			'nilai' => str_replace(',', '', $this->input->post('jumlah')),
			'keterangan' => $this->input->post('catatan')
		);
	}

	function fill_data_kas_in()
	{
		$identity = $this->session->userdata('IDENTITY_ID');
		$jnsjrn=$this->input->post('jnsjrn');
		$bank_akun=$this->input->post('bank_akun');
		if($jnsjrn=="k")
			{
				$nojur=$this->jurnal_model->GenJkasin();
				$fid="7";
			}
			else{
				$nojur=$this->jurnal_model->GenJbankin($bank_akun);
				$fid="11";
			}
			
		$tipe_trx = $this->input->post('tipe_trx');
		$akun = $_POST['akun'];
		$jumlah = $_POST['nilai'];
		$keterangan = $_POST['keterangan'];
		$total = 0;
		$no_kas_ ="";
		$dari = $this->input->post('dari');
		foreach ($jumlah as $row) {
			$total += str_replace(',', '', $row);
		}
		 
		$tipe_trx= $this->input->post('tipe_trx');
			if($tipe_trx=='add'){
				$no_kas= $this->GenKasNumber($this->input->post('jns'));
				$this->data = array(
					'no' => $nojur,
					'tgl' => $this->input->post('tanggal'),
					'f_id' => $fid,
					'invoice_no' => $no_kas,
					'keterangan' => $this->input->post('catatan'),
					'login_id' => $this->session->userdata('SESS_USER_ID'),
					'waktu_post' => date("Y-m-d H:i:s"),
					'identityID' => $identity
				);
				
				$object  = array(    
					'no_trx_kas' =>  $no_kas,
					'tgl_catat' => date("Y-m-d"),
					'jumlah' => $total,
					'keterangan' => $this->input->post('catatan'),
					'jns_trans' => $this->input->post('jns'),
					'untuk_kas_id' => $this->input->post('dari_akun'),
					'dari' => $this->input->post('dari'),
					'dok' => $this->input->post('dokumen'),
					'posting' => 1,
					'no_dok' => $this->input->post('no_dokumen'),
					'identity_id' => $this->input->post('identity_id'),
					'user' => $this->input->post('userid')
				);
				$this->db->insert('tbl_trans_kas', $object);
				$no_kas_ = $this->db->insert_id();
				// Insert to custom trans table
				// 1 = setor, 2 = terima
				$cdata = array(
					'id_trans_kas' => $this->db->insert_id(),
					'user_id' => $this->input->post('userid')
				);

				if ( 'KK' == $this->input->post('jns') ) {
					// jika dari akun bank kalteng maka masuk sbg penerimaan
					if ( 131 == $this->input->post('akun')[0] && ! empty( $this->input->post('kredit1') ) ) {
						$cdata['type'] = 2;
					} else {
						$cdata['type'] = 1;
					}
					$this->db->insert( 'tbl_trans_kas_out', $cdata );
				} else {
					$cdata['type'] = 2;
					$this->db->insert( 'tbl_trans_kas_custom', $cdata );
				}

			}
			else if($tipe_trx=='edit')
			{
				if($jnsjrn=="k")
			{
				$nojur=$this->jurnal_model->GenJkasin();
				$fid="7";
			}
			else{
				$nojur=$this->jurnal_model->GenJbankin($bank_akun);
				$fid="11";
			}

				$id_trx_kas=$this->input->post('id_trx_kas');
				$this->data = array(
					'no' => $nojur,
					'tgl' => $this->input->post('tanggal'),
					'f_id' => $fid,
					'invoice_no' => $id_trx_kas,
					'keterangan' => $this->input->post('deskripsi'),
					'login_id' => $this->session->userdata('SESS_USER_ID'),
					'waktu_post' => date("Y-m-d H:i:s")
				);
				
				$id_trx= $this->input->post('id_trx');
				$object  = array(    
				 'update_data' => date("Y-m-d"),
				 'jumlah' => $total,
				 'keterangan' => $this->input->post('catatan'),
				 'jns_trans' => $this->input->post('jns'),
				 'dari' => $this->input->post('dari'),
				 'dok' => $this->input->post('dokumen'),
				 'posting' => 1,
				 'no_dok' => $this->input->post('no_dokumen'),
				 'no_rek' => $this->input->post('no_rek'),
				 'update_user' => $this->input->post('userid')
				);
		   		$this->db->where('id', $id_trx);
				$this->db->update('tbl_trans_kas', $object);
			}
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$i = 0;
		foreach ($akun as $data) {
			$this->details[$i + 1] = array(
				'item' => $i + 1,
				'akun_id' => $akun[$i],
				'debit_kredit' => 0,
				'nilai' => str_replace(',', '', $jumlah[$i]),
				'keterangan' => $keterangan[$i]
			);
			$i++;
		}
		$this->details[$i + 1] = array(
			'item' => $i + 1,
			'akun_id' => $this->input->post('dari_akun'),
			'debit_kredit' => 1,
			'nilai' => strval($total),
			'keterangan' => $this->input->post('deskripsi')
		);

		$config['upload_path']          = 'uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti_transaksi'))
        { 
            $data =   $this->upload->data();
 			$no_kas_ = ($no_kas_ !="")?$no_kas_:$id_trx_kas;
 			$this->db->where('id', $no_kas_);
			$this->db->update('tbl_trans_kas', array("bukti_transaksi"=>$data['file_name']));

        }else{
        	 
        }
	}

	function fill_data_kas_out()
	{
		$identity = $this->session->userdata('IDENTITY_ID');
		$jnsjrn=$this->input->post('jnsjrn');
		$bank_akun=$this->input->post('bank_akun');
		if($jnsjrn=="k")
			{
				$nojur=$this->jurnal_model->GenJkasout();
				$fid="6";
			}
			else{
				$nojur=$this->jurnal_model->GenJbankout($bank_akun);
				$fid="10";
			}
			
		$tipe_trx = $this->input->post('tipe_trx');
		$akun = $_POST['akun'];
		$jumlah = $_POST['nilai'];
		$keterangan = $_POST['keterangan'];
		$total = 0;
		$no_kas_ ="";
		foreach ($jumlah as $row) {
			$total += str_replace(',', '', $row);
		}
		if ($tipe_trx == 'add') {
			$no_kas = $this->GenKasNumber($this->input->post('jns'));
			$this->data = array(
				'no' => $nojur,
				'tgl' => $this->input->post('tanggal'),
				'f_id' => $fid,
				'invoice_no' => $no_kas,
				'keterangan' => $this->input->post('catatan'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s"),
				'identityID' => $identity
			);

			$object  = array(
				'no_trx_kas' =>  $no_kas,
				'tgl_catat' => date("Y-m-d"),
				'jumlah' => $total,
				'keterangan' => $this->input->post('catatan'),
				'akun' => 'Pengeluaran',
				'dari_kas_id' => $this->input->post('dari_akun'),
				'jns_trans' => $this->input->post('jns'),
				'kepada' => $this->input->post('kepada'),
				'dok' => $this->input->post('dokumen'),
				'posting' => 1,
				'no_dok' => $this->input->post('no_dokumen'),
				'identity_id' => $this->input->post('identity_id'),
				'user' => $this->input->post('userid')
			);
			$this->db->insert('tbl_trans_kas', $object);
			$no_kas_ = $this->db->insert_id();
		} else if ($tipe_trx == 'edit') {
			
			if($jnsjrn=="k")
			{
				$nojur=$this->jurnal_model->GenJkasout();
				$fid="7";
			}
			else{
				$nojur=$this->jurnal_model->GenJbankout($bank_akun);
				$fid="11";
			}
			
			$id_trx_kas = $this->input->post('id_trx_kas');
			$this->data = array(
				'no' => $nojur,
				'tgl' => $this->input->post('tanggal'),
				'f_id' => $fid,
				'invoice_no' => $id_trx_kas,
				'keterangan' => $this->input->post('deskripsi'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);

			$id_trx = $this->input->post('id_trx');
			$object  = array(
				'update_data' => date("Y-m-d"),
				'jumlah' => str_replace(',', '', $this->input->post('jumlah')),
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
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$i = 0;
		foreach ($akun as $data) {
			$this->details[$i + 1] = array(
				'item' => $i + 1,
				'akun_id' => $akun[$i],
				'debit_kredit' => 1,
				'nilai' => str_replace(',', '', $jumlah[$i]),
				'keterangan' => $keterangan[$i]
			);
			$i++;
		}
		$this->details[$i + 1] = array(
			'item' => $i + 1,
			'akun_id' => $this->input->post('dari_akun'),
			'debit_kredit' => 0,
			'nilai' => strval($total),
			'keterangan' => $this->input->post('deskripsi')
		);

		$config['upload_path']          = 'uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti_transaksi'))
        { 
            $data =   $this->upload->data();
 			$no_kas_ = ($no_kas_ !="")?$no_kas_:$id_trx_kas;
 			$this->db->where('id', $no_kas_);
			$this->db->update('tbl_trans_kas', array("bukti_transaksi"=>$data['file_name']));

        }else{
        	 
        }
	}

	function fill_data_kas_insurance()
	{

		$tipe_trx = $this->input->post('tipe_trx');
		if ($tipe_trx == 'add') {
			$no_kas = $this->GenKasNumber($this->input->post('jns'));
			$this->data = array(
				'no' =>  $this->GenJurNumber(),
				'tgl' => $this->input->post('tanggal'),
				'f_id' => $this->input->post('f_id'),
				'invoice_no' => $no_kas,
				'keterangan' => ' Penerimaan dana asuransi dari ' . $this->input->post('dari'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);


			$object  = array(
				'no_trx_kas' =>  $no_kas,
				'tgl_catat' => date("Y-m-d"),
				'jumlah' => str_replace(',', '', $this->input->post('jumlah')),
				'keterangan' => ' Penerimaan dana asuransi dari ' . $this->input->post('dari'),
				'jns_trans' => $this->input->post('jns'),
				'dari' => $this->input->post('dari'),
				'dok' => $this->input->post('dokumen'),
				'posting' => 1,
				'no_dok' => $this->input->post('no_dokumen'),
				'identity_id' => $this->input->post('identity_id'),
				'user' => $this->input->post('userid')
			);
			$this->db->insert('tbl_trans_kas', $object);
		} else if ($tipe_trx == 'edit') {
			$id_trx_kas = $this->input->post('id_trx_kas');
			$this->data = array(
				'no' =>  $this->GenJurNumber(),
				'tgl' => $this->input->post('tanggal'),
				'f_id' => $this->input->post('f_id'),
				'invoice_no' => $id_trx_kas,
				'keterangan' => ' Penerimaan dana asuransi dari ' . $this->input->post('dari'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);

			$id_trx = $this->input->post('id_trx');
			$object  = array(
				'update_data' => date("Y-m-d"),
				'jumlah' => str_replace(',', '', $this->input->post('jumlah')),
				'keterangan' => ' Penerimaan dana asuransi dari ' . $this->input->post('dari'),
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
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++) {
			$debit = $this->input->post('debit' . $i);
			$kredit = $this->input->post('kredit' . $i);
			$keterangan = $this->input->post('keterangan' . $i);
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
					'nilai' => $value,
					'keterangan' => $keterangan
				);
			}
		}
	}


	function fill_data_pembelian()
	{

		$tipe_trx = $this->input->post('tipe_trx');
	


		if ($tipe_trx == 'add') {
			$this->data = array(
				'no' =>  $this->GenJurNumber(),
				'tgl' => $this->input->post('tanggal'),
				'f_id' => $this->input->post('f_id'),
				'invoice_no' => $this->input->post('invoiceIDmanual'),
				'keterangan' => $this->input->post('deskripsi'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);

			$status_trx = $this->input->post('trxStatus');
			if ($status_trx == '2') {
				$pay = "0";
			} else {
				$pay = "1";
			}
			$object  = array(
				'invoiceBuyID' => $this->input->post('invoiceIDmanual'),
				'trxFullName' => $this->input->post('trxFullName'),
				'trxAddress' => $this->input->post('trxAddress'),
				'trxPhone' => $this->input->post('trxPhone'),
				'supplierID' => $this->input->post('memberCode'),
				'trxDate' => $this->input->post('trxDate'),
				'note' => $this->input->post('note'),
				'trxTotal' => str_replace(',', '', $this->input->post('trxTotal')),
				'userID' => $this->session->userdata('SESS_USER_ID'),
				'identityID' => $this->session->userdata('IDENTITY_ID'),
				'trxStatus' => $this->input->post('trxStatus'),
				'trxTerminDate' => $this->input->post('trxTerminDate'),
				'trxbankmethod' => $this->input->post('jns_bayar'),
				'trxAdmin' => str_replace(',', '', $this->input->post('b_admin')),
				'posting' => 1,
				'is_pay' => $pay,
				'createdDate' => date("Y-m-d H:i:s")
			);
			$this->db->insert('as_buy_transactions', $object);

			if ($status_trx == '2') {
				$object  = array(
					'invoiceID' => $this->input->post('invoiceIDmanual'),
					'status' => 1,
					'createdDate' => date("Y-m-d H:i:s")
				);
				$this->db->insert('as_debts', $object);
			}
		} else if ($tipe_trx == 'edit') {
			$this->data = array(
				'no' =>  $this->GenJurNumber(),
				'tgl' => $this->input->post('tanggal'),
				'f_id' => $this->input->post('f_id'),
				'invoice_no' => $this->input->post('invoiceIDmanual'),
				'keterangan' => $this->input->post('deskripsi'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);

			$id_trx = $this->input->post('id_trx');
			$status_trx = $this->input->post('trxStatus');
			if ($status_trx == '2') {
				$pay = "0";
			} else {
				$pay = "1";
			}
			$object  = array(
				'trxFullName' => $this->input->post('trxFullName'),
				'trxAddress' => $this->input->post('trxAddress'),
				'trxPhone' => $this->input->post('trxPhone'),
				'supplierID' => $this->input->post('memberCode'),
				'trxDate' => $this->input->post('trxDate'),
				'note' => $this->input->post('note'),
				'trxTotal' => str_replace(',', '', $this->input->post('trxTotal')),
				'modifiedUserID' => $this->session->userdata('SESS_USER_ID'),
				'identityID' => $this->session->userdata('IDENTITY_ID'),
				'trxStatus' => $this->input->post('trxStatus'),
				'trxTerminDate' => $this->input->post('trxTerminDate'),
				'trxbankmethod' => $this->input->post('jns_bayar'),
				'trxAdmin' => str_replace(',', '', $this->input->post('b_admin')),
				'posting' => 1,
				'is_pay' => $pay,
				'is_update' => 1,
				'modifiedDate' => date("Y-m-d H:i:s")
			);
			$this->db->where('trxID', $id_trx);
			$this->db->update('as_buy_transactions', $object);
		}
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++) {
			$debit = $this->input->post('debit' . $i);
			$kredit = $this->input->post('kredit' . $i);
			$keterangan = $this->input->post('keterangan' . $i);
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
					'nilai' => $value,
					'keterangan' => $keterangan
				);
			}
		}
	}




	function fill_data_pembelian_pay()
	{

		$trxStatus = $this->input->post('trxStatus');


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
			'debtPay' => str_replace(',', '', $this->input->post('trxTotalbyr')),
			'b_admin' => str_replace(',', '', $this->input->post('b_admin')),
			'createdUserID' => $this->session->userdata('SESS_USER_ID'),
			'payMethod' => $this->input->post('jns_bayar'),
			'bank' => $this->input->post('bank'),
			'bank_v' => $this->input->post('bankven')
		);
		$this->db->insert('as_debts_payment', $object);

		if ($trxStatus == '2') {
			$object  = array(

				'is_pay' => 1
			);
			$this->db->where('invoiceBuyID', $this->input->post('nomorinvoice'));
			$this->db->update('as_buy_transactions', $object);
		}


		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++) {
			$debit = $this->input->post('debit' . $i);
			$kredit = $this->input->post('kredit' . $i);
			$keterangan = $this->input->post('keterangan' . $i);
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
					'nilai' => $value,
					'keterangan' => $keterangan
				);
			}
		}
	}

	function fill_data_SPM()
	{
		$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tgl_spm'),
			'f_id' => 1,
			'invoice_no' => $this->input->post('no_spm'),
			'keterangan' => $this->input->post('uraianSpp'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$object  = array(
			'status' => 1
		);
		$this->db->where('invoiceID', $this->data['invoice_no']);
		$this->db->update('as_debts', $object);
		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');
		$akun_debit = $this->input->post('akun_spm_debit');
		$akun_kredit = $this->input->post('akun_spm_kredit');
		$jumlah_bayar  = str_replace(",", "", $this->input->post('jumlah_dibayarkan'));
		$this->details[1] = array(
			'item' => 1,
			'akun_id' => $akun_debit,
			'debit_kredit' => 1,
			'nilai' => (float) $jumlah_bayar,
			'keterangan' => $this->input->post('uraianSpp'),
		);
		$this->details[2] = array(
			'item' => 1,
			'akun_id' => $akun_kredit,
			'debit_kredit' => 0,
			'nilai' => (float) $jumlah_bayar,
			'keterangan' => $this->input->post('uraianSpp'),
		);
	}
	function fill_data_bayar_hutang()
	{
		$keterangan = "pembayaran hutang ke vendor dengan invoice : ".$this->input->post('invoiceBuyID');
		$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => 1,
			'invoice_no' => $this->input->post('invoiceBuyID'),
			'keterangan' => $keterangan,
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$object  = array(
			'is_pay' => $this->input->post('is_pay')
		);
		$dataWhere = array(
        		"supplierID"=>$this->input->post('supplierID'),
        		"invoiceBuyID"=>$this->input->post('invoiceBuyID')
        	);
		$this->db->where($dataWhere);
		$this->db->update('as_buy_transactions', $object);

		//input payment debt
		$objectDebt  = array( 
			'invoiceID'=>$this->input->post('invoiceBuyID'),
			'status'=>$this->input->post('is_pay'),
			'modifiedDate'=>date("y-m-d"),
			'modifiedUserID'=>$this->session->userdata('SESS_USER_ID'),
		);
		$idDebt = "";
		$cekExist = $this->db->select('*')->from('as_debts')->where('invoiceID',$this->input->post('invoiceBuyID'))->get()->row_array(); 
		if(count($cekExist) >0){
			$this->db->update('as_debts', $objectDebt,array('invoiceID'=>$this->input->post('invoiceBuyID')));
			$idDebt = $cekExist['debtID'];
		}else{
			$DataInsert = $this->db->insert('as_debts', $objectDebt);
			$idDebt = $DataInsert->insert_id();
		}
		if($idDebt !=""){
			$objectDebtDetail  = array(  
					'debtID'=>$idDebt,
					'debtDate'=>date("y-m-d"),
					'debtPay'=>$this->input->post('nominal'), 
					'keterangan'=>'',
					'createdDate'=>'',
					'createdUserID'=>''
			);
			$this->db->insert('as_debts_payment', $objectDebtDetail);
			//$this->_insert_on_duplicate_update_batch('as_debts_payment','debtID',$objectDebtDetail);
		}
		//masukan kedalam pengeluaran bendahara
		$object  = array(
				'no_trx_kas' =>  $this->input->post('invoiceBuyID'),
				'tgl_catat' => date("Y-m-d"),
				'jumlah' => $this->input->post('nominal'),
				'keterangan' => $keterangan,
				'akun' => 'Pengeluaran', 
				'jns_trans' => "KK",
				'kepada' => $this->input->post('dari'),
				'dok' => $this->input->post('invoiceBuyID'),
				'posting' => 1,
				'no_dok' => $this->input->post('invoiceBuyID'),
				'identity_id' => $this->session->userdata('SESS_USER_ID'),
				'user' => $this->session->userdata('SESS_USER_ID'),
		);
		$this->db->insert('tbl_trans_kas', $object);
		// Insert to custom trans table
		// 1 = setor, 2 = terima
		$cdata = array(
			'id_trans_kas' => $this->db->insert_id(),
			'user_id' => $this->session->userdata('SESS_USER_ID'),
			'type'=>1,
		);

		$this->db->insert( 'tbl_trans_kas_out', $cdata );
		
		 
 		$akun_debit = $this->input->post('akun_hutang');
		$akun_kredit = $this->input->post('akun');
		$jumlah_bayar  = str_replace(",", "", $this->input->post('nominal')); 
		$this->details[1] = array(
			'item' => 1,
			'akun_id' => $akun_debit,
			'debit_kredit' => 1, 
			'nilai' => (float) $jumlah_bayar,
			'keterangan' => $keterangan,
		);
		$this->details[2] = array(
			'item' => 1,
			'akun_id' => $akun_kredit,
			'debit_kredit' => 0,
			'nilai' => (float) $jumlah_bayar,
			'keterangan' => $keterangan,
		);
	}
	function fill_data_add_hutang($data)
	{
		$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $data['tanggal'],
			'f_id' => 1,
			'invoice_no' => $data['invoiceBuyID'],
			'keterangan' =>  $data['keterangan'],
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$object  = array(
			'is_pay' => 0
		);
		$dataWhere = array(
        		"supplierID"=>$data['supplierID'],
        		"invoiceBuyID"=>$data['invoiceBuyID']
        	);
		$this->db->where($dataWhere);
		$this->db->update('as_buy_transactions', $object);
 		$akun_debit = $data['akun_debit'];//"245"//HPP obat
		$akun_kredit = $data['akun_kredit'];//"81"//utang kepada vendor
		$jumlah_bayar  = str_replace(",", "", $data['nominal']); 
		$this->details[1] = array(
			'item' => 1,
			'akun_id' => $data['akun_debit'],
			'debit_kredit' => 1, 
			'nilai' => (float) $jumlah_bayar,
			'keterangan' =>  $data['keterangan'],
		);
		$this->details[2] = array(
			'item' => 1,
			'akun_id' => $data['akun_kredit'],
			'debit_kredit' => 0,
			'nilai' => (float) $jumlah_bayar,
			'keterangan' => $data['keterangan'],
		);
	}
	//Check for duplicate no
	function check_no()
	{
		//$this->db->where('no', $this->data['no']);
		//$query = $this->db->select('*')->from('jurnal')->where('no', $this->data['no'])->get();
		$query = $this->db->query("SELECT * FROM `jurnal` WHERE  `no` ='".$this->data['no']."'  ");
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
			
			// check for akun_saldo
			if ( $this->db->query("SELECT akun_id FROM akun_saldo WHERE akun_id = " . $this->details[$i]['akun_id'] . " AND identityID=" . $this->identity_id )->row_array() ) {
				$this->db->query('UPDATE akun_saldo SET saldo = saldo' . $op . $this->details[$i]['nilai'] . ' WHERE akun_id = ' . $this->details[$i]['akun_id'] . ' AND identityID=' . $this->identity_id );
			} else {
				$data = array(
					'akun_id' => $this->details[$i]['akun_id'],
					'identityID' => $this->identity_id,
					'saldo' => $this->details[$i]['nilai']
				);
				$this->db->insert('akun_saldo', $data);
			}
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function tampil_member()
	{
		return $this->db->get('as_members');
	}

	public function hapus_jurnal($id, $idjurnal)
	{
		return $this->db->delete('jurnal_detail', array('jurnal_id' => 12));
		return $this->db->delete('jurnal', array('invoice_no' => $id));
	}

	function GenJurNumber()
	{
	
		$trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 6, 8);
		if ($produksiIDfil == "") {
			$trxDate = date('my');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
		} else {
			$trxDate = date('my');
			$trxd = substr($produksiIDfil, 0, 4);
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

		$kode = "JI-" . date('d') . "-" . $invno;
		return $kode;
	}
	
	function GenJunSA()
	{
	
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="13" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JSA-".$identityCode."/".$invno;
		return $kode;
	}
	
	
	function GenJuno()
	{
	
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="1" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JUM-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJpb()
	{
	
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="4" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JPB-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJsl()
	{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="5" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JSL-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJpu($id)
	{
		$q_data = $this->db->query("SELECT * FROM as_identity WHERE identityID = '".$id."' ");
		$a_data = $q_data->row();
		$identityCode=$a_data->identityCode;
		
		$trxid = $this->db->query('SELECT * from jurnal where f_id="15" and identityID='.$id.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JPU-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJpp($id)
	{
		$q_data = $this->db->query("SELECT * FROM as_identity WHERE identityID = '".$id."' ");
		$a_data = $q_data->row();
		$identityCode=$a_data->identityCode;
		
		$trxid = $this->db->query('SELECT * from jurnal where f_id="16" and identityID='.$id.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JPP-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJkasout()
	{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="6" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "KKL-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJbankout($bank_akun)
	{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="10" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "BKO-".$identityCode."/".$invno;
		return $kode;
	}
	
	
	function GenJkasin()
	{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="7" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "KKM-".$identityCode."/".$invno;
		return $kode;
	}
	
	
	function GenJbankin($bank_akun)
	{
		if($bank_akun)
		{
		$identityID=$bank_akun;
		}
		else{
		$identityID=$this->session->userdata('IDENTITY_ID');
		}
		$identityCode=$this->session->userdata('identityCode');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="11" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "BKI"."-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJtrfKB()
	{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="12" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "TKB-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJrp()
	{
	
		$trxid = $this->db->query('SELECT * from jurnal where f_id="7" order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
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

		$kode = "JRP-".$invno;
		return $kode;
	}
	
	function GenJsa()
	{
	
		$trxid = $this->db->query('SELECT * from jurnal where f_id="8" order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
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

		$kode = "JSA-".$invno;
		return $kode;
	}
	
	
	function GenJsp()
	{
	
		$trxid = $this->db->query('SELECT * from jurnal where f_id="9" order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
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

		$kode = "JSP-".$invno;
		return $kode;
	}
	
	function GenJpe()
	{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="2" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JPE-".$identityCode."/".$invno;
		return $kode;
	}
	
	function GenJkor()
	{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$trxid = $this->db->query('SELECT * from jurnal where f_id="14" and identityID='.$identityID.' order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 13, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate."/". $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 7, 5);
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

		$kode = "JKR-".$identityCode."/".$invno;
		return $kode;
	}

	function GenKasNumber($jns)
	{
		$trxid = $this->db->query('SELECT * from tbl_trans_kas order by id desc limit 1;')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no_trx_kas'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 6, 8);
		if ($produksiIDfil == "") {
			$trxDate = date('my');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
		} else {
			$trxDate = date('my');
			$trxd = substr($produksiIDfil, 0, 4);
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

		$kode = $jns . "-" . date('d') . "-" . $invno;
		return $kode;
	}


	public function fill_data_setor_to_bendahara()
	{

		$this->load->model('Jurnal_unpost_model', 'jurnal_unpostm');
		$no_kas = $this->GenKasNumber($this->input->post('jns'));
		$no_jurnal = $this->GenJurNumber();
		$this->data = array(
			'no' =>  $no_jurnal,
			'tgl' => $this->input->post('tgl_trx'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $no_kas,
			'keterangan' => $this->input->post('keterangan'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);

		$object  = array(
			'no_trx_kas' => $no_kas,
			'tgl_catat' => $this->input->post('tgl_trx'),
			'jumlah' => str_replace(',', '', $this->input->post('jumlah')),
			'keterangan' => $this->input->post('keterangan'),
			'jns_trans' => $this->input->post('jns'),
			'akun' => $this->input->post('type_trx'),
			'dari' => 'Kasir',
			'posting' => 1,
			'identity_id' => $this->input->post('identity_id'),
			'user' => $this->input->post('userid')
		);
		$this->db->insert('tbl_trans_kas', $object);

		// Insert to custom trans table
		// 1 = setor, 2 = terima
		$cdata = array(
			'id_trans_kas' => $this->db->insert_id(),
			'type' => 2,
			'user_id' => $this->input->post('userid')
		);
		$this->db->insert('tbl_trans_kas_custom', $cdata);

		// Update status setoran
		$this->jurnal_unpostm->update_status_setoran($no_jurnal);

		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');

		$akun = array();
		$akun[1] = array(
			'item' => 1,
			'akun_id' => $this->input->post('tf_dari'),
			'debit_kredit' => 0,
			'nilai' => $this->input->post('jumlah'),
			'keterangan' => ''
		);
		$akun[2] = array(
			'item' => 2,
			'akun_id' => $this->input->post('tf_ke'),
			'debit_kredit' => 1,
			'nilai' => $this->input->post('jumlah'),
			'keterangan' => ''
		);
		$this->details = $akun;
	}

	public function fill_data_setor_to_bank()
	{

		$no_kas = $this->GenKasNumber($this->input->post('jns'));
		$this->data = array(
			'no' =>  $this->GenJurNumber(),
			'tgl' => $this->input->post('tgl_trx'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $no_kas,
			'keterangan' => $this->input->post('keterangan'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);

		$object  = array(
			'no_trx_kas' => $no_kas,
			'tgl_catat' => $this->input->post('tgl_trx'),
			'jumlah' => str_replace(',', '', $this->input->post('jumlah')),
			'keterangan' => $this->input->post('keterangan'),
			'jns_trans' => $this->input->post('jns'),
			'akun' => $this->input->post('type_trx'),
			'dari' => 'Bendahara',
			'dari_kas_id' => $this->input->post('tf_dari'),
			'untuk_kas_id' => $this->input->post('tf_ke'),
			'posting' => 1,
			'identity_id' => $this->input->post('identity_id'),
			'user' => $this->input->post('userid')
		);
		$this->db->insert('tbl_trans_kas', $object);

		// Insert to custom trans table
		// 1 = setor, 2 = terima
		$cdata = array(
			'id_trans_kas' => $this->db->insert_id(),
			'type' => 1,
			'user_id' => $this->input->post('userid')
		);
		$this->db->insert('tbl_trans_kas_custom', $cdata);

		if ($this->input->post('proyekID')) $this->data['proyek_id'] = $this->input->post('proyekID');

		$akun = array();
		$akun[1] = array(
			'item' => 1,
			'akun_id' => $this->input->post('tf_dari'),
			'debit_kredit' => 0,
			'nilai' => str_replace(',', '', $this->input->post('jumlah')),
			'keterangan' => ''
		);
		$akun[2] = array(
			'item' => 2,
			'akun_id' => $this->input->post('tf_ke'),
			'debit_kredit' => 1,
			'nilai' => str_replace(',', '', $this->input->post('jumlah')),
			'keterangan' => ''
		);
		$this->details = $akun;
	}
	function _insert_on_duplicate_update_batch($table, $keysID, $data)
	{
	   $mysql = "";
	   foreach($data as $item){
	   		$keys = array_keys($item);
	   		$values = array_values($item);
	   		$cek = $this->db->select('*')->from($table)->WHERE($keysID,$item[$keysID])->get()->result_array();
	   		if(count($cek) >0){
	   			$this->db->update($table,$item,array($keysID=>$item[$keysID]));
	   			/*$mysql .=  "UPDATE  ".$table." SET ";
	   			foreach ($keys as $key) {
	   				 $mysql .= $keys."='".$item[$key]."'";
	   			}
	   			$mysql .=" WHERE ".$keysID."='".$item[$keysID]."'; ";*/
	   		}else{
	   			$this->db->insert($table,$item);
	   			/*$mysql .=  "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES ('".implode('\',\' ',$values)."'); ";*/
	   		}

	   }	
	   //die($mysql);
	  // return $this->db->query($mysql);
	  
	  
	}

	public function post_jurnal_data($id)
	{
		

		$this->db->query('SET foreign_key_checks = 0');
		$query_cek1=$this->db->query("insert into jurnal(no,tgl,f_id,keterangan,invoice_no) select no,tgl,f_id,keterangan,invoice_no from jurnal_temp where invoice_no='$id'");
		
		$q_data = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '".$id."' ");
		$a_data = $q_data->row();
		$idjurnal=$a_data->id;

		$query_cek2=$this->db->query("insert into jurnal_detail(jurnal_id,item,akun_id,debit_kredit,nilai,keterangan) select '$idjurnal',a.item,a.akun_id,a.debit_kredit,a.nilai,a.keterangan from jurnal_detail_temp a left join jurnal_temp b on a.jurnal_id=b.id where b.invoice_no='$id'");

		$this->db->query('SET foreign_key_checks = 1');
	}

	function get_data_id_k_i_temp($id)
	{
		$this->db->select('jurnal_temp.id,tbl_trans_kas.id as trx_kas_in_id, jurnal_temp.tgl, jurnal_temp.no, jurnal_temp.invoice_no, jurnal_temp.keterangan, jurnal_temp.f_id AS f_id, f.nama AS f_name, jurnal_temp.proyek_id, proyek.nama as project_name, jurnal_detail_temp.jurnal_id,jurnal_detail_temp.item, jurnal_detail_temp.id as id_jr_det,jurnal_detail_temp.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_detail_temp.debit_kredit, jurnal_detail_temp.nilai, jurnal_detail_temp.keterangan as ket_jurnal_det');
		$this->db->from('jurnal_temp');
		$this->db->join('f', 'jurnal_temp.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail_temp', 'jurnal_detail_temp.jurnal_id=jurnal_temp.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail_temp.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal_temp.proyek_id=proyek.id', 'LEFT');
		$this->db->join('tbl_trans_kas', 'tbl_trans_kas.no_trx_kas=jurnal_temp.invoice_no', 'LEFT');
		$this->db->where('jurnal_temp.invoice_no', $id);
		$this->db->order_by('jurnal_temp.tgl', 'asc');
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
	
	function get_data_id_inv_temp($id)
	{
		$this->db->select('jurnal_temp.id,as_sales_transactions.trxID as trx_inv_id, jurnal_temp.tgl, jurnal_temp.no, jurnal_temp.invoice_no, jurnal_temp.keterangan, jurnal_temp.f_id AS f_id, f.nama AS f_name, jurnal_temp.proyek_id, proyek.nama as project_name, jurnal_detail_temp.jurnal_id,jurnal_detail_temp.item, jurnal_detail_temp.id as id_jr_det,jurnal_detail_temp.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_detail_temp.debit_kredit, jurnal_detail_temp.nilai, jurnal_detail_temp.keterangan as ket_jurnal_det');
		$this->db->from('jurnal_temp');
		$this->db->join('f', 'jurnal_temp.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail_temp', 'jurnal_detail_temp.jurnal_id=jurnal_temp.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail_temp.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal_temp.proyek_id=proyek.id', 'LEFT');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=jurnal_temp.invoice_no', 'LEFT');
		$this->db->where('jurnal_temp.invoice_no', $id);
		$this->db->order_by('jurnal_temp.tgl', 'asc');
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
