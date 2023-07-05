<div class="container-fluid">
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="row">
		<div class="col-lg-8">
			<?= form_open_multipart('user/edit'); ?>
			<div class="form-group row">
				<label for="email" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" readonly>
				</div>
			</div>
			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Full Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
					<?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">Picture
				</div>
				<div class="col-sm-10">
					<div class="row">
						<div class="col-sm-3">
							<img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
						</div>
						<div class="col-sm-9">
							<div class="custom-file">
								<input type="file" class="custom-file-input img-edit" id="foto" name="foto" onchange="return fileValidation('image')" for="image">
								<label style="white-space: nowrap;
								padding-right: 87px;
								overflow: hidden;
								text-overflow: ellipsis;" class="custom-file-label img-label" for="customFile">Choose file</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row justify-content-end">
				<div class="col-sm-10">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
			</form>
		</div>
	</div>

</div>
</div>




<script>
	function fileValidation(ini) {
		var fileInput =
			document.getElementById(ini);

		var filePath = fileInput.value;

		// Allowing file type 
		var allowedExtensions =
			/(\.jpg|\.jpeg|\.png)$/i;

		if (!allowedExtensions.exec(filePath)) {
			alert('tipe file tidak valid');
			fileInput.value = '';
			return false;
		}
	}
</script>