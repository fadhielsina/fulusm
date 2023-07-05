<?php

class Project_retail extends CI_Controller
{
    private $db_fulus;

    function __construct()
    {
        parent::__construct();;
        $this->load->library('auth');
        if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
            $this->auth->check_user_authentification(1);
        }

        $this->load->library('form_validation');
        $this->load->model('purchasing_model');
        $this->load->library('BniEnc');
        $this->load->library('customlib');
        $this->load->library('Tbswrapper');
        $this->load->helper('download');
        $this->load->model('akun_model');
        $this->load->model('project_model');
        $this->load->model('data_model');

        $this->db_fulus = $this->load->database('fulusme', TRUE);
    }

    function index()
    {
        $this->form_validation->set_rules('stat_pro', 'Status Project', 'required');

        if ($this->form_validation->run() == false) {
            $data['cek'] = 10;
            $cek = 10;
        } else {
            $data['cek'] = $this->input->post('stat_pro');
            $cek = $this->input->post('stat_pro');;
        }

        $data['title'] = "Daftar Semua Project Retail";
        $data['main_content'] = 'project/daftar_all_project_retail';
        $data['data_project'] = $this->project_model->getAllProjectRetail($cek);
        $data['status_pro'] = $this->db_fulus->get('status_project')->result();
        $this->load->view('template/template_xpanel', $data);
    }

    function detail($id)
    {
        $this->form_validation->set_rules('hasil_nilai_scoring', 'Hasil Nilai Scoring', 'required|trim');

        if ($this->form_validation->run() == false) {
            $idpro = $this->db_fulus->get_where('project_retail', ['id' => $id])->row()->id_project;
            $data['title'] = "Detail Project Retail";
            $data['form_scoring'] = "Project Retail";
            $data['main_content'] = 'project/detail_project_retail';
            $data['id'] = $id;
            $data['project_id'] = $idpro;
            $data['get_tipe'] = $this->data_model->getScoringTipe();
            $data['get_score_project'] = $this->data_model->get_score_project($idpro);
            $tipe = $this->input->post('tipe_id');
            $data['tipe'] = $this->db->get_where('scr_type', ['id' => $tipe])->row();
            $data['get_table_scoring'] = $this->data_model->get_table_scoring();
            $data['data_project'] = $this->db_fulus->select('*')->from('project_retail a')->join('retail', 'retail.id = a.retail_id')->where('a.id', $id)
                ->get()->row();
            $this->load->view('template/template_xpanel', $data);
        } else {
            $this->data_model->submitScore();
            redirect('project_retail/detail/' . $id . '');
        }
    }

    function form_project($id)
    {
        if (isset($_POST['reject'])) {
            $this->reject($id);
            $this->saveProject($id, "reject");
            redirect('project_retail');
        }

        $this->form_validation->set_rules('tipe', 'Tipe', 'required|trim');
        $this->form_validation->set_rules('id_anggota', 'ID Anggota', 'required|trim');
        $this->form_validation->set_rules('mitra', 'Mitra', 'required|trim');
        $this->form_validation->set_rules('jenis_pengembalian', 'Jenis Pengembalian', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Detail Proposal";
            $data['main_content'] = 'scoring/form_project_retail';
            $data['project_id'] = $id;
            $data['score'] = $this->db->get_where('scoring', ['id_project' => $id])->result();
            $score = $data['score'][0]->hasil_scoring;
            $data['user_data'] = $this->db_fulus->select('*, status_project.status as nama_status')->from('project_retail a')
                ->join('retail', 'retail.id = a.retail_id')->join('status_project', 'a.status = status_project.id')
                ->where('a.id_project', $id)
                ->get()->row();
            $data['stat_project'] = $this->db->get_where('scr_status', ['id_project' => $id])->row();
            $data['grade'] = $this->data_model->getGrade($score);
            $data['formProject'] = $this->db->get_where('trx_project', ['id_project' => $id])->row();
            $data['trx_project'] = $this->db->get_where('trx_project_retail', ['id_project' => $id])->row();
            $data['list_mitra'] = $this->db_fulus->get('koperasi')->result();
            $this->load->view('template/template_xpanel', $data);
        } else {
            $this->saveProject($id, "approve");
            $this->approve($id);
            redirect('project/daftar');
        }
    }

    function saveProject($id, $action_type)
    {
        $tipe = $this->input->post('tipe');
        $tipe_pengembalian = $this->input->post('jenis_pengembalian');
        $tempo_perbulan = $this->input->post('jatuh_tempo');
        $tempo_akhir = $this->input->post('tgl_pengembalian');

        $id_project = $id;
        $id_peminjam = $this->input->post('id_peminjam');
        $nama_peminjam = $this->input->post('nama_peminjam');
        $nama_project = $this->input->post('nama_project');
        $persent_keuntungan = $this->input->post('keuntungan');
        $tenor = $this->input->post('tenor');

        $mitra = $this->input->post('mitra');
        $nama_mitra = $this->db_fulus->get_where('koperasi', ['id_koperasi' => $mitra])->row();
        $id_anggota = $this->input->post('id_anggota');

        $rating = $this->input->post('rating');
        $jumlah_lot = $this->input->post('jumlah_lot');
        $harga_perlot = $this->input->post('harga_perlot');
        $modal = $this->input->post('modal_project');
        $note = $this->input->post('note');

        if ($tipe == 1) {
            $tipe_bayar = 'Mudharabah';
        }
        if ($tipe == 2) {
            $tipe_bayar = 'Musyarakah';
        }
        if ($tipe == 3) {
            $tipe_bayar = 'Murabahah';
        }

        if ($tipe_pengembalian == 0) {
            $tipe_kembali = strtotime($tempo_akhir);
        }
        if ($tipe_pengembalian == 1) {
            $tipe_kembali = $tempo_perbulan;
        }

        if ($action_type == "approve") {
            $status = 0;
        } else {
            $status = 3;
        }

        $data_jurnal = [
            'id_project' => $id_project,
            'nama_peminjam' => $nama_peminjam,
            'nama_project' => $nama_project,
            'ujrah' => 1,
            'lender' => null,
            'borrower' => null,
            'tipe' => $tipe_bayar,
            'persentasi_keuntungan' => $persent_keuntungan,
            'angsuran' => $tipe_kembali,
            'status' => $status,
            'tenor' => $tenor,
            'id_peminjam' => $id_peminjam
        ];

        $data_pro = [
            'id_project' => $id_project,
            'nama_peminjam' => $nama_peminjam,
            'nama_project' => $nama_project,
            'rating' => $rating,
            'jumlah_lot' => intval(str_replace(',', '', $jumlah_lot)),
            'harga_perlot' => intval(str_replace(',', '', $harga_perlot)),
            'modal_project' => intval(str_replace(',', '', $modal)),
            'estimasi_keuntungan' => $persent_keuntungan,
            'note' => $note,
            'mitra' => $nama_mitra->nama_koperasi,
            'id_anggota' => $id_anggota,
            'id_mitra' => $mitra
        ];

        $this->db->insert('trx_project_retail', $data_pro);
        $this->db->insert('trx_project', $data_jurnal);
        $this->db->where('id_project', $id_project);
        $this->db->update('scr_status', ['edit_st' => 1]);
    }

    function approve($id)
    {
        $note = $this->input->post('note');

        $dataTrx = [
            'tgl_app' => date('y-m-d'),
            'status' => 1,
            'tgl_deadline' => date('Y-m-d', strtotime("+14 day", strtotime(date('y-m-d')))),
        ];

        $this->db->where('id_project', $id);
        $this->db->update('scr_status', ['note_app' => $note]);

        $this->db_fulus->where('id_project', $id);
        $this->db_fulus->update('project_retail', ['status' => 1, 'end_ts' => strtotime('+ 2 day', time())]);
        $this->db->set($dataTrx);
        $this->db->where('id_project', $id);
        $this->db->update('trx_project');
        $this->_sendEmail($id);
    }

    function _sendEmail($id)
    {
        $query = $this->db_fulus->get_where('project_retail', ['id_project' => $id])->row();
        $nama_toko = $query->nama_toko;
        $config = $this->config->item('config_email');
        $this->email->initialize($config);

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');
        $this->email->to('sinafadhiel@gmail.com, project@fulusme.id');

        // Subject email
        $this->email->subject('Riview Project');

        // Isi email
        $this->email->message('
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
        </head>
        <body>
        <div style="width: 650px; border : 2px solid #00FFFF; padding: 20px;">
            <h2 class="card-title">Fulusme</h2>
            <h4 class="card-subtitle mb-2 text-muted">Jakarta, ' . date('d F Y') . '</h4>
            <hr>
            <p class="card-text">
            <table>
            <tbody>
            <tr>
                <td style="width: 152px; height: 30px;"> ID Project </td>
                <td style="width: 12px;"> : </td>
                <td> ' . $id . ' </td>
            </tr>
            <tr>
                <td style="height: 30px;"> Tipe Project </td>
                <td> : </td>
                <td> Project Retail </td>
            </tr>
            <tr>
                <td style="height: 30px;"> Nama Project </td>
                <td> : </td>
                <td> ' . $nama_toko . ' </td>
            </tr>
            </tbody>
            </table>
            <div style="margin-top:15px;">
            Project diatas telah di riview. Silahkan klik link dibawah untuk melihat hasil riview.
            <div>
            </p>
            <a href="' . base_url('project_retail/detail/') . $query->id . '">Go To Link</a>
        </div>

        </body>
        </html>
        ');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! email retail berhasil dikirim.';
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    function reject($id)
    {
        $note = $this->input->post('note');
        $data = [
            'end_ts' => time(),
            'status' => 3
        ];

        $this->db->where('id_project', $id);
        $this->db->update('scr_status', ['note_app' => $note]);
        $this->db_fulus->where('id_project', $id);
        $this->db_fulus->update('project_retail', $data);
        $this->_sendEmail($id);
    }

    function market_place($id)
    {
        $this->form_validation->set_rules('nominal_pengembalian', 'Nominal Pengembalian', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Detail Project";
            $data['main_content'] = 'project/detail_project_retail_berjalan';
            $data['project'] = $this->project_model->getDetailProject($id);
            $id_project = $data['project']->id_project;
            $data['detail_project'] = $this->db_fulus->select('*')->from('project_retail')->join('retail', 'retail.id = project_retail.retail_id')
                ->where('project_retail.id_project', $id_project)->get()->row();
            $data['datproject'] = $this->db->get_where('trx_project_retail', ['id_project' => $id_project])->row();
            $data['dana_terkumpul'] = $this->project_model->getDanaTerkumpul($id_project);
            $data['tgl_transfer'] = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $id])->row();
            $this->cek_va($id_project);
            $this->load->view('template/template_xpanel', $data);
        } else {
            if (isset($_POST['send_akad'])) {
                $nominal_pengembalian = intval(str_replace(',', '', $this->input->post('nominal_pengembalian')));
                $pinjaman_tf = intval(str_replace(',', '', $this->input->post('pinjam_di_tf')));
                $this->create_akad_ijarah($id, $nominal_pengembalian, $pinjaman_tf);
                $idpro = $this->db->get_where('trx_project', ['id' => $id])->row()->id_project;
                $this->db->where('id_project', $idpro);
                $this->db->update('scr_status', ['status_ijarah' => 1]);
            } else {
                $nominal_pengembalian = $this->input->post('nominal_pengembalian');
                $pinjaman_tf = $this->input->post('pinjam_di_tf');
                $idpro = $this->db->get_where('trx_project', ['id' => $id])->row()->id_project;
                $data_trx = [
                    'status' => 2,
                    'nominal_pengembalian' => intval(str_replace(',', '', $nominal_pengembalian)),
                    'pinjaman_tf' => intval(str_replace(',', '', $pinjaman_tf))
                ];
                $this->db->where('id', $id);
                $this->db->update('trx_project', $data_trx);
                $this->project_model->postProjectRetail($id);
                // $this->send_ujrah($this->input->post('ujrah'));
                $this->create_akad_peminjam($idpro);
                redirect('project/marketplace');
            }
        }
    }

    function cancel($id)
    {
        $data = ['status' => 4, 'end_ts' => time()];
        $this->db_fulus->set($data);
        $this->db_fulus->where('id_project', $id);
        $this->db_fulus->update('project_retail');
        $this->db->where('id_project', $id);
        $this->db->update('trx_project', ['status' => 4]);

        $data_retur = ['status' => 2, 'cancel_ts' => date('Y-m-d h:i:s')];
        $this->db->where('id_project', $id);
        $this->db->update('trx_pendanaan', $data_retur);
        redirect('purchasing/purchasing_retur');
    }

    function cek_va($id)
    {
        $modal = $this->db_fulus->get_where('project_retail', ['id_project' => $id])->row()->jumlah_pinjaman;
        $query = $this->db->get_where('trx_project', ['id_project' => $id])->row();
        $profile = $this->db_fulus->select('retail.name, retail.phone, user.email')
            ->from('retail')->join('user', 'user.id = retail.user_id')->where('user_id', $query->id_peminjam)->get()->row();
        $pengembalian_dana = $query->dana_terkumpul * (1.3 / 100);
        if ($query->dana_terkumpul >= $modal) {
            // masukan va
            if (!$query->virtual_account) {
                $data = [
                    'project_id' => $id,
                    'customer_id' => $query->id_peminjam,
                    'customer_name' => $profile->name,
                    'customer_phone' => $profile->phone,
                    'customer_email' => $profile->email,
                    'trx_amount' => $pengembalian_dana
                ];
                $this->create_borrower_va($data);
            }
        }
    }

    function create_akad_peminjam($id_project)
    {
        $query = $this->db_fulus->get_where('project_retail', ['id_project' => $id_project])->row();
        $query2 = $this->db_fulus->get_where('retail', ['id' => $query->retail_id])->row();
        $query3 = $this->db->get_where('trx_project_retail', ['id_project' => $id_project])->row();
        $query4 = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();

        $tgl = date('d');
        $hari_ini = $this->hari_ini();
        $tahun = date('Y');
        $bulan = $this->customlib->get_month_name(date('m'));
        $tanggal = "$hari_ini, $tgl $bulan $tahun";

        $arr = [
            $nama_peminjam = $query->nama_pemilik,
            $id_peminjam = $query->id_anggota,
            $alamat = $query2->address,
            $nama_toko = $query->nama_toko,
            $alamat_toko = $query2->alamat_toko,
            $ktp_peminjam = $query2->ktp,
            $hp_peminjam = $query2->phone,
            $mitra = $query3->mitra,
            $id_mitra = "",
            $harga_beli = "",
            $trblg_harga_beli = "",
            $tgl_pembiayaan = $tanggal = "$hari_ini, $tgl $bulan $tahun",
            $harga_jual = "",
            $trblg_harga_jual = "",
            $ujrah = number_format($query->jumlah_pinjaman * 1 / 100),
            $trblg_ujrah = '( ' . terbilang(intval(str_replace(',', '', $ujrah))) . ' )',
            $tgl_jatuh_tempo = date('d-M-Y', $query4->angsuran)
        ];

        $template = FCPATH . 'assets/Aqad_murabahah_peminjam_pulsa.docx';

        $data['GeneratedFileName'] = "Aqad_murabahah_peminjam_pulsa$id_peminjam.docx"; // nama file untuk dokumen yang digenerate
        $data['folderGenerated'] = "assets/pdf"; // nama folder untuk menyimpan hasil generate dokumen
        $userData[0]['id_project'] = "$id_project";
        $userData[0]['tgl'] = "$tanggal";
        $userData[0]['only_tgl'] = $tgl;
        $userData[0]['only_bulan'] = $bulan;
        $userData[0]['only_tahun'] = $tahun;
        $userData[0]['nama_peminjam'] = "$nama_peminjam";
        $userData[0]['id_peminjam'] = $id_peminjam;
        $userData[0]['alamat'] = $alamat;
        $userData[0]['nama_toko'] = $nama_toko;
        $userData[0]['alamat_toko'] = $alamat_toko;
        $userData[0]['ktp_peminjam'] = $ktp_peminjam;
        $userData[0]['hp_peminjam'] = $hp_peminjam;
        $userData[0]['mitra'] = $mitra;
        $userData[0]['id_mitra'] = $id_mitra;
        $userData[0]['harga_beli'] = $harga_beli;
        $userData[0]['trblg_harga_beli'] = $trblg_harga_beli;
        $userData[0]['tgl_pembiayaan'] = $tgl_pembiayaan;
        $userData[0]['harga_jual'] = $harga_jual;
        $userData[0]['trblg_harga_jual'] = $trblg_harga_jual;
        $userData[0]['ujrah'] = $ujrah;
        $userData[0]['trblg_ujrah'] = $trblg_ujrah;
        $userData[0]['tgl_jatuh_tempo'] = $tgl_jatuh_tempo;

        $this->tbswrapper->tbsLoadTemplate($template);
        $this->tbswrapper->namafile = $data['GeneratedFileName'];
        $this->tbswrapper->folder = FCPATH . $data['folderGenerated'] . "/";
        $this->tbswrapper->tbsMergeField('vars', $userData);
        $this->tbswrapper->tbsMergeBlock('user', $userData);

        if ($this->tbswrapper->tbsRender()) {
            // force_download(FCPATH . "" . $data['folderGenerated'] . "/\\" . $data['GeneratedFileName'], NULL);
            force_download('./assets/pdf/' . $data['GeneratedFileName'], NULL);
            $this->kirim_akad_peminjam($id_peminjam);
        } else {
            $this->session->set_flashdata('message', lang('error_generate_dokumen'));
            redirect('home');
        }
    }

    function create_akad_ijarah($id, $nominal_pengembalian, $pinjaman_di_tf)
    {
        $query = $this->db->get_where('trx_project', ['id' => $id])->row();
        $query1 = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $query->id_project])->row();
        $query2 = $this->db_fulus->select('retail.*')->from('retail')->join('user', 'retail.user_id = user.id')->where('user_id', $query->id_peminjam)->get()->row();
        $query3 = $this->db->get_where('trx_project_retail', ['id_project' => $query->id_project])->row();
        $query4 = $this->db_fulus->get_where('project_retail', ['id_project' => $query->id_project])->row();
        $arr = [
            $id_project = $query->id_project,
            $nama_peminjam = $query->nama_peminjam,
            $nama_toko = $query4->nama_toko,
            $ktp_peminjam = $query2->ktp,
            $alamat_peminjam = $query2->address,
            $modal = number_format($query3->modal_project),
            // $pengembalian_dana = number_format($query->nominal_pengembalian),
            $pengembalian_dana = number_format($nominal_pengembalian),
            $ujrah = number_format($query4->jumlah_pinjaman * 1 / 100),
            $keuntungan = number_format($query4->jumlah_pinjaman * 1.3 / 100),
            $marjin_keuntungan = intval(str_replace(',', '', $keuntungan)),
            // $pinjaman_tf = number_format($query->pinjaman_tf),
            $pinjaman_tf = number_format($pinjaman_di_tf),
            $jatuh_tempo = date('d-m-Y', strtotime("$query->tgl_deadline")),
            $va = $query->virtual_account,
            $mitra = $query3->mitra,
            $tlp_peminjam = $query2->phone,
            $email_peminjam = $query2->email,
            $tenor = "$query1->tenor hari",
            $trblg_modal = '( ' . terbilang(intval(str_replace(',', '', $modal))) . ' )',
            $trblg_pengembalian_dana = '( ' . terbilang(intval(str_replace(',', '', $pengembalian_dana))) . ' )',
            $trblg_ujrah = '( ' . terbilang(intval(str_replace(',', '', $ujrah))) . ' )',
            $trblg_pinjaman_tf = '( ' . terbilang(intval(str_replace(',', '', $pinjaman_tf))) . ' )',
        ];

        $tempo = '' . date('d', strtotime($jatuh_tempo)) . ' ';
        $tempo .= '' . $this->customlib->get_month_name(date('m', strtotime($jatuh_tempo))) . ' ';
        $tempo .= '' . date('Y', strtotime($jatuh_tempo)) . '';
        $tgl = date('d');
        $hari_ini = $this->hari_ini();
        $tahun = date('Y');
        $bulan = $this->customlib->get_month_name(date('m'));
        $tanggal = "$hari_ini, $tgl $bulan $tahun";

        $template = FCPATH . 'assets/Aqad_ijarah_peminjam_pulsa.docx';

        $data['GeneratedFileName'] = "Aqad_ijarah_peminjam_pulsa$id_project.docx";
        $data['folderGenerated'] = "assets/pdf"; // nama folder untuk menyimpan hasil generate dokumen
        $userData[0]['id_project'] = "$id_project";
        $userData[0]['tgl'] = "$tanggal";
        $userData[0]['nama_peminjam'] = "$nama_peminjam";
        $userData[0]['nama_toko'] = "$nama_toko";
        $userData[0]['ktp_peminjam'] = "$ktp_peminjam";
        $userData[0]['alamat_peminjam'] = "$alamat_peminjam";
        $userData[0]['modal'] = "$modal";
        $userData[0]['trblg_modal'] = "$trblg_modal";
        $userData[0]['pengembalian_dana'] = "$pengembalian_dana";
        $userData[0]['trblg_pengembalian_dana'] = "$trblg_pengembalian_dana";
        $userData[0]['ujrah'] = "$ujrah";
        $userData[0]['marjin_keuntungan'] = "$marjin_keuntungan";
        $userData[0]['trblg_ujrah'] = "$trblg_ujrah";
        $userData[0]['pinjaman_tf'] = "$pinjaman_tf";
        $userData[0]['trblg_pinjaman_tf'] = "$trblg_pinjaman_tf";
        $userData[0]['jatuh_tempo'] = "$tempo";
        $userData[0]['va_project'] = "$va";
        $userData[0]['mitra'] = "$mitra";
        $userData[0]['tlp_peminjam'] = "$tlp_peminjam";
        $userData[0]['email_peminjam'] = "$email_peminjam";
        $userData[0]['harga_jual'] = "";
        $userData[0]['trblg_harga_jual'] = "";
        $userData[0]['tenor'] = "$tenor";
        $userData[0]['denda'] = "";
        $userData[0]['trblg_denda'] = "";

        $this->tbswrapper->tbsLoadTemplate($template);
        $this->tbswrapper->namafile = $data['GeneratedFileName'];
        $this->tbswrapper->folder = FCPATH . $data['folderGenerated'] . "/";
        $this->tbswrapper->tbsMergeField('vars', $userData);
        $this->tbswrapper->tbsMergeBlock('user', $userData);

        if ($this->tbswrapper->tbsRender()) {
            // force_download(FCPATH . "" . $data['folderGenerated'] . "/\\" . $data['GeneratedFileName'], NULL);
            force_download('./assets/pdf/' . $data['GeneratedFileName'], NULL);
            $this->kirim_akad_ijarah($id);
        } else {
            $this->session->set_flashdata('message', lang('error_generate_dokumen'));
            redirect('home');
        }
    }

    function kirim_akad_peminjam($id_anggota)
    {
        $email_user = $this->db_fulus->get_where('retail', ['id_anggota' => $id_anggota])->row()->email;

        // konfigurasi email server
        $config = $this->config->item('config_email');

        $this->email->initialize($config);

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');

        // $this->email->from('sinafadhiel@gmail.com', 'Admin Fulusme');
        $this->email->to("$email_user, chesyah@fulusme.id, sinafadhiel@gmail.com");

        // Lampiran email, isi dengan url/path file
        $this->email->attach('./assets/pdf/\Aqad_murabahah_peminjam_pulsa' . $id_anggota . '.docx');

        // Subject email
        $this->email->subject('Akad Murabahah Pengelola Dana');

        // Isi email
        $this->email->message('');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            // echo 'Sukses! Akad berhasil dikirim.';
            redirect('project/daftar');
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    function kirim_akad_ijarah($id)
    {
        $project = $this->db->get_where('trx_project', ['id' => $id])->row_array();
        $idPro = $project['id_project'];
        $namePro = $project['nama_project'];
        $pinjaman = $this->input->post('pinjam_di_tf');
        $ujrah = $this->input->post('ujrah');
        $nominal_pengembalian = $this->input->post('nominal_pengembalian');
        $lender = $this->input->post('lender');
        $total_pendanaan = intval(str_replace(',', '', $nominal_pengembalian)) - intval(str_replace(',', '', $lender));

        $query = $this->db_fulus->select('retail.user_id, retail.id_anggota')->from('project_retail pr')->join('retail', 'retail.id = pr.retail_id')
            ->where('pr.id_project', $idPro)->get()->row();
        $id_peminjam = $query->user_id;
        $id_anggota = $query->id_anggota;
        $data_user = $this->db_fulus->get_where('user', ['id' => $id_peminjam])->row();
        $email_user = $data_user->email;

        // konfigurasi email server
        $config = $this->config->item('config_email');
        $this->email->initialize($config);

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim penerima server
        $this->email->from('noreply@fulusme.id', 'Admin Fulusme');

        // $this->email->from('sinafadhiel@gmail.com', 'Admin Fulusme');
        $this->email->to("$email_user, sinafadhiel@gmail.com");

        $this->email->attach('./assets/pdf/\Aqad_ijarah_peminjam_pulsa' . $idPro . '.docx');

        $this->email->subject('Akad Ijarah');

        $this->email->message('
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
            </head>
            <body>
            <div style="width: 650px; border : 2px solid #00FFFF; padding: 20px;">
                <h2 class="card-title">Fintek Madani</h2>
                <h4 class="card-subtitle mb-2 text-muted">Jakarta, ' . date('d F Y') . '</h4>
                <hr>
                <p class="card-text">
                Terimakasih telah memilih Fulusme sebagai partner anda dalam Pendanaan dengan ini kami menginformasikan
                bahwa dana untuk Proyek anda, <b> ' . $namePro . ' </b> dengan ID <b> ' . $idPro . ' </b> telah terkumpul.  <br><br>
                Untuk detailnya akan tertuang dalam Akad Ijarah yang akan dikirimkan dan ditandatangani sebelum dana di Transfer. <br><br>
                Untuk informasi lebih lanjut silakan hubungi : <br> 
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 50px; height: 22px;"> Telp </td>
                            <td style="width: 10px;"> : </td>
                            <td> +62 21 2555-8986 </td>
                        </tr>
                        <tr>
                            <td style="height: 22px;"> WA </td>
                            <td> : </td>
                            <td> XXXXXXXXXXXXXX </td>
                        </tr>
                        <tr>
                            <td style="height: 22px;"> Email </td>
                            <td> : </td>
                            <td> info@fulusme.id </td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            </body>
            </html>
        ');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! Akad berhasil dikirim.';
            // redirect('project/daftar');
        } else {
            echo $this->email->print_debugger();
            die;
        }
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

    function create_borrower_va($data_front)
    {
        $client_id = '00411';
        $secret_key = '58f928b6ee844f344b3f72e282d05314';
        $url = 'https://apibeta.bni-ecollection.com/';
        $customer_id = $data_front['customer_id'];
        $project_id = $data_front['project_id'];
        $customer_name = $data_front['customer_name'];
        $customer_email = $data_front['customer_email'];
        $customer_phone = $data_front['customer_phone'];
        $trx_amount = $data_front['trx_amount'];
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
            $this->db->where('id_project', $project_id);
            $this->db->where('id_peminjam', $customer_id);
            $this->db->update('trx_project', ['virtual_account' => $data_response['virtual_account']]);
            return $datares;
        }
    }

    function send_ujrah($ujrah)
    {
        $curl = curl_init('url_to_post');
        curl_setopt($curl, CURLOPT_URL, 'http://localhost/kantor/surplus_fast/api/fulusme/send_ujrah');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_USERPWD, "fulusme:fulusme321");
        $headers = array(
            'Content-Type:application/json'
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            "ujrah" => $ujrah
        )));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        $api = json_decode($response, true);
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
}
