<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
  	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

	function penyebutEnglish($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "twelf");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebutEnglish($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebutEnglish($nilai/10)."ti". penyebutEnglish($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " hundred" . penyebutEnglish($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebutEnglish($nilai/100) . " hundred" . penyebutEnglish($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " thousand" . penyebutEnglish($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebutEnglish($nilai/1000) . " thousand" . penyebutEnglish($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebutEnglish($nilai/1000000) . " million" . penyebutEnglish($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebutEnglish($nilai/1000000000) . " billion" . penyebutEnglish(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebutEnglish($nilai/1000000000000) . " trillion" . penyebutEnglish(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		$active = get_cookie('my_lang');
		if($active =="english"){
			if($nilai<0) {
				$hasil = "minus ". trim(penyebutEnglish($nilai));
			} else {
				$hasil = trim(penyebutEnglish($nilai));
			}     
			return ucwords($hasil)." Dollar";
		}else{
			if($nilai<0) {
				$hasil = "minus ". trim(penyebut($nilai));
			} else {
				$hasil = trim(penyebut($nilai));
			}     
			return ucwords($hasil)." Rupiah";
		}		
		
	}
	
	function terbilang_lot($nilai)
    {
    	$active = get_cookie('my_lang');
    	if ($active == "english") {
    		if ($nilai < 0) {
    			$hasil = "minus " . trim(penyebutEnglish($nilai));
    		} else {
    			$hasil = trim(penyebutEnglish($nilai));
    		}
    		return ucwords($hasil) . "";
    	} else {
    		if ($nilai < 0) {
    			$hasil = "minus " . trim(penyebut($nilai));
    		} else {
    			$hasil = trim(penyebut($nilai));
    		}
    		return ucwords($hasil) . "";
    	}
    }


 