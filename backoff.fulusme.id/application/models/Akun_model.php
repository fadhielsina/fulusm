<?php

class Akun_model extends CI_Model {

	var $data;

	public $identity_id;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->identity_id = $this->session->userdata('IDENTITY_ID');
    }
	
	function set_account_group_id($id)
	{
		$this->db->where_in('akun.kelompok_akun_id', $id);
	}

	function get_all_data($kelompok_akun_id = null)
	{
		$this->db->select('akun.id, akun.nama, akun.kode, akun_saldo.saldo_awal, akun_saldo.saldo, akun.kelompok_akun_id, kelompok_akun.nama AS groups_name, akun.nama AS nama_parent, akun.level,
			(select count(id) from akun akn_child where akn_child.parent_akun= akun.id ) child
			');
		$this->db->from('akun_saldo');
		$this->db->join('akun', 'akun.id=akun_saldo.akun_id', 'LEFT');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id=kelompok_akun.id', 'INNER');
		$this->db->where('akun_saldo.identityID', $this->identity_id);
		if ( $kelompok_akun_id ) {
			$this->db->where('akun.kelompok_akun_id', $kelompok_akun_id);
		}
		$this->db->order_by("akun.kelompok_akun_id,akun.kode,akun.id ASC");

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
	
	function get_all_data2()
	{
		$this->db->select('*');
		$this->db->from('akun_saldo');
		$this->db->join('akun', 'akun.id=akun_saldo.akun_id');
		$this->db->where('akun_saldo.identityID', $this->identity_id);

		$this->db->order_by("akun_saldo.akun_saldo_id ASC");

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

	function get_all_data_akun()
	{
		$this->db->select('akun.id, akun.nama, akun.kode, akun.kelompok_akun_id, kelompok_akun.nama AS groups_name, akun.nama AS nama_parent');
		$this->db->from('akun');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id=kelompok_akun.id', 'INNER');
	
		$this->db->order_by("akun.kelompok_akun_id ASC");
		$this->db->order_by("akun.id ASC");
		$this->db->order_by("akun.parent_akun ASC");
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
	
	function get_all_data_piutang()
	{
		$this->db->select('*');
		$this->db->from('akun_saldo');
		$this->db->join('akun', 'akun.id=akun_saldo.akun_id');
		 $this->db->like('akun.kode', '2', 'after'); 
		$this->db->where('akun_saldo.identityID', $this->identity_id);

		$this->db->order_by("akun.id ASC");

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
	
	function get_all_data_utang()
	{
		$this->db->select('*');
		$this->db->from('akun_saldo');
		$this->db->join('akun', 'akun.id=akun_saldo.akun_id');
		 $this->db->like('akun.kode', '5', 'after'); 
		$this->db->where('akun_saldo.identityID', $this->identity_id);

		$this->db->order_by("akun.id ASC");

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

	function get_all_data_by_kode($kode = '')
	{
		$this->db->select('as_departement.departement_name,as_division.division_name,akun.id, akun.nama, akun.kode, akun.saldo_awal, akun.saldo, akun.kelompok_akun_id, kelompok_akun.nama AS groups_name');
		$this->db->from('akun');
		$this->db->join('as_departement', 'as_departement.id_departement= akun.id_departement', 'LEFT');
		$this->db->join('as_division', 'as_departement.id_division= as_division.id_division', 'LEFT');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id=kelompok_akun.id', 'INNER');

		if ( '' !== $kode ) {
			$this->db->like('akun.kode', $kode, '');
		}

		$this->db->order_by("akun.kode ASC");

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
	
	
	function get_all_data_conf()
	{
		$this->db->select('*');
		$this->db->from('tbl_config_akun');
		$this->db->where('akun_id IS NULL');
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
	
	function get_all_data_akun_config()
	{
		$this->db->select('*');
		$this->db->from('tbl_config_akun');
		$this->db->join('akun', 'akun.id=tbl_config_akun.akun_id', 'left');
		$this->db->where('akun_id IS NOT NULL');
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
	
	
	function get_all_kas()
	{
		$this->db->select('akun.id, akun.nama, akun.kode, akun.saldo_awal, akun.saldo, akun.kelompok_akun_id, kelompok_akun.nama AS groups_name');
		$this->db->from('akun');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id=kelompok_akun.id', 'INNER');
		$this->db->where_in('akun.kelompok_akun_id', 1);
		$this->db->where("akun.kode REGEXP '^(111|112)'");
		$this->db->where('length(kode) >', 2);
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
	
	function get_data_for_dropdown_kas()
	{
		$data = $this->get_all_kas();
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
	function get_data_for_dropdown_piutang()
	{
		$this->db->select('akun.id, akun.nama, akun.kode, akun.saldo_awal, akun.saldo, akun.kelompok_akun_id, kelompok_akun.nama AS groups_name');
		$this->db->from('akun');
		$this->db->join('kelompok_akun', 'akun.kelompok_akun_id=kelompok_akun.id', 'INNER');
		$this->db->where_in('akun.kelompok_akun_id', 1);
		$this->db->like('akun.kode', '11301','');
		$data = $this->db->get();
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


	function get_data_by_id_saldo($id)
	{
		 $query=$this->db->query("SELECT a.*,b.* FROM akun_saldo a left join jurnal b on a.sa_trx_no=b.invoice_no  WHERE a.akun_id = '".$id."'  and a.identityID = '".$this->session->userdata('IDENTITY_ID')."' ");
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}

	function get_data_for_dropdown( $kelompok_akun_id = null, $kode = null )
	{
		if ( $kode ) {
			$data = $this->get_all_data_by_kode( $kode );
		} else {
			$data = $this->get_all_data( $kelompok_akun_id );
		}
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
		$idakunpar=$this->input->post('parent_akun');
		$q_data2 = $this->db->query("SELECT * FROM akun WHERE id = '".$idakunpar."' ");
		$a_data2 = $q_data2->row();
		$levelpar=$a_data2->level;
		$levelchild=$levelpar+1;
		$this->data = array(
			
			//'id_company' => $this->input->post('id_company'),
			'parent_akun' => $this->input->post('parent_akun'),
			//'id_division' => $this->input->post('id_division'),
			'nama' => $this->input->post('nama'),
			'kode' => $this->input->post('kode'),
			'level' => $levelchild,
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
	function set_saldo_awal_bulk()
	{
		$id = $this->input->post('id');
		 
		$this->db->trans_start();
		foreach ($id as $key => $i) 			
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
			$this->db->where('id', $i);
			$update = $this->db->update('akun', array('saldo_awal' => $saldo_awal) );
			if($saldo_awal>0){
				$cek =  $this->db->get_where('akun_saldo',array('akun_id'=>$i,'identityID'=>$this->identity_id));
				if($cek->num_rows()>0){
					$this->db->update('akun_saldo',array('saldo_awal'=>$saldo_awal),array('akun_id'=>$i,'identityID'=>$this->identity_id));
				}else{
					$this->db->insert('akun_saldo',array('saldo_awal'=>$saldo_awal,'akun_id'=>$i,'identityID'=>$this->identity_id,'tanggal'=>date("y-m-d")));	
				}
			
				
			}

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
		$delete = $this->db->delete('akun');
		return $delete;
	}

	public function get_all_kas_bank()
	{
		return $this->db->query("SELECT akun.id, akun.nama, akun.kode FROM akun_saldo
			LEFT JOIN akun ON akun.id = akun_saldo.akun_id
			WHERE akun.kode REGEXP '^(1000)' AND akun.kode not in ('1000.00','1000.01','1000.02') AND akun_saldo.identityID=" . $this->identity_id)->result();
	}
	
	public function get_aset_tetap()
	{
		return $this->db->query("SELECT akun.id, akun.nama, akun.kode FROM akun_saldo
			LEFT JOIN akun ON akun.id = akun_saldo.akun_id
			WHERE akun.kode REGEXP '^(4000)' AND akun.kode <> '4000.00' and akun_saldo.identityID=" . $this->identity_id)->result();
	}
	
	public function get_utang_akun()
	{
		return $this->db->query("SELECT akun.id, akun.nama, akun.kode FROM akun_saldo
			LEFT JOIN akun ON akun.id = akun_saldo.akun_id
			WHERE akun.kode REGEXP '^(5200)' AND akun.kode <> '5200.00' and akun_saldo.identityID=" . $this->identity_id)->result();
	}
	
	public function get_all_akun_arr()
	{
		return $this->db->query("SELECT akun.id, akun.nama, akun.kode FROM akun_saldo
			LEFT JOIN akun ON akun.id = akun_saldo.akun_id
			WHERE  akun_saldo.identityID=" . $this->identity_id)->result_array();
	}
	
	public function get_all_kas_bank_unit($id)
	{
		return $this->db->query("SELECT akun.id, akun.nama, akun.kode FROM akun_saldo
			LEFT JOIN akun ON akun.id = akun_saldo.akun_id
			WHERE akun.kode REGEXP '^(1000)' AND akun_saldo.identityID=" . $id)->result();
	}

	public function get_data_for_dropdown_kas_bank($kelompok_akun_id = null)
	{
		$results = $this->db->query("SELECT akun.id, akun.nama, akun.kode FROM akun_saldo
			LEFT JOIN akun ON akun.id = akun_saldo.akun_id
			WHERE akun.kode REGEXP '^(1)' AND akun_saldo.identityID=" . $this->identity_id)->result_array();

		$data = array();
		if ( count( $results ) > 0 ) {
			foreach ($results as $key => $value) {
				$value = (array)$value;
				$data[$value['id']] = $value['nama'].' - '.$value['kode'];
			}
		}
		return $data;
	}

	function get_data_for_dropdown_umum()
	{
		$results = $this->db->query("SELECT akun.id, akun.nama, akun.kode FROM akun_saldo
			LEFT JOIN akun ON akun.id = akun_saldo.akun_id
			WHERE akun_saldo.identityID=" . $this->identity_id)->result_array();

		$data = array();
		if ( count( $results ) > 0 ) {
			foreach ($results as $key => $value) {
				$value = (array)$value;
				$data[$value['id']] = $value['nama'].' - '.$value['kode'];
			}
		}
		return $data;
	}

}
/* End of file akun_model.php */
/* Location: ./application/models/akun_model.php */
