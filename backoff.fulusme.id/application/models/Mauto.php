<?php

class Mauto extends CI_Model {

    var $tabel = 'as_members';   //variabel tabelnya

	  var $table = 'as_products';

    var $column_order = array('productBarcode','productName','productImei',null); //set column field database for datatable orderable

    var $column_search = array('productBarcode','productName','productImei'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('productID' => 'desc'); // default order 

    function __construct() {

        parent::__construct();

    }

 

    //fungsi untuk menampilkan semua data dari tabel database

    function get_produk($kode,$identity) {

        $this->db->select('*')->from('as_products');
		$this->db->join('products_stok', 'products_stok.productBarcode = as_products.productBarcode', 'left'); 

        $this->db->like('as_products.productBarcode',$kode,'after');

        $this->db->or_like('as_products.productName',$kode,'after');

        $this->db->or_like('as_products.productShortcut',$kode,'after');
		$this->db->limit(10);

        $query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }



    function get_bahan($kode) {

         $this->db->select('*')->from('as_bahan');
		
        $this->db->like('bahanBarcode',$kode,'after');

        $this->db->or_like('bahanName',$kode,'after');
		$this->db->limit(10);

        $query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }

	  function member_list(){
        $hasil=$this->db->query("SELECT * FROM as_members");
        return $hasil->result();
    }

	 function get_member($kode) {

         $this->db->select('*')->from('as_members');

        $this->db->like('memberCode',$kode,'after');

		$this->db->or_like('memberFullName',$kode,'after');
		$this->db->limit(15);

		$query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }

    function get_akun($kode) {

         $this->db->select('*')->from('akun');

        $this->db->like('kode',$kode,'after');

        $this->db->or_like('nama',$kode,'after');
        $this->db->limit(15);

        $query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }
	
	 function get_vehicles($kode) {

         $this->db->select('*')->from('as_vehicle_type');

        $this->db->like('merk',$kode,'after');

		$this->db->or_like('type',$kode,'after');
		$this->db->limit(15);

		$query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }
	
	
	

	function get_proyek($kode) {

         $this->db->select('*')->from('as_proyek');

        $this->db->like('proyekCode',$kode,'after');

		$this->db->or_like('proyekFullName',$kode,'after');

		$query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }

	

	

	private function _get_datatables_query()

    {

         

        $this->db->from($this->table);

 

        $i = 0;

     

        foreach ($this->column_search as $item) // loop column 

        {

            if($_POST['search']['value']) // if datatable send POST for search

            {

                 

                if($i===0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                }

                else

                {

                    $this->db->or_like($item, $_POST['search']['value']);

                }

 

                if(count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

         

        if(isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } 

        else if(isset($this->order))

        {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

	

	 function get_datatables($kode) {

         $this->db->select('*')->from('as_members');

        $this->db->like('memberCode',$kode,'after');

		$this->db->or_like('memberFullName',$kode,'after');

		$query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }
	
	
	 function tampil_suplier_json() {
        $this->datatables->select('*');
        $this->datatables->from('as_suppliers');
        $this->datatables->add_column('view', '<a href="admin/edit_suplier/$1">edit</a> | <a href="admin/hapus_suplier/$1">delete</a>', 'supplierID');
        return $this->datatables->generate();
    }

    function get_vendor($kode) {

         $this->db->select('*')->from('as_suppliers');

        $this->db->like('supplierCode',$kode,'after');

        $this->db->or_like('supplierName',$kode,'after');
        $this->db->limit(15);

        $query = $this->db->get();

        //cek apakah ada data

        if ($query->num_rows() > 0) { //jika ada maka jalankan

            return $query->result();

        }

    }
	
		function get_aset_debt_ajx($id_supp) {
		$this->db->select('as_buy_transactions .*');
		$this->db->select('as_suppliers.*');
		$this->db->select('sum(as_debts_payment.debtPay) as totalbyr ');
		$this->db->from('as_buy_transactions');
		$this->db->join('as_debts', 'as_debts.invoiceID=as_buy_transactions.invoiceBuyID', 'LEFT');
		$this->db->join('as_debts_payment', 'as_debts_payment.debtID=as_debts.debtID', 'LEFT');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID=as_buy_transactions.supplierID', 'LEFT');
		$this->db->where('as_buy_transactions.supplierID', $id_supp);
		$this->db->group_by('as_buy_transactions.trxID', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_vendor_ajx($id_supp) {
		$this->db->select('as_order_transactions .*');
		$this->db->select('as_suppliers.*');
		$this->db->select('sum(as_debts_payment.debtPay) as totalbyr ');
		$this->db->from('as_order_transactions');
		$this->db->join('as_debts', 'as_debts.invoiceID=as_order_transactions.invoiceOrderID', 'LEFT');
		$this->db->join('as_debts_payment', 'as_debts_payment.debtID=as_debts.debtID', 'LEFT');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID=as_order_transactions.supplierID', 'LEFT');
		$this->db->where('as_order_transactions.supplierID', $id_supp);
		$this->db->group_by('as_order_transactions.trxID', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

function get_vendor_saldo_ajx($id_supp) {
		$this->db->select('as_order_transactions .*');
		$this->db->select('as_suppliers.*');
		$this->db->select('sum(as_debts_payment.debtPay) as totalbyr ');
		$this->db->from('as_order_transactions');
		$this->db->join('as_debts', 'as_debts.invoiceID=as_order_transactions.invoiceOrderID', 'LEFT');
		$this->db->join('as_debts_payment', 'as_debts_payment.debtID=as_debts.debtID', 'LEFT');
		$this->db->join('as_suppliers', 'as_suppliers.supplierID=as_order_transactions.supplierID', 'LEFT');
		$this->db->where('as_order_transactions.supplierID', $id_supp);
		$this->db->group_by('as_order_transactions.trxID', 'desc');
		$query = $this->db->get();
		return $query->result();
}



function get_debt_pay_ajx($id_supp) {
    $this->db->select('as_debts.invoiceID');
		$this->db->select('as_debts_payment.*');
		$this->db->select('as_order_transactions .*');
		$this->db->from('as_debts_payment');
		$this->db->join('as_debts', 'as_debts.debtID=as_debts_payment.debtID', 'LEFT');
		$this->db->join('as_order_transactions', 'as_order_transactions.invoiceOrderID=as_debts.invoiceID', 'LEFT');
		$this->db->where('as_order_transactions.supplierID', $id_supp);
		$query = $this->db->get();
		return $query->result();
}


function get_recv_pay_ajx($id_mem) {
		$this->db->select('as_receivables_payment.*');
		$this->db->select('as_sales_transactions .*');
		$this->db->from('as_receivables_payment');
		$this->db->join('as_receivables', 'as_receivables.receivableID=as_receivables_payment.receivableID', 'LEFT');
		$this->db->join('as_sales_transactions', 'as_sales_transactions.invoiceID=as_receivables.invoiceID', 'LEFT');
		$this->db->where('as_sales_transactions.memberID', $id_mem);
		$query = $this->db->get();
		return $query->result();
}

	function ajax_get_vendor_by_id($id){
        $hsl=$this->db->query("SELECT a.*,b.*, sum(c.debtPay) as totalbyr FROM as_order_transactions a left join as_debts b on a.invoiceOrderID=b.invoiceID left join as_debts_payment c on b.debtID=c.debtID WHERE a.trxID='$id'");
        if($hsl->num_rows()>0){
            foreach ($hsl->result() as $data) {
                $hasil=array(
                    'trxTotal' => $data->trxTotal,
                    'invoiceID'=>$data->invoiceID,
                    'note' => $data->note,
					'totalbyr' => $data->totalbyr,
					'debtID' => $data->debtID,
                    );
            }
        }
        return $hasil;
    }
	
	
	function ajax_get_aset_debt_by_id($id){
        $hsl=$this->db->query("SELECT a.*,b.*, sum(c.debtPay) as totalbyr FROM as_buy_transactions a left join as_debts b on a.invoiceBuyID=b.invoiceID left join as_debts_payment c on b.debtID=c.debtID WHERE a.trxID='$id'");
        if($hsl->num_rows()>0){
            foreach ($hsl->result() as $data) {
                $hasil=array(
                    'trxTotal' => $data->trxTotal,
                    'invoiceID'=>$data->invoiceID,
                    'note' => $data->note,
					'totalbyr' => $data->totalbyr,
					'debtID' => $data->debtID,
                    );
            }
        }
        return $hasil;
    }
	
	
	function get_cus_ajx($id_supp) {
		$this->db->select('as_sales_transactions .*');
		$this->db->select('as_receivables .*');
		$this->db->select('as_members.*');
		$this->db->select('sum(as_receivables_payment.receivablePay) as totalbyr ');
		$this->db->from('as_sales_transactions');
		$this->db->join('as_receivables', 'as_receivables.invoiceID=as_sales_transactions.invoiceID', 'LEFT');
		$this->db->join('as_receivables_payment', 'as_receivables_payment.receivableID=as_receivables.receivableID', 'LEFT');
		$this->db->join('as_members', 'as_members.memberID=as_sales_transactions.memberID', 'LEFT');
		$this->db->where('as_sales_transactions.memberID', $id_supp);
		$this->db->group_by('as_sales_transactions.trxID', 'desc');
		$query = $this->db->get();
		return $query->result();
}
	
	function ajax_get_cus_by_id($id){
        $hsl=$this->db->query("SELECT a.*,b.receivableID, sum(c.receivablePay) as totalbyr FROM as_sales_transactions a left join as_receivables b on a.invoiceID=b.invoiceID left join as_receivables_payment c on b.receivableID=c.receivableID WHERE a.trxID='$id'");
        if($hsl->num_rows()>0){
            foreach ($hsl->result() as $data) {
                $hasil=array(
                    'trxTotal' => $data->trxTotal,
                    'note' => $data->note,
					'totalbyr' => $data->totalbyr,
					'receivableID' => $data->receivableID,
                    );
            }
        }
        return $hasil;
    }

}

?>