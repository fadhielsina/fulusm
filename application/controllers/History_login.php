<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History_login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }


    public function index()
    {
        $data['title'] = 'History Login';
        $data['allhistory'] = $this->db->get('history_login')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/top_bar', $data);
        $this->load->view('history_login', $data);
        $this->load->view('templates/footer');
    }
}
