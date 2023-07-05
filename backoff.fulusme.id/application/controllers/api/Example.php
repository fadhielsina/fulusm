<?php
defined('BASEPATH') or exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'libraries/REST_Controller.php';
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        CI_Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class Example extends REST_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('BniEnc');
        // if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
        //     $this->auth->check_user_authentification(1);
        // }
        $this->load->model('data_model');
        $this->load->library('Tbswrapper');
        $this->load->library('customlib');
        $this->load->helper('download');
        $this->db_fulus = $this->load->database('fulusme', TRUE);
    }
    
    function coba_post()
    {
        $data = [
            'id' => $this->post('id'),
            'nama' => $this->post('nama')
            ];
        
        $this->response($data, REST_Controller::HTTP_OK);
    }

    function index_get()
    {
        $user = [
            "date" => date('Y-m-d H:i:s', strtotime("+ 2 year")),
            "message" => 'Success'
        ];
        $this->response($user, REST_Controller::HTTP_OK);
    }
    
}