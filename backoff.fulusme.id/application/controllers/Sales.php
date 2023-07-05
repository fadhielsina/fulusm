<?php
class Sales extends CI_Controller
{
    function __construct()
    {
        parent::__construct();;
        $this->load->library('auth');
        if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
            $this->auth->check_user_authentification(1);
        }
        $this->load->model('sales_model');
        $this->load->model('user_model');
        // $this->lang->load('surplus_lang', get_cookie('my_lang'));
    }

    function index()
    {
        $data['title'] = "Sales Account";
        $data['main_content'] = 'user/display_sales';
        $data['user_data'] = $this->sales_model->getAllSales();
        $this->load->view('template/template_xpanel', $data);
    }

    function add()
    {
        $data['title'] = "Tambah Sales Akun";
        $data['main_content'] = 'user/form_sales';
        $data['user_data'] = FALSE;
        $this->load->view('template/template_xpanel', $data);
    }

    function insert()
    {
        $this->form_validation->set_rules('password1', 'Password Baru', 'required|trim|matches[password2]');
        $this->form_validation->set_rules('password2', 'Ulangi Passworrd', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->add();
        } else {
            $nama_depan = $this->input->post('nama_depan');
            $nama_belakang = $this->input->post('nama_belakang');
            $username = $this->input->post('username');
            $password = $this->input->post('password1');
            $no_hp = $this->input->post('no_hp');
            $no_ktp = $this->input->post('no_ktp');
            $alamat = $this->input->post('alamat');

            $data_login = [
                'identity_id' => 1,
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
                'username' => $username,
                'password' => md5($password),
                'administrator' => 0,
            ];
            $this->db->insert('login', $data_login);
            $lastID = $this->db->insert_id();

            $data_sales = [
                'login_id' => $lastID,
                'no_hp' => $no_hp,
                'no_ktp' => $no_ktp,
                'alamat' => $alamat
            ];
            $this->db->insert('sales_account', $data_sales);
            redirect('sales/');
        }
    }

    function edit()
    {
        $id = $this->uri->segment(3);
        $this->form_validation->set_rules('id', 'ID', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit Sales Akun";
            $data['id'] = $id;
            $data['main_content'] = 'user/form_edit_sales';
            $data['sales'] = $this->sales_model->getSales($id);
            $this->load->view('template/template_xpanel', $data);
        } else {
            $id = $this->input->post('id');
            $nama_depan = $this->input->post('nama_depan');
            $nama_belakang = $this->input->post('nama_belakang');
            $no_hp = $this->input->post('no_hp');
            $no_ktp = $this->input->post('no_ktp');
            $alamat = $this->input->post('alamat');
            $this->db->where('id', $id);
            $data_login = [
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
            ];
            $this->db->update('login', $data_login);
            $this->db->where('login_id', $id);
            $data_sales = [
                'no_hp' => $no_hp,
                'no_ktp' => $no_ktp,
                'alamat' => $alamat
            ];
            $this->db->update('sales_account', $data_sales);
            redirect('sales/');
        }
    }

    function view()
    {
        $id = $this->uri->segment(3);
        $data['title'] = $this->lang->line('lihat_pengguna');
        $data['main_content'] = 'user/form';
        $data['act'] = 'view';
        $data['form_act'] = '';
        $data['user_data'] = $this->user_model->get_data_by_id($id);
        $data['lokasi_data'] = $this->user_model->get_data_lokasi();
        $this->load->view('template/template_xpanel', $data);
    }

    function delete()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('sales_account', ['login_id' => $id]);
        $this->db->delete('login', ['id' => $id]);
        redirect('sales');
    }

    function _user_validation($edit = 0)
    {
        $this->form_validation->set_rules('fname', 'Nama Depan', 'trim|required');
        $this->form_validation->set_rules('lname', 'Nama Belakang', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        if ($edit) {
            $this->form_validation->set_rules('password', 'Password', 'trim|matches[cpassword]');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Ulangi Password', 'trim|required');
        }
        return $this->form_validation->run();
    }
}

/* End of file user.php */

/* Location: ./application/CI_Controllers/user.php */
