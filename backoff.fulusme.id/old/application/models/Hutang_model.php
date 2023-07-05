<?php

class Hutang_model extends CI_Model
{

	var $data;

	public $identity_id;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->identity_id = $this->session->userdata('IDENTITY_ID');
	}

	function table_add($data)
	{

		if ($this->db->insert($this->table, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function get_all_data_hutang()
	{
		$this->db->select('as_debts.debtID as iddebt');
		$this->db->select('as_debts.*');
		$this->db->select('as_debts_payment.*');
		$this->db->select('sum(as_debts_payment.debtPay) as totalbyr');
		$this->db->select('as_buy_transactions.*');
		$this->db->select('login.*');
		$this->db->select('as_tipe_bayar.name as met_bayar');
		$this->db->from('as_debts');
		$this->db->join('as_buy_transactions', 'as_buy_transactions.invoiceBuyID=as_debts.invoiceID', 'left');
		$this->db->join('as_debts_payment', 'as_debts_payment.debtID=as_debts.debtID', 'left');
		$this->db->join('as_tipe_bayar', 'as_tipe_bayar.id=as_debts_payment.payMethod', 'left');
		$this->db->join('login', 'login.id=as_buy_transactions.userID', 'left');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	function fill_data()
	{
		$akun_ap_d=$this->input->post('akun_ap_d');
		$q_data = $this->db->query("SELECT * FROM akun_saldo WHERE akun_saldo_id = '".$akun_ap_d."' ");
        $a_data = $q_data->row();
		$bal=$a_data->saldo;
		$bal_1=$a_data->saldo_awal;
		$saldo_ne=$bal+$this->input->post('saldo');
		$saldotrx=str_replace(',', '', $this->input->post('saldo') );
		 $id    = $this->input->post('inv');
		 if($bal_1=="0") {
			$object2    = array(
            'saldo' => $saldo_ne,
			'saldo_awal' => $bal
        );
		}
		else{
			$object2    = array(
            'saldo' => $saldo_ne
        );
		}
		 
        $this->db->where('akun_saldo_id', $akun_ap_d);
        $this->db->update('akun_saldo', $object2);
		
		
		
		$identityID=$this->session->userdata('IDENTITY_ID');
		$apcode= $this->genSaldoNumber();
		$this->data = array(
			'invoiceOrderID' => $apcode,
			'supplierID' => $this->input->post('supplier'),
			'trxDate' =>$this->input->post('tgl_saldo'),
			'no_dokumen' =>$this->input->post('no_bukti'),
			'trxTotal' =>$saldotrx,
			'note' =>$this->input->post('keterangan'),
			 'identityID' => $identityID,
			 'buyType' => "SH",
			 'is_saldo' =>1
		);
		
		  $objectdebt       = array(
            'invoiceID' => $apcode,
			'createdDate'=>date('Y-m-d')
        );
		
        $this->db->insert('as_debts', $objectdebt);
		
		// Jurnal Saldo Awal
		$this->jurnal_model->data = array(
			'no' =>  $this->jurnal_model->GenJsa(),
			'tgl' => $this->input->post('tgl_saldo'),
			'f_id' => 8,
			'invoice_no' => $apcode,
			'keterangan' => $this->input->post('keterangan'),
			'identityID' => $this->session->userdata('IDENTITY_ID'),
			'sc_id' => $this->input->post('supplier'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$akun = array();
		$akun[1] = array(
			'akun_id' => $this->input->post('akun_ap_d'), 
			'debit_kredit' => 1,
			'nilai' => $saldotrx,
			'keterangan' => ''
		);

		$akun[] = array(
				'akun_id' => $this->input->post('akun_ap_k'), // utang dagang
				'debit_kredit' => 0,
				'nilai' => $saldotrx,
				'keterangan' => ''
			);

		// resorting item key
		foreach( $akun as $key => $v_ak ) {
			$akun[ $key ]['item'] = $key;
		}

		$this->jurnal_model->details = $akun;
		if ($this->jurnal_model->check_no()) {
			$this->jurnal_model->insert_data();
		}
	}
	
	 function insert_data()
	{
		$insert = $this->db->insert('as_order_transactions', $this->data);
		return $insert;
	}

	 public function genSaldoNumber()
    {
        $trxid = $this->db->query('SELECT * from as_order_transactions WHERE buyType = "SH" order by trxID desc limit 1;')->row_array();
        $trxdate = $trxid['trxDate'];
        
        $invoiceID = $trxid['invoiceOrderID'];
        
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
        
        
        
        return "SH-" . $invno;
    }
	
	function Gensaldo()
		{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$q_data = $this->db->query("SELECT * from as_debt_bal where identityID='".$identityID."' order by debtID desc limit 1 ");
		$a_data = $q_data->row();
		if($a_data){
		$memberid=$a_data->no_trx_bal;
		}
		else{
			$memberid='';
		}
		if($memberid<>"")
		{
			$memberid_count = substr($memberid, 4, 5);
			$memberid_new_count=$memberid_count+1;
			$memberid_new_count2 = sprintf("%05d", $memberid_new_count);
			$kode="SH".$identityCode.$memberid_new_count2;
		}
		else 
		{
			$kode="SH".$identityCode."00001";
		}
		return $kode;
		}
		
}
/* End of file akun_model.php */
/* Location: ./application/models/akun_model.php */
