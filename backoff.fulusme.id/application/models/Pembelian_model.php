<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian_model extends CI_Model
{

    public $data;

    public $data_details;

    public $data_debts = array();

    public $data_keterangan = array();
	
	 public $data_keterangan_trx = array();

    public $identity_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->model('jurnal_model');
        $this->identity_id = $this->session->userdata('IDENTITY_ID');
    }

    public function get_all_data()
    {
       return $this->db->query("SELECT * FROM as_buy_transactions 
            LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_buy_transactions.supplierID
            WHERE buyType = 'PM' AND as_buy_transactions.identityID=" . $this->identity_id )->result();
    }
	
	public function get_all_data_detail($id)
    {
       return $this->db->query("SELECT a.*,b.*,c.*,d.*,e.satuanName as sat1, f.satuanName as sat2 FROM as_buy_detail_transactions a
            LEFT JOIN as_buy_transactions b ON b.invoiceBuyID = a.invoiceBuyID
			 LEFT JOIN as_barang c ON c.barangID = a.bahanID
			 LEFT JOIN as_suppliers d ON d.supplierID = b.supplierID
			  LEFT JOIN as_satuan e ON e.satuanID = a.detailBuySat1
			  LEFT JOIN as_satuan f ON f.satuanID = a.detailBuySat2
            WHERE  b.trxID=" . $id )->result();
    }



    function fill_data()
    {
        $invoiceID = $this->genPembelianNumber();
		$ket_trx = sprintf('%s ; %s ; %s', 
                    $this->input->post('no_faktur'), 
                    $this->input->post('no_po'), 
                    $this->input->post('keterangan') );
        $this->data = array(
            'invoiceBuyID' => $invoiceID,
            'no_dokumen' => $this->input->post('no_po'),
            'identityID' => $this->identity_id,
            'invoiceSupplier' => $this->input->post('no_faktur'),
            'supplierID' => $this->input->post('supplier'),
            'trxDate' =>$this->input->post('tgl_pembelian'),
            'trxSubtotal' => str_replace(',', '', $this->input->post('subtotal') ),
            'trxDiscount' => str_replace(',', '', $this->input->post('diskon') ),
            'trxTotal' => str_replace(',', '', $this->input->post('total') ),
            'trxStatus' => $this->input->post('termin'),
            'note' => $ket_trx,
            'trxPPN' => str_replace(',', '', $this->input->post('pajak') ),
            'buyType' => 'PM'
        );

        $supplierName = $this->db->query("SELECT supplierName FROM as_suppliers WHERE supplierID = " . $this->input->post('supplier'))->row();

        if ( $this->input->post('tgl_termin') ) {
            $this->data['trxTerminDate'] = $this->input->post('tgl_termin');
        }

        if ( $this->input->post('kas_id') ) {
            $this->data['kasID'] = $this->input->post('kas_id');
        }

        if ( '2' == $this->input->post('termin') ) {
            $this->data_debts = array(
                'invoiceID' => $invoiceID,
                'receiveNo' => $this->input->post('no_faktur'),
                'createdDate' => date('Y-m-d')
            );
        }

        // Detail barang
        if ( $this->input->post('detail') ) {
            foreach( $this->input->post('detail') as $detail ) {
                $this->data_details[] = array(
                    'invoiceBuyID' => $invoiceID,
                    'bahanID' => $detail['idbarang'],
                    'detailBuyPrice' => $detail['harga'],
                    'detailBuyQty' => $detail['qty'],
                    'detailBuySat1' => $detail['satuan_1'],
                    'detailBuyQty2' => $detail['qty_2'],
                    'detailBuySat2' => $detail['satuan_2'],
                    'discPercent' => $detail['diskon'],
                    'detailBuySubtotal' => $detail['subtotal'],
                    'createdDate' => date('Y-m-d H:i:s')
                );

                // Barang
                $barang = $this->db->query("SELECT barangBarcode, barangName FROM as_barang WHERE barangID=" . $detail['idbarang'])->row();
                // keterangan jurnal
                $this->data_keterangan[] = sprintf('%s %s %s %d%s@%s', 
                    $this->input->post('no_faktur'), 
                    $barang->barangName, 
                    $supplierName->supplierName, 
                    $detail['qty'], 
                    $this->get_satuan($detail['satuan_1']), 
                    $detail['harga']
                );
            }
        }
    }

    function check_code($id = '')
    {
        $this->db->where('invoiceSupplier', $this->data['invoiceSupplier']);
        if($id != '') $this->db->where('id !=', $id);
        $query = $this->db->get('as_buy_transactions');

        if ($query->num_rows() > 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function get_satuan( $id ) 
    {
        $satuan = $this->db->query("SELECT satuanName FROM as_satuan WHERE satuanID=" . $id)->row();
        return $satuan->satuanName;
    }

    public function insert_data()
    {
        $insert = $this->db->insert('as_buy_transactions', $this->data);
        if ( $insert ) {
            $this->db->insert_batch( 'as_buy_detail_transactions', $this->data_details );

            if ( count( $this->data_debts ) > 0 ) {
                $this->db->insert('as_debts', $this->data_debts );
            }
        }
        return $insert;
    }

    public function genPembelianNumber()
    {
        $trxid = $this->db->query('SELECT * from as_buy_transactions WHERE buyType = "PM" order by trxID desc limit 1;')->row_array();
        $trxdate = $trxid['trxDate'];
        
        $invoiceID = $trxid['invoiceBuyID'];
        
        $d = date("my", strtotime($trxdate));
        
        $tglfktr = date('my');
        
        $invoiceIDfil = substr($invoiceID, 3, 8);
        
        if ($invoiceIDfil == "") {
            
            $trxDate = date('ym');
            
            $trx = 1;
            
            $invoice = sprintf("%04d", $trx);
            
            $invno = $trxDate . $invoice;
            
        }
        else {
            
            $trxDate = date('ym');
            
            $trxd = substr($invoiceIDfil, 0, 4);
            
            if ($trxDate == $trxd) {
                
                $invno = $invoiceIDfil + 1;
                
                $invno = sprintf("%08d", $invno);
                
            }
            
            else {
                
                $trxDate = date('ym');
                
                $trx = 1;
                
                $invoice = sprintf("%04d", $trx);
                
                $invno = $trxDate . $invoice;
                
            }
        }
        
        
        
        return "PM-" . $invno;
    }

}
