<div class="card">
    <div class="card-body">
        <?php if ($formProject) { ?>
            <form action="<?= base_url('project/form_project') ?>/<?= $data_project->id_project ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <label><b>Masukan Auth Password</b></label> <span class="float-right">
                            <!-- <h6><a href="<?= base_url('data_peminjam/resendEmail') ?>/<?= $data_project->project_id ?>">Resend Token</a></h6> -->
                        </span>
                        <input type="password" id="token" name="token" class="form-control">
                        <?= $this->session->flashdata('message_token'); ?>
                        <small class="text-danger"> <?= form_error('token'); ?> </small>
                    </div>
                    <?php if ($formProject->tipe == "Murabahah") : ?>
                        <div class="col">
                            <label>Uang Muka (Murabahah)</label>
                            <input class="form-control" type="text" onkeyup="formatNumber(this);" name="uang_muka" id="uang_muka">
                        </div>
                    <?php endif; ?>
                    <div class="col">
                        <label>Noted</label>
                        <textarea name="noted" id="noted" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col">
                        <button type="submit" name="submitpost" class="btn btn-primary" onclick="return confirm('Post Project ini ke marketplace?')">Approve & Post To Marketplace</button>
                    </div>
                    <div class="col text-center">
                        <button type="submit" name="revisi" class="btn btn-warning" onclick="return confirm('Revisi Project Ini?')">Revision</button>
                    </div>
                    <div class="col">
                        <button type="submit" name="rejected" class="btn btn-danger float-right" onclick="return confirm('Anda akan reject project ini?')">Reject</button>
                    </div>
                </div>
            </form>

        <?php } else { ?>

            <form action="<?= base_url('project/form_project') ?>/<?= $data_project->id_project ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_project" id="id_project" value="<?= $data_project->id_project ?>">
                <input type="hidden" name="id_peminjam" id="id_peminjam" value="<?= $data_project->peminjam_id ?>">
                <input type="hidden" name="nama_peminjam" id="nama_peminjam" value="<?= $user_data[0]->name ?>">
                <input type="hidden" name="nama_project" id="nama_project" value="<?= $data_project->nama_project ?>">
                <?php $query = $data_project;
                if ($history_project != null) {
                    $query = $history_project;
                }
                ?>
                <input type="hidden" name="crowdfound_period" id="crowdfound_period" value="<?= $query->crowdfound_period ?>">
                <input type="hidden" name="tenor" id="tenor" value="<?= $query->tenor ?>">
                <input type="hidden" name="nilai_project" id="nilai_project" value="<?= $query->nilai_project ?>">
                <input type="hidden" name="modal_project" id="modal_project" value="<?= $query->modal_project ?>">
                <input type="hidden" name="harga_perlot" id="harga_perlot" value="<?= $query->harga_perlot ?>">
                <input type="hidden" name="keuntungan" id="keuntungan" value="<?= $query->keuntungan ?>">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-4 mr-3">
                            <label for="input-file-now">Upload Prospektus File</label>
                            <input type="file" id="proposal" name="proposal" class="dropify" data-max-file-size="2M" />
                            <!-- <small class="text-danger"> <?= form_error('proposal'); ?> </small> -->
                        </div>
                        <div class="col-lg-6">
                            <label for="input-file-now">Upload Foto Project</label>
                            <input type="file" id="image_project" name="files[]" multiple class="dropify" data-max-file-size="2M" />
                            <!-- <small class="text-danger"> <?= form_error('image_project'); ?> </small> -->
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-left:-2px; margin-right:1px;">
                    <div class="form-group col">
                        <label>Pembagian Hasil Pemodal %</label>
                        <input type="text" class="form-control" onkeyup="formatNumber(this);hitung_pembagian()" name="pem_pendana" id="pem_pendana" value="<?= $grade->hasil_pendana ?>">
                        <small class="text-danger"> <?= form_error('pem_pendana'); ?> </small>
                    </div>

                    <div class="form-group col">
                        <label>Pembagian Hasil Penerbit %</label>
                        <input type="text" class="form-control" readonly onkeyup="formatNumber(this);" name="pem_peminjam" id="pem_peminjam" value="<?= $grade->hasil_peminjam ?>">
                        <small class="text-danger"> <?= form_error('pem_peminjam'); ?> </small>
                    </div>
                </div>

                <div class="form-group col">
                    <label>Jenis Pendanaan</label>
                    <select class="form-control" id="tipe" name="tipe">
                        <option disabled selected>Pilih Jenis</option>
                        <option value="1">Equitas</option>
                        <option value="2">Pendanaan</option>
                    </select>
                    <small class="text-danger"> <?= form_error('tipe'); ?> </small>
                </div>

                <div class="row" style="margin-left:-2px; margin-right:1px;">
                    <div class="form-group col">
                        <label>Jenis Pengembalian</label>
                        <select class="form-control" name="jenis_pengembalian" id="jenis_pengembalian" onchange="jenis();">
                            <option disabled selected>Pilih Jenis</option>
                            <option value="0">Di Akhir</option>
                            <option value="1">Per Bulan</option>
                        </select>
                        <small class="text-danger"> <?= form_error('jenis_pengembalian'); ?> </small>
                    </div>
                    <div class="form-group col" id="tambahan">
                    </div>
                </div>

                <!-- <div class="form-group col-6">
							<label>Nominal Pengembalian</label>
							<input class="form-control" type="text" onkeyup="formatNumber(this)" name="nominal_pengembalian" id="nominal_pengembalian">
							<small class="text-danger"> <?= form_error('nominal_pengembalian'); ?> </small>
						</div> -->

                <div class="text-center">
                    <button type="submit" name="save_form" class="btn waves-effect waves-light btn-outline-primary" onclick="return confirm('Save Project ini?')">Save</button>
                </div>
            </form>

        <?php } ?>

    </div>
</div>

<script>
    $("#image_project").on("change", function() {
        if ($("#image_project")[0].files.length > 4) {
            alert("Yang tersimpan maksimal hanya 4 file");
        }
    });
</script>