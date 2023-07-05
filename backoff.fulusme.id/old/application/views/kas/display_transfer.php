<br/>
<div class="post-title col-lg-12"><h3 class="pull-left"><?php echo $title; ?></h3>
<div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".site_url()."kas/add_kas_transfer'" ));
		?>		
	</div>
</div>
<br/><br/>
<div class="post-body">


		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>		
	</div>
	<div class="col-lg-12">
		<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	  <table class="table info-table" id="display_table">
		<thead>
			<tr>
				<th>No.Trx</th>
				<th><?= $this->lang->line('no_jurnal') ?></th>
				<th><?= $this->lang->line('tanggal') ?></th>
				<th><?= $this->lang->line('dari_kas') ?></th>
				<th><?= $this->lang->line('untuk_kas') ?></th>
				<th><?= $this->lang->line('catatan') ?></th>
				<th>Total</th>
				<th></th>
			</tr>
		</thead>						
		<tbody>
			<?php
				if($kas_data)
				{
					foreach ($kas_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$row->no_trx_kas.'</td>';
						if ($row->no) {
						echo '<td>'.$row->no.'</td>';
						}
						else
						{
							echo "<td><b class='label label-danger'>Belum Posting</b></td>";
						}
						echo '<td>'.mediumdate_indo($row->tgl_catat).'</td>';
						echo '<td>'.$row->nm_akun.'</td>';
						echo '<td>'.$row->nm_akun2.'</td>';
						echo '<td>'.$row->ket_trx.'</td>';
						echo '<td>'.number_format($row->jumlah).'</td>';
						?>
						<td>
						<ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="padding:4px;">Action <b class="caret"></b></a>
                        <ul class="dropdown-menu">
						<li><?php echo anchor(site_url()."kas/detail_data_transfer/".$row->id_trx, 'Detail'); ?></li>		
						<?php if ($row->no) { ?>
                   		<li><?php echo anchor(site_url()."kas/nota_transfer/".$row->id_trx, 'Note' , array('target' => '_blank')); ?></li>	
						
						<?php } ?>
						<li><a href="<?php echo site_url()."kas/delete_data_kas/".$row->id_trx;?>/tk" onclick="javascript: return confirm('Do You really wants to delete data? : <?php echo $row->no_trx_kas; ?> ?')" >Delete</a></li>	
						
						</ul>
                    </li>
                </ul>
						</td>
						<?php echo '</tr>';
					}
				}
			?>	
		</tbody>
	</table>
</div>			
</div>			
</div>			
</div>			