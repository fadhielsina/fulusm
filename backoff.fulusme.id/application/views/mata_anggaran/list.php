<?php

?>

<br/>
<div class="post-title col-lg-12">
	<h3 class="pull-left"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
	<div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".$action_add."'" ));
			//echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => 'Lihat', 'onClick' => "editAction('".site_url()."anggaran/view')" ));
			//echo form_button(array('id' => 'button-edit','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary', 'content' => 'Ubah', 'onClick' => "editAction('".site_url()."anggaran/edit')" ));
			//echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => 'Hapus', 'onClick' => "deleteAction('".site_url()."anggaran/delete')" ));
		?>		
	</div>
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

			foreach ($anggaran as $key => $value) {
				echo '<tr>';
				$id="";
				foreach ($field as $key2 => $value2) {
					if($id=="") { $id=$key2;}

					echo '<td>'.$value[$key2].'</td>';
				}
			
				echo "<td>".form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => $this->lang->line('hapus'), 'onClick' => "document.location.href='".$action_delete."/".$value[$id]."'"))."</td>";
				echo '</tr>';
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


<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;


</script>