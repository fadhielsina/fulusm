<?php

class Jurnal_template_model extends CI_Model {

	var $data;
	var $details;

	public $table = 'tbl_jurnal_template';

	public $identity_id;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();

		$this->identity_id = $this->session->userdata('IDENTITY_ID');
    }

    public function get_all_data()
    {
    	$this->db->select('tbl_jurnal_template.*');
    	$this->db->where('identityID', $this->identity_id );
    	$this->db->from('tbl_jurnal_template');
    	
    	$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
    }

    public function fill_data()
	{
		$akun_data = array();
		$akun = $this->input->post('akun');
		$position = $this->input->post('position');
		$nilai = $this->input->post('nilai');
		$type_template = $this->input->post('type_template');

		foreach( $akun as $k => $val ) {
			$ak_data = array(
				'akun_id' => $val,
				'debit_kredit' => $position[ $k ]
			);
			if ( 2 == $type_template ) {
				$ak_data['nilai'] = $nilai[ $k ];
			}
			$akun_data[] = $ak_data;
		}
		$this->data = array(
			'nama_template' => $this->input->post('nama'),
			'type_template' => $type_template,
			'akun_data' => json_encode( $akun_data ),
			'identityID' => $this->identity_id
		);
	}
	
	public function insert_data()
	{
		$insert = $this->db->insert($this->table, $this->data);
		return $insert;
	}

	public function update_data($id)
	{
		$this->db->where('templateID', $id);
		$update = $this->db->update($this->table, $this->data);
		return $update;
	}

	public function delete_data($id){
		$delete = $this->db->delete($this->table, array('templateID' => $id));
		return $delete;
	}

	public function get_data_by_id($id)
	{
		$this->db->select('tbl_jurnal_template.*');
		$this->db->where('templateID', $id );
    	$this->db->from('tbl_jurnal_template');
    	
    	$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}
	
}
/* End of file jurnal_model.php */
/* Location: ./application/models/jurnal_model.php */
