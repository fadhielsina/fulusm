<?php

class Laporan_keuangan extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->library('auth');
		$this->auth->check_user_authentification();
		$this->load->model('jurnal_model');	
		$this->load->model('akun_model');
		$this->load->model('pajak_model');
		$this->load->model('laporankeuangan_model');
		$this->load->helper('indodate');
		$this->load->helper('finance');
		$this->load->library('fpdf');
		$this->load->add_package_path( APPPATH . 'third_party/fpdf');
        $this->load->library('pdf');
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	}
	
	function index()
	{
		$data['title'] = "Laporan Keuangan";
		$data['main_content'] = 'laporan_keuangan/form';
		$data['months'] = bulan_list(1);
		$data['years'] = tahun_list();
		$this->load->view('layout/template', $data);
	}	
	
	
	function lap_penjualan()
	{
		
		 $q_data = $this->db->query("SELECT a.*,b.*,c.*,d.* FROM as_sales_transactions a left join jurnal b  on a.invoiceID=b.invoice_no left join jurnal_detail c on b.id=c.jurnal_id left join klien d on a.memberID=d.id  WHERE c.akun_id in ('11101','11500','11500','112001','112002','112010') ");
        $j_data = $q_data->num_rows()();
        $a_data = $q_data->row();
		$data['main_content'] = 'laporan_keuangan/laporan_penjualan';
		$data['datapen'] = $a_data;
		$this->load->view('layout/template', $data);
		
	}
	
	function lap_pendapatan()
	{
		$lokasi    = $this->input->post('lokasi');
		if($lokasi)
		{
			$id= $this->input->post('lokasi');
		}
		else
		{
			$id= $this->session->userdata('IDENTITY_ID');
		}
		
		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');
		 $q_data_iden = $this->db->query("SELECT * FROM as_identity WHERE identityID = '".$id."' ");
         $a_data_iden = $q_data_iden->row();
		 $akunsaldo=$a_data_iden->id_akun_kas;
		  $q_data_saldo = $this->db->query("SELECT * FROM akun WHERE id = '".$akunsaldo."' ");
         $a_data_saldo = $q_data_saldo->row();
		$data['address'] =$a_data_iden->identityAddress;
		$data['nameper'] =$a_data_iden->identityName;
		if($a_data_saldo)
		{
		$data['saldo'] =$a_data_saldo->saldo;
		}
		else
		{
			$data['saldo'] =0;
		}
		$data['lokasi_data'] = $this->laporankeuangan_model->get_data_lokasi();
		$data['datapen'] = $this->laporankeuangan_model->get_laporan_pendapatan($id,$tanggal1,$tanggal2);
		
		 if ($this->input->post('submit') == "filter") {
		$data['main_content'] = 'laporan_keuangan/laporan_pendapatan';
		$this->load->view('layout/template', $data);
		 }
		 
		 else if ($this->input->post('submit') == "pdf") {
		 $this->load->view('laporan_keuangan/laporan_pendapatan_print', $data);
            $html = $this->output->get_output();
            $this->load->library('dompdf_gen');
            $this->dompdf->set_paper("A4", "landscape");
            $this->dompdf->load_html($html);
            
            $this->dompdf->render();
            $this->dompdf->stream($id, array(
                'Attachment' => 0
            ));
			
		 }
		 
		 else
		 {
			 $data['main_content'] = 'laporan_keuangan/laporan_pendapatan';
		$this->load->view('layout/template', $data);
		 }
		
	}
	
	
	function lap_pendapatan_bank()
	{
		$lokasi    = $this->input->post('lokasi');
		if($lokasi)
		{
			$id= $this->input->post('lokasi');
		}
		else
		{
			$id= $this->session->userdata('IDENTITY_ID');
		}
		$jns_byr    = $this->input->post('jns_byr');
		$tanggal1    = $this->input->post('tanggal1');
		$tanggal2    = $this->input->post('tanggal2');

		 $q_data_iden = $this->db->query("SELECT * FROM as_identity WHERE identityID = '".$id."' ");
         $a_data_iden = $q_data_iden->row();
		 		if($a_data_iden)
		{
		$data['address'] =$a_data_iden->identityAddress;
		$data['nameper'] =$a_data_iden->identityName;
		}
		else
		{
		$data['address'] ="Kantor Pasat";
		$data['nameper'] ="Semua Cabang";
		}
		$data['lokasi_data'] = $this->laporankeuangan_model->get_data_lokasi();
		$data['datapen'] = $this->laporankeuangan_model->get_laporan_pendapatan_bank($id,$tanggal1,$tanggal2,$jns_byr);
		
		 if ($this->input->post('submit') == "filter") {
		$data['main_content'] = 'laporan_keuangan/laporan_pendapatan_bank';
		$this->load->view('layout/template', $data);
		 }
		  else if ($this->input->post('submit') == "excel") {
			  $today=date('Y-m-d');
		 $data['title'] = "Laporan_Pendapatan_".$today;
		$this->load->view('laporan_keuangan/laporan_pendapatan_bank_excel', $data);
		 }
		 else if ($this->input->post('submit') == "pdf") {
		 $this->load->view('laporan_keuangan/laporan_pendapatan_bank_print', $data);
            $html = $this->output->get_output();
            $this->load->library('dompdf_gen');
            $this->dompdf->set_paper("A4", "landscape");
            $this->dompdf->load_html($html);
            
            $this->dompdf->render();
            $this->dompdf->stream($id, array(
                'Attachment' => 0
            ));
			
		 }
		 
		 else
		 {
			 $data['main_content'] = 'laporan_keuangan/laporan_pendapatan_bank';
		$this->load->view('layout/template', $data);
		 }
		
	}
	
	
	function laporan_laba_rugi()
	{
		$data['wajib_pajak_data'] = $this->pajak_model->get_data();
		$bulan = $this->uri->segment(3);
		$data['bulan'] = ($bulan) ? nama_bulan($bulan) : FALSE;
		$data['tahun'] = $this->uri->segment(4);
		$data['laba_rugi_data'] = $this->_get_laba_rugi_data($bulan,$data['tahun']);
		$this->load->view('laporan_keuangan/laba_rugi', $data);
	}

