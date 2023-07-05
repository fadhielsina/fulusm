<?php

class Barang_kategori_model extends CI_Model {
	
	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function get_all_data(){
		$identityID=$this->session->userdata('IDENTITY_ID');
		$this->db->select('*');  
		$this->db->from('as_barang_kategori');
		$this->db->where('identityID', $identityID);
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
	
	function get_kategori_data()
	{
		
		$this->db->select('*');  
		$this->db->from('as_barang_kategori');
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
 
	
	  function search_klien($nama){
        $this->db->like('memberFullName', $nama , 'both');
        $this->db->limit(10);
        return $this->db->get('as_members')->result();
    }

	function get_data_by_id($id){
		$this->db->where('id_kat_barang', $id);
		$query = $this->db->get('as_barang_kategori');
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}

	function fill_data()
	{
		
		$identityID=$this->session->userdata('IDENTITY_ID');
		$prodcode= $this->GencatNumber();
		$this->data = array(
			'kode_kategori' => $prodcode,
			'nama_kategori' => $this->input->post('nama'),
			'identityID' => $identityID
		);
	}
	
	function fill_data_up()
	{
		
		$this->data = array(
			'nama_kategori' => $this->input->post('nama')
		);
	}
	
	function GencatNumber()
		{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$q_data = $this->db->query("SELECT * from as_barang_kategori where identityID='".$identityID."' order by id_kat_barang desc limit 1 ");
		$a_data = $q_data->row();
		if($a_data){
		$memberid=$a_data->kode_kategori;
		}
		else{
			$memberid="";
		}
		if($memberid<>"")
		{
			$memberid_count = substr($memberid, 4, 3);
			$memberid_new_count=$memberid_count+1;
			$memberid_new_count2 = sprintf("%03d", $memberid_new_count);
			$kode="P".$identityCode."-".$memberid_new_count2;
		}
		else 
		{
			$kode="P".$identityCode."-"."001";
		}
		return $kode;
		}
	
	//Check for duplicate login ID
	function check_name($id = '')
	{
		$this->db->where('nama', $this->data['nama']);
		if($id != '') $this->db->where('id !=', $id);
		$query = $this->db->get('klien');

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
		$insert = $this->db->insert('as_barang_kategori', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('id_kat_barang', $id);
		$update = $this->db->update('as_barang_kategori', $this->data);
		return $update;
	}

	function delete_data($id){
		$this->db->where('id_kat_barang', $id);
		$delete = $this->db->delete('as_barang_kategori');
		return $delete;
	}

}

/* End of file klien_model.php */
/* Location: ./application/models/klien_model.php */
