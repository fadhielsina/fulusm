<script type="text/javascript" src="<?php echo base_url();?>js/group_table.js"></script>
<div class="col-lg-12">
<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?php echo $title; ?></h4>
<table class="table info-table" id="display_table">
		<thead>
			<tr>
				<th><?= $this->lang->line('grup') ?></th>
				<th>Kode Akun</th>
				<th><?= $this->lang->line('akun') ?></th>
				<th><?= $this->lang->line('saldo') ?></th>									
				<th><?= $this->lang->line('buku_besar') ?></th>
				</tr>
		</thead>
		<tbody>		
			<?php
				if($account_data)
				{
					foreach ($account_data as $row) 
					{
						echo '<tr>';
						echo '<td>'.$row->groups_name.'</td>';
						echo '<td>'.$row->kode.'</td>';
						echo '<td>'.$row->nama.'</td>';
						echo '<td>'.number_format(($row->saldo), 0, '', '.').'</td>';						
						echo '<td>'.anchor(site_url()."jurnal/buku_besar/".$row->id, $this->lang->line('buku_besar')).'</td>'; 	
						echo '</tr>';
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th><?= $this->lang->line('grup') ?></th>
				<th>Kode Akun</th>
				<th><?= $this->lang->line('akun') ?></th>
				<th><?= $this->lang->line('saldo') ?></th>									
				<th><?= $this->lang->line('buku_besar') ?></th>
			</tr>
		</tfoot>
	</table>
</div>

</div>

</div>
