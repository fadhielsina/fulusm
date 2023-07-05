<?php

class Saldo extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->helper(array('url','form'));
		$this->load->model('saldo_model');
		$this->load->model('akun_model');
		$this->load->model('jurnal_model');
	}
	
	
	function data_saldo_piutang()
	{
		
		
		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['title'] = "Saldo Piutang";
		$data['main_content'] = 'saldo/display_saldo';
		$data['kas_data'] = $this->saldo_model->get_all_data_recv_bal($tanggal1,$tanggal2);
		$this->load->view('template/template_xpanel', $data);
	}
	
	function add_saldo_piutang()
	{
		$data['f_id'] = 1;
		$no_ref= $this->GenRefNumber();
		

		$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

		if($pageWasRefreshed ) {
			//do something because page was refreshed;
		} else {
			$object  = array(    
			'no_trx_bal' =>  $no_ref,
			'tgl_catat' => date("Y-m-d"),
			'createdUserID' => $this->session->userdata('SESS_USER_ID')
			);
			$this->db->insert('as_receivables_bal', $object);
		}
		
		
		$data['no_ref']= $no_ref;
		
		$data['userid']= $this->session->userdata('SESS_USER_ID');
		$data['identity_id']= $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');	
		$data['title'] = "Tambah Kas Masuk";
		$data['main_content'] = 'saldo/add_saldo_piutang';
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	function detail_data_in($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '".$id."' ");
		$a_data = $q_data->row();
		$id_trx=$a_data->no_trx_kas;
		$cek_post=$a_data->posting;
		if($cek_post=='1')
		{
			$data['disabled'] ='readonly';
			$data['tipe_trx'] ='edit';		
		}
		else
		{
			$data['disabled'] ='';	
			$data['tipe_trx'] ='edit';	
		}
		$data['f_id'] = 1;
		$data['cek_post'] = $cek_post;
		$data['userid']= $this->session->userdata('SESS_USER_ID');
		$data['identity_id']= $this->session->userdata('IDENTITY_ID');
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['id_trx'] =$id;
		$data['id_trx_kas'] =$id_trx;
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id_trx);
		$data['kas_data'] = $this->kas_model->get_all_data_in_byid($id);
		$data['title'] = "Detail Kas Masuk";
		$data['main_content'] = 'kas/detail_kas_masuk';
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	function update_trx_saldo()
	{
	
		$id_trx= $this->input->post('id_trx');
		$nokas= $this->input->post('nokas');
		$object  = array(    
		'modifiedDate' => date("Y-m-d"),
		'bal' => str_replace(',','',$this->input->post('jumlah')),
		'keterangan' => $this->input->post('catatan'),
		'update_user' => $this->session->userdata('SESS_USER_ID')
		);
		$this->db->where('receivableID', $id_trx);
		$this->db->update('as_receivables_bal', $object);
		
		redirect('saldo/add_saldo_detail/'.$nokas, 'refresh');	
	}
	
	
	function batal_trx_ko($id)
	{
		
		
		$q_data = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '".$id."' ");
		$j_data = $q_data->num_rows();
		$a_data = $q_data->row();
		$idjurnal=$a_data->id;
		
		$q_data_temp = $this->db->query("SELECT * FROM jurnal_temp WHERE invoice_no = '".$id."' ");
		$j_data_temp = $q_data_temp->num_rows();
		$a_data_temp = $q_data_temp->row();
		$idjurnal_temp=$a_data_temp->id;
		
		$this->db->where('no_trx_bal', $id);
		$this->db->delete('as_receivables_bal');
		
		$this->db->where('jurnal_id', $idjurnal_temp);
		$this->db->delete('jurnal_detail_temp');
		
		$this->db->where('id', $idjurnal_temp);
		$this->db->delete('jurnal_temp');
		
		$this->db->where('jurnal_id', $idjurnal);
		$this->db->delete('jurnal_detail');
		
		$this->db->where('id', $idjurnal);
		$this->db->delete('jurnal');
		$this->session->set_flashdata('message', "<h5 class='badge badge-info'>Data dengan no Ref : <b>".$id." </b> telah dihapus </h5>");
		redirect('saldo/data_saldo_piutang/', 'refresh');
	}
	
	function fill_saldo_in()
	{
		
		$tipe_trx= $this->input->post('tipe_trx');
		$no_ref =$this->input->post('no_ref');
		$trxDate =$this->input->post('trxDate');
		
		if($tipe_trx=='add'){
			
			
			$object  = array(    
			'tgl_catat' => $trxDate,
			'bal' => str_replace(',','',$this->input->post('jumlah')),
			'keterangan' => $this->input->post('catatan'),
			'memberID' => $this->input->post('memberID'),
			'no_trx_bal' => $this->input->post('no_ref'),
			'cek_simpan' => 1,
			'posting' => 0,
			'createdUserID' => $this->input->post('userid')
			);
			$this->db->where('no_trx_bal', $no_ref);
			$this->db->update('as_receivables_bal', $object);
			redirect('saldo/add_saldo_detail/'.$no_ref, 'refresh');
		}
		else if($tipe_trx=='edit')
		{
			$id_trx_kas=$this->input->post('id_trx_kas');
			
			
			$id_trx= $this->input->post('id_trx');
			$object  = array(    
			'update_data' => date("Y-m-d"),
			'jumlah' => str_replace(',','',$this->input->post('jumlah')),
			'keterangan' => $this->input->post('catatan'),
			'jns_trans' => $this->input->post('jns'),
			'dari' => $this->input->post('dari'),
			'dok' => $this->input->post('dokumen'),
			'posting' => 0,
			'no_dok' => $this->input->post('no_dokumen'),
			'update_user' => $this->input->post('userid')
			);
			$this->db->where('id', $id_trx);
			$this->db->update('tbl_trans_kas', $object);
		}
		
	}
	
	
	function add_saldo_detail($id)
	{
		
		$idj=$this->session->userdata('idjur');
		$data['id_trx_ref'] =$id;
		$data['idjur'] =$idj;
		$data['f_id'] = 1;
		$data['saldo_data'] = $this->saldo_model->get_all_data_bal_ref($id);
		$data['jurnal_data'] = $this->saldo_model->cek_jurnal_ci($id);
		$data['jurnal_data_list'] = $this->saldo_model->get_data_saldo_temp($id);
		$data['jurnal_data_det'] = $this->saldo_model->cek_jurnal_ci_det($idj);
		$data['title'] = "Detail Saldo Piutang";
		$data['main_content'] = 'saldo/add_saldo_conf';
		$this->load->view('template/template_xpanel', $data);
	}
	
	function unpost_data_kas($id)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '".$id."' ");
		$a_data = $q_data->row();
		$id_trx=$a_data->no_trx_kas;
		
		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '".$id_trx."' ");
		$a_data2 = $q_data2->row();
		$id_jurnal=$a_data2->id;
		
		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);
		
		$object2    = array(
		'posting' => 0
		);
		$this->db->where('id', $id);
		$this->db->update('tbl_trans_kas', $object2);
		
		
		redirect('kas/detail_data_in/'.$id, 'refresh');
	}
	
	function delete_data_kas($id,$id2)
	{
		$q_data = $this->db->query("SELECT * FROM tbl_trans_kas WHERE id = '".$id."' ");
		$a_data = $q_data->row();
		$id_trx=$a_data->no_trx_kas;
		
		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '".$id_trx."' ");
		$a_data2 = $q_data2->row();
		$id_jurnal=$a_data2->id;
		
		$this->kas_model->delete_data($id);
		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);
		
		
		if($id2=='km')
		{
			redirect('kas/kas_masuk', 'refresh');
		}
		else if($id2=='kk')
		{
			redirect('kas/kas_keluar', 'refresh');
		}
		else if($id2=='tk')
		{
			redirect('kas/transfer_kas', 'refresh');
		}
	}
	
	function insert_jurnal_saldo()
	{
		
		$object  = array(    
		'no'=>$this->GenJurSaldo(),
		'tgl' => $this->input->post('tanggal'),
		'f_id' => $this->input->post('f_id'),
		'invoice_no' => $this->input->post('no_ref'),
		'keterangan' => $this->input->post('deskripsi'),
		'login_id' => $this->session->userdata('SESS_USER_ID'),
		'waktu_post' => date("Y-m-d H:i:s")
		);
		$this->db->insert('jurnal_temp', $object);
		$last_id = $this->db->insert_id();
		$this->session->set_userdata('idjur', $last_id);
		
		redirect('saldo/add_saldo_detail/'.$this->input->post('no_ref'), 'refresh');
	}
	
	
	function insert_saldo_jurnal()
	{
		
		$no_ref= $this->input->post('no_ref');
		$id_jurnal= $this->input->post('id_jurnal');
		$akun = $this->input->post('idakun');
		$debit = $this->input->post('dk');
		$count_item = $this->input->post('count_item');
		$keterangan =$this->input->post('keterangan');
		$value=str_replace(',','',$this->input->post('jumlah'));
		if($debit == 'd')
		{
			$dk = 1;
		}
		else
		{
			$dk = 0;
		}
		$this->details = array(
		'item' => $count_item,
		'jurnal_id'=>$id_jurnal,
		'akun_id' => $akun,
		'debit_kredit' => $dk,
		'nilai' => $value,
		'keterangan' => $keterangan
		);
		$this->db->trans_start();
		$this->db->insert('jurnal_detail_temp', $this->details);
		$this->db->trans_complete();	
		redirect('saldo/add_saldo_detail/'.$this->input->post('no_ref'), 'refresh');
	}
	
	function btl_jurnal_saldo($id,$id2,$id3)
	{
		$this->db->where('id', $id);
		$this->db->delete('jurnal_detail_temp');
		$this->session->unset_userdata('idjur');
		$this->session->set_userdata('idjur', $id3);
		redirect('saldo/add_saldo_detail/'.$id2, 'refresh');
	}
	
	
	function pra_jurnal($id,$id2)
	{
		$this->session->unset_userdata('idjur');
		$object2  = array(
		'posting' => 1
		);
		$this->db->where('no_trx_bal', $id2);
		$this->db->update('as_receivables_bal', $object2);
		
		
		$object  = array(
		'is_post' => 1
		);
		$this->db->where('invoice_no', $id2);
		$this->db->update('jurnal_temp', $object);
		$this->jurnal_model->post_jurnal_data($id2);
		
		$this->db->select('jurnal_detail_temp.*');
		$this->db->from('jurnal_detail_temp');
		$this->db->join('jurnal_temp', 'jurnal_temp.id = jurnal_detail_temp.jurnal_id');
		$this->db->where('jurnal_temp.invoice_no', $id2);
		$query = $this->db->get();

		foreach ($query->result_array() as $d) {
			$op = ($d['debit_kredit']) ? '+' : '-';
			$this->db->query('UPDATE akun SET saldo = saldo'.$op.$d['nilai'].' WHERE id = '.$d['akun_id']);
		}			
		redirect('saldo/add_saldo_detail/'.$id2, 'refresh');
	}
	
	
	function unpost_jur($id,$id2)
	{
		
		
		$q_data = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '".$id."' ");
		$j_data = $q_data->num_rows();
		$a_data = $q_data->row();
		$idjurnal=$a_data->id;
		
		
		$this->db->where('jurnal_id', $idjurnal);
		$this->db->delete('jurnal_detail');
		
		$this->db->where('id', $idjurnal);
		$this->db->delete('jurnal');
		
		
		$q_data2 = $this->db->query("SELECT * FROM jurnal_temp WHERE invoice_no = '".$id."' ");
		$j_data2 = $q_data2->num_rows();
		$a_data2 = $q_data2->row();
		$idjurnal2=$a_data2->id;
		
		$this->db->where('jurnal_id', $idjurnal2);
		$this->db->delete('jurnal_detail_temp');
		
		$this->db->where('id', $idjurnal2);
		$this->db->delete('jurnal_temp');
		$this->session->unset_userdata('idjur');
		
		redirect('saldo/add_saldo_detail/'.$id2, 'refresh');
	}
	
	function GenJurSaldo()
	{
		
		$trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$l_jurno=strlen($produksiID);
		if($l_jurno==14){
			$produksiIDfil = substr($produksiID, 10, 4);
		}
		else if($l_jurno==15){
			$produksiIDfil = substr($produksiID, 10, 5);
		}
		
		else if($l_jurno==16){
			$produksiIDfil = substr($produksiID, 10, 6);
		}
		
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
			$invno_1 = $produksiIDfil + 1;
			
			$invno_last = $trxDate . $invno_1;
			
			if($l_jurno==14){
				$invno_cek = sprintf("%04d", $invno_1);
				$trxidtmp = $this->db->query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 4)='.$invno_cek)->row_array();
			}
			else if($l_jurno==15){
				$invno_cek = sprintf("%05d", $invno_1);
				$trxidtmp = $this->db->query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 5)='.$invno_cek)->row_array();
			}
			
			else if($l_jurno==16){
				$invno_cek = sprintf("%06d", $invno_1);
				$trxidtmp = $this->db->query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 6)='.$invno_cek)->row_array();
			}
			
			
			
			if($trxidtmp)
			{
				$trxid2 = $this->db->query('SELECT no,CONVERT(SUBSTRING(no,11),UNSIGNED INTEGER) AS num from jurnal_temp order by num desc limit 1')->row_array();
				$produksiID2 = $trxid2['no'];
				$l_jurno2=strlen($produksiID2);
				if($l_jurno2==14){
					$produksiIDfil2 = substr($produksiID2, 10, 4);
				}
				else if($l_jurno2==15){
					$produksiIDfil2 = substr($produksiID2, 10, 5);
				}
				
				else if($l_jurno2==16){
					$produksiIDfil2 = substr($produksiID2, 10, 6);
				}
				$produksiIDfil3=ltrim($produksiIDfil2,'0');
				$invnoc = $produksiIDfil3 + 1;
				$l_jurno3=strlen($produksiID2);
				if($l_jurno3==14){
					$invoice2 = sprintf("%04d", $invnoc);
				}
				else if($l_jurno3==15){
					$invoice2 = sprintf("%05d", $invnoc);
				}
				
				else if($l_jurno3==16){
					$invoice2 = sprintf("%06d", $invnoc);
				}
				
				$invno = $trxDate . $invoice2;
			}
			else {
				
				if($l_jurno==14){
					$invno_cek = sprintf("%04d", $invno_1);
				}
				else if($l_jurno==15){
					$invno_cek = sprintf("%05d", $invno_1);
				}
				
				else if($l_jurno==16){
					$invno_cek = sprintf("%06d", $invno_1);
				}
				$invno_last = $trxDate . $invno_cek;
				$invno = $invno_last;
				
			}
			
		}

		$kode = "JS-". date('d')."-". $invno;
		return $kode;
	}
	
	function GenRefNumber()
	{
		$trxid = $this->db->query('SELECT * from as_receivables_bal order by receivableID desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no_trx_bal'];
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

		$kode = "SP-".date('d')."-". $invno;
		return $kode;
	}
}