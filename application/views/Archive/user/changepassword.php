<div class="container-fluid">
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>	

		<div class="col-lg-8">
			<?= $this->session->flashdata('message'); ?>
			<?= form_open_multipart('user/changepassword');?>
				<div class="form-group">
				    <label for="current_password" class="col-form-label">Password Lama</label>
				    
				      <input type="password" class="form-control" id="current_password" name="current_password">
				      <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
				    
				  </div>
				  <div class="form-group">
				    <label for="new_password1" class="col-form-label">Password Baru</label>
				    
				      <input type="password" class="form-control" id="new_password1" name="new_password1" >
				      <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
				    
				  </div>
				  <div class="form-group">
				    <label for="new_password1" class="col-form-label">Ulang Password</label>
				    
				      <input type="password" class="form-control" id="new_password2" name="new_password2" >
				      <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
				    
				  </div>
				  <div class="form-group ">
				  	
				  		<button type="submit" class="btn btn-primary">Ganti Password</button>
				  	
				  </div>
			</form>
		</div>


	</div>
</div>