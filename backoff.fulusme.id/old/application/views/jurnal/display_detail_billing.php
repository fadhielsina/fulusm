<div class="post-title col-lg-12"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>
<div class="post-body">
<div class="col-lg-12">
<div class="panel panel-info">
  <div class="panel-heading"> </div>
  <div class="panel-body">
	<div class="row">
		<div class="col-md-12 text-left">
			<div class="card">
				<div class="card-body">
				<div class="row">
				<div class="col-md-4"><h3>DETAIL DATA</h3></div>
				<div class="col-md-8 text-right">
					<a class="btn btn-secondary" href="<?php echo site_url("jurnal/jurnal_billing") ?>">Kembali </a>
				</div>
				</div>
				<?php	
					$kolom=array(
						
						"REGISTRATION_CODE"=>"Register Pasien",
						"PATIENT_NAME"=>"Nama Pasien",
						"PAYMENT_CODE"=>"Kode Pembayaran",
						"CLASS"=>"Jenis Pelayanan",
						"INSURANCE_CODE"=>"Kode Asuransi",
						"INSURANCE_NAME"=>"Nama Asuransi",
						"DEPARTMENT_NAME"=>"Departemen",
						"PAYMENT_TYPE"=>"Jenis Pembyaran",
						"ADMINISTRATION_PAYMENT_FEE"=>"Biaya Administrasi",
						"AMOUNT"=>"Jumlah",
						"CASHIER_NAME"=>"Kasir",
						"SHIFT"=>"Shift",
						"PAYMENT_DATE"=>"Tgl Pembayaran",
						"CREATED_AT"=>"Tgl Digenerate",
						"is_posting"=>"Sudah Diposting",
					);
					echo '<table class="table">';
					foreach($journal_data as $item){
						$item = (array)$item;
						foreach($kolom as $index=>$value){
							echo '<tr>
							<td width="40%"><label for="fname">'.$value.'</label></td>
							<td class="col-md-8"><input type="text" name="'.$index.'" value="'.$item[$index].'" class="form-control" disabled="1" id="'.$index.'" title="'.$value.'"></td>
							</tr>
							'; 
						}
					}
					echo '</table>';
					?>
				</div>
			</div>
		</div>
	</div>				
  </div>		
</div>		
</div>		
</div>		
