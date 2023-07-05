<?php
    $this->load->view('template/header_head_cetak');
    $column_text = $tanggal1;
?>

<div class="row">
	<div class="col-12">
		<img src="<?php echo site_url(); ?>assets/img/logo-smb-left.png" width="200" style="">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Rincian Pembayaran per Bank</h3>
			<p style="text-align: center;"><?php echo 'Per Tgl. ' . $column_text . ' s/d ' . $tanggal2; ?></p>
		</div>
	</div>
</div>

<?php foreach($line1 as $da);?>
<div class="row-mt-0">
    <div class="col-5">
        <h5 style="text-align: left;margin-bottom: 10px;margin-top: 0; margin-left: 25px;"> <?= 'Nama Bank       : ' .$da['nama_bank'];?></h5>
    </div>
</div>
<!--<div class="row-mt-0">
    <div class="col-5">
        <h6 style="text-align: left;margin-bottom: 10px;margin-top: 0; margin-left: 25px;"><?= 'Nama        : ' .$da['grouping'];?></h6>
    </div>
        <div class="col-6"></div>
</div>-->


<table>
	<thead>
		<tr>
        <th class="th-head text-left">Tanggal</th>
        <th class="th-head text-left">No. Dok#</th>
        <th class="th-head text-left">Keterangan Pembayaran</th>
        <th class="th-head text-right">Jumlah</th>
        </tr>
	</thead>

    <tbody>
        <?php
        $nilai_akhir = 0;
        foreach( $data as $d ):
            if ($d['akunid'] !== $akunid) {        
                $nilai= $d['nilai'];            
            $nilai_akhir += $nilai;
		?> 
            <tr><td class="bold head indent"><?php echo $d['nama']; ?></td>
            <td></td><td></td><td></td></tr>
			<tr>
            <td class="indent-1"><?php echo $d['tgl']; ?></td>
            <td class="indent"><?php echo $d['dok']; ?></td>
            <td class="indent"><?php echo $d['keterangan']; ?></td>
            <td class="text-right"><?php echo number_format( $nilai); ?></td>
            </tr>
		<?php } endforeach; ?>
		<tr>
        <td></td><td></td>
        <td></td>
        <td class="bold border-top text-right"><?php echo number_format( $nilai_akhir ); ?></td>
        </tr>
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>