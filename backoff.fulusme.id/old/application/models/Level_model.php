<?php

class Level_model extends CI_Model {

	var $data;
	public $table="as_level";
	public $primary="id_level";

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

	
	function get_all_data($condition="")
	{
		if($condition !=""){
			$this->db->where($condition);
		}
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	function get_data_by_id($id)
	{
		$this->db->where($this->primary, $id);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function insert_data($data)
	{
		$insert = $this->db->insert($this->table, $data);
		return $insert;
	}

	function update_data($id,$data)
	{
		$this->db->where($this->primary, $id);
		$update = $this->db->update($this->table, $data);
		return $update;
	}

	function delete_data($id){
		$this->db->where($this->primary, $id);
		$delete = $this->db->delete($this->table);
		return $delete;
	}

	function field_data(){
		$field = $this->db->field_data($this->table);
		
		return $field;
	}
	function check_username(){
		return true;
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
	function get_data_menu()
	{
		$this->db->select('*');
		$this->db->from('m_menu');
		$this->db->order_by('parent_menu',"DESC");
		$this->db->order_by('menu_ORDER',"ASC");
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
/* End of file Asset_model.php */
/* Location: ./application/models/Asset_model.php */
