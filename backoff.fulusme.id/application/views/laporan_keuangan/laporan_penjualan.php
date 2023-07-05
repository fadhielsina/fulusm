<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var bln = $('#bulan').val();
			var thn = $('#tahun').val();
			oTable.fnClearTable();
			$.post('<?php echo site_url().'invoice/search' ?>',
				  { bulan : bln, tahun : thn},
				  function(msg){
					if(msg) {
						msg = eval(msg);
						oTable.fnAddData(msg);
					}
				  }
			  );
		});
	});
</script>

<div class="post-body">

	<?php echo $this->session->flashdata('message'); ?>
	<br/>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
	<thead>
		<tr>
			<th style="width: 60px">No. Jurnal</th>
			<th style="width: 60px">No. Invoice</th>
			<th style="width: 60px">Nama Customer</th>
			<th>Kode Customer</th>
			<th>Kas Cabang</th>
			<th>Piutang Car </th>
			<th>Piutang Bus </th>
			<th>BCA </th>
			<th>BNI </th>
			<th>Mandiri</th>
			<th></th>			
		</tr>
	</thead>
	<tbody>
		<?php 
			if($datapen)
			{
				foreach ($datapen as $row) 
				{ 
				 
					echo '<tr>';
					echo '<td>'.$row->invoiceID.'</td>';
					echo '<td>'.$row->trxDate.'</td>';
					echo '<td>'.$row->invoiceIDmanual.'</td>';
					echo '<td>'.$row->trxFullName.'</td>';
					echo '<td>'.number_format($row->trxJasaTotal).'</td>';	
					echo '<td>'.number_format($row->trxSparepartTotal).'</td>';	
					echo '<td>'.number_format($row->trxDiscount).'</td>';		
					echo '<td>'.number_format($row->trxTotal).'</td>';	
					echo '<td>'.number_format($row->totalbyr).'</td>';	
					echo '<td>'.number_format($sisabyr).'</td>';	
					echo '<td>'.anchor(site_url()."invoice/invoice_pay/".$row->invoiceID, 'Bayar').' &nbsp;&nbsp;'.anchor(site_url()."invoice/nota/".$row->invoiceID, 'Nota').'</td>'; 							
					echo '</tr>';
				}
			}
		?>
	</tbody>	
</table>		

</div>		
