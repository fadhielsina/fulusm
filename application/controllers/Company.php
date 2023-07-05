<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function show_company()
	{
		$data['title'] = 'Profil Perusahaan';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['company'] = [1, 1];
		if ($data['user']['role_id'] == 2) {
			$data['company'] = $this->db->get_where('perusahaan_peminjam', ['peminjam_id' => $data['user']['id']])->row_array();
		} else {
			$data['company'] = $this->db->get_where('perusahaan_pendana', ['pendana_id' => $data['user']['id']])->row_array();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/top_bar', $data);
		$this->load->view('user/company', $data);
		$this->load->view('templates/footer');
	}

	public function edit()
	{
		$data['title'] = 'Ubah Profil Perusahaan';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['company'] = [1, 1];
		if ($data['user']['role_id'] == 2) {

			$data['company'] = $this->db->get_where('perusahaan_peminjam', ['peminjam_id' => $data['user']['id']])->row_array();
		} else {
			$data['company'] = $this->db->get_where('perusahaan_pendana', ['pendana_id' => $data['user']['id']])->row_array();
		}

		$this->form_validation->set_rules('type', 'Company Type.', 'required');
		$this->form_validation->set_rules('perusahaan', 'Company Name.', 'required');
		$this->form_validation->set_rules('kategoribisnis', 'Business Category.', 'required');
		$this->form_validation->set_rules('tipebisnis', 'Business Type.', 'required');
		$this->form_validation->set_rules('deskripsi', 'Office Status.', 'required');
		$this->form_validation->set_rules('status_kantor', 'Description.', 'required');
		$this->form_validation->set_rules('jumlah_karyawan', 'Number of Employee.', 'required|callback_phone');
		$this->form_validation->set_rules('tahun_berdiri', 'Founded Year.', 'required|callback_phone');
		$this->form_validation->set_rules('provinsi', 'Province.', 'required');
		$this->form_validation->set_rules('kota', 'City/Regency.', 'required');
		$this->form_validation->set_rules('kecamatan', 'Distric.', 'required');
		$this->form_validation->set_rules('tlpPerusahaan', 'Company Phone Number.', 'required|callback_phone');
		$this->form_validation->set_rules('alamatWeb', 'Company Website.', 'required');
		if ($this->form_validation->run() == false) {
			$data['provinces'] = $this->db->get('provinces')->result_array();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/top_bar', $data);
			$this->load->view('user/companyedit', $data);
			$this->load->view('templates/footer');
		} else {

			$company = [
				"tipe_perusahaan" => $this->input->post('type'),
				"nama_perusahaan" => $this->input->post('perusahaan'),
				"kategori_bisnis" => $this->input->post('kategoribisnis'),
				"tipe_bisnis" => $this->input->post('tipebisnis'),
				"deskripsi_perusahaan" => $this->input->post('deskripsi'),
				"status_kantor" => $this->input->post('status_kantor'),
				"jumlah_karyawan" => $this->input->post('jumlah_karyawan'),
				"tahun_berdiri" => $this->input->post('tahun_berdiri'),
				"provinsi" => $this->input->post('provinsi'),
				"kota" => $this->input->post('kota'),
				"kecamatan" => $this->input->post('kecamatan'),
				"no_tlp" => $this->input->post('tlpPerusahaan'),
				"alamat_website" => $this->input->post('alamatWeb')
			];

			$this->db->where('id', $data['company']['id']);
			$this->db->update('perusahaan_penerbit', $company);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Edit Company Complete! 
				</div>');
			redirect('company/show_company');
		}
	}


	public function phone($str)
	{
		if (!preg_match("/^[+]*[[0-9]{1,4}[-0-9]*$/", $str)) {
			$this->form_validation->set_message('phone', 'The {field} is not a Valid Phone Number');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
