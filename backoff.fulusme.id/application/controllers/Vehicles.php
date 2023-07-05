<?php

class Vehicles extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('vehicles_model');		
	}
	
	function index()
	{
		$data['title'] = "Display Kendaraan";
		$data['main_content'] = 'vehicles/display';
		$data['vehicles_data'] = $this->vehicles_model->get_all_data();
		$this->load->view('layout/template', $data);
	}

	function add()
	{
		$data['title'] = "Tambah Kendaraan";
		$data['main_content'] = 'vehicles/form';
		$data['act'] = 'add';
		$data['form_act'] = 'insert';
		$data['vehicles_data'] = FALSE;
		$this->load->view('layout/template', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = "Lihat Klien";
		$data['main_content'] = 'vehicles/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$data['client_data'] = $this->vehicles_model->get_data_by_id($id);
		$this->load->view('layout/template', $data);
	}	

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = "Edit Klien";
		$data['main_content'] = 'vehicles/form';
		$data['act'] = 'edit';
		$data['form_act'] = 'update/'.$id;
		$data['vehicles_data'] = $this->vehicles_model->get_data_by_id($id);
		$this->load->view('layout/template', $data);
	}
	
	function popup()
	{
		$data['client_data'] = $this->vehicles_model->get_all_data();
		$this->load->view('vehicles/popup', $data);
	}

	function insert()
	{
		if (!$this->_vehicles_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->add();
		}
		else
		{
			$this->vehicles_model->fill_data();
		
			//Insert Data
			if($this->vehicles_model->insert_data()) 
			{
				$this->session->set_userdata('SUCCESSMSG', 'Merk Kendaraan baru berhasil ditambahkan ;)');
				redirect('vehicles');
			}			
		}
	}

	function update()
	{
		$id = $this->uri->segment(3);
		if (!$this->_klien_validation())
		{
			$this->session->set_userdata('ERRMSG_ARR', validation_errors());
			$this->edit();
		}
		else
		{
			$this->klien_model->fill_data();
			//Cek Akun
			if(!$this->klien_model->check_name($id))
			{
				$this->session->set_userdata('ERRMSG_ARR', 'Nama Klien telah digunakan');
				$this->edit();
			}
			//Update Data
			elseif($this->klien_model->update_data($id))
			{
				$this->session->set_userdata('SUCCESSMSG', 'Update Klien sukses ;)');
				redirect('klien');
			}
		}
	}

	function delete()
	{
		$id = $this->input->post('id');
		$klien_data = $this->klien_model->get_data_by_id($id);
		if($this->_check_project_exist($id))
		{
			$msg = 'E#Klien '.$klien_data['nama'].' tidak dapat dihapus karena telah digunakan pada proyek.';
		}
		else
		{
			if($this->klien_model->delete_data($id))
			{
				$msg = 'S#Klien '.$klien_data['memberFullName'].' telah dihapus.';
			}
			else
			{
				$msg .= 'E#Terjadi kesalahan dalam menghapus data klien '.$klien_data['memberFullName'].'. Harap coba lagi.';
			}
		}
		echo $msg;
	}
	
	function _check_project_exist($id)
	{
		$this->load->model('proyek_model');
		$this->proyek_model->set_klien_id($id);
		$proyek_data = $this->proyek_model->get_all_data();
		if ($proyek_data)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _vehicles_validation()
	{	
		$this->form_validation->set_rules('merk', 'Nama', 'trim|required');	
	
		return $this->form_validation->run();
	}
 function get_autocomplete(){
    if (isset($_GET['term'])) {
        $result = $this->klien_model->earch_cus($_GET['term']);
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label'         => $row->trxFullName,
                    'namafull'   => $row->trxFullName,
             );
                echo json_encode($arr_result);
        }
    }
}

	function GenCusNumber($div)
		{
		$trxid = mysql_fetch_array(mysql_query('SELECT * from as_members where is_new=1 order by memberID desc limit 1;'));
		$trxdate = date('Y-m-d');
		$memberid = $trxid['productBarcode'];
		if($memberid)
		{
			$memberid_count = substr($memberid, 1, 4);
			$memberid_new_count=$memberid_count+1;
			$memberid_new_count2 = sprintf("%04d", $memberid_new_count);
			$kode=$div.$memberid_new_count2;
		}
		else 
		{
			$kode=$div."0001";
		}
		return $kode;
		}
}
/* End of file klien.php */
/* Location: ./application/CI_Controllers/klien.php */
