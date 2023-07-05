<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pejabat_model extends CI_Model {

	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

	function get_all_data()
	{
		$this->db->select('*');
		$this->db->join('as_jabatan', 'as_jabatan.id_jabatan = master_pejabat.jabatan', 'left');
		$query = $this->db->get('master_pejabat');
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
		$this->db->where('id', $id);
		$query = $this->db->get('master_pejabat');
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
			'nama' => $this->input->post('nama'),
			'nip' => $this->input->post('nip'),
			'jabatan' => $this->input->post('jabatan')
		);
	}
	function insert_data()
	{
		$insert = $this->db->insert('master_pejabat', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('master_pejabat', $this->data);
		return $update;
	}

	function delete_data($id){
		$delete = $this->db->delete('master_pejabat', array('id' => $id));
		return $delete;
	}

}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
