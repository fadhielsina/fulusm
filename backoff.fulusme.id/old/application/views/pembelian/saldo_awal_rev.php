<br/>
<div class="post-title col-lg-12">
	<h3 class="pull-left"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
	<div class="pull-right">
		<?php 
			echo form_button(array('type' => 'button','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => 'input saldo awal', 'data-toggle' => "modal", 'data-target' => "#exampleModalCenter" ));
		?>		
	</div>
</div>
	

<?php
echo "<div id='error' class='error-message' ";
if($this->session->userdata('ERRMSG_ARR'))
{
	echo ">";
	echo $this->session->userdata('ERRMSG_ARR');
	$this->session->unset_userdata('ERRMSG_ARR');
}
else
{
	echo "style='display:none'>";
}
echo "</div>";
$data['class'] = 'input';	

?>



<div id="content_area">
	

<?php

?>

<div id="cnt_detail" style="display:none"></div>
<div class="post-title col-lg-12">
</div>
		
<div class="post-body">

<?php echo $this->session->flashdata('message'); ?>
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>
<br/><br/>
<div class="col-lg-12">
<div class="card">
  <div class="card-body mt-3 ml-2">
  <h3 class="card-title">Data Saldo Awal</h3>
  <br/>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="displaytable">
		<thead>
			<tr>
				<?php
				foreach ($field as $key => $value) {
					echo '<th>'.$value.'</th>';
				}
				?>
				
			</tr>
		</thead>
		<tfoot>
			<?php
			foreach ($field as $key => $value) {
				echo '<th>'.$value.'</th>';
			}
			?>
			
		</tfoot>
		<tbody>
			<?php

			foreach ($saldoawal as $key => $value) {
				echo '<tr>';
				echo '<td>' .$value['nama']. '</td>';
				echo '<td>' .$value['kode']. '</td>';
				echo '<td>' .number_format($value['saldo_awal']). '</td>';
				echo '<td>' .$value['tanggal']. '</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>






<script type="text/javascript" charset="utf-8">
	$(function() {
                
		$('#button-save').click(function() {
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.post("<?php echo site_url()."akun/tampil_saldo"?>",$("#form_saldo_awal").serialize(),function(result){
				$("#content_area").html(result);
				$("#form_saldo_awal").trigger("reset");
			});
			//location.href = '<?php echo site_url();?>laporan_keuangan/'+jenis_laporan+'/'+bulan+'/'+tahun;
		});
		$("#button-load").click(function(){

			$.post("<?php echo site_url()."akun/tampil_saldo"?>",$("#form_saldo_awal").serialize(),function(result){
				$("#content_area").html(result);
				$("#form_saldo_awal").trigger("reset");
});
});
	});

$( function() {
var dateFormat = "yyyy/mm/dd",
	from = $( "#tanggal" )
	    .datepicker({
	      defaultDate: "+1w",
	      changeMonth: true,
	      numberOfMonths: 1
	    })
} );
$(document).ready(function() {
$(function () {
	var table = $('#displaytable').DataTable({
		"columnDefs": [{
		"visible": true,
		"targets": 0
		}],
		"order": [
			[0, 'asc']
		],
		});
	});
});

function loadDetail(){
	
	$.post("<?php echo site_url()."akun/tampil_saldo"?>",function(result){
		$("#cnt_detail").html(result);
		$("#cnt_detail").slideDown("slow");
		$("html, body").animate({ scrollTop: $('#button-close').offset().top }, 1000);
		$("#form_saldo_awal").trigger("reset");
	});
}
</script>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-windows"></i> <?php echo $title; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  	<form action="<?= site_url('akun/saldo_awal');?>"  id="form_saldo_awal" method="POST"> 
      	<div class="modal-body">
		<div class="row-ml-2">
		<div class="col-12">
			<table>	
			<div class="">
			<tr><?php echo form_label("Nama"); ?></tr>
			</div>
			<div class="">
			<tr>				
					<?php
						$data['name'] = 'nama'; 
						$data['id'] = 'nama';
						$data['class'] = "form-control";
						$selected = 'all';
						echo form_dropdown('nama', $akun, $selected ,$data); ?>					
			</tr>			
			</div>
			<div class="row mt-2">
			<tr><?php echo form_label("Saldo"); ?></tr>
			</div>
			<div class="">
			<tr>
				
				<?php 
					$data['name']  = 'saldo_awal';
					$data['id'] = 'saldo_awal';
					$data['minlength'] = '2';
					$data['required'] =  'required';
					$data['class'] ='form-control autonumeric-integer';
					$data['placeholder'] = "Masukan Saldo";					
					$data['title'] = $this->lang->line('valid_pilih_akun');
					echo form_input($data);
				?>					
				
			</tr>
			</div>
			<div class="row mt-2 md-2">
			<tr><?= form_label('per-Tgl'); ?></tr>
			</div>
			<div class="">
			<tr>
						<div class="input-daterange input-group" >
							<input type="date" class="form-control" name="tanggal"  required>
						</div>				
			</tr>			
			</div>
			</table>
		</div>
		</div>
		<div class="modal-footer">
			<button type="button"  class="btn btn-secondary" data-dismiss="modal">Batal</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
      	</div>
		</form>
      </div>
    </div>
  </div>
</div>




