<?php

?>

<br/>
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
  <h3 class="card-title">Detail Data Saldo Awal</h3>
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
<script type="text/javascript">
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
		//$("#form_laporan").trigger("reset");
	});
}
</script>