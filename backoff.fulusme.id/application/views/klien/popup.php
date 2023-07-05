<script type="text/javascript" charset="utf-8">
	$(function() {
		popup_table = $('#popup').dataTable({
			"bJQueryUI": true,
			 destroy: true,
			searching: false,
			"sPaginationType": "full_numbers"
		});

	});
</script>

<div id="dialog-form_addajx"></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="mydata">
	<thead>
		<tr>
			<th>ID</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>No. Telp</th>
			<th></th>									
		</tr>
	</thead>
	 <tbody id="show_data">
                 
            </tbody>
</table>
<br/>
<a id="OpenDialog" class="btn btn-info btn-sm"> Tambah </a>

 <script type="text/javascript">
        $(document).ready(function () {
            $("#OpenDialog").click(function () {
                $("#dialog").dialog({modal: true, height: 590, width: 1005,title: 'Tambah Data Klien', });
            });
        });
    </script>
	
	<a id="reloaddataklien" class="btn btn-warning btn-sm"> Refresh Data Klien </a>
   

<script type="text/javascript" charset="utf-8">


$('#reloaddataklien').click( function() { 
		$('#popup').dataTable();
		alert('Reload data berhasil!!');
		
});
</script>

 <div id="dialog" title="Dialog Title" style="display: none" >
<form action="" method="POST" id="klien_form" class="form-group">

	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">	
			<tr>
			<th><?php echo form_label('Divisi *','nama'); ?></th>
			<td>
				<select name="divisi" >
					<option value="C">Car (C)</option>	
					<option value="B">Instalasi (B)</option>
					<option value="S">SO (S)</option>
										</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Nama *','nama'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama';
					$data['class'] = 'form-control';
					$data['title'] = "Nama tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('No Identitas *','identitasno'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'no_identitas';
					$data['title'] = "Identitas tidak boleh kosong";						
					echo form_input($data);
				?>
			</td>
		</tr>			
		<tr>
			<th><?php echo form_label('NPWP','npwp'); ?></th>
			<td>
				<?php 
					$nomor['title'] = "NPWP harus diisi dengan angka";	
					$nomor['name'] = $nomor['id'] = 'npwp';
					$nomor['maxlength']='2';
					$nomor['size']='4';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp1';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp2';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp3';
					$nomor['maxlength']='1';
					$nomor['size']='2';
					echo form_input($nomor);

					echo "&nbsp;-";

					$nomor['name'] = $nomor['id'] = 'npwp4';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp5';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);
				?>							
			</td>
		</tr>						
		<tr>
			<th><?php echo form_label('Alamat *','alamat'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'alamat';
					$data['title'] = "Alamat tidak boleh kosong";						
					echo form_input($data);
				?>
			</td>
		</tr>									
		<tr>
			<th><?php echo form_label('Telpon *','telpon'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'telpon';
					$data['title'] = "Telpon tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Email','email'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'email';
					$data['title'] = "Email harus diisi dengan format email yang benar. Contoh : klien@frigia.com";			
					echo form_input($data);
				?>
			</td>
		</tr>		
			<tr><td></td><td> <input id="submit-p" class="btn btn-info" type="submit" value="Tambah Klien"></td></tr>
	</table>
	
	

<?php echo form_close(); ?>
    </div>
	
	<script type="text/javascript">
    $(document).ready(function(){
        tampil_data_barang();   //pemanggilan fungsi tampil barang.
         
        $('#mydata').dataTable();
          
        //fungsi tampil barang
        function tampil_data_barang(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url()?>auto/data_member',
                async : false,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                                '<td>'+data[i].memberFullName+'</td>'+
                                '<td>'+data[i].memberCode+'</td>'+
                                '<td>'+data[i].memberAddress+'</td>'+
								 '<td>'+data[i].memberAddress+'</td>'+
                                '</tr>';
                    }
                    $('#show_data').html(html);
                }
 
            });
        }
 
    });
 
</script>


	<script>
    $(document).ready(function(){
        $("#klien_form").submit(function(e){
            e.preventDefault();
            var divisi = $("#divisi").val();;
            var nama= $("#nama").val();
			 var no_identitas= $("#no_identitas").val();
			  var npwp= $("#npwp").val();
			   var npwp1= $("#npwp1").val();
			    var npwp2= $("#npwp2").val();
				 var npwp3= $("#npwp3").val();
				  var npwp4= $("#npwp4").val();
				   var npwp5= $("#npwp5").val();
				    var alamat= $("#alamat").val();
				var telpon= $("#telpon").val();
				var email= $("#email").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>index.php/klien/insert',
                data: {divisi:divisi,nama:nama,no_identitas:no_identitas,npwp:npwp,npwp1:npwp1,npwp2:npwp2,npwp3:npwp3,npwp4:npwp4,npwp5:npwp5,alamat:alamat,telpon:telpon,email:email},
                success:function(data)
                {
					$('#dialog').dialog('close');
                    alert('SUCCESS!!');
                },
                error:function()
                {
                    alert('fail');
                }
            });
        });
    });
</script>
