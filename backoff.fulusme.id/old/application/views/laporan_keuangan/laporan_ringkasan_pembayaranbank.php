<?php
    $this->load->view('template/header_head_cetak');
    $column_text = $tanggal1;
?>

<div class="row">
	<div class="col-12">
		<img src="<?php echo site_url(); ?>assets/img/logo-smb-left.png" width="200" style="">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;"><?= $title ;?></h3>
			<p style="text-align: center;"><?php echo 'Per Tgl. ' . $column_text . ' s/d ' . $tanggal2; ?></p>
		</div>
	</div>
</div>
<!--<div class="row-mt-0">
    <div class="col-5">
        <h6 style="text-align: left;margin-bottom: 10px;margin-top: 0; margin-left: 25px;"><?= 'Nama        : ' .$da['grouping'];?></h6>
    </div>
        <div class="col-6"></div>
</div>-->
<div style="  width: 650px;
  margin: auto;">

<style>
table {
  border-collapse: collapse;
}
table, th, td {
  border: 1px solid black;
}
</style>
<table>
	<thead>
		<tr style="background-color: #afeeee;  color: white;">
        <th class="th-head text-left" style="padding: 8px;">Nama Akun Transaksi</th>
        <th class="th-head text-right" style="padding: 8px;">Jumlah</th>
        </tr>
	</thead>

    <tbody> <?php $nilai_akhir = 0; if ($countKB>0){ ?>
        <tr>
            <td class="indent" style="padding: 8px;background-color: #f0f8ff;" colspan="2">Kas Besar</td></tr>
        <?php
        
        $nilai_akhir1 = 0;
        foreach( $data1 as $d1 ):          
            $nilai_akhir1 += $d1['nilai'];            
            ?>
			<tr>
            <td class="indent-2" style="padding: 8px;padding-left: 2em;"><?php echo $d1['nama']; ?></td>
            <td class="text-right" style="padding: 8px;"><?php echo number_format( $d1['nilai']); ?></td>
            </tr>
		<?php  endforeach; ?>
		<tr>
        <td style="padding : 8px;background-color: #dcdcdc;" class="text-right">Jumlah per Akun Transaksi</td>
        <td class="bold border-top text-right" style="padding: 8px;background-color: #dcdcdc;"><?php echo number_format( $nilai_akhir1 ); ?></td>
        </tr>
        <?php $nilai_akhir+=$nilai_akhir1; ?>
        <?php }; if ($countBM>0){ ?>
            <tr>
            <td class="indent" style="padding: 8px;background-color: #f0f8ff;" colspan="2">Bank Mandiri</td></tr>
        <?php
        $nilai_akhir2 = 0;
        foreach( $data2 as $d2 ):          
            $nilai_akhir2 += $d2['nilai'];
            ?> 
			<tr>
            <td class="indent-2" style="padding: 8px;padding-left: 2em;"><?php echo $d2['nama']; ?></td>
            <td class="text-right" style="padding: 8px;"><?php echo number_format( $d2['nilai']); ?></td>
            </tr>
		<?php  endforeach; ?>
		<tr>
        <td style="padding : 8px;background-color: #dcdcdc;" class="text-right">Jumlah per Akun Transaksi</td>
        <td class="bold border-top text-right" style="padding: 8px;background-color: #dcdcdc;"><?php echo number_format( $nilai_akhir2 ); ?></td>
        </tr> 
        <?php $nilai_akhir+=$nilai_akhir2; ?>
        <?php }; if ($countBNI>0){ ?>
            <tr>
            <td class="indent" style="padding: 8px;background-color: #f0f8ff;" colspan="2">BNI</td></tr>
        <?php
        $nilai_akhir3 = 0;
        foreach( $data3 as $d3 ):          
            $nilai_akhir3 += $d3['nilai'];
            ?> 
			<tr>
            <td class="indent-2" style="padding: 8px;padding-left: 2em;"><?php echo $d3['nama']; ?></td>
            <td class="text-right" style="padding: 8px;"><?php echo number_format( $d3['nilai']); ?></td>
            </tr>
		<?php  endforeach; ?>
		<tr>
        <td style="padding : 8px;background-color: #dcdcdc;" class="text-right">Jumlah per Akun Transaksi</td> 
        <td class="bold border-top text-right" style="padding: 8px;background-color: #dcdcdc;"><?php echo number_format( $nilai_akhir3 ); ?></td>
        </tr>
        <?php $nilai_akhir+=$nilai_akhir3; ?>
        <?php }; if ($countBCA>0){ ?>
            <tr>
            <td class="indent" style="padding: 8px;background-color: #f0f8ff;">BCA</td></tr>
        <?php
        $nilai_akhir4 = 0;
        foreach( $data4 as $d4 ):          
            $nilai_akhir4 += $d4['nilai'];
            ?> 
			<tr>
            <td class="indent-2" style="padding: 8px;padding-left: 2em;"><?php echo $d4['nama']; ?></td>
            <td class="text-right" style="padding: 8px;"><?php echo number_format( $d4['nilai']); ?></td>
            </tr>
		<?php  endforeach; ?>
		<tr>
        <td style="padding : 8px;background-color: #dcdcdc;" class="text-right">Jumlah per Akun Transaksi</td> 
        <td class="bold border-top text-right" style="padding: 8px;background-color: #dcdcdc;"><?php echo number_format( $nilai_akhir4 ); ?></td>
        </tr> <?php $nilai_akhir+=$nilai_akhir4; };?>
		<tr style="background-color: #dcdcdc;">
        <td class="indent" style="padding: 8px;">Total Kas/Bank</td> 
        <td class="bold border-top text-right" style="padding: 8px;"><?php echo number_format( $nilai_akhir ); ?></td>
        </tr>
	</tbody>
</table>
</div>

<?php  $this->load->view("template/footer_admin_cetak"); ?>