<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surplus_model extends CI_Model {
	public $table = "akun";
	public $primary = "id";
	private $finance_DB;
	
    public function __construct()
    {
        parent::__construct();
        $this->finance_DB = $this->load->database('mysql_finance', TRUE);

        return $this->finance_DB;
    }

    function get_all($condition=""){
    	if($condition !="")
    	{
    		$this->finance_DB->where($condition);
    	}

    	return $this->finance_DB->get($this->table);

    }
	
	function table_add($data){
		
		if ($this->finance_DB->insert($this->table,$data)) {
			return $this->finance_DB->insert_id();
		} else {
			return false;
		}	
	
	}
	function table_update($id,$data){
		
		//if($this->role_exists($id) == false){
		//	$this->table_add($data);
		//	return true;
		//}else{
			$this->finance_DB->where($this->primary, $id);
			$this->finance_DB->update($this->table,$data);
			//var_dump($this->finance_DB->affected_rows());
			//die();
			if($this->finance_DB->affected_rows() > 0)
			{	
				return true;
			} else {
				return "Tidak ada data yang diubah";
			}	
		//}
	}
	function check_exists($condition)
	{
		$this->finance_DB->where($condition);
		$query = $this->finance_DB->get($this->table);
		
		if ($query->num_rows() > 0){
			return array("respon"=>true,"data"=>$query->row());
		}
		else{
			return array("respon"=>false,"data"=>"");
		}
	}

	function insert_or_duplicate_update_batch($dataPOInsert,$dataPOUpdate="",$data="",$dataUpdate=""){
		$respon['update'] = 0;
		$respon['insert'] = 0;
		$respon['updateDebt'] = 0;
		$respon['insertDebt'] = 0;
		$respon['updateTrans'] = 0;
		$respon['insertTrans'] = 0;


		if($dataPOUpdate !=""){
			if(count($dataPOUpdate)>0){
				if($this->finance_DB->update_batch($this->table,$dataPOUpdate,$this->primary)){
					$respon['update']++;
				}
			}
		}
		if(isset($dataPOInsert)){
			if(count($dataPOInsert)>0){
				if($this->finance_DB->insert_batch($this->table,$dataPOInsert)){
					$respon['insert']++;
				}
			}
		}

		if(isset($dataUpdate['debt'])){
			if(count($dataUpdate['debt'])>0){
				if($this->finance_DB->update_batch("as_debts",$dataUpdate['debt'],"invoiceID")){
					$respon['updateDebt']++;
					
				}
			}
		}

		if(isset($data['debt'])){
			if(count($data['debt'])>0){
				//$DebtInput = $this->_insert_on_duplicate_update_batch('as_debts','id',$data['debt']);
				if($this->finance_DB->insert_batch("as_debts",$data['debt'],"invoiceID")){
					$respon['insertDebt']++;
				}

			}
		}

		if(isset($dataUpdate['trans'])){
			if(count($dataUpdate['trans'])>0){
				if($this->finance_DB->update_batch("as_buy_transactions",$dataUpdate['trans'],"invoiceBuyID")){
					$respon['updateTrans']++;
				}
			}
		}

		if(isset($data['trans'])){
			if(count($data['trans'])>0){
				if($this->finance_DB->insert_batch("as_buy_transactions",$data['trans'])){
					$respon['insertTrans']++;
				}
			}
		}

		return $respon;	
	}
	

	function GenJurNumber()
		{

		$trxid = mysql_fetch_array(mysql_query('SELECT * from jurnal order by id desc limit 1;'));
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 6, 8);
		if ($produksiIDfil == "")
			{ 
			$trxDate = date('my');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
			}
		  else
			{
			$trxDate = date('my');
			$trxd = substr($produksiIDfil, 0, 4);
			if ($trxDate == $trxd)
				{
				$invno = $produksiIDfil + 1;
				$invno = sprintf("%08d", $invno);
				}
			  else
				{
				$trxDate = date('my');
				$trx = 1;
				$invoice = sprintf("%04d", $trx);
				$invno = $trxDate . $invoice;
				}
			}

		$kode = "JI-". date('d')."-". $invno;
		return $kode;
		}
		
		function GenKasNumber($jns)
		{
		$trxid = mysql_fetch_array(mysql_query('SELECT * from tbl_trans_kas order by id desc limit 1;'));
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no_trx_kas'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 6, 8);
		if ($produksiIDfil == "")
			{ 
			$trxDate = date('my');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
			}
		  else
			{
			$trxDate = date('my');
			$trxd = substr($produksiIDfil, 0, 4);
			if ($trxDate == $trxd)
				{
				$invno = $produksiIDfil + 1;
				$invno = sprintf("%08d", $invno);
				}
			  else
				{
				$trxDate = date('my');
				$trx = 1;
				$invoice = sprintf("%04d", $trx);
				$invno = $trxDate . $invoice;
				}
			}

		$kode = $jns."-".date('d')."-". $invno;
		return $kode;
		}

	function _insert_on_duplicate_update_batch($table, $keysID, $data)
	{
	   $mysql = "";
	   foreach($data as $item){
	   		$keys = array_keys($item);
	   		$values = array_values($item);
	   		$cek = $this->db->select('*')->from($table)->WHERE($keysID,$item[$keysID])->get()->result_array();
	   		if(count($cek) >0){
	   			$this->db->update($table,$item,array($keysID=>$item[$keysID]));
	   			/*$mysql .=  "UPDATE  ".$table." SET ";
	   			foreach ($keys as $key) {
	   				 $mysql .= $keys."='".$item[$key]."'";
	   			}
	   			$mysql .=" WHERE ".$keysID."='".$item[$keysID]."'; ";*/
	   		}else{
	   			$this->db->insert($table,$item);
	   			/*$mysql .=  "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES ('".implode('\',\' ',$values)."'); ";*/
	   		}

	   }	
	   //die($mysql);
	  // return $this->db->query($mysql);
	  
	  
	}
	
}
?>