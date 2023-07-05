<br/>
<div class="post-title col-lg-12">
	<h3 class="pull-left"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
	<div class="pull-right">
		<?php 
			echo form_button(array('type' => 'button','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => 'Tambah Mapping', 'data-toggle' => "modal", 'data-target' => "#exampleModalCenter" ));
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
  	<table cellpadding="0" cellspacing="0" border="0" class="display" id="displaytable">
		<thead>
			<tr>
				<?php
				foreach ($field as $key => $value) {
					echo '<th>'.$value.'</th>';
				}
				?>	
				<th></th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			foreach ($saldoawal as $key => $value) {
				$no = $key + 1;
				echo '<tr>';
				echo '<td>'. $no .'</td>';
				echo '<td>' .$value['nama']. '</td>';
				echo '<td>' .$value['kode']. '</td>';
				echo '<td><a href="'.base_url().'/akun/mapping_akun_delete/'.$value['akun_saldo_id'].'" class="btn btn-xs waves-effect waves-light btn-danger">hapus</a></td>';
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
<div class="modal fade in show" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"><i class="mdi mdi-note-multiple-outline"></i> <?php echo $title; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  	<form action="<?= site_url( $form_action );?>"  id="form_saldo_awal" method="POST"> 
      	<div class="modal-body">
			<div class="form-group">
				<?php echo form_label("Nama Akun"); ?>
				<?php
					$data['name'] = 'nama_akun'; 
					$data['id'] = 'nama';
					$data['class'] = "form-control";
					$data['style'] = 'width:100%;';
					$selected = 'all';
					echo form_dropdown('nama_akun', $akun, $selected ,$data); ?>					
			</div>		
			
			<i class="mdi mdi-alert-octagram"></i> Khusus Untuk Akun Bank<hr/>
			<div class="form-group"><?php echo form_label("Kode Transaksi Keluar"); ?>
				<?php 
					$data['class'] ='form-control';
					$data['name'] = $data['id'] = 'in';
					echo form_input($data);
				?>
			</div>
			
			<div class="form-group"><?php echo form_label("Kode Transaksi Masuk"); ?>
				<?php 
					$data['class'] ='form-control';
					$data['name'] = $data['id'] = 'out';
					echo form_input($data);
				?>
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