<?php

class Spk_model extends CI_Model {

    var $tabel = 'as_members';   //variabel tabelnya

    

    function __construct() {

        parent::__construct();

    }

    

    function get_all_spk() {
        $this->datatables->select('invoiceID');
        $this->datatables->select('car_merk');
        $this->datatables->select('car_year');
        $this->datatables->select('nopol');
        $this->datatables->select('chasis_no');
        $this->datatables->select('engine_no');
        $this->datatables->select('sts_proses');
        $this->datatables->select('sts_cek_stock');
        $this->datatables->select('memberID');
        $this->datatables->select('vehicleID');
        $this->datatables->from('as_spk_transactions');
        $this->db->order_by('trxID DESC');
        $this->datatables->add_column('view', '<a class="btn btn-xs btn-info btn-flat" href="'.base_url().'spk/edit_spk/$1/$2/$3"><i class="fa fa-arrow-circle-right"></i></a>', 'memberID, vehicleID, invoiceID');
        return $this->datatables->generate();
    }


   function get_all_cek_stock() {
        $this->datatables->select('invoiceID');
        $this->datatables->select('car_merk');
        $this->datatables->select('car_year');
        $this->datatables->select('nopol');
        $this->datatables->select('chasis_no');
        $this->datatables->select('engine_no');
        $this->datatables->select('sts_proses');
        $this->datatables->select('sts_cek_stock');
        $this->datatables->select('memberID');
        $this->datatables->select('vehicleID');
        $this->datatables->from('as_spk_transactions');
         $this->db->order_by('trxID DESC');
        $this->datatables->where("sts_proses = '1' ");
        $this->datatables->add_column('view', '<a class="btn btn-xs btn-info btn-flat" href="'.base_url().'spk/cek_stok/$1/$2/$3"><i class="fa fa-arrow-circle-right"></i></a>', 'memberID, vehicleID, invoiceID');
        return $this->datatables->generate();
    }
	
	function get_all_sales() {
        $this->db->select('*');
        $this->db->from('as_sales_transactions');
        $this->db->order_by('trxID DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

     public function get_sales_vehicle($vehicleID)
    {
       $query = $this->db->query("SELECT a.*  FROM as_sales_transactions as a WHERE a.vehicleID = '".$vehicleID."' ");
        return  $query->result();
    }

    public function get_sales_detail($invoiceID)
    {
       $query = $this->db->query("SELECT *  FROM as_sales_detail_transactions as a 
    LEFT JOIN as_products as c on c.productBarcode = a.productBarcode
        WHERE a.invoiceID = '".$invoiceID."' ");
        return  $query->result();
    }

public function get_spk_detail($invoiceID)
    {
       $query = $this->db->query("SELECT a.*  FROM as_spk_detail_transactions as a WHERE a.invoiceID = '".$invoiceID."' ");
        return  $query->result();
    }
	
	public function get_spk_detail_off($invoiceID)
    {
       $query = $this->db->query("SELECT a.*  FROM as_spk_detail_transactions as a WHERE a.ready_stock !='on' and a.invoiceID = '".$invoiceID."'");
        return  $query->result();
    }


    function insert_spk_to_sales($invoiceID, $invSales){
        return $this->db->query("
INSERT INTO as_sales_transactions ( 
memberID, vehicleID, trxTerminDate, invoiceID, invoiceIDmanual, trxFullName, trxAddress, trxPhone, trxTime, trxDate, trxTotalModal, trxSparepartTotal, trxJasaTotal, trxInstalasiTotal, trxSubtotal, trxDiscount, trxPPN, trxTotal,trxPay, trxChange, trxStatus, trxsales, trxdriver, trxcarseries, trxcartype, trxcarno, trxbankmethod, trxbankmember, trxbanknorek, trxbankedc, trxbankadmin, trxzone, trxnopo, createdDate, createdUserID, modifiedDate, modifiedUserID, isPosting_status, isProyek, proyekid, identityID, trxInDate, trxOutDate, kilometer, note, isfinish, is_update, is_pending, userID, userSTS, is_publish, car_merk, car_year,  engine_no, chasis_no, nopol )
    SELECT 
    memberID, vehicleID, trxTerminDate, '".$invSales."', invoiceIDmanual, trxFullName, trxAddress, trxPhone, trxTime, trxDate, trxTotalModal, trxSparepartTotal, trxJasaTotal, trxInstalasiTotal, trxSubtotal, trxDiscount, trxPPN, trxTotal, trxPay, trxChange, trxStatus, trxsales, trxdriver, trxcarseries, trxcartype, nopol, trxbankmethod, trxbankmember, trxbanknorek, trxbankedc, trxbankadmin, trxzone, trxnopo, createdDate, createdUserID, modifiedDate, modifiedUserID, isPosting_status, isProyek, proyekid, identityID, trxInDate, trxOutDate, kilometer, note, isfinish, is_update, is_pending, userID, userSTS, is_publish, car_merk,car_year,  engine_no, chasis_no, nopol
    FROM   as_spk_transactions
    WHERE  invoiceID = '".$invoiceID."'
            ");
    }

     function insert_spk_to_sales_detail($detailID, $invSales){
        return $this->db->query("
INSERT INTO as_sales_detail_transactions ( detailID, productShortcut, invoiceID, productBarcode, productSat, detailModal, detailSubtotalModal, detailPrice, detailQty, detailbonus ,note, discPercent, discTotal, detailSubtotal, ispromocheck, createdDate, createdUserId, modifiedDate, isfinish ,modifiedUserID
 )
    SELECT 
    detailID, productShortcut, '".$invSales."', productBarcode, productSat, detailModal, detailSubtotalModal, detailPrice, detailQty, detailbonus ,note, discPercent, discTotal, detailSubtotal, ispromocheck, createdDate, createdUserId, modifiedDate, isfinish ,modifiedUserID
    FROM   as_spk_detail_transactions
    WHERE  detailID = '".$detailID."'
            ");
    }

}

?>