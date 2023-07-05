<?php

class Menu_model extends CI_Model {

	var $data;
	var $details;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

	function get_menu($menu_akses=""){
		$respon = array("message"=>"","error"=>"1");
		$parent = $this->get_parent_menu();

		if(is_array($parent)){
			$menu = array();
			foreach($parent as $item){
				$menu[$item['nama_menu']]	= $item;
				$menu[$item['id_menu']] = 	$this->get_child_menu($item['id_menu'],$menu_akses);
			}

			$respon = array("message"=>"menu load sukses","data"=>$menu,"error"=>"");
		}else{
			$respon = array("message"=>"menu belum didaftarkan","data"=>"","error"=>"1");
		}

		return $respon;		
	}

	function get_parent_menu($menu_akses=""){
		$this->db->where(array("parent_menu"=>""));
		if(is_array($menu_akses)){
			$this->db->where_in("id_menu",$menu_akses);
		}
		$this->db->order_by("menu_order","ASC");

		return $this->db->get("m_menu")->result_array();
	}
	function get_child_menu($parent,$menu_akses=""){
		$this->db->where("parent_menu",$parent);
		if(is_array($menu_akses)){
			$this->db->where_in("id_menu",$menu_akses);
		}
		$this->db->order_by("menu_order","ASC");

		return $this->db->get("m_menu")->result_array();
	}

	
}