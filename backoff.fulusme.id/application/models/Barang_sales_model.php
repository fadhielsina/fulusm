<?php

class Barang_sales_model extends CI_Model {
	
	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function get_all_data(){
		$identityID=$this->session->userdata('IDENTITY_ID');
		$this->db->select('*');  
		$this->db->from('as_barang_jual');
		$this->db->join('as_barang_kategori', 'as_barang_kategori.id_kat_barang=as_barang_jual.id_kat_barang', 'LEFT');
		$this->db->where('as_barang_jual.idenityID', $identityID);
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
 
	
	  function search_klien($nama){
        $this->db->like('memberFullName', $nama , 'both');
        $this->db->limit(10);
        return $this->db->get('as_members')->result();
    }

	function get_data_by_id($id){
		$this->db->where('barangID', $id);
		$query = $this->db->get('as_barang_jual');
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
		$prodcode= $this->GenProdNumber();
		$this->data = array(
			'barangBarcode' => $prodcode,
			'barangName' => $this->input->post('nama'),
			'id_kat_barang' => $this->input->post('kategori'),	
			'satuanID' => $this->input->post('satuan1'),
			'satuanID2' => $this->input->post('satuan2'),
			'idenityID' => $identityID
		);
	}
	
	function fill_data_up()
	{
		
		$this->data = array(
			'barangName' => $this->input->post('nama'),
			'satuanID' => $this->input->post('satuan1'),
			'satuanID2' => $this->input->post('satuan2'),
			'id_kat_barang' => $this->input->post('kategori')
		);
	}
	
	function GenProdNumber()
		{
		
		$identityID=$this->session->userdata('IDENTITY_ID');
		$q_data = $this->db->query("SELECT * from as_barang_jual where idenityID='".$identityID."' order by barangID desc limit 1 ");
		$a_data = $q_data->row();
		$memberid=$a_data->barangBarcode;
		if($memberid<>"")
		{
			$memberid_count = substr($memberid, 1, 3);
			$memberid_new_count=$memberid_count+1;
			$memberid_new_count2 = sprintf("%03d", $memberid_new_count);
			$kode="P".$memberid_new_count2;
		}
		else 
		{
			$kode="P".$identityCode.$div."001";
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
		$insert = $this->db->insert('as_barang_jual', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('barangID', $id);
		$update = $this->db->update('as_barang_jual', $this->data);
		return $update;
	}

	function delete_data($id){
		$this->db->where('barangID', $id);
		$delete = $this->db->delete('as_barang_jual');
		return $delete;
	}

}

/* End of file klien_model.php */
/* Location: ./application/models/klien_model.php */
