<?php

class Vendor_model extends CI_Model {
	
	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function get_all_data(){
		$identityID=$this->session->userdata('IDENTITY_ID');
		$this->db->select('*');  
		$this->db->from('as_suppliers');
		$this->db->where('as_suppliers.identityID', $identityID);
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
		$this->db->where('supplierID', $id);
		$query = $this->db->get('as_suppliers');
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
		$div=$this->input->post('entitas');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$venno= $this->GenVenNumber($div);
		$this->data = array(
			'supplierCode' => $venno,
			'supplierName' => $this->input->post('nama'),
			'supplierAddress' => $this->input->post('alamat'),			
			'supplierPhone' => $this->input->post('telpon'),
			'supplierEmail' => $this->input->post('email'),
			'supplierContactPerson' => $this->input->post('pic'),
			'identityID' => $identityID,
			'entitas' => $div
		);
	}
	
	function fill_data_up($id)
	{
		$q_data = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '".$id."' ");
        $a_data = $q_data->row();
		$code_supp =$a_data->supplierCode;
		$div=$this->input->post('entitas');
		$new_code=substr_replace($code_supp, $div, 3, 1); 
		$identityID=$this->session->userdata('IDENTITY_ID');
		$this->data = array(
			'supplierCode' => $new_code,
			'supplierName' => $this->input->post('nama'),
			'supplierAddress' => $this->input->post('alamat'),			
			'supplierPhone' => $this->input->post('telpon'),
			'supplierEmail' => $this->input->post('email'),
			'supplierContactPerson' => $this->input->post('pic'),
			'identityID' => $identityID,
			'entitas' => $div
		);
	}
	
	function GenVenNumber($div)
		{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$q_data = $this->db->query("SELECT * from as_suppliers where identityID='".$identityID."' and entitas ='".$div."' order by supplierID desc limit 1 ");
		$a_data = $q_data->row();
		$memberid=$a_data->supplierCode;
		$memberid_ent = substr($memberid, 3, 1);
		if($memberid<>"")
		{
			$memberid_count = substr($memberid, 4, 5);
			$memberid_new_count=$memberid_count+1;
			$memberid_new_count2 = sprintf("%05d", $memberid_new_count);
			$kode="V".$identityCode.$div.$memberid_new_count2;
		}
		else 
		{
			$kode="V".$identityCode.$div."00001";
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
		$insert = $this->db->insert('as_suppliers', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('supplierID', $id);
		$update = $this->db->update('as_suppliers', $this->data);
		return $update;
	}

	function delete_data($id){
		$this->db->where('supplierID', $id);
		$delete = $this->db->delete('as_suppliers');
		return $delete;
	}

}

/* End of file klien_model.php */
/* Location: ./application/models/klien_model.php */
