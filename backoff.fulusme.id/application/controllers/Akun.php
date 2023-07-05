<?php

class Akun extends CI_Controller {

	public $identity_id;

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('akun_model');
		$this->load->model('setting_model');
		$this->load->model('jurnal_model');
		$this->load->model('model_master');
		$this->lang->load('surplus_lang', get_cookie('my_lang'));

		$this->identity_id = $this->session->userdata('IDENTITY_ID');
	}

	function index()
	{
		$this->auth->check_user_authentification(1);
		$data['title'] = $this->lang->line('display_akun');
		$data['main_content'] = 'akun/display';
		$data['account_data'] = $this->akun_model->get_all_data_akun();
		$this->load->view('template/template_xpanel', $data);
	}

	function popup()
	{
		$data['akun'] = $this->akun_model->get_all_data();
		$this->load->view('akun/popup', $data);
	}

	function add()
	{
		$data['title'] = $this->lang->line('tambah_akun');
		$data['main_content'] = 'akun/form';
		$data['act'] = 'add';
		$data['form_act'] = 'insert';
		$data['account_data'] = FALSE;
		
		$this->setting_model->table="as_company";
		$data['dataCompany'] = $this->setting_model->get_all_data()->result_array();
		
		$this->setting_model->table="akun";
		$data['dataAkun'] = $this->setting_model->get_all_data()->result_array();

		$data['account_groups'] = $this->akun_model->get_all_account_groups();
		$data['identities'] = $this->model_master->get_identity_lists(true);

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
		$data['akun'] = $this->akun_model->get_data_for_dropdown_umum();	
		$data['all_kas'] = $this->akun_model->get_data_for_dropdown_kas_bank();
		$akun_ekuitas = $this->input->post('kredit');
		$kode_trx_sa='SA' . date('YmdHis');
		if('post' === $this->input->method()){
			$id=$this->input->post('nama');
			$saldo_awal=str_replace(',','', $this->input->post('saldo_awal'));
			$tanggal = $this->input->post('tanggal');
			$tanggal = date('Y-m-d', strtotime( $tanggal ) );

			$exist = $this->db->query("SELECT akun_id FROM akun_saldo WHERE akun_id = '" . $id . "' AND identityID=" . $this->identity_id )->row_array();
			if ( $exist ) {
				$query = 'UPDATE akun_saldo SET saldo_awal = '. $saldo_awal.', tanggal= "'. $tanggal .'",sa_trx_no= "'. $kode_trx_sa .'" WHERE akun_id = ' . $id . ' AND identityID=' . $this->identity_id;
				$this->db->query( $query );
			} else {
				$data_insert = array(
					'akun_id' => $id,
					'identityID' => $this->identity_id,
					'saldo_awal' => $saldo_awal,
					'sa_trx_no' => $kode_trx_sa
				);
				$this->db->insert('akun_saldo', $data_insert);
			}

			$ekuitas =$this->db->query("SELECT saldo, saldo_awal FROM akun_saldo WHERE akun_id=" . $akun_ekuitas . " AND identityID=" . $this->identity_id )->row_array();
			if ( $ekuitas ) {
				if ( $ekuitas['saldo_awal'] <= 0 ) {
					$query = 'UPDATE akun_saldo SET saldo_awal = '. $saldo_awal.', tanggal= "'. $tanggal .'", sa_trx_no= "'. $kode_trx_sa .'" WHERE akun_id = ' . $akun_ekuitas . ' AND identityID=' . $this->identity_id;
					$this->db->query( $query );
				}
			} else {
				$data_insert = array(
					'akun_id' => $akun_ekuitas,
					'identityID' => $this->identity_id,
					'saldo_awal' => $saldo_awal,
					'sa_trx_no' => $kode_trx_sa
				);
				$this->db->insert('akun_saldo', $data_insert);
			}

			// jurnal data
			$akun = array();
			$akun[1] = array(
				'item' => 1,
				'akun_id' => $id,
				'debit_kredit' => 1,
				'nilai' => $saldo_awal,
				'keterangan' => 'Saldo Awal'
			);
			$akun[2] = array(
				'item' => 2,
				'akun_id' => $akun_ekuitas, // id coa ekuitas awal
				'debit_kredit' => 0,
				'nilai' => $saldo_awal,
				'keterangan' => 'Saldo Awal'
			);
	
			$this->jurnal_model->data = array(
				'no' =>  $this->jurnal_model->GenJunSA(),
				'tgl' => $tanggal,
				'f_id' => 13,
				'invoice_no' => $kode_trx_sa,
				'keterangan' => 'input saldo awal',
				'login_id' => $this->session->userdata('SESS_USER_ID'),
				'waktu_post' => date("Y-m-d H:i:s"),
				'identityID' => $this->identity_id
			);
			$this->jurnal_model->details = $akun;
			$this->jurnal_model->insert_data();
		}
		$data['saldoawal']=$this->db->query("SELECT akun_saldo.*, akun.nama, akun.kode FROM akun_saldo
											LEFT JOIN akun ON akun.id = akun_saldo.akun_id
											WHERE akun_saldo.saldo>0 AND akun_saldo.identityID=" . $this->identity_id)->result_array();
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
	function saldo_awal_input_data()
	{
		$data['title'] = $this->lang->line('data_saldo_awal');
		$data['action'] = 'input';
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
		$data['identities'] = $this->model_master->get_identity_lists(true);
		$this->load->view('template/template_xpanel', $data);
	}

	function insert()
	{
		if (!$this->_akun_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->add();
		}
		else
		{
			$this->akun_model->fill_data();
			//Check for duplicate account name
			if(!$this->akun_model->check_name())
			{
				$this->session->set_userdata('ERRMSG_ARR', $this->lang->line('nama_akun_used'));
				$this->add();
			}
			//Check for duplicate account code
			elseif(!$this->akun_model->check_code())
			{
				$this->session->set_userdata('ERRMSG_ARR', $this->lang->line('id_akun_used'));
				$this->add();
			}
			//Insert Data
			elseif($this->akun_model->insert_data())
			{
				$this->session->set_userdata('SUCCESSMSG', $this->lang->line('akun_sukses'));
				redirect('akun');
			}
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
	function input_saldo_awal_bulk()
	{
		

		if (!$this->_saldo_awal_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->saldo_awal_input_data();
		}
		else
		{
			$error_message = $this->_check_sum();
			if($error_message != '')
			{
				$this->session->set_userdata('ERRMSG_ARR', $error_message);
				$this->saldo_awal_input_data();
			}
			else
			{
				//Update Saldo Awal
				if($this->akun_model->set_saldo_awal_bulk())
				{
					// jurnal data
				$akun = array();
				$id = $this->input->post('id');
				 
				foreach ($id as $key => $i){ 	
						$akun[] = array(
							'item' => 1,
							'akun_id' => $id,
							'debit_kredit' => 1,
							'nilai' => $saldo_awal,
							'keterangan' => 'Saldo Awal'
						);
				}
				$this->jurnal_model->data = array(
					'no' =>  $this->jurnal_model->GenJunSA(),
					'tgl' => $tanggal,
					'f_id' => 13,
					'invoice_no' => $kode_trx_sa,
					'keterangan' => 'input saldo awal',
					'login_id' => $this->session->userdata('SESS_USER_ID'),
					'waktu_post' => date("Y-m-d H:i:s"),
					'identityID' => $this->identity_id
				);
				$this->jurnal_model->details = $akun;
				$this->jurnal_model->insert_data();

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
		$this->form_validation->set_rules('nama', 'Nama Akun', 'trim|required');
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

	public function mapping_akun()
	{
		$identityID=$this->session->userdata('IDENTITY_ID');
		 $identityName=$this->session->userdata('identityName');
		$data['title'] = 'Mapping Akun Unit : '.$identityName;
		$data['main_content'] = 'akun/akun_mapping';
		$akun = $this->db->query("SELECT akun.nama, akun.kode, akun.id FROM akun where akun.id not in (select akun_id from akun_saldo where identityID='".$identityID."' )")->result_array();	
		$data['identities'] = $this->model_master->get_identity_lists(true);

		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['id']] = $value['nama'].' - '.$value['kode'];
			}
		} else { $data['akun']=''; }
		if('post' === $this->input->method()){
			$akun_id = $this->input->post('nama_akun');
			$in = $this->input->post('in');
			$out = $this->input->post('out');
			$data_insert = array(
				'akun_id' => $akun_id,
				'identityID' => $identityID,
				'in' => $in,
				'out' => $out
			);
			$this->db->insert('akun_saldo', $data_insert);
			 redirect('akun/mapping_akun', 'refresh');
		}
		$data['saldoawal']=$this->db->query("SELECT akun_saldo.akun_saldo_id,akun.nama, akun.kode FROM akun_saldo
											LEFT JOIN akun ON akun.id = akun_saldo.akun_id
											WHERE akun_saldo.identityID='".$this->identity_id."' order by akun.kode asc")->result_array();
		$data['form_action'] = 'akun/mapping_akun';
		$data['field']= array(
			'no' => 'No',
			"nama"=>"Nama Akun",
			"kode"=>"Kode"
			);
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	function mapping_akun_delete($id)
	{
		
		$this->db->where('akun_saldo_id', $id);
		$delete = $this->db->delete('akun_saldo');
		redirect('akun/mapping_akun');
	}
	
	public function config_akun()
	{
		$identityName=$this->session->userdata('identityName');
		$identityID=$this->session->userdata('IDENTITY_ID');
		$data['title'] = 'Config Akun Unit : '.$identityName;
		$data['main_content'] = 'akun/akun_config';
		$data['data_akun_config'] = $this->akun_model->get_all_data_akun_config();
		$data['nama_akun2'] = $this->akun_model->get_all_data2();
		$data['nama_akun_config'] = $this->akun_model->get_all_data_conf();
		$data['act'] = 'add';
		$data['form_act'] = 'insert_conf_akun';
		$data['client_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}
	
	
	
	function delete_conf_akun($id)
	{
		
        $data = array(
			'akun_id' => null
        );
		$this->db->where('configAkunID', $id);
		$this->db->update('tbl_config_akun', $data);


        redirect('akun/config_akun');
	}
	
	public function insert_conf_akun()
    {
       
        $akun_config   = $this->input->post('akun_config');
        $akun    = $this->input->post('akun');
        
        $data = array(
			'akun_id' => $akun
        );
		$this->db->where('configAkunID', $akun_config);
		$this->db->update('tbl_config_akun', $data);


        redirect('akun/config_akun');
    }

}
/* End of file akun.php */
/* Location: ./application/CI_Controllers/akun.php */
