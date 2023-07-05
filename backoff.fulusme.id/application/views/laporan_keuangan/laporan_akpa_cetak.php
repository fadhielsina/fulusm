<?php
    $this->load->view('template/header_head_cetak');
    $column_text = $tanggal1;
?>

<div class="row">
	<div class="col-12">
		<img src="<?php echo site_url(); ?>assets/img/logo-smb-left.png" width="200" style="">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Arus Kas per Akun</h3>
			<p style="text-align: center;"><?php echo 'Per Tgl. ' . $column_text . ' s/d ' . $tanggal2; ?></p>
		</div>
	</div>
</div>


<table>
	<thead>
		<tr>
        <th class="th-head text-left">Tanggal</th>
        <th class="th-head text-left">Tipe Transaksi</th>
        <th class="th-head text-left">No. Invoice#</th>
        <th class="th-head text-left">Keterangan</th>
        <th class="th-head text-right">Nilai (Domestik)</th>
        </tr>
	</thead>

    <tbody>
        <?php foreach($line1 as $da);?>
        <tr><td class="bold td-head indent"><?php echo $da['nama_bank']; ?></td><td></td><td></td><td></td><td></td></tr>
		<?php
        $nilai_akhir = 0;
        foreach( $data as $d ):
            if ($d['akunid'] !== $akunid) {
            if( $d['dk']=='0'){
                $nilai=$d['nilai'];
            } else {
                $nilai= -$d['nilai'];
            }
            $nilai_akhir += $nilai;
		?> 
            <tr><td class="bold head indent-1"><?php echo $d['nama']; ?></td>
            <td></td><td></td><td></td><td></td></tr>
			<tr>
            <td class="indent-2"><?php echo $d['tgl']; ?></td>
            <td class="indent-2"><?php echo $d['tipe_transaksi']; ?></td>
            <td class="indent-2"><?php echo $d['invoice_no']; ?></td>
            <td class="indent-2"><?php echo $d['keterangan']; ?></td>
            <td class="text-right"><?php echo number_format( $nilai); ?></td>
            </tr>      
		<?php }  endforeach; ?>
		<tr>
        <td></td><td></td><td></td>
        <td></td>
        <td class="bold border-top text-right"><?php echo number_format( $nilai_akhir ); ?></td>
        </tr>
	</tbody>



</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>