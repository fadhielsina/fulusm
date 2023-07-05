<style>
    .form-control:disabled,
    .form-control[readonly] {
        opacity: 1;
    }

    .form-control {
        font-size: 13px;
        color: black;
    }
</style>

<div class="post-title col-lg-12">

    <?php echo $this->session->flashdata('message'); ?>
    <?php
    if ($this->session->userdata('SUCCESSMSG')) {
        echo "<div class='success'>" . $this->session->userdata('SUCCESSMSG') . "</div>";
        $this->session->unset_userdata('SUCCESSMSG');
    }
    ?>
    <div class="card">
        <h1><a href="<?= base_url('project/project_detail') ?>/<?= $data_project->project_id ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
        <div class="container">
            <form action="<?= base_url('data_peminjam/edit_document') ?>/<?= $data_project->project_id ?>" method="post" enctype="multipart/form-data">
                <div class="form-row text-center">
                    <div class="form-group col-md-6">
                        <label>ID Pengelola Dana</label>
                        <input type="text" readonly class="form-control text-center" id="id_peminjam" value="<?= $data_project->peminjam_id ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama Pengelola Dana</label>
                        <input type="text" readonly class="form-control text-center" id="nama_peminjam" value="<?= $data_project->name ?>">
                    </div>
                </div>
                <div class="form-row text-center">
                    <div class="form-group col-md-6">
                        <label>ID Project</label>
                        <input type="text" readonly class="form-control text-center" id="id_project" name="id_project" value="<?= $data_project->project_id ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama Project</label>
                        <input type="text" readonly class="form-control text-center" id="nama_project" value="<?= $data_project->nama_project ?>">
                    </div>
                </div>
                <?php if ($update_doc) {
                    $data_project = $update_doc;
                } ?>
                <div class="form-row text-center">
                    <div class="form-group col-md-4">
                        <h4 class="card-title">SPK</h4>
                        <input type="file" id="spk_file" name="spk_file" class="dropify" data-default-file="<?= $this->config->item('front_url') ?>assets/img/profile/<?= $data_project->spk ?>" />
                        <input type="hidden" id="spk" name="spk" value="<?= $data_project->spk ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <h4 class="card-title">LOA</h4>
                        <input type="file" id="loa_file" name="loa_file" class="dropify" data-default-file="<?= $this->config->item('front_url') ?>assets/img/profile/<?= $data_project->loa ?>" />
                        <input type="hidden" id="loa" name="loa" value="<?= $data_project->loa ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <h4 class="card-title">Kontrak</h4>
                        <input type="file" id="kontrak_file" name="kontrak_file" class="dropify" data-default-file="<?= $this->config->item('front_url') ?>assets/img/profile/<?= $data_project->kontrak ?>" />
                        <input type="hidden" id="kontrak" name="kontrak" value="<?= $data_project->kontrak ?>">
                    </div>
                </div>
                <div class="form-row text-center">
                    <div class="form-group col-md-4">
                        <h4 class="card-title">Rekening Koran</h4>
                        <input type="file" id="rekening_koran_file" name="rekening_koran_file" class="dropify" data-default-file="<?= $this->config->item('front_url') ?>assets/img/profile/<?= $data_project->rekening_koran ?>" />
                        <input type="hidden" id="rekening_koran" name="rekening_koran" value="<?= $data_project->rekening_koran ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <h4 class="card-title">Profil Perusahaan</h4>
                        <input type="file" id="profil_perusahaan_file" name="profil_perusahaan_file" class="dropify" data-default-file="<?= $this->config->item('front_url') ?>assets/img/profile/<?= $data_project->profil_perusahaan ?>" />
                        <input type="hidden" id="profil_perusahaan" name="profil_perusahaan" value="<?= $data_project->profil_perusahaan ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <h4 class="card-title">Laporan Keuangan</h4>
                        <input type="file" id="laporan_keuangan_file" name="laporan_keuangan_file" class="dropify" data-default-file="<?= $this->config->item('front_url') ?>assets/img/profile/<?= $data_project->laporan_keuangan ?>" />
                        <input type="hidden" id="laporan_keuangan" name="laporan_keuangan" value="<?= $data_project->laporan_keuangan ?>">
                    </div>
                </div>
                <div class="form-row text-center">
                    <div class="form-group col-md-4">
                        <h4 class="card-title">Prospektus</h4>
                        <input type="file" id="dokumen_pendukung_file" name="dokumen_pendukung_file" class="dropify" data-default-file="<?= $this->config->item('front_url') ?>assets/img/profile/<?= $data_project->prospektus ?>" />
                        <input type="hidden" id="dokumen_pendukung" name="dokumen_pendukung" value="<?= $data_project->dokumen_pendukung ?>">
                    </div>
                    <div class="col-md-4">
                        <div class="container mt-5">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan perubahan?')">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>