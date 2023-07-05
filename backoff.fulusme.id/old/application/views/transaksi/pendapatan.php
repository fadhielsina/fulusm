<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>

<div class="post-title"><h2><a href="#"><?php echo $title; ?></a></h2></div>

<div class="post-body">

 <div class="box-body table-responsive no-padding">
               
                  <table id="example1" class="table table-bordered table-hover dataTable">
                    <thead>
                      <tr>
						<th>No.</th>
						<th>Tgl. Transaksi</th>
						<th>Total Pendapatan</th>
						<th>Aksi</th>
                    </thead>
                    <tbody>
                      	<?php  
                        $no = 1;
                        foreach ($trx as $lihat):
                        ?>
                    	<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $lihat->trxDate; ?></td>
							<td><?php echo number_format($lihat->totaltrx); ?></td>
							<td>
							<a href="<?php echo site_url(); ?>transaksi/save_pendapatan_outlet?totalpen=<?php echo $lihat->totaltrx ?>&tgl=<?php echo $lihat->trxDate ?>&noju= <?php echo $trxid ?>&trxDate= <?php echo $lihat->trxDate ?>" class="btn btn-sm btn-primary btn-flat" > <i class="fa fa-plus-square"></i> POSTING </a></td>
                    	</tr>
                    	<?php endforeach; ?>
                    </tbody>
                  </table>
                  
                </div><!-- /.box-body -->

</div>

<script type='text/javascript'>
	//Validasi di client
	$(document).ready(function()
	{
		$('#jurnal_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				nomor: "required",
				tanggal: "required dateISO",
				deskripsi: "required",
				debit1: "integer",
				kredit1: "integer",
				debit2: "integer",
				kredit2: "integer"
			}
		});
	});
</script>
