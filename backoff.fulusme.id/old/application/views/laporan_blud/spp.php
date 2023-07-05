<div class="card" id="frm_add_spp" style="display: none">
	<form method="POST" action="<?php echo base_url("Procurement/proses_spp") ?>">
		<input type="hidden" name="id_procurements" id="id_procurements" value="">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">Surat permintaan Pembayaran </div>
		</div>
		<div class="row">
			<div class="col-md-4">NO SPP </div>
			<div class="col-md-8"><input type="text" name="no_spp" class="form-control" value="<?php echo $genNOSPP ?>"></div>
		</div>
		<div class="row">
			<div class="col-md-4">Mata Anggaran </div>
			<div class="col-md-8">
				<select  name="mata_anggaran" id="mata_anggaran" class="form-control">
					<?php
					foreach($mata_anggaran as $item){
						echo '<option value="'.$item["id_mata_anggaran"].'_'.$item["mata_anggaran"].'">'.$item["id_mata_anggaran"].'-'.$item["mata_anggaran"].'</option>';
					}
					?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">Tanggal </div>
			<div class="col-md-8"><input type="date" name="date_spp" class="form-control" value="<?php echo date('Y-m-d') ?>"></div>
		</div>
		<div class="row">
			<div class="col-md-4">Uraian </div>
			<div class="col-md-8"><input type="text" id="uraian_spp" name="uraian_spp" class="form-control"></div>
		</div>
		<div class="row">
			<div class="col-md-4">Nama Penerima </div>
			<div class="col-md-8"><input type="text" id="supplierName" name="supplierName" class="form-control"></div>
		</div>
		<div class="row">
			<div class="col-md-4">Nama Bank </div>
			<div class="col-md-8"><input type="text" id="supplierBankname" name="supplierBankname" class="form-control"></div>
		</div>
		<div class="row">
			<div class="col-md-4">No Rekening </div>
			<div class="col-md-8"><input type="text" id="supplierBankid" name="supplierBankid" class="form-control"></div>
		</div>
		<div class="row">
			<div class="col-md-4">NPWP </div>
			<div class="col-md-8"><input type="text" id="supplierNPWP" name="supplierNPWP" class="form-control"></div>
		</div> 
		<div class="row">
			<div class="col-md-4">PPTK </div>
			<div class="col-md-8">
				<select  name="pptk" id="pptk" class="form-control">
					<?php
					foreach($pejabat as $item){
						echo '<option value="'.$item["id"].'">'.$item["nama"].'-'.$item["nip"].'</option>';
					}
					?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<button id="btn_add_spp" type="submit" class="btn btn-primary">Proses SPP</button>
				<button id="cancel_spp" class="btn btn-warning">Batal</button>
			</div>
		</div>
	</div>
	</form>
</div>

<div class="card">
<div class="card-body">
<div class="row">
<div class="col-md-6">	
	<h3>Laporan <?php echo ucfirst(str_replace("_"," ",$jenis_laporan)) ?></h3>
</div>
<div class="col-md-6 text-right">
	<a href="#" id="load_FO" class="btn btn-primary">Load FO Data</a>
	<span id="loading_message" style="display: none">Please wait...</span>	
</div>
</div>
 <div class="table-responsive m-t-5">
    <table id="example23" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('tanggal') ?></th>
		<th ><?= $this->lang->line('supplier') ?></th>
		<th ><?= $this->lang->line('no_order') ?></th>
		<th ><?= $this->lang->line('invoice_no') ?></th>
		<th ><?= $this->lang->line('no_spp') ?></th>
		<th ><?= $this->lang->line('keterangan') ?></th>
		<th ><?= $this->lang->line('jumlah') ?></th>
		<th  class="no-print"></th>
	</tr>
	</thead>	
	<tbody>
	<?php
	if($procurement !="" && is_array($procurement)){
		foreach ($procurement as $key => $value) {
		echo '<tr>';
		echo '<td>'.date( 'Y-m-d', strtotime( $value['date'] ) ).'</td>';
		echo '<td>'.$value['supplierName'].'</td>';
		echo '<td>'.$value['noOrder'].'</td>';
		echo '<td>'.$value['invoiceNo'].'</td>';
		echo '<td>'.$value['noSpp'].'</td>';
		echo '<td>'.$value['uraianSpp'].' </td>';
		echo '<td>'.number_format($value['total_purchases']).'</td>';
		echo '<td class="no-print">
		<ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="padding:4px;">'.$this->lang->line('aksi') .'<b class="caret"></b></a>
                <ul class="dropdown-menu">';
                if($value['noSpp']==""){
			    echo '<li>'.anchor("", 'Input SPP','onClick=\'return loadSPP("'.$value['id'].'","'.$value['description'].'")\'').'</li>';
				}else if($value['noSpp'] !=""){
				 echo ' <li>'.anchor(site_url()."Procurement/cetak_spp/".$value['id'], 'Cetak SPP','target="_blank"').'</li>';
				 if($value['noSpm'] ==""){ //tampilkan hanya jika no spm masih kosong
				 	echo ' <li>'.anchor(site_url()."Procurement/input_spm/".$value['id'], 'Input SPM').'</li>';
				 }
				}
				echo '</ul>
            </li>
        </ul></td>';
		
		echo '</tr>';
		}
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th ><?= $this->lang->line('tanggal') ?></th>
		<th ><?= $this->lang->line('supplier') ?></th>
		<th ><?= $this->lang->line('no_order') ?></th>
		<th ><?= $this->lang->line('invoice_no') ?></th>
		<th ><?= $this->lang->line('no_spp') ?></th>
		<th ><?= $this->lang->line('keterangan') ?></th>
		<th ><?= $this->lang->line('jumlah') ?></th>
		<th  class="no-print"></th>
	</tr>
	</tfoot>
</table>
</div>
</div>
</div>

<script type="text/javascript" charset="utf-8">



</script>

