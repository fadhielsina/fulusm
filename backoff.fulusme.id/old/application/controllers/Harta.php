<?php

class Harta extends CI_Controller
{

    function __construct()
    {
        parent::__construct();;
        $this->load->library('auth');
        if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
            $this->auth->check_user_authentification(1);
        }
        $this->load->model('harta_model');
        $this->load->model('akun_model');
        $this->load->model('model_master');
        $this->lang->load('surplus_lang', get_cookie('my_lang'));
    }

    function index()
    {
        redirect('harta/kelompok_harta');
    }

    function kelompok_harta()
    {
        $data['title'] = "Daftar Kelompok Harta Tetap";
        $data['main_content'] = 'harta/kelompok';
        $data['user_data'] = $this->harta_model->get_all_data();
        $this->load->view('template/template_xpanel', $data);
    }

    function add()
    {
        $data['title'] = "Tambah Kelompok Harta Tetap";
        $data['tipe'] = 'add';
        $data['main_content'] = 'harta/form_kelompok';
        $data['akun'] = $this->harta_model->get_all_akun();
        $this->load->view('template/template_xpanel', $data);
    }

    function form_insert()
    {
        $this->harta_model->insertData();
        redirect('harta/kelompok_harta');
    }

    function form_edit($id)
    {
        $this->harta_model->editData($id);
        redirect('harta/kelompok_harta');
    }

    function view()
    {
        $id = $this->uri->segment(3);
        $data['id'] = $id;
        $data['title'] = "Detail Kelompok Harta Tetap";
        $data['tipe'] = 'view';
        $data['tipe2'] = '-plaintext';
        $data['dis'] = 'disabled';
        $data['read'] = 'readonly';
        $data['data_harta'] = $this->db->get_where('kelompok_harta', ['id' => $id])->row();
        $data['akun_h'] = $this->db->get_where('akun', ['id' => $data['data_harta']->akun_harta])->row();
        $data['akun_a'] = $this->db->get_where('akun', ['id' => $data['data_harta']->akun_akumulasi])->row();
        $data['akun_d'] = $this->db->get_where('akun', ['id' => $data['data_harta']->akun_depresiasi])->row();
        $data['main_content'] = 'harta/form_kelompok';
        $this->load->view('template/template_xpanel', $data);
    }

    function edit()
    {
        $id = $this->uri->segment(3);
        $data['id'] = $id;
        $data['title'] = "Edit Kelompok Harta Tetap";
        $data['tipe'] = 'edit';
        $data['tipe2'] = '';
        $data['dis'] = '';
        $data['read'] = '';
        $data['data_harta'] = $this->db->get_where('kelompok_harta', ['id' => $id])->row();
        $data['akun_h'] = $this->db->get_where('akun', ['id' => $data['data_harta']->akun_harta])->row();
        $data['akun_a'] = $this->db->get_where('akun', ['id' => $data['data_harta']->akun_akumulasi])->row();
        $data['akun_d'] = $this->db->get_where('akun', ['id' => $data['data_harta']->akun_depresiasi])->row();
        $data['akun'] = $this->harta_model->get_all_akun();
        $data['main_content'] = 'harta/form_kelompok';
        $this->load->view('template/template_xpanel', $data);
    }

    function delete()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('kelompok_harta', ['id' => $id]);
        redirect('harta/kelompok_harta');
    }

    function pembelian_harta()
    {
        $data['title'] = "Daftar Pembelian Harta Tetap";
        $data['main_content'] = 'harta/daftar_pembelian';
        $data['user_data'] = $this->db->get_where('as_buy_transactions', ['is_fixed_asset' => 1])->result();
        $this->load->view('template/template_xpanel', $data);
    }

    function add_pembelian()
    {
        $data['title'] = "Tambah Pembelian Harta Tetap";
        $data['tipe'] = 'add';
        $data['main_content'] = 'harta/form_pembelian';
        $data['all_kas'] = $this->akun_model->get_all_kas_bank();
        $data['all_aset'] = $this->akun_model->get_aset_tetap();
        $data['all_utang'] = $this->akun_model->get_utang_akun();
        $data['kelompok_harta'] = $this->db->get_where('kelompok_harta', ['status' => 1])->result();
        $data['supplier'] = $this->db->get('as_suppliers')->result();
        $data['location'] = $this->model_master->get_identity_lists();
        $this->load->view('template/template_xpanel', $data);
    }

    public function form_insert_pembelian()
    {
        $this->harta_model->insert_data_pembelian_asset();

        $this->session->set_flashdata("message","Penambahan Asset Tetap Berhasil.");
        redirect('harta/pembelian_harta');
    }

    public function form_edit_pembelian()
    {
        $this->harta_model->edit_data_pembelian_asset();

        $this->session->set_flashdata("message","Edit Asset Tetap Berhasil.");
        redirect('harta/pembelian_harta');
    }

    public function view_pembelian( $id )
    {
        $data['title'] = "Lihat Pembelian Harta Tetap";
        $data['main_content'] = 'harta/view_pembelian';
        $data['data'] = $this->db->get_where('as_buy_transactions', ['trxID' => $id])->row();
        $data['detail'] = $this->db->get_where('as_buy_detail_transactions', ['invoiceBuyID' => $data['data']->invoiceBuyID ])->result();
        $this->load->view('template/template_xpanel', $data);
    }

    public function edit_pembelian( $id )
    {
        $data['title'] = "Edit Pembelian Harta Tetap";
        $data['main_content'] = 'harta/edit_pembelian';
        $data['data'] = $this->db->get_where('as_buy_transactions', ['trxID' => $id])->row();
        $data['detail'] = $this->db->get_where('as_buy_detail_transactions', ['invoiceBuyID' => $data['data']->invoiceBuyID ])->result();
        $data['all_kas'] = $this->akun_model->get_all_kas();
        $data['kelompok_harta'] = $this->db->get_where('kelompok_harta', ['status' => 1])->result();
        $data['supplier'] = $this->db->get('as_suppliers')->result();
        $data['location'] = $this->model_master->get_identity_lists();
        $this->load->view('template/template_xpanel', $data);
    }
}
/* End of file user.php */
/* Location: ./application/CI_Controllers/user.php */
