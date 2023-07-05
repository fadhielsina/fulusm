<?php

class Saldo_model extends CI_Model {

	var $data;

	function Kas_model()
	{
		parent::Model();
	}
	
	function get_loc_data()
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
		if($this->session->userdata('ADMIN')!='1')
		{
		 $this->db->where('tbl_trans_kas.identity_id', $id);
		}
		$this->db->group_by('tbl_trans_kas.id');
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
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_all_data_out($id1,$id2,$id3)
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->select('tbl_trans_kas.id as id_trx');
		$this->db->select('jurnal.*');
		$this->db->from('tbl_trans_kas');
		$this->db->join('jurnal', 'jurnal.invoice_no=tbl_trans_kas.no_trx_kas', 'left');
		$this->db->where('tbl_trans_kas.jns_trans', 'KK');
		if($this->session->userdata('ADMIN')!='1')
		{
		$this->db->where('tbl_trans_kas.identity_id', $id1);
		}
		else
		{
			if($id1!=' ')
				{
					$this->db->where('tbl_trans_kas.identity_id', $id1);
				}
				else{
				}
		}
		if($id2)
	 {
		  $this->db->where('tbl_trans_kas.tgl_catat >=', $id2);
	 }
	 
	 if($id3)
	 {
		  $this->db->where('tbl_trans_kas.tgl_catat <= ', $id3);
	 }
		$this->db->order_by('tbl_trans_kas.id', 'desc');
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
	
	function get_data_saldo_temp($id)
	{
		$this->db->select('jurnal_temp.id,as_receivables_bal.receivableID, jurnal_temp.tgl, jurnal_temp.no, jurnal_temp.invoice_no, jurnal_temp.keterangan, jurnal_temp.f_id AS f_id, f.nama AS f_name, jurnal_temp.proyek_id, proyek.nama as project_name, jurnal_detail_temp.jurnal_id,jurnal_detail_temp.item, jurnal_detail_temp.id as id_jr_det,jurnal_detail_temp.akun_id, akun.nama as account_name, akun.kelompok_akun_id,akun.kode, jurnal_detail_temp.debit_kredit, jurnal_detail_temp.nilai, jurnal_detail_temp.keterangan as ket_jurnal_det');
		$this->db->from('jurnal_temp');
		$this->db->join('f', 'jurnal_temp.f_id=f.id', 'INNER');
		$this->db->join('jurnal_detail_temp', 'jurnal_detail_temp.jurnal_id=jurnal_temp.id', 'INNER');
		$this->db->join('akun', 'jurnal_detail_temp.akun_id=akun.id', 'INNER');
		$this->db->join('proyek', 'jurnal_temp.proyek_id=proyek.id', 'LEFT');
		$this->db->join('as_receivables_bal', 'as_receivables_bal.no_trx_bal=jurnal_temp.invoice_no', 'LEFT');
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
	
	function get_all_data_recv_bal($id2,$id3)
	{
		$this->db->select('as_members.*');
		$this->db->select('as_receivables_bal.*');
		$this->db->select('jurnal.*');
		$this->db->from('as_receivables_bal');
		$this->db->join('jurnal', 'jurnal.invoice_no=as_receivables_bal.no_trx_bal', 'left');
		$this->db->join('as_members', 'as_members.memberID=as_receivables_bal.memberID', 'left');
		if($id2)
	 {
		  $this->db->where('as_receivables_bal.tgl_catat >=', $id2);
	 }
	 
	 if($id3)
	 {
		  $this->db->where('as_receivables_bal.tgl_catat <= ', $id3);
	 }
		$this->db->order_by('as_receivables_bal.receivableID', 'desc');
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
	
	
	function get_all_data_in_byid($id)
	{
		$this->db->select('tbl_trans_kas.*');
		$this->db->from('tbl_trans_kas');
		$this->db->where('tbl_trans_kas.id', $id);
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
	
	function get_all_data_bal_ref($id)
	{
		
		$this->db->select('login.nama_depan');
		$this->db->select('as_members.memberFullName');
		$this->db->select('as_receivables_bal.*');
		$this->db->from('as_receivables_bal');
		$this->db->join('as_members', 'as_members.memberID=as_receivables_bal.memberID', 'left');
		$this->db->join('login', 'login.id=as_receivables_bal.createdUserID', 'left');
		$this->db->where('as_receivables_bal.no_trx_bal', $id);
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

	function get_data_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('akun');
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}

	function get_data_for_dropdown()
	{
		$data = $this->get_all_data();
		if($data) {
			foreach ($data as $row) {
				$akun[$row->id] = $row->nama.' - '.$row->kode;
			}
			return $akun;
		}
		else
		{
			return FALSE;
		}
	}

	function get_id_by_name($name)
	{
		$this->db->where('nama', $name);
		$query = $this->db->get('akun');

		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result->id;
		}
		else
		{
			return FALSE;
		}
	}	

	function get_all_account_groups()
	{
		$query = $this->db->get('kelompok_akun');
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$kelompok_akun[$row->id] = $row->nama;
			}
			return $kelompok_akun;
		}
		else
		{
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
		if($id != '') $this->db->where('id !=', $id);
		$query = $this->db->get('akun');

		if ($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}	

	//Check for duplicate account kode
	function check_code($id = '')
	{
		$this->db->where('kode', $this->data['kode']);
		if($id != '') $this->db->where('id !=', $id);
		$query = $this->db->get('akun');

		if ($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}	

	function set_saldo_awal()
	{
		$id = $this->input->post('id');
		$this->db->trans_start();
		for ($i = 1; $i <= count($id); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
			if($debit)
			{
				$saldo_awal = $debit;
			}
			elseif($kredit)
			{
				$saldo_awal = -$kredit;
			}
			else
			{
				$saldo_awal = 0;
			}
			$this->db->where('id', $id[$i-1]);
			$update = $this->db->update('akun', array('saldo_awal' => $saldo_awal) );
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

	function delete_data($id){
		$this->db->where('id', $id);
		$delete = $this->db->delete('tbl_trans_kas');
		return $delete;
	}
	
	function delete_jurnal($id){
		$this->db->where('id', $id);
		$delete = $this->db->delete('jurnal');
		return $delete;
	}
	
	function delete_detail_jurnal($id){
		$this->db->where('jurnal_id', $id);
		$delete = $this->db->delete('jurnal_detail');
		return $delete;
	}

}
/* End of file akun_model.php */
/* Location: ./application/models/akun_model.php */
