<?php

class Klien_model extends CI_Model {
	
	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	

	
	function get_all_data()
	{
		$identityID=$this->session->userdata('IDENTITY_ID');
		$this->db->select('*');  
		$this->db->from('as_members');
		$this->db->where('as_members.identityID', $identityID);
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
		$this->db->where('memberID', $id);
		$query = $this->db->get('as_members');
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
		$cusno= $this->GenCusNumber($div);
		$this->data = array(
			'memberCode' => $cusno,
			'memberFullName' => $this->input->post('nama'),
			'memberNPWP' => $this->input->post('npwp').$this->input->post('npwp1').$this->input->post('npwp2').$this->input->post('npwp3').$this->input->post('npwp4').$this->input->post('npwp5'),
			'memberKTP' => $this->input->post('no_identitas'),
			'memberAddress' => $this->input->post('alamat'),			
			'memberPhone' => $this->input->post('telpon'),
			'memberEmail' => $this->input->post('email'),
			'identityID' => $identityID,
			'entitas' => $div,
			'is_new'=>1
		);
	}
	
	function fill_data_up($id)
	{
		$q_data = $this->db->query("SELECT * FROM as_members WHERE memberID = '".$id."' ");
        $a_data = $q_data->row();
		$code_mem =$a_data->memberCode;
		$div=$this->input->post('entitas');
		$new_code=substr_replace($code_mem, $div, 3, 1); 
		$identityID=$this->session->userdata('IDENTITY_ID');
		$this->data = array(
			'memberCode' => $new_code,
			'memberFullName' => $this->input->post('nama'),
			'memberNPWP' => $this->input->post('npwp').$this->input->post('npwp1').$this->input->post('npwp2').$this->input->post('npwp3').$this->input->post('npwp4').$this->input->post('npwp5'),
			'memberKTP' => $this->input->post('no_identitas'),
			'memberAddress' => $this->input->post('alamat'),			
			'memberPhone' => $this->input->post('telpon'),
			'memberEmail' => $this->input->post('email'),
			'identityID' => $identityID,
			'is_new'=>1
		);
	}
	
	function GenCusNumber($div)
		{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$q_data = $this->db->query("SELECT * from as_members where identityID='".$identityID."' and entitas ='".$div."' order by memberID desc limit 1 ");
		$a_data = $q_data->row();
		$memberid=$a_data->memberCode;
		if($memberid<>"")
		{
			$memberid_count = substr($memberid, 4, 5);
			$memberid_new_count=$memberid_count+1;
			$memberid_new_count2 = sprintf("%05d", $memberid_new_count);
			$kode="C".$identityCode.$div.$memberid_new_count2;
		}
		else 
		{
			$kode="C".$identityCode.$div."00001";
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
		$insert = $this->db->insert('as_members', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('memberID', $id);
		$update = $this->db->update('as_members', $this->data);
		return $update;
	}

	function delete_data($id){
		$this->db->where('memberID', $id);
		$delete = $this->db->delete('as_members');
		return $delete;
	}

}

/* End of file klien_model.php */
/* Location: ./application/models/klien_model.php */
