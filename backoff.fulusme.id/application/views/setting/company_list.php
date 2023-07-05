
<div class="card">
<div class="card-body">
<?php
/*var_dump($this->session->flashdata("message"));
if($this->session->flashdata("message") !=""){
	echo '<div class="row">
	<div class="col-md-12">
		<h3>'.$this->session->flashdata("message").'</h3>
	</div>
	</div>';
}*/
?>
<div class="row">
	<div class="col-md-12" id="add_company" style="display:none">
		<form action="<?php echo base_url("setting/add_company") ?>" method="POST">
			<table class="table color-table info-table">
				<tr>
					<th><?php echo form_label($this->lang->line('company').'*','company'); ?></th>
					<td>
						<?php 
							$data['name'] = $data['id'] = 'company_name';
							// added by Adhe on 19.05.2010
							$data['maxlength'] = '50';
							$data['class'] ='form-control';
							$data['value'] = (set_value('company_name')) ? set_value('company_name') :"";
							$data['title'] = $this->lang->line('valid_company');
							echo form_input($data);
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo form_label($this->lang->line('company').'*','company'); ?> Address</th>
					<td>
						<?php 
							$data['name'] = $data['id'] = 'company_address';
							// added by Adhe on 19.05.2010
							$data['maxlength'] = '50';
							$data['class'] ='form-control';
							$data['value'] = (set_value('company_address')) ? set_value('company_address') :"";
							//$data['title'] = $this->lang->line('valid_company');
							echo form_input($data);
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo form_label($this->lang->line('company').'*','company'); ?> Phone</th>
					<td>
						<?php 
							$data['name'] = $data['id'] = 'company_phone';
							// added by Adhe on 19.05.2010
							$data['maxlength'] = '50';
							$data['class'] ='form-control';
							$data['value'] = (set_value('company_phone')) ? set_value('company_phone') :"";
							//$data['title'] = $this->lang->line('valid_company');
							echo form_input($data);
						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php
							echo form_submit('simpan',$this->lang->line('simpan'), "id = 'button-save'" );
						?>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-md-12" id="add_division_form" style="display:none">
		<form action="<?php echo base_url("setting/add_division") ?>" method="post">
			<table class="table color-table info-table">
				<tr>
					<th><?php echo form_label($this->lang->line('company').'*','company'); ?></th>
					<td>
						<?php 
							$data['id'] = 'id_company';
							// added by Adhe on 19.05.2010
							
							$data['class'] ='form-control';
							$data['title'] = $this->lang->line('company');
							$dataCmb = array();
							if(is_array($dataCompany)){
								foreach($dataCompany as $item){
									$dataCmb[$item['id_company']] = $item['name_company'];
								}
							}
							echo form_dropdown("id_company",$dataCmb,"",$data);
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo form_label($this->lang->line('division').'*','division'); ?></th>
					<td>
						<?php 
							$data['name'] = $data['id'] = 'division_name';
							// added by Adhe on 19.05.2010
							$data['maxlength'] = '50';
							$data['class'] ='form-control';
							$data['value'] = (set_value('division_name')) ? set_value('division_name') :"";
							//$data['title'] = $this->lang->line('valid_company');
							echo form_input($data);
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo form_label($this->lang->line('division').'COA*','division_coa'); ?></th>
					<td>
						<?php 
							$data['name'] = $data['id'] = 'division_coa';
							// added by Adhe on 19.05.2010
							$data['maxlength'] = '50';
							$data['class'] ='form-control';
							$data['value'] = (set_value('division_coa')) ? set_value('division_coa') :"";
							//$data['title'] = $this->lang->line('valid_company');
							echo form_input($data);
						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php
							echo form_submit('simpan',$this->lang->line('simpan'), "id = 'button-save'" );
						?>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-md-12" id="add_departement_form" style="display:none">
		<form action="<?php echo base_url("setting/add_departement") ?>" method="post">
			<table class="table color-table info-table">
				<tr>
					<th><?php echo form_label($this->lang->line('company').'*','id_company'); ?></th>
					<td>
						<?php 
							$data['id'] = 'id_company2';
							// added by Adhe on 19.05.2010
							
							$data['class'] ='form-control';
							$data['title'] = $this->lang->line('company');
							$dataCmb = array();
							if(is_array($dataCompany)){
								foreach($dataCompany as $item){
									$dataCmb[$item['id_company']] = $item['name_company'];
								}
							}
							echo form_dropdown("id_company2",$dataCmb,"",$data);
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo form_label($this->lang->line('division').'*','id_division'); ?></th>
					<td>
						<?php 
							$data['id'] = 'id_division';
							// added by Adhe on 19.05.2010
							
							$data['class'] ='form-control';
							$data['title'] = $this->lang->line('company');
							$dataCmb = array();
							echo form_dropdown("id_division",$dataCmb,"",$data);
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo form_label($this->lang->line('departement').'*','departement'); ?></th>
					<td>
						<?php 
							$data['name'] = $data['id'] = 'departement_name';
							// added by Adhe on 19.05.2010
							$data['maxlength'] = '50';
							$data['class'] ='form-control';
							$data['value'] = (set_value('departement_name')) ? set_value('departement_name') :"";
							//$data['title'] = $this->lang->line('valid_company');
							echo form_input($data);
						?>
					</td>
				</tr>
				<tr>
					<th><?php echo form_label($this->lang->line('departement').'COA*','departement_coa'); ?></th>
					<td>
						<?php 
							$data['name'] = $data['id'] = 'departement_coa';
							// added by Adhe on 19.05.2010
							$data['maxlength'] = '50';
							$data['class'] ='form-control';
							$data['value'] = (set_value('departement_coa')) ? set_value('departement_coa') :"";
							//$data['title'] = $this->lang->line('valid_company');
							echo form_input($data);
						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php
							echo form_submit('simpan',$this->lang->line('simpan'), "id = 'button-save'" );
						?>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-md-6">
		<!-- <button class="btn btn-primary" id="add_hospital">Add Hostpital</button> -->
		<button class="btn btn-primary" id="add_division"><?php echo $this->lang->line('tambah').' '.$this->lang->line('division'); ?></button>
		<button class="btn btn-primary" id="add_departement"><?php echo $this->lang->line('tambah').' '.$this->lang->line('departement'); ?></button>
	</div>
