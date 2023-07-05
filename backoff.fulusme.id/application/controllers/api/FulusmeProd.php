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

class FulusmeProd extends REST_Controller
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

    // Create VA START 
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

        // Start create no VA
        if (strlen($customer_phone) > 12) :
            $phone_to_va = substr("$customer_phone", 1, 12);
        elseif (strlen($customer_phone) < 12) :
            $phone_to_va = str_pad($customer_phone, 12, '0');
        else :
            $phone_to_va = $customer_phone;
        endif;

        $virtual_account = '7675' . $phone_to_va;
        // End No VA

        $exp_time = date('YmdHis', strtotime('+2 years'));

        $cek_va = $this->db->select('*')->from('virtual_account')
            ->where('virtual_account', $virtual_account)
            ->where('response_code', '000000')
            ->get();

        if ($cek_va->num_rows() < 1) :
            // Bila VA belum ada
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
                'type_project' => $type_project,
                'bill_expired' => time() + 60 * 180
            ];
            $this->db->insert('virtual_account', $data);
            $virtual_id = $this->db->insert_id();
            $this->insert_pendanaan($data_front, $virtual_account, $virtual_id);
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
            // $post = [
            //     'id_project' => $id_project,
            //     'va' => $va,
            //     'trx_amount'   => $trx_amount,
            //     'phone_user' => $phone_user,
            //     'code_saham' => $project->code_saham_alias
            // ];
            // $ch = curl_init('http://178.128.124.100/api_mobile/api/example/sendSms');
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
    // Create VA End 

    // Inquiry Start 
    function url_inquiry_post()
    {
        $service_code = $this->post('service_code');
        $user_ref_no = $this->post('user_ref_no');
        $bin_no = $this->post('bin_no');
        $va_no = $this->post('va_no');
        $auth_code = $this->post('auth_code');
        $key = 'BD1Pr0dFuLu5M3';

        $str = $service_code . $user_ref_no . $bin_no . $va_no . $key;
        $auth_code_cek = hash('sha256', $str);

        $cek_va = $this->db->select('*')->from('virtual_account')
            ->where('virtual_account', $va_no)
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
            if ($cek_va->row()->bill_expired < time()) :
                // Bill expired
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
    // Inquiry End

    // Payment Start
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
        $key = 'BD1Pr0dFuLu5M3';

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
            $id_va = $cek_va->row()->id;
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
            $this->db->query("UPDATE va_inquiry SET response_code = '000101' WHERE va_no = '$va_no' AND bill_amount = '$bill_amount' ORDER BY id DESC LIMIT 1");
            $this->db->where('id', $id_va)->update('virtual_account', ['response_code' => '000101']);
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
        
        $cek_pendanaan = $this->db_fulus->select('*')->from('pendanaan')
            ->where('id', $pendanaan_id)
            ->order_by('id', 'DESC')
            ->limit(1)->get();

        if ($cek_pendanaan->num_rows() > 0) :
            if (!$cek_pendanaan->row()->paid_ts || $cek_pendanaan->row()->paid_ts == 0) :
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
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
    // Payment End

    function GenProjNumber($trx_id)
    {
        $trxid = $this->db_fulus->query('SELECT * from pendanaan order by id desc limit 1;')->row_array();
        $trxdate = date('Y-m-d');
        $produksiID = $trxid['id'];
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