/*		
	function laporan_neraca_saldo_sebelum_penyesuaian()
	{
		$data['title'] = "LAPORAN NERACA SALDO SEBELUM PENYESUAIAN";
		$data['wajib_pajak_data'] = $this->pajak_model->get_data();
		$bulan = $this->uri->segment(3);
		$data['bulan'] = ($bulan) ? nama_bulan($bulan) : FALSE;
		$data['tahun'] = $this->uri->segment(4);
		$data['neraca_data'] = $this->_get_neraca_data($bulan,$data['tahun'],1);
		$this->load->view('laporan_keuangan/neraca', $data);
	}
	
	function laporan_neraca_saldo_setelah_penyesuaian()
	{
		$data['title'] = "LAPORAN NERACA SALDO SETELAH PENYESUAIAN";
		$data['wajib_pajak_data'] = $this->pajak_model->get_data();	
		$bulan = $this->uri->segment(3);
		$data['bulan'] = ($bulan) ? nama_bulan($bulan) : FALSE;
		$data['tahun'] = $this->uri->segment(4);
		$data['neraca_data'] = $this->_get_neraca_data($bulan,$data['tahun'],array(1,2));
		$this->load->view('laporan_keuangan/neraca', $data);
	}
	
	function laporan_neraca_saldo_setelah_penutupan()
*/
	function laporan_neraca()
	{
		$data['title'] = "LAPORAN NERACA";
		$data['wajib_pajak_data'] = $this->pajak_model->get_data();	
		$bulan = $this->uri->segment(3);
		$data['bulan'] = ($bulan) ? nama_bulan($bulan) : FALSE;
		$data['tahun'] = $this->uri->segment(4);
		$data['neraca_data'] = $this->_get_neraca_data($bulan,$data['tahun']);
		$this->load->view('laporan_keuangan/neraca', $data);
	}
	
	function _get_neraca_data($bulan, $tahun)
	{
//		if($f) $this->jurnal_model->set_f($f);
		$this->jurnal_model->set_month_year($bulan, $tahun, '<=');
		$this->jurnal_model->set_account_group_id(array(1,2,3));
		$journal_data = $this->jurnal_model->get_data();

		$this->akun_model->set_account_group_id(array(1,2,3));
		$akun = $this->akun_model->get_all_data();

		if($akun)
		{
			foreach ($akun as $row)
			{
				$result[$row->kelompok_akun_id][$row->id] = array('nama' => $row->nama, 'saldo' => $row->saldo_awal);
			}

			if($journal_data)
			{
				foreach ($journal_data as $row)
				{
					if(isset($result[$row->kelompok_akun_id][$row->akun_id]))
					{
						if($row->debit_kredit == 1)
						{
							$result[$row->kelompok_akun_id][$row->akun_id]['saldo'] += $row->nilai;
						}
						else
						{
							$result[$row->kelompok_akun_id][$row->akun_id]['saldo'] -= $row->nilai;
						}
					}
				}
			}
			return $result;
		}
		else
		{
			$this->session->set_userdata('ERRMSG_ARR', 'Laporan Neraca tidak dapat dibuat karena belum ada data akun pada kelompok aktiva, kewajiban, dan modal');
			redirect('laporan_keuangan');
		}
	}

	function _get_laba_rugi_data($bulan, $tahun)
	{
		$this->jurnal_model->set_month_year($bulan, $tahun);
		$this->jurnal_model->set_account_group_id(array(4,5));
		$journal_data = $this->jurnal_model->get_data();

		$this->akun_model->set_account_group_id(array(4,5));
		$akun = $this->akun_model->get_all_data();

		if($akun)
		{
			foreach ($akun as $row)
			{
				$result[0][$row->kelompok_akun_id][$row->id] = array('nama' => $row->nama, 'saldo' => 0);
				$result[1][$row->kelompok_akun_id][$row->id] = array('nama' => $row->nama, 'saldo' => 0);
			}

			if($journal_data)
			{
				foreach ($journal_data as $row)
				{
					if(isset($result[0][$row->kelompok_akun_id][$row->akun_id]))
					{
						if($row->debit_kredit == 1)
						{
							if($row->proyek_id)
							{
								$result[1][$row->kelompok_akun_id][$row->akun_id]['saldo'] += $row->nilai;
							}
							else
							{
								$result[0][$row->kelompok_akun_id][$row->akun_id]['saldo'] += $row->nilai;
							}
						}
						else
						{
							if($row->proyek_id)
							{
								$result[1][$row->kelompok_akun_id][$row->akun_id]['saldo'] -= $row->nilai;
							}
							else
							{
								$result[0][$row->kelompok_akun_id][$row->akun_id]['saldo'] -= $row->nilai;
							}
						}
					}
				}
			}			
			return $result;
		}
		else
		{
			$this->session->set_userdata('ERRMSG_ARR', 'Laporan Laba Rugi tidak dapat dibuat karena belum ada data akun pada kelompok pendapatan dan biaya');
			redirect('laporan_keuangan');
		}
	}

}
/* End of file laporan_keuangan.php */
/* Location: ./application/CI_Controllers/laporan_keuangan.php */
