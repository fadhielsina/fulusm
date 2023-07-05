<?php

class Scoring extends CI_Controller
{

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
			$this->auth->check_user_authentification(1);
		}
		$this->load->library('form_validation');
		$this->load->model('scoring_model');
	}

	function index()
	{
		$data['title'] = "Tipe Scoring";
		$data['main_content'] = 'scoring/index';
		$data['cek'] = 'N';
		$data['type_scoring'] = $this->scoring_model->getType();
		$this->load->view('template/template_xpanel', $data);
	}

	function addType()
	{
		$this->form_validation->set_rules('nama_tipe', 'Nama Tipe', 'required|trim');
		$this->form_validation->set_rules('tgl_berlaku', 'tgl_berlaku', 'required|trim');

		if ($this->form_validation->run() == false) {

			$data['title'] = "Tambah Tipe";
			$data['main_content'] = 'scoring/form_scoring';
			$data['act'] = 'add';
			$data['form_act'] = 'insert';
			$data['user_data'] = FALSE;
			$data['get_tipe'] = $this->db->get('scr_type')->result_array();
			$this->load->view('template/template_xpanel', $data);
		} else {
			$this->scoring_model->addType();
		}
	}

	function addDetailType()
	{
		$this->form_validation->set_rules('nama_detail_tipe[]', 'Nama Detail Tipe', 'required|trim');
		$this->form_validation->set_rules('tipe_id', 'Nama Tipe', 'required|trim');
		$this->form_validation->set_rules('bobot[]', 'Bobot', 'required|trim');

		if ($this->form_validation->run() == false) {

			$data['title'] = "Tambah Detail Tipe";
			$data['main_content'] = 'scoring/form_scoring';
			$data['act'] = 'add';
			$data['form_act'] = 'insert';
			$data['user_data'] = FALSE;
			$data['get_tipe'] = $this->db->get('scr_type')->result_array();
			$this->load->view('template/template_xpanel', $data);
		} else {
			$this->scoring_model->addDetailType();
		}
	}

	function addSubDetail()
	{
		$this->form_validation->set_rules('nama_sub_detail[]', 'Nama Sub Detail Tipe', 'required|trim');
		$this->form_validation->set_rules('detail_tipe_id', 'Nama Detail Tipe', 'required|trim');
		$this->form_validation->set_rules('bobot_persent[]', 'Bobot Persent', 'required|trim');

		if ($this->form_validation->run() == false) {

			$data['title'] = "Tambah Sub Detail Tipe";
			$data['main_content'] = 'scoring/form_scoring';
			$data['act'] = 'add';
			$data['form_act'] = 'insert';
			$data['user_data'] = FALSE;
			$data['get_tipe'] = $this->db->get('scr_type')->result_array();
			$this->load->view('template/template_xpanel', $data);
		} else {
			$this->scoring_model->addSubDetail();
		}
	}

	function addFaktor()
	{
		$this->form_validation->set_rules('sub_detail_tipe_id4', 'Nama Sub Detail Tipe', 'required|trim');
		$this->form_validation->set_rules('nama_faktor[]', 'Nama Detail Tipe', 'required|trim');
		$this->form_validation->set_rules('score[]', 'Bobot Score', 'required|trim');

		if ($this->form_validation->run() == false) {

			$data['title'] = "Tambah Sub Detail Tipe";
			$data['main_content'] = 'scoring/form_scoring';
			$data['act'] = 'add';
			$data['form_act'] = 'insert';
			$data['user_data'] = FALSE;
			$data['get_tipe'] = $this->db->get('scr_type')->result_array();
			$this->load->view('template/template_xpanel', $data);
		} else {
			$this->scoring_model->addFaktor();
		}
	}

	function detail_tipe($id)
	{
		$arr = [];
		$query = $this->db->get_where('scr_detail_tipe', ['tipe_id' => $id])->result();
		foreach ($query as $key) {
			array_push($arr, $key);
		}
		echo json_encode($arr);
	}

	function sub_detail($id)
	{
		$arr = [];
		$query = $this->db->get_where('scr_sub_detail_tipe', ['detail_tipe_id' => $id])->result();
		foreach ($query as $key) {
			array_push($arr, $key);
		}
		// echo $id;
		echo json_encode($arr);
	}
}
/* End of file user.php */
/* Location: ./application/CI_Controllers/user.php */
