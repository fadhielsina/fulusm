<?php

class Jurnal extends CI_Controller
{
	public $identity_id;

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('auth', 'surplus_sync'));
		$this->auth->check_user_authentification();
		$this->load->model('jurnal_model');
		$this->load->model('jurnal_unpost_model');
		$this->load->model('akun_model');
		$this->load->model('Surplus_model');
		$this->load->model('Spk_model');
		$this->load->model('jurnal_template_model');
		$this->load->model('model_master');
		$this->load->helper('finance');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));

		$this->identity_id = $this->session->userdata('IDENTITY_ID');
	}

	function index()
	{
		$data['title'] = $this->lang->line('jurnal');
		$data['main_content'] = 'jurnal/display';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['journal_data'] = $this->_search_jurnal();
		$data['search_URL'] = site_url('jurnal/search');
		$this->load->view('template/template_xpanel', $data);
	}

	function rekap()
	{
		$data['title'] = $this->lang->line('rekap_jurnal');
		$data['main_content'] = 'jurnal/rekap';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['journal_data'] = $this->_search_jurnal_rekap();
		$data['search_URL'] = site_url('jurnal/search');
		$this->load->view('template/template_xpanel', $data);
	}

	function search()
	{
		$result = $this->_search_jurnal();
		$journal_data = array();
		if ($result) {
			foreach ($result as $row) {
				if ($row->debit_kredit == 1) {
					$d = $row->nilai;
					$k = '';
				} else {
					$d = '';
					$k = $row->nilai;
				}
				$data = '[';
				$data .= "'" . $row->tgl . "',";
				$data .= "'" . $row->no . "',";
				$data .= "'" . $row->invoice_no . "',";
				$data .= "'" . $row->item . "',";
				$data .= "'" . $row->kode . ' - '. $row->account_name . "',";
				$data .= "'" . $d . "',";
				$data .= "'" . $k . "',";
				$data .= "'" . anchor(site_url() . "jurnal/jurnal_koreksi/" . $row->id."/".$row->invoice_no, 'Jurnal Koreksi') . "'";
				$data .= ']';
				$journal_data[] = $data;
			}
		}
		if (count($journal_data) > 0) {
			echo '[' . implode(',', $journal_data) . ']';
		} else {
			echo "[['','','','','','','','']]";
		}
		die();
	}

	function jurnal_umum()
	{
		$data['title'] = $this->lang->line('jurnal_umum');
		$data['supplier'] = $this->db->get('as_suppliers')->result();
		$data['members'] = $this->db->get('as_members')->result();
		$data['main_content'] = 'jurnal/form';
		$data['f_id'] = 1;
		// edited by Adhe on 19.05.2010
		$accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['template'] = $this->jurnal_template_model->get_all_data();

		// end
		$this->load->view('template/template_xpanel', $data);
	}

	function jurnal_pembelian()
	{
		$data['title'] = $this->lang->line('jurnal_pembelian');
		$data['main_content'] = 'jurnal/form_pembelian';
		$data['f_id'] = 2;
		// edited by Adhe on 19.05.2010
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		// end
		$this->load->view('template/template_xpanel', $data);
	}



	function jurnal_penyesuaian()
	{
		$data['title'] = $this->lang->line('jurnal_penyesuaian');
		$data['main_content'] = 'jurnal/form';
		$data['f_id'] = 2;
		// edited by Adhe on 19.05.2010
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Account not available --');
		// end
		$this->load->view('template/template_xpanel', $data);
	}

	function jurnal_penutup()
	{
		$data['title'] = $this->lang->line('jurnal_penutup');
		$data['main_content'] = 'jurnal/penutup';
		$this->load->view('template/template_xpanel', $data);
	}

	function jurnal_koreksi()
	{
		$id = $this->uri->segment(3);
		$id2 = $this->uri->segment(4);
		$data['title'] = $this->lang->line('jurnal_koreksi');
		$data['inv'] =$id2;
		$data['main_content'] = 'jurnal/koreksi';
		$this->jurnal_model->set_id($id);
		$data['journal_data'] = $this->jurnal_model->get_data();
		$data['accounts'] = $this->akun_model->get_data_for_dropdown();
		$this->load->view('template/template_xpanel', $data);
	}

	function buku_besar()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('buku_besar_detail');
		$data['main_content'] = 'jurnal/buku_besar';
		$data['account_data'] = $this->akun_model->get_data_by_id($id);
		$this->jurnal_model->set_account_id($id);
		$data['journal_data'] = $this->jurnal_model->get_data();
		$this->load->view('template/template_xpanel', $data);
	}

	function buku_besar_rekap()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('buku_besar_rekap');
		$data['main_content'] = 'jurnal/buku_besar_rekap';
		$data['account_data'] = $this->akun_model->get_all_data();
		//$this->jurnal_model->set_account_id($id);
		$data['journal_data'] = $this->jurnal_model->get_data_akun();

		$this->load->view('template/template_xpanel', $data);
	}
	
	function insert_ju()
	{
		$identity = $this->session->userdata('IDENTITY_ID');
		$jnsjrn=$this->input->post('jnsjrn');
		$bank_akun=$this->input->post('bank_akun');
		
		$akun = $this->input->post('akun');
		$sc_id = '';
		
		for ($i = 1; $i <= count($akun); $i++) {
			$debit = $this->input->post('debit' . $i);
			$kredit = $this->input->post('kredit' . $i);
			$keterangan = $this->input->post('keterangan' . $i);
			if (($debit != '') || ($kredit != '')) {
				if ($debit != '') {
					$dk = 1;
					$value = $debit;
				} else {
					$dk = 0;
					$value = $kredit;
				}
				$this->jurnal_model->details[$i] = array(
					'item' => $i,
					'akun_id' => $akun[$i - 1],
					'debit_kredit' => $dk,
					'nilai' => $value,
					'keterangan' => $keterangan
				);
			}
		}
			
		if($jnsjrn=="ju")
		{
			$nojur=$this->jurnal_model->GenJuno();
			$fid="1";
		}
		else if($jnsjrn=="juc")
		{
			$nojur=$this->jurnal_model->GenJuno();
			$fid="1";
			$sc_id=$this->input->post('member');
			$memberid=$this->input->post('member');
			$q_data = $this->db->query("SELECT * FROM as_members WHERE memberID = '".$memberid."' ");
			$a_data = $q_data->row();
			$memberCode=$a_data->memberCode;
			$sc_code=$memberCode;
			
			$object  = array(    
			'identityID' => $identity,
			'nojur' => $nojur,
			'memberID' => $memberid,
			'trxTotal' => $value,
			'cus_code' => $memberCode,
			'note_trx_cus' => $this->input->post('keterangan'),
			'createdDate' => $this->input->post('tanggal')
			);
			$this->db->insert('as_trx_cus', $object);
		}	
		else if($jnsjrn=="juv")
		{
			$nojur=$this->jurnal_model->GenJuno();
			$fid="1";
			$sc_id=$this->input->post('supplier');
			$supplierid=$this->input->post('supplier');
			$q_data = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '".$supplierid."' ");
			$a_data = $q_data->row();
			$supplierCode=$a_data->supplierCode;
			$sc_ven=$supplierCode;
			
			$object  = array(    
			'identityID' => $identity,
			'nojur' => $nojur,
			'supplierID' => $supplierid,
			'trxTotal' => $value,
			'sup_code' => $supplierCode,
			'note_trx_ven' => $this->input->post('keterangan'),
			'createdDate' => $this->input->post('tanggal')
			);
			$this->db->insert('as_trx_ven', $object);
		}
		else if($jnsjrn=="JPE") {
			$nojur=$this->jurnal_model->GenJpe();
				$fid="2";
				$sc_id = '';
		}
		else {
			$nojur=$this->jurnal_model->GenJuno();
			$fid="1";
		}
				
		$this->jurnal_model->data = array(
			'no'        => $nojur,
			'tgl'       => date('Y-m-d'),
			'f_id'      => $fid,
			'invoice_no'=> $this->input->post('payno'),
			'keterangan'=> $this->input->post('keterangan'),
			'login_id'  => $this->session->userdata('SESS_USER_ID'),
			'waktu_post'=> date("Y-m-d H:i:s"),
			'identityID'=> $identity,
			'sc_id'     => $sc_id,
			'sc_code'   => $sc_code,
			'sc_ven'    => $sc_ven
		);
		
		if ( $this->jurnal_model->insert_data() ) {
			// Insert to trans kas
			for ($i = 1; $i <= count($this->jurnal_model->details); $i++) {

				if ( ! $this->is_kas_akun( $this->jurnal_model->details[$i]['akun_id'] ) ) 
					continue;
				
				$jns_kas = ($this->jurnal_model->details[$i]['debit_kredit']) ? 'KM' : 'KK';
				$akun_ket = ($this->jurnal_model->details[$i]['debit_kredit']) ? 'Pemasukan' : 'Pengeluaran';
				$data = array(
					'no_trx_kas' => $this->jurnal_model->GenKasNumber( $jns_kas ),
					'tgl_catat' => date('Y-m-d'),
					'jumlah' => $this->jurnal_model->details[$i]['nilai'],
					'keterangan' => $this->jurnal_model->data['keterangan'],
					'akun' => $akun_ket,
					'jns_trans' => $jns_kas,
					'posting' => 1,
					'update_data' => date('Y-m-d'),
					'update_user' => $this->jurnal_model->data['login_id'],
					'user' => $this->jurnal_model->data['login_id'],
					'no_dok' => $this->jurnal_model->data['invoice_no'],
					'identity_id' => $this->session->userdata('IDENTITY_ID')
				);

				if ($this->jurnal_model->details[$i]['debit_kredit']){
					$data['untuk_kas_id'] = $this->jurnal_model->details[$i]['akun_id'];
				} else {
					$data['dari_kas_id'] = $this->jurnal_model->details[$i]['akun_id'];
				}

				$this->db->insert('tbl_trans_kas', $data );
			}
		}
		
		redirect('jurnal/buku_besar_detail');
	
	}

	function insert()
	{
		$goto = $this->input->post('goto');
		if (!$this->_jurnal_validation()) {
			$this->session->set_flashdata("message", validation_errors());
			redirect($goto);
		} else {
			$error_message = $this->_detail_validation();
			if ($error_message != '') {
				$this->session->set_flashdata("message", $error_message);
				redirect($goto);
			} else {
				$this->jurnal_model->fill_data();
				//Check for duplicate no
				if (!$this->jurnal_model->check_no()) {
					$this->session->set_flashdata("message", $this->lang->line('no_jurnal_used'));
					redirect($goto);
				}
				//Insert Data
				elseif ($this->jurnal_model->insert_data()) {

					// Insert to trans kas
					for ($i = 1; $i <= count($this->jurnal_model->details); $i++) {

						if ( ! $this->is_kas_akun( $this->jurnal_model->details[$i]['akun_id'] ) ) 
							continue;
						
						$jns_kas = ($this->jurnal_model->details[$i]['debit_kredit']) ? 'KM' : 'KK';
						$akun_ket = ($this->jurnal_model->details[$i]['debit_kredit']) ? 'Pemasukan' : 'Pengeluaran';
						$data = array(
							'no_trx_kas' => $this->jurnal_model->GenKasNumber( $jns_kas ),
							'tgl_catat' => date('Y-m-d'),
							'jumlah' => $this->jurnal_model->details[$i]['nilai'],
							'keterangan' => $this->jurnal_model->data['keterangan'],
							'akun' => $akun_ket,
							'jns_trans' => $jns_kas,
							'posting' => 1,
							'update_data' => date('Y-m-d'),
							'update_user' => $this->jurnal_model->data['login_id'],
							'user' => $this->jurnal_model->data['login_id'],
							'no_dok' => $this->jurnal_model->data['invoice_no'],
							'identity_id' => $this->session->userdata('IDENTITY_ID')
						);

						if ($this->jurnal_model->details[$i]['debit_kredit']){
							$data['untuk_kas_id'] = $this->jurnal_model->details[$i]['akun_id'];
						} else {
							$data['dari_kas_id'] = $this->jurnal_model->details[$i]['akun_id'];
						}

						$this->db->insert('tbl_trans_kas', $data );
					}

					$this->session->set_userdata('SUCCESSMSG', $this->lang->line('akun_sukses'));
					redirect('jurnal');
				}
			}
		}
	}
	
	function insert_koreksi()
	{
		$goto = $this->input->post('goto');
		if(!$this->_jurnal_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			redirect($goto);
		}
		else
		{
			$error_message = $this->_detail_validation();
			if($error_message != '')
			{
				$this->session->set_userdata('ERRMSG_ARR', $error_message);
				redirect($goto);
			}
			else
			{
				$this->jurnal_model->fill_data_koreksi();
				//Check for duplicate no
				if(!$this->jurnal_model->check_no())
				{
					$this->session->set_userdata('ERRMSG_ARR', 'Nomor Jurnal telah digunakan');
					redirect($goto);
				}
				//Insert Data
				elseif($this->jurnal_model->insert_data())
				{
					$this->session->set_userdata('SUCCESSMSG', 'Jurnal baru sukses ;)');
					redirect('jurnal');
				}
			}
		}
	}

	public function is_kas_akun( $id_akun )
	{
		$result = $this->db->query("select kode from akun where id=" . $id_akun)->row_array();
		if ( preg_match('/^111/i', $result['kode'] ) ) {
			return true;
		} else {
			return false;
		}
	}


	function insert_kas_transfer()
	{
		$goto = $this->input->post('goto');
		$this->jurnal_model->fill_data_transfer();
		//Check for duplicate no
		if (!$this->jurnal_model->check_no()) {
			$this->session->set_userdata('ERRMSG_ARR', 'Nomor Jurnal telah digunakan');
			redirect($goto);
		}
		//Insert Data
		elseif ($this->jurnal_model->insert_data()) {
			$this->session->set_userdata('SUCCESSMSG', 'Transfer Kas Berhasil Disimpan');
			redirect('kas/transfer_kas');
		}
	}

	function insert_kas_keluar()
	{
		$goto = $this->input->post('goto');
		
		$this->jurnal_model->fill_data_kas_out();
		//Check for duplicate no
		if (!$this->jurnal_model->check_no()) {
			$this->session->set_flashdata("message", 'Nomor Jurnal telah digunakan');
			redirect($goto);
		}
		//Insert Data
		elseif ($this->jurnal_model->insert_data()) {
			$this->session->set_userdata('SUCCESSMSG', 'Kas Keluar Berhasil Disimpan');
			redirect('kas/kas_keluar');
		}
	}

	function insert_kas_masuk()
	{
		$goto = $this->input->post('goto');
		if (!$this->_jurnal_validation()) {
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			redirect($goto);
		} else {
			$this->jurnal_model->fill_data_kas_in();
			//Check for duplicate no
			if (!$this->jurnal_model->check_no()) {
				$this->session->set_userdata('ERRMSG_ARR', 'Nomor Jurnal telah digunakan');
				redirect($goto);
			}
			//Insert Data
			elseif ($this->jurnal_model->insert_data()) {
				$this->session->set_userdata('SUCCESSMSG', 'Kas Masuk Berhasil Disimpan');
				redirect('kas/kas_masuk');
			}
		}
	}

	function insert_pembelian()
	{
		$goto = $this->input->post('goto');
		if (!$this->_jurnal_validation()) {
			$this->session->set_flashdata("message", validation_errors());
			redirect($goto);
		} else {
			$error_message = $this->_detail_validation();
			if ($error_message != '') {
				$this->session->set_flashdata("message", $error_message);
				redirect($goto);
			} else {
				$this->jurnal_model->fill_data_pembelian();
				//Check for duplicate no
				if (!$this->jurnal_model->check_no()) {
					$this->session->set_flashdata("message", 'Nomor Jurnal telah digunakan');
					redirect($goto);
				}
				//Insert Data
				elseif ($this->jurnal_model->insert_data()) {
					$this->session->set_userdata('SUCCESSMSG', 'Pembelian Berhasil Disimpan');
					redirect('purchasing');
				}
			}
		}
	}


	function insert_pembelian_pay()
	{
		$goto = $this->input->post('goto');
		$id1 = $this->input->post('id1');
		$id2 = $this->input->post('id2');
		if (!$this->_jurnal_validation()) {
			$this->session->set_flashdata("message", validation_errors());
			redirect($goto);
		} else {
			$error_message = $this->_detail_validation();
			if ($error_message != '') {
				$this->session->set_flashdata("message", $error_message);
				redirect($goto);
			} else {
				$this->jurnal_model->fill_data_pembelian_pay();
				//Check for duplicate no
				if (!$this->jurnal_model->check_no()) {
					$this->session->set_flashdata("message", 'Nomor Jurnal telah digunakan');
					redirect($goto);
				}
				//Insert Data
				elseif ($this->jurnal_model->insert_data()) {
					$this->session->set_userdata('SUCCESSMSG', 'Pembayaran Berhasil Disimpan');
					redirect($goto);
				}
			}
		}
	}

	function get_details()
	{
		$laba_rugi = $this->akun_model->get_id_by_name('Ikhtisar Laba Rugi');
		$modal = $this->akun_model->get_id_by_name('Modal');
		if (!$laba_rugi) {
			echo 'error_laba_rugi';
		} elseif (!$modal) {
			echo 'error_modal';
		} else {
			//Menutup akun pendapatan dengan memindahkan saldo setiap akun pendapatan ke akun ikhtisar laba rugi
			$this->akun_model->set_account_group_id(4);
			$pendapatan = $this->akun_model->get_all_data();
			$i = 1;
			if ($pendapatan) {
				$sum_pendapatan = 0;
				foreach ($pendapatan as $row) {
					if ($row->saldo != 0) {
						$debit = ($row->saldo < 0) ? abs($row->saldo) : '';
						$kredit = ($row->saldo > 0) ? $row->saldo : '';
						$sum_pendapatan += $row->saldo;
						$this->_create_table_detail($i, $row->id, $debit, $kredit);
						$i++;
					}
				}
				if ($sum_pendapatan != 0) {
					$debit = ($sum_pendapatan > 0) ? $sum_pendapatan : '';
					$kredit = ($sum_pendapatan < 0) ? abs($sum_pendapatan) : '';
					$this->_create_table_detail($i, $laba_rugi, $debit, $kredit);
					$i++;
				}
			}

			//Menutup akun biaya dengan memindahkan saldo setiap akun biaya ke akun ikhtisar laba rugi
			$this->akun_model->set_account_group_id(5);
			$biaya = $this->akun_model->get_all_data();
			if ($biaya) {
				$sum_biaya = 0;
				foreach ($biaya as $row) {
					if ($row->saldo != 0) {
						$debit = ($row->saldo < 0) ? abs($row->saldo) : '';
						$kredit = ($row->saldo > 0) ? $row->saldo : '';
						$sum_biaya += $row->saldo;
						$this->_create_table_detail($i, $row->id, $debit, $kredit);
						$i++;
					}
				}
				if ($sum_biaya != 0) {
					$debit = ($sum_biaya > 0) ? $sum_biaya : '';
					$kredit = ($sum_biaya < 0) ? abs($sum_biaya) : '';
					$this->_create_table_detail($i, $laba_rugi, $debit, $kredit);
					$i++;
				}
			}

			//Menutup akun ikhtisar laba rugi dengan memindahkan saldo akun tersebut ke akun modal
			$sum = $sum_pendapatan + $sum_biaya;
			if ($sum != 0) {
				$debit = ($sum < 0) ? abs($sum) : '';
				$kredit = ($sum > 0) ? $sum : '';
				$this->_create_table_detail($i, $laba_rugi, $debit, $kredit);
				$i++;
				$this->_create_table_detail($i, $modal, $kredit, $debit);
				$i++;
			}

			//Menutup akun prive (jika ada) dengan memindahkan saldo akun tersebut ke akun modal
			$prive = $this->akun_model->get_id_by_name('Prive');
			if ($prive) {
				$this->akun_model->get_data_by_id($prive);
				if ($prive['saldo'] != 0) {
					$debit = ($prive['saldo'] < 0) ? abs($prive['saldo']) : '';
					$kredit = ($prive['saldo'] > 0) ? $prive['saldo'] : '';
					$this->_create_table_detail($i, $prive['id'], $debit, $kredit);
					$i++;
					$this->_create_table_detail($i, $modal, $kredit, $debit);
				}
			}
		}
	}

	function _create_table_detail($i, $akun_id, $debit, $kredit)
	{
		$accounts = $this->akun_model->get_data_for_dropdown();
		$detail['disabled'] = TRUE;
		$detail['class'] = 'field';
		echo '<tr>';
		echo '<td>';
		$akun['id'] = 'akun' . $i;
		$akun['class'] = 'combo';
		$akun['disabled'] = TRUE;
		$selected = $akun_id;
		echo form_dropdown('akun[]', $accounts, $selected, $akun);
		echo '</td>';
		echo '<td>';
		$detail['id'] = $detail['name'] = 'debit' . $i;
		$detail['value'] = $debit;
		echo form_input($detail);
		echo '</td>';
		echo '<td>';
		$detail['id'] = $detail['name'] = 'kredit' . $i;
		$detail['value'] = $kredit;
		echo form_input($detail);
		echo '</td>';
		echo '</tr>';
	}

	function _search_jurnal()
	{
		$month = ($this->input->post('bulan') !== FALSE) ? $this->input->post('bulan') : date("m");
		$year = ($this->input->post('tahun') !== FALSE) ? $this->input->post('tahun') : date("Y");
		$this->jurnal_model->set_month_year($month, $year);
		return $this->jurnal_model->get_data();
	}
	function _search_jurnal_rekap()
	{
		$month = ($this->input->post('bulan') !== FALSE) ? $this->input->post('bulan') : date("m");
		$year = ($this->input->post('tahun') !== FALSE) ? $this->input->post('tahun') : date("Y");
		$this->jurnal_model->set_month_year($month, $year);
		return $this->jurnal_model->get_data_rekap();
	}


	function detail_jurnal_inv($id)
	{
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id);
		$data['title'] = $this->lang->line('detail_jurnal');
		$data['main_content'] = 'jurnal/detail_jurnal_invoice';
		$this->load->view('template/template_xpanel', $data);
	}


	function _jurnal_validation()
	{
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

		$akun = $this->input->post('akun');
		for ($i = 1; $i <= count($akun); $i++) {
			$this->form_validation->set_rules('debit' . $i, 'Debit', 'trim|is_natural');
			$this->form_validation->set_rules('kredit' . $i, 'Kredit', 'trim|is_natural');
		}

		return $this->form_validation->run();
	}

	function _detail_validation()
	{
		$error_message = '';
		if ($this->input->post('f_id') != 3) {
			if (($this->input->post('debit1') == '' && $this->input->post('kredit1') == '') || ($this->input->post('debit2') == '' && $this->input->post('kredit2') == '')) {
				$error_message = $this->lang->line('error_akun_min');
			} else {
				$akun_exist = array();
				$debit_sum = 0;
				$kredit_sum = 0;
				$akun = $this->input->post('akun');
				for ($i = 1; $i <= count($akun); $i++) {
					$debit = $this->input->post('debit' . $i);
					$kredit = $this->input->post('kredit' . $i);
					// akun tidak boleh ada yang sama
					if (in_array($akun[$i - 1], $akun_exist)) {
						$error_message = $this->lang->line('duplicate_detail');
					} else {
						$akun_exist[count($akun_exist)] = $akun[$i - 1];
					}
					// hitung jumlah debit
					if ($debit != '') $debit_sum += $debit;
					// hitung jumlah kredit
					if ($kredit != '') $kredit_sum += $kredit;
				}
				if ($debit_sum == 0 || $kredit_sum == 0) {
					if ($error_message) $error_message .= '<br/>';
					$error_message .= $this->lang->line("jumlah_kosong");
				}
				if ($debit_sum != $kredit_sum) {
					if ($error_message) $error_message .= '<br/>';
					$error_message .= $this->lang->line("nominal_tidak_sama");
				}
			}
		}
		return $error_message;
	}

	function unpost_jurnal_invoice($id)
	{


		$q_data = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id . "' ");
		$j_data = $q_data->num_rows();
		$a_data = $q_data->row();
		$idjurnal = $a_data->id;

		$object  = array(
			'is_publish' => 0
		);
		$this->db->where('invoiceID', $id);
		$this->db->update('as_sales_transactions', $object);

		$this->db->where('jurnal_id', $idjurnal);
		$this->db->delete('jurnal_detail');

		$this->db->where('id', $idjurnal);
		$this->db->delete('jurnal');
		redirect("invoice");
	}

	function GenJurNumber()
	{
		$trxid = mysql_fetch_array(mysql_query('SELECT * from jurnal order by id desc limit 1;'));
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
	function jurnal_penggajian()
	{
		$data['title'] = $this->lang->line('jurnal_penggajian');
		$data['main_content'] = 'jurnal/display_penggajian';
		$data['load_api'] = base_url('jurnal/load_penggajian');
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['journal_data'] = $this->_search_jurnal_unpost('penggajian');
		$data['search_URL'] = site_url('jurnal/jurnal_penggajian');
		$this->load->view('template/template_xpanel', $data);
	}
	function jurnal_billing()
	{
		
		$id = $this->session->userdata('IDENTITY_ID');
		$data['title'] = 'Penerimaan Kasir';
		$data['main_content'] = 'kas/display_kasir';
		$month = (($this->input->post('month') != "") ? $this->input->post('month') : date("m"));
		$year = (($this->input->post('year') != "") ? $this->input->post('year') : date("Y"));
		$data['kas_data'] = $this->Spk_model->get_all_sales( $id );

		$this->load->view('template/template_xpanel', $data);
	}
	function jurnal_billing_detail($id)
	{

		$data['title'] = $this->lang->line('jurnal_billing');
		$data['main_content'] = 'jurnal/display_detail_billing';
		$this->load->helper('indodate');
		$data['journal_data'] = (array) $this->jurnal_unpost_model->get_data_id($id);
		//var_dump($data['journal_data']);
		$data['search_URL'] = site_url('jurnal/jurnal_billing_detail');
		$this->load->view('template/template_xpanel', $data);
	}
	function proses_unpost($id_jurnal)
	{
		$post = $this->jurnal_unpost_model->posting_data($id_jurnal);

		if ($post) {
			$this->session->set_flashdata("message", "Posting data Sukses");
		} else {
			$this->session->set_flashdata("message", "Posting data Gagal");
		}
		redirect("jurnal/jurnal_billing");
	}
	function load_billing($year = "", $month = "")
	{

		$this->surplus_sync->month = $month;
		$this->surplus_sync->year = $year;
		$loadData = $this->surplus_sync->sync_payment();
		//posting data insurance dan card
		$insurance = $this->db->select("*")
			->from('jurnal_unpost')
			->where("is_posting", 0)
			->where_in("PAYMENT_TYPE", array('CARD','INSURANCE'))
			->get()->result_array();
		$DataCash = array();	
		foreach ($insurance  as $key => $value) {
			$this->jurnal_unpost_model->posting_data($value['id']);
			 
		}
		$this->jurnal_unpost_model->posting_cash();


		echo json_encode($loadData);

		/*	
		// Start session (also wipes existing/previous sessions)
		$this->curl->create($this->config->item("API_SERVER")."/sync_athos/sync_payment");
		// Option & Options
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10,
							CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
							CURLOPT_USERPWD        => $this->config->item("API_USER") . ":" . $this->config->item("API_PASS"),
							));

		// Login to HTTP user authentication
		//$this->curl->http_login($this->config->item("API_USER"), $this->config->item("API_PASS"));
		$post = array("username"=>'admin', //username aplikasi
						"password"=>"admin", //password aplikasi
						"token"=>"cf4d7f7c57361bcfb33be470ddb90b0d",
						"year"=>(($year=="")?date("Y"):$year),
						"month"=>(($month=="")?date("m"):$month)
						);
		
		$this->curl->post($post);
		try {
			$response = $this->curl->execute();
			if($this->curl->error_code !=0){
				die("failed sync data ".$this->curl->error_string);
			}else{
				//$return = json_decode( $response);
				//echo "<pre>";
				//var_dump($return);
				//die();
				//$data['user']= $return->data;
				echo $response;
			}
		}catch(Exception $ex) {
            //if ($ch != null) curl_close($ch);
            throw new Exception($ex);
        }*/
	}
	function load_penggajian()
	{
		// Start session (also wipes existing/previous sessions)
		$this->curl->create("http://202.149.67.146:800/api_athos/index.php/api/sync_athos/");
		// Option & Options
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));

		// Login to HTTP user authentication
		$this->curl->http_login("athoshr", "athoshr321");
		$post = array(
			"username" => 'admin', //username aplikasi
			"password" => "admin", //password aplikasi
			"condition" => array("is_active" => 0),
			"token" => "cf4d7f7c57361bcfb33be470ddb90b0d"
		);

		$this->curl->post($post);
		$response = $this->curl->execute();
		if ($this->curl->error_code != 0) {
			die("failed sync data " . $this->curl->error_string);
			redirect("jurnal/jurnal_billing");
		} else {
			$return = json_decode($response);
			redirect("jurnal/jurnal_billing");
		}
	}

	function _search_jurnal_unpost($jurnalType, $paymentCode = "", $paymentType = '')
	{
		$month = ($this->input->post('bulan') !== FALSE) ? $this->input->post('bulan') : date("m");
		$year = ($this->input->post('tahun') !== FALSE) ? $this->input->post('tahun') : date("Y");
		$this->jurnal_unpost_model->set_month_year($month, $year);
		return $this->jurnal_unpost_model->get_data($jurnalType, $paymentCode, $paymentType);
	}
	function edit_bayar()
	{ }
	function dateISO($text)
	{
		return true;
	}

	function insert_kas_insurance()
	{
		$goto = $this->input->post('goto');
		if (!$this->_jurnal_validation()) {
			$this->session->set_flashdata("message", validation_errors());
			redirect($goto);
		} else {
			$error_message = $this->_detail_validation();
			if ($error_message != '') {
				$this->session->set_flashdata("message", $error_message);
				redirect($goto);
			} else {
				$this->jurnal_model->fill_data_kas_insurance();
				//Check for duplicate no
				if (!$this->jurnal_model->check_no()) {
					$this->session->set_flashdata("message", 'Nomor Jurnal telah digunakan');
					redirect($goto);
				}
				//Insert Data
				elseif ($this->jurnal_model->insert_data()) {
					$this->session->set_flashdata("message", 'Kas Penerimaan asuransi Berhasil Disimpan ');
					redirect('kas/insurance');
				}
			}
		}
	}

	public function insert_kas_setor_to_bendahara()
	{
		$result = array("message"=>"","data"=>"","error"=>"1");
		$dataSetoran = $this->db->select('*')
			->from('jurnal_unpost')
			->where('PAYMENT_TYPE', 'CASH')
			->where('is_setor', '0')
			->get()->result();
		//var_dump($dataSetoran);
		  
		$this->jurnal_model->fill_data_setor_to_bendahara();
		//Check for duplicate no
		if (!$this->jurnal_model->check_no()) {
			$this->session->set_flashdata("message", 'Nomor Jurnal telah digunakan');
			$result = array("message"=>"Nomor Jurnal telah digunakan","target"=>site_url("kas/add_kas_transfer_to_bendahara"),"data"=>"","error"=>"1");
			//redirect('kas/add_kas_transfer_to_bendahara');
		}
		//Insert Data
		elseif ($this->jurnal_model->insert_data()) {
			$this->session->set_userdata('SUCCESSMSG', 'Setor Ke Bendahara Berhasil');
			$file =$this->cetak_bukti_setoran($dataSetoran);
			$result = array("message"=>"Setor Ke Bendahara Berhasil","target"=>site_url("kas/kas_masuk"),"data"=>$file,"error"=>"0");

			//redirect('kas/kas_masuk');
		}

		echo json_encode($result);
	}

	public function insert_kas_setor_to_bank()
	{

		$this->jurnal_model->fill_data_setor_to_bank();
		//Check for duplicate no
		if (!$this->jurnal_model->check_no()) {
			$this->session->set_flashdata("message", 'Nomor Jurnal telah digunakan');
			redirect('kas/add_kas_setor_bank');
		}
		//Insert Data
		elseif ($this->jurnal_model->insert_data()) {
			$this->session->set_userdata('SUCCESSMSG', 'Setor Ke Bank Berhasil');
			redirect('kas/transfer_kas');
		}
	}

	public function insert_jurnal_unpost_penerimaan_lain()
	{
		$this->jurnal_unpost_model->fill_data_penerimaan_lain();
		//Check for duplicate no
		if (!$this->jurnal_unpost_model->check_no_unpost()) {
			$this->session->set_flashdata("message", 'Nomor Invoice telah digunakan');
			redirect('kas/add_penerimaan_kasir_lain');
		}
		//Insert Data
		elseif ($this->jurnal_unpost_model->insert_data_unpost()) {
			$this->session->set_userdata('SUCCESSMSG', 'Data berhasil disimpan');

			// Insert to jurnal as well
			$this->jurnal_model->data = $this->jurnal_unpost_model->data;
			unset($this->jurnal_model->data['PATIENT_NAME']);
			unset($this->jurnal_model->data['PAYMENT_TYPE']);
			unset( $this->jurnal_model->data['AMOUNT']);
			unset( $this->jurnal_model->data['CLASS']);
			unset( $this->jurnal_model->data['is_posting']);
			$this->jurnal_model->data['no'] = $this->jurnal_model->GenJurNumber();
			
			$this->jurnal_model->details = $this->jurnal_unpost_model->details;
			$this->jurnal_model->insert_data();

			redirect('jurnal/jurnal_billing');
		}
	}

	function cetak_bukti_setoran($dataCash){
		$data['journal_data_cash'] = $dataCash; 
		$data['bendahara'] = $this->db->select('*')
							->from('master_pejabat')
							->where('jabatan','3')
							->limit(1)
							->get()->row_array();
		//$this->load->view("jurnal/cetak_setoran_kasir",$data);
		$pathGen = "generated/";
    	//clean file has been generated
    	//$this->delete_oldfiles($pathGen,(60 * 30));


    	
    	$html = $this->load->view("jurnal/cetak_setoran_kasir",$data,true);
    	
    	$rpt_name = "Setoran kasir";
    	 
        $head ="<html>
        <body>
        <head> 
        	<style> 
        	#report_area td,#report_area th{
        		padding:2px;
        		border-bottom:1px solid #e9ecef;
        	}
        	#report_area2 td,#report_area2 th{
        		padding:2px;
        		border-bottom:1px solid #e9ecef;
        	}
        	#report_area3 td,#report_area3 th{
        		padding:2px;
        		border-bottom:1px solid #e9ecef;
        	}
        	#report_area,#report_area2,#report_area3{
        		width:100%;
        	}
        	.dataTable{ width:90%!important;}
			h1,h2,h3{
				text-align:center !important;
			}
			th, td {
			  padding: 3px;
			  text-align: left;
			}
			.dataTable {
				  font-family: Arial, Helvetica, sans-serif;
				  border-collapse: collapse;
				  width: 100%;
				}

				.dataTable td, .dataTable th {
				  border: 1px solid #ddd;
				  padding: 2px;
				}

				table.dataTable thead th, table.dataTable tfoot th {
					width:unset !important;
				}

				.dataTable tr:nth-child(even){background-color: #f4f8fb;}

				.dataTable tr:hover {background-color: #ddd;}

				.dataTable th {
				  padding-top: 2px;
				  padding-bottom: 2px;
				  text-align: left;
				  background-color: #007bff;
				  color: white;
				}
        	</style>
        	</head>
        	";
        $footer ="</body></html>";	
        $pageLayout = $head.' '.$html.' '.$footer;
       
        $this->load->library('dompdf_gen');
        
        $this->dompdf->set_option('isRemoteEnabled', TRUE);
        $this->dompdf->set_option('isJavascriptEnabled', TRUE);
       	$this->dompdf->load_html($pageLayout);
        
        $this->dompdf->render();
        $output = $this->dompdf->output();
        $file = $pathGen."".$rpt_name.'.pdf';
        if(file_put_contents($file, $output)){
    		return  $file;
    	}else{
    		return "";
    	}
        //$this->dompdf->stream($file, array("Attachment" => 0));  
        //return $file;

		 
	}

	function tutup_buku_bulan(){
		
	}

	public function view_jurnal()
	{
		$id = $this->uri->segment(3);
		$data['title'] = 'Jurnal Detail';
		$data['main_content'] = 'jurnal/view_jurnal';
		$this->jurnal_model->set_id($id);
		$data['journal_data'] = $this->jurnal_model->get_data();
		$data['accounts'] = $this->akun_model->get_data_for_dropdown();
		$this->load->view('template/template_xpanel', $data);
	}

	public function buku_besar_detail()
	{
		$data['title'] = $this->lang->line('jurnal');
		$data['main_content'] = 'jurnal/display_buku_besar_detail';
		$this->load->helper('indodate');
		$identity_id = $this->input->post('lokasi') ? $this->input->post('lokasi') : $this->identity_id;
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $identity_id;
		$data['journal_data'] = $this->db->query("
			SELECT jurnal.no as no_jurnal,jurnal.sc_code,jurnal.sc_ven,jurnal.keterangan as ketjur,jurnal.f_id,jurnal_detail.nilai, jurnal_detail.debit_kredit, jurnal_detail.keterangan, akun.nama, akun.kode,
			jurnal.identityID, jurnal.tgl, as_sales_transactions.trxFakturID, as_sales_transactions.trxPOID, as_members.memberCode, as_suppliers.supplierCode,
			as_buy_transactions.invoiceSupplier, as_buy_transactions.no_dokumen, as_buy_transactions.note as note_trx,as_trx_cus.*,as_trx_ven.*,as_identity.identityCode
			FROM jurnal_detail 
			LEFT JOIN akun ON akun.id = jurnal_detail.akun_id 
			LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
			LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no
			LEFT JOIN as_members ON as_members.memberID = as_sales_transactions.memberID
			LEFT JOIN as_buy_transactions ON as_buy_transactions.invoiceBuyID = jurnal.invoice_no
			LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_buy_transactions.supplierID
			LEFT JOIN as_trx_cus ON as_trx_cus.nojur = jurnal.no
			LEFT JOIN as_trx_ven ON as_trx_ven.nojur = jurnal.no
			LEFT JOIN as_identity ON as_identity.identityID = jurnal.identityID
			WHERE jurnal.identityID = {$identity_id} order by jurnal.id desc
			")->result();
		$data['search_URL'] = site_url('jurnal/buku_besar_detail');
		$this->load->view('template/template_xpanel', $data);
	}
	
	public function gl_pemb()
	{
		$data['title'] = $this->lang->line('jurnal');
		$data['main_content'] = 'jurnal/display_gl_pemb';
		$this->load->helper('indodate');
		$identity_id = $this->input->post('lokasi') ? $this->input->post('lokasi') : $this->identity_id;
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $identity_id;
		$data['journal_data'] = $this->db->query("
			SELECT jurnal.no as no_jurnal,jurnal_detail.nilai, jurnal_detail.debit_kredit, jurnal_detail.keterangan, akun.nama, akun.kode,
			jurnal.identityID, jurnal.tgl, as_sales_transactions.trxFakturID, as_sales_transactions.trxPOID, as_members.memberCode, as_suppliers.supplierCode,
			as_buy_transactions.invoiceSupplier, as_buy_transactions.no_dokumen, as_buy_transactions.note as note_trx
			FROM jurnal_detail 
			LEFT JOIN akun ON akun.id = jurnal_detail.akun_id 
			LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
			LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no
			LEFT JOIN as_members ON as_members.memberID = as_sales_transactions.memberID
			LEFT JOIN as_buy_transactions ON as_buy_transactions.invoiceBuyID = jurnal.invoice_no
			LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_buy_transactions.supplierID
			WHERE jurnal.f_id='4' and jurnal.identityID = {$identity_id}
			")->result();
		$data['search_URL'] = site_url('jurnal/gl_pemb');
		$this->load->view('template/template_xpanel', $data);
	}
	
	public function gl_penj()
	{
		$data['title'] = $this->lang->line('jurnal');
		$data['main_content'] = 'jurnal/display_gl_penj';
		$this->load->helper('indodate');
		$identity_id = $this->input->post('lokasi') ? $this->input->post('lokasi') : $this->identity_id;
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $identity_id;
		$data['journal_data'] = $this->db->query("
			SELECT jurnal.no as no_jurnal,jurnal_detail.nilai, jurnal_detail.debit_kredit, jurnal_detail.keterangan, akun.nama, akun.kode,
			jurnal.identityID, jurnal.tgl, as_sales_transactions.trxFakturID, as_sales_transactions.trxPOID, as_members.memberCode, as_suppliers.supplierCode,
			as_buy_transactions.invoiceSupplier, as_buy_transactions.no_dokumen, as_buy_transactions.note as note_trx
			FROM jurnal_detail 
			LEFT JOIN akun ON akun.id = jurnal_detail.akun_id 
			LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
			LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no
			LEFT JOIN as_members ON as_members.memberID = as_sales_transactions.memberID
			LEFT JOIN as_buy_transactions ON as_buy_transactions.invoiceBuyID = jurnal.invoice_no
			LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_buy_transactions.supplierID
			WHERE jurnal.f_id='5' and jurnal.identityID = {$identity_id}
			")->result();
		$data['search_URL'] = site_url('jurnal/gl_pemb');
		$this->load->view('template/template_xpanel', $data);
	}
	
	public function gl_umum()
	{
		$data['title'] = $this->lang->line('jurnal');
		$data['main_content'] = 'jurnal/display_gl_umum';
		$this->load->helper('indodate');
		$identity_id = $this->input->post('lokasi') ? $this->input->post('lokasi') : $this->identity_id;
		$start = $this->input->post('start');
		if(!empty($start)) { $start = $this->input->post('start'); }else{$start=date('Y/m/d', strtotime('-1 month'));}
		$end = $this->input->post('end');
		if(!empty($end)) { $end = $this->input->post('start'); }else{$end=date('Y/m/d');}
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $identity_id;
		$data['journal_data'] = $this->db->query("
			SELECT jurnal.no as no_jurnal,jurnal_detail.nilai,jurnal.sc_code,jurnal.sc_ven, jurnal_detail.debit_kredit, jurnal_detail.keterangan, akun.nama, akun.kode,
			jurnal.identityID, jurnal.tgl, as_sales_transactions.trxFakturID, as_sales_transactions.trxPOID, as_members.memberCode, as_suppliers.supplierCode,
			as_buy_transactions.invoiceSupplier, as_buy_transactions.no_dokumen, as_buy_transactions.note as note_trx
			FROM jurnal_detail 
			LEFT JOIN akun ON akun.id = jurnal_detail.akun_id 
			LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
			LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no
			LEFT JOIN as_members ON as_members.memberID = as_sales_transactions.memberID
			LEFT JOIN as_buy_transactions ON as_buy_transactions.invoiceBuyID = jurnal.invoice_no
			LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_buy_transactions.supplierID
			WHERE jurnal.f_id='1' and jurnal.identityID = {$identity_id} AND jurnal.tgl >='".$start."' AND jurnal.tgl <='".$end."'
			")->result();
		$data['search_URL'] = site_url('jurnal/gl_pemb');
		$this->load->view('template/template_xpanel', $data);
	}
	
	public function gl_kas_bank()
	{
		$data['title'] = $this->lang->line('jurnal');
		$data['main_content'] = 'jurnal/display_gl_kb';
		$this->load->helper('indodate');
		$identity_id = $this->input->post('lokasi') ? $this->input->post('lokasi') : $this->identity_id;
		$start = $this->input->post('start');
		if(!empty($start)) { $start = $this->input->post('start'); }else{$start=date('Y/m/d', strtotime('-1 month'));}
		$end = $this->input->post('end');
		if(!empty($end)) { $end = $this->input->post('start'); }else{$end=date('Y/m/d');}
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $identity_id;
		$data['journal_data'] = $this->db->query("
			SELECT jurnal.no as no_jurnal,jurnal_detail.nilai, jurnal_detail.debit_kredit, jurnal_detail.keterangan, akun.nama, akun.kode,
			jurnal.identityID, jurnal.tgl, as_sales_transactions.trxFakturID, as_sales_transactions.trxPOID, as_members.memberCode, as_suppliers.supplierCode,
			as_buy_transactions.invoiceSupplier, as_buy_transactions.no_dokumen, as_buy_transactions.note as note_trx
			FROM jurnal_detail 
			LEFT JOIN akun ON akun.id = jurnal_detail.akun_id 
			LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
			LEFT JOIN as_sales_transactions ON as_sales_transactions.invoiceID = jurnal.invoice_no
			LEFT JOIN as_members ON as_members.memberID = as_sales_transactions.memberID
			LEFT JOIN as_buy_transactions ON as_buy_transactions.invoiceBuyID = jurnal.invoice_no
			LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_buy_transactions.supplierID
			WHERE jurnal.f_id in ('6','7','10','11') and jurnal.identityID = {$identity_id} AND jurnal.tgl >='".$start."' AND jurnal.tgl <='".$end."'
			")->result();
		
		$data['search_URL'] = site_url('jurnal/gl_kas_bank');
		$this->load->view('template/template_xpanel', $data);
	}
	
	public function update_jurnal_edit()
	{
		$jurnal_id = $this->input->post('jurnal_id');
		$akun = $this->input->post('akun');
		$identityID = $this->input->post('identity_id');
		
		// restore dlu saldo akun ke awal
		$this->_restore_akun_saldo( $jurnal_id, $identityID );

		for ($i = 1; $i <= count($akun); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit =$this->input->post('kredit'.$i);
			$keterangan =$this->input->post('keterangan'.$i);
			$id_jurnal_det = $this->input->post('jurnal_det_id'.$i);
			if(($debit != '') || ($kredit != ''))
			{
				if($debit != '')
				{
					$dk = 1;
					$value = $debit;
				}
				else
				{
					$dk = 0;
					$value = $kredit;
				}
				$data = array(
					'item' => $i,
					'akun_id' => $akun[$i-1],
					'debit_kredit' => $dk,
					'nilai' => $value,
					'keterangan' => $keterangan
				);

				//var_dump( $id_jurnal_det );

				if ( $id_jurnal_det ) {
					$this->db->where( 'id', $id_jurnal_det );
					$this->db->update( 'jurnal_detail', $data );
				} else {
					$data['jurnal_id'] = $jurnal_id;
					$this->db->insert('jurnal_detail', $data );
				}
				//var_dump( $data );

			}
		}

		redirect( $this->input->post('redirect_url'), 'refresh');
	}

	public function _restore_akun_saldo( $jurnal_id, $identityID )
	{
		$jurnal_detail = $this->db->query("SELECT * FROM jurnal_detail WHERE jurnal_id = " . $jurnal_id )->result_array();

		foreach( $jurnal_detail as $jd ) {
			$op = ($jd['debit_kredit']) ? '-' : '+'; // jadi dibalik utk restore
			$query = 'UPDATE akun SET saldo = saldo'.$op.$jd['nilai'].' WHERE id = '.$jd['akun_id'];
			$this->db->query('UPDATE akun_saldo SET saldo = saldo'.$op.$jd['nilai'].' WHERE akun_id = ' . $jd['akun_id'] . ' AND identityID=' . $identityID );
			//var_dump( $query );
			//$this->db->query($query);
		}
	}

}
/* End of file jurnal.php */
/* Location: ./application/CI_Controllers/jurnal.php */
