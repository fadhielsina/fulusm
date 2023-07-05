<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aludi extends CI_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->library('auth');
        if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
            $this->auth->check_user_authentification(1);
        }
        $this->load->model('user_model');
        $this->load->model('level_model');
        $this->lang->load('surplus_lang', get_cookie('my_lang'));
        $this->db_fulus = $this->load->database('fulusme', TRUE);
    }

    function _sendEmail($id, $type = null)
    {
        $query = $this->db->get_where('aludi_penerbit', ['id' => $id])->row();
        $kode = $query->kode;
        $owner = $query->owner;
        $penerbit_email = $query->email;

        // Load library email dan konfigurasinya
        $config = $this->config->item('config_email');
        $this->email->initialize($config);
        $this->load->library('email', $config);

        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');
        $this->email->to('chesyah@fulusme.id, sinafadhiel@gmail.com');

        // Subject email
        $this->email->subject('Aludi Report');

        // Isi email
        $this->email->message('Aludi penerbit berhasil didaftarkan, dengan data : 
                            <br> Kode : ' . $kode . '
                            <br> Owner : ' . $owner . '
                            <br> Email : ' . $penerbit_email . '
                            <br> Silahkan klik link dibawah untuk melihat detailnya.
                            <br> <a href="' . base_url('Aludi/Penerbit/') . '">Go To Link</a>');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    function auth_token()
    {
        $this->db->order_by("date_expired", "DESC");
        $query_token = $this->db->get('aludi_token')->row();

        if ($query_token) :
            $expr_token = $query_token->date_expired;
            if (date('Y-m-d') < $expr_token) :
                return $query_token->token;
            endif;
        else :
            // set post fields
            $post = [
                'email' => 'chesyah@fulusme.id',
                'password' => 'Fulusm346'
            ];
            $ch = curl_init('https://aludi.id/index.php/api/v1/auth_api/refresh_token');
            // $ch = curl_init('https://aludi.id/index.php/api/test/auth_api/refresh_token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            // execute!
            $response = json_decode(curl_exec($ch));
            curl_close($ch);
            // do anything you want with your response
            $token = $response->data->token;
            $kode = $response->respon->kode;
            $kode_grup = $response->respon->kode_grup;

            $data = [
                'token' => $token,
                'kode' => $kode,
                'kode_group' => $kode_grup,
                'date_expired' =>  date('Y-m-d 23:59:00')
            ];
            $this->db->insert('aludi_token', $data);
            return $token;
        endif;
    }

    function penyelenggara_pulling()
    {
        $token = $this->auth_token();
        $kode_penerbit = $this->input->post('kode_penerbit');
        $id_provinsi = $this->input->post('id_provinsi');
        $id_industri = $this->input->post('id_industri');
        $kode_saham = $this->input->post('kode_saham');
        $jumlah_pemodal = $this->input->post('jumlah_pemodal');
        $saham_ditawarkan = $this->input->post('saham_ditawarkan');
        $saham_dihimpun = $this->input->post('saham_dihimpun');
        $jumlah_dividen = $this->input->post('jumlah_dividen');
        $saham_syariah_ditawarkan = $this->input->post('saham_syariah_ditawarkan');
        $saham_syariah_dihimpun = $this->input->post('saham_syariah_dihimpun');
        $sukuk_ditawarkan = $this->input->post('sukuk_ditawarkan');
        $sukuk_dihimpun = $this->input->post('sukuk_dihimpun');
        $pembagian_bunga = $this->input->post('pembagian_bunga');
        $tenor = $this->input->post('tenor');
        $tanggal_listed = $this->input->post('tanggal_listed');
        $tanggal_fully_funded = $this->input->post('tanggal_fully_funded');

        // A sample PHP Script to POST data using cURL
        $post_data = [
            'kode_penerbit' => $kode_penerbit,
            'id_provinsi' => $id_provinsi,
            'id_industri' => $id_industri,
            'kode_saham' => $kode_saham,
            'jumlah_pemodal' => $jumlah_pemodal,
            'saham_ditawarkan' => $saham_ditawarkan,
            'saham_dihimpun' => $saham_dihimpun,
            'jumlah_dividen' => $jumlah_dividen,
            'saham_syariah_ditawarkan' => $saham_syariah_ditawarkan,
            'saham_syariah_dihimpun' => $saham_syariah_dihimpun,
            'sukuk_ditawarkan' => $sukuk_ditawarkan,
            'sukuk_dihimpun' => $sukuk_dihimpun,
            'pembagian_bunga' => $pembagian_bunga,
            'tenor' => $tenor,
            'tanggal_listed' => $tanggal_listed,
            'tanggal_fully_funded' => $tanggal_fully_funded,
        ];

        // Prepare new cURL resource
        $crl = curl_init('https://aludi.id/api/v1/penyelenggara/pulling');
        // $crl = curl_init('https://aludi.id/api/test/penyelenggara/pulling');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

        // Set HTTP Header for POST request 
        curl_setopt(
            $crl,
            CURLOPT_HTTPHEADER,
            array(
                'Token: ' . $token
            )
        );

        // Submit the POST request
        $response = json_decode(curl_exec($crl));
        $pesan = $response->pesan;
        curl_close($crl);

        if ($response->data) :
            $post_data['date_created'] = time();
            $this->db->insert('aludi_penyelenggara', $post_data);
        endif;

        foreach ($pesan as $row) :
            $this->session->set_flashdata('message', $row);
            $this->penyelenggara_add();
        endforeach;
    }

    function penerbit_create()
    {
        $token = $this->auth_token();
        $owner = $this->input->post('owner');
        $nomor_tlp = $this->input->post('nomor_tlp');
        $email = $this->input->post('email');
        $nama_perusahaan = $this->input->post('nama_perusahaan');
        $nama_brand = $this->input->post('nama_brand');
        $bidang_usaha = $this->input->post('bidang_usaha');
        // $total_pendanaan = $this->input->post('total_pendanaan');
        $total_pendanaan = intval(str_replace(',', '', $this->input->post('total_pendanaan')));
        $status = $this->input->post('status');
        $deskripsi = $this->input->post('deskripsi');

        // A sample PHP Script to POST data using cURL
        $post_data = [
            'owner' => $owner,
            'nomor_telepon' => $nomor_tlp,
            'email' => $email,
            'nama_perusahaan' => $nama_perusahaan,
            'nama_brand' => $nama_brand,
            'bidang_usaha' => $bidang_usaha,
            'total_pendanaan' => $total_pendanaan,
            'status' => $status,
            'deskripsi' => $deskripsi,
        ];

        // Prepare new cURL resource
        $crl = curl_init('https://aludi.id/index.php/api/v1/penerbit/created');
        // $crl = curl_init('https://aludi.id/index.php/api/test/penerbit/created');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

        // Set HTTP Header for POST request 
        curl_setopt(
            $crl,
            CURLOPT_HTTPHEADER,
            array(
                'Token: ' . $token
            )
        );

        // Submit the POST request
        $response = json_decode(curl_exec($crl));
        $pesan = $response->pesan;
        curl_close($crl);

        if ($response->data) :
            $post_data['kode'] = $response->data->kode;
            $post_data['date_created'] = time();
            $this->db->insert('aludi_penerbit', $post_data);
            $insert_id = $this->db->insert_id();
            $this->_sendEmail($insert_id, $type = 'penerbit');
        endif;

        foreach ($pesan as $row) :
            $this->session->set_flashdata('message', $row);
            $this->penerbit_add();
        endforeach;
    }

    function penerbit_update()
    {
        $token = $this->auth_token();
        $kode = $this->input->post('kode');
        $owner = $this->input->post('owner');
        $nomor_tlp = $this->input->post('nomor_tlp');
        $email = $this->input->post('email');
        $nama_perusahaan = $this->input->post('nama_perusahaan');
        $nama_brand = $this->input->post('nama_brand');
        $bidang_usaha = $this->input->post('bidang_usaha');
        $total_pendanaan = $this->input->post('total_pendanaan');
        $status = $this->input->post('status');
        $deskripsi = $this->input->post('deskripsi');

        // A sample PHP Script to POST data using cURL
        $post_data = [
            'kode' => $kode,
            'owner' => $owner,
            'nomor_telepon' => $nomor_tlp,
            'email' => $email,
            'nama_perusahaan' => $nama_perusahaan,
            'nama_brand' => $nama_brand,
            'bidang_usaha' => $bidang_usaha,
            'total_pendanaan' => $total_pendanaan,
            'status' => $status,
            'deskripsi' => $deskripsi,
        ];

        // Prepare new cURL resource
        $crl = curl_init('https://aludi.id/index.php/api/v1/penerbit/updated');
        // $crl = curl_init('https://aludi.id/index.php/api/test/penerbit/updated');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

        // Set HTTP Header for POST request 
        curl_setopt(
            $crl,
            CURLOPT_HTTPHEADER,
            array(
                'Token: ' . $token
            )
        );

        // Submit the POST request
        $response = json_decode(curl_exec($crl));
        $pesan = $response->pesan;
        curl_close($crl);

        if ($response->data) :
            $this->db->update('aludi_penerbit', $post_data, ['kode' => $kode]);
        endif;

        foreach ($pesan as $row) :
            $this->session->set_flashdata('message', $row);
            $this->penerbit_add();
        endforeach;
    }

    function penerbit_update_status()
    {
        $token = $this->auth_token();
        $kode = $this->input->post('kode');
        $status = $this->input->post('status');

        // A sample PHP Script to POST data using cURL
        $post_data = [
            'kode' => $kode,
            'status' => $status,
        ];

        // Prepare new cURL resource
        $crl = curl_init('https://aludi.id/index.php/api/v1/penerbit/updated_status');
        // $crl = curl_init('https://aludi.id/index.php/api/test/penerbit/updated_status');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

        // Set HTTP Header for POST request 
        curl_setopt(
            $crl,
            CURLOPT_HTTPHEADER,
            array(
                'Token: ' . $token
            )
        );

        // Submit the POST request
        $response = json_decode(curl_exec($crl));
        $pesan = $response->pesan;
        curl_close($crl);

        if ($response->data) :
            $this->db->update('aludi_penerbit', $post_data, ['kode' => $kode]);
        endif;

        foreach ($pesan as $row) :
            $this->session->set_flashdata('message', $row);
            $this->penerbit_add();
        endforeach;
    }

    function penerbit_list()
    {
        $token = $this->auth_token();
        // A sample PHP Script to POST data using cURL

        // Prepare new cURL resource
        $crl = curl_init('https://aludi.id/index.php/api/v1/penerbit/list_view');
        // $crl = curl_init('https://aludi.id/index.php/api/test/penerbit/list_view');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

        // Set HTTP Header for POST request 
        curl_setopt(
            $crl,
            CURLOPT_HTTPHEADER,
            array(
                'Token: ' . $token
            )
        );

        // Submit the POST request
        $response = json_decode(curl_exec($crl));
        curl_close($crl);
        // var_dump($response);
        return $response->data;
    }

    function penerbit()
    {
        $data['title'] = "Aludi Penerbit";
        $data['main_content'] = 'laporan_aludi/display_penerbit';
        $data['penerbit_data'] = $this->db->select('*')->from('aludi_penerbit')
            ->join('aludi_status', 'aludi_penerbit.status = aludi_status.id_status')->get()->result();;
        $this->load->view('template/template_xpanel', $data);
    }

    function penerbit_add()
    {
        $data['title'] = "Aludi / Tambah Penerbit";
        $data['main_content'] = 'laporan_aludi/form_penerbit';
        $data['aludi_status'] = $this->db->get('aludi_status')->result();
        $data['user_data'] = FALSE;
        $this->load->view('template/template_xpanel', $data);
    }

    function penerbit_edit()
    {
        $kode = $this->uri->segment(3);
        $query = $this->db->select('*')->from('aludi_penerbit')
            ->join('aludi_status', 'aludi_penerbit.status = aludi_status.id_status')
            ->where('aludi_penerbit.kode', $kode)->get()->row();
        $data['title'] = "Aludi / Edit Penerbit";
        $data['penerbit'] = $query;
        $data['main_content'] = 'laporan_aludi/form_edit_penerbit';
        $data['user_data'] = FALSE;
        $this->load->view('template/template_xpanel', $data);
    }

    function penerbit_edit_status()
    {
        $kode = $this->uri->segment(3);
        $query = $this->db->select('*')->from('aludi_penerbit')
            ->join('aludi_status', 'aludi_penerbit.status = aludi_status.id_status')
            ->where('aludi_penerbit.kode', $kode)->get()->row();
        $data['title'] = "Aludi / Edit Status Penerbit";
        $data['penerbit'] = $query;
        $data['aludi_status'] = $this->db->get('aludi_status')->result();
        $data['main_content'] = 'laporan_aludi/form_edit_status_penerbit';
        $data['user_data'] = FALSE;
        $this->load->view('template/template_xpanel', $data);
    }

    function penyelenggara()
    {
        // $data['title'] = "Aludi Penyelenggara";
        // $data['main_content'] = 'laporan_aludi/display_penyelenggara';
        // $data['penerbit_data'] = $this->db->select('*')->from('aludi_penerbit')
        //     ->join('aludi_status', 'aludi_penerbit.status = aludi_status.id_status')->get()->result();;
        // $this->load->view('template/template_xpanel', $data);

        $this->penyelenggara_add();
    }

    function penyelenggara_add()
    {
        $field = [
            'label' => ['Kode Penerbit', 'Id Provinsi', 'Id Industri', 'Kode Saham', 'Jumlah Pemodal', 'Saham Ditawarkan', 'Saham Dihimpun', 'Jumlah Dividen', 'Saham Syariah Ditawarkan', 'Saham Syariah Dihimpun', 'Sukuk Sitawarkan', 'Sukuk Dihimpun', 'Pembagian Bunga', 'Tenor', 'Tanggal Listed', 'Tanggal Fully Funded'],
            'type_form' => ['text', 'number', 'number', 'text', 'number', 'number', 'number', 'number', 'number', 'number', 'number', 'number', 'number', 'number', 'date', 'date'],
            'idname' => ['kode_penerbit', 'id_provinsi', 'id_industri', 'kode_saham', 'jumlah_pemodal', 'saham_ditawarkan', 'saham_dihimpun', 'jumlah_dividen', 'saham_syariah_ditawarkan', 'saham_syariah_dihimpun', 'sukuk_ditawarkan', 'sukuk_dihimpun', 'pembagian_bunga', 'tenor', 'tanggal_listed', 'tanggal_fully_funded']
        ];

        $data['title'] = "Aludi / Tambah Penyelenggara";
        $data['main_content'] = 'laporan_aludi/form_penyelenggara';
        $data['field'] = $field;
        $data['user_data'] = FALSE;
        $this->load->view('template/template_xpanel', $data);
    }
}
