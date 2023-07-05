<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{

    public $data;

    public $data_details;

    public $data_receivables = array();

    public $data_keterangan = array();

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
       return $this->db->query("SELECT * FROM as_sales_transactions 
            LEFT JOIN as_members ON as_members.memberID = as_sales_transactions.memberID
            WHERE saleType = 'PJM' AND as_sales_transactions.identityID=" . $this->identity_id )->result();
    }
	
	public function get_all_data_detail($id)
    {
       return $this->db->query("SELECT a.*,b.*,c.*,d.*,e.satuanName as sat1, f.satuanName as sat2 FROM as_sales_detail_transactions a
            LEFT JOIN as_sales_transactions b ON b.invoiceID = a.invoiceID
			 LEFT JOIN as_barang_jual c ON c.barangBarcode = a.productBarcode
			 LEFT JOIN as_members d ON d.memberID = b.memberID
			  LEFT JOIN as_satuan e ON e.satuanID = a.detailSat1
			  LEFT JOIN as_satuan f ON f.satuanID = a.detailSat2
            WHERE  b.trxID=" . $id )->result();
    }

    function fill_data()
    {
        $invoiceID = $this->genNumber();
		$ket_trx = sprintf('SJ%s ; %s ; %s', 
                    $this->input->post('no_faktur'), 
                    $this->input->post('no_po'), 
					 $this->input->post('keterangan') );
        $this->data = array(
            'invoiceID' => $invoiceID,
            'trxPOID' => $this->input->post('no_po'),
            'identityID' => $this->identity_id,
            'trxFakturID' => $this->input->post('no_faktur'),
            'memberID' => $this->input->post('pelanggan'),
            'trxDate' => date('Y-m-d'),
            'trxSubtotal' => str_replace(',', '', $this->input->post('subtotal') ),
            'trxDiscount' => str_replace(',', '', $this->input->post('diskon') ),
            'trxTotal' => str_replace(',', '', $this->input->post('total') ),
            'trxStatus' => $this->input->post('termin'),
            'note' => $ket_trx,
            'trxPPN' => str_replace(',', '', $this->input->post('pajak') ),
            'saleType' => 'PJM'
        );

        $memberName = $this->db->query("SELECT memberFullName FROM as_members WHERE memberID = " . $this->input->post('pelanggan'))->row();

        if ( $this->input->post('tgl_termin') ) {
            $this->data['trxTerminDate'] = $this->input->post('tgl_termin');
        }

        if ( '2' == $this->input->post('termin') ) {
            $this->data_receivables = array(
                'invoiceID' => $invoiceID,
                'createdDate' => date('Y-m-d')
            );
        }

        // Detail barang
        if ( $this->input->post('detail') ) {
            foreach( $this->input->post('detail') as $detail ) {
                $this->data_details[] = array(
                    'invoiceID' => $invoiceID,
                    'productBarcode' => $detail['idbarang'],
                    'detailPrice' => $detail['harga'],
                    'detailQty' => $detail['qty'],
                    'detailSat1' => $detail['satuan_1'],
                    'detailQty2' => $detail['qty_2'],
                    'detailSat2' => $detail['satuan_2'],
                    'discPercent' => $detail['diskon'],
                    'detailSubtotal' => $detail['subtotal'],
                    'createdDate' => date('Y-m-d H:i:s')
                );

                // Barang
                $barang = $this->db->query("SELECT barangBarcode, barangName FROM as_barang_jual WHERE barangBarcode='" . $detail['idbarang'] ."'")->row();
                // keterangan jurnal
                $this->data_keterangan[] = sprintf('SJ%s %s %s %d%s@%s', 
                    $this->input->post('no_faktur'), 
                    $barang->barangName, 
                     $memberName->memberFullName, 
                    $detail['qty'], 
                    $this->get_satuan($detail['satuan_1']), 
                    $detail['harga']
                );
            }
        }
    }

    function check_code($id = '')
    {
        $this->db->where('trxFakturID', $this->data['trxFakturID']);
        if($id != '') $this->db->where('id !=', $id);
        $query = $this->db->get('as_sales_transactions');

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
        $insert = $this->db->insert('as_sales_transactions', $this->data);
        if ( $insert ) {
            $this->db->insert_batch( 'as_sales_detail_transactions', $this->data_details );

            if ( count( $this->data_receivables ) > 0 ) {
                $this->db->insert('as_receivables', $this->data_receivables );
            }
        }
        return $insert;
    }

    public function genNumber()
    {
        $trxid = $this->db->query('SELECT * from as_sales_transactions WHERE saleType = "PJM" order by trxID desc limit 1;')->row_array();
        $trxdate = $trxid['trxDate'];
        
        $invoiceID = $trxid['invoiceID'];
        
        $d = date("my", strtotime($trxdate));
        
        $tglfktr = date('my');
        
        $invoiceIDfil = substr($invoiceID, 4, 9);
        
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
        
        
        
        return "PJM-" . $invno;
    }

}
