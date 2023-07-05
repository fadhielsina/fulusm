<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master extends CI_Model {

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function tampil_trxpj_post_by_date()
	{
		$this->db->select('*');
		$this->db->select('SUM(as_sales_transactions.trxTotal) as totaltrx');
		$this->db->from('as_sales_transactions');
		$this->db->join('as_identity', 'as_sales_transactions.identityID = as_identity.identityID', 'left'); 
		$this->db->where_not_in('isPosting_status', 1);
		$this->db->group_by('as_sales_transactions.trxDate');
		$this->db->order_by('as_sales_transactions.trxDate','DESC');
		return $this->db->get();
	}
	
	public function get_identity_lists( $dropdown = false )
	{
		$this->db->select('identityID, identityName');
		$this->db->from('as_identity');

		if ( $dropdown ) {
			$data = $this->db->get()->result();
			if($data) {
				$akun = array();
				foreach ($data as $row) {
					$akun[$row->identityID] = $row->identityName;
				}
				return $akun;
			}
		}
		return $this->db->get()->result();
	}

	public function get_satuans() 
	{
		return $this->db->query("SELECT satuanID, satuanName FROM as_satuan")->result();
	}
	

}
