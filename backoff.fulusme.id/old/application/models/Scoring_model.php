<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scoring_model extends CI_Model
{

  var $data;
  private $db_fulus;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->db_fulus = $this->load->database('fulusme', TRUE);
  }

  public function getType()
  {
    return $this->db->get('scr_type')->result_array();
  }

  public function addType()
  {
    $datType = [
      'nama_tipe' => htmlspecialchars($this->input->post('nama_tipe', true)),
      'tgl_berlaku' => htmlspecialchars($this->input->post('tgl_berlaku', true))
    ];
    $this->db->insert('scr_type', $datType);
    redirect('scoring/addType');
  }

  public function addDetailType()
  {
    $nama_detail_tipe = $_POST['nama_detail_tipe'];
    $tipe_id = $_POST['tipe_id'];
    $bobot = $_POST['bobot'];
    $datKriteria = array();
    $i = 0;

    foreach ($nama_detail_tipe as $dataNama) {
      array_push($datKriteria, array(
        'tipe_id' => $tipe_id,
        'nama_detail_tipe' => $dataNama,
        'bobot_persent' => $bobot[$i]
        // 'bobot_scoring' => $bobot_scoring[$i],
        // 'nilai' => $nilai[$i],
        // 'scoring' => $scoring[$i]
      ));

      $i++;
    }
    $this->db->insert_batch('scr_detail_tipe', $datKriteria);
    redirect('scoring/addDetailType');
  }

  public function addSubDetail()
  {
    $nama_detail_tipe = $_POST['nama_sub_detail'];
    $detail_tipe_id = $_POST['detail_tipe_id'];
    $bobot_persent = $_POST['bobot_persent'];
    $datKriteria = array();
    $i = 0;

    foreach ($nama_detail_tipe as $dataNama) {
      array_push($datKriteria, array(
        'detail_tipe_id' => $detail_tipe_id,
        'nama_sub_detail' => $dataNama,
        'bobot_persent' => $bobot_persent[$i]
      ));

      $i++;
    }
    $this->db->insert_batch('scr_sub_detail_tipe', $datKriteria);
    redirect('scoring/addSubDetail');
  }

  public function addFaktor()
  {
    $nama_faktor = $_POST['nama_faktor'];
    $sub_detail_tipe_id = $_POST['sub_detail_tipe_id4'];
    $bobot_score = $_POST['score'];
    $datKriteria = array();
    $i = 0;

    foreach ($nama_faktor as $dataNama) {
      array_push($datKriteria, array(
        'sub_detail_tipe_id' => $sub_detail_tipe_id,
        'nama_faktor' => $dataNama,
        'score' => $bobot_score[$i]
      ));

      $i++;
    }
    $this->db->insert_batch('scr_faktor', $datKriteria);
    redirect('scoring/addFaktor');
  }

  public function getDetailTipe()
  {
    $id = $this->input->post('tipe_id');

    $this->db->select('scr_detail_tipe.id, scr_detail_tipe.nama_detail_tipe, scr_type.nama_tipe');
    $this->db->from('scr_detail_tipe');
    $this->db->join('scr_type', 'scr_type.id = scr_detail_tipe.tipe_id');
    $this->db->where('tipe_id', $id);
    $this->db->order_by('tipe_id');
    return $this->db->get()->result_array();
  }

  public function getSubDetailTipe()
  {
    $id = $this->input->post('detail_tipe_id');

    $this->db->select('scr_sub_detail_tipe.id, scr_sub_detail_tipe.nama_sub_detail, scr_detail_tipe.nama_detail_tipe');
    $this->db->from('scr_sub_detail_tipe');
    $this->db->join('scr_detail_tipe', 'scr_detail_tipe.id = scr_sub_detail_tipe.detail_tipe_id');
    $this->db->where('detail_tipe_id', $id);
    $this->db->order_by('detail_tipe_id');
    return $this->db->get()->result_array();
  }
}
