
<div class="post-body">
	<div class="col-lg-12">
<div class="card">
  <div class="card-body">
  	<h4 class="card-title" id="title-detail"><?= $this->lang->line('laporan_realisasi_anggaran') ?></h4>
  	<div class="row">
  		<div class="col-md-12 text-center">
  			<h3>Realisasi Anggaran</h3>
  		</div>
  	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="displaytable">
		<thead>
			<tr>
				
				<?php
				foreach ($field as $key => $value) {
					echo '<th>'.$value.'</th>';
				}
				?>
				<th>Selisih</th>				
			</tr>
		</thead>
		<tbody>
			<?php
			$s=1;
			foreach ($output as $key => $value){ $s;
			
				echo '<tr  style="background-color:lightblue;color:#FFFF;">';
				echo '<td>' .$key.'</td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '</tr>';
				foreach ($value as $key2 => $value2) {
					$selisih = $value2['nominal'] + $value2['kredit'] - $value2['debit'];
					$realisasi =  $value2['debit']-$value2['kredit'] ;
					echo '<tr>';
					echo '<td>'.$key2.'</td>';
					echo '<td>'.number_format($value2['nominal']).'</td>';
					echo '<td>'.number_format($realisasi).'</td>';
					//echo '<td>'.number_format($value['kredit']).'</td>';
					echo '<td>'.number_format($selisih).'</td>';
					echo '</tr>';
				}
			$s++;}
			?>
		</tbody>

	</table>
</div>
</div>
</div>
</div>

<script>

$(document).ready(function() {
    var groupColumn = 0;
    var table = $('#displaytable').DataTable({
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        "order": [[ groupColumn, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last= null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="4">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
	
} );
</script>

