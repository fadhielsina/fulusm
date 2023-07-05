<?php
class Transaksi extends CI_Controller
{

	private $db_fulus;

	function __construct()
	{
		parent::__construct();;
		$this->load->library('auth');
		if (($this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'update') || $this->uri->segment(3) !== $this->session->userdata('SESS_USER_ID')) {
			$this->auth->check_user_authentification(1);
		}
		$this->load->helper(array('url', 'form'));
		$this->load->model('model_master');
		$this->load->model('trx_model');
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

	function GenProNumber()
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
		$kode = "PLNS-" . date('d') . "-" . $invno;
		return $kode;
	}

	function pendapatan()
	{
		$trxid = mysql_fetch_array(mysql_query('SELECT * from jurnal order by id desc limit 1;'));
		$trxdate = date('Y-m-d');
		$invoiceID = $trxid['no'];
		$d = date("my", strtotime($trxdate));
		$tglfktr = date('my');
		$invoiceIDfil = substr($invoiceID, 6, 8);
		if ($invoiceIDfil == "") {
			$trxDate = date('my');
			$trx = 1;
			$invoice = sprintf("%04d", $trx);
			$invno = $trxDate . $invoice;
		} else {
			$trxDate = date('my');
			$trxd = substr($invoiceIDfil, 0, 4);
			if ($trxDate == $trxd) {
				$invno = $invoiceIDfil + 1;
				$invno = sprintf("%08d", $invno);
			} else {
				$trxDate = date('my');
				$trx = 1;
				$invoice = sprintf("%04d", $trx);
				$invno = $trxDate . $invoice;
			}
		}

		$invno = "JU/" . date('m') . "-" . $invno;
		$data['trxid'] = $invno;
		$data['trx'] = $this->model_master->tampil_trxpj_post_by_date()->result_object();
		$data['title'] = "Data Pendapatan";
		$data['main_content'] = 'transaksi/pendapatan';
		$this->load->view('layout/template', $data);
	}

	function save_pendapatan_outlet()
	{
		$totalpen = $this->input->get('totalpen');
		$tgl = date('Y-m-d');
		$noju = $this->input->get('noju');
		$trxDate = $this->input->get('trxDate');

		$object = array(
			'no' => $noju,
			'tgl' => $tgl,
			'f_id' => 1,
			'keterangan' => 'Pendapatan Outlet'
		);
		$this->db->insert('jurnal', $object);
		$jurid = mysql_fetch_array(mysql_query('SELECT * from jurnal order by id desc limit 1;'));
		$akunkas = mysql_fetch_array(mysql_query('SELECT * from akun where id=2;'));
		$akunpen = mysql_fetch_array(mysql_query('SELECT * from akun where id=18;'));
		$salkas = $akunkas['saldo'];
		$saldo1 = $salkas + $totalpen;
		$salpen = $akunpen['saldo'];
		$saldo2 = $salpen - $totalpen;
		$idjur = $jurid['id'];
		$object_deb = array(
			'jurnal_id' => $idjur,
			'akun_id' => 2,
			'item' => 1,
			'debit_kredit' => 1,
			'nilai' => $totalpen,
		);
		$this->db->insert('jurnal_detail', $object_deb);

		$object = array(
			'saldo' => $saldo1
		);
		$this->db->where('id', 2);
		$this->db->update('akun', $object);

		$object_kre = array(
			'jurnal_id' => $idjur,
			'akun_id' => 18,
			'item' => 2,
			'debit_kredit' => 0,
			'nilai' => $totalpen,
		);
		$this->db->insert('jurnal_detail', $object_kre);

		$object = array(
			'saldo' => $saldo2
		);
		$this->db->where('id', 18);
		$this->db->update('akun', $object);

		$object_up = array(
			'isPosting_status' => 1
		);
		$this->db->where('trxDate', $trxDate);
		$this->db->update('as_sales_transactions', $object_up);

		redirect("transaksi/pendapatan");
	}

	function bayar_angsuran()
	{
		$data['title'] = "Transaksi Pengembalian Dana";
		$data['main_content'] = 'transaksi/bayar_angsuran';
		$data['project'] = $this->db->get_where('trx_jatuh_tempo', ['status !=' => 1])->result();
		$this->load->view('template/template_xpanel', $data);
	}

