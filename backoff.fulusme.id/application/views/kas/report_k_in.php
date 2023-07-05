<br/>
<div class="post-title col-lg-12"><h3 class="pull-left"><?php echo $title; ?></h3>
</div>
<br/><br/>
		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	$saldoAwal = (isset($kas_data_last['jumlah_last'])?$kas_data_last['jumlah_last']:0);	
?>		
	</div>
	<div class="col-lg-12">
  <div class="card">
  	<div class="card-header">
		<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
		    <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area'));"><i class="mdi mdi-printer"></i></button>
		    <button type="button" class="btn btn-secondary"  onClick="excelTable($('#report_area'));"><i class="mdi mdi-file-excel"></i></button>
		    <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area'));"><i class="mdi mdi-file-pdf"></i></button> 
		</div>
		</div>
	</div>	
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	 <div class="table-responsive m-t-5"  style="background-color:#767779;padding: 10px; ">
    <table id="report_area" class="table display table-bordered table-striped"  style="background-color:white; ">
		<thead>
			<tr>
				<th><?= $this->lang->line('tanggal') ?></th>
				<th>No.Trx</th>
				<th><?= $this->lang->line('keterangan') ?></th>
				<th><?= $this->lang->line('diterima') ?></th>
				<th><?= $this->lang->line('disetor') ?></th>
				<th><?= $this->lang->line('saldo') ?></th>
			</tr>
		</thead>						
		<tbody>	
			<!-- <tr>
				<td></td>
				<td></td>
				<td>Saldo Awal Bulan</td>
				<td></td>
				<td></td>
				<td><?php  echo number_format($saldoAwal) ?> </td>
			</tr> -->
		
			<?php
				if($kas_data)
				{
					$TotalKas = 0;
					$TotalMasuk = 0;
					foreach ($kas_data as $row)
					{
						if($row->jns_trans=="KM"){
							$pemasukan = ($row->jumlah);
							$pengeluaran = 0;
							$TotalKas = $pemasukan + $TotalKas;
							$TotalMasuk += $pemasukan;
						}else if($row->jns_trans=="KK"){
							$pengeluaran = ($row->jumlah);
							$pemasukan = 0;
							$TotalKas = $TotalKas + $pengeluaran;
							$TotalMasuk += $pengeluaran;
						}else{
							$pengeluaran =0;
							$pemasukan = 0;
						}
						
						echo '<tr>';
						echo '<td>'.mediumdate_indo($row->tgl_catat).'</td>';
						echo '<td>'.$row->no.'</td>';
						echo '<td>'.$row->keterangan.'</td>';
						echo '<td>'.number_format($pemasukan).'</td>';
						echo '<td>'.number_format($pengeluaran).'</td>';
						echo '<td>'.number_format($TotalKas).'</td>';
						echo '</tr>';
					}
					
				}
			?>	
		</tbody>
		 <tfoot>
		 	<tr><th></th>
            	<th></th>
            	<th></th>
            	<th></th>
                <th style="text-align:right">Sisa Saldo: </th>
                <th><?php  echo number_format($TotalKas) ?></th>
            </tr>
            <tr>
            	<th></th>
            	<th></th>
            	<th></th>
            	<th></th>
                <th style="text-align:right">Total Bulan Sebelumnya : <br></th>
                <th><?php  echo number_format($saldoAwal) ?></th>
            </tr>
        </tfoot>
	</table>
</div>			
</div>			
</div>			
</div>			
<script type="text/javascript">


</script>