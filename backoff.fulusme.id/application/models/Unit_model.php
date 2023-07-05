<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_model extends CI_Model {

	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

	
	
	function get_all_data()
	{
		$this->db->select('*');
		$query = $this->db->get('as_identity');
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
		$this->db->select('*');
		$this->db->where('identityID', $id);
		$query = $this->db->get('as_identity');
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
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
	
	function fill_data()
	{
		$this->data = array(
			'identityCode' => $this->input->post('kdunit'),
			'identityName' => $this->input->post('nmunit'),
			'identityAddress' => $this->input->post('addrunit'),
			'identityPhone' => $this->input->post('hpunit'),
			'identityOwner' => $this->input->post('picunit'),
			'identityHead' => $this->input->post('ho_unit')
		);
		
	}
	
	function create_random($length)
	{
	    $data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $string = '';
	    for($i = 0; $i < $length; $i++) {
	        $pos = rand(0, strlen($data)-1);
	        $string .= $data{$pos};
	    }
	    return $string;
	}
	//Check for duplicate login ID
	function check_username($id = '')
	{
		$this->db->where('username', $this->data['username']);
		$this->db->where('aktif', 1);
		if($id != '') $this->db->where('id !=', $id);
		$query = $this->db->get('login');

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
		$insert = $this->db->insert('as_identity', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('identityID', $id);
		$update = $this->db->update('as_identity', $this->data);
		return $update;
	}

	function delete_data($id){
		$this->db->where('id', $id);
		$delete = $this->db->update('login', array('aktif' => 0));
		return $delete;
	}

}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
