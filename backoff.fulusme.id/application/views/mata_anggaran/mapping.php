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

<div class="card" style="padding-top:25px">
<div class="card-body" style="padding-top:30px">
<div class="post-title" style="margin-top: 20px;margin-bottom: 50px;">
<h4 class="card-title">Setting Anggaran</h4>
</div>
	<form id="form_laporan" method="POST"> 
	<?php echo form_hidden('nama_laporan', $nama_laporan); ?>
	<table  cellpadding="2" cellspacing="0" style="width:100%;height: auto;">					
	<tr>
			<div class="row">
			<th><?php echo form_label($this->lang->line('bulan'),'bulan'); ?></th>
			<td>				
				<?php 
					$data['id'] = 'bulan';
					$data['class'] = "form-control col-sm-4";					
					$selected = date("m");
					echo form_dropdown('bulan', $months, $selected, $data);
				?>					
				<?php 
						$data['name']  = 'tahun';
						$data['type'] = 'text' ;
						$data['id']  = 'tahun';
						$data['minlength'] = '2';
						$data['class'] ='form-control col-md-2 text-center disable';
						$data['placeholder'] = 
						date('Y');
						echo form_input($data);
					?>		
			</td>
			</div>
		</tr>	
		<tr>
			<div class="row">					
			<th><?php echo form_label($this->lang->line('pilih_akun'),'id_akun'); ?></th>
			<td>
					<?php 
						$data['id'] = 'id_akun';
						$data['class'] = "form-control col-sm-6";
						//$data['data-toggle'] = "modal";
						//$data['data-target']= "#InputPengumumanModal";
						$selected = 'all';
						echo form_dropdown('id_akun', $akun, "", $data);
					?>
					
            </div>
			</td>
			</div>
		</tr>
		<tr>
			<div class="row">
			<th><?php echo form_label("Anggaran"); ?></th>	
			<td>
					<?php 
						$data['name']  = "anggaran";
						$data['id'] = 'anggaran';
						$data['class'] ='form-control col-md-6';
						$data['required'] = 'required';
						$data['minlength'] = '2';
						$data['placeholder'] = "Masukan Anggaran";					
						$data['title'] = $this->lang->line('valid_pilih_akun');
						echo form_input($data);
					?>					
			</td>
			<?= form_error('anggaran','<small class="text-danger pl-3">','</small>'); ?>
			</div>
		</tr>		
	</table>
	</form>
	<div class="buttons mt-2">
		<?php
			echo form_button(array('id' => 'button-save', 'content' => $this->lang->line('simpan')));
			//echo form_button('reset','Reset', "id = 'button-reset'" );
			echo form_button(array('id' => 'button-load', 'content' => 'Load Anggaran'));
		?>
	</div>
</div>
</div>

<div id="content_area">
	
<?php

?>

<br/>
<div id="cnt_detail" style="display:none"></div>
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

			foreach ($mapping as $key => $value) {
				echo '<tr>';
				echo '<td>' .$value['nama']. '</td>';
				echo '<td>' .$value['kode']. '</td>';
				echo '<td>' .number_format($value['nominal']). '</td>';?>
		        <td><a href="<?php echo base_url(); ?>anggaran/mapping_edit/<?php echo $value['id_mapping'] ?>" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-edit"></i> </a>
				</td>
				<?php
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


</div>

<script type="text/javascript" charset="utf-8">
	$(function() {
                
		$('#button-save').click(function() {
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.post("<?php echo site_url()."anggaran/mapping_tambah"?>",$("#form_laporan").serialize(),function(result){
				$("#content_area").html(result);
				//$("#form_laporan").trigger("reset");
			});
			//location.href = '<?php echo site_url();?>laporan_keuangan/'+jenis_laporan+'/'+bulan+'/'+tahun;
		});
		$("#button-load").click(function(){

			$.post("<?php echo site_url()."anggaran/load_mapping"?>",$("#form_laporan").serialize(),function(result){
				$("#content_area").html(result);
				//$("#form_laporan").trigger("reset");
			});
		});
	});
    var dataPeriode = JSON.parse('<?php echo json_encode($periode) ?>') ;   
    /*$("#periode_anggaran").change(function(){
        console.log($("#periode_anggaran").val());
        console.log(dataPeriode);
    })*/
    $("#periode_anggaran").select2()
	.on("select2:select", function (e) {
	    var selected_element = $(e.currentTarget);
	    var select_val = selected_element.val();
	    alert(select_val);
	});
    /*$('.input-daterange').datepicker({
            orientation: "bottom left"
       });*/
    $( function() {
	    var dateFormat = "yyyy/mm/dd",
	      from = $( "#tgl_awal" )
	        .datepicker({
	          defaultDate: "+1w",
	          changeMonth: true,
	          numberOfMonths: 1
	        })
	        .on( "change", function() {
	          to.datepicker( "option", "minDate", getDate( this ) );
	        }),
	      to = $( "#tgl_akhir" ).datepicker({
	        defaultDate: "+1w",
	        changeMonth: true,
	        numberOfMonths: 1
	      })
	      .on( "change", function() {
	        from.datepicker( "option", "maxDate", getDate( this ) );
	      });
	 
	    function getDate( element ) {
	      var date;
	      try {
	        date = $.datepicker.parseDate( dateFormat, element.value );
	      } catch( error ) {
	        date = null;
	      }
	 
	      return date;
	    }
	  } );

	  function jenis() {
		var jenis = document.getElementById('id_akun').value;
		'<a href="" class="btn btn-info float-left" data-toggle="modal" data-target="#InputPengumumanModal">Post Pengumuman</a>';
	}

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



</script>