<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model {

	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

	function validate_login($username, $password)
	{
		$this->db->select('as_identity.*');
		$this->db->select('login.*,as_level.*');
		$this->db->from('login');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'LEFT');
		$this->db->join('as_level', 'as_level.id_level=login.level_akses', 'LEFT');
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		$this->db->where('aktif', 1);
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_all_data()
	{
		$this->db->select('*');
		$this->db->where('aktif', 1);
		$this->db->join('as_level', 'as_level.id_level=login.level_akses', 'LEFT');
		$this->db->join('as_identity', 'as_identity.identityID=login.identity_id', 'LEFT');
		$this->db->order_by('as_identity.identityID', 'asc');
		$query = $this->db->get('login');
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
		$this->db->join('as_level', 'as_level.id_level=login.level_akses', 'LEFT');
		$query = $this->db->get('login');
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
			'nama_depan' => $this->input->post('fname'),
			'nama_belakang' => $this->input->post('lname'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'identity_id' => $this->input->post('lokasi'),
			'level_akses' => $this->input->post('level_akses'),
			'administrator' => $this->input->post('administrator'),
			'aktif' => 1
		);
		if($this->input->post('password')) {
			$this->data['password'] = md5($this->input->post('password'));
		}
		$resetpass=$this->input->post('reset_pass');

		if($resetpass=='1') {
			$username=$this->input->post('username');
			$new_pass = $this->data['password'];
			$this->data['password'] = ($new_pass);
			$this->session->set_flashdata('message', "<h4>Password Baru untuk user <b>".$username."</b> : <b>" . $this->input->post('password') . "</b></h4>");
		}
	}
	
	function create_random($length)
	{
	    $data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $string = '';
	    for($i = 0; $i < $length; $i++) {
	        $pos = rand(0, strlen($data)-1);
	        $string .= $data[$pos];
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
		$insert = $this->db->insert('login', $this->data);
		return $insert;
	}

	function update_data($id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('login', $this->data);
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
