<?php

class Virtual_account extends CI_Controller
{
    private $db_fulus;

    public function __construct()
    {
        parent::__construct();;
        $this->load->library('auth');
        $this->load->library('BniEnc');
        $this->load->library('Tbswrapper');
        $this->load->library('customlib');
        $this->load->helper('download');
        // if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
        //     $this->auth->check_user_authentification(1);
        // }
        $this->load->model('data_model');
        $this->db_fulus = $this->load->database('fulusme', TRUE);
    }

    function index()
    {
        $data = ['message' => "masuk"];
        var_dump($data);
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

    function get_CURL($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result, true);
    }

    function get_content($url, $post = '')
    {
        $usecookie = __DIR__ . "/cookie.txt";
        $header[] = 'Content-Type: application/json';
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

    function callback()
    {
        // FROM BNI
        // $client_id = '00411';
        // $secret_key = '58f928b6ee844f344b3f72e282d05314';

        $client_id = '10143';
        $secret_key = 'ca6e56d58425af00d2c6a1674b60fd7b';

        $data = file_get_contents('php://input');

        $data_json = json_decode($data, true);

        if (!$data_json) {
            // handling orang iseng
            echo '{"status":"999","message":"jangan iseng :D"}';
        } else {
            if ($data_json['client_id'] === $client_id) {
                $data_asli = $this->bnienc->decrypt($data_json['data'], $client_id, $secret_key);

                if (!$data_asli) {
                    // handling jika waktu server salah/tdk sesuai atau secret key salah
                    echo '{"status":"999","message":"waktu server tidak sesuai NTP atau secret key salah."}';
                } else {
                    // insert data asli ke db
                    $temp = $this->db->get_where('virtual', ['trx_id' => $data_asli['trx_id']])->row();
                    if ($temp) {
                        $datar = array(
                            'trx_amount' => $data_asli['trx_amount'],
                            'payment_amount' => $data_asli['payment_amount'],
                            'cumulative_payment_amount' => $data_asli['cumulative_payment_amount'],
                            'payment_ntb' => $data_asli['payment_ntb'],
                            'datetime_payment' => $data_asli['datetime_payment'],
                            'datetime_payment_iso8601' => $data_asli['datetime_payment_iso8601'],
                        );
                        $this->db->where('trx_id', $data_asli['trx_id']);
                        $this->db->update('virtual', $datar);

                        $va = $data_asli['virtual_account'];
                        $time = strtotime($data_asli['datetime_payment']);
                        $time1 = $data_asli['datetime_payment'];
                        $trxID = $data_asli['trx_id'];
                        if ($va) {
                            $this->bayar($va, $time1, $trxID);
                            $dataDb = ['status' => 1, 'paid_ts' => $time];
                            $this->db_fulus->where('nomor_va', $va);
                            $this->db_fulus->update('pendanaan', $dataDb);
                            // $this->_sendEmail($data_asli['trx_id']);
                        }
                        echo '{"status":"000"}';
                        exit;
                    } else {
                        $data = array(
                            'trx_id' => $data_asli['trx_id'], // silakan gunakan parameter berikut sebagai acuan nomor tagihan
                            'virtual_account' => $data_asli['virtual_account'],
                            'customer_name' => $data_asli['customer_name'],
                            'trx_amount' => $data_asli['trx_amount'],
                            'payment_amount' => $data_asli['payment_amount'],
                            'cumulative_payment_amount' => $data_asli['cumulative_payment_amount'],
                            'payment_ntb' => $data_asli['payment_ntb'],
                            'datetime_payment' => $data_asli['datetime_payment'],
                            'datetime_payment_iso8601' => $data_asli['datetime_payment_iso8601'],
                        );
                        $this->db->insert('virtual', $data);
                        echo '{"status":"000"}';
                        exit;
                    }
                }
            }
        }
    }

    function bayar($id, $time1, $trx_id)
    {
        $id_project = $this->db->get_where('virtual', ['trx_id' => $trx_id])->row()->id_project;
        $cek_project = $this->db_fulus->get_where('project', ['id' => $id_project])->row();
        if ($cek_project) {
            $project = $this->data_model->get_pembayaran_project($id);
            $pendanaan = $this->data_model->get_pendanaan_project($project->id);
        } else {
            $project = $this->data_model->get_pembayaran_project_retail($id);
            $pendanaan = $this->data_model->get_pendanaan_project_retail($project->id);
            $pr = 1;
        }
        $trx_project = $this->db->get_where('trx_project', ['id_project' => $project->project_id])->row();
        $tipe = $trx_project->tipe;
        $invoice = $this->GenProjNumber($trx_id);
        $cek = $this->db->get_where('trx_pendanaan', ['nomor_va' => $id])->row();
        $danaTerkumpul = $this->db->get_where('trx_project', ['id_project' => $project->project_id])->row()->dana_terkumpul;

        if (!$cek) {
            $dataPendanaan = [
                'id_project' => $pendanaan->project_id,
                'id_pendana' => $pendanaan->pendana_id,
                'nominal' => $pendanaan->nominal,
                'create_ts' => $time1,
                'no_invoice' => $invoice,
                'nomor_va' => $pendanaan->nomor_va,
                'status' => 1
            ];
            $this->db->insert('trx_pendanaan', $dataPendanaan);

            $dataProject = [
                'status' => 1
            ];
            $this->db_fulus->set($dataProject);
            $this->db_fulus->where('id', $pendanaan->id);
            $this->db_fulus->update('pendanaan');

            $update_dana = (int) $danaTerkumpul + (int) $pendanaan->nominal;
            $this->db->where('id_project', $project->project_id);
            $this->db->update('trx_project', ['dana_terkumpul' => $update_dana]);

            $id_pendana = null;
            if ($pr) {
                $this->create_akad_confrim_dana($pendanaan->id);
                $id_pendana = $pendanaan->pendana_id;
            }
            $this->_sendEmail($trx_id, $id_pendana);
            $this->penjurnalan_pendanaan($pendanaan, $tipe, $invoice);
        }
    }

    function create_akad_confrim_dana($pendanaan_id)
    {
        $query = $this->db_fulus->get_where('pendanaan', ['id' => $pendanaan_id])->row();
        $id_user = $query->pendana_id;
        $id_project = $query->project_id;
        $no_va = $query->nomor_va;
        $query2 = $this->db_fulus->get_where('pendana', ['id' => $id_user])->row();
        $query3 = $this->db_fulus->get_where('project_retail', ['id_project' => $id_project])->row();
        $query4 = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();
        $query5 = $this->db->get_where('virtual', ['virtual_account' => $no_va])->row();

        $tgl = date('d');
        $hari_ini = $this->hari_ini();
        $tahun = date('Y');
        $bulan = $this->customlib->get_month_name(date('m'));
        $tanggal = "$hari_ini, $tgl $bulan $tahun";

        $nama_pendana = $query2->full_name;
        $nama_project = $query3->nama_toko;
        $modal = number_format($query3->jumlah_pinjaman);
        $tgl_pendanaan = $query5->datetime_payment;
        $tgl_jatuh_tempo = date('d-M-Y', $query4->angsuran);
        $jumlah_pendanaan = number_format($query->nominal);
        $trblg_pendanaan = '( ' . terbilang(intval(str_replace(',', '', $jumlah_pendanaan))) . ' )';
        $jumlah_lot = $query5->total_lot;
        $jumlah_tenor = $query3->tenor;
        $nisbah = number_format($query3->jumlah_pinjaman * 1.3 / 100);
        $no_rek_peminjam = "";
        $nama_peminjam = $query3->nama_pemilik;
        $nama_bank_peminjam = "";
        $alamat_pendana = "$query2->address, $query2->kecamatan, $query2->kota, $query2->provinsi";
        $no_tlp_pendana = $query2->phone;
        $email_pendana = $query2->email;

        $template = FCPATH . 'assets/Aqad_mudharabah_pendana_pulsa.docx';

        $data['GeneratedFileName'] = "Aqad_mudharabah_pendana_pulsa$id_user.docx"; // nama file untuk dokumen yang digenerate
        $data['folderGenerated'] = "assets/pdf"; // nama folder untuk menyimpan hasil generate dokumen
        $userData[0]['id_project'] = "$id_project";
        $userData[0]['tgl'] = "$tanggal";
        $userData[0]['nama_pendana'] = "$nama_pendana";
        $userData[0]['id_pendana'] = "$id_user";
        $userData[0]['nama_project'] = "Retail / $nama_project";
        $userData[0]['modal'] = "$modal";
        $userData[0]['tgl_pendanaan'] = "$tgl_pendanaan";
        $userData[0]['tgl_jatuh_tempo'] = "$tgl_jatuh_tempo";
        $userData[0]['jumlah_pendanaan'] = "$jumlah_pendanaan";
        $userData[0]['trblg_pendanaan'] = "$trblg_pendanaan";
        $userData[0]['jumlah_lot'] = "$jumlah_lot";
        $userData[0]['no_va'] = "$no_va";
        $userData[0]['jumlah_tenor'] = "$jumlah_tenor";
        $userData[0]['nisbah'] = "$nisbah";
        $userData[0]['no_rek_peminjam'] = "$no_rek_peminjam";
        $userData[0]['nama_peminjam'] = "$nama_peminjam";
        $userData[0]['nama_bank_peminjam'] = "$nama_bank_peminjam";
        $userData[0]['alamat_pendana'] = "$alamat_pendana";
        $userData[0]['no_tlp_pendana'] = "$no_tlp_pendana";
        $userData[0]['email_pendana'] = "$email_pendana";

        $this->tbswrapper->tbsLoadTemplate($template);
        $this->tbswrapper->namafile = $data['GeneratedFileName'];
        $this->tbswrapper->folder = FCPATH . $data['folderGenerated'] . "/";
        $this->tbswrapper->tbsMergeField('vars', $userData);
        $this->tbswrapper->tbsMergeBlock('user', $userData);

        if ($this->tbswrapper->tbsRender()) {
            // force_download(FCPATH . "" . $data['folderGenerated'] . "/\\" . $data['GeneratedFileName'], NULL);
            force_download('./assets/pdf/' . $data['GeneratedFileName'], NULL);
        } else {
            $this->session->set_flashdata('message', lang('error_generate_dokumen'));
            redirect('home');
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
    
    function testEmail()
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
            echo 'Sukses! No Virtual Account sudah terkirim email.';
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    function _sendEmail($trx_id, $id_pendana = null)
    {
        $query = $this->db->get_where('virtual', ['trx_id' => $trx_id])->row();
        $no_va = $query->virtual_account;
        $nama_project = $query->name_project;
        $id_project = $query->id_project;
        $name_user = $query->customer_name;
        $phone_user = $query->phone;
        $trx_amount = $query->trx_amount;
        $total_lot = $query->total_lot;
        $tgl_transfer = $query->datetime_payment;
        $email_user = $query->customer_email;

        // konfigurasi email server
        $config = $this->config->item('config_email');
        $this->email->initialize($config);

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');
        $this->email->to("$email_user, sinafadhiel@gmail.com");

        if ($id_pendana != null) {
            $this->email->attach('./assets/pdf/\Aqad_mudharabah_pendana_pulsa' . $id_pendana . '.docx');
        }

        // Subject email
        $this->email->subject('Confirm Payment');

        // Isi email
        $this->email->message('Terimakasih Anda telah melakukan pembayaran tagihan Anda pada Fulusme dengan rincian sebagai berikut: <br><br>
        <b>Nomor VA : ' . $no_va . ' </b><br>
        <b>No Transaksi : ' . $trx_id . ' </b><br>
        <b>Nama Project / ID : ' . $nama_project . ' / ' . $id_project . '</b><br>
        <b>Nama Pendana : ' . $name_user . '</b><br>
        <b>Email Pendana : ' . $email_user . '</b><br>
        <b>Telepon : ' . $phone_user . '</b><br>
        <b>Total Tagihan : Rp. ' . number_format($trx_amount) . '</b><br>
        <b>Jumlah Lot : ' . $total_lot . '</b><br>
        <b>Tanggal Transfer : ' . $tgl_transfer . '</b><br>
        <b>Bank : BNI Syariah</b><br><br>
        Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2555-8986 WA: XXXXXXXXXXX Email: info@fulusme.id
        ');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! No Virtual Account sudah terkirim email.';
            header("Content-type: application/json; charset=utf-8");
            $text = 'Pembayaran%20atas%0AProject%20' . $id_project . '%0ANo%20VA%20' . $no_va . '%0AJumlah%20Rp.%20' . number_format($trx_amount) . '%0ATelah%20selesai.%20Terimakasih%20anda%20telah%20melakukan%20pembayaran';
            $url = '202.149.67.146:8800/?PhoneNumber=' . $phone_user . '&Text=' . $text . '&ID=MUMTAAZ';

            $mysession = curl_init();
            curl_setopt($mysession, CURLOPT_URL, $url);
            curl_setopt($mysession, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($mysession, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($mysession, CURLOPT_FAILONERROR, true);
            $json = json_decode(curl_exec($mysession), true);
        } else {
            echo $this->email->print_debugger();
            die;
        }
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
}