	function form_bayar($id)
	{
		$this->form_validation->set_rules('nominal', 'Nominal Pembayaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Detail Pengembalian Dana";
			$data['main_content'] = 'transaksi/form_bayar';
			$data['pengembalian'] = $this->db->get_where('trx_pengembalian_dana', ['id_project' => $id])->result();
			$data['project'] = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $id])->row();
			$data['dana_pengembalian'] = $this->pengembalian($id);
			$statpro = $this->db->get_where('history_project', ['id' => $id])->row();
			if ($statpro) {
				$data['status_project'] = $statpro->status;
			} else {
				$data['status_project'] = $this->db_fulus->get_where('project_retail', ['id_project' => $id])->row()->status;
			}
			$data['dana_terkumpul'] = $this->db->get_where('trx_project', ['id_project' => $id])->row()->dana_kembali;
			$data['nisbah'] = $this->db->select('dana_nisbah, tgl_nisbah')->from('trx_pengembalian_dana')->where('id_project', $id)->get()->result();
			$data['readonly'] = '';
			if ($data['dana_pengembalian']->nominal >= $data['project']->jumlah_pinjaman) {
				$this->db->where('id_project', $id);
				$this->db->update('trx_jatuh_tempo', ['status' => 2]);
				$data['readonly'] = "readonly";
			}
			$this->load->view('template/template_xpanel', $data);
		} else {
			$id_project = $this->input->post('id_project');
			$id_peminjam = $this->input->post('id_peminjam');
			$nominal = intval(str_replace(',', '', $this->input->post('nominal')));
			$tgl_tempo = strtotime($this->input->post('tgl_tempo'));
			$danaTerkumpul = $this->db->get_where('trx_project', ['id_project' => $id_project])->row()->dana_kembali;
			$tambahDana = (int) $nominal + (int) $danaTerkumpul;
			$this->db->where('id_project', $id_project);
			$this->db->update('trx_project', ['dana_kembali' => $tambahDana]);
			$this->jurnal_pengembalian($id_project, $nominal);
			$data = [
				'id_project' => $id_project,
				'id_peminjam' => $id_peminjam,
				'nominal' => $nominal,
				'tgl_bayar' => time()
			];
			$this->db->insert('trx_pengembalian_dana', $data);
			$data_up = ['tgl_tempo' => date('Y-m-d', strtotime('+1 month', $tgl_tempo))];
			$this->db->where('id_project', $id_project);
			$this->db->update('trx_jatuh_tempo', $data_up);
			redirect('transaksi/bayar_angsuran');
		}
	}

	function jurnal_pengembalian($id_project, $nominal)
	{
		$project = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();
		$tipe = $project->tipe;
		$invoice = $this->GenProNumber();
		$proj = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $id_project])->row();
		$jenis_angsuran = $proj->tipe_angsuran;

		if ($jenis_angsuran == 'Di Akhir') {
			$total = $proj->jumlah_pinjaman;
			$nominal = $proj->lender;
		} else {
			$total = ((int) $proj->jumlah_pinjaman /  $proj->angsuran) - ($proj->lender / $proj->angsuran);
			$nominal = $proj->lender / $proj->angsuran;
		}
		$this->jurnal_pelunasan($id_project, $project, $tipe, $invoice, $total);
		// $this->jurnal_bagi_hasil($project, $tipe, $proj, $nominal);
	}

	function jurnal_pelunasan($id_project, $project, $tipe, $invoice, $total)
	{
		$akun_d = 5;
		$data_trx = [
			'no_trx_kas' => $invoice,
			'tgl_catat' => date('Y-m-d'),
			'jumlah' => $total,
			'keterangan' => "Pelunasan $project->nama_project",
			'akun' => "Pemasukan",
			'untuk_kas_id' => $akun_d,
			'jns_trans' => "KM",
			'dok' => $project->nama_project,
			'no_dok' => $id_project,
			'dari' => $project->nama_peminjam
		];
		$this->db->insert('tbl_trans_kas', $data_trx);

		$akun = 93;
		if ($tipe) {
			if ($tipe === 'Musyarakah') {
				$akun = 91;
			} elseif ($tipe === 'Mudharabah') {
				$akun = 90;
			}
		}

		if ($project) {
			$dataJurnal = [
				'no' =>  $this->GenJurNumber(),
				'tgl' => $project->tgl_app,
				'f_id' => 1,
				'invoice_no' => $invoice,
				'keterangan' => "Pengembalian Dana $project->nama_project",
				'waktu_post' => date("Y-m-d")
			];
			$this->db->insert('jurnal', $dataJurnal);
			$lastID = $this->db->insert_id();

			$saldo_akun_default_d = $this->db->select('saldo')->from('akun_saldo')->where('id', $akun_d)->get()->row()->saldo;
			$saldo_akun_default_k = $this->db->select('saldo')->from('akun_saldo')->where('id', $akun)->get()->row()->saldo;

			$dataJurnal_detail_debit = [
				'jurnal_id' => $lastID,
				'item' => 1,
				'akun_id' => $akun_d,
				'debit_kredit' => 1,
				'nilai' => $total
			];

			$dataJurnal_detail_kredit = [
				'jurnal_id' => $lastID,
				'item' => 2,
				'akun_id' => $akun,
				'debit_kredit' => 0,
				'nilai' => $total
			];
			$this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
			$this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);
			$saldo_new_d = $saldo_akun_default_d + $total;
			$this->db->where('id', $akun_d);
			$this->db->update('akun_saldo', ['saldo' => $saldo_new_d]);
			$saldo_new_k = $saldo_akun_default_k + $total;
			$this->db->where('id', $akun);
			$this->db->update('akun_saldo', ['saldo' => $saldo_new_k]);
		}
	}

	function jurnal_bagi_hasil($id_project, $project, $tipe, $proj, $nominal)
	{
		$idPro = $proj->id_project;
		$project = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $idPro])->row();
		$pro = $this->db->get_where('trx_project', ['id_project' => $idPro])->row();
		$tipe = $pro->tipe;
		$invoice = $this->GenProNumber();

		if ($tipe !== 'Murabahah') {
			$data_trx = [
				'no_trx_kas' => $invoice,
				'tgl_catat' => date('Y-m-d'),
				'jumlah' => $nominal,
				'keterangan' => "Pelunasan Bagi Hasil $project->nama_project",
				'akun' => "Pemasukan",
				'untuk_kas_id' => 5,
				'jns_trans' => "KM",
				'dok' => $project->nama_project,
				'no_dok' => $id_project,
				'dari' => $project->peminjam
			];
			$this->db->insert('tbl_trans_kas', $data_trx);
		}

		$akun = 88;
		$akun2 = 89;
		if ($tipe) {
			if ($tipe === 'Musyarakah') {
				$akun = 87;
				$akun2 = 5;
			} elseif ($tipe === 'Mudharabah') {
				$akun = 86;
				$akun2 = 5;
			}
		}

		$saldo_akun_default_d = $this->db->select('saldo')->from('akun_saldo')->where('id', $akun2)->get()->row()->saldo;
		$saldo_akun_default_k = $this->db->select('saldo')->from('akun_saldo')->where('id', $akun)->get()->row()->saldo;

		if ($project) {
			$dataJurnal = [
				'no' =>  $this->GenJurNumber(),
				'tgl' => date('Y-m-d'),
				'f_id' => 1,
				'invoice_no' => $invoice,
				'keterangan' => "Pengembalian Dana $project->nama_project",
				'waktu_post' => date("Y-m-d")
			];
			$this->db->insert('jurnal', $dataJurnal);
			$lastID = $this->db->insert_id();

			$dataJurnal_detail_debit = [
				'jurnal_id' => $lastID,
				'item' => 1,
				'akun_id' => $akun2,
				'debit_kredit' => 1,
				'nilai' => $nominal
			];

			$dataJurnal_detail_kredit = [
				'jurnal_id' => $lastID,
				'item' => 2,
				'akun_id' => $akun,
				'debit_kredit' => 0,
				'nilai' => $nominal
			];
			$this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
			$this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);

			$saldo_new_d = $saldo_akun_default_d + $nominal;
			$this->db->where('id', $akun2);
			$this->db->update('akun_saldo', ['saldo' => $saldo_new_d]);

			$saldo_new_k = $saldo_akun_default_k - $nominal;
			$this->db->where('id', $akun);
			$this->db->update('akun_saldo', ['saldo' => $saldo_new_k]);
		}
	}

	function pengembalian($id)
	{
		$this->db->select_sum('nominal');
		return $this->db->get_where('trx_pengembalian_dana', ['id_project' => $id])->row();
	}

	function nisbah_payment()
	{
		$idPro = $this->input->post('idPro');
		$nisbah = intval(str_replace(',', '', $this->input->post('nisbah')));
		$this->jurnal_nisbah($idPro, $nisbah);
		$this->db->where('id_project', $idPro);
		$this->db->update('trx_jatuh_tempo', ['status' => 2]);
		// $data = [
		// 	'status' => 5
		// ];
		// $this->db_fulus->where('id', $idPro);
		// $this->db_fulus->update('project', $data);
		// $this->db->where('id', $idPro);
		// $this->db->update('history_project', $data);
		// $this->db->where('id_project', $idPro);
		// $this->db->update('trx_project', $data);
		$data = [
			'dana_nisbah' => $nisbah,
			'tgl_nisbah' => time()
		];
		$this->db->where('id_project', $idPro);
		$this->db->update('trx_pengembalian_dana', $data);
		$this->db->where('id_project', $idPro);
		$this->db->update('trx_jatuh_tempo', ['status' => 1]);
		$this->db->where('id_project', $idPro);
		$this->db->update('trx_project', ['dana_nisbah' => $nisbah]);
		redirect('transaksi/bayar_angsuran');
	}

	function jurnal_nisbah($id_project, $nominal)
	{
		$project = $this->db->get_where('trx_project', ['id_project' => $id_project])->row();
		$tipe = $project->tipe;
		$proj = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $id_project])->row();
		$jenis_angsuran = $proj->tipe_angsuran;
		if ($jenis_angsuran == 'Di Akhir') {
			$total = $proj->jumlah_pinjaman;
			$nominal = $proj->lender;
		} else {
			$total = ((int) $proj->jumlah_pinjaman /  $proj->angsuran) - ($proj->lender / $proj->angsuran);
			$nominal = $proj->lender / $proj->angsuran;
		}
		$this->jurnal_bagi_hasil($id_project, $project, $tipe, $proj, $nominal);
	}
}
