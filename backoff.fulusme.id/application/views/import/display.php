<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/material/plugins/dropify/dist/css/dropify.min.css">
<style type="text/css">
	.dropify-wrapper .dropify-message p {
		text-align: center;
	}
</style>

<div class="post-title col-lg-12">
	<h3><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
</div>
		
<div class="post-body">

	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Import From Excel</h4>

				<?php echo form_open_multipart( $form_action ); ?>
					<div class="form-group text-center">
						<input type="file" id="input-file-now" name="file_upload" class="dropify" />
					</div>
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary btn-block" value="Import Sekarang">
					</div>
				</form>
			</div>
		</div>
	</div>

</div>


<script src="<?php echo base_url(); ?>assets/material/plugins/dropify/dist/js/dropify.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		// Basic
		$('.dropify').dropify();
	});
</script>