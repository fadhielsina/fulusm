<?php

class Home extends CI_Controller
{

	public $identity_id;

	function __construct()
	{
		parent::__construct();;
		$this->load->model('project_model');
		$this->load->database();
		$this->db_fulus = $this->load->database('fulusme', TRUE);
		$this->load->library(array('auth', 'customlib', 'session'));
		$this->auth->check_user_authentification();
	}

	function index()
	{
		$data = $this->show_chart();
		$data['title'] = "Selamat Datang";
		$data['main_content'] = 'home';
		$data['crowdfunding'] = $this->project_model->getProject();
		$data['project_tidak_terkumpul'] = $this->project_model->getDashProTidakTerkumpul();
		$data['pengembalian_project'] = $this->project_model->getProjectJatuhTempo();
		$data['project_terkumpul'] = $this->project_model->getDashProTerkumpul();
		$this->load->view('template/template_xpanel', $data);
	}

	//open flash chart dev

	public function show_chart()
	{
		$data = array(
			'chart_height'  => 400,
			'chart_width'   => '100%',
			'data_url'      => site_url('home/get_laba_rugi')
		);
		return $data;
	}

	function get_realisasi()
	{
		if (count($data['realisasi']) > 0) {
			$data['periode'] = $data['realisasi'][0];
			$this->load->view('template/template_xpanel', $data);
		}
		$data['realisasi'] = $this->anggaran_model->get_aktif_realisai();
	}


	/**
	 * Generates data for OFC2 line chart in json format
	 *
	 * @return void
	 */
	public function get_laba_rugi()
	{
		$this->load->plugin('ofc2');
		$this->load->model('jurnal_model');

		$model_data = $this->jurnal_model->get_laba_rugi_data();

		$bulan_data = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");

		for ($i = (date('n') + 1); $i <= 12; $i++) {
			$pendapatan_kredit = (isset($model_data[$i][date('Y') - 1][4][0])) ? $model_data[$i][date('Y') - 1][4][0] : 0;
			$pendapatan_debit = (isset($model_data[$i][date('Y') - 1][4][1])) ? $model_data[$i][date('Y') - 1][4][1] : 0;
			$beban_kredit = (isset($model_data[$i][date('Y') - 1][5][0])) ? $model_data[$i][date('Y') - 1][5][0] : 0;
			$beban_debit = (isset($model_data[$i][date('Y') - 1][5][1])) ? $model_data[$i][date('Y') - 1][5][1] : 0;

			$data[] = ($pendapatan_kredit - $pendapatan_debit) - ($beban_debit - $beban_kredit);
			$thn = date('y') - 1;
			$thn = (strlen($thn) == 1) ? '0' . $thn : $thn;
			$x_data[] = $bulan_data[$i - 1] . "'" . $thn;
		}
		for ($i = 1; $i <= date('n'); $i++) {
			$pendapatan_kredit = (isset($model_data[$i][date('Y')][4][0])) ? $model_data[$i][date('Y')][4][0] : 0;
			$pendapatan_debit = (isset($model_data[$i][date('Y')][4][1])) ? $model_data[$i][date('Y')][4][1] : 0;
			$beban_kredit = (isset($model_data[$i][date('Y')][5][0])) ? $model_data[$i][date('Y')][5][0] : 0;
			$beban_debit = (isset($model_data[$i][date('Y')][5][1])) ? $model_data[$i][date('Y')][5][1] : 0;

			$data[] = ($pendapatan_kredit - $pendapatan_debit) - ($beban_debit - $beban_kredit);
			$x_data[] = $bulan_data[$i - 1] . "'" . date('y');
		}

		$max = (int)max($data);
		$maxlen = strlen($max);
		$up = round($max, - ($maxlen - 1));

		$min = (int)min($data);
		$minlen = strlen($min);
		$down = round($min, - ($minlen - 1));

		$abs_max = (int)max(abs($max), abs($min));
		$len = strlen($abs_max);
		$round = round($abs_max, - ($len - 1));
		$step = '1' . substr($round, 1);
		$up = ($max > $up) ? $up + $step : $up;
		$down = ($min < $down) ? $down - $step : $down;

		$d = new hollow_dot();
		$d->size(4)->halo_size(1)->colour('#668053');

		$line = new line();
		$line->set_values($data);
		$line->set_default_dot_style($d);
		$line->set_width(5);
		$line->set_colour('#7491a0');

		$x_labels = new x_axis_labels();
		$x_labels->set_labels($x_data);

		$x = new x_axis();
		$x->set_labels($x_labels);
		$x->set_grid_colour('#bfb8b3');

		$y = new y_axis();
		$y->set_grid_colour('#bfb8b3');
		$y->set_range($down, $up, $step);

		$chart = new open_flash_chart();
		$chart->add_element($line);
		$chart->set_x_axis($x);
		$chart->set_y_axis($y);
		$chart->set_bg_colour('#FFFFFF');

		echo $chart->toPrettyString();
	}
	public function change_lang($lang)
	{
		$this->athoslib->loadLanguage($lang);
	}

	//open flash chart dev
}
/* End of file home.php */
/* Location: ./application/CI_Controllers/home.php */
