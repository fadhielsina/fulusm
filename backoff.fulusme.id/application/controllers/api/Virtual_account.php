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

class Virtual_account extends REST_Controller

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

            "message" => date('Y-m-d H:i:s', strtotime("+ 2 year"))

        ];

        $number = '081546810673';
        $va = '3424234234234';
        $id_project = '19028309128';
        $text = 'Silahkan%20lakukan%20pembayaran%20proyek%20' . $id_project . '%20dengan%20no%20va%20' . $va . '%0Terimakasih%20anda%20telah%20bersedia%20menjadi%20pemodal%20di%20Fulusme SCF';
        $url = 'http://amecitia.com:8800/?PhoneNumber=' . $number . '&Text=' . $text . '&ID=FULUSME';

        redirect($url);
        $this->response($user, REST_Controller::HTTP_OK);
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



    function get_content($url, $post = '')

    {

        $usecookie = __DIR__ . "/cookie.txt";

        $header[] = 'Content-Type: application/json';

        // $header[] = 'X-API-Key: 7e6e5c9d-ed58-4a98-be46-434c5a8f2792';

        $header[] = "Accept-Encoding: gzip, deflate";

        $header[] = "Cache-Control: max-age=0";

        $header[] = "Connection: keep-alive";

        $header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_VERBOSE, false);

        // curl_setopt($ch, CURLOPT_NOBODY, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_ENCODING, true);

        curl_setopt($ch, CURLOPT_AUTOREFERER, true);

        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);



        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");



        if ($post) {

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }



        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);



        $rs = curl_exec($ch);



        if (empty($rs)) {

            var_dump($rs, curl_error($ch));

            curl_close($ch);

            return false;
        }

        curl_close($ch);

        return $rs;
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

    function create_virtual_account($data)
    {
        $client_id = 'd5030099-6884-4968-9d2e-71436ecea566';
        $secret_key = 'f7a0a209-9a19-4e49-a36f-eac18990dc8f';
        $auth = base64_encode("$client_id:$secret_key");

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
        // 		$this->response($api, REST_Controller::HTTP_OK);
        // var_dump($api['access_token']);
        if ($this->db->insert('virtual_account', ['username_password' => $auth, 'access_token' => 'Bearer ' . $api['access_token']])) :
            $last_id = $this->db->insert_id();
            $this->generateVA($last_id, $api['access_token'], $data);
        endif;
    }

    function generateVA($last_id = '', $auth = '', $data)
    {
        $customer_name = $data['customer_name'];
        $customer_phone = $data['customer_phone'];

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
            "VirtualAccountNumber" => '8888' . $customer_phone,
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
            $data = [
                'user_ref_no' => $api['UserReferenceNumber'],
                'response_time' => $api['ResponseTime'],
                'virtual_account' => $api['VirtualAccountNumber'],
                'code_status' => $api['CodeStatus'],
                'description' => $api['DescriptionStatus'],
                'exp_time' => $exp_time
            ];
            $this->db->update('virtual_account', $data, ['id' => $last_id]);
            // var_dump($api);
            $this->response($api, REST_Controller::HTTP_OK);
        endif;
    }

    function insert_pendanaan($data_front, $data_send, $va)
    {
        $customer_id = $data_front['customer_id'];
        $trx_amount = $data_front['trx_amount'];
        $project_id = $data_front['project_id'];
        $id_peminjam = $data_front['borrower_id'];
        $jenis_pendanaan = $data_front['type_project'];

        $data = [
            'project_id' => $project_id,
            'peminjam_id' => $id_peminjam,
            'pendana_id' => $customer_id,
            'nominal' => $trx_amount,
            'status' => 0,
            'create_ts' => strtotime("now"),
            'pending_ts' => strtotime('+30 minutes', time()),
            'nomor_va' => $va,
            'jenis_pendanaan' => $jenis_pendanaan
        ];
        $this->db_fulus->insert('pendanaan', $data);
        $pendanaan_id = $this->db_fulus->insert_id();
        $this->create_akad_confrim_new($pendanaan_id, $data_send);
    }



    function create_pra_akad($data_send)

    {
        $va = $data_send['va'];

        $id_project = $data_send['project_id'];

        $id_user = $data_send['customer_id'];

        $name_user = $data_send['customer_name'];

        $email_user = $data_send['customer_email'];



        $tgl = date('d');

        $hari_ini = $this->hari_ini();

        $tahun = date('Y');

        $bulan = $this->customlib->get_month_name(date('m'));

        $tanggal = "$hari_ini, $tgl $bulan $tahun";



        $query = $this->db_fulus->get_where('pendana', ['id' => $id_user])->row();
        $ktp = "";

        $nama_bank = "";

        $no_rek = "";

        $nama_rek = "";

        if ($query) {

            $ktp = $query->ktp;

            $nama_bank = $query->bank_name;

            $no_rek = $query->bank_number;

            $nama_rek = $query->bank_account_name;
        }



        $template = FCPATH . 'assets/Wakala_pendana.docx';

        // $DataRUP = $this->Rup_model->get_by_id($id);



        $data['GeneratedFileName'] = "Wakala_pendana$id_user.docx"; // nama file untuk dokumen yang digenerate

        $data['folderGenerated'] = "assets/pdf"; // nama folder untuk menyimpan hasil generate dokumen

        $userData[0]['id_project'] = "$id_project";

        $userData[0]['tgl'] = "$tanggal";

        $userData[0]['nama'] = "$name_user";

        $userData[0]['ktp'] = "$ktp";

        $userData[0]['no_va'] = "$va";

        $userData[0]['email'] = "$email_user";

        $userData[0]['nama_bank'] = "$nama_bank";

        $userData[0]['cabang_bank'] = "-";

        $userData[0]['no_rek'] = "$no_rek";

        $userData[0]['nama_rek'] = "$nama_rek";



        $this->tbswrapper->tbsLoadTemplate($template);

        $this->tbswrapper->namafile = $data['GeneratedFileName'];

        $this->tbswrapper->folder = FCPATH . $data['folderGenerated'] . "/";

        $this->tbswrapper->tbsMergeField('vars', $userData);

        $this->tbswrapper->tbsMergeBlock('user', $userData);



        if ($this->tbswrapper->tbsRender()) {

            // force_download(FCPATH . "" . $data['folderGenerated'] . "/\\" . $data['GeneratedFileName'], NULL);

            force_download('./assets/pdf/' . $data['GeneratedFileName'], NULL);

            $this->_sendEmail($data_send);
        } else {

            $this->session->set_flashdata('message', lang('error_generate_dokumen'));

            redirect('home');
        }
    }
    
    function create_akad_confrim_new($pendanaan_id, $data_send)
    {
        $query = $this->db_fulus->get_where('pendanaan', ['id' => $pendanaan_id])->row();
        $id_user = $query->pendana_id;
        $id_project = $query->project_id;
        $no_va = $query->nomor_va;
        $query2 = $this->db_fulus->get_where('pendana', ['id' => $id_user])->row();
        $query3 = $this->db->get_where('history_project', ['id' => $id_project])->row();
        $query4 = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();

        $tgl = date('d');
        $hari_ini = $this->hari_ini();
        $tahun = date('Y');
        $bulan = $this->customlib->get_month_name(date('m'));
        $tanggal = "$hari_ini, $tgl $bulan $tahun";

        $nama_pendana = $query2->full_name;
        $modal = number_format($query3->modal_project);
        $harga_perlembar = number_format($query3->harga_perlembar_shm);
        $trblg_harga_perlembar = '( ' . terbilang(intval(str_replace(',', '', $harga_perlembar))) . ' )';
        $tgl_jatuh_tempo = date('Y-m-d', strtotime("+14 day", strtotime(date('y-m-d'))));
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
            $this->_sendEmail($data_send);
        } else {
            $this->session->set_flashdata('message', lang('error_generate_dokumen'));
            redirect('home');
        }
    }



    function _sendEmail($data_send)

    {

        $va = $data_send['va'];

        $trx_id = $data_send['trx_id'];

        $id_project = $data_send['project_id'];

        $id_user = $data_send['customer_id'];

        $name_user = $data_send['customer_name'];

        $email_user = $data_send['customer_email'];

        $phone_user = $data_send['customer_phone'];

        $trx_amount = $data_send['trx_amount'];

        $total_lot = $data_send['total_lot'];

        $batas_bayar = $data_send['batas_bayar'];



        $project = $this->db_fulus->get_where('project', ['id' => $id_project])->row();

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

        $this->email->attach('./assets/pdf/\Surat_perjanjian' . $id_user . '.docx');



        // Subject email

        $this->email->subject('Project Funding');



        // Isi email

        $this->email->message('Terimakasih Anda telah bersedia menjadi Pemodal di Fulusme SCF ,

        berikut kami sampaikan informasi mengenai rincian pemodalan yang telah Anda pilih: <br><br>

        <b>Nomor VA : ' . $va . '</b><br>

        <b>Nama Proyek / ID : ' . $nama_project . ' / ' . $id_project . '</b><br>

        <b>Nama : ' . $name_user . ' </b><br>

        <b>ID Pemodal : ' . $id_user . '</b><br>

        <b>Email : ' . $email_user . '</b><br>

        <b>Telepon : ' . $phone_user . '</b><br>

        <b>Total Tagihan : Rp. ' . number_format($trx_amount) . ' </b><br>

        <b>Jumlah LOT : ' . $total_lot . ' </b><br>

        <b>Batas Waktu Pembayaran : ' . $batas_bayar . ' </b><br><br>

        Silahkan lakukan pembayaran menggunakan Nomor VA <b>' . $va . '</b> melalui channel Danamon sebelum batas waktu pembayaran diatas.

        <br><br>

        Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2520-934 WA: +62 822-9999-6862 Email:info@fulusme.id

        ');



        // Tampilkan pesan sukses atau error

        if ($this->email->send()) {

            // echo 'Sukses! No Virtual Account sudah terkirim email.';

            $data_db = [

                'trx_id' => $trx_id,

                'customer_name' => $name_user,

                'virtual_account' => $va,

                'customer_email' => $email_user,

                'id_project' => $id_project,

                'name_project' => $nama_project,

                'total_lot' => $total_lot,

                'phone' => $phone_user

            ];

            if ($this->db->insert('virtual', $data_db)) {
                // set post fields
                $post = [
                    'id_project' => $id_project,
                    'va' => $va,
                    'trx_amount'   => $trx_amount,
                    'phone_user' => $phone_user,
                    'ip_address' => $this->input->ip_address()
                ];
                
                $ch = curl_init('http://178.128.124.100/api_mobile/api/example/sendSms');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                
                // execute!
                $response = curl_exec($ch);
                
                // close the connection, release resources used
                curl_close($ch);
            };
        } else {

            echo $this->email->print_debugger();

            die;
        }
    }



    function create_va_borrower_post()

    {

        $data = [

            'project_id' => $this->post('project_id'),

            'customer_id' => $this->post('customer_id'),

            'customer_name' => $this->post('customer_name'),

            'customer_phone' => $this->post('customer_phone'),

            'customer_email' => $this->post('customer_email'),

            'trx_amount' => $this->post('trx_amount'),

            'total_lot' => $this->post('total_lot'),

            'borrower_id' => $this->post('borrower_id')

        ];

        $cek = $this->db_fulus->get_where('project', ['id' => $data['project_id']])->row();

        $this->create_borrower_va($data);
    }



    function create_borrower_va($data_front)

    {

        $client_id = '00411';

        $secret_key = '58f928b6ee844f344b3f72e282d05314';

        $url = 'https://apibeta.bni-ecollection.com/';



        $customer_id = $data_front['customer_id'];

        $customer_name = $data_front['customer_name'];

        $customer_email = $data_front['customer_email'];

        $customer_phone = $data_front['customer_phone'];

        $trx_amount = $data_front['trx_amount'];

        $project_id = $data_front['project_id'];

        $total_lot = $data_front['total_lot'];



        $data_asli = array(

            'client_id' => $client_id,  // wajib

            'trx_id' => mt_rand(), // wajib

            'trx_amount' => $trx_amount, // wajib

            'billing_type' => 'i', // wajib

            'datetime_expired' => date('Y-m-d H:i:s', strtotime("+ 2 year")),

            'virtual_account' => '',

            'customer_name' => $customer_name, // wajib

            'customer_email' => $customer_email,

            'customer_phone' => $customer_phone,

            'type' => 'createbilling', // wajib

        );

        $hashed_string = $this->bnienc->encrypt(

            $data_asli,

            $client_id,

            $secret_key

        );



        $data = array(

            'client_id' => $client_id,

            'data' => $hashed_string,

        );



        $response = $this->get_content($url, json_encode($data));

        $response_json = json_decode($response, true);



        if ($response_json['status'] !== '000') {

            // handling jika gagal

            var_dump($response_json);
        } else {

            $data_response = $this->bnienc->decrypt($response_json['data'], $client_id, $secret_key);

            // $data_response will contains something like this: 

            $datares = array(

                'virtual_account' => $data_response['virtual_account'],

                'trx_id' => $data_response['trx_id'],

                'message' => 'Sukses! No Virtual Account sudah terkirim.'

            );

            $this->set_response($datares, REST_Controller::HTTP_CREATED);

            return $datares;
        }
    }

    function rdl_post()
    {
        $this->create_rdl();
    }

    function create_rdl()
    {
        // $post = [
        //     'username' => 'e85da5f0-45ed-4bfc-a15e-695e322de292',
        //     'password' => '154abe7c-25f0-4a6d-9941-7b735c05fef7'
        // ];

        $curl = curl_init('url_to_post');
        curl_setopt($curl, CURLOPT_URL, 'https://apidev.bni.co.id:8065//api/oauth/token');
        curl_setopt($curl, CURLOPT_POST, 1);
        // curl_setopt($curl, CURLOPT_USERPWD, "fulusme:fulusme321");
        $headers = array(
            'Content-Type:application/x-www-form-urlencoded',
            'Authorization:Basic ZTg1ZGE1ZjAtNDVlZC00YmZjLWExNWUtNjk1ZTMyMmRlMjkyOjE1NGFiZTdjLTI1ZjAtNGE2ZC05OTQxLTdiNzM1YzA1ZmVmNw=='
        );
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);

        curl_close($curl);
        $api = json_decode($response, true);

        var_dump($api);
    }
}
