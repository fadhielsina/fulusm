<?php

class Data_pendana extends CI_Controller
{
	private $db_fulus;

	public function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
			$this->auth->check_user_authentification(1);
		}
		$this->load->model('data_model');
		$this->db_fulus = $this->load->database('fulusme', TRUE);
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

	function index()
	{
		$data['title'] = "Display Pemodal";
		$data['main_content'] = 'user/list_customer';
		$data['link_detail'] = 'data_pendana/detail/';
		$data['user_data'] = $this->data_model->get_all_data_pendana();
		$this->load->view('template/template_xpanel', $data);
	}

	function detail($id)
	{
		$data['title'] = "Daftar Project";
		$data['main_content'] = 'user/detail_data_pendana';
		$data['data_project'] = $this->data_model->get_data_project_pendana($id);
		$data['user_id'] = $id;
		$data['identitas'] = $this->data_model->get_identitas_pendana($id);
		$this->load->view('template/template_xpanel', $data);
	}

	function pendanaan()
	{
		$data['title'] = "Daftar Pendanaan";
		$data['main_content'] = 'project/pendanaan';
		$data['pendanaan_data'] = $this->data_model->get_all_pendanaan();
		$this->load->view('template/template_xpanel', $data);
	}

	function pendanaan_detail($id)
	{
		$data['title'] = "Detail Pendanaan Project";
		$data['main_content'] = 'project/detail_pendanaan_project';
		$data['project'] = $this->data_model->get_pendanaan_project($id);
		$this->load->view('template/template_xpanel', $data);
	}

	function bayar($id)
	{
		$project = $this->data_model->get_pendanaan_project($id);
		$trx_project = $this->db->get_where('trx_project', ['id_project' => $project->project_id])->row();
		$pendanaan = $this->data_model->get_pendanaan_project($project->id);
		$tipe = $trx_project->tipe;
		$mat = mt_rand();
		$invoice = "$mat-$project->project_id";
		$this->penjurnalan_pendanaan($pendanaan, $tipe, $invoice);

		$dataPendanaan = [
			'id_project' => $pendanaan->project_id,
			'id_pendana' => $pendanaan->pendana_id,
			'nominal' => $pendanaan->nominal,
			'create_ts' => date('Y-m-d h:i:s'),
			'no_invoice' => $invoice,
			'nomor_va' => $pendanaan->nomor_va,
			'status' => 1
		];

		$this->db->insert('trx_pendanaan', $dataPendanaan);
		$lastID = $this->db->insert_id();
		$query = $this->db->get_where('trx_hutang_payment', ['trx_id' => $lastID])->row();
		$dataTrx_hutang_payment = [
			'trx_id' => $lastID
		];

		if ($query) {
			$this->db->where('trx_id', $lastID);
			$this->db->update('trx_hutang_payment', $dataTrx_hutang_payment);
		} else {
			$this->db->insert('trx_hutang_payment', $dataTrx_hutang_payment);
		}

		$dataProject = [
			'status' => 1
		];

		$this->db_fulus->set($dataProject);
		$this->db_fulus->where('id', $pendanaan->id);
		$this->db_fulus->update('pendanaan');
		redirect('project/daftar');
	}

	function penjurnalan_pendanaan($project, $tipe, $invoice)
	{
		$akun = 46;
		if ($tipe) {
			if ($tipe === 'Musyarakah') {
				$akun = 45;
			} elseif ($tipe === 'Mudharabah') {
				$akun = 44;
			}
		}

		$data_trx = [
			'no_trx_kas' => $invoice,
			'tgl_catat' => date('Y-m-d'),
			'jumlah' => $project->nominal,
			'keterangan' => "Pendanaan Project $project->nama_project",
			'akun' => "Pemasukan",
			'jns_trans' => "KM",
			'dari' => $project->full_name,
			'kepada' => $project->name
		];
		$this->db->insert('tbl_trans_kas', $data_trx);

		if ($project) {
			$dataJurnal = [
				'no' =>  $this->GenJurNumber(),
				'tgl' => date("Y-m-d"),
				'f_id' => 1,
				'invoice_no' => $invoice,
				'keterangan' => "Pendanaan Project $project->nama_project",
				'waktu_post' => date("Y-m-d h:i:s")
			];
			$this->db->insert('jurnal', $dataJurnal);
			$lastID = $this->db->insert_id();

			$dataJurnal_detail_debit = [
				'jurnal_id' => $lastID,
				'item' => 1,
				'akun_id' => 42,
				'debit_kredit' => 1,
				'nilai' => $project->nominal
			];

			$dataJurnal_detail_kredit = [
				'jurnal_id' => $lastID,
				'item' => 1,
				'akun_id' => $akun,
				'debit_kredit' => 0,
				'nilai' => $project->nominal
			];

			$this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
			$this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);

			$data_debts = [
				'invoiceID' => $invoice,
				'status' => "1",
				'createdDate' => date('Y-m-d h:i:s'),
				'createdUserID' => $this->session->userdata('SESS_USER_ID')
			];
			$this->db->insert('as_debts', $data_debts);
			// $IdLast = $this->db->insert_id();
		}
	}

	function kembalikan($id)
	{
		$data = ['status' => 3];
		$this->db_fulus->set($data);
		$this->db_fulus->where('id', $id);
		$this->db_fulus->update('pendanaan');
		$this->db->delete('trx_pendanaan', ['no_pembayaran' => $id]);
		redirect('data_pendana/project_detail/' . $id);
	}
}

/* End of file user.php */

/* Location: ./application/CI_Controllers/user.php */
