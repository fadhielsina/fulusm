<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Athoshr_model extends CI_Model {
	public $table = "procurements";
	public $primary = "id";
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_all_data($condition)
	{
		if($condition !=""){
			$this->db->where($condition);
		}

		return $this->db->get($this->table);
		
		
	}

	
	function table_add($data){
		
		if ($this->db->insert($this->table,$data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}	
	}
	function table_update($id,$data){
		
		if(!$this->role_exists($id)){
			$this->table_add($data);
			return true;
		}else{
			$this->db->where($this->primary, $id);
			$this->db->update($this->table,$data);
			if($this->db->affected_rows() > 0)
			{	
				return true;
			} else {
				return "Tidak ada data yang diubah";
			}	
		}
	}
	function role_exists($id)
	{
		$this->db->where($this->primary, $id);
		$query = $this->db->get($this->table);
		
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
}
?>