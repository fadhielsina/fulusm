<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  DOMPDF
* 
* Author: Jd Fiscus
* 	 	  jdfiscus@gmail.com
*         @iamfiscus
*          
*
* Origin API Class: http://code.google.com/p/dompdf/
* 
* Location: http://github.com/iamfiscus/Codeigniter-DOMPDF/
*          
* Created:  06.22.2010 
* 
* Description:  This is a Codeigniter library which allows you to convert HTML to PDF with the DOMPDF library
* 
*/
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Dompdf_gen {
		
	public function __construct() {
		
		//require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';
		
		$pdf = new DOMPDF();
		
		$CI =& get_instance();
		$CI->dompdf = $pdf;
		
	}

	public function pdf_schedule_create($ReportName,$date,$table){
		$style = "<style> 
		 		h1 { 
		 			color: #000; 
		 			font-family: times; 
		 			font-size: 20px;
		 			text-align:center; 
		 			margin:0px;  
		 		}
		 		h5 { 
		 			color: #000; 
		 			font-family: times; 
		 			font-size: 14px;
		 			text-align:center;
		 			margin:0px  ;
		 		}
		 		.tableNoBorder td { white-space: wrap; font-size:10px;border:0px #fff00 solid;padding;0px;margin:0px; }
		 		table {
				border-collapse: collapse;
				}
				table td { white-space: wrap; font-size:10px;border:1px #fff00 solid;padding;0px;margin:0px; }
				table tr{border:1px #fff00 solid;padding;0px;margin:0px;}
				table th {background-color:#d0c9c9;}
				</style> 
		 		";
       
		
		
		$date = nice_date($date,"M Y");
		$header = "<table border='0px' width='100%' align='center' class='tableNoBorder'>
				<tr>
					<td colspan='3' style='text-align:center'>
					<h1 >PEMERINTAH KABUPATEN KATINGAN<br>
					BADAN LAYANAN UMUM DAERAH<br>
					RUMAH SAKIT UMUM DAERAH MAS AMSYAR KASONGAN
					</h1><br>
					Jl. Rumah Sakit No.01 Kasongan<br>
					Telp. (0536) 4041041  Fax. (0536) 4041041<br><br>
					<h5>LEMBAR KONSULTASI / VERIFIKASI<br>
					ABSEN SIDIK JARI PNS</h5>
					</td>
				</tr>
				<tr>
					<td width='100px'>RUANG</td>
					<td width='10px'>:</td>
					<td > </td>
				</tr>
				<tr>
					<td width='100px'>BULAN</td>
					<td >:</td>
					<td > </td>
				</tr>	
				</table>
				<hr><br><br><br>
			";
		$tbl =  ($table); //get table data
		$footer = "<table border='0px' width='100%' align='center' class='tableNoBorder'>
				<tr>
					<td>
						Keterangan :<br>
						P	=	Dinas Pagi			Pukul 07.00 s/d 14.00 WIB	<br>		
						S	=	Dinas Sore			Pukul 14.00 s/d 20.00 WIB	<br>		
						M	=	Dinas Malam			Pukul 20.00 s/d 07.00 WIB	<br>	

					</td>
					<td colspan='2' style='text-align:center'>
					Mengetahui :<br>
					Kepala Seksi
					</td>
				</tr>
				</table>";
		$GenerateHTML = $style." ".$header." ".$tbl." ".$footer;

		//die($GenerateHTML);
		$dompdf = new DomPdfLib();

		$dompdf->loadHtml($GenerateHTML);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->set_option('defaultFont', 'Courier');

		// Render the HTML as PDF
		$dompdf->render();
		
    	

		$fname = $ReportName;
		$pay_month = strtolower(date("F_Y"));
		$output = $dompdf->output();
		$generate = file_put_contents(FCPATH.'/generated/'.$fname.'_'.$pay_month.'.pdf', $output);
		//$generate = $dompdf->Output(FCPATH.'/generated/'.$fname.'_'.$pay_month.'.pdf', 'F');
		
		//var_dump($generate);
		if($generate){
			$respon  = array("message"=>"","data"=>base_url('/generated/'.$fname.'_'.$pay_month.'.pdf'),"error"=>"0");
		}else{
			$respon  = array("message"=>"","data"=>"","error"=>"1");
		}
		return json_encode($respon);
	}
	
}