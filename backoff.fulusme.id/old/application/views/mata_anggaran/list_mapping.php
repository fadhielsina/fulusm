<?php

?>

<br/>
<div id="cnt_detail" style="display:none"></div>
<div class="post-title col-lg-12">
	<h3 class="pull-left"><i class="fa fa-windows"></i> <?= ('Data Anggaran'); ?></h3>
	<div class="pull-right">
		<?php 
			//echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => 'Tambah Baru', 'onClick' => "location.href='".$action_add."'" ));
			//echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => 'Lihat', 'onClick' => "editAction('".site_url()."anggaran/view')" ));
			//echo form_button(array('id' => 'button-edit','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary', 'content' => 'Ubah', 'onClick' => "editAction('".site_url()."anggaran/edit')" ));
			//echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => 'Hapus', 'onClick' => "deleteAction('".site_url()."anggaran/delete')" ));
		?>		
	</div>
</div>
		
<div class="post-body">


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
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
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

			foreach ($mapping as $key => $value) {
				echo '<tr>';
				echo '<td>' .$value['nama']. '</td>';
				echo '<td>' .$value['kode']. '</td>';
				echo '<td>' .number_format($value['nominal']). '</td>';
				echo '</tr>';
				
				//echo "<td>";
				//echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => 'Detail', 'onClick' => " loadDetail('".$value[$id]."')" ));
				//echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => $this->lang->line('hapus'), 'onClick' => "document.location.href='".$action_delete."/".$value[$id]."'"));

				
				//echo '</td>
				//	'</tr>';
			}
			?>
		</tbody>
		<tfoot>
			<?php
			foreach ($field as $key => $value) {
				echo '<th>'.$value.'</th>';
			}
			?>
			<th></th>
		</tfoot>
	</table>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(function () {
	var table = $('#display_table').DataTable({
		"columnDefs": [{
		"visible": true,
		"targets": 0
		}],
		"order": [
			[0, 'asc']
		],
		dom: 'Bfrtip',
			buttons: [
			'excel', 'pdf', 'print'
			],
		

		});
	});
});

function loadDetail(idMappping){
	
	$.post("<?php echo site_url()."anggaran/mapping_detail"?>",{id:idMappping},function(result){
		$("#cnt_detail").html(result);
		$("#cnt_detail").slideDown("slow");
		$("html, body").animate({ scrollTop: $('#button-close').offset().top }, 1000);
		//$("#form_laporan").trigger("reset");
	});
}
</script>