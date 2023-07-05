<?php

class Purchasing extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('purchasing_model');
		$this->load->model('jurnal_model');
		$this->load->model('jurnal_template_model');
		$this->load->model('akun_model');
		$this->load->model('kas_model');
		$this->load->helper('finance');
		$this->load->model('model_master');
	}

	function index()
	{
		$lokasi    = $this->input->post('lokasi');
		if ($lokasi) {
			$id = $this->input->post('lokasi');
		} else {
			$id = $this->session->userdata('IDENTITY_ID');
		}

		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['lokasi_data'] = $this->purchasing_model->get_data_lokasi();
		$data['title'] = "Pembelian";
		$data['main_content'] = 'purchasing/display';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['journal_data'] = $this->purchasing_model->get_data_invoice($id, $tanggal1, $tanggal2);
		$this->load->view('template/template_xpanel', $data);
	}

	function search()
	{
		$result = $this->_search_invoice();
		if ($result) {
			foreach ($result as $row) {

				$data = '[';
				$data .= "'" . $row->invoiceID . "',";
				$data .= "'" . $row->trxDate . "',";
				$data .= "'" . $row->invoiceIDmanual . "',";
				$data .= "'" . $row->trxFullName . "',";
				$data .= "'" . $row->trxTotal . "',";
				$data .= "'" . $row->note . "',";
				$data .= "'" . anchor(site_url() . "invoice/invoice_detail/" . $row->trxID, 'Detail') . "'";
				$data .= ']';
				$nvoice_data[] = $data;
			}
		}
		echo '[' . implode(',', $nvoice_data) . ']';
	}

	function _search_invoice()
	{
		$month = ($this->input->post('bulan') !== FALSE) ? $this->input->post('bulan') : date("m");
		$year = ($this->input->post('tahun') !== FALSE) ? $this->input->post('tahun') : date("Y");
		$this->invoice_model->set_month_year($month, $year);
		return $this->invoice_model->get_data();
	}


	function purchasing_add()
	{
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$data['usernama'] = $this->session->userdata('SESS_FIRST_NAME');
		$data['f_id'] = 1;
		$data['bank'] = $this->purchasing_model->get_bank();
		$data['bank2'] = $this->purchasing_model->get_bank_own();
		$data['jenisbyr'] = $this->purchasing_model->get_jenis_byr();
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['title'] = "Tambah Pembelian";
		$data['main_content'] = 'purchasing/form';
		$data['vendorcode'] = $this->GenVendorNumber();
		$this->load->view('template/template_xpanel', $data);
	}


	function fill_data_pembelian()
	{

		$tipe_trx = $this->input->post('tipe_trx');



		if ($tipe_trx == 'add') {

			$status_trx = $this->input->post('trxStatus');
			$trxTotalbyr = str_replace(',', '', $this->input->post('trxTotalbyr'));
			if ($status_trx == '2') {
				$pay = "0";
			} else {
				$pay = "1";
			}
			$object  = array(
				'invoiceBuyID' => $this->input->post('invoiceIDmanual'),
				'trxFullName' => $this->input->post('namavendor'),
				'trxAddress' => $this->input->post('vendorAddress'),
				'trxPhone' => $this->input->post('vendorPhone'),
				'supplierID' => $this->input->post('vendorID'),
				'trxDate' => $this->input->post('trxDate'),
				'note' => $this->input->post('note'),
				'trxTotal' => str_replace(',', '', $this->input->post('trxTotal')),
				'trxSubtotal' => str_replace(',', '', $this->input->post('trxSubtotal')),
				'trxDiscount' => str_replace(',', '', $this->input->post('trxDiscount')),
				'trxDP' => str_replace(',', '', $this->input->post('trxTotalbyr')),
				'trxppn' => 10,
				'userID' => $this->session->userdata('SESS_USER_ID'),
				'identityID' => $this->session->userdata('IDENTITY_ID'),
				'trxStatus' => $this->input->post('trxStatus'),
				'trxTerminDate' => $this->input->post('trxTerminDate'),
				'trxbankmethod' => $this->input->post('jns_bayar'),
				'trxAdmin' => str_replace(',', '', $this->input->post('b_admin')),
				'posting' => 1,
				'is_pay' => $pay,
				'createdDate' => date("Y-m-d H:i:s")
			);
			$this->db->insert('as_buy_transactions', $object);

			if ($status_trx == '2') {
				$object  = array(
					'invoiceID' => $this->input->post('invoiceIDmanual'),
					'status' => 1,
					'createdDate' => date("Y-m-d H:i:s")
				);
				$this->db->insert('as_debts', $object);
			}
			$this->session->set_flashdata('SUCCESSMSG', "<h5 class='badge badge-info'>Data dengan no PO : <b>" . $this->input->post('invoiceIDmanual') . " </b> telah disimpan </h5>");
			redirect('purchasing/purchasing_detail/' . $this->input->post('invoiceIDmanual'), 'refresh');
		} else if ($tipe_trx == 'edit') {
			$this->data = array(
				'no' =>  $this->GenJurNumber(),
				'tgl' => $this->input->post('tanggal'),
				'f_id' => $this->input->post('f_id'),
				'invoice_no' => $this->input->post('invoiceIDmanual'),
				'keterangan' => $this->input->post('deskripsi'),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);

			$id_trx = $this->input->post('id_trx');
			$status_trx = $this->input->post('trxStatus');
			if ($status_trx == '2') {
				$pay = "0";
			} else {
				$pay = "1";
			}
			$object  = array(
				'trxFullName' => $this->input->post('trxFullName'),
				'trxAddress' => $this->input->post('trxAddress'),
				'trxPhone' => $this->input->post('trxPhone'),
				'supplierID' => $this->input->post('memberCode'),
				'trxDate' => $this->input->post('trxDate'),
				'note' => $this->input->post('note'),
				'trxTotal' => str_replace(',', '', $this->input->post('trxTotal')),
				'modifiedUserID' => $this->session->userdata('SESS_USER_ID'),
				'identityID' => $this->session->userdata('IDENTITY_ID'),
				'trxStatus' => $this->input->post('trxStatus'),
				'trxTerminDate' => $this->input->post('trxTerminDate'),
				'trxbankmethod' => $this->input->post('jns_bayar'),
				'trxAdmin' => str_replace(',', '', $this->input->post('b_admin')),
				'posting' => 1,
				'is_pay' => $pay,
				'is_update' => 1,
				'modifiedDate' => date("Y-m-d H:i:s")
			);
			$this->db->where('trxID', $id_trx);
			$this->db->update('as_buy_transactions', $object);
		}
	}


	function purchasing_detail($id)
	{
		$idj = $this->session->userdata('idjur');
		if (!$idj) {
			$q_data_temp = $this->db->query("SELECT * FROM jurnal_temp WHERE invoice_no = '" . $id . "' ");
			$j_data_temp = $q_data_temp->num_rows();
			$a_data_temp = $q_data_temp->row();
			if ($a_data_temp) {
				$idjurnal_temp = $a_data_temp->id;
				$data['idjur'] = $idjurnal_temp;
			}
		} else {
			$data['idjur'] = $idj;
		}
		$data['id_trx_kas'] = $id;
		$data['f_id'] = 1;
		$data['po_data'] = $this->purchasing_model->get_po_byno($id);
		$data['jurnal_data'] = $this->kas_model->cek_jurnal_ci($id);
		$data['jurnal_data_list'] = $this->jurnal_model->get_data_id_k_i_temp($id);
		$data['jurnal_data_det'] = $this->kas_model->cek_jurnal_ci_det($idj);
		$data['title'] = "Detail PO";
		$data['main_content'] = 'purchasing/purchasing_conf';
		$this->load->view('template/template_xpanel', $data);
	}

	function insert_pay()
	{
		$goto = $this->input->post('goto');
		$id_trx = $this->input->post('id_trx');
		if (!$this->_jurnal_validation()) {
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			redirect($goto);
		} else {
			$error_message = $this->_detail_validation();
			if ($error_message != '') {
				$this->session->set_userdata('ERRMSG_ARR', $error_message);
				redirect($goto);
			} else {
				$this->purchasing_model->fill_data_pay();
				//Check for duplicate no
				if (!$this->purchasing_model->check_no_pay()) {
					$this->session->set_userdata('ERRMSG_ARR', 'Nomor Jurnal telah digunakan');
					redirect($goto);
				}
				//Insert Data
				elseif ($this->purchasing_model->insert_data_pay()) {
					$this->session->set_userdata('SUCCESSMSG', 'Jurnal baru sukses ;)');
					redirect('purchasing/purchasing_pay_debt/' . $id_trx);
				}
			}
		}
	}

	function _jurnal_validation()
	{
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required|dateISO');

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
				$error_message = "Minimal dua data pada detail harus dimasukkan.";
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
						$error_message = "Data akun pada table detail tidak boleh sama.";
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
					$error_message .= "Jumlah data debit maupun kredit tidak boleh 0.";
				}
				if ($debit_sum != $kredit_sum) {
					if ($error_message) $error_message .= '<br/>';
					$error_message .= "Jumlah debit harus sama dengan jumlah kredit.";
				}
			}
		}
		return $error_message;
	}

	function insert_jurnal_po()
	{

		$object  = array(
			'no' => $this->GenJurPo(),
			'tgl' => $this->input->post('tanggal'),
			'f_id' => $this->input->post('f_id'),
			'invoice_no' => $this->input->post('no_kas'),
			'keterangan' => $this->input->post('deskripsi'),
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$this->db->insert('jurnal_temp', $object);
		$last_id = $this->db->insert_id();
		$this->session->set_userdata('idjur', $last_id);
		redirect('purchasing/purchasing_detail/' . $this->input->post('no_kas'), 'refresh');
	}

	function insert_jurnal_po_act()
	{
		$no_kas = $this->input->post('no_kas');
		$id_jurnal = $this->input->post('id_jurnal');
		$akun = $this->input->post('idakun');
		$debit = $this->input->post('dk');
		$count_item = $this->input->post('count_item');
		$keterangan = $this->input->post('keterangan');
		$value = str_replace(',', '', $this->input->post('jumlah'));
		if ($debit == 'd') {
			$dk = 1;
		} else {
			$dk = 0;
		}
		$this->details = array(
			'item' => $count_item,
			'jurnal_id' => $id_jurnal,
			'akun_id' => $akun,
			'debit_kredit' => $dk,
			'nilai' => $value,
			'keterangan' => $keterangan
		);
		$this->db->trans_start();
		$this->db->insert('jurnal_detail_temp', $this->details);
		$this->db->trans_complete();
		redirect('purchasing/purchasing_detail/' . $this->input->post('no_kas'), 'refresh');
	}

	function btl_jurnal_po($id, $id2, $id3)
	{
		$this->db->where('id', $id);
		$this->db->delete('jurnal_detail_temp');
		$this->session->unset_userdata('idjur');
		$this->session->set_userdata('idjur', $id3);
		redirect('purchasing/purchasing_detail/' . $id2, 'refresh');
	}


	function pra_jurnal($id2)
	{
		$this->session->unset_userdata('idjur');
		$object2  = array(
			'posting' => 1
		);
		$this->db->where('invoiceBuyID', $id2);
		$this->db->update('as_buy_transactions', $object2);


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
			$this->db->query('UPDATE akun SET saldo = saldo' . $op . $d['nilai'] . ' WHERE id = ' . $d['akun_id']);
		}
		redirect('purchasing/purchasing_detail/' . $id2, 'refresh');
	}


	function unpost_jur($id)
	{


		$q_data = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id . "' ");
		$j_data = $q_data->num_rows();
		$a_data = $q_data->row();
		$idjurnal = $a_data->id;


		$this->db->where('jurnal_id', $idjurnal);
		$this->db->delete('jurnal_detail');

		$this->db->where('id', $idjurnal);
		$this->db->delete('jurnal');


		$q_data2 = $this->db->query("SELECT * FROM jurnal_temp WHERE invoice_no = '" . $id . "' ");
		$j_data2 = $q_data2->num_rows();
		$a_data2 = $q_data2->row();
		$idjurnal2 = $a_data2->id;

		$this->db->where('jurnal_id', $idjurnal2);
		$this->db->delete('jurnal_detail_temp');

		$this->db->where('id', $idjurnal2);
		$this->db->delete('jurnal_temp');
		$this->session->unset_userdata('idjur');

		redirect('purchasing/purchasing_detail/' . $id, 'refresh');
	}

	function batal_trx_po($id)
	{


		$q_data = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id . "' ");
		$j_data = $q_data->num_rows();
		$a_data = $q_data->row();
		$idjurnal = $a_data->id;

		$q_data_temp = $this->db->query("SELECT * FROM jurnal_temp WHERE invoice_no = '" . $id . "' ");
		$j_data_temp = $q_data_temp->num_rows();
		$a_data_temp = $q_data_temp->row();
		$idjurnal_temp = $a_data_temp->id;

		$this->db->where('invoiceBuyID', $id);
		$this->db->delete('as_buy_transactions');

		$this->db->where('jurnal_id', $idjurnal_temp);
		$this->db->delete('jurnal_detail_temp');

		$this->db->where('id', $idjurnal_temp);
		$this->db->delete('jurnal_temp');

		$this->db->where('jurnal_id', $idjurnal);
		$this->db->delete('jurnal_detail');

		$this->db->where('id', $idjurnal);
		$this->db->delete('jurnal');
		$this->session->set_flashdata('message', "<h5 class='badge badge-info'>Data dengan no Invoice : <b>" . $id . " </b> telah dihapus </h5>");
		redirect('purchasing', 'refresh');
	}


	function unpost_data_purchasing($id)
	{
		$q_data = $this->db->query("SELECT * FROM as_buy_transactions WHERE trxID = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->invoiceBuyID;

		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id_trx . "' ");
		$a_data2 = $q_data2->row();
		$id_jurnal = $a_data2->id;


		$q_data3 = $this->db->query("SELECT * FROM as_debts WHERE invoiceID = '" . $id_trx . "' ");
		$a_data3 = $q_data3->row();
		$j_data = $q_data3->num_rows();
		if ($j_data > 0) {
			$id_debt = $a_data3->debtID;
		} else {
			$id_debt = 0;
		}

		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);

		$this->purchasing_model->delete_debt_detail($id_debt);
		$this->purchasing_model->delete_debt($id_trx);

		$object2    = array(
			'posting' => 0,
			'is_pay' => 0
		);
		$this->db->where('trxID', $id);
		$this->db->update('as_buy_transactions', $object2);


		redirect('purchasing/purchasing_detail/' . $id, 'refresh');
	}



	function delete_data_purchasing($id)
	{
		$q_data = $this->db->query("SELECT * FROM as_buy_transactions WHERE trxID = '" . $id . "' ");
		$a_data = $q_data->row();
		$id_trx = $a_data->invoiceBuyID;

		$q_data2 = $this->db->query("SELECT * FROM jurnal WHERE invoice_no = '" . $id_trx . "' ");
		$a_data2 = $q_data2->row();
		$id_jurnal = $a_data2->id;


		$q_data3 = $this->db->query("SELECT * FROM as_debts WHERE invoiceID = '" . $id_trx . "' ");
		$a_data3 = $q_data3->row();
		$id_debt = $a_data3->debtID;


		$this->kas_model->delete_detail_jurnal($id_jurnal);
		$this->kas_model->delete_jurnal($id_jurnal);

		$this->purchasing_model->delete_debt_detail($id_debt);
		$this->purchasing_model->delete_debt($id_trx);
		$this->purchasing_model->delete_data_trx($id);


		redirect('purchasing', 'refresh');
	}



	function purchasing_utang()
	{
		$lokasi    = $this->input->post('lokasi');
		if ($lokasi) {
			$id = $this->input->post('lokasi');
		} else {
			$id = $this->session->userdata('IDENTITY_ID');
		}

		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['lokasi_data'] = $this->purchasing_model->get_data_lokasi();
		$data['title'] = 'tes';
		$data['main_content'] = 'purchasing/display_utang';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y', strtotime('-1 month'));
		$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');
		$data['form_action'] = 'purchasing/purchasing_utang';
		$data['journal_data'] = $this->purchasing_model->get_data_debt($id, $tanggal1, $tanggal2);

		$this->load->view('template/template_xpanel', $data);
	}


	function aset_debt()
	{
		$id = $this->session->userdata('IDENTITY_ID');

		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['lokasi_data'] = $this->purchasing_model->get_data_lokasi();
		$data['title'] = 'tes';
		$data['main_content'] = 'purchasing/display_utang_aset';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['tanggal1']    = $this->input->post('start') ? $this->input->post('start') : date('m/d/Y', strtotime('-1 month'));
		$data['tanggal2']    = $this->input->post('end') ? $this->input->post('end') : date('m/d/Y');
		$data['form_action'] = 'purchasing/purchasing_utang';
		$data['journal_data'] = $this->purchasing_model->get_data_debt_aset($id);

		$this->load->view('template/template_xpanel', $data);
	}

	function purchasing_aset_detail_debt($id, $id2, $id3, $id4)
	{
		$identityID = $this->session->userdata('IDENTITY_ID');
		$akun = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='" . $identityID . "'")->result_array();
		if (count($akun) > 0) {
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['out']] = $value['nama'];
			}
		}
		$data['bank_data'] = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.nama like 'Bank%' and b.identityID='" . $identityID . "'")->result();

		$data['payno'] = $this->Genpaynumber();
		$data['debtIDtrx'] = $id2;
		$data['identity'] = $id3;
		$data['utangID'] = $id4;
		$data['form_action'] = 'purchasing/insert_pay_debt';
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$q_data = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '" . $id . "' ");
		$a_data = $q_data->row();
		$data['supplier'] = $a_data->supplierName;
		$data['supplierID'] = $a_data->supplierID;
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['all_kas_unit'] = $this->akun_model->get_all_kas_bank_unit($id3);
		$data['title'] = "Pembayaran Hutang Pembelian Aset";
		$data['title'] = "Pembayaran Hutang Aset";
		$data['template'] = $this->jurnal_template_model->get_all_data();
		$data['main_content'] = 'purchasing/form_detail_pay_aset';
		$this->load->view('template/template_xpanel', $data);
	}


	function insert_pay_debt_aset()
	{
		$supplierid = $this->input->post('supplierID');
		$q_data = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '" . $supplierid . "' ");
		$a_data = $q_data->row();
		$supplierCode = $a_data->supplierCode;

		$identity_pus = $this->session->userdata('IDENTITY_ID');
		$jnsjrn = $this->input->post('jnsjrn');
		$bank_akun = $this->input->post('bank_akun');
		$identity = $this->session->userdata('IDENTITY_ID');


		$qi = $this->db->query("SELECT * FROM as_identity WHERE identityID = '" . $identity . "' ");
		$ai = $qi->row();
		$idenname = $ai->identityName;

		// Jurnal bayar hutang
		$saldotrx = $this->input->post('total');



		//bayar hutang
		$nojur = $this->jurnal_model->GenJpu($identity);
		$fid = "15";

		$this->jurnal_model->data = array(
			'no' =>  $nojur,
			'tgl' => $this->input->post('tanggalbyr'),
			'f_id' => $fid,
			'invoice_no' => $this->input->post('payno'),
			'keterangan' => $this->input->post('memo'),
			'identityID' => $identity,
			'sc_id' => $supplierCode,
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$akun = array();
		$akun[1] = array(
			'akun_id' => $this->input->post('utangID'), //utang dagang
			'debit_kredit' => 1,
			'nilai' => $saldotrx,
			'keterangan' => $this->input->post('memo')
		);

		$akun[] = array(
			'akun_id' => $this->input->post('akun_kas'), // kas
			'debit_kredit' => 0,
			'nilai' => $saldotrx,
			'keterangan' => $this->input->post('memo')
		);

		// resorting item key
		foreach ($akun as $key => $v_ak) {
			$akun[$key]['item'] = $key;
		}

		$this->jurnal_model->details = $akun;
		$this->jurnal_model->insert_data();

		redirect('purchasing/aset_debt');
	}

	function purchasing_pay_debt($id)
	{
		$q_data3 = $this->db->query("SELECT * FROM as_buy_transactions WHERE trxID = '" . $id . "' ");
		$a_data3 = $q_data3->row();
		$id_trx_po = $a_data3->invoiceBuyID;

		$q_data2 = $this->db->query("SELECT * FROM as_debts WHERE invoiceID = '" . $id_trx_po . "' ");
		$a_data2 = $q_data2->row();
		$id_debt = $a_data2->debtID;

		$data['f_id'] = 1;
		$data['bank'] = $this->purchasing_model->get_bank();
		$data['bank2'] = $this->purchasing_model->get_bank_own();
		$data['jenisbyr'] = $this->purchasing_model->get_jenis_byr();
		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');
		$accounts = $this->purchasing_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['id_trx'] = $id;
		$data['id_trx_po'] = $id_trx_po;
		$data['invoice_data'] = $this->purchasing_model->get_data_debt_by_id($id);
		$data['invoice_debt_pay'] = $this->purchasing_model->get_data_debt_pay($id_debt);
		$data['title'] = "Pembelian";
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id_trx_po);
		$data['main_content'] = 'purchasing/form_detail_pay';
		$this->load->view('template/template_xpanel', $data);
	}

	function invoice_pay_det()
	{
		$data['f_id'] = 1;
		$data['form_action'] = 'pembelian/insert';
		$accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['supplier'] = $this->db->get('as_suppliers')->result();
		$data['title'] = "Pembayaran Invoice Pending";
		$data['main_content'] = 'purchasing/form_detail_pay';
		$this->load->view('template/template_xpanel', $data);
	}

	function get_customer()
	{

		$kode = strtolower($_GET['term']);
		//$query = $this->mauto->get_bahan($kode);
		$query = $this->db->from('as_members')->like('memberFullName', $kode)->limit(10)->get();

		$bahan       =  array();
		foreach ($query->result() as $d) {
			$bahan[]     = array(
				'label' => $d->memberCode . " - " . $d->memberFullName . " - " . $d->memberAddress,
				'memberID' => $d->memberID,
				'memberCode' => $d->memberCode,
				'memberFullName' => $d->memberFullName,
				'memberAddress' => $d->memberAddress,
				'memberPhone' => $d->memberPhone
			);
		}
		echo json_encode($bahan);
	}

	function get_customer_json()
	{
		header('Content-Type: application/json');
		echo $this->invoice_model->tampil_member_json();
	}



	function invoice_kasir()
	{
		$lokasi    = $this->input->post('lokasi');
		if ($lokasi) {
			$id = $this->input->post('lokasi');
		} else {
			$id = $this->session->userdata('IDENTITY_ID');
		}

		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['lokasi_data'] = $this->invoice_model->get_data_lokasi();
		$data['title'] = "Invoice Pending";
		$data['main_content'] = 'invoice/display_pay';
		$data['journal_data'] = $this->invoice_model->get_data_pending($id, $tanggal1, $tanggal2);
		$this->load->view('template/template_xpanel', $data);
	}

	function invoice_piutang()
	{
		$lokasi    = $this->input->post('lokasi');
		if ($lokasi) {
			$id = $this->input->post('lokasi');
		} else {
			$id = $this->session->userdata('IDENTITY_ID');
		}

		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		$data['lokasi_data'] = $this->invoice_model->get_data_lokasi();
		$data['title'] = "Piutang Invoice";
		$data['main_content'] = 'invoice/display_piutang';
		$data['journal_data'] = $this->invoice_model->get_data_piutang($id, $tanggal1, $tanggal2);
		$this->load->view('template/template_xpanel', $data);
	}




	function invoice_pay_termin($id)
	{
		$data['f_id'] = 1;
		$q_data = $this->db->query("SELECT * FROM as_receivables WHERE invoiceID = '" . $id . "' ");
		$j_data = $q_data->num_rows();
		$a_data = $q_data->row();
		$piutangid = $a_data->receivableID;
		$data['piutangid'] = $piutangid;
		$data['bank'] = $this->invoice_model->get_bank();
		$data['bank2'] = $this->invoice_model->get_bank_own();
		$data['jenisbyr'] = $this->invoice_model->get_jenis_byr();
		$data['invoice_data_detail'] = $this->invoice_model->get_data_piutang_id_detail($piutangid);
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id);
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['invoice_data'] = $this->invoice_model->get_data_piutang_id($id);
		$data['title'] = "Pembayaran Invoice Termin";
		$data['main_content'] = 'invoice/form_detail_termin';
		$this->load->view('template/template_xpanel', $data);
	}

	function simpan_termin_pay()
	{
		$debtID    = $this->input->post('debtID');
		$dibayar  = $dibayar  = str_replace(',', '', $this->input->post('dibayar'));
		$payno    = $this->input->post('payno');
		$data = $this->purchasing_model->simpan_data_term_pay($debtID, $dibayar, $payno);
		echo json_encode($data);
	}

	function termin_pay_data()
	{
		$debtID    = $this->input->post('debtID');
		$totalbayar  = $totalbayar  = str_replace(',', '', $this->input->post('trxTotalbyr'));

		$object       = array(
			'debtID' =>  $debtID,
			'debtPay' => $totalbayar,
			'createdDate' => date('Y-m-d h:i:s')
		);

		$this->db->insert('as_debts_payment', $object);
		if ($stsbyr == "2") {
			$object2    = array(
				'status' => 2,
			);
			$this->db->where('invoiceID', $nomorinvoice);
			$this->db->update('as_debts', $object2);

			$object3    = array(
				'is_pay' => 1,
			);
			$this->db->where('invoiceBuyID', $nomorinvoice);
			$this->db->update('as_buy_transactions', $object3);
		}
		redirect('purchasing/purchasing_pay_debt/' . $id_trx, 'refresh');
	}

	function nota($id)
	{

		$q_data = $this->db->query("SELECT * FROM as_sales_transactions WHERE invoiceID = '" . $id . "' ");
		$j_data = $q_data->num_rows();
		$a_data = $q_data->row();
		$a['noinv'] = $a_data->invoiceID;
		$a['customer'] = $a_data->trxFullName;
		$a['total'] = $a_data->trxTotal;
		$a['tgltrx'] = $a_data->trxDate;
		$a['note'] = $a_data->note;

		$this->load->view('invoice/print', $a);

		$html = $this->output->get_output();

		$this->load->library('dompdf_gen');

		$this->dompdf->load_html($html);

		$this->dompdf->render();
		$this->dompdf->stream($invoiceID, array(
			'Attachment' => 0
		));
	}

	function invoice_pay($id)
	{
		$data['f_id'] = 1;
		$data['no_invoice'] = $id;
		$data['bank'] = $this->invoice_model->get_bank();
		$data['bank2'] = $this->invoice_model->get_bank_own();
		$data['jenisbyr'] = $this->invoice_model->get_jenis_byr();
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id);
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['invoice_data'] = $this->invoice_model->get_data_pending_id($id);
		$data['invoice_data_detail'] = $this->invoice_model->get_data_pending_id_detail($id);
		$data['title'] = "Pembayaran Invoice Pending";
		$data['main_content'] = 'invoice/form_detail_pay';
		$this->load->view('template/template_xpanel', $data);
	}


	function batal_trx($id)
	{

		$this->invoice_model->delete_data_trx($id);
		redirect('invoice', 'refresh');
	}


	function pending_pay_data()
	{
		$stsbyr    = $this->input->post('stsbyr');
		$nomorinvoice    = $this->input->post('nomorinvoice');
		$totalbayar  = str_replace(',', '', $this->input->post('trxTotalbyr'));
		$type  = $this->input->post('jns_bayar');
		$bankcus          = $this->input->post('bankcus');
		if ($type == '1') {
			$object       = array(
				'invoiceID' =>  $nomorinvoice,
				'amount' => $totalbayar,
				'tipe_bayar' => 1,
				'bank_id' =>  0,
				'createdDate' => date('Y-m-d h:i:s')
			);
		} else {
			$object       = array(
				'invoiceID' =>  $nomorinvoice,
				'amount' => $totalbayar,
				'tipe_bayar' => $type,
				'bank_id' =>  $bankcus,
				'createdDate' => date('Y-m-d h:i:s')
			);
		}
		$this->db->insert('as_pending_pay', $object);
		if ($stsbyr == "2") {
			$object2    = array(
				'isfinish' => 1,
			);
			$this->db->where('invoiceID', $nomorinvoice);
			$this->db->update('as_sales_transactions', $object2);
		}
		redirect('invoice/invoice_pay/' . $nomorinvoice, 'refresh');
	}

	function purchasing_detail_debt($id, $id2, $id3)
	{
		$identityID = $this->session->userdata('IDENTITY_ID');
		$akun = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.kode like '1112%' and b.identityID='" . $identityID . "'")->result_array();
		if (count($akun) > 0) {
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['out']] = $value['nama'];
			}
		}
		$data['bank_data'] = $this->db->query("SELECT a.*,b.* from akun a left join akun_saldo b on a.id=b.akun_id where a.nama like 'Bank%' and b.identityID='" . $identityID . "'")->result();

		$data['payno'] = $this->Genpaynumber();
		$data['debtIDtrx'] = $id2;
		$data['identity'] = $id3;
		$data['form_action'] = 'purchasing/insert_pay_debt';
		$accounts = $this->akun_model->get_data_for_dropdown();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$q_data = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '" . $id . "' ");
		$a_data = $q_data->row();
		$data['supplier'] = $a_data->supplierName;
		$data['supplierID'] = $a_data->supplierID;
		$data['all_kas'] = $this->akun_model->get_all_kas_bank();
		$data['all_kas_unit'] = $this->akun_model->get_all_kas_bank_unit($id3);
		$data['title'] = "Pembayaran Hutang";
		$data['template'] = $this->jurnal_template_model->get_all_data();
		$data['main_content'] = 'purchasing/form_detail_pay';
		$this->load->view('template/template_xpanel', $data);
	}

	function insert_pay_debt()
	{
		$supplierid = $this->input->post('supplierID');
		$q_data = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '" . $supplierid . "' ");
		$a_data = $q_data->row();
		$supplierCode = $a_data->supplierCode;

		$identity_pus = $this->session->userdata('IDENTITY_ID');
		$jnsjrn = $this->input->post('jnsjrn');
		$bank_akun = $this->input->post('bank_akun');
		$identity = $this->input->post('identity');


		$qi = $this->db->query("SELECT * FROM as_identity WHERE identityID = '" . $identity . "' ");
		$ai = $qi->row();
		$idenname = $ai->identityName;

		// Jurnal bayar hutang
		$saldotrx = $this->input->post('total');

		$q2     = $this->db->query("SELECT * from tbl_config_akun WHERE con_code = 'ut_01'");

		$a2     = $q2->row();

		$utang      = $a2->akun_id;

		$qh = $this->db->query("SELECT * FROM akun WHERE kode = '5000.03.001' ");
		$ah = $qh->row();
		$ak_hut_pus = $ah->id;

		$qp = $this->db->query("SELECT * FROM akun WHERE kode = '2000.04.002' ");
		$ap = $qp->row();
		$ak_pt_ug = $ap->id;


		//jurnal kas pusat out
		$jns = 'KK';
		$no_kas = $this->jurnal_model->GenKasNumber($jns);
		$nojur_kp = $this->jurnal_model->GenJbankout($identity);
		$fid_pus = "10";

		$this->jurnal_model->data = array(
			'no' =>  $nojur_kp,
			'tgl' => $this->input->post('tanggalbyr'),
			'f_id' => $fid_pus,
			'invoice_no' => $no_kas,
			'keterangan' => 'Pengeluaran Kas/Bank Untuk ' . $idenname,
			'identityID' => $identity_pus,
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$akun_kp = array();
		$akun_kp[1] = array(
			'akun_id' => $ak_pt_ug, //utang dagang
			'debit_kredit' => 1,
			'nilai' => $saldotrx,
			'keterangan' => 'Pengeluaran Kas/Bank Untuk ' . $idenname
		);

		$akun_kp[] = array(
			'akun_id' => $this->input->post('akun_kas_pusat'), // kas
			'debit_kredit' => 0,
			'nilai' => $saldotrx,
			'keterangan' => 'Pengeluaran Kas/Bank Untuk ' . $idenname
		);

		// resorting item key
		foreach ($akun_kp as $key_kp => $v_ak_kp) {
			$akun_kp[$key_kp]['item'] = $key_kp;
		}

		$this->jurnal_model->details = $akun_kp;
		$this->jurnal_model->insert_data();


		//jurnal kas Unit in
		$jns2 = 'KI';
		$no_kas_un = $this->jurnal_model->GenKasNumber($jns2);
		$nojur_ug = $this->jurnal_model->GenJbankin($identity);
		$fid_ug = "11";

		$this->jurnal_model->data = array(
			'no' =>  $nojur_ug,
			'tgl' => $this->input->post('tanggalbyr'),
			'f_id' => $fid_ug,
			'invoice_no' => $no_kas_un,
			'keterangan' => 'Penerimaan Hutang dari kas/bank pusat',
			'identityID' => $identity,
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$akun_ug = array();
		$akun_ug[1] = array(
			'akun_id' => $this->input->post('akun_kas'), //utang dagang
			'debit_kredit' => 1,
			'nilai' => $saldotrx,
			'keterangan' => 'Penerimaan Hutang dari kas/bank pusat'
		);

		$akun_ug[] = array(
			'akun_id' => $ak_hut_pus, // kas
			'debit_kredit' => 0,
			'nilai' => $saldotrx,
			'keterangan' => 'Penerimaan Hutang dari kas/bank pusat'
		);

		// resorting item key
		foreach ($akun_ug as $key_ug => $v_ak_ug) {
			$akun_ug[$key_ug]['item'] = $key_ug;
		}

		$this->jurnal_model->details = $akun_ug;
		$this->jurnal_model->insert_data();


		//bayar hutang
		$nojur = $this->jurnal_model->GenJpu($identity);
		$fid = "15";

		$this->jurnal_model->data = array(
			'no' =>  $nojur,
			'tgl' => $this->input->post('tanggalbyr'),
			'f_id' => $fid,
			'invoice_no' => $this->input->post('payno'),
			'keterangan' => $this->input->post('memo'),
			'identityID' => $identity,
			'sc_id' => $supplierCode,
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$akun = array();
		$akun[1] = array(
			'akun_id' => $utang, //utang dagang
			'debit_kredit' => 1,
			'nilai' => $saldotrx,
			'keterangan' => $this->input->post('memo')
		);

		$akun[] = array(
			'akun_id' => $this->input->post('akun_kas'), // kas
			'debit_kredit' => 0,
			'nilai' => $saldotrx,
			'keterangan' => $this->input->post('memo')
		);

		// resorting item key
		foreach ($akun as $key => $v_ak) {
			$akun[$key]['item'] = $key;
		}

		$this->jurnal_model->details = $akun;
		$this->jurnal_model->insert_data();

		redirect('purchasing/purchasing_utang');
	}

	function GenVendorNumber()
	{
		$codeidentity = $this->session->userdata('IDENTITY_CODE');
		$trxid = $this->db->query('SELECT * from as_suppliers order by supplierID desc limit 1')->row_array();

		$vendorID = $trxid['supplierCode'];
		if ($vendorID == "") {
			$kode = "ven-" . $codeidentity . "-00001";
		} else {
			if (preg_match('/ven-/', $vendorID)) {
				$vendorIDfil = substr($vendorID, 8, 5);
				$invno = $vendorIDfil + 1;
				$invno = sprintf("%05d", $invno);
				$kode = "ven-" . $codeidentity . $invno;
			} else {
				$kode = "ven-" . $codeidentity . "-00001";
			}
		}

		return $kode;
	}


	function GenJurPo()
	{

		$trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['no'];
		$l_jurno = strlen($produksiID);
		if ($l_jurno == 14) {
			$produksiIDfil = substr($produksiID, 10, 4);
		} else if ($l_jurno == 15) {
			$produksiIDfil = substr($produksiID, 10, 5);
		} else if ($l_jurno == 16) {
			$produksiIDfil = substr($produksiID, 10, 6);
		}

		if ($produksiIDfil == "") {
			$trxDate = date('my');
			$trx = 1;

			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
		} else {
			$trxDate = date('my');
			$invno_1 = $produksiIDfil + 1;

			$invno_last = $trxDate . $invno_1;

			if ($l_jurno == 14) {
				$invno_cek = sprintf("%04d", $invno_1);
				$trxidtmp = $this->db->query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 4)=' . $invno_cek)->row_array();
			} else if ($l_jurno == 15) {
				$invno_cek = sprintf("%05d", $invno_1);
				$trxidtmp = $this->db->query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 5)=' . $invno_cek)->row_array();
			} else if ($l_jurno == 16) {
				$invno_cek = sprintf("%06d", $invno_1);
				$trxidtmp = $this->db->query('SELECT * from jurnal_temp where SUBSTRING(no, 11, 6)=' . $invno_cek)->row_array();
			}



			if ($trxidtmp) {
				$trxid2 = $this->db->query('SELECT no,CONVERT(SUBSTRING(no,11),UNSIGNED INTEGER) AS num from jurnal_temp order by num desc limit 1')->row_array();
				$produksiID2 = $trxid2['no'];
				$l_jurno2 = strlen($produksiID2);
				if ($l_jurno2 == 14) {
					$produksiIDfil2 = substr($produksiID2, 10, 4);
				} else if ($l_jurno2 == 15) {
					$produksiIDfil2 = substr($produksiID2, 10, 5);
				} else if ($l_jurno2 == 16) {
					$produksiIDfil2 = substr($produksiID2, 10, 6);
				}
				$produksiIDfil3 = ltrim($produksiIDfil2, '0');
				$invnoc = $produksiIDfil3 + 1;
				$l_jurno3 = strlen($produksiID2);
				if ($l_jurno3 == 14) {
					$invoice2 = sprintf("%04d", $invnoc);
				} else if ($l_jurno3 == 15) {
					$invoice2 = sprintf("%05d", $invnoc);
				} else if ($l_jurno3 == 16) {
					$invoice2 = sprintf("%06d", $invnoc);
				}

				$invno = $trxDate . $invoice2;
			} else {

				if ($l_jurno == 14) {
					$invno_cek = sprintf("%04d", $invno_1);
				} else if ($l_jurno == 15) {
					$invno_cek = sprintf("%05d", $invno_1);
				} else if ($l_jurno == 16) {
					$invno_cek = sprintf("%06d", $invno_1);
				}
				$invno_last = $trxDate . $invno_cek;
				$invno = $invno_last;
			}
		}

		$kode = "JPO" . date('d') . "-" . $invno;
		return $kode;
	}

	function payment_purchase($supplier = "", $id = "", $id_trx_po = "")
	{
		$data['vendor'] = $this->db->select('supplierCode as value, supplierName as label')
			->from('as_suppliers')
			->get()->result_array();
		$data['transaction'] = 	$this->db->select('concat(invoiceBuyID,\' \',receiveNo) as label,  invoiceBuyID  as value')
			->from('as_buy_transactions')
			->where('supplierID', $supplier)
			->where('is_pay', 0)
			->get()->result_array();
		$data['accounts'] = 	$this->db->select('  nama as label, id as value')
			->from('akun')
			->like('kode', '111', 'after')
			->or_like('kode', '112', 'after')
			->get()->result_array();
		$data['purchasing'] = 	$this->db->select('  concat_ws(\' \',\'No Invoice :\',invoiceBuyID,note) as label, invoiceBuyID as value')
			->from('as_buy_transactions')
			->where('is_pay', '0')
			->group_by('invoiceBuyID')
			->get()->result_array();

		$data['userid'] = $this->session->userdata('SESS_USER_ID');
		$data['identity_id'] = $this->session->userdata('IDENTITY_ID');

		$data['id_trx'] = $id;
		$data['id_trx_po'] = $id_trx_po;
		$data['invoice_data_detail'] = $this->purchasing_model->get_data_debt_pay_list($id);
		$data['jurnal_data'] = $this->jurnal_model->get_data_id($id_trx_po);

		$data['list_data'] = $this->purchasing_model->get_data_debt_by_id($id);
		$data['title'] = "Pembayaran Hutang";

		$data['action'] = site_url("purchasing/purchasing_utang_proses");
		$data['back_url'] = site_url("purchasing/purchasing_utang");
		//$data['add_url']=site_url("Konsumen/form_konsumen");
		//$data['edit_url']=site_url("Konsumen/edit_konsumen");
		//$data['detail_url']=site_url("Konsumen/detail_konsumen");
		//$data['delete_url']=site_url("Konsumen/delete_konsumen"); 
		$data['save_url'] = site_url("purchasing/purchasing_utang_proses");
		$data['field_primary'] = 'invoiceBuyID';
		$data['hidden'] = array("akun_hutang" => "281"); //id akun hutang ke vendor
		$data['js_file'] = "purchasing.js";
		$data['field'] = array(
			'supplierID' => array(
				'label' => 'Pembayaran Ke',
				'type' => 'combo',
				'data' => $data['vendor']
			),
			'invoiceBuyID' => array(
				'label' => 'Pembelian :',
				'type' => 'combo',
				'data' => $data['purchasing']
			),
			'akun' => array(
				'label' => 'Dari Akun Bank',
				'type' => 'combo',
				'data' => $data['accounts']
			),
			'tanggal' => array(
				'label' => 'Tanggal Bayar',
				'type' => 'date',
				'data' => $data['purchasing']
			),
			'nominal' => "Total Pembayaran",
			'is_pay' => array(
				'label' => 'Lunas / Belum',
				'type' => 'combo',
				'data' => array(array('value' => '0', 'label' => 'Belum Lunas'), array('value' => '1', 'label' => 'Lunas'))
			),
		);
		$data['main_content'] = 'form';
		$this->load->view('template/template_xpanel', $data);
	}

	function purchasing_utang_proses()
	{
		$this->form_validation->set_rules('supplierID', 'Supplier', 'required');
		$this->form_validation->set_rules('akun', 'Akun', 'required');
		$this->form_validation->set_rules('invoiceBuyID', 'No Invoice', 'required');
		$this->form_validation->set_rules('nominal', 'Nominal', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->payment_purchase();
		} else {
			$this->jurnal_model->fill_data_bayar_hutang();
			$this->jurnal_model->insert_data();
			redirect("purchasing/purchasing_utang");
		}
	}

	function purchasing_hutang()
	{
		$lokasi    = $this->input->post('lokasi');

		if ($lokasi) {
			$id = $this->input->post('lokasi');
		} else {
			$id = $this->session->userdata('IDENTITY_ID');
		}

		$tgl1    = $this->input->post('tanggal1');
		// $data['lokasi_data'] = $this->purchasing_model->get_data_lokasi();
		$data['title'] = $this->lang->line('hutang_pembelian');
		$data['main_content'] = 'purchasing/display_hutang_fulusme';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$jenis = 1;

		// $data['project'] = $this->db_fulus->get_where('project', ['version' => 0])->result();
		$data['project'] = $this->db->distinct()->select('id_project')->from('trx_pendanaan')->order_by('id_project')->get()->result();
		// $data['journal_data'] = $this->purchasing_model->get_data_debt($id, $tanggal1, $tanggal2);

		$data['journal_data'] = $this->purchasing_model->get_data_hutang('', $tgl1, $jenis);
		$this->load->view('template/template_xpanel', $data);
	}

	function purchasing_retur()
	{
		$lokasi    = $this->input->post('lokasi');

		if ($lokasi) {
			$id = $this->input->post('lokasi');
		} else {
			$id = $this->session->userdata('IDENTITY_ID');
		}

		$tgl1    = $this->input->post('tanggal1');
		// $data['lokasi_data'] = $this->purchasing_model->get_data_lokasi();
		$data['title'] = $this->lang->line('hutang_pembelian');
		$data['main_content'] = 'purchasing/display_retur';
		$this->load->helper('indodate');
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$jenis = 2;
		$data['project'] = $this->db->distinct()->select('id_project')->from('trx_pendanaan')->order_by('id_project')->get()->result();
		$data['journal_data'] = $this->purchasing_model->get_data_hutang('', $tgl1, $jenis);
		$this->load->view('template/template_xpanel', $data);
	}

	function debt_payment($id)
	{
		$this->form_validation->set_rules('nominal', 'Nominal Pembayaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Pengembalian Dana + Bagi Hasil";
			$data['jurnal_data'] = $this->purchasing_model->get_data_hutang($id, '', '');
			$jenis = $data['jurnal_data']->status;
			if ($jenis == 2) {
				$data['title'] = "Retur Pendanaan";
			}
			$data['total_dibayar'] =  $this->purchasing_model->get_dibayar($id);
			$data['main_content'] = 'hutang/form_debt_payment';
			$data['id'] = $id;
			$this->load->view('template/template_xpanel', $data);
		} else {
			$trx_id = $this->input->post('no_invoice');
			$id_project = $this->input->post('id_project');
			$nominal = $this->input->post('nominal');
			$keuntungan = $this->input->post('keuntungan');
			$id_user = $this->input->post('id_user');
			$nama_project = $this->input->post('nama_project');
			$nama_user = $this->input->post('nama_user');
			$status = $this->input->post('status');
			$nomor_va = $this->input->post('nomor_va');
			$this->jurnal_hutang_payment($id, $id_user, $nominal, $keuntungan, $id_project, $nama_project, $nama_user, $status);

			if ($status == 1) {
				$this->_sendEmail($nomor_va, $keuntungan);
			} else {
				$this->_sendEmailRetur($nomor_va);
			}

			$data_trx_pendanaan = [
				'status' => $status,
				'return_ts' => date('Y-m-d H:i:s')
			];

			if ($status == 2) {
				$data_trx_pendanaan = [
					'status' => $status,
					'cancel_ts' => date('Y-m-d H:i:s')
				];
			}
			$this->db->where('id', $id);
			$this->db->update('trx_pendanaan', $data_trx_pendanaan);
			$this->validation_status($id_project, $status);
			redirect('purchasing/purchasing_hutang');
		}
	}

	function validation_status($id, $status)
	{
		if ($status == 1) {
			$modal_project = $this->db->get_where('trx_project', ['id_project' => $id])->row()->dana_terkumpul;
			$cek = $this->db->query(" SELECT SUM(nominal) as total FROM trx_pendanaan WHERE id_project = $id AND status = 1 AND return_ts IS NOT NULL")->row()->total;
			if ($cek >= $modal_project) {
				$data = [
					'status' => 5
				];
				$cek_project = $this->db_fulus->get_where('project', ['id' => $id])->row();
				if ($cek_project) {
					$this->db_fulus->where('id', $id);
					$this->db_fulus->update('project', $data);
					$this->db->where('id', $id);
					$this->db->update('history_project', $data);
				} else {
					$this->db_fulus->where('id_project', $id);
					$this->db_fulus->update('project_retail', $data);
				}
				$this->db->where('id_project', $id);
				$this->db->update('trx_project', $data);
			}
		}
	}

	function debt_payment_all($idPro)
	{
		$query = $this->db->get_where('trx_pendanaan', ['id_project' => $idPro])->result();
		foreach ($query as $row) {
			$id = $row->id;
			$trx_id = $row->no_invoice;
			$id_project = $row->id_project;
			$nominal = $row->nominal;
			$keuntungan = 0;
			$id_user = $row->id_pendana;
			$nama_user = $this->db_fulus->get_where('pendana', ['id' => $row->id_pendana])->row()->full_name;
			$nama_project = $this->db->get_where('trx_project', ['id_project' => $id_project])->row()->nama_project;
			$status = $row->status;
			$this->jurnal_hutang_payment($id, $id_user, $nominal, $keuntungan, $id_project, $nama_project, $nama_user, $status);
			if ($status == 1) {
				$this->_sendEmail($row->nomor_va, $keuntungan);
			} else {
				$this->_sendEmailRetur($row->nomor_va);
			}
			$data_trx_pendanaan = [
				'status' => $status,
				'return_ts' => date('Y-m-d H:i:s')
			];
			if ($status == 2) {
				$data_trx_pendanaan = [
					'status' => $status,
					'cancel_ts' => date('Y-m-d H:i:s')
				];
			}
			$this->db->where('id', $id);
			$this->db->update('trx_pendanaan', $data_trx_pendanaan);
		}

		redirect('purchasing/purchasing_retur');
	}

	function jurnal_hutang_payment($id, $id_user, $nominal, $keuntungan, $id_project, $nama_project, $nama_user, $status)
	{
		$jns = "PLNS";
		$ket = "Pelunasan Modal Ke Pendana";
		if ($status == 2) {
			$jns = "RTR";
			$ket = "Retur Dana ke Pendana";
		}
		$invoice = $this->GenPgmNumber($jns);
		$akun_bank = 5;
		$data_1 = [
			'create_ts' => date('Y-m-d h:i:s'),
			'nominal' => intval(str_replace(',', '', $nominal)),
			'id_user' => $id_user,
			'keuntungan' => intval(str_replace(',', '', $keuntungan)),
			'trx_id' => $id,
			'status' => $status,
			'id_project' => $id_project
		];
		$this->db->insert('trx_hutang_payment', $data_1);

		if ($status == 2) {
			$data_trx = [
				'no_trx_kas' => $invoice,
				'tgl_catat' => date('Y-m-d'),
				'jumlah' => intval(str_replace(',', '', $nominal)),
				'keterangan' => $ket,
				'akun' => "Pengeluaran",
				'dari_kas_id' => $akun_bank,
				'jns_trans' => "KK",
				'dok' => $nama_project,
				'no_dok' => $id_project,
				'dari' => "Bank",
				'kepada' => $nama_user
			];
			$this->db->insert('tbl_trans_kas', $data_trx);
			$project = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();
			$tipe = $project->tipe;
			$akun = 85;

			if ($tipe) {
				if ($tipe === 'Musyarakah') {
					$akun = 84;
				} elseif ($tipe === 'Mudharabah') {
					$akun = 83;
				}
			}

			$dataJurnal = [
				'no' =>   $this->GenJurNumber(),
				'tgl' => date("Y-m-d"),
				'f_id' => 1,
				'invoice_no' => $invoice,
				'keterangan' => $ket,
				'waktu_post' => date("Y-m-d"),
				'id_project' => $id_project
			];
			$this->db->insert('jurnal', $dataJurnal);
			$lastID = $this->db->insert_id();

			$dataJurnal_detail_debit = [
				'jurnal_id' => $lastID,
				'item' => 1,
				'akun_id' => $akun,
				'debit_kredit' => 1,
				'nilai' => intval(str_replace(',', '', $nominal))
			];

			$dataJurnal_detail_kredit = [
				'jurnal_id' => $lastID,
				'item' => 2,
				'akun_id' => $akun_bank,
				'debit_kredit' => 0,
				'nilai' => intval(str_replace(',', '', $nominal))
			];

			$this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
			$this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);

			$saldo_akun_default_d1 = $this->db->select('saldo')->from('akun')->where('id', $akun)->get()->row()->saldo;
			$saldo_akun_default_k1 = $this->db->select('saldo')->from('akun')->where('id', $akun_bank)->get()->row()->saldo;
			$saldo_new_d1 = $saldo_akun_default_d1 + (int) intval(str_replace(',', '', $nominal));
			$this->db->where('id', $akun);
			$this->db->update('akun', ['saldo' => $saldo_new_d1]);
			$saldo_new_k1 = $saldo_akun_default_k1 - (int) intval(str_replace(',', '', $nominal));
			$this->db->where('id', $akun_bank);
			$this->db->update('akun', ['saldo' => $saldo_new_k1]);

			$data_fulusme = [
				'status' => 2,
				'canceled_ts' => time()
			];
			$this->db_fulus->where('project_id', $id_project);
			$this->db_fulus->where('pendana_id', $id_user);
			$this->db_fulus->update('pendanaan', $data_fulusme);
		} else {
			$project = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();
			$tipe = $project->tipe;
			$total = intval(str_replace(',', '', $nominal));
			$untung = intval(str_replace(',', '', $keuntungan));
			$this->jurnal_tf_pelunasan($invoice, $akun_bank, $total, $ket, $nama_user, $tipe, $id_project);
			$this->jurnal_tf_bagi_hasil($akun_bank, $untung, $nama_user, $tipe, $id_project);

			$data_fulusme = [
				'status' => 3,
				'returned_ts' => time()
			];
			$this->db_fulus->where('project_id', $id_project);
			$this->db_fulus->where('pendana_id', $id_user);
			$this->db_fulus->update('pendanaan', $data_fulusme);
		}
	}

	function jurnal_tf_pelunasan($invoice, $akun_bank, $total, $ket, $nama_user, $tipe, $id_project)
	{
		$data_trx = [
			'no_trx_kas' => $invoice,
			'tgl_catat' => date('Y-m-d'),
			'jumlah' => $total,
			'keterangan' => $ket,
			'akun' => "Pengeluaran",
			'dari_kas_id' => $akun_bank,
			'jns_trans' => "KK",
			'dari' => "Bank",
			'kepada' => $nama_user
		];
		$this->db->insert('tbl_trans_kas', $data_trx);

		$akun = 85;

		if ($tipe) {
			if ($tipe === 'Musyarakah') {
				$akun = 84;
			} elseif ($tipe === 'Mudharabah') {
				$akun = 83;
			}
		}

		$dataJurnal = [
			'no' =>   $this->GenJurNumber(),
			'tgl' => date("Y-m-d"),
			'f_id' => 1,
			'invoice_no' => $invoice,
			'keterangan' => $ket,
			'waktu_post' => date("Y-m-d"),
			'id_project' => $id_project
		];
		$this->db->insert('jurnal', $dataJurnal);

		$lastID = $this->db->insert_id();

		$dataJurnal_detail_debit = [
			'jurnal_id' => $lastID,
			'item' => 1,
			'akun_id' => $akun,
			'debit_kredit' => 1,
			'nilai' => $total
		];

		$dataJurnal_detail_kredit = [
			'jurnal_id' => $lastID,
			'item' => 2,
			'akun_id' => $akun_bank,
			'debit_kredit' => 0,
			'nilai' => $total
		];

		$this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
		$this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);

		$saldo_akun_default_d1 = $this->db->select('saldo')->from('akun')->where('id', $akun)->get()->row()->saldo;
		$saldo_akun_default_k1 = $this->db->select('saldo')->from('akun')->where('id', $akun_bank)->get()->row()->saldo;
		$saldo_new_d1 = $saldo_akun_default_d1 + $total;
		$this->db->where('id', $akun);
		$this->db->update('akun', ['saldo' => $saldo_new_d1]);
		$saldo_new_k1 = $saldo_akun_default_k1 - $total;
		$this->db->where('id', $akun_bank);
		$this->db->update('akun', ['saldo' => $saldo_new_k1]);
	}

	function jurnal_tf_bagi_hasil($akun_bank, $untung, $nama_user, $tipe, $id_project)
	{
		$ket = "Pelunasan Bagi Hasil";
		$invoice = $this->GenPgmNumber("PBH");

		$data_trx = [
			'no_trx_kas' => $invoice,
			'tgl_catat' => date('Y-m-d'),
			'jumlah' => $untung,
			'keterangan' => $ket,
			'akun' => "Pengeluaran",
			'dari_kas_id' => $akun_bank,
			'jns_trans' => "KK",
			'dari' => "Bank",
			'kepada' => $nama_user
		];
		$this->db->insert('tbl_trans_kas', $data_trx);

		$akun = 88;

		if ($tipe) {
			if ($tipe === 'Musyarakah') {
				$akun = 87;
			} elseif ($tipe === 'Mudharabah') {
				$akun = 86;
			}
		}

		$dataJurnal = [
			'no' =>   $this->GenJurNumber(),
			'tgl' => date("Y-m-d"),
			'f_id' => 1,
			'invoice_no' => $invoice,
			'keterangan' => $ket,
			'waktu_post' => date("Y-m-d"),
			'id_project' => $id_project
		];
		$this->db->insert('jurnal', $dataJurnal);
		$lastID = $this->db->insert_id();

		$dataJurnal_detail_debit = [
			'jurnal_id' => $lastID,
			'item' => 1,
			'akun_id' => $akun,
			'debit_kredit' => 1,
			'nilai' => $untung
		];

		$dataJurnal_detail_kredit = [
			'jurnal_id' => $lastID,
			'item' => 2,
			'akun_id' => $akun_bank,
			'debit_kredit' => 0,
			'nilai' => $untung
		];

		$this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
		$this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);


		$saldo_akun_default_d1 = $this->db->select('saldo')->from('akun')->where('id', $akun)->get()->row()->saldo;
		$saldo_akun_default_k1 = $this->db->select('saldo')->from('akun')->where('id', $akun_bank)->get()->row()->saldo;
		$saldo_new_d1 = $saldo_akun_default_d1 + $untung;
		$this->db->where('id', $akun);
		$this->db->update('akun', ['saldo' => $saldo_new_d1]);
		$saldo_new_k1 = $saldo_akun_default_k1 - $untung;
		$this->db->where('id', $akun_bank);
		$this->db->update('akun', ['saldo' => $saldo_new_k1]);
	}

	function _sendEmail($id, $keuntungan)
	{
		$data = $this->db->get_where('virtual', ['virtual_account' => $id])->row();
		$email_user = $data->customer_email;
		$id_project = $data->id_project;
		$nama_project = $data->name_project;
		$jumlah_lot = $data->total_lot;
		$nominal = $data->trx_amount;
		$keuntungan = intval(str_replace(',', '', $keuntungan));
		$total_trans = $nominal + $keuntungan;

		// konfigurasi email server
		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://backoffice.fintekmadani.id',
			'smtp_user' => 'admin@backoffice.fintekmadani.id',
			'smtp_pass' => 'Bismillah2812',
			'smtp_port' => 465,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];

		$this->email->initialize($config);
		$this->load->library('email', $config);

		// Email dan nama pengirim penerima server
		$this->email->from('admin_back@devback.fulusme.com', 'Admin Fulusme');
		$this->email->to('' . $email_user . ',sinafadhiel@gmail.com, approval@fulusme.com');

		// Lampiran email, isi dengan url/path file
		// $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

		// Subject email
		$this->email->subject('NOTA CICILAN / PELUNASAN');

		// Isi email
		$this->email->message('Terima kasih Telah Melakukan Pendanaan Untuk Proyek ini, 
		Dengan ini kami mengembalikan Dana yang di setorkan Bersama dengan nilai keuntungan sbb:<br><br>
		<b>Nama Proyek / ID: ' . $nama_project . ' / ' . $id_project . ' </b><br>
		<b>No Transaksi: ' . $id . ' </b><br>
		<b>Total Pendanaan: ' . number_format($nominal) . ' </b><br>
		<b>Jumlah LOT: ' . $jumlah_lot . ' </b><br>
		<b>Nilai Keuntungan: ' . number_format($keuntungan) . ' </b><br>
		<b>Total yang di Transfer: ' . number_format($total_trans) . ' </b><br>
		<b>Tanggal Transfer: </b><br>
		<b>No Rekening: </b><br>
		<b>BANK: BNI Syariah</b><br><br>
		Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2555-8986 WA: XXXXXXXXXXX Email: info@fulusme.id
		');

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
			echo 'Sukses! email berhasil dikirim.';
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	function _sendEmailRetur($id)
	{
		$key = $this->db->get_where('virtual', ['virtual_account' => $id])->row();

		$email_user = $key->customer_email;

		// konfigurasi email server
		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://devback.fulusme.com',
			'smtp_user' => 'admin_back@devback.fulusme.com',    // Ganti dengan email gmail kamu
			'smtp_pass' => 'Bismillah2812',      // Password gmail kamu
			'smtp_port' => 465,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];

		$this->email->initialize($config);

		// Load library email dan konfigurasinya
		$this->load->library('email', $config);

		// Email dan nama pengirim penerima server
		$this->email->from('admin_back@devback.fulusme.com', 'Admin Fulusme');
		$this->email->to('' . $email_user . ',sinafadhiel@gmail.com, chesyah@fintekmadani.id');

		// Lampiran email, isi dengan url/path file
		// $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

		// Subject email
		$this->email->subject('Nota Retur');

		// Isi email
		$this->email->message('Sehubungan dengan tidak tercapainya nilai proyek yang dibutuhkan maka Dana yang sudah ditransfer akan kami
		kembalikan dengan rincian Sbb: <br><br>
		<b>Nama Project / ID : ' . $key->name_project . ' / ' . $key->id_project . ' </b><br>
		<b>Total Pendanaan : Rp. ' . number_format($key->trx_amount) . '</b><br>
		<b>Jumlah LOT : ' . $key->total_lot . '</b><br>
		<b>Biaya Transfer : 0 </b><br>
		<b>Total yang di Transfer : Rp. ' . number_format($key->payment_amount) . ' </b><br>
		<b>Tanggal Transfer : ' . $key->datetime_payment . ' </b><br>
		<b>Bank : BNI Syariah</b><br><br>
		Untuk informasi lebih lanjut silakan hubungi telp.: +62 21 2555-8986 WA: XXXXXXXXXXX Email: info@fulusme.id
		');

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
			echo 'Sukses! email berhasil dikirim.';
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	function GenJurNumber()
	{

		$trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1;')->row_array();

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

	function GenPgmNumber($jns)
	{
		$trxid = $this->db->query('SELECT * from jurnal order by id desc limit 1;')->row_array();

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



		$kode = "$jns-" . date('d') . "-" . $invno;

		return $kode;
	}

	function Genpaynumber()
	{

		$trxid = $this->db->query('SELECT * from as_debts_payment  order by paymentID desc limit 1')->row_array();
		$trxdate = date('Y-m-d');
		$produksiID = $trxid['debtInv'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$produksiIDfil = substr($produksiID, 10, 4);
		if ($produksiIDfil == "") {
			$trxDate = date('m/y');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . "/" . $invoice;
		} else {
			$trxDate = date('m/y');
			$trxd = substr($produksiID, 4, 5);
			if ($trxDate == $trxd) {
				$invnoa = $produksiIDfil + 1;
				$invnob = sprintf("%04d", $invnoa);
				$invno = $trxDate . "/" . $invnob;
			} else {
				$trxDate = date('m/y');
				$trx = 1;
				$invoice = sprintf("%04d", $trx);
				$invno = $trxDate . "/" . $invoice;
			}
		}

		$kode = "PIV-" . $invno;
		return $kode;
	}
}
		/* End of file jurnal.php */
		/* Location: ./application/controllers/jurnal.php */
