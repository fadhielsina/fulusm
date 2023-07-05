<?php 
class UploadFoto extends CI_Controller
{
    function __construct()
    {
    parent::__construct();
    //load Helper for Form
    $this->load->helper('url', 'form'); 
    $this->load->library('form_validation');
    }
    function index()
    {
        $this->load->view('image_upload_form');
    }
    public function upload() 
    {
        $config['upload_path'] = '../assets/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2000;
 
 
        $this->load->library('upload', $config);
 
        if (!$this->upload->do_upload('profile_pic')) 
        {
            $error = array('error' => $this->upload->display_errors());
 
            var_dump($error);
        } 
        else 
        {
            $data = array('image_metadata' => $this->upload->data());
 
            echo "berhasil";
        }
    }
 
}
?>