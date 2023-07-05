<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Sales_model extends CI_Model

{



    var $data;

    private $db_fulus;



    public function __construct()

    {

        parent::__construct();

        $this->load->database();

        $this->db_fulus = $this->load->database('fulusme', TRUE);
    }



    public function getAllSales()

    {

        $this->db->select('sales_account.*, login.nama_depan, login.nama_belakang, login.username');

        $this->db->from('sales_account');

        $this->db->join('login', 'sales_account.login_id = login.id');

        return $this->db->get()->result();
    }



    public function getSales($id)

    {

        $this->db->select('sales_account.*, login.nama_depan, login.nama_belakang, login.username');

        $this->db->from('sales_account');

        $this->db->join('login', 'sales_account.login_id = login.id');

        $this->db->where('login.id', $id);

        return $this->db->get()->row();
    }

    function getAllMitra()
    {
        return $this->db_fulus->get('koperasi')->result();
    }

    function getMitra($id)
    {
        return $this->db_fulus->get_where('koperasi', ['id_koperasi' => $id])->row();
    }
}
