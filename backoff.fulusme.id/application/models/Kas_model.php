<?php

class Kas_model extends CI_Model
{

	var $data;

	public $identity_id;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->identity_id = $this->session->userdata('IDENTITY_ID');
	}

	function table_add($data)
	{

		if ($this->db->insert($this->table, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function get_all_data_trf($id)
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('tbl_trans_kas.keterangan as ket_trx');
		$this->db->select('jurnal.*');
		$this->db->select('akun.*');
		$this->db->select('akun.nama as nm_akun');
		$this->db->select('akun2.nama as nm_akun2');
		$this->db->from('tbl_trans_kas');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'left');
		$this->db->join('akun', 'tbl_trans_kas.dari_kas_id=akun.id', 'left');
		$this->db->join('akun as akun2', 'tbl_trans_kas.untuk_kas_id=akun2.id', 'left');
		$this->db->where('tbl_trans_kas.jns_trans', 'TK');
		$this->db->where('tbl_trans_kas.identity_id', $id);
		$this->db->group_by('tbl_trans_kas.id');
		$this->db->order_by('tbl_trans_kas.id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_all_data_trf_byid($id)
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('tbl_trans_kas.keterangan as ket_trx');
		$this->db->select('jurnal.*');
		$this->db->select('akun.*');
		$this->db->select('akun.nama as nm_akun');
		$this->db->select('akun2.nama as nm_akun2');
		$this->db->from('tbl_trans_kas');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->join('jurnal_detail', 'jurnal_detail.jurnal_id=jurnal.id', 'left');
		$this->db->join('akun', 'tbl_trans_kas.dari_kas_id=akun.id', 'left');
		$this->db->join('akun as akun2', 'tbl_trans_kas.untuk_kas_id=akun2.id', 'left');
		$this->db->where('tbl_trans_kas.id', $id);
		$this->db->group_by('tbl_trans_kas.id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_all_data_out($id, $isposting = "")
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('jurnal.*');
		$this->db->from('tbl_trans_kas');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->where('tbl_trans_kas.jns_trans', 'KK');
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('tbl_trans_kas.identity_id', $id);
		}
		$this->db->group_by('tbl_trans_kas.id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_all_data_out_custom($id, $isposting = "", $id2, $id3)
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas_out.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('jurnal.*');
		$this->db->from('tbl_trans_kas_out');
		$this->db->join('tbl_trans_kas', 'tbl_trans_kas.id=tbl_trans_kas_out.id_trans_kas', 'left');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->where('tbl_trans_kas.jns_trans', 'KK');
		if ($isposting != "") {
			$this->db->where('tbl_trans_kas.posting', $isposting);
		}
		if ($this->session->userdata('ADMIN') != '1') {
			//$this->db->where('tbl_trans_kas.identity_id', $id);
			$this->db->where('tbl_trans_kas_out.user_id', $id);
		}
		if ($id2) {
			$id2 = date('Y-m-d', strtotime($id2));
			$this->db->where('tbl_trans_kas.tgl_catat >=', $id2);
		}

		if ($id3) {
			$id3 = date('Y-m-d', strtotime($id3));
			$this->db->where('tbl_trans_kas.tgl_catat <=', $id3);
		}

		$this->db->group_by('tbl_trans_kas.id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_all_data_in($id, $isposting = "")
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('jurnal.*');
		$this->db->from('tbl_trans_kas');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->where('tbl_trans_kas.jns_trans', 'KM');
		if ($isposting != "") {
			$this->db->where('tbl_trans_kas.posting', $isposting);
		}
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('tbl_trans_kas.identity_id', $id);
		}
		$this->db->group_by('tbl_trans_kas.id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_all_data_in_custom($id, $isposting = "", $id2, $id3)
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas_custom.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('jurnal.*');
		$this->db->from('tbl_trans_kas_custom');
		$this->db->join('tbl_trans_kas', 'tbl_trans_kas.id=tbl_trans_kas_custom.id_trans_kas', 'left');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		//$this->db->where('tbl_trans_kas.jns_trans', 'KM');
		if ($isposting != "") {
			$this->db->where('tbl_trans_kas.posting', $isposting);
		}
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('tbl_trans_kas_custom.user_id', $id);
		}
		$this->db->group_by('tbl_trans_kas_custom.id');

		if ($id2) {
			$id2 = date('Y-m-d', strtotime($id2));
			$this->db->where('tbl_trans_kas.tgl_catat >=', $id2);
		}

		if ($id3) {
			$id3 = date('Y-m-d', strtotime($id3));
			$this->db->where('tbl_trans_kas.tgl_catat <=', $id3);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_saldo_in()
	{
		$this->db->select('saldo');
		$this->db->from('akun');
		$this->db->where('id', 136);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_saldo_out()
	{
		$this->db->select('saldo');
		$this->db->from('akun');
		$this->db->where('id', 137);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	function get_all_data_in_byid($id)
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->from('tbl_trans_kas');
		$this->db->where('tbl_trans_kas.id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_data_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('akun');
		if ($query->num_rows() > 0) {
			return $query->row_array();
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

	function get_id_by_name($name)
	{
		$this->db->where('nama', $name);
		$query = $this->db->get('akun');

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result->id;
		} else {
			return FALSE;
		}
	}

	function get_all_account_groups()
	{
		$query = $this->db->get('kelompok_akun');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$kelompok_akun[$row->id] = $row->nama;
			}
			return $kelompok_akun;
		} else {
			return FALSE;
		}
	}

	function fill_data()
	{
		$this->data = array(
			'nama' => $this->input->post('nama'),
			'kode' => $this->input->post('kode'),
			'kelompok_akun_id' => $this->input->post('kelompok'),
			'pajak' => $this->input->post('pajak'),
			'keterangan' => $this->input->post('keterangan')
		);
	}

	//Check for duplicate account name
	function check_name($id = '')
	{
		$this->db->where('nama', $this->data['nama']);
		if ($id != '') $this->db->where('id !=', $id);
		$query = $this->db->get('akun');

		if ($query->num_rows() > 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//Check for duplicate account kode
	function check_code($id = '')
	{
		$this->db->where('kode', $this->data['kode']);
		if ($id != '') $this->db->where('id !=', $id);
		$query = $this->db->get('akun');

		if ($query->num_rows() > 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function set_saldo_awal()
	{
		$id = $this->input->post('id');
		$this->db->trans_start();
		for ($i = 1; $i <= count($id); $i++) {
			$debit = $this->input->post('debit' . $i);
			$kredit = $this->input->post('kredit' . $i);
			if ($debit) {
				$saldo_awal = $debit;
			} elseif ($kredit) {
				$saldo_awal = -$kredit;
			} else {
				$saldo_awal = 0;
			}
			$this->db->where('id', $id[$i - 1]);
			$update = $this->db->update('akun', array('saldo_awal' => $saldo_awal));
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function insert_data()
	{
		$insert = $this->db->insert('akun', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('akun', $this->data);
		return $update;
	}

	function delete_data($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('tbl_trans_kas');
		return $delete;
	}

	function delete_jurnal($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('jurnal');
		return $delete;
	}

	function delete_detail_jurnal($id)
	{
		$this->db->where('jurnal_id', $id);
		$delete = $this->db->delete('jurnal_detail');
		return $delete;
	}

	function get_all_data_insurance($id, $isposting = "")
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('jurnal.*');
		$this->db->from('tbl_trans_kas');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->where('tbl_trans_kas.jns_trans', 'KI');
		if ($isposting != "") {
			$this->db->where('tbl_trans_kas.posting', $isposting);
		}
		if ($this->session->userdata('ADMIN') != '1') {
			$this->db->where('tbl_trans_kas.identity_id', $id);
		}
		$this->db->group_by('tbl_trans_kas.id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function getHistori($akun, $tgl_awal, $tgl_akhir)
	{
		$query = "(dari_kas_id='$akun' OR untuk_kas_id='$akun')";
		if ($akun) {
			$this->db->select('*');
			$this->db->from('tbl_trans_kas');
			$this->db->where('tgl_catat >=', $tgl_awal);
			$this->db->where('tgl_catat <=', $tgl_akhir);
			$this->db->where($query);
			$this->db->where('identity_id', $this->session->userdata('IDENTITY_ID'));
			return $this->db->get()->result();
		}
	}

	public function filter($search, $limit, $start, $order_field, $order_ascdesc, $lokasi = null, $start_date = null, $end_date = null, $jns_trans){
		$this->_get_datatable_filter( $search, $order_field, $order_ascdesc, $lokasi, $start_date, $end_date, $jns_trans );
		$this->db->limit($limit, $start); // Untuk menambahkan query LIMIT

		return $this->db->get()->result_array(); // Eksekusi query sql sesuai kondisi diatas
  	}

	public function count_all( $order_field, $order_ascdesc, $lokasi, $jns_trans ){
		$this->_get_datatable_filter( null, $order_field, $order_ascdesc, $lokasi, null, null, $jns_trans );
		return $this->db->count_all_results(); // Untuk menghitung semua data siswa
	}

	public function count_filter( $search, $order_field, $order_ascdesc, $lokasi = null, $start_date = null, $end_date = null, $jns_trans ){
		$this->_get_datatable_filter( $search, $order_field, $order_ascdesc, $lokasi, $start_date, $end_date, $jns_trans );
		$query = $this->db->get();
	    return $query->num_rows();
	}

	public function _get_datatable_filter($search, $order_field, $order_ascdesc, $lokasi = null, $start_date = null, $end_date = null, $jns_trans = 'KM'){
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('jurnal.*');
		$this->db->from('tbl_trans_kas');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->where('tbl_trans_kas.jns_trans', $jns_trans);

		if( $lokasi )
		{
			$this->db->where('tbl_trans_kas.identity_id', $lokasi);
		}

		if ( $start_date ) {
			$this->db->where('tbl_trans_kas.tgl_catat >=', date('Y-m-d', strtotime( $start_date ) ) );
		}

		if ( $end_date ) {
			$this->db->where('tbl_trans_kas.tgl_catat <= ', date('Y-m-d', strtotime( $end_date ) ) );
		}

		if ( $search ) {
			$this->db->like('no_trx_kas', $search); // Untuk menambahkan query where LIKE
			$this->db->or_like('invoice_no', $search); // Untuk menambahkan query where OR LIKE
			$this->db->or_like('no_dok', $search); // Untuk menambahkan query where OR LIKE
			$this->db->or_like('tgl_catat', $search); // Untuk menambahkan query where OR LIKE
		}

		$this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
	}

	function cek_jurnal_ci($id)
	{
		$this->db->select('*');
		$this->db->from('jurnal_temp');
		$this->db->where('invoice_no', $id);
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
	
		function cek_jurnal_ci_det($id)
	{
		$this->db->select('*');
		$this->db->from('jurnal_detail');
		$this->db->where('jurnal_id', $id);
		$this->db->order_by("id", "desc");
		$this->db->limit(1);
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
/* End of file akun_model.php */
/* Location: ./application/models/akun_model.php */
