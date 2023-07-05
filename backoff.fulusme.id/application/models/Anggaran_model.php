<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran_model extends CI_Model {
	public $table = "m_mata_anggaran";
	public $primary = "id_mata_anggaran";
	private $ahtos_DB;

    public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

    function get_all($condition="",$limit=10000,$offset=0){
    	if($condition !="")
    	{
    		$this->db->where($condition);
    	}
    	

    	return $this->db->get($this->table);

    }
    function get_all_count($condition=""){
    	if($condition !="")
    	{
    		$this->db->where($condition);
    	}

    	return $this->db->count_all($this->table);

    }
    function get_by_id($id){
    	$this->db->where($this->primary,$id);
    	return $this->db->get($this->table);
    }

	
	function table_add($data){
		
		if ($this->db->insert($this->table,$data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}	
	}
	function table_update($id,$data){
		
		//if($this->role_exists($id) == false){
		//	$this->table_add($data);
		//	return true;
		//}else{
			$this->db->where($this->primary, $id);
			$this->db->update($this->table,$data);
			//var_dump($this->db->affected_rows());
			//die();
			if($this->db->affected_rows() > 0)
			{	
				return true;
			} else {
				return "Tidak ada data yang diubah";
			}	
		//}
	}
	function role_exists($id)
	{
		$this->db->where($this->primary, $id);
		$query = $this->db->get($this->table);
		
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	function get_all_periode($condition="",$limit=10000,$offset=0){
    	if($condition !="")
    	{
    		$this->db->where($condition);
    	}
    	$this->db->select("m_mata_anggaran.id_anggaran,
						m_mata_anggaran.id_mata_anggaran,
						m_mata_anggaran.mata_anggaran,
						m_periode_anggaran.id_periode,
						m_periode_anggaran.nama_periode,
						m_periode_anggaran.tanggal_awal,
						m_periode_anggaran.tanggal_akhir,
						m_periode_anggaran.is_aktif");
    	$this->db->from("m_mata_anggaran");
    	$this->db->JOIN("m_periode_anggaran","m_periode_anggaran.id_mata_anggaran =m_mata_anggaran.id_mata_anggaran ","INNER");
    	

    	return $this->db->get();

    }
    function get_all_mapping($condition="",$limit=10000,$offset=0){
    	if($condition !="")
    	{
    		$this->db->where($condition);
    	}
    	$this->db->select("`m_periode_anggaran`.`id_periode`,
    						m_mata_anggaran.id_anggaran,
							m_mata_anggaran.id_mata_anggaran,
							m_mata_anggaran.mata_anggaran,
							m_periode_anggaran.nama_periode,
							m_periode_anggaran.tanggal_awal,
							m_periode_anggaran.tanggal_akhir,
							m_periode_anggaran.is_aktif,
							m_mapping_anggaran.id_akun,
							sum(`m_mapping_anggaran`.`nominal`) nominal");
    	$this->db->from("m_mapping_anggaran");
    	$this->db->JOIN("m_periode_anggaran","m_periode_anggaran.id_periode = m_mapping_anggaran.id_periode","INNER");
    	$this->db->JOIN("m_mata_anggaran","m_mata_anggaran.id_mata_anggaran = m_periode_anggaran.id_mata_anggaran","INNER");
    	$this->db->group_by("`m_mata_anggaran`.`id_anggaran`,`m_periode_anggaran`.`id_periode`");
    	

    	return $this->db->get();

    }
    function get_detail_mapping($condition="",$limit=10000,$offset=0){
    	if($condition !="")
    	{
    		$this->db->where($condition);
    	}
    	$this->db->select("`m_periode_anggaran`.`id_periode`,
                            m_mata_anggaran.id_anggaran,
                            m_mata_anggaran.id_mata_anggaran,
                            m_mata_anggaran.mata_anggaran,
                            m_periode_anggaran.nama_periode,
                            m_periode_anggaran.tanggal_awal,
                            m_periode_anggaran.tanggal_akhir,
                            m_periode_anggaran.is_aktif,
                            m_mapping_anggaran.id_mapping,
                            m_mapping_anggaran.id_akun,
                            m_mapping_anggaran.nominal,
                            akun.id id_akun,
                            akun.nama nama_akun
                            ");
    	$this->db->from("m_mapping_anggaran");
    	$this->db->JOIN("m_periode_anggaran","m_periode_anggaran.id_periode = m_mapping_anggaran.id_periode","INNER");
    	$this->db->JOIN("m_mata_anggaran","m_mata_anggaran.id_mata_anggaran = m_periode_anggaran.id_mata_anggaran","INNER");
    	$this->db->JOIN("akun","m_mapping_anggaran.id_akun = akun.id","LEFT");
    	
    	return $this->db->get();

    }
    function get_aktif_periode(){
    	$condition = array("is_aktif"=>1);
    	$PeriodeAktif = $this->get_all_periode($condition)->row_array();
    	

    	if(count($PeriodeAktif) <=0){
    		$this->session->set_flashdata("message","periode tidak ada yang aktif, silahkan aktifkan salah satu");
                redirect("anggaran/setting_periode");
    	}else{
			return $PeriodeAktif;    		
    	}
    }
    function get_aktif_realisai(){
    	$PeriodeAktif = $this->get_aktif_periode();
    	$query="SELECT
					`m_periode_anggaran`.`id_periode`,
					`m_mata_anggaran`.`id_anggaran`,
					`m_mata_anggaran`.`id_mata_anggaran`,
					`m_mata_anggaran`.`mata_anggaran`,
					`m_periode_anggaran`.`nama_periode`,
					`m_periode_anggaran`.`tanggal_awal`,
					`m_periode_anggaran`.`tanggal_akhir`,
					`m_periode_anggaran`.`is_aktif`,
					`m_mapping_anggaran`.`id_akun`,
					`m_mapping_anggaran`.`nominal`,
					`akun`.`nama` nama_akun ,
                    `akun`.`kelompok_akun_id` kelompok_akun_id ,
					sum(if(jurnal_detail.debit_kredit=1,jurnal_detail.nilai,0)) debet,
					sum(if(jurnal_detail.debit_kredit=0,jurnal_detail.nilai,0)) kredit
				FROM
					( m_periode_anggaran )
					INNER JOIN `m_mapping_anggaran`  ON `m_periode_anggaran`.`id_periode` = `m_mapping_anggaran`.`id_periode`
					INNER JOIN `m_mata_anggaran` ON `m_mata_anggaran`.`id_mata_anggaran` = `m_periode_anggaran`.`id_mata_anggaran`
					LEFT JOIN `akun` ON `m_mapping_anggaran`.`id_akun` = `akun`.`id` 
					LEFT JOIN jurnal_detail ON jurnal_detail.akun_id = `m_mapping_anggaran`.`id_akun`
				WHERE
					`m_periode_anggaran`.`id_periode` = '".$PeriodeAktif['id_periode']."'
				GROUP BY
				`m_periode_anggaran`.`id_periode`,
				`m_mapping_anggaran`.`id_akun`";

    	return $this->db->query($query)->result_array();
    }
	
	function get_data_by_id($id){
		$this->db->where('id_mapping', $id);
		$query = $this->db->get('m_mapping_anggaran');
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
		function fill_data_up()
	{
		
		$this->data = array(
			'id_akun' => $this->input->post('akun'),
			'nominal' => $this->input->post('nominal')
		);
	}
	
	function update_data_up($id)
	{
		$this->db->where('id_mapping', $id);
		$update = $this->db->update('m_mapping_anggaran', $this->data);
		return $update;
	}
	
}
?>