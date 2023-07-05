<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Harta_model extends CI_Model
{

    var $data;

    public $identity_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->model('jurnal_model');
        $this->identity_id = $this->session->userdata('IDENTITY_ID');
    }

    function GenJurNumber()
    {
        $trxid = $this->db->query('SELECT * from kelompok_harta order by id desc limit 1;')->row_array();
        $trxdate = date('Y-m-d');
        $produksiID = $trxid['kode'];
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

        $kode = "FG-" . date('d') . "-" . $invno;
        return $kode;
    }

    function get_all_data()
    {
        return $this->db->get_where('kelompok_harta', ['status' => 1])->result();
    }

    function get_all_akun()
    {
        $this->db->select('id, nama, kode, saldo_awal, saldo');
        $this->db->from('akun');
        $this->db->where('LENGTH(kode) > 2');
        return $this->db->get()->result();
    }

    function insertData()
    {
        $nama = $this->input->post('nama_kelompok');
        $umur = $this->input->post('umur_ekonomis');
        $ket = $this->input->post('keterangan');
        $metode = $this->input->post('metode_depresiasi');
        $akun_harta = $this->input->post('akun_harta');
        $akun_akumulasi = $this->input->post('akun_akumulasi');
        $akun_depresiasi = $this->input->post('akun_depresiasi');

        $data = [
            'kode' => $this->GenJurNumber(),
            'nama_kelompok' => $nama,
            'umur' => $umur,
            'metode' => $metode,
            'akun_harta' => $akun_harta,
            'akun_akumulasi' => $akun_akumulasi,
            'akun_depresiasi' => $akun_depresiasi,
            'keterangan' => $ket,
            'status' => 1
        ];
        $this->db->insert('kelompok_harta', $data);
    }

    function editData($id)
    {
        $kode = $this->input->post('kode');
        $nama = $this->input->post('nama_kelompok');
        $umur = $this->input->post('umur_ekonomis');
        $ket = $this->input->post('keterangan');
        $metode = $this->input->post('metode_depresiasi');
        $akun_harta = $this->input->post('akun_harta');
        $akun_akumulasi = $this->input->post('akun_akumulasi');
        $akun_depresiasi = $this->input->post('akun_depresiasi');

        $data = [
            'kode' => $kode,
            'nama_kelompok' => $nama,
            'umur' => $umur,
            'metode' => $metode,
            'akun_harta' => $akun_harta,
            'akun_akumulasi' => $akun_akumulasi,
            'akun_depresiasi' => $akun_depresiasi,
            'keterangan' => $ket,
            'status' => 1
        ];
        $this->db->where('id', $id);
        $this->db->update('kelompok_harta', $data);
    }

    function insert_data_pembelian_asset()
    {
        $get_supplier = $this->db->get_where('as_suppliers', ['supplierID' => $this->input->post('supplier')])->row();
        $invoiceBuyID = $this->genDetailBuyNumber('PF');
        $kelompok_hartas = array();
        $data = array(
            'invoiceBuyID' => $invoiceBuyID,
            'identityID' => $this->session->userdata('IDENTITY_ID'),
            'supplierID' => $this->input->post('supplier'),
            'trxFullName' => $get_supplier->supplierName,
            'trxDate' => $this->input->post('tgl_pembelian'),
            'trxSubtotal' => $this->input->post('subtotal'),
            'trxDiscount' => $this->input->post('diskon'),
            'trxTotal' => $this->input->post('total'),
            'note' => $this->input->post('keterangan'),
            'trxPPN' => $this->input->post('pajak'),
            'trxbankmethod' => $this->input->post('termin'),
            'is_fixed_asset' => 1,
             'utangID' => $this->input->post('utang_id'),
            'is_ppn' => $this->input->post('pajak_apply')
        );

        if ( '2' == $this->input->post('termin') ) {
            $data['trxTerminDate'] = $this->input->post('tgl_termin');

            $debts = array(
                'invoiceID' => $invoiceBuyID,
                'createdDate' => date('Y-m-d'),
                'terminDate' => $data['trxTerminDate']
            );
            $this->db->insert('as_debts', $debts);
        } else {
            $data['kasID'] = $this->input->post('kas_id');
        }

        $this->db->insert('as_buy_transactions', $data);
        $id = $this->db->insert_id();

        $details = $this->input->post('detail');

        if ( is_array( $details ) ) {
            foreach( $details as $d ) {
                $code = 'auto' == $d['kode'] ? $this->genDetailBuyNumber('HT', 'buy_detail') : $d['kode'];
                $data = array(
                    'invoiceBuyID' => $invoiceBuyID,
                    'detailBuyCode' => $code,
                    'detailBuyName' => $d['nama_item'],
                    'detailBuyPrice' => $d['harga'],
                    'detailBuyQty' => $d['qty'],
                    'discPercent' => $d['discount_percentage'],
                    'detailBuySubtotal' => $d['subtotal'],
                    'identityID' => $d['lokasi'],
                    'keterangan' => $d['keterangan'],
                    'residu' => $d['residu'],
                    'trxPPN' => $d['pajak'],
                    'tgl_pakai' => $d['tgl_pakai'],
                    'umur_ekonomis' => $d['umur_ekonomis'],
                    'kelompokHartaID' => $d['kelompok_asset']
                );
                $this->db->insert('as_buy_detail_transactions', $data);
                $kelompok_hartas[] = array(
                    'harta_id' => $d['kelompok_asset'],
                    'subtotal' => $d['subtotal']
                );
            }
        }

        // Jurnal the data
        $this->jurnal_model->data = array(
            'no' =>  $this->jurnal_model->GenJpb(),
            'tgl' => $this->input->post('tgl_pembelian'),
            'f_id' => 4,
            'invoice_no' => $invoiceBuyID,
            'identityID' => $this->session->userdata('IDENTITY_ID'),
            'keterangan' => $this->input->post('keterangan'),
            'login_id' => $this->session->userdata('SESS_USER_ID'),
            'waktu_post' => date("Y-m-d H:i:s")
        );
        $totalbil = $this->input->post('total');
        $ppn = 0;
        $akun = array();
        foreach( $kelompok_hartas as $k => $ak_harta ) {
            $akun[ $k + 1 ] = array(
                'akun_id' => $this->input->post('aset_akun'), 
                'debit_kredit' => 1,
                'nilai' => $totalbil,
                'keterangan' => ''
            );
        }

     /*    if( '1' == $this->input->post('pajak_apply') ){
            $ppn = $this->input->post('pajak');
            $akun[] = array(
                'akun_id' => 37, // ppn masukan
                'debit_kredit' => 1,
                'nilai' => $ppn,
                'keterangan' => ''
            );  
        } */

        if ( '2' == $this->input->post('termin') ) {
            $akun[] = array(
                'akun_id' =>$this->input->post('utang_id'),  // utang pembelian aktiva
                'debit_kredit' => 0,
                'nilai' => $totalbil,
                'keterangan' => ''
            );
        } else {
            $akun[] = array(
                'akun_id' => $this->input->post('kas_id'), // kas id
                'debit_kredit' => 0,
                'nilai' => $totalbil,
                'keterangan' => ''
            );
        }

        // resorting item key
        foreach( $akun as $key => $v_ak ) {
            $akun[ $key ]['item'] = $key;
        }

        $this->jurnal_model->details = $akun;
        if ($this->jurnal_model->check_no()) {
            $this->jurnal_model->insert_data();
        }

    }

    function edit_data_pembelian_asset()
    {
        $get_supplier = $this->db->get_where('as_suppliers', ['supplierID' => $this->input->post('supplier')])->row();
        $invoiceBuyID = $this->input->post('no_pembelian');
        $data = array(
            'invoiceBuyID' => $invoiceBuyID,
            'identityID' => $this->session->userdata('IDENTITY_ID'),
            'supplierID' => $this->input->post('supplier'),
            'trxFullName' => $get_supplier->supplierName,
            'trxDate' => $this->input->post('tgl_pembelian'),
            'trxSubtotal' => $this->input->post('subtotal'),
            'trxDiscount' => $this->input->post('diskon'),
            'trxTotal' => $this->input->post('total'),
            'note' => $this->input->post('keterangan'),
            'trxPPN' => $this->input->post('pajak'),
            'trxbankmethod' => $this->input->post('termin'),
            'is_fixed_asset' => 1
        );

        if ( '2' == $this->input->post('termin') ) {
            $data['trxTerminDate'] = $this->input->post('tgl_termin');

            $debts = array(
                'modifiedDate' => date('Y-m-d H:i:s'),
                'terminDate' => $data['trxTerminDate']
            );
            $this->db->where('invoiceID', $invoiceBuyID);
            $this->db->update('as_debts', $debts);
        }

        $this->db->where('invoiceBuyID', $invoiceBuyID);
        $this->db->update('as_buy_transactions', $data);
        
        $details = $this->input->post('detail');
        if ( is_array( $details ) ) {
            foreach( $details as $d ) {
                $data = array(
                    'detailBuyName' => $d['nama_item'],
                    'detailBuyPrice' => $d['harga'],
                    'detailBuyQty' => $d['qty'],
                    'discPercent' => $d['discount_percentage'],
                    'detailBuySubtotal' => $d['subtotal'],
                    'identityID' => $d['lokasi'],
                    'keterangan' => $d['keterangan'],
                    'residu' => $d['residu'],
                    'trxPPN' => $d['pajak'],
                    'tgl_pakai' => $d['tgl_pakai'],
                    'umur_ekonomis' => $d['umur_ekonomis'],
                    'kelompokHartaID' => $d['kelompok_asset']
                );
                $this->db->where('detailBuyCode', $d['kode']);
                $this->db->update('as_buy_detail_transactions', $data);
            }
        }

    }

    public function genDetailBuyNumber($prefix = '', $db = '')
    {
        if ( 'buy_detail' == $db ) {
            $trxid = $this->db->query('SELECT * from as_buy_detail_transactions order by detailID desc limit 1;')->row_array();
            $produksiID = $trxid['detailBuyCode'];
        } else {
            $trxid = $this->db->query('SELECT * from as_buy_transactions WHERE is_fixed_asset = 1 order by trxID desc limit 1;')->row_array();
            $produksiID = $trxid['invoiceBuyID'];
        }
        $trxdate = date('Y-m-d');
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

        $kode = $prefix . "-" . date('d') . "-" . $invno;
        return $kode;
    }

    public function get_kelompok_harta( $harta_id, $column = 'akun_harta' )
    {
        $query = $this->db->query('SELECT '. $column .' FROM kelompok_harta WHERE id = '. $harta_id.';')->row_array();
        if ( isset( $query[ $column ] ) )
            return $query[ $column ];
        return false;
    }

    public function get_aktiva_tetap()
    {
        $query = $this->db->query("
            select ab.invoiceBuyID, ab.trxDate, abd.tgl_pakai, abd.umur_ekonomis, 
            abd.kelompokHartaID, abd.detailBuyCode, abd.last_periode, abd.detailBuySubtotal, abd.residu,
            kh.akun_akumulasi, kh.akun_depresiasi
            from as_buy_transactions ab
            left join as_buy_detail_transactions abd ON ab.invoiceBuyID = abd.invoiceBuyID
            left join kelompok_harta kh ON abd.kelompokHartaID = kh.id
            WHERE ab.is_fixed_asset = 1
            ")->result_array();

        if ( is_array( $query ) && count( $query ) > 0 ) {
            return $query;
        } else {
            return FALSE;
        }
    }

    public function get_harta_lists( $tgl, $identity_id = null )
    {
        if ( is_null( $identity_id ) )
            $identity_id = $this->identity_id;
        
        $tgl = date('Y-m-d', strtotime( $tgl ) );
        return $this->db->query("SELECT aset.* , buy.trxDate 
            FROM as_buy_detail_transactions aset
            LEFT JOIN as_buy_transactions buy ON buy.invoiceBuyID = aset.invoiceBuyID 
            WHERE buy.trxDate <= '{$tgl}' AND buy.identityID = " . $identity_id)->result();
    }

}
