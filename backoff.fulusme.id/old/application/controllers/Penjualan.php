<?php

class Penjualan extends CI_Controller {

	public $identity_id;

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('penjualan_model');
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
		$data['title'] = 'Penjualan Barang';
		$data['main_content'] = 'penjualan/display';
		$data['account_data'] = $this->penjualan_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}
	
	function detail_sales($id)
	{
		$this->auth->check_user_authentification(1);
		$data['title'] = 'Detail Penjualan Barang';
		$data['main_content'] = 'penjualan/display_detail';
		$data['account_data'] = $this->penjualan_model->get_all_data_detail($id);
			$data['form_edit_jurnal'] = site_url('jurnal/update_jurnal_edit');
		$data['redirect_url'] = site_url( 'penjualan/detail_sales/' . $id );
		$accounts = $this->akun_model->get_data_for_dropdown_umum();
		$data['accounts'] = ($accounts) ? $accounts : array('-- Belum ada Akun --');
		$data['template'] = $this->jurnal_template_model->get_all_data();

		$invoiceID = $data['account_data'][0]->invoiceID;

		$data['data_jurnal'] = $this->db->query("SELECT jurnal_detail.*, jurnal.identityID FROM jurnal_detail 
			LEFT JOIN jurnal ON jurnal.id = jurnal_detail.jurnal_id
			WHERE jurnal.invoice_no = '". $invoiceID."'")->result();
		$this->load->view('template/template_xpanel', $data);
	}
	
	function popup()
	{
		$data['akun'] = $this->akun_model->get_all_data();
		$this->load->view('akun/popup', $data);
	}

	function add()
	{
		$data['title'] = "Tambah Penjualan";
        $data['tipe'] = 'add';
        $data['main_content'] = 'penjualan/form';
        $data['form_action'] = 'penjualan/insert';
        $data['all_kas'] = $this->akun_model->get_all_kas();
        $data['members'] = $this->db->get('as_members')->result();
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
		$this->penjualan_model->fill_data();
		//Check for duplicate account code
		if(!$this->penjualan_model->check_code())
		{
			$this->session->set_flashdata('message', 'No Faktur / No PO sudah digunakan!' );
			$this->add();
		}
		//Insert Data
		elseif($this->penjualan_model->insert_data())
		{
			$this->session->set_flashdata('message', 'Penambahan data penjualan berhasil');

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
						'keterangan' => implode(' ', $this->penjualan_model->data_keterangan )
					);
				}
			}

			$this->jurnal_model->data = array(
				'no' =>  $this->jurnal_model->GenJsl(),
				'tgl' => $this->penjualan_model->data['trxDate'],
				'f_id' => 5,
				'invoice_no' => $this->penjualan_model->data['invoiceID'],
				'keterangan' => implode(' ', $this->penjualan_model->data_keterangan ),
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s"),
				'identityID' => $this->identity_id,
				'sc_id' => $this->input->post('pelanggan')
			);
			if ($this->jurnal_model->check_no()) {
				$this->jurnal_model->insert_data();
			}

			redirect('penjualan/buku_penj');
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
	
	public function buku_penj()
	{
		$data['title'] = "Buku Penjualan";
		$data['main_content'] = 'penjualan/buku_penjualan';
		$this->load->helper('indodate');
		$identity_id = $this->input->post('lokasi') ? $this->input->post('lokasi') : $this->identity_id;
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list(1);
		$data['lokasi'] = $this->model_master->get_identity_lists(true);
		$data['selected_lokasi'] = $identity_id;
		$data['journal_data'] = $this->db->query("
			SELECT  as_sales_transactions.*, as_members.*
			FROM as_sales_transactions 
			LEFT JOIN as_members ON as_members.memberID = as_sales_transactions.memberID
			WHERE as_sales_transactions.identityID = {$identity_id}
			")->result();
		$data['search_URL'] = site_url('penjualan/buku_penj');
		$this->load->view('template/template_xpanel', $data);
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
/* End of file penjualan.php */
/* Location: ./application/CI_Controllers/pembelian.php */