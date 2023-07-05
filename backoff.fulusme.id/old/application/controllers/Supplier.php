<?php

class Supplier extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('klien_model');		
		$this->load->model('vendor_model');	
	}
	
	function index()
	{
		$data['title'] = "Display Supplier";
		$data['main_content'] = 'vendor/display';
		$data['client_data'] = $this->vendor_model->get_all_data();
		$this->load->view('template/template_xpanel', $data);
	}

	function add()
	{
		$data['title'] = "Tambah Suppler";
		$data['main_content'] = 'vendor/form';
		$data['act'] = 'add';
		$data['form_act'] = 'insert';
		$data['client_data'] = FALSE;
		$this->load->view('template/template_xpanel', $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$data['title'] = "Lihat vendor";
		$data['main_content'] = 'vendor/form';
		$data['act'] = 'view';
		$data['form_act'] = '';
		$data['client_data'] = $this->vendor_model->get_data_by_id($id);
		$this->load->view('template/template_xpanel', $data);
	}	

	function edit()
	{
		$id = $this->uri->segment(3);
		$data['title'] = "Edit vendor";
		$data['main_content'] = 'vendor/form_edit';
		$data['act'] = 'edit';
		$data['form_act'] = 'update/'.$id;
		$data['client_data'] = $this->vendor_model->get_data_by_id($id);
		$this->load->view('template/template_xpanel', $data);
	}
	
	function popup()
	{
		$data['client_data'] = $this->klien_model->get_all_data();
		$this->load->view('klien/popup', $data);
	}

	function insert()
	{
		$this->vendor_model->fill_data();
		$this->vendor_model->insert_data();
		$this->session->set_userdata('SUCCESSMSG', 'Vendor baru sukses ;)');
		redirect('supplier');			
	}

	function update()
	{
		$id = $this->uri->segment(3);
		$this->vendor_model->fill_data_up($id);
		$this->vendor_model->update_data($id);
		$this->session->set_userdata('SUCCESSMSG', 'Update Vendor sukses ;)');
		redirect('supplier');
	}

	function delete($id)
	{
		
			$this->db->where('supplierID', $id);
		$delete = $this->db->delete('as_suppliers');
		redirect('supplier');
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

	function _klien_validation()
	{	
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('npwp', 'NPWP', 'trim|numeric');		
		$this->form_validation->set_rules('npwp1', 'NPWP', 'trim|numeric');		
		$this->form_validation->set_rules('npwp2', 'NPWP', 'trim|numeric');		
		$this->form_validation->set_rules('npwp3', 'NPWP', 'trim|numeric');		
		$this->form_validation->set_rules('npwp4', 'NPWP', 'trim|numeric');		
		$this->form_validation->set_rules('npwp5', 'NPWP', 'trim|numeric');		
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('telpon', 'Telpon', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
	
		return $this->form_validation->run();
	}
 function get_autocomplete(){
    if (isset($_GET['term'])) {
        $result = $this->blog_model->search_blog($_GET['term']);
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label'         => $row->trxFullName,
                    'namafull'   => $row->trxFullNames
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
