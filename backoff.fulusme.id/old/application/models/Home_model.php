<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{

  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->identity_id = $this->session->userdata('IDENTITY_ID');
    }

    public function get_data_pendapatan()
	{
		return $this->db->query("SELECT sum(nilai) as tot_income FROM jurnal_detail
			LEFT JOIN akun ON akun.id = jurnal_detail.akun_id left join kelompok_akun on kelompok_akun.id=akun.kelompok_akun_id
			WHERE kelompok_akun.id='4'")->result();
	}


}
