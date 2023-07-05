<?php

class Vehicles_model extends CI_Model {
	
	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function get_all_data(){
		$query = $this->db->get('as_vehicle_type');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	
 
    function search_cus($nama){
        $this->db->like('merk', $nama , 'both');
        $this->db->limit(10);
        return $this->db->get('as_vehicle_type')->result();
    }
 

	function get_data_by_id($id){
		$this->db->where('id', $id);
		$query = $this->db->get('as_vehicle_type');
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
		
		$this->data = array(
			'merk' => $this->input->post('merk'),		
			'type' => $this->input->post('type'),
			'series' => $this->input->post('series')
		);
	}
	
	
	
	//Check for duplicate login ID
	function check_name($id = '')
	{
		$this->db->where('merk', $this->data['merk']);
		if($id != '') $this->db->where('id !=', $id);
		$query = $this->db->get('as_vehicle_type');

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
		$insert = $this->db->insert('as_vehicle_type', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('as_vehicle_type', $this->data);
		return $update;
	}

	function delete_data($id){
		$this->db->where('id', $id);
		$delete = $this->db->delete('as_vehicle_type');
		return $delete;
	}

}

/* End of file klien_model.php */
/* Location: ./application/models/klien_model.php */
