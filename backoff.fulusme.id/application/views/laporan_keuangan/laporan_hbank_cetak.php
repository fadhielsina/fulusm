<?php
    $this->load->view('template/header_head_cetak');
    $column_text = $tanggal1;
?>

<div class="row">
	<div class="col-12">
		<img src="<?php echo site_url(); ?>assets/img/logo-smb-left.png" width="200" style="">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Histori Bank</h3>
			<p style="text-align: center;"><?php echo 'Per Tgl. ' . $column_text . ' s/d ' . $tanggal2; ?></p>
		</div>
	</div>
</div>

<?php foreach($kop as $da);?>
<div class="row-mt-0">
    <div class="col-5">
        <h6 style="text-align: left;margin-bottom: 0;margin-top: 0; margin-left: 25px;"> <?= 'Kode       : ' .$da['kode'];?></h6>
    </div>
    <div class="col-5">
        <h6 style="text-align: right;margin-bottom: 0;margin-top: 0; margin-right: 25px;"><?= 'Saldo Awal     : ' ;?><?= number_format($da['saldo_awal']);?></h6>
    </div>
</div>
<div class="row-mt-0">
    <div class="col-5">
        <h6 style="text-align: left;margin-bottom: 10px;margin-top: 0; margin-left: 25px;"><?= 'Nama        : ' .$da['grouping'];?></h6>
    </div>
        <div class="col-6"></div>
</div>


<table>
	<thead>
		<tr>
        <th class="th-head text-left">Tanggal</th>
        <th class="th-head text-left">No. Invoice#</th>
        <th class="th-head text-left">No.</th>
        <th class="th-head text-left">Keterangan</th>
        <th class="th-head text-right">Debit</th>
        <th class="th-head text-right">Kredit</th>
        <th class="th-head text-right">Saldo Akhir</th>
        </tr>
	</thead>

    <tbody>
        <?php $saldoa = 0;
        foreach( $s_akhir as $a):
         $saldoa +=  $a['tambah'] - $a['kurang'];?>
        <?php endforeach;?>
        <tr><td></td><td></td><td></td>
        <td>Saldo Akhir</td><td></td><td></td>
        <td class="text-right"><?php echo number_format( $saldoa ); ?></td></tr>
		<?php
        $debit = 0;
        $kredit = 0;
		foreach( $data as $d ):
			$saldoa +=  $d['debit'] - $d['kredit'] ;
            $debit += $d['debit'];
            $kredit += $d['kredit'];
		?>
			<tr>
            <td class="indent"><?php echo $d['tgl']; ?></td>
            <td class="indent"><?php echo $d['invoice_no']; ?></td>
            <td class="indent"><?php echo $d['NO']; ?></td>
            <td class="indent"><?php echo $d['keterangan']; ?></td>
            <td class="text-right"><?php echo number_format( $d['debit']); ?></td>
            <td class="text-right"><?php echo number_format( $d['kredit'] ); ?></td>
            <td class="text-right"><?php echo number_format( $saldoa ); ?></td>
            </tr>
		<?php endforeach; ?>
		<tr>
        <td></td><td></td><td></td>
        <td></td>
        <td class="bold border-top text-right"><?php echo number_format( $debit ); ?></td>
        <td class="bold border-top text-right"><?php echo number_format( $kredit ); ?></td>
        <td></td>
        </tr>
	</tbody>



</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>