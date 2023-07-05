<br/>

<div class="post-body">



<?php echo $this->session->flashdata('message'); ?>

<?php

	if($this->session->userdata('SUCCESSMSG'))

	{

		echo "<div class='success'>".$this->session->userdata('SUCCESSMSG')."</div>";

		$this->session->unset_userdata('SUCCESSMSG');

	}

?>

<br/><br/>

<div class="col-lg-12">

<div class="card">

  <div class="card-body">

  <h4 class="card-title">Tipe Scoring</h4>
  <div class="pull-right">

		<?php

			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => 'Tambah Tipe', 'onClick' => "location.href='".site_url()."scoring/addType'" ));

		?>

	</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">

		<thead>

			<tr>

				<th>Nama Type</th>

				<!-- <th></th> -->

			</tr>

		</thead>

		<tbody>

    <?php

    foreach ($type_scoring as $row) : ?>

      <tr>

        <td><?= $row['nama_tipe'] ?></td>

        <!-- <td><a href="<?= base_url('scoring/detail') ?>/<?= $row['id'] ?>">Detail</a></td> -->

      </tr>

    <?php endforeach; ?>

		</tbody>

		<tfoot>

			<tr>

				<th>Nama Type</th>

				<!-- <th></th> -->

			</tr>

		</tfoot>

	</table>

</div>

</div>



<?php if ($cek == 'Y') : ?>

<div class="card">

  <div class="card-body">

	  <h4 class="card-title"><a href="<?= base_url('data_pendana') ?>" class="btn btn-primary btn-sm">Close</a></h4>

	</div>

</div>

<?php endif; ?>



</div>

</div>

