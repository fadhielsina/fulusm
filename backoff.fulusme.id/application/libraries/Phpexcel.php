<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/phpexcel/PHPExcel.php';
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

class Excel extends Phpexcel {
		
	public function __construct() {
		
	parent::__construct();
		
	}
	
}