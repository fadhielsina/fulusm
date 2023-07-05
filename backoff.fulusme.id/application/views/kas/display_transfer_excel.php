<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th>No.Trx</th>
				<th>No. Jurnal</th>
				<th>Tgl</th>
				<th>Dari Kas</th>
				<th>Untuk Kas</th>
				<th>Catatan</th>
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
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="padding:4px;">Aksi <b class="caret"></b></a>
                        <ul class="dropdown-menu">
						<li><?php echo anchor(site_url()."kas/detail_data_transfer/".$row->id_trx, 'Detail'); ?></li>		
						<?php if ($row->no) { ?>
                   		<li><?php echo anchor(site_url()."kas/nota_transfer/".$row->id_trx, 'Nota' , array('target' => '_blank')); ?></li>	
						<?php } ?>
						<li><a href="<?php echo site_url()."kas/delete_data_kas/".$row->id_trx;?>/tk" onclick="javascript: return confirm('Anda akan menghapus data : <?php echo $row->no_trx_kas; ?> ?')" >Hapus</a></li>	
						
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