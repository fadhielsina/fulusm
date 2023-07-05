<?php
//$this->load->view('template/header_head');
?>
<style>
h2{
	font-size: 20px;
	margin: 3px 2px;
}
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
	<table border="0" width="90%" align="center" style="text-align: center">
		<tr>
			<td colspan="4"><h2>Katingan</h2></td>
		</tr>
		<tr>
			<td colspan="4"><h2>RSUD Mas Amsyar Kasongan </h2></td>
		</tr>
		<tr>
			<td colspan="4"><h2>Surat Permintaan Pembayaran</h2></td>
		</tr>
		<tr>
			<td colspan="4"><h2>(SPP)</h2></td>
		</tr>
		<tr>
			<td colspan="4"><h4>No SPP : <?php echo $procurement['noSpp'] ?></h4>
			<hr>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="text-align: left">
				<table border="0" width="100%" style="text-align: left" >
				<tr style="text-align: left">
						<td colspan="4">
							Kepada Yth, <br><strong>Pimpinan BLUD RSUD Mas Amyar Kasongan</strong> <br>Di Kasongan
						</td>
					</tr>
				<tr style="text-align: left">
						<td colspan="4">
							Dengan memperhatikan Rencana Bisnis Anggaran/DPA RSUD Mas Amsyar Kasongan,<br> Bersama ini kami mengajukan Surat Permintaan Pembayaran <br>Kegiatan BLUD sebagai berikut :
						</td>
					</tr>
				<tr style="text-align: left">
						<td width="10%">a. </td>
						<td  width="20%">jumlah Pembayaran Yang Diminta</td>
						<td  width="40%">: Rp. <?php echo number_format($procurement['total_purchases']) ?></td>
						<td  width="30%"> </td>
					</tr>
				<tr>
						<td style="text-align: left"> </td>
						<td>Terbilang</td>
						<td>: <?php echo ucwords(penyebut($procurement['total_purchases'])) ?> Rupiah</td>
						<td style="text-align: left"></td>
					</tr>
				<tr>
						<td>b. </td>
						<td>Untuk Keperluan</td>
						<td colspan="2">: <?php echo ucwords($procurement['uraianSpp']) ?></td>
						
					</tr>
				<tr>
						<td>c. </td>
						<td>Mata Anggaran</td>
						<td>:</td>
						<td></td>
					</tr>
				<tr>
					<td colspan="4" style="text-align: left">
						<table border="1px" width="90%" align="center" style="text-align: center">
							<tr>
								<td>Kode Rek</td>
								<td>Mata Anggaran</td>
								<td>Jumlah</td>
							</tr>
							<tr>
								<td><?php echo $procurement['id_anggaran']; ?></td>
								<td><?php echo $procurement['mata_anggaran']; ?></td>
								<td><?php echo number_format($procurement['total_purchases']) ?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>d. </td>
					<td>Nama Penerima</td>
					<td colspan="2">: <?php echo $procurement['supplierName'] ?></td>
				</tr>
				<tr >
					<td>e. </td>
					<td>Nama Bank</td>
					<td colspan="2">: <?php echo $procurement['supplierBankname'] ?></td>
				</tr>
				<tr >
					<td>f. </td>
					<td>No Rekening</td>
					<td colspan="2">: <?php echo $procurement['supplierBankid'] ?></td>
				</tr>
				<tr >
					<td>g. </td>
					<td>NPWP</td>
					<td colspan="2">: <?php echo $procurement['supplierNPWP'] ?></td>
				</tr>
				</table>
				</td>
			</tr>
			<tr style="text-align: left">
				<td colspan="4"><br>
					<br>
					<br>
					<br>Kasongan, <?php echo nice_date($procurement['dateSpp'],"d-M-Y"); ?>
				<br>
				<br></td>
			</tr>
			<tr>
				<td>Pejabat Teknis BLUD</td>
				<td></td>
				<td>BENDAHARA PENGELUARAN BLUD</td>
				<td></td>
			</tr>
			<tr>
				<td><br><br><br><br><br>
				<?php echo  $procurement['nama_pptk']; ?>	<br>
				NIP : <?php echo  $procurement['nip_pptk']; ?></td>
				<td></td>
				<td><br><br><br><br><br>
				<?php echo  $procurement['nama_bendahara']; ?><br>
				NIP : <?php echo  $procurement['nip_bendahara']; ?> </td>
				<td></td>
			</tr>

		</table>
</body>
</html>