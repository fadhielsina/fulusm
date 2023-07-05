
<div class="post-body">
	<div class="col-lg-12">
<div class="card">
  <div class="card-body">
  	<div class="pull-right">
  		<?php
  		echo form_button(array('id' => 'button-close','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => 'Close', 'onClick' => "close_detail()"));
  		?>
  	</div>
  	<h4 class="card-title" id="title-detail">Detail Mapping Anggaran </h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table_detail">
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

			foreach ($mapping_detail as $key => $value) {
				echo '<tr>';
				$id="";
				foreach ($field as $key2 => $value2) {
					if($id=="") { $id=$key2;}
					if(is_numeric($value[$key2])){
						echo '<td>'.number_format($value[$key2]).'</td>';	
					}else{
						echo '<td>'.$value[$key2].'</td>';
					}
				}
			
				echo "<td>";
				echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => 'Hapus', 'onClick' => "deleteMapping('".$action_delete."/".$value['id_mapping']."')"));

				
				echo '</td>
					</tr>';
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
function deleteMapping(urlDelete){
	$.getJSON(urlDelete,function(result){
		alert(result.message)
		if(result.error="0"){
			close_detail();
		}
	});
}
$(document).ready(function() {
	$(function () {
	var table = $('#display_table_detail').DataTable({
		"columnDefs": [{
		"visible": false,
		"targets": 0
		}],
		"order": [
			[0, 'asc']
		],
		dom: 'Bfrtip',
					buttons: [
					'excel', 'pdf', 'print'
					]

		});
	});
});
function close_detail(){
    $("#cnt_detail").slideUp("slow");
}
</script>
