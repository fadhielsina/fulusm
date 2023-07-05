<?php

class Pembelian extends CI_Controller {

	public $identity_id;

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('pembelian_model');
		$this->load->model('akun_model');
		$this->load->model('jurnal_model');
		$this->load->model('jurnal_template_model');
		$this->load->model('model_master');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));

		$this->identity_id = $this->session->userdata('IDENTITY_ID');
	}

	function index()
	{
		$this->auth->check_user_authentification(1);
		$data['title'] = 'Pembelian Barang';
		$data['main_content'] = 'pembelian/display';
		$data['account_data'] = $this->pembelian_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	function detail_buy($id)
	{
		$this->auth->check_user_authentification(1);
		$data['title'] = 'Detail Pembelian Barang';
		$data['main_content'] = 'pembelian/display_detail';
		$data['account_data'] = $this->pembelian_model->get_all_data_detail($id);
		$data['satuans'] = $this->model_master->get_satuans();
		$data['form_edit_action'] = site_url('pembelian/update_detail');
		$data['form_edit_jurnal'] = site_url('jurnal/update_jurnal_edit');
		$data['redirect_url'] = site_url( 'pembelian/detail_buy/' . $id );
		$accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['template'] = $this->jurnal_template_model->get_all_data();

		$invoiceID = $data['account_data'][0]->invoiceBuyID;

		$data['data_jurnal'] = $this->db->query("SELECT jurnal_detail.*, jurnal.identityID FROM jurnal_detail 
			LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
			WHERE jurnal.invoice_no = '". $invoiceID."'")->result();

		//echo '</pre>';
		//print_r( $data['account_data']);
		//echo '</pre>'; die();
		$this->load->view('template/template_xpanel', $data);
	}

	function update_detail()
	{
		$this->auth->check_user_authentification(1);
		 $trxID = $this->input->post('trxID');
		$detail_id = $this->input->post('detailID');
		$subtotal = ( $this->input->post('harga') - intval( $this->input->post('diskon') ) ) * $this->input->post('qty');
		$ppn = $subtotal * ($this->input->post('ppn')/100);
		$total = $subtotal + $ppn; 

		$data = array(
			'detailBuyPrice' => $this->input->post('harga'),
            'detailBuyQty' => $this->input->post('qty'),
            'detailBuySat1' => $this->input->post('satuan_1'),
            'detailBuyQty2' => $this->input->post('qty_2'),
            'detailBuySat2' => $this->input->post('satuan_2'),
            'discPercent' => $this->input->post('diskon'),
			 'ppn' => $this->input->post('ppn'),
            'detailBuySubtotal' => $total,
		);
		$this->db->where('detailID', $detail_id);
		$this->db->update('as_buy_detail_transactions', $data);

		$this->session->set_flashdata('message', 'Data berhasil di edit' );
		
		redirect('pembelian/detail_buy/' . $trxID );
	}
	
	function popup()
	{
		$data['akun'] = $this->akun_model->get_all_data();
		$this->load->view('akun/popup', $data);
	}

	function add()
	{
		$data['title'] = "Tambah Pembelian";
        $data['tipe'] = 'add';
        $data['main_content'] = 'pembelian/form';
        $data['form_action'] = 'pembelian/insert';
        $data['all_kas'] = $this->akun_model->get_all_kas();
        $data['supplier'] = $this->db->select('*')->where('identityID',$this->identity_id)->get('as_suppliers')->result();
        $accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['template'] = $this->jurnal_template_model->get_all_data();
		$data['satuans'] = $this->model_master->get_satuans();

        $this->load->view('template/template_xpanel', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('lihat_akun');
		$data['main_content'] = 'akun/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$this->setting_model->table="as_company";
		$data['dataCompany'] = $this->setting_model->get_all_data()->result_array();
		
		$this->setting_model->table="akun";
		$data['dataAkun'] = $this->setting_model->get_all_data()->result_array();

		$data['account_data'] = $this->akun_model->get_data_by_id($id);
		$data['account_groups'] = $this->akun_model->get_all_account_groups();
		$this->load->view('template/template_xpanel', $data);
	}

	function detail_akun()
	{
		$data['title'] = $this->lang->line('detail_akun');
		$data['main_content'] = 'akun/detail_akun';
		$data['account_data'] = $this->akun_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}

	function saldo_awal()
	{
		$data['title'] = $this->lang->line('saldo_awal');
		$data['main_content'] = 'akun/saldo_awal_rev';
		$akun = $this->db->query("SELECT akun.nama, akun.kode, akun.id FROM akun WHERE kelompok_akun_id IN (1,2,3,6)")->result_array();	
		$akun_ekuitas = 54;

		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['id']] = $value['nama'].' - '.$value['kode'];
			}
		}
		if('post' === $this->input->method()){
			$id=$this->input->post('nama');
			$saldo_awal=str_replace(',','', $this->input->post('saldo_awal'));
			$get = $this->db->query("SELECT saldo, saldo_awal, kelompok_akun_id FROM akun WHERE id=" . $id)->row_array();
			$ekuitas =$this->db->query("SELECT saldo, saldo_awal, kelompok_akun_id FROM akun WHERE id=" . $akun_ekuitas)->row_array();
			$tanggal = $this->input->post('tanggal');
			$query = 'UPDATE akun SET saldo_awal = '. $saldo_awal.', tanggal= "'. $tanggal .'" WHERE id = ' . $id;
			$this->db->query( $query );
			if ( '1' == $get['kelompok_akun_id'] ) {
				$dari = 1;
				$ke = 0;
			} elseif ( '2' == $get['kelompok_akun_id'] ) {
				$dari = 0;
				$ke = 1;
			}
	
			// Set ekuitas
			if ( $ekuitas['saldo_awal'] <= 0 ) {
				$query_ekuitas = 'UPDATE akun SET saldo_awal = '. $saldo_awal.', tanggal= "'. $tanggal .'" WHERE id = ' . $akun_ekuitas;
				$this->db->query( $query_ekuitas );
			}
	
			// jurnal data
			$akun = array();
			$akun[1] = array(
				'item' => 1,
				'akun_id' => $id,
				'debit_kredit' => $dari,
				'nilai' => $saldo_awal,
				'keterangan' => ''
			);
			$akun[2] = array(
				'item' => 2,
				'akun_id' => $akun_ekuitas, // id coa ekuitas awal
				'debit_kredit' => $ke,
				'nilai' => $saldo_awal,
				'keterangan' => ''
			);
	
			$this->jurnal_model->data = array(
				'no' =>  $this->jurnal_model->GenJurNumber(),
				'tgl' => $tanggal,
				'f_id' => 1,
				'invoice_no' => 'SA' . date('YmdHis'),
				'keterangan' => 'input saldo awal',
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s")
			);
			$this->jurnal_model->details = $akun;
			$this->jurnal_model->insert_data();
	
			$data['saldoawal']=$this->db->query("SELECT
												* FROM akun
												WHERE saldo_awal>0")->result_array();
			$data['field']= array(
							"nama"=>"Nama Akun",
							"kode"=>"Kode",
							"saldo_awal"=>"Saldo Awal",
							"tanggal"=>"per Tanggal"
							);

		}
		$data['saldoawal']=$this->db->query("SELECT * FROM akun
											WHERE saldo_awal>0")->result_array();
		$data['field']= array(
			"nama"=>"Nama Akun",
			"kode"=>"Kode",
			"saldo_awal"=>"Saldo Awal",
			"tanggal"=>"per Tanggal"
			);
		$this->load->view('template/template_xpanel', $data);
	}

	function tampil_saldo(){
		$id=$this->input->post('nama');
		$saldo_awal=str_replace(',','', $this->input->post('saldo_awal'));
		$get = $this->db->query("SELECT saldo, saldo_awal, kelompok_akun_id FROM akun WHERE id=" . $id)->row_array();
		$ekuitas =$this->db->query("SELECT saldo, saldo_awal, kelompok_akun_id FROM akun WHERE id=214")->row_array();
		$tanggal = $this->input->post('tanggal');
		$query = 'UPDATE akun SET saldo_awal = '. $saldo_awal.', tanggal= "'. $tanggal .'" WHERE id = ' . $id;
		$this->db->query( $query );
		if ( '1' == $get['kelompok_akun_id'] ) {
			$dari = 1;
			$ke = 0;
		} elseif ( '2' == $get['kelompok_akun_id'] ) {
			$dari = 0;
			$ke = 1;
		}

		// Set ekuitas
		$akun_Ekuitas = '214'; // id_akun ekutitas/modal
		if ( $ekuitas['saldo_awal'] <= 0 ) {
			$query_ekuitas = 'UPDATE akun SET saldo_awal = '. $saldo_awal.' WHERE id ='.$akun_Ekuitas.'  ';
			$this->db->query( $query_ekuitas );
		}

		// jurnal data
		$akun = array();
		$akun[1] = array(
			'item' => 1,
			'akun_id' => $id,
			'debit_kredit' => $dari,
			'nilai' => $saldo_awal,
			'keterangan' => ''
		);
		$akun[2] = array(
			'item' => 2,
			'akun_id' => $akun_Ekuitas,
			'debit_kredit' => $ke,
			'nilai' => $saldo_awal,
			'keterangan' => ''
		);

		$this->jurnal_model->data = array(
			'no' =>  $this->jurnal_model->GenJurNumber(),
			'tgl' => $tanggal,
			'f_id' => 1,
			'invoice_no' => 'SA' . date('YmdHis'),
			'keterangan' => 'input saldo awal',
			'login_id' => $this->session->userdata('SESS_USER_ID'),
			'waktu_post' => date("Y-m-d H:i:s")
		);
		$this->jurnal_model->details = $akun;
		$this->jurnal_model->insert_data();

		$data['saldoawal']=$this->db->query("SELECT
											* FROM akun
											WHERE saldo_awal>0")->result_array();
		$data['field']= array(
						"nama"=>"Nama Akun",
						"kode"=>"Kode",
						"saldo_awal"=>"Saldo Awal",
						"tanggal"=>"per Tanggal"
						);
		$this->load->view('akun/saldo',$data);
	}

	function saldo_awal_data()
	{
		$data['title'] = $this->lang->line('data_saldo_awal');
		$data['main_content'] = 'akun/saldo_awal_data';
		$data['account_data'] = $this->akun_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = $this->lang->line('edit_akun');
		$this->setting_model->table="as_company";
		$data['dataCompany'] = $this->setting_model->get_all_data()->result_array();
		
		$this->setting_model->table="akun";
		$data['dataAkun'] = $this->setting_model->get_all_data()->result_array();
		
		$data['main_content'] = 'akun/form';
		$account_data = $this->akun_model->get_data_by_id($id);
		if($this->_check_jurnal_exist($id))
		{
			$this->session->set_userdata('ERRMSG_ARR', 'Akun '.$account_data['nama'].' tidak dapat diedit karena telah dipakai di jurnal.');
			$data['act'] = 'view';
			$data['form_act'] = '';
		}
		else
		{
			$data['act'] = 'edit';
			$data['form_act'] = 'update/'.$id;
		}
		$data['account_data'] = $account_data;
		$data['account_groups'] = $this->akun_model->get_all_account_groups();
		$this->load->view('template/template_xpanel', $data);
	}

	function insert()
	{
			$supplierid=$this->input->post('supplier');
			$q_data = $this->db->query("SELECT * FROM as_suppliers WHERE supplierID = '".$supplierid."' ");
			$a_data = $q_data->row();
			$supplierCode=$a_data->supplierCode;
			$sc_ven=$supplierCode;
		$this->pembelian_model->fill_data();
		//Check for duplicate account code
		if(!$this->pembelian_model->check_code())
		{
			$this->session->set_flashdata('message', 'No Faktur / No PO sudah digunakan!' );
			$this->add();
		}
		//Insert Data
		elseif($this->pembelian_model->insert_data())
		{
			$this->session->set_flashdata('message', 'Penambahan data pembelian berhasil');

			// Insert jurnal
			$akun = $this->input->post('akun');
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
						'keterangan' => implode(' ', $this->pembelian_model->data_keterangan )
					);
				}
			}

			$this->jurnal_model->data = array(
				'no' =>  $this->jurnal_model->GenJpb(),
				'tgl' => $this->pembelian_model->data['trxDate'],
				'f_id' => 4,
				'invoice_no' => $this->pembelian_model->data['invoiceBuyID'],
				'keterangan' => implode(' ', $this->pembelian_model->data_keterangan ),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s"),
				'identityID' => $this->identity_id,
				'sc_id' => $this->input->post('supplier'),
			    'sc_ven' => $sc_ven
			);
			if ($this->jurnal_model->check_no()) {
				$this->jurnal_model->insert_data();
			}

			redirect('pembelian/buku_pemb');
		}
	}

	function update()
	{
		$id = $this->uri->segment(3);
		if (!$this->_akun_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->edit();
		}
		else
		{
			$this->akun_model->fill_data();
			//Check for duplicate account name
			if(!$this->akun_model->check_name($id))
			{
				$this->session->set_userdata('ERRMSG_ARR', 'Nama Akun telah digunakan');
				$this->edit();
			}
			//Check for duplicate account code
			elseif(!$this->akun_model->check_code($id))
			{
				$this->session->set_userdata('ERRMSG_ARR', 'Kode Akun telah digunakan');
				$this->edit();
			}
			//Update Data
			elseif($this->akun_model->update_data($id))
			{
				$this->session->set_userdata('SUCCESSMSG', 'Update Akun sukses ;)');
				redirect('akun');
			}
		}
	}

	function delete()
	{
		$id = $this->input->post('id');
		$account_data = $this->akun_model->get_data_by_id($id);
		if($this->_check_jurnal_exist($id))
		{
			$msg = 'E#Akun '.$account_data['nama'].' tidak dapat dihapus karena telah dipakai di jurnal.';
		}
		else
		{
			if($this->akun_model->delete_data($id))
			{
				$msg = 'S#Akun '.$account_data['nama'].' telah dihapus.';
			}
			else
			{
				$msg .= 'E#Terjadi kesalahan dalam menghapus data akun '.$account_data['nama'].'. Harap coba lagi.';
			}
		}
		echo $msg;
	}
	
	
	public function buku_pemb()
	{
		$data['title'] = "Buku Pembelian";
		$data['main_content'] = 'pembelian/buku_pembelian';
		$this->load->helper('indodate');
		$identity_id = $this->input->post('lokasi') ? $this->input->post('lokasi') : $this->identity_id;
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $identity_id;
		$data['journal_data'] = $this->db->query("
			SELECT  as_buy_transactions.*, as_suppliers.*,as_buy_detail_transactions.*,as_barang.*
			FROM as_buy_detail_transactions 
			LEFT JOIN as_buy_transactions ON as_buy_detail_transactions.invoiceBuyID = as_buy_transactions.invoiceBuyID
			LEFT JOIN as_barang ON as_barang.barangID = as_buy_detail_transactions.bahanID
			LEFT JOIN as_suppliers ON as_suppliers.supplierID = as_buy_transactions.supplierID
			WHERE as_buy_transactions.identityID = {$identity_id} order by as_buy_transactions.invoiceBuyID
			")->result();
		$data['search_URL'] = site_url('pembelian/buku_pemb');
		$this->load->view('template/template_xpanel', $data);
	}
	
	function input_saldo_awal()
	{
		if (!$this->_saldo_awal_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->saldo_awal();
		}
		else
		{
			$error_message = $this->_check_sum();
			if($error_message != '')
			{
				$this->session->set_userdata('ERRMSG_ARR', $error_message);
				$this->saldo_awal();
			}
			else
			{
				//Update Saldo Awal
				if($this->akun_model->set_saldo_awal())
				{
					$this->session->set_userdata('SUCCESSMSG', $this->lang->line('valid_saldo_awal'));
					redirect('akun/saldo_awal');
				}
			}
		}
	}

	function _check_sum()
	{
		$error_message = '';
		$debit_sum = 0;
		$kredit_sum = 0;
		$id = $this->input->post('id');
		for ($i = 1; $i <= count($id); $i++)
		{
			$debit = $this->input->post('debit'.$i);
			$kredit = $this->input->post('kredit'.$i);
			$debit_sum += $debit;
			$kredit_sum += $kredit;
		}
		if($debit_sum != $kredit_sum)
		{
			$error_message = "Jumlah debit harus sama dengan jumlah kredit.";
		}
		return $error_message;
	}

	function _check_jurnal_exist($id)
	{
		$this->load->model('jurnal_model');
		$this->jurnal_model->set_account_id($id);
		$journal_data = $this->jurnal_model->get_data();
		if ($journal_data)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _akun_validation()
	{
		//$this->form_validation->set_rules('nama', 'Nama Akun', 'trim|required');
		//$this->form_validation->set_rules('id_division', 'Division', 'trim|required');
		//$this->form_validation->set_rules('id_departement', 'Departement', 'trim|required');
		//$this->form_validation->set_rules('kode', 'Kode Akun', 'trim|required|numeric');

		return $this->form_validation->run();
	}

	function _saldo_awal_validation()
	{
		$id = $this->input->post('id');
		for ($i = 1; $i <= count($id); $i++)
		{
			$this->form_validation->set_rules('debit'.$i, 'Debit', 'trim|is_natural');
			$this->form_validation->set_rules('kredit'.$i, 'Kredit', 'trim|is_natural');
		}

		return $this->form_validation->run();
	}

}
/* End of file pembelian.php */
/* Location: ./application/CI_Controllers/pembelian.php */