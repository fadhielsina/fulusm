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

class Fulusme extends REST_Controller
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

    function index_get()
    {
        $user = [
            "date" => date('Y-m-d H:i:s', strtotime("+ 2 year")),
            "message" => 'Success'
        ];

        $this->test_second();
        $this->response($user, REST_Controller::HTTP_OK);
    }

    function test_second()
    {
        // konfigurasi email server
        $config = $this->config->item('config_email');
        $this->email->initialize($config);

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');
        $this->email->to("sinafadhiel@gmail.com");

        // Subject email
        $this->email->subject('Confirm Payment');

        // Isi email
        $this->email->message('Test');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    function frontfulusme_post()
    {
        $test = $this->post('test');
        $this->response(['message' => $test], REST_Controller::HTTP_OK);
    }

    function hari_ini()
    {
        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;
            case 'Mon':
                $hari_ini = "Senin";
                break;
            case 'Tue':
                $hari_ini = "Selasa";
                break;
            case 'Wed':
                $hari_ini = "Rabu";
                break;
            case 'Thu':
                $hari_ini = "Kamis";
                break;
            case 'Fri':
                $hari_ini = "Jumat";
                break;
            case 'Sat':
                $hari_ini = "Sabtu";
                break;
            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }
        return $hari_ini;
    }

    function tokenAPI($data)
    {
        $client_id = 'd5030099-6884-4968-9d2e-71436ecea566';
        $secret_key = 'f7a0a209-9a19-4e49-a36f-eac18990dc8f';

        $xtimetamp = date('Y-m-d\TH:i:s+07:00');
        $signature = $client_id . '|' . $xtimetamp;
        $h_signature = hash_hmac('sha256', $signature); //sementara di dokumen hanya 1 yg di hash
        $h_signature = hash_hmac('sha256', $signature, $other_parameter); //ini fungsi untuk hash sha256 parameternya 2

        $curl = curl_init('url_to_post');
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.danamon.co.id/api/oauth/token');
        curl_setopt($curl, CURLOPT_POST, 1);
        $headers = array(
            'X-TIMESTAMP:' . $auth,
            'Content-Type:application/x-www-form-urlencoded',
            ''
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
            'grant_type' => 'client_credentials'
        )));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);

        curl_close($curl);
        $api = json_decode($response, true);
        //      $this->response($api, REST_Controller::HTTP_OK);
        // var_dump($api['access_token']);
        if ($this->db->insert('virtual_account', ['username_password' => $auth, 'access_token' => 'Bearer ' . $api['access_token']])) :
            $last_id = $this->db->insert_id();
            $this->generateVA($last_id, $api['access_token'], $data);
        endif;
    }

    function create_virtual_account_old($data)
    {
        $client_id = 'd5030099-6884-4968-9d2e-71436ecea566';
        $secret_key = 'f7a0a209-9a19-4e49-a36f-eac18990dc8f';
        $auth = base64_encode("$client_id:$secret_key");
        $xtimetamp = date('Y-m-d\TH:i:s+07:00');

        $curl = curl_init('url_to_post');
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.danamon.co.id/api/oauth/token');
        curl_setopt($curl, CURLOPT_POST, 1);
        $headers = array(
            'Authorization: Basic ' . $auth,
            'Content-Type:application/x-www-form-urlencoded'
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
            'grant_type' => 'client_credentials'
        )));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);

        curl_close($curl);
        $api = json_decode($response, true);
        //      $this->response($api, REST_Controller::HTTP_OK);
        // var_dump($api['access_token']);
        if ($this->db->insert('virtual_account', ['username_password' => $auth, 'access_token' => 'Bearer ' . $api['access_token']])) :
            $last_id = $this->db->insert_id();
            $this->generateVA($last_id, $api['access_token'], $data);
        endif;
    }

    function generateVA($last_id = '', $auth = '', $data_front)
    {
        $id_project = $data_front['project_id'];
        $customer_name = $data_front['customer_name'];
        $customer_phone = $data_front['customer_phone'];
        $trx_amount = $data_front['trx_amount'];

        if (strlen($customer_phone) > 12) :
            $phone_to_va = substr("$customer_phone", 1, 12);
        elseif (strlen($customer_phone) < 12) :
            $phone_to_va = str_pad($customer_phone, 12, '0');
        else :
            $phone_to_va = $customer_phone;
        endif;

        $api_key = '2a733b16-0670-46d5-958b-bb30b8712b70';
        // $auth = 'AUsBrf6pj2TZRsKSB6gejo8Xx3FRPtdMM2Ye1KK2ArUx2K3bmxcXLz6a';
        $bdi_signature = 'f4e4d374c813fd1689bdb1bf1f51653f';
        $bdi_timestamp = date('Y-m-d', strtotime('-7 hour')) . "T" . date('H:i:s', strtotime('-7 hour')) . ".126Z";
        $req_time = date('YmdHis', time());
        $exp_time = date('YmdHis', strtotime('+2 years'));

        $curl = curl_init('url_to_post');
        curl_setopt($curl, CURLOPT_URL, 'https://sandbox.danamon.co.id/v1/api/productcreation/va/createva');
        curl_setopt($curl, CURLOPT_POST, 1);

        $headers = array(
            'Authorization: Bearer ' . $auth,
            'Content-Type:application/json',
            'BDI-Signature:' . $bdi_signature . '',
            'BDI-Key:' . $api_key . '',
            'BDI-Timestamp:' . $bdi_timestamp . ''
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            "UserReferenceNumber" => "1200123456784321",
            "RequestTime" => "$req_time",
            "VirtualAccountNumber" => '7675' . $phone_to_va,
            "VirtualAccountName" => "$customer_name",
            "VirtualAccountExpiryDate" => "$exp_time"
        )));

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $api = json_decode($response, true);
        if ($code == 200) :
            $virtual_account = $api['VirtualAccountNumber'];
            $data = [
                'user_ref_no' => $api['UserReferenceNumber'],
                'response_time' => $api['ResponseTime'],
                'virtual_account' => $api['VirtualAccountNumber'],
                'code_status' => $api['CodeStatus'],
                'description' => $api['DescriptionStatus'],
                'exp_time' => $exp_time,
                'trx_amount' => $trx_amount,
                'va_name' => $customer_name,
                'time_created' => time(),
                'id_project' => $id_project
            ];
            $this->db->update('virtual_account', $data, ['id' => $last_id]);
            $this->db->update('virtual_account', ['response_code' => '00000'], ['id' => $last_id]);
            // $this->insert_pendanaan($data_front, $virtual_account);
            // var_dump($api);
            $this->response($data, REST_Controller::HTTP_OK);
        endif;
    }

    function create_va_post()
    {
        $data = [
            'project_id' => $this->post('project_id'),
            'customer_id' => $this->post('customer_id'),
            'customer_name' => $this->post('customer_name'),
            'customer_phone' => $this->post('customer_phone'),
            'customer_email' => $this->post('customer_email'),
            'trx_amount' => $this->post('trx_amount'),
            'total_lot' => $this->post('total_lot'),
            'borrower_id' => $this->post('borrower_id'),
            'type_project' => $this->post('type_project')
        ];
        if ($data['type_project'] == 'retail') {
            $cek = $this->db_fulus->get_where('project_retail', ['id_project' => $data['project_id']])->row();
        } else {
            $cek = $this->db_fulus->get_where('project', ['id' => $data['project_id']])->row();
        }
        if ($cek) {
            // $this->set_response($data, REST_Controller::HTTP_CREATED);
            $this->create_virtual_account($data);
        } else {
            echo "ID Project tidak tersedia, silahkan periksa ID Project yang tersedia.";
        }
    }

    function create_virtual_account($data_front)
    {
        $id_project = $data_front['project_id'];
        $customer_name = $data_front['customer_name'];
        $customer_phone = $data_front['customer_phone'];
        $customer_email = $data_front['customer_email'];
        $customer_id = $data_front['customer_id'];
        $total_lot = $data_front['total_lot'];
        $borrower_id = $data_front['borrower_id'];
        $type_project = $data_front['type_project'];
        $trx_amount = $data_front['trx_amount'];

        if (strlen($customer_phone) > 12) :
            $phone_to_va = substr("$customer_phone", 1, 12);
        elseif (strlen($customer_phone) < 12) :
            $phone_to_va = str_pad($customer_phone, 12, '0');
        else :
            $phone_to_va = $customer_phone;
        endif;

        $virtual_account = '7675' . $phone_to_va;
        $exp_time = date('YmdHis', strtotime('+2 years'));

        $cek_va = $this->db->select('*')->from('virtual_account')
            ->where('virtual_account', $virtual_account)
            ->where('response_code', '000000')
            ->get();

        if ($cek_va->num_rows() < 1) :
            $data = [
                'virtual_account' => $virtual_account,
                'description' => 'Pendaan Project ' . $id_project,
                'exp_time' => $exp_time,
                'trx_amount' => $trx_amount,
                'va_name' => $customer_name,
                'time_created' => time(),
                'id_project' => $id_project,
                'response_code' => '000000',
                'customer_phone' => $customer_phone,
                'customer_email' => $customer_email,
                'customer_id' => $customer_id,
                'total_lot' => $total_lot,
                'borrower_id' => $borrower_id,
                'type_project' => $type_project
            ];
            $this->db->insert('virtual_account', $data);
            $virtual_id = $this->db->insert_id();
            $this->insert_pendanaan($data_front, $virtual_account, $virtual_id);
            // var_dump($api);
            $this->response($data, REST_Controller::HTTP_OK);
        else :
            $data = [
                'virtual_account' => $cek_va->row()->virtual_account,
                'trx_amount' => $cek_va->row()->trx_amount,
                'id_project' => $cek_va->row()->id_project,
                'response_code' => null,
            ];
            $this->response($data, REST_Controller::HTTP_OK);
        endif;
    }

    function insert_pendanaan($data_front, $va, $virtual_id)
    {
        $customer_id = $data_front['customer_id'];
        $trx_amount = $data_front['trx_amount'];
        $project_id = $data_front['project_id'];
        $id_peminjam = $data_front['borrower_id'];
        $jenis_pendanaan = $data_front['type_project'];
        $total_lot = $data_front['total_lot'];

        $data = [
            'project_id' => $project_id,
            'peminjam_id' => $id_peminjam,
            'pendana_id' => $customer_id,
            'nominal' => $trx_amount,
            'status' => 0,
            'create_ts' => strtotime("now"),
            'pending_ts' => strtotime('+3 hours', time()),
            'nomor_va' => $va,
            'jenis_pendanaan' => $jenis_pendanaan,
            'total_lot' => $total_lot
        ];
        if ($this->db_fulus->insert('pendanaan', $data)) :
            $pendanaan_id = $this->db_fulus->insert_id();
            $this->db->update('virtual_account', ['pendanaan_id' => $pendanaan_id], ['id' => $virtual_id]);
            $sisa = $this->db_fulus->get_where('pendana', ['id' => $customer_id])->row()->sisa_pendanaan;
            $sisa_kuota = $sisa - $trx_amount;
            $this->db_fulus->update('pendana', ['sisa_pendanaan' => $sisa_kuota], ['id' => $customer_id]);
            $this->create_akad_confrim_new($pendanaan_id, $data_front);
        endif;
    }

    function create_akad_confrim_new($pendanaan_id, $data_send)
    {
        $query = $this->db_fulus->get_where('pendanaan', ['id' => $pendanaan_id])->row();
        $id_user = $query->pendana_id;
        $id_project = $query->project_id;
        $no_va = $query->nomor_va;
        $query2 = $this->db_fulus->get_where('pendana', ['id' => $id_user])->row();
        $query3 = $this->db->get_where('history_project', ['id' => $id_project])->row();

        $tgl = date('d');
        $hari_ini = $this->hari_ini();
        $tahun = date('Y');
        $bulan = $this->customlib->get_month_name(date('m'));
        $tanggal = "$hari_ini, $tgl $bulan $tahun";

        $nama_pendana = $query2->full_name;
        $modal = number_format($query3->modal_project);
        $harga_perlembar = number_format($query3->harga_perlembar_shm);
        $trblg_harga_perlembar = '( ' . terbilang(intval(str_replace(',', '', $harga_perlembar))) . ' )';
        $tgl_jatuh_tempo = date('Y-m-d', strtotime("+6 month", strtotime(date('y-m-d'))));
        $trblg_modal = '( ' . terbilang(intval(str_replace(',', '', $modal))) . ' )';
        $jumlah_lot = $data_send['total_lot'];
        $trblg_jumlah_lot = '( ' . terbilang_lot(intval(str_replace(',', '', $jumlah_lot))) . ' )';
        $ktp_pendana = "$query2->ktp";
        $no_rek_pendana = $query2->bank_number;
        $nama_bank_pendana = "$query2->bank_account_name";
        $email_pendana = $query2->email;

        $template = FCPATH . 'assets/Aqad_pendana_new.docx';

        $data['GeneratedFileName'] = "Surat_perjanjian$id_user.docx"; // nama file untuk dokumen yang digenerate
        $data['folderGenerated'] = "assets/pdf"; // nama folder untuk menyimpan hasil generate dokumen
        $userData[0]['tgl'] = "$tanggal";
        $userData[0]['no_va'] = "$no_va";
        // Project
        $userData[0]['id_project'] = "$id_project";
        $userData[0]['modal'] = "$modal";
        $userData[0]['jumlah_lot'] = "$jumlah_lot";
        $userData[0]['trblg_modal'] = "$trblg_modal";
        $userData[0]['trblg_jumlah_lot'] = "$trblg_jumlah_lot";
        $userData[0]['harga_perlembar'] = "$harga_perlembar";
        $userData[0]['trblg_harga_perlembar'] = "$trblg_harga_perlembar";
        // Uer Pendana 
        $userData[0]['nama_pendana'] = "$nama_pendana";
        $userData[0]['id_pendana'] = "$id_user";
        $userData[0]['email_pendana'] = "$email_pendana";
        $userData[0]['ktp_pendana'] = "$ktp_pendana";
        $userData[0]['no_rek_pendana'] = "$no_rek_pendana";
        $userData[0]['nama_bank_pendana'] = "$nama_bank_pendana";
        // Pendanaan 
        $userData[0]['tgl_perjanjian'] = "$tanggal";
        $userData[0]['tgl_jatuh_tempo'] = "$tgl_jatuh_tempo";

        $this->tbswrapper->tbsLoadTemplate($template);
        $this->tbswrapper->namafile = $data['GeneratedFileName'];
        $this->tbswrapper->folder = FCPATH . $data['folderGenerated'] . "/";
        $this->tbswrapper->tbsMergeField('vars', $userData);
        $this->tbswrapper->tbsMergeBlock('user', $userData);

        if ($this->tbswrapper->tbsRender()) {
            // force_download(FCPATH . "" . $data['folderGenerated'] . "/\\" . $data['GeneratedFileName'], NULL);
            force_download('./assets/pdf/' . $data['GeneratedFileName'], NULL);
            $this->_sendEmail($data_send, $no_va);
        } else {
            $this->session->set_flashdata('message', lang('error_generate_dokumen'));
            redirect('home');
        }
    }

    function _sendEmail($data_send, $va)
    {
        $id_project = $data_send['project_id'];
        $id_user = $data_send['customer_id'];
        $name_user = $data_send['customer_name'];
        $email_user = $data_send['customer_email'];
        $phone_user = $data_send['customer_phone'];
        $trx_amount = $data_send['trx_amount'];
        $total_lot = $data_send['total_lot'];
        $project = $this->db_fulus->select('*')->from('project')->where('id', $id_project)->where('version', 1)->get()->row();
        if ($project) {
            $nama_project = $project->nama_project;
        } else {
            $nama_project = "Project Retail";
        }
        // konfigurasi email server
        $config = $this->config->item('config_email');
        $this->email->initialize($config);
        // Load library email dan konfigurasinya
        $this->load->library('email', $config);
        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');
        $this->email->to("$email_user, sinafadhiel@gmail.com");
        // Lampiran email, isi dengan url/path file
        // $this->email->attach('./assets/pdf/\Wakala_pendana' . $id_user . '.docx');
        $this->email->attach('./assets/pdf/\Surat_perjanjian' . $id_user . '.docx');
        // Subject email
        $this->email->subject('Project Funding');
        // Isi email
        $this->email->message('Terimakasih Anda telah bersedia menjadi Pemodal di Fulusme SCF,
        berikut kami sampaikan informasi mengenai rincian pemodalan yang telah Anda pilih: <br><br>
        <b>Nomor VA : ' . $va . '</b><br>
        <b>Nama Proyek / ID : ' . $nama_project . ' / ' . $id_project . '</b><br>
        <b>Kode Saham : ' . $project->code_saham_alias . ' </b><br>
        <b>Nama : ' . $name_user . ' </b><br>
        <b>ID Pemodal : ' . $id_user . '</b><br>
        <b>Email : ' . $email_user . '</b><br>
        <b>Telepon : ' . $phone_user . '</b><br>
        <b>Total Tagihan : Rp. ' . number_format($trx_amount) . ' </b><br>
        <b>Jumlah LOT : ' . $total_lot . ' </b><br>
        <b>Batas Waktu Pembayaran : Sebelum ' . date("H:i:s", strtotime('+3 hour')) . ' </b><br>
        Silahkan lakukan pembayaran menggunakan Nomor VA <b>' . $va . '</b> melalui channel Danamon sebelum batas waktu pembayaran diatas.
        <br><br>
        Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2555-8986 WA: XXXXXXXXXXX Email:info@fulusme.id
        ');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            // set post fields
            $post = [
                'id_project' => $id_project,
                'va' => $va,
                'trx_amount'   => $trx_amount,
                'phone_user' => $phone_user,
                'code_saham' => $project->code_saham_alias
            ];

            $ch = curl_init('http://178.128.124.100/api_mobile/api/example/sendSms');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            // execute!
            $response = curl_exec($ch);
            // close the connection, release resources used
            curl_close($ch);
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    function url_inquiry_post()
    {
        $service_code = $this->post('service_code');
        $user_ref_no = $this->post('user_ref_no');
        $bin_no = $this->post('bin_no');
        $va_no = $this->post('va_no');
        $auth_code = $this->post('auth_code');
        $key = 'BD1U@TfulU5m3';

        $str = $service_code . $user_ref_no . $bin_no . $va_no . $key;
        $auth_code_cek = hash('sha256', $str);

        $cek_va = $this->db->select('*')->from('virtual_account')
            ->where('virtual_account', $va_no)
            ->order_by('id', 'DESC')
            ->limit(1)->get();
        $cek_inquiry = $this->db->select('*')->from('va_inquiry')
            ->where('va_no', $va_no)
            ->order_by('id', 'DESC')
            ->limit(1)->get();

        if ($cek_va->num_rows() < 1) :
            // Jika nomor VA tidak ada 
            $va_name = null;
            $trx_amount = null;
            $data_response = [
                'service_code' => $service_code,
                'user_ref_no' => $user_ref_no,
                'bin_no' => $bin_no,
                'bin_title' => "Fulusme",
                'va_no' => $va_no,
                'va_name' => $va_name,
                'bill_amount' => $trx_amount . ".00",
                'response_code' => "000100",
                'auth_code' => $auth_code_cek,
                'flg_pay' => "F"
            ];
            $this->response($data_response, REST_Controller::HTTP_OK);
        else :
            // Jika nomor VA ada 
            $data = [
                'service_code' => $service_code,
                'user_ref_no' => $user_ref_no,
                'bin_no' => $bin_no,
                'va_no' => $va_no,
                'auth_code_req' => $auth_code,
                'time_response' => time()
            ];
            $this->db->insert('va_inquiry', $data);

            $last_id = $this->db->insert_id();
            $last_id_va = $cek_va->row()->id;
            $va_name = $cek_va->row()->va_name;
            $trx_amount = $cek_va->row()->trx_amount;
            // Cek expired 
            if ($cek_va->row()->exp_time < time()) :
                $response_code = '000102';
            else :
                $response_code = $cek_va->row()->response_code;
            endif;

            $data_response = [
                'service_code' => $service_code,
                'user_ref_no' => $user_ref_no,
                'bin_no' => $bin_no,
                'bin_title' => "Fulusme",
                'va_no' => $va_no,
                'va_name' => $va_name,
                'bill_amount' => $trx_amount . ".00",
                'response_code' => $response_code,
                'auth_code' => $auth_code_cek,
                'flg_pay' => "F"
            ];
            $this->db->update('va_inquiry', $data_response, ['id' => $last_id]);
            $this->db->update('virtual_account', ['response_code' => $response_code], ['id' => $last_id_va]);
            $this->response($data_response, REST_Controller::HTTP_OK);
        endif;
    }

    function payment_post()
    {
        $service_code = $this->post('service_code');
        $user_ref_no = $this->post('user_ref_no');
        $bin_no = $this->post('bin_no');
        $bin_title = $this->post('bin_title');
        $va_no = $this->post('va_no');
        $va_name = $this->post('va_name');
        $bill_amount = $this->post('bill_amount');
        $pay_amount = $this->post('pay_amount');
        $pay_account = $this->post('pay_account');
        $pay_bank = $this->post('pay_bank');
        $pay_desc = $this->post('pay_desc');
        $auth_code = $this->post('auth_code');
        $trx_amount = number_format($bill_amount) . '.00';
        $key = 'BD1U@TfulU5m3';

        $str = $service_code . $user_ref_no . $bin_no . $va_no . $bill_amount . $key;
        $auth_code_cek = hash('sha256', $str);

        $cek_va = $this->db->select('*')->from('virtual_account')
            ->where('virtual_account', $va_no)
            ->order_by('id', 'DESC')
            ->limit(1)->get();

        if ($cek_va->num_rows() < 1) :
            // Jika VA tidak ada
            $data_response = [
                'service_code' => $service_code,
                'user_ref_no' => $user_ref_no,
                'bin_no' => $bin_no,
                'bin_title' => "Fulusme",
                'va_no' => $va_no,
                'va_name' => $va_name,
                'bill_amount' => $bill_amount,
                'pay_amount' => $pay_amount,
                'pay_account' => $pay_account,
                'pay_bank' => $pay_bank,
                'pay_desc' => $pay_desc,
                'response_code' => "000100",
                'auth_code' => $auth_code_cek
            ];
            $this->response($data_response, REST_Controller::HTTP_OK);
        else :
            // Jika VA ada 
            $data = [
                'service_code' => $service_code,
                'user_ref_no' => $user_ref_no,
                'bin_no' => $bin_no,
                'bin_title' => $bin_title,
                'va_no' => $va_no,
                'va_name' => $va_name,
                'bill_amount' => $bill_amount,
                'pay_amount' => $pay_amount,
                'pay_account' => $pay_account,
                'pay_bank' => $pay_bank,
                'pay_desc' => $pay_desc,
                'auth_code_req' => $auth_code,
                'time_response' => time()
            ];
            $this->db->insert('va_payment', $data);
            $last_id = $this->db->insert_id();

            $data_response = [
                'service_code' => $service_code,
                'user_ref_no' => $user_ref_no,
                'bin_no' => $bin_no,
                'bin_title' => "Fulusme",
                'va_no' => $va_no,
                'va_name' => $va_name,
                'bill_amount' => $bill_amount,
                'pay_amount' => $pay_amount,
                'pay_account' => $pay_account,
                'pay_bank' => $pay_bank,
                'pay_desc' => $pay_desc,
                'response_code' => $cek_va->row()->response_code,
                'auth_code' => $auth_code_cek
            ];
            $this->db->update('va_payment', $data_response, ['id' => $last_id]);
            $this->db->update('va_payment', ['response_code' => '000101'], ['id' => $last_id]);
            $this->db->where('va_no', $va_no)->where('bill_amount', $trx_amount)->update('va_inquiry', ['response_code' => '000101']);
            $this->db->where('virtual_account', $va_no)->where('trx_amount', round($bill_amount))->update('virtual_account', ['response_code' => '000101']);
            $this->update_pendanaan($cek_va->row());
            $this->response($data_response, REST_Controller::HTTP_OK);
        endif;
    }

    function update_pendanaan($data_va)
    {
        $id_project = $data_va->id_project;
        $pendanaan_id = $data_va->pendanaan_id;
        $no_va = $data_va->virtual_account;
        $trx_amount = $data_va->trx_amount;
        $pendana_id = $data_va->customer_id;
        $time1 = time();

        $cek_pendanaan = $this->db_fulus->get_where('pendanaan', ['id' => $pendanaan_id]);

        if ($cek_pendanaan->num_rows() < 1) :
        else :
            if (!$cek_pendanaan->row()->paid_ts) :
                $this->db_fulus->update('pendanaan', ['status' => 1, 'paid_ts' => $time1], ['id' => $pendanaan_id]);

                $invoice = $this->GenProjNumber($no_va);
                $cek = $this->db->select('*')->from('trx_pendanaan')->where('nomor_va', $no_va)->where('nominal', $trx_amount)->get()->row();
                $danaTerkumpul = $this->db->get_where('trx_project', ['id_project' => $id_project])->row()->dana_terkumpul;

                if (!$cek) {
                    $dataPendanaan = [
                        'id_project' => $id_project,
                        'id_pendana' => $pendana_id,
                        'nominal' => $trx_amount,
                        'create_ts' => date('Y-m-d H:i:s', $time1),
                        'no_invoice' => $invoice,
                        'nomor_va' => $no_va,
                        'status' => 1
                    ];
                    $this->db->insert('trx_pendanaan', $dataPendanaan);

                    $update_dana = (int) $danaTerkumpul + (int) $trx_amount;
                    $this->db->where('id_project', $id_project);
                    $this->db->update('trx_project', ['dana_terkumpul' => $update_dana]);
                    $this->_sendEmailPembayaran($data_va, $time1);
                    // $this->penjurnalan_pendanaan($pendanaan, $tipe, $invoice);
                }
            endif;
        endif;
    }

    function _sendEmailPembayaran($query, $tf_time)
    {
        $no_va = $query->virtual_account;
        $id_project = $query->id_project;
        $name_user = $query->va_name;
        $email_user = $query->customer_email;
        $phone_user = $query->customer_phone;
        $trx_amount = $query->trx_amount;
        $total_lot = $query->total_lot;
        $tgl_transfer = date('d-m-Y H:i:s', $tf_time);
        $nama_project = $this->db_fulus->get_where('project', ['id' => $id_project])->row()->nama_project;

        // konfigurasi email server
        $config = $this->config->item('config_email');
        $this->email->initialize($config);

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');
        $this->email->to("$email_user, sinafadhiel@gmail.com");

        // Subject email
        $this->email->subject('Confirm Payment');

        // Isi email
        $this->email->message('Terimakasih Anda telah melakukan pembayaran tagihan Anda pada Fulusme SCF dengan rincian sebagai berikut: <br><br>
        <b>Nomor VA : ' . $no_va . ' </b><br>
        <b>Nama Project / ID : ' . $nama_project . ' / ' . $id_project . '</b><br>
        <b>Nama Pendana : ' . $name_user . '</b><br>
        <b>Email Pendana : ' . $email_user . '</b><br>
        <b>Telepon : ' . $phone_user . '</b><br>
        <b>Total Tagihan : Rp. ' . number_format($trx_amount) . '</b><br>
        <b>Jumlah Lot : ' . $total_lot . '</b><br>
        <b>Tanggal Transfer : ' . $tgl_transfer . '</b><br>
        Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2555-8986 WA: XXXXXXXXXXX Email: info@fulusme.id
        ');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            // set post fields
            // $post = [
            //     'id_project' => $id_project,
            //     'va' => $no_va,
            //     'trx_amount'   => $trx_amount,
            //     'phone_user' => $phone_user
            // ];

            // $ch = curl_init('http://178.128.124.100/api_mobile/api/example/sendSmsPayment');
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            // $response = curl_exec($ch);
            // curl_close($ch);

            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    function penjurnalan_pendanaan($project, $tipe, $invoice)
    {
        $akun_bank = 5;
        $akun = 85;
        if ($tipe) {
            if ($tipe === 'Musyarakah') {
                $akun = 84;
            } elseif ($tipe === 'Mudharabah') {
                $akun = 83;
            }
        }
        $saldo_default_bank = $this->db->select('saldo')->from('akun_saldo')->where('id', $akun_bank)->get()->row()->saldo;
        $saldo_default_tipe = $this->db->select('saldo')->from('akun_saldo')->where('id', $akun)->get()->row()->saldo;

        $data_trx = [
            'no_trx_kas' => $invoice,
            'tgl_catat' => date('Y-m-d'),
            'jumlah' => $project->nominal,
            'keterangan' => "Pendanaan Project $project->nama_project",
            'akun' => "Pemasukan",
            'untuk_kas_id' => $akun_bank,
            'jns_trans' => "KM",
            'dok' => $project->nama_project,
            'no_dok' => $project->project_id,
            'dari' => $project->full_name,
            'kepada' => $project->name
        ];
        $this->db->insert('tbl_trans_kas', $data_trx);

        if ($project) {
            $dataJurnal = [
                'no' =>  $this->GenJurNumber(),
                'tgl' => date("Y-m-d"),
                'f_id' => 1,
                'invoice_no' => $invoice,
                'keterangan' => "Pendanaan Project $project->nama_project",
                'waktu_post' => date("Y-m-d h:i:s"),
                'id_project' => $project->project_id
            ];
            $this->db->insert('jurnal', $dataJurnal);
            $lastID = $this->db->insert_id();

            $dataJurnal_detail_debit = [
                'jurnal_id' => $lastID,
                'item' => 1,
                'akun_id' => $akun_bank,
                'debit_kredit' => 1,
                'nilai' => $project->nominal
            ];
            $saldo_bank_update = $saldo_default_bank + $project->nominal;
            $data_bank = [
                'saldo' => $saldo_bank_update
            ];
            $this->db->where('id', $akun_bank);
            $this->db->update('akun_saldo', $data_bank);

            $dataJurnal_detail_kredit = [
                'jurnal_id' => $lastID,
                'item' => 2,
                'akun_id' => $akun,
                'debit_kredit' => 0,
                'nilai' => $project->nominal
            ];

            $saldo_tipe_update = $saldo_default_tipe - $project->nominal;
            $data_tipe = [
                'saldo' => $saldo_tipe_update
            ];
            $this->db->where('id', $akun);
            $this->db->update('akun_saldo', $data_tipe);

            $this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
            $this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);

            $data_debts = [
                'invoiceID' => $invoice,
                'status' => "1",
                'createdDate' => date('Y-m-d h:i:s'),
                'createdUserID' => $this->session->userdata('SESS_USER_ID')
            ];
            $this->db->insert('as_debts', $data_debts);
            // $IdLast = $this->db->insert_id();
        }
    }

    function GenProjNumber($trx_id)
    {
        $trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1;')->row_array();
        $trxdate = date('Y-m-d');
        $produksiID = $trxid['no'];
        $d = date("my", strtotime($trxdate));
        $tglfktr = date('my');
        $produksiIDfil = substr($produksiID, 6, 8);
        if ($produksiIDfil == "") {
            $trxDate = date('my');
            $trx = 1;
            $invoice = sprintf("%04d", $trx);
            $invno = $trxDate . $invoice;
        } else {
            $trxDate = date('my');
            $trxd = substr($produksiIDfil, 0, 4);
            if ($trxDate == $trxd) {
                $invno = $produksiIDfil + 1;
                $invno = sprintf("%08d", $invno);
            } else {
                $trxDate = date('my');
                $trx = 1;
                $invoice = sprintf("%04d", $trx);
                $invno = $trxDate . $invoice;
            }
        }

        $kode = "PND-" . date('d') . "-" . $trx_id;
        return $kode;
    }

    function GenJurNumber()
    {
        $trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1;')->row_array();
        $trxdate = date('Y-m-d');
        $produksiID = $trxid['no'];
        $d = date("my", strtotime($trxdate));
        $tglfktr = date('my');
        $produksiIDfil = substr($produksiID, 6, 8);
        if ($produksiIDfil == "") {
            $trxDate = date('my');
            $trx = 1;
            $invoice = sprintf("%04d", $trx);
            $invno = $trxDate . $invoice;
        } else {
            $trxDate = date('my');
            $trxd = substr($produksiIDfil, 0, 4);
            if ($trxDate == $trxd) {
                $invno = $produksiIDfil + 1;
                $invno = sprintf("%08d", $invno);
            } else {
                $trxDate = date('my');
                $trx = 1;
                $invoice = sprintf("%04d", $trx);
                $invno = $trxDate . $invoice;
            }
        }

        $kode = "JI-" . date('d') . "-" . $invno;
        return $kode;
    }
}
