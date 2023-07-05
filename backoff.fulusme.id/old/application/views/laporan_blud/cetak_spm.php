<?php
//$this->load->view('template/header_head');
?>

<style>
table td{
    padding: 0px;
}    
.tbl_border td{
    border: solid 1px #000000 !important;
    padding: 2px 1px;
    border-collapse: separate;
}
.tbl_no_border td{
    border: solid 0px #000000;
    padding-left: 5px;
    text-align: left;
}
</style>
</head>
<body>
<div class="row">
<div class="col-md-12 text-center mx-auto">
<table  width="700px" style="text-align: center;margin:20px auto" align="center" class="tbl_no_border">
	<tr>
            <td colspan="4" style="text-align: center"> 
                    <h3>SURAT PERINTAH MEMBAYAR<br>
                    TAHUN ANGGARAN 2019<br>
                    Katingan<br>
                    RSUD Mas Amsyar Kasongan</h3>
                    <hr>
            </td>
	</tr>
	<tr>
		
		<td colspan="2" style="text-align: left"><h4>NO SPM : <?php echo $procurement['noSpm']?></h4></td>
        <td  colspan="2" style="text-align: center"></td>
	</tr>
	<tr>
		<td  colspan="2" style="text-align: left;border: 1px solid #000000 !important">
			<h4>Pimpinan BLUD RSUD Mas Amsyar Kasongan
				<br><br>
				Memerintahkan<br>
				Supaya Membayarkan Kepada<br>
				Bendahara Pengeluaran/Pihak Ketiga   :<br>
				</h4>
                <table class="tbl_no_border" style="border: 0px;text-align: left" border="0">
					<tr>
						<td colspan="3"><?php echo $procurement['supplierName']?></td>
					</tr>
					<tr>
                        <td width="30%"><b>Bank</b></td>
                        <td  width="10%">:</td>
                        <td  width="60%"><?php echo $procurement['supplierBankname']?></td>
					</tr>
					<tr>
                        <td ><b>Nomor Rekenig</b></td>
                        <td>:</td>
                        <td><?php echo $procurement['supplierBankid']?></td>
					</tr>
					<tr>
                        <td><b>NPWP</b></td>
                        <td>:</td>
                        <td><?php echo $procurement['supplierNPWP']?></td>
					</tr>
					<tr>
                        <td colspan="3"><b>Untuk Keperluan</b></td>
					</tr>
                    <tr>
                       <td colspan="3">  <?php  echo $procurement['uraianSpp']."  <br>".$procurement['supplierName']." <br>(".$procurement['supplierContactPerson'].")"?> <br> dengan rincian terlampir.</td>
					</tr>
				</table> 
			</h4>

		</td>
		<td colspan="2" style="text-align: left;padding:0px" >
                    <table class="tbl_border" width="100%">
                        <tr>
                            <td colspan="3"><b>Informasi :</b> <br>(tidak mengurangi Jumlah SPM)</td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>Uraian</td>
                            <td>Jumlah</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Iuran Wajib PNS</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Tabungan Perumahan</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Jumlah</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>POTONGAN</b></td>
                        </tr>
                        <tr>
                            <td>No </td>
                            <td>Uraian</td>
                            <td>Jumlah</td>
                        </tr>
                        <?php
                        $jumlah = 0;
                        foreach($pajakData as $index=>$item){
                            echo ' <tr>
                            <td> </td>
                            <td>'.$index.'</td>
                            <td>'. number_format((double)$item).'</td>
                        </tr>';
                            $jumlah +=(double)$item;
                        }
                        $diBayarkan =  $procurement['total_purchases']-$jumlah;
                        ?>
                        <tr>
                            <td> </td>
                            <td><b>Jumlah</b></td>
                            <td><?php echo number_format($jumlah) ?></td>
                        </tr>
                    </table>
                </td>
	</tr>
        <tr class="tbl_border text-left">
            <td colspan="4"><h4>Pembebanan Pada Kode Rekening</h4></td>
	</tr>
	<tr class="tbl_border">
		<td><?php echo $aktif_anggaran['id_mata_anggaran'] ?></td>
		<td><?php echo $aktif_anggaran['mata_anggaran'] ?></td>
		<td>Rp</td>
		<td><?php echo number_format($procurement['total_purchases']) ?></td>
	</tr>
	<tr class="tbl_border">
		<td></td>
		<td align="right"><b>Jumlah</b></td>
		<td>Rp</td>
		<td><?php echo number_format($procurement['total_purchases'])?></td>
	</tr>
        <tr class="tbl_no_border">
		<td ></td>
		<td align="right"><b>Jumlah Dibayar</b></td>
		<td>Rp</td>
                <td><?php echo number_format((double)($diBayarkan));?></td>
	</tr>
        <tr class="tbl_no_border">
		<td></td>
		<td align="right"><b>Terbilang</b></td>
		<td></td>
		<td></td>
	</tr>
        <tr class="tbl_no_border">
		<td></td>
		<td colspan="3" align="right"><b><?php echo terbilang($diBayarkan) ?></b></td>
	</tr>
</table>
</div>
</div>

</body>
</html>