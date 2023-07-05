<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Auto extends CI_Controller
{
 
	public function __construct() {
		parent::__construct();;
		$this->load->model('mauto'); 
		$this->load->helper(array('url'));
 
	}
 
	public function index()
	{
	}
	
	 public function get_bahan_formula() {
		
		$kode = strtolower($_GET['term']); 
		$query = $this->mauto->get_bahan_formula($kode); 
 
		$produk       =  array();
		foreach ($query as $d) {
			$produk[]     = array(
				'label' => $d->productBarcode." - ". $d->productName, 
				'kdproduk' => $d->productBarcode,
				'stokproduk' => $d->productStock
			);
		}
		echo json_encode($produk);    
	}
	
	
	public function get_produk() {
		$identity=$this->session->userdata('identityID');
		$kode = strtolower($_GET['term']); 
		$query = $this->mauto->get_produk($kode,$identity); 

		$produk       =  array();
		foreach ($query as $d) {
			$produk[]     = array(
			'label' => $d->productBarcode." - ". $d->productName." - ". $d->productShortcut,
			'kdproduk' => $d->productBarcode,
			'stokproduk' => $d->jumlah
			);
		}
		echo json_encode($produk);    
	}
	
	 public function get_produk_promo() {
		
	   $identity=$this->session->userdata('identityID');
		$kode = strtolower($_GET['term']); 
		$query = $this->mauto->get_produk_promo($kode,$identity); 
 
		$produk       =  array();
		foreach ($query as $d) {
			$produk[]     = array(
				'label' => $d->productName, 
				'kdproduk' => $d->productBarcode,
				'stokproduk' => $d->productStock
			);
		}
		echo json_encode($produk);    
	}
	
	function data_member(){
		$data=$this->mauto->member_list();
		echo json_encode($data);
	}
	
	 public function get_member() {
		
		 $keyword = $this->input->post('term');
		$data['response'] = 'false'; //Set default response
		$query = $this->mauto->get_member($keyword); //Search DB
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array( 
									   'label' =>$row->memberID." - ". $row->memberFullName." - ". $row->memberAddress,
										 'memberID' => $row->memberID,
										'memberCode' => $row->memberCode,
										'memberFullName' => $row->memberFullName,
										'memberAddress' => $row->memberAddress,
										'memberPhone' => $row->memberPhone
									 );  //Add a row to array
			}
		}
		if('IS_AJAX')
		{
			echo json_encode($data); //echo json string if ajax request
			
		}
		else
		{
			
		}
	}
	 
	 
	 public function get_akun() {
		
		 $keyword = $this->input->post('term');
		$data['response'] = 'false'; //Set default response
		$query = $this->mauto->get_akun($keyword); //Search DB
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array( 
									   'label' => $row->kode." - ". $row->nama,
										 'id' => $row->id,
										 'namaakun' => $row->nama,
										 'kodeakun' => $row->kode,
										 'idakun' => $row->id
									 );  //Add a row to array
			}
		}
		if('IS_AJAX')
		{
			echo json_encode($data); //echo json string if ajax request
			
		}
		else
		{
			
		}
	}

	public function get_vendor() {
		
		 $keyword = $this->input->post('term');
		$data['response'] = 'false'; //Set default response
		$query = $this->mauto->get_vendor($keyword); //Search DB
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array( 
									   'label' =>$row->supplierCode." - ". $row->supplierName." - ". $row->supplierAddress,
										 'supplierID' => $row->supplierID,
										'supplierCode' => $row->supplierCode,
										'supplierName' => $row->supplierName,
										'supplierAddress' => $row->supplierAddress,
										'supplierPhone' => $row->supplierPhone,
										'suppliercity' => $row->suppliercity
									 );  //Add a row to array
			}
		}
		if('IS_AJAX')
		{
			echo json_encode($data); //echo json string if ajax request
			
		}
		else
		{
			
		}
	} 
	
	public function ajax_get_vendor() {
		$id_supp=$this->input->post('supplierID');
		$data = $this->mauto->get_vendor_ajx($id_supp);
		echo json_encode($data);
	}
	
	function ajax_get_vendor_id(){
        $id=$this->input->get('id');
        $data=$this->mauto->ajax_get_vendor_by_id($id);
        echo json_encode($data);
    }
	
	
	public function ajax_get_aset_debt() {
		$id_supp=$this->input->post('supplierID');
		$data = $this->mauto->get_aset_debt_ajx($id_supp);
		echo json_encode($data);
	}
	
	function ajax_get_aset_debt_id(){
        $id=$this->input->get('id');
        $data=$this->mauto->ajax_get_aset_debt_by_id($id);
        echo json_encode($data);
    }
	
	public function ajax_get_debt_pay() {
		$id_supp=$this->input->post('supplierID');
    $data = $this->mauto->get_debt_pay_ajx($id_supp);
		echo json_encode($data);
	}
	
	public function ajax_get_recv_pay() {
		$id_mem=$this->input->post('memberID');
    $data = $this->mauto->get_recv_pay_ajx($id_mem);
		echo json_encode($data);
	}
	
	public function ajax_get_cus() {
		$id_mem=$this->input->post('memberID');
    $data = $this->mauto->get_cus_ajx($id_mem);
		echo json_encode($data);
	}
	
	function ajax_get_cus_id(){
        $id=$this->input->get('id');
        $data=$this->mauto->ajax_get_cus_by_id($id);
        echo json_encode($data);
    }
	
	 public function get_vehicles() {
		
		 $keyword = $this->input->post('term');
		$data['response'] = 'false'; //Set default response
		$query = $this->mauto->get_vehicles($keyword); //Search DB
		if( ! empty($query) )
		{
			$data['response'] = 'true'; //Set response
			$data['message'] = array(); //Create array
			foreach( $query as $row )
			{
				$data['message'][] = array( 
									   'label' =>$row->merk." - ". $row->type,
										 'id' => $row->id,
										'merk' => $row->merk,
										'type' => $row->type,
										'series' => $row->series
									 );  //Add a row to array
			}
		}
		if('IS_AJAX')
		{
			echo json_encode($data); //echo json string if ajax request
			
		}
		else
		{
			
		}
	}
	 
	
	public function get_proyek() {
		
		$kode = strtolower($_GET['term']); 
		$query = $this->mauto->get_proyek($kode); 
 
		$proyek       =  array();
		foreach ($query as $d) {
			$proyek[]     = array(
				'label' => $d->proyekCode." | ". $d->proyekFullName,
				'idproyek' => $d->proyekCode,
				'namaproyek' => $d->proyekFullName , 
				'alamatproyek' => $d->proyekAddress, 
				'telpproyek' => $d->proyekPhone 
			);
		}
		echo json_encode($proyek);      
	}
	
	
	public function ajax_list()
	{
		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $person->productID;
			$row[] = $person->productBarcode;
			$row[] = $person->productName;
			$row[] = $person->productImei;
 
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
			$data[] = $row;
		}
 
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	
	public function get_bahan() {
		
		$kode = strtolower($_GET['term']); 
		//$query = $this->mauto->get_bahan($kode);
		$query = $this->db->from('as_bahan')->like('bahanName',$kode)->get();		
 
		$produk       =  array();
		foreach ($query->result() as $d) {
			$bahan[]     = array(
				'label' => $d->bahanBarcode." - ". $d->bahanName, 
				'idbahan' => $d->bahanID,
				'bahanBarcode' => $d->bahanBarcode,
				'bahanBuyPrice' => $d->bahanBuyPrice
			);
		}
		echo json_encode($bahan);    
		
	}

	public function get_barang() {
		
		$kode = strtolower($_GET['term']); 
		//$query = $this->mauto->get_bahan($kode);
		$query = $this->db->from('as_barang')->like('barangName',$kode)->get();		
 
		$produk       =  array();
		foreach ($query->result() as $d) {
			$bahan[]     = array(
				'label' => $d->barangBarcode." - ". $d->barangName, 
				'idbarang' => $d->barangID,
				'barangBarcode' => $d->barangBarcode,
				'nama' => $d->barangName,
				'satuanID' => $d->satuanID,
				'satuanID2' => $d->satuanID2
			);
		}
		echo json_encode($bahan);    
		
	}

	public function get_barang_jual() {
		
		$kode = strtolower($_GET['term']); 
		//$query = $this->mauto->get_bahan($kode);
		$query = $this->db->from('as_barang_jual')->like('barangName',$kode)->get();		
 
		$produk       =  array();
		foreach ($query->result() as $d) {
			$bahan[]     = array(
				'label' => $d->barangBarcode." - ". $d->barangName, 
				'idbarang' => $d->barangID,
				'barangBarcode' => $d->barangBarcode,
				'nama' => $d->barangName,
				'satuanID' => $d->satuanID,
				'satuanID2' => $d->satuanID2
			);
		}
		echo json_encode($bahan);    
		
	}	

	public function get_bahan_so() {
		
		$kode = strtolower($_GET['term']); 
		//$query = $this->mauto->get_bahan($kode);
		$query = $this->db->from('as_bahan')->join('bahan_stok', 'bahan_stok.bahanBarcode = as_bahan.bahanBarcode', 'left')->like('bahanName',$kode)->limit(10)->get();		
 
		$produk       =  array();
		foreach ($query->result() as $d) {
			$bahan[]     = array(
				'label' => $d->bahanBarcode." - ". $d->bahanName, 
				'idbahan' => $d->bahanID,
				'bahanBarcode' => $d->bahanBarcode,
				'stokbahan' => $d->jumlah,
				'bahanBuyPrice' => $d->bahanBuyPrice
			);
		}
		echo json_encode($bahan);    
		
	}
		
	
	public function get_pengguna() {
		
		$kode = strtolower($_GET['term']); 
		//$query = $this->mauto->get_bahan($kode);
		$query = $this->db->from('as_pegawai')->like('nama_lengkap',$kode)->or_like('nip',$kode)->limit(10)->get();		
 
		$pengguna       =  array();
		foreach ($query->result() as $d) {
			$pengguna[]     = array(
				'label' => $d->nip." - ". $d->nama_lengkap, 
				'userid' => $d->pegawai_id,
			);
		}
		echo json_encode($pengguna);    
		
	}
	
	
	public function get_supplier() {      
	
		$kode = strtolower($_GET['term']); 		
		$query = $this->db->from('as_suppliers')->like('supplierName',$kode)->limit(10)->get();  
			
			$supplier       =  array();        
			foreach ($query->result() as $d) {            
				$supplier[]     = array(           
					'label' => $d->supplierName." - ". $d->supplierAddress,  
					'supplierID' => $d->supplierID,
					'supplierName' => $d->supplierName,					
					'alamatkirim' => $d->supplierAddress,
					'email' => $d->supplierEmail,
					'cp' => $d->supplierCPHp
				
				);        
			}        
			echo json_encode($supplier);        }
			
	 function suplier_json() {
		header('Content-Type: application/json');
		echo $this->mauto->tampil_suplier_json();
	}
			
	 public function get_tagihan() {      
	
		$kode = strtolower($_GET['term']); 		
		$query = $this->db->from('as_order_transactions')->like('invoiceOrderID',$kode)->get();  
			
			$tagihan       =  array();        
			foreach ($query->result() as $d) {            
				$tagihan[]     = array(           
					'label' => $d->invoiceOrderID,  
					'invoiceOrderID' => $d->invoiceOrderID,
					'trxFullName' => $d->trxFullName,					
					'trxTotal' => $d->trxTotal,
					'trxTerminDate' => $d->trxTerminDate
				
				);        
			}        
			echo json_encode($tagihan);        }

	public function check_faktur_pemb() {
		$identity=$this->session->userdata('identityID');
		$kode = strtolower($_POST['kode']);
		$type = strtolower( $_POST['type'] );
		
		if ( 'faktur' == $type ) {
			$this->db->where('invoiceSupplier', $kode );
		} else {
			$this->db->where('no_dokumen', $kode );
		}
		$count = $this->db->count_all_results('as_buy_transactions');
		$response = array();

		if ( $count > 0 ) {
			$response['success'] = true;
			$response['data'] = sprintf('<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			<h5 class="text-info"><i class="fa fa-exclamation-circle"></i>Notifikasi :</h5> %s</div>', 'No Faktur / No PO sudah digunakan!' );
		} else {
			$response['success'] = false;
			$response['data'] = '';
		}
		echo json_encode($response);    
	}									  
}
 