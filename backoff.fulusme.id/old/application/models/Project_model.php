<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model
{

  var $data;
  private $db_fulus;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
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

  function GenProjNumber()
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

    $kode = "PRO-" . date('d') . "-" . $invno;
    return $kode;
  }

  function getAllProject()
  {
    $arr = [];
    $this->db_fulus->select('*');
    $this->db_fulus->from('project');
    $this->db_fulus->order_by('project.create_ts', 'ASC');
    $this->db_fulus->where('version', 0);
    $query = $this->db_fulus->get()->result();
    foreach ($query as $key) {
      $versi1 = $this->db->get_where('history_project', ['id' => $key->id])->row();
      if ($versi1) {
        array_push($arr, $versi1);
      } else {
        array_push($arr, $key);
      }
    }
    return $arr;
  }

  function getAllProjectRetail($cek)
  {
    $this->db_fulus->select('project_retail.*, retail.user_id');
    $this->db_fulus->from('project_retail');
    $this->db_fulus->join('retail', 'retail.id = project_retail.retail_id');
    $this->db_fulus->order_by('project_retail.create_ts', 'ASC');
    if ($cek != 10) {
      $this->db_fulus->where('status', $cek);
    }
    $query = $this->db_fulus->get()->result();
    return $query;
  }

  function getProject()
  {
    $this->db->select('trx_project.*');
    $this->db->from('trx_project');
    $this->db->where('status', 1);
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->result_array();
  }

  function getProjectJatuhTempo()
  {
    $this->db->select('*');
    $this->db->from('trx_jatuh_tempo');
    $this->db->where('tgl_tempo <=', date('Y-m-d', strtotime("+3 day")));
    $this->db->where('status', 0);
    return $this->db->get()->result();
  }

  function getDashProTerkumpul()
  {
    $pro = $this->db->get_where('trx_project', ['status' => 1])->result();
    $arr = [];
    foreach ($pro as $key) {
      $cek_modal = $this->getDataProject($key->id_project);
      if ($cek_modal) {
        $modal = $cek_modal->modal_project;
      } else {
        $modal = $this->db->get_where('trx_project_retail', ['id_project' => $key->id_project])->row()->modal_project;
      }
      $cek_status = $this->db->get_where('history_project', ['id' => $key->id_project])->row();
      if ($cek_status) {
        $status = $cek_status;
      } else {
        $status = $this->db_fulus->get_where('project_retail', ['id_project' => $key->id_project])->row();
      }
      $query = $this->db->select('create_ts')->from('trx_pendanaan')->where('id_project', $key->id_project)->order_by('create_ts', 'DESC')->limit(1)->get()->row();
      if ($query && $status->status == 1) {
        $dayEnd = $key->tgl_deadline;
        $day2 = date('Y-m-d', strtotime('+2 days', strtotime($dayEnd)));
        if ($day2 <= date('Y-m-d')) {
          if ($modal <= $key->dana_terkumpul) {
            array_push($arr, $key);
          }
        }
      }
    }
    return $arr;
  }

  function getDashProTidakTerkumpul()
  {
    $pro = $this->db->get_where('trx_project', ['status' => 1])->result();
    $arr = [];
    foreach ($pro as $key) {
      $cek_modal = $this->getDataProject($key->id_project);
      if ($cek_modal) {
        $modal = $cek_modal->modal_project;
      } else {
        $modal = $this->db->get_where('trx_project_retail', ['id_project' => $key->id_project])->row()->modal_project;
      }
      $query = $this->db->select('create_ts')->from('trx_pendanaan')->where('id_project', $key->id_project)->order_by('create_ts', 'DESC')->limit(1)->get()->row();
      if ($query) {
        $dayEnd = $key->tgl_deadline;
        $day2 = date('Y-m-d');
        if ($day2 >= $dayEnd) {
          if ($modal > $key->dana_terkumpul) {
            array_push($arr, $key);
          }
        }
      }
    }
    return $arr;
  }

  function getDetailProject($id)
  {
    return $this->db->get_where('trx_project', ['id_project' => $id])->row();
  }

  function getDanaTerkumpul($id_project)
  {
    $this->db->select_sum('nominal');
    $this->db->where('id_project', $id_project);
    return $this->db->get('trx_pendanaan')->row();
  }

  function getDataProject($id_project)
  {
    $query1 = $this->db->get_where('history_project', ['id' => $id_project])->row();
    if ($query1) {
      return $query1;
    } else {
      return $this->db_fulus->get_where('project', ['id' => $id_project])->row();
    };
  }

  function getTrackPendanaan($id)
  {
    return $this->db->query("SELECT a.*, b.user_id, b.full_name, b.bank_number
                            FROM new_surplus.trx_pendanaan a
                            JOIN fintekma_prod.pendana b
                            ON b.id = a.id_pendana 
                            WHERE id_project = $id")->result();
  }

  function returPendanaan($id)
  {
    return $this->db->query("SELECT a.*, b.user_id, b.full_name, b.bank_number, c.nominal as nominal_retur, c.create_ts as waktu_retur, 
                            c.keuntungan
                            FROM new_surplus.trx_pendanaan a
                            JOIN fintekma_prod.pendana b ON b.id = a.id_pendana
                            JOIN new_surplus.trx_hutang_payment c ON c.id_project = a.id_project
                            WHERE a.id_project = $id AND c.status = 2
                            GROUP BY id_pendana")->result();
  }

  function pelunasanPendanaan($id)
  {
    return $this->db->query("SELECT a.*, b.user_id, b.full_name, b.bank_number, c.nominal as nominal_retur, c.create_ts as waktu_retur, 
                            c.keuntungan
                            FROM fintekma_backend.trx_pendanaan a
                            JOIN fintekma_prod.pendana b ON b.id = a.id_pendana
                            JOIN fintekma_backend.trx_hutang_payment c ON c.id_project = a.id_project
                            WHERE a.id_project = $id AND c.status = 1 AND a.return_ts IS NOT Null
                            GROUP BY id_pendana")->result();
  }

  function postProject($id)
  {
    $project = $this->db->get_where('trx_project', ['id' => $id])->row_array();
    $idPro = $project['id_project'];
    $namePro = $project['nama_project'];
    $tipe = $project['tipe'];
    $pinjaman = $this->input->post('pinjam_di_tf');
    $ujrah = $this->input->post('ujrah');
    $keuntungan = $this->input->post('keuntungan');
    $lender = $this->input->post('lender');
    $borrower = $this->input->post('borrower');
    $invoice = $this->GenProjNumber();

    $data_trx = [
      'no_trx_kas' => $invoice,
      'tgl_catat' => date('Y-m-d'),
      'jumlah' => intval(str_replace(',', '', $pinjaman)),
      'keterangan' => "Pengiriman Dana Project $namePro dengan Id Project $idPro",
      'akun' => "Pengeluaran",
      'jns_trans' => "KK",
      'dok' => $namePro,
      'no_dok' => $idPro,
      'kepada' => $project['nama_peminjam']
    ];
    $this->db->insert('tbl_trans_kas', $data_trx);

    if ($project) {
      $dataJurnal = [
        'no' =>  $this->GenJurNumber(),
        'tgl' => date("Y-m-d"),
        'f_id' => 1,
        'invoice_no' => $invoice,
        'keterangan' => "Pengiriman Dana Project $namePro",
        'waktu_post' => date("Y-m-d")
      ];
      $this->db->insert('jurnal', $dataJurnal);
      $lastID = $this->db->insert_id();

      if ($tipe != 'Murabahah') {
        if ($tipe === 'Musyarakah') {
          $akun = 91;
        } elseif ($tipe === 'Mudharabah') {
          $akun = 90;
        }
        $akun_k = 5;
        $dataJurnal_detail_debit = [
          'jurnal_id' => $lastID,
          'item' => 1,
          'akun_id' => $akun,
          'debit_kredit' => 1,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $dataJurnal_detail_kredit = [
          'jurnal_id' => $lastID,
          'item' => 2,
          'akun_id' => $akun_k,
          'debit_kredit' => 0,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $saldo_akun_default_d = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun)->get()->row()->saldo;
        $saldo_akun_default_k = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_k)->get()->row()->saldo;
        $saldo_new_d = $saldo_akun_default_d + (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('akun_saldo_id', $akun);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_d]);
        $saldo_new_k = $saldo_akun_default_k - (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('akun_saldo_id', $akun_k);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_k]);
      } else {
        $akun_d1 = 93;
        $akun_k1 = 92;
        $akun_k2 = 89;
        $dataJurnal_detail_debit = [
          'jurnal_id' => $lastID,
          'item' => 1,
          'akun_id' => $akun_d1,
          'debit_kredit' => 1,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $dataJurnal_detail_kredit = [
          'jurnal_id' => $lastID,
          'item' => 2,
          'akun_id' => $akun_k1,
          'debit_kredit' => 0,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $dataJurnal_detail_kredit1 = [
          'jurnal_id' => $lastID,
          'item' => 3,
          'akun_id' => $akun_k2,
          'debit_kredit' => 0,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];
        $this->db->insert('jurnal_detail', $dataJurnal_detail_kredit1);

        $saldo_akun_default_d1 = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_d1)->get()->row()->saldo;
        $saldo_akun_default_k1 = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_k1)->get()->row()->saldo;
        $saldo_akun_default_k2 = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_k2)->get()->row()->saldo;
        $saldo_new_d1 = $saldo_akun_default_d1 + (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('akun_saldo_id', $akun_d1);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_d1]);
        $saldo_new_k1 = $saldo_akun_default_k1 - (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('akun_saldo_id', $akun_k1);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_k1]);
        $saldo_new_k2 = $saldo_akun_default_k2 - (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('akun_saldo_id', $akun_k2);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_k2]);
      }

      $tipe_angsuran = "Di Akhir";
      $akhir_tempo = date("Y-m-d", $project['angsuran']);
      if ($project['angsuran'] <= 12) {
        $tipe_angsuran = "Per Bulan";
        $m = $project['angsuran'];
        $akhir_tempo = date('Y-m-d', strtotime("+$m month"));
      }

      $dataJatuhTempo = [
        'id_project' => $project['id_project'],
        'nama_project' => $project['nama_project'],
        'peminjam' => $project['nama_peminjam'],
        'tgl_pinjam' => date("Y-m-d"),
        'tgl_tempo' => date('Y-m-d', strtotime("+1 month")),
        'angsuran' => $project['angsuran'],
        'jumlah_pinjaman' => intval(str_replace(',', '', $project['nominal_pengembalian'])),
        'tipe_angsuran' => $tipe_angsuran,
        'status' => 0,
        'tenor' => $project['tenor'],
        'id_peminjam' => $project['id_peminjam'],
        'ujrah' => intval(str_replace(',', '', $ujrah)),
        'keuntungan' => intval(str_replace(',', '', $keuntungan)),
        'lender' => intval(str_replace(',', '', $lender)),
        'borrower' => intval(str_replace(',', '', $borrower)),
        'no_invoice' => $invoice,
        'cicilan' => intval(str_replace(',', '', $this->input->post('cicilan'))),
        'akhir_tempo' => $akhir_tempo
      ];

      $this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
      $this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);
      $this->db->insert('trx_jatuh_tempo', $dataJatuhTempo);
      $this->db_fulus->where('id', $project['id_project']);
      $this->db_fulus->update('project', ['status' => 2]);
      $this->db->where('id', $project['id_project']);
      $this->db->update('history_project', ['status' => 2]);

      $this->jurnal_ujrah($idPro, $ujrah, $namePro);
    }
  }

  function postProjectRetail($id)
  {
    $project = $this->db->get_where('trx_project', ['id' => $id])->row_array();
    $idPro = $project['id_project'];
    $namePro = $project['nama_project'];
    $tipe = $project['tipe'];
    $pinjaman = $this->input->post('pinjam_di_tf');
    $ujrah = $this->input->post('ujrah');
    $keuntungan = $this->input->post('keuntungan');
    $lender = $this->input->post('lender');
    $borrower = $this->input->post('borrower');
    $invoice = $this->GenProjNumber();

    $data_trx = [
      'no_trx_kas' => $invoice,
      'tgl_catat' => date('Y-m-d'),
      'jumlah' => intval(str_replace(',', '', $pinjaman)),
      'keterangan' => "Pengiriman Dana Project $namePro dengan Id Project $idPro",
      'akun' => "Pengeluaran",
      'jns_trans' => "KK",
      'dok' => $namePro,
      'no_dok' => $idPro,
      'kepada' => $project['nama_peminjam']
    ];
    $this->db->insert('tbl_trans_kas', $data_trx);

    if ($project) {
      $dataJurnal = [
        'no' =>  $this->GenJurNumber(),
        'tgl' => date("Y-m-d"),
        'f_id' => 1,
        'invoice_no' => $invoice,
        'keterangan' => "Pengiriman Dana Project $namePro",
        'waktu_post' => date("Y-m-d")
      ];
      $this->db->insert('jurnal', $dataJurnal);
      $lastID = $this->db->insert_id();

      if ($tipe != 'Murabahah') {
        if ($tipe === 'Musyarakah') {
          $akun = 91;
        } elseif ($tipe === 'Mudharabah') {
          $akun = 90;
        }
        $akun_k = 5;
        $dataJurnal_detail_debit = [
          'jurnal_id' => $lastID,
          'item' => 1,
          'akun_id' => $akun,
          'debit_kredit' => 1,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $dataJurnal_detail_kredit = [
          'jurnal_id' => $lastID,
          'item' => 2,
          'akun_id' => $akun_k,
          'debit_kredit' => 0,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $saldo_akun_default_d = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun)->get()->row()->saldo;
        $saldo_akun_default_k = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_k)->get()->row()->saldo;
        $saldo_new_d = $saldo_akun_default_d + (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('id', $akun);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_d]);
        $saldo_new_k = $saldo_akun_default_k - (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('id', $akun_k);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_k]);
      } else {
        $akun_d1 = 93;
        $akun_k1 = 92;
        $akun_k2 = 89;
        $dataJurnal_detail_debit = [
          'jurnal_id' => $lastID,
          'item' => 1,
          'akun_id' => $akun_d1,
          'debit_kredit' => 1,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $dataJurnal_detail_kredit = [
          'jurnal_id' => $lastID,
          'item' => 2,
          'akun_id' => $akun_k1,
          'debit_kredit' => 0,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];

        $dataJurnal_detail_kredit1 = [
          'jurnal_id' => $lastID,
          'item' => 3,
          'akun_id' => $akun_k2,
          'debit_kredit' => 0,
          'nilai' => intval(str_replace(',', '', $pinjaman))
        ];
        $this->db->insert('jurnal_detail', $dataJurnal_detail_kredit1);

        $saldo_akun_default_d1 = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_d1)->get()->row()->saldo;
        $saldo_akun_default_k1 = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_k1)->get()->row()->saldo;
        $saldo_akun_default_k2 = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_k2)->get()->row()->saldo;
        $saldo_new_d1 = $saldo_akun_default_d1 + (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('id', $akun_d1);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_d1]);
        $saldo_new_k1 = $saldo_akun_default_k1 - (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('id', $akun_k1);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_k1]);
        $saldo_new_k2 = $saldo_akun_default_k2 - (int) intval(str_replace(',', '', $pinjaman));
        $this->db->where('id', $akun_k2);
        $this->db->update('akun_saldo', ['saldo' => $saldo_new_k2]);
      }

      $tipe_angsuran = "Di Akhir";
      $akhir_tempo = date("Y-m-d", $project['angsuran']);
      if ($project['angsuran'] <= 12) {
        $tipe_angsuran = "Per Bulan";
        $m = $project['angsuran'];
        $akhir_tempo = date('Y-m-d', strtotime("+$m month"));
      }

      $dataJatuhTempo = [
        'id_project' => $project['id_project'],
        'nama_project' => $project['nama_project'],
        'peminjam' => $project['nama_peminjam'],
        'tgl_pinjam' => date("Y-m-d"),
        'tgl_tempo' => date('Y-m-d', strtotime("+1 month")),
        'angsuran' => $project['angsuran'],
        'jumlah_pinjaman' => intval(str_replace(',', '', $project['nominal_pengembalian'])),
        'tipe_angsuran' => $tipe_angsuran,
        'status' => 0,
        'tenor' => $project['tenor'],
        'id_peminjam' => $project['id_peminjam'],
        'ujrah' => intval(str_replace(',', '', $ujrah)),
        'keuntungan' => intval(str_replace(',', '', $keuntungan)),
        'lender' => intval(str_replace(',', '', $lender)),
        'borrower' => intval(str_replace(',', '', $borrower)),
        'no_invoice' => $invoice,
        'cicilan' => intval(str_replace(',', '', $this->input->post('cicilan'))),
        'akhir_tempo' => $akhir_tempo
      ];

      $this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
      $this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);
      $this->db->insert('trx_jatuh_tempo', $dataJatuhTempo);
      $this->db_fulus->where('id', $project['id_project']);
      $this->db_fulus->update('project_retail', ['status' => 2]);

      $this->jurnal_ujrah($idPro, $ujrah, $namePro);
    }
  }

  function jurnal_ujrah($idPro, $ujrah, $namePro)
  {
    $mat = mt_rand();
    $invoice = "$mat-$idPro";
    $akun_d = 82;
    $akun_k = 5;

    $data_trx_ = [
      'no_trx_kas' => "TK-$invoice",
      'tgl_catat' => date('Y-m-d'),
      'jumlah' => intval(str_replace(',', '', $ujrah)),
      'keterangan' => "Ujrah project $namePro",
      'akun' => "Transfer",
      'jns_trans' => "TK",
      'dari_kas_id' => 42,
      'dok' => $namePro,
      'no_dok' => $idPro,
      'untuk_kas_id' => 53,
      'dari' => 'Bank',
      'kepada' => 'Bank Fast'
    ];
    $this->db->insert('tbl_trans_kas', $data_trx_);

    $dataJurnal = [
      'no' =>  $this->GenJurNumber(),
      'tgl' => date("Y-m-d"),
      'f_id' => 1,
      'invoice_no' => "TK-$invoice",
      'keterangan' => "Ujrah project $namePro",
      'waktu_post' => date("Y-m-d")
    ];
    $this->db->insert('jurnal', $dataJurnal);
    $lastID = $this->db->insert_id();

    $dataJurnal_detail_debit = [
      'jurnal_id' => $lastID,
      'item' => 1,
      'akun_id' => $akun_d,
      'debit_kredit' => 1,
      'nilai' => intval(str_replace(',', '', $ujrah))
    ];

    $dataJurnal_detail_kredit = [
      'jurnal_id' => $lastID,
      'item' => 2,
      'akun_id' => $akun_k,
      'debit_kredit' => 0,
      'nilai' => intval(str_replace(',', '', $ujrah))
    ];

    $saldo_akun_default_d = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_d)->get()->row()->saldo;
    $saldo_akun_default_k = $this->db->select('saldo')->from('akun_saldo')->where('akun_saldo_id', $akun_k)->get()->row()->saldo;
    $saldo_new_d = $saldo_akun_default_d + (int) intval(str_replace(',', '', $ujrah));
    $this->db->where('akun_saldo_id', $akun_d);
    $this->db->update('akun_saldo', ['saldo' => $saldo_new_d]);
    $saldo_new_k = $saldo_akun_default_k - (int) intval(str_replace(',', '', $ujrah));
    $this->db->where('akun_saldo_id', $akun_k);
    $this->db->update('akun_saldo', ['saldo' => $saldo_new_k]);

    $this->db->insert('jurnal_detail', $dataJurnal_detail_debit);
    $this->db->insert('jurnal_detail', $dataJurnal_detail_kredit);
  }

  function cancelProject($id)
  {
    $data = ['status' => 4, 'end_ts' => time()];
    $this->db_fulus->set($data);
    $this->db_fulus->where('id', $id);
    $this->db_fulus->update('project');
    $this->db->where('id', $id);
    $this->db->update('history_project', $data);
    $this->db->where('id_project', $id);
    $this->db->update('trx_project', ['status' => 4]);

    $data_retur = ['status' => 2, 'cancel_ts' => date('Y-m-d h:i:s')];
    $this->db->where('id_project', $id);
    $this->db->update('trx_pendanaan', $data_retur);
  }
}
