<?php

class Laporankeuangan_model extends CI_Model {

	var $data;

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function get_data()
	{		
		$query = $this->db->get('lap_pph21');
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}

	function fill_data()
	{
		$this->data = array(
			'npwp' => $this->input->post('npwp'),
			'nama' => $this->input->post('nama_wp'),
			'alamat' => $this->input->post('alamat'),			
			'telpon' => $this->input->post('telpon'),			
			'fax' => $this->input->post('fax'),			
			'email' => $this->input->post('email'),			
			'jenis_usaha' => $this->input->post('jenis'),			
			'klu' => $this->input->post('klu'),			
			'pemilik' => $this->input->post('nama_pemilik'),			
			'npwp_pemilik' => $this->input->post('npwp_pemilik'),			
			'keterangan' => $this->input->post('keterangan')					
		);			

	}
		
	function insert_data()
	{
		$insert = $this->db->insert('lap_pph21', $this->data);
		return $insert;
	}
	
		public function get_laporan_pendapatan($id,$tanggal1,$tanggal2)
	{
     if($tanggal1)
	 {
		 $where1=" and a.trxDate >= '".$tanggal1."' ";
	 }
	 else { $where1="";}
	 
	   if($tanggal2)
	 {
		 $where2=" and a.trxDate <= '".$tanggal2."' ";
	 }
	 else { $where2="";}
	 
		return $query_cek=$this->db->query("SELECT a.*,b.*,c.*,d.*,b.keterangan as ket_jurnal FROM as_sales_transactions a left join jurnal b  on a.invoiceID=b.invoice_no left join jurnal_detail c on b.id=c.jurnal_id left join akun d on d.id=c.akun_id  WHERE d.kelompok_akun_id='4' and a.identityID = '".$id."' $where1 $where2 group by b.id");
				
	}
	
		public function get_laporan_pendapatan_bank($id,$tanggal1,$tanggal2,$jns_byr)
	{
		
		if($this->session->userdata('ADMIN')!='1')
		{
		$whereiden="where a.identityID = '".$id."'";
		}
		else
		{
			if($id!=' ')
				{
					$whereiden="where a.identityID = '".$id."'";
				}
				else{
					$whereiden="where a.identityID != '".null."'";
				}
		}
		
     if($tanggal1)
	 {
		 $where1=" and a.trxDate >= '".$tanggal1."' ";
	 }
	 else { $where1="";}
	 
	   if($tanggal2)
	 {
		 $where2=" and a.trxDate <= '".$tanggal2."' ";
	 }
	 else { $where2="";}
	 
	  if($jns_byr=="0")
	 {
		 $where_type="";
	 }
	 
	 else  if($jns_byr=="1")
	 {
		 $where_type=" and a.trxbankmethod='1'";
	 }
	 
	  else  if($jns_byr=="2")
		  
	{
		$where_type=" and a.trxbankmethod='2'";
	}
	
	
		return $query_cek=$this->db->query("SELECT a.*,b.*,c.*,d.*,b.keterangan as ket_jurnal,d.name as nm_tipe FROM as_sales_transactions a left join jurnal b  on a.invoiceID=b.invoice_no left join jurnal_detail c on b.id=c.jurnal_id left join as_tipe_bayar d on d.id=a.trxbankmethod  $whereiden $where_type $where1 $where2 group by b.id");
				
	}
	
	function get_data_lokasi()
	{
		$this->db->select('*');
		$this->db->from('as_identity');
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

}
/* End of file pajak_model.php */
/* Location: ./application/models/pajak_model.php */
