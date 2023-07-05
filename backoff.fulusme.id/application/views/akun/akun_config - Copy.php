
<div id="content_area">

<div class="post-body">

<?php echo $this->session->flashdata('message'); ?>
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>
<div class="col-lg-12">
<div class="card">

	<div class="col-md-12">
                                <h4 class="card-title badge badge-success"> <?php echo $title; ?></h4>
								
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Akun Pembelian</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Akun Penjualan</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="home2" role="tabpanel" aria-expanded="true">
                                  <?php
	echo form_open('akun/'.$form_act, 'id="klien_form"');

	
?>
	<br/>
	<table class="table color-table info-table" cellpadding="2" cellspacing="0">	
		
			<tr>
			<th><?php echo form_label('Fungsi','ap'); ?></th>
			<td>
				<select class="form-control col-md-6" name="akun_config" required="">
								<?php foreach ($nama_akun_config as $row2) : ?>
									<option value="<?= $row2->configAkunID ?>" selected><?= $row2->con_name ?></option>
								<?php endforeach; ?>
							</select>
			</td>
		</tr>					
			<tr>
			<th><?php echo form_label('Akun','ap'); ?></th>
			<td>
				<select class="form-control col-md-6" name="akun" required="">
								<?php foreach ($nama_akun2 as $row) : ?>
									<option value="<?= $row->akun_id ?>" selected><?= $row->nama . ' - ' . $row->kode ?></option>
								<?php endforeach; ?>
							</select>
							<select class="form-control col-md-3" name="dk" required="">
							<option value="d">Debit</option>
							<option value="k">Kredit</option>
							</select>
			</td>
		</tr>		
       <tr>		
	   <th></th>
	   <td>
			<?php 
							echo form_submit('simpan','Simpan', array('id' => 'button-cancel', 'content' => 'Batal', 'class' => "btn btn-info" ) );
							?>				
							<?php echo form_close(); ?>
							</td>
		</tr>		
	</table>
	<hr/>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>No</th>
				<th>Unit Bisnis</th>
				<th>Fungsi Transaksi</th>
				<th>Nama Akun Transaksi</th>
				<th>Kode Akun Transaksi</th>
				<th>Posisi DK</th>
				<th></th>
			</tr>
		</thead>						
		<tbody>
			<?php
				if($data_akun_config)
				{
					$i = 1;
					foreach ($data_akun_config as $row3)
					{
						echo '<tr>';
						echo '<td>'.$i++.'</td>';
						echo '<td>'.$row3->identityName.'</td>';
						echo '<td>'.$row3->con_name.'</td>';
						echo '<td>'.$row3->nama.'</td>';
						echo '<td>'.$row3->kode.'</td>';
						echo '<td>'.$row3->dk.'</td>';
						echo '<td>'.form_hidden($i, $row3->configAkuntrxID).form_radio('selected_data', $row3->configAkuntrxID).'<a href="'.base_url().'/akun/delete_conf_akun/'.$row3->configAkuntrxID.'" class="btn btn-xs waves-effect waves-light btn-danger">hapus</a></td>';
						echo '</tr>';
						
					}
				}
			?>	
		</tbody>
	</table>

                                
								</div>
								

								
                                <div class="tab-pane p-20" id="profile2" role="tabpanel" aria-expanded="false">
					On Progress
								</div>
							
                    </div>
	
	
</div>
</div>
</div>
</div>
</div>


