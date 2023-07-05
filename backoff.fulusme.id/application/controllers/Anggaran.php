<?php
class anggaran extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library(array('auth','session','customlib'));
		$this->auth->check_user_authentification();
		$this->load->model('anggaran_model');	
		$this->load->model('akun_model');
		$this->load->helper('tgl_indo_helper');
		$this->load->helper('indodate');
		$this->load->helper('finance');
		//$this->load->library(array('fpdf'));
		$this->load->helper(array('date','url'));
		$this->lang->load('surplus_lang', get_cookie('my_lang'));
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	}
	
	function index()
	{
		//$this->keuangan();
		$data['title'] = $this->lang->line('data_mata_anggaran');
		$data['action_add'] = site_url()."anggaran/tambah";
		$data['action_delete'] = site_url()."anggaran/delete";
		$data['main_content'] = 'mata_anggaran/list';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$data['anggaran'] = $this->anggaran_model->get_all()->result_array();
		$data['field'] = array("id_mata_anggaran"=>$this->lang->line('id_anggaran'),
								"mata_anggaran"=>$this->lang->line('nama_anggaran'));

		$this->load->view('template/template_xpanel', $data);
	}
	function tambah($id="")
	{
		$data['module_name'] = "anggaran";
		$data['title'] = $this->lang->line('tambah_mata_anggaran');
		$data['main_content'] = 'mata_anggaran/tambah';
		if($id!=""){
			$data['anggaran'] = $this->anggaran_model->get_all()->row();

		}else{
			$data['anggaran'] = array("id_mata_anggaran"=>"",
								"mata_anggaran"=>"");			
		}
			
		$data['form_act'] = site_url('anggaran/proses_tambah');
		$data['act'] = "tambah";
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();

		$this->load->view('template/template_xpanel', $data);
	}
	function proses_tambah()
	{
		//var_dump($this->input->post("module"));
		if($this->input->post("module") =="anggaran"){
			$this->anggaran_model->table="m_mata_anggaran";

			$dataInput = array("id_mata_anggaran"=>$this->input->post("id_mata_anggaran"),
								"mata_anggaran"=>$this->input->post("mata_anggaran"));

			$input = $this->anggaran_model->table_add($dataInput);
			if($input != false){
				redirect('anggaran');
			}else{
				$this->session->set_userdata('ERRMSG_ARR',"Error Menambahkan data");
				$this->tambah();
			}
		}else if($this->input->post("module") =="periode"){
			$this->anggaran_model->table="m_periode_anggaran";

			$dataInput = array("nama_periode"=>$this->input->post("nama_periode"),
								"id_mata_anggaran"=>$this->input->post("mata_anggaran"),
								"tanggal_awal"=>$this->input->post("tanggal_awal"),
								"tanggal_akhir"=>$this->input->post("tanggal_akhir"));


			$input = $this->anggaran_model->table_add($dataInput);
			if($input === false){
				redirect('anggaran/tambah_periode');
			}else{
				//$this->session->set_userdata('ERRMSG_ARR',"Error Menambahkan data");
				redirect('anggaran/setting_periode');
			}
		}
	}
	//

	///
	
	function setting_periode()
	{
		//$this->keuangan();
		$data['title'] = $this->lang->line('data_periode_anggaran');
		$data['action_add'] = site_url()."anggaran/tambah_periode";
		$data['action_delete'] = site_url()."anggaran/delete_periode";
		$data['action_aktifkan'] = site_url()."anggaran/aktifkan_periode";
		$data['main_content'] = 'mata_anggaran/list_periode';		
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->anggaran_model->table="m_periode_anggaran";
		$data['anggaran'] = $this->anggaran_model->get_all_periode()->result_array();
		$data['field'] = array("id_periode"=>$this->lang->line('id_peride_anggaran'),
								"nama_periode"=>$this->lang->line('periode_anggaran'),
								"mata_anggaran"=>$this->lang->line('nama_anggaran'),
								"tanggal_awal"=>$this->lang->line('tanggal_awal'),
								"tanggal_akhir"=>$this->lang->line('tanggal_akhir'));


		$this->load->view('template/template_xpanel', $data);
	}
	function tambah_periode($id="")
	{
		$data['title'] = $this->lang->line('tambah_periode_anggaran');
		$data['module_name'] = "periode";
		$data['main_content'] = 'mata_anggaran/tambah_periode';
		$anggaran = $this->anggaran_model->get_all()->result_array();
		if(is_array($anggaran) && count($anggaran)>0){
			foreach ($anggaran as $key => $value) {
				$data['anggaran'][$value['id_mata_anggaran']] = $value['mata_anggaran'];
			}
			
		}else{
			$data['anggaran'] = array("0"=>"Mata anggaran masih koson");
		}
		if($id!=""){
			$this->anggaran_model->table="m_periode_anggaran";
			$data['periode'] = $this->anggaran_model->get_all_periode()->result_array();	

		}else{
			$data['periode'] = array("nama_periode"=>"",
								"id_mata_anggaran"=>"",
								"tanggal_awal"=>"",
								"tanggal_akhir"=>"");		
		}
			
		$data['form_act'] = site_url('anggaran/proses_tambah');
		$data['act'] = "tambah";
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();

		$this->load->view('template/template_xpanel', $data);
	}
	function aktifkan_periode($id,$aktifStatus=""){
		$aktif = 1;
		if($aktifStatus!=""){
			$aktif=$aktifStatus;
		}
		if($aktifStatus=="0"){
			//cek saat nonaktifkan tidak boleh semua di non aktifkan
			$cekQ = $this->db->query("SELECT * FROM m_periode_anggaran WHERE is_aktif=1");
			if($cekQ->num_rows() <=1){
				$this->session->set_flashdata("message","Gagal non aktifkan, Minimal Harus ada 1 periode yang aktif");
				redirect("anggaran/setting_periode");
			}
		}

		//die($id);
		//if($this->db->query("UPDATE m_periode_anggaran SET is_aktif=0")){
			$this->db->query("UPDATE m_periode_anggaran SET is_aktif='".$aktif."' WHERE id_periode='".$id."'");
		//}



		redirect("anggaran/setting_periode");

	}



	function mapping()
	{
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$data['title'] = $this->lang->line('mapping_mata_anggaran');
		$data['main_content'] = 'mata_anggaran/mapping';
		$data['nama_laporan']	 = "mapping_anggaran";
		$akun = $this->akun_model->get_all_akun_arr();
		if(count($akun)>0){
			foreach ($akun as $key => $value) {
				$value = (array)$value;
				$data['akun'][$value['id']] = $value['nama'];
			}
		}

		$this->anggaran_model->table="m_periode_anggaran";
		$data['periode'] = $this->anggaran_model->get_all_periode()->result_array();	
		if(count($data['periode'])>0){
			foreach ($data['periode'] as $key => $value) {
				$data['options_periode'][$value['id_periode']] = $value['nama_periode'];
			}
			
		}
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();

		$data['title'] = $this->input->post("nama_laporan");
		$data['mapping'] = $this->db->query("SELECT m_mapping_anggaran.id_mapping,		
		m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, m_mapping_anggaran.nominal, akun.kode,
		 akun.nama FROM m_mapping_anggaran 
		LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
		WHERE id_periode='".date('m')."'")->result_array();
		$data['bulan']= 
		$data['action_delete'] = site_url()."anggaran/delete_mapping";
		$data['field'] = array(
							//"id_periode"=>"ID Periode",
							"nama"=>"Nama Akun",
							"kode"=>"Kode Akun",
							//"tanggal_awal"=>$this->lang->line('tanggal_awal'),
							//"tanggal_akhir"=>$this->lang->line('tanggal_akhir'),
							"nominal"=>"Anggaran"
							);


		$this->load->view('template/template_xpanel', $data);
	}
	
	function mapping_edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = "Edit Anggaran";
		$data['akun'] = $this->akun_model->get_all_data2();
		$data['main_content'] = 'mata_anggaran/form_edit';
		$data['act'] = 'anggaran/mapping_edit_act';
		$data['form_act'] = 'mapping_edit_act/'.$id;
		$data['mapping_data'] = $this->anggaran_model->get_data_by_id($id);
		$this->load->view('template/template_xpanel', $data);
	}
	
	function mapping_edit_act()
	{
		$id = $this->uri->segment(3);
		$this->anggaran_model->fill_data_up();
		$this->anggaran_model->update_data_up($id);
		$this->session->set_userdata('SUCCESSMSG', 'Update Anggaran sukses ;)');
		redirect('anggaran/mapping');
	}
	
	
	function mapping_tambah(){
		
		$this->form_validation->set_rules('anggaran','Anggaran','required');


		if($this->form_validation->run()  == false){
			redirect('mapping');
		} else {

			$dataMapping = array(
			'id_periode' => $this->input->post("bulan"),
			'id_akun' => $this->input->post("id_akun"),
			'nominal' => (float)$this->input->post("anggaran"),
			);
	
			$this->anggaran_model->table="m_mapping_anggaran";
			if($dataMapping['nominal'] > 0 )
			{
				$inputMapping = $this->anggaran_model->table_add($dataMapping);
			}
			
			$data['title'] = $this->input->post("nama_laporan");
			$data['mapping'] = $this->db->query("SELECT m_mapping_anggaran.id_mapping,		
			m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, m_mapping_anggaran.nominal, akun.kode,
			 akun.nama FROM m_mapping_anggaran 
			LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
			WHERE id_periode='". $this->input->post("bulan")."'")->result_array();
	
			$data['action_delete'] = site_url()."anggaran/delete_mapping";
			$data['field'] = array(
								//"id_periode"=>"ID Periode",
								"nama"=>"Nama Akun",
								"kode"=>"Kode Akun",
								//"tanggal_awal"=>$this->lang->line('tanggal_awal'),
								//"tanggal_akhir"=>$this->lang->line('tanggal_akhir'),
								"nominal"=>"Anggaran"
								);
	
			$this->load->view('mata_anggaran/list_mapping', $data);
		}
	}

	function load_mapping()
	{ 
		$data['title'] = $this->input->post("nama_laporan");
		$where = '';
		if ( $this->input->post('bulan') ) {
			$where = "WHERE id_periode='". $this->input->post("bulan")."'";
		}
		$data['mapping'] = $this->db->query("SELECT m_mapping_anggaran.id_mapping,		
		m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, m_mapping_anggaran.nominal, akun.kode,
		 akun.nama FROM m_mapping_anggaran 
		LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
		" . $where )->result_array();

		$data['action_delete'] = site_url()."anggaran/delete_mapping";
		$data['field'] = array(
							//"id_periode"=>"ID Periode",
							"nama"=>"Nama Akun",
							"kode"=>"Kode Akun",
							//"tanggal_awal"=>$this->lang->line('tanggal_awal'),
							//"tanggal_akhir"=>$this->lang->line('tanggal_akhir'),
							"nominal"=>"Anggaran"
							);

		$this->load->view('mata_anggaran/list_mapping', $data);
	}

	function mapping_detail (){
		$id= $this->input->post("id");
		$condition = array("m_periode_anggaran.id_periode"=>$id);
		$data['mapping_detail'] = $this->anggaran_model->get_detail_mapping($condition)->result_array();
		$data['action_delete'] = site_url()."anggaran/delete_mapping";
		$data['field'] = array(
							"id_periode"=>"ID Periode",
							"mata_anggaran"=>"Nama Anggaran",
							"nama_periode"=>"Nama Periode",
							"tanggal_awal"=>"Tgl Awal Periode",
							"tanggal_akhir"=>" Tgl Akhir Periode",
							"nama_akun" => "Akun",
							"nominal"=>"Nominal"
							);

		$this->load->view('mata_anggaran/mapping_detail', $data);
		
	}
	function realisasi(){
		//$data['realisasi'] = $this->anggaran_model->get_aktif_realisai();
		$data['realanggaran']= $this->db->query("SELECT 'Januari' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama,sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit FROM m_mapping_anggaran 
												INNER JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='01'	
												GROUP BY akun.id							
												UNION
												SELECT 'Februari' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama,sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='02'	
												GROUP BY akun.id								
												UNION
												SELECT 'Maret' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='03'
												GROUP BY akun.id
												UNION
												SELECT 'April' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='04'
												GROUP BY akun.id
												UNION
												SELECT 'Mei' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='05'
												GROUP BY akun.id
												UNION
												SELECT 'Juni' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='06'
												GROUP BY akun.id
												UNION
												SELECT 'Juli' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='07'
												GROUP BY akun.id
												UNION
												SELECT 'Agustus' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='08'
												GROUP BY akun.id
												UNION
												SELECT 'September' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='09'
												GROUP BY akun.id
												UNION
												SELECT 'Oktober' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='10'
												GROUP BY akun.id
												UNION
												SELECT 'November' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='11'
												GROUP BY akun.id
												UNION
												SELECT 'Desember' as grouping, 		
												m_mapping_anggaran.id_mapping,		
												m_mapping_anggaran.id_periode, m_mapping_anggaran.id_akun, sum(m_mapping_anggaran.nominal) as nominal, akun.kode, akun.nama, sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) as debit, sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) as kredit 
												FROM m_mapping_anggaran 
												LEFT JOIN akun ON m_mapping_anggaran.id_akun = akun.id
												LEFT JOIN jurnal_detail ON  jurnal_detail.akun_id = akun.id 
												WHERE id_periode='12'
												GROUP BY akun.id
												")->result_array();
		$dataL= array();
		foreach( $data['realanggaran'] as  $lap) {
			$dataL[$lap['grouping']] [$lap['nama']] =array ('nominal' => $lap['nominal'], 'debit'=> $lap['debit'], 'kredit' => $lap['kredit'] );
		}
		$data['output']=$dataL;
		$data['field'] = array(
							"nama_akun" => $this->lang->line('akun'),
							"nominal"=>$this->lang->line('anggaran'),
							"realisasi"=>'Realisasi',
							);
		//$data['bulan']=$this->customlib->get_month_name($realanggaran['id_periode']);
		$data['main_content'] = 'mata_anggaran/mapping_detail_realisasi';
		$this->load->view('template/template_xpanel', $data);
	

		//echo '<pre>';
		//var_dump($data);
	}
	function delete($option=""){
		$delete = $this->db->query("DELETE FROM m_mata_anggaran WHERE id_mata_anggaran ='".$option."'");
		if($delete){
			$respon = array("message"=>"Hapus data berhasil","data"=>"","error"=>0);
		}else{
			$respon = array("message"=>"Hapus data gagal","data"=>$this->db->error(),"error"=>0);
		}

		echo json_encode($respon);
		

	}
	function delete_periode($option=""){
		$this->db->query("DELETE FROM m_periode_anggaran WHERE id_periode ='".$option."'");

		redirect("anggaran/setting_periode");

	}
	function delete_mapping($option=""){
		$delete = $this->db->query("DELETE FROM m_mapping_anggaran WHERE id_mapping ='".$option."'");

		if($delete){
			$respon = array("message"=>"Hapus data berhasil","data"=>"","error"=>0);
		}else{
			$respon = array("message"=>"Hapus data gagal","data"=>$this->db->error(),"error"=>0);
		}

		echo json_encode($respon);

	}

}