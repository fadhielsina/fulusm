<?php

class Piutang_model extends CI_Model
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
	
	function get_data_recv($id)
	{
		$this->db->select('as_receivables.*');
		$this->db->select('as_members.*');
		$this->db->select('as_receivables.receivableID as idrecv');
		$this->db->select('as_receivables_payment.*');
		$this->db->select('sum(as_receivables_payment.receivablePay) as totalbyr');
		$this->db->select('sum(DISTINCT(as_sales_transactions.trxTotal)) as totaltrx');
		$this->db->select('as_sales_transactions.*');
		$this->db->select('as_sales_transactions.identityID as idenID');
		$this->db->from('as_sales_transactions');
		$this->db->join('as_receivables', 'as_receivables.invoiceID=as_sales_transactions.invoiceID', 'left');
		$this->db->join('as_receivables_payment', 'as_receivables_payment.receivableID=as_receivables.receivableID', 'left');
		$this->db->join('as_members', 'as_members.memberID = `as_sales_transactions`.`memberID`', 'left');
		$this->db->where('as_sales_transactions.identityID', $id);
		$this->db->group_by('as_sales_transactions.memberID', 'desc');
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
	
	function get_all_data_piutang()
	{
		$this->db->select('*');
		$this->db->from('as_receivables_bal');
		$this->db->join('as_members', 'as_members.memberID=as_receivables_bal.memberID', 'left');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	
	function simpan_data_term_pay($debtID,$dibayar,$payno){
		$datepay=date('Y-m-d h:i:s');
        $hasil=$this->db->query("INSERT INTO as_receivables_payment (receivableID,receivablePay,receivableDate,recvInv)VALUES('$debtID','$dibayar','$datepay','$payno')");
        return $hasil;
    }
	
	
	function fill_data()
	{
		
		$memberid=$this->input->post('customer');
			$q_data = $this->db->query("SELECT * FROM as_members WHERE memberID = '".$memberid."' ");
			$a_data = $q_data->row();
			$memberCode=$a_data->memberCode;
			$sc_code=$memberCode;
		$akun_ap_d=$this->input->post('akun_ap_d');
		$saldo= str_replace(',','',$this->input->post('saldo'));
		$q_data = $this->db->query("SELECT * FROM akun_saldo WHERE akun_id = '".$akun_ap_d."' ");
        $a_data = $q_data->row();
		$bal=$a_data->saldo;
		$bal1=$a_data->saldo_awal;
		$saldo_ne=$bal+$saldo;
		if($bal1<>0) {
		 $object2    = array(
            'saldo' => $saldo_ne
        );
		}
		else
		{
			 $object2    = array(
            'saldo' => $saldo_ne,
			'saldo_awal' => $saldo_ne
        );
		}
        $this->db->where('akun_id', $akun_ap_d);
        $this->db->update('akun_saldo', $object2);
		
		$identityID=$this->session->userdata('IDENTITY_ID');
		$apcode= $this->genSaldoNumber();
		$this->data = array(
			'invoiceID' => $apcode,
			'memberID' => $this->input->post('customer'),
			'trxDate' =>$this->input->post('tgl_saldo'),
			'trxFakturID' =>$this->input->post('no_bukti'),
			'trxTotal' =>$saldo,
			'note' =>$this->input->post('keterangan'),
			 'identityID' => $identityID,
			 'saleType' => "SP",
			 'is_saldo' =>1
		);
		
		 $objectdebt       = array(
            'invoiceID' => $apcode,
			'createdDate'=>date('Y-m-d')
        );
		
        $this->db->insert('as_receivables', $objectdebt);
		// Jurnal Saldo Awal
		$this->jurnal_model->data = array(
			'no' =>  $this->jurnal_model->GenJsp(),
			'tgl' => $this->input->post('tgl_saldo'),
			'f_id' => 9,
			'invoice_no' => $apcode,
			'keterangan' => $this->input->post('keterangan'),
			'identityID' => $this->session->userdata('IDENTITY_ID'),
			'sc_id' => $this->input->post('customer'),
			'sc_code' => $sc_code,
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$akun = array();
		$akun[1] = array(
			'akun_id' => $this->input->post('akun_ap_d'), 
			'debit_kredit' => 1,
			'nilai' => $saldo,
			'keterangan' => ''
		);

		$akun[] = array(
				'akun_id' => $this->input->post('akun_ap_k'),
				'debit_kredit' => 0,
				'nilai' => $saldo,
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
		$insert = $this->db->insert('as_sales_transactions', $this->data);
		return $insert;
	}


	function Gensaldo()
		{
		$identityCode=$this->session->userdata('identityCode');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$q_data = $this->db->query("SELECT * from as_receivables_bal where identityID='".$identityID."' order by receivableID desc limit 1 ");
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
			$kode="SP".$identityCode.$memberid_new_count2;
		}
		else 
		{
			$kode="SP".$identityCode."00001";
		}
		return $kode;
		}
		
		
		public function genSaldoNumber()
    {
        $trxid = $this->db->query('SELECT * from as_sales_transactions WHERE saleType = "SP" order by trxID desc limit 1;')->row_array();
        $trxdate = $trxid['trxDate'];
        
        $invoiceID = $trxid['invoiceID'];
        
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
        
        
        
        return "SP-" . $invno;
    }
		
}
/* End of file akun_model.php */
/* Location: ./application/models/akun_model.php */
