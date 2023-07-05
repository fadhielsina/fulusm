<?php



class Mitra extends CI_Controller
{

    private $db_fulus;

    function __construct()
    {
        parent::__construct();;
        $this->load->library('auth');
        if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {

            $this->auth->check_user_authentification(1);
        }
        $this->db_fulus = $this->load->database('fulusme', TRUE);
        $this->load->model('sales_model');
        $this->load->model('user_model');
    }


    function index()
    {
        $data['title'] = "Koperasi / Mitra";
        $data['main_content'] = 'user/display_mitra';
        $data['mitra_data'] = $this->sales_model->getAllMitra();
        $this->load->view('template/template_xpanel', $data);
    }


    function add()
    {
        $data['title'] = "Tambah Koperasi / Mitra";
        $data['main_content'] = 'user/form_mitra';
        $data['user_data'] = FALSE;
        $this->load->view('template/template_xpanel', $data);
    }


    function insert()
    {
        $this->form_validation->set_rules('id_mitra', 'ID Mitra', 'required|trim');
        $this->form_validation->set_rules('nama_mitra', 'Nama Mitra', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->add();
        } else {
            $id_mitra = $this->input->post('id_mitra');
            $nama_mitra = $this->input->post('nama_mitra');
            $cek_id = $this->db_fulus->get_where('koperasi', ['id_koperasi' => $id_mitra])->row();
            if ($cek_id) {
                die('ID sudah terdaftar <br> <a href="' . base_url('mitra/') . '">Back</a>');
            } else {
                $data_mitra = [
                    'id_koperasi' => $id_mitra,
                    'nama_koperasi' => $nama_mitra
                ];
                $this->db_fulus->insert('koperasi', $data_mitra);
            }
            redirect('mitra/');
        }
    }


    function edit()
    {
        $id = $this->uri->segment(3);
        $this->form_validation->set_rules('id', 'ID', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit Koperasi / Mitra";
            $data['id'] = $id;
            $data['main_content'] = 'user/form_edit_mitra';
            $data['mitra'] = $this->sales_model->getMitra($id);
            $this->load->view('template/template_xpanel', $data);
        } else {
            $id = $this->input->post('id');
            $id_mitra = $this->input->post('id_mitra');
            $nama_mitra = $this->input->post('nama_mitra');

            $data_mitra = [
                'id_koperasi' => $id_mitra,
                'nama_koperasi' => $nama_mitra,
            ];
            $this->db_fulus->where('id_koperasi', $id);
            $this->db_fulus->update('koperasi', $data_mitra);

            redirect('mitra/');
        }
    }


    function delete()
    {
        $id = $this->uri->segment(3);
        $this->db_fulus->delete('koperasi', ['id_koperasi' => $id]);
        redirect('mitra');
    }
}

/* End of file user.php */

/* Location: ./application/CI_Controllers/user.php */
