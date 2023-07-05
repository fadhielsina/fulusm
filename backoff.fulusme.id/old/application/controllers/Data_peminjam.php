<?php

class Data_peminjam extends CI_Controller
{
	private $db_fulus;

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		$this->load->library('upload');
		$this->load->library('form_validation');
		$this->load->database();
		$this->db_fulus = $this->load->database('fulusme', TRUE);
		if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
			$this->auth->check_user_authentification(1);
		}
		$this->load->model('data_model');
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$data['title'] = "Display Penerbit";
		$data['main_content'] = 'user/list_customer';
		$data['link_detail'] = 'data_peminjam/detail/';
		$data['user_data'] = $this->data_model->get_all_data_peminjam();
		$this->load->view('template/template_xpanel', $data);
	}

	function detail($id)
	{
		$data['title'] = "Daftar Project";
		$data['main_content'] = 'user/detail_data_peminjam';
		$data['data_project'] = $this->data_model->get_data_project($id);
		$data['user_id'] = $id;
		$data['identitas'] = $this->data_model->get_identitas_peminjam($id);
		$this->load->view('template/template_xpanel', $data);
	}

	function edit_document($id)
	{
		$this->form_validation->set_rules('id_project', 'Id Project', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['title'] = "Form Edit";
			$data['main_content'] = 'user/edit_doc';
			$data['data_project'] = $this->data_model->get_detail_project($id);
			$data['update_doc'] = $this->db->get_where('history_project_document', ['project_id' => $id])->row();
			$this->load->view('template/template_xpanel', $data);
		} else {
			$this->data_model->edit_document();
			redirect('data_peminjam/project_detail/' . $id . '');
		}
	}

	function download_doc($doc = null)
	{
		$this->load->helper('download');
		if ($doc == null) {
			echo "User tidak upload document!";
			echo "<br>";
			echo " <input type='button' value='Go back!' onclick='history.back()'> ";
		} else {
			$download = force_download('../public_html/assets/img/profile/' . $doc . '', NULL);
			if ($download == null) {
				echo "File $doc tidak tersedia!";
				echo "<br>";
				echo " <input type='button' value='Go back!' onclick='history.back()'> ";
			}
		}
	}

	function download_akad($id)
	{
		$this->load->helper('download');
		$download = force_download('./assets/pdf/\Akad_peminjam' . $id . '.docx', NULL);
		if ($download == null) {
			echo "File Akad tidak ada!";
			echo "<br>";
			echo " <input type='button' value='Go back!' onclick='history.back()'> ";
		}
	}
}

/* End of file user.php */

/* Location: ./application/CI_Controllers/user.php */