</div>
<h3><?= $this->lang->line('list_currency') ?></h3>
 <div class="table-responsive m-t-5">
    <table id="example23group" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('company') ?></th>
		<th ><?= $this->lang->line('division') ?></th>
		<th ><?= $this->lang->line('departement') ?></th>
		<!-- <th ><?= $this->lang->line('kode_akun') ?></th> -->
		
		
	</tr>
	</thead>
	<tbody>
	<?php
	$name_company = "";
	$division_name = "";
	$departement_name = "";
	foreach ($company_data as $key => $value) {
		/*if($name_company != $value['name_company']){
			$company = $value['name_company'];
		}else{
			$company = "testing";
		}
		if($division_name != $value['division_name']){
			$division_name = $value['division_name'];
		}else{
			$division_name = "";
		}
		if($departement_name != $value['departement_name']){
			$departement_name = $value['departement_name'];
		}else{
			$departement_name ="";
		}*/

		echo '<tr>';
		echo '<td>'.$value['name_company'].'</td>';
		echo '<td>'.$value['division_name'].'</td>';
		echo '<td style="padding-left:40px;">'.$value['departement_name'].'</td>';
		//echo '<td>'.$value['departement_coa'].'</td>';
		//echo '<td>'.$value['company_phone'].'</td>';
		//echo '<td></td>';
		echo '</tr>';

		$company = $value['name_company'];
	}
	?>
	 </tbody>
	 	<tfoot>
	<tr>
		<th ><?= $this->lang->line('company') ?></th>
		<th ><?= $this->lang->line('division') ?></th>
		<th ><?= $this->lang->line('departement') ?></th>
		<!-- <th ><?= $this->lang->line('kode_akun') ?></th> -->
		
	</tr>
	</tfoot>	
</table>
</div>
</div>
</div>
<script type='text/javascript'>
//Validasi di client
jQuery(document).ready(function()
{
    var $company = jQuery("#id_company").select2();
    var $company2 = jQuery("#id_company2").select2();
    var $division = jQuery("#id_division").select2();

    $company2.on('select2:select', function (e) { 
            loadDivision();
    });

    function loadDivision(){
        $.getJSON("<?php echo base_url('setting/loadDivision') ?>/"+$company2.val(),function(result){
            //clear terlebih dahulu
            $division.val(null).trigger('change');


            $division.select2({
              data: result
            })
            //validateCoa($company.val(),0);//ambil 0 string dari kode akun yang d textbox
        });
    }
    
    $("#add_hospital").click(function(){
            $("#add_company").show("slow");
            $("#add_division_form").hide("slow");
            $("#add_departement_form").hide("slow");
    })
    $("#add_division").click(function(){
            $("#add_company").hide("slow");
            $("#add_division_form").show("slow");
            $("#add_departement_form").hide("slow");
    })
    $("#add_departement").click(function(){
            $("#add_company").hide("slow");
            $("#add_division_form").hide("slow");
            $("#add_departement_form").show("slow");
            loadDivision();
    })


});	
</script>
<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;

$(document).ready(function() {
    
    $(function () {
    var table = $('#example23group').DataTable({
            "columnDefs": [{
                    "visible": false,
                    "targets": 0
                    },{
                    "visible": false,
                    "targets": 1
                    }],
            "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({
                    page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(0, {
                    page: 'current'
                    }).data().each(function (group, i) {

                            if (last !== group) {
                            $(rows).eq(i).before('<tr class="group" style="background-color:#167eea;color:#FFFF"><td colspan="3">' + group + '</td></tr>');
                            last = group;
                            }
                    });
                    api.column(1, {
                    page: 'current'
                    }).data().each(function (group, i) {

                            if (last !== group) {
                            $(rows).eq(i).before('<tr class="group" style="background-color:#5d8fc3;color:#FFFF;"><td colspan="3" style="padding-left:20px;">' + group + '</td></tr>');
                            last = group;
                            }
                    });
            }
            });
    });
});
</script>
