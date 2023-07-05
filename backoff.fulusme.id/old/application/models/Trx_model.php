<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trx_model extends CI_Model
{

    var $data;
    private $db_fulus;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_fulus = $this->load->database('fulusme', TRUE);
    }
}
