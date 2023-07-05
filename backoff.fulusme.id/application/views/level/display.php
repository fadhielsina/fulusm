
<div class="post-body">

<div class="col-lg-12">
<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
  <div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => $this->lang->line('tambah'), 
				'onClick' => "location.href='".site_url()."".$add_act."'" ));
			echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => $this->lang->line('lihat'), 'onClick' => "editAction('".site_url()."level/view')" ));
			echo form_button(array('id' => 'button-edit','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary', 'content' => $this->lang->line('ubah'), 'onClick' => "editAction('".site_url()."level/edit')" ));
			echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => $this->lang->line('hapus'), 'onClick' => "deleteAction('".site_url()."level/delete')" ));
		?>		
		</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
			<?php

			foreach($field as $index=>$item){
				echo '<th>'.$item.'</th>';
			}
			echo '<th></th>';
			?>
			</tr>
		</thead>
		<tbody>
			<?php
				if($asset_data)
				{
					$i = 0;
					foreach ($asset_data as $row)
					{

						echo '<tr>';
						foreach($field as $indexdata=>$itemdata){
							echo '<td>'.$row[$indexdata].'</td>';
						}
						
						//echo '<td>'.$row->nama_depan.'</td>';
						//echo '<td>'.$row->nama_belakang.'</td>';
						//echo '<td>'.$row->username.'</td>';
						echo '<td>'.form_hidden($i, $row['id_level']).form_radio('selected_data', $row['id_level'],'','id="'.$row['id_level'].'"').'</td>';
						echo '</tr>';
						$i++;
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
			<?php
			foreach($field as $index=>$item){
				echo '<th>'.$item.'</th>';
			}
			?>
			</tr>
		</tfoot>
	</table>
</div>
</div>
</div>
</div>
