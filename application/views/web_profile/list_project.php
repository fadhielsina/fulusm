<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
};

function ribuan($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>

<!-- project-->
<div class="site-section" style="padding-top: 50px;">
    <div class="container">
        <div class="row border-responsive">
            <?php foreach ($project as $obj) { ?>

                <?php
                $idp = $obj['id'];
                $query_pendanaan = $this->db->select('COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.modal_project, 0) as jumlah_pendanaan,')
                    ->from('pendanaan')->join('project', 'project.id = pendanaan.project_id')
                    ->where('project.version', 1)
                    ->where('project.id', $idp)
                    ->group_start()
                    ->where('pendanaan.status', 0)->or_where('pendanaan.status', 1)
                    ->group_end()
                    ->get()->row();
                ?>

                <?php if ($query_pendanaan->jumlah_pendanaan >= 1 || $obj["totalhari"] - $obj["sisawaktu"] > 0) : ?>

                    <div class="col-md-6 col-lg-3 mt-5 mb-4 mb-lg-0 border-right" style="font-size:13px;">
                        <img <?php if ($obj["image"]) { ?> src="<?php echo base_url('assets/') . "img/profile/" . $obj["image"] ?> " style="border-bottom:4px #ff6f05 solid;border-top:4px #ff6f05 solid;margin-bottom:15px;width: 90%;height: 250px;border-radius:0 0 10% 10%; margin-left: auto;
  margin-right: auto;" <?php } else { ?> src="<?php echo base_url('assets/') ?>img/noimage.png" <?php } ?> style="border-bottom:4px #ff6f05 solid;margin-bottom:15px;width:70%;border-radius:0 0 20% 20%; margin-left: auto;
  margin-right: auto;">
                        <a href="#" class="kt-widget__title" style=" color: #040538; font-size: 15px;display: inline-block;
    padding: 0px;height: 50px;margin-bottom: 24% !important;margin-top: 16px;"><?php echo $obj["nama_project"] ?></a>



                        <?php if ($query_pendanaan->jumlah_pendanaan >= 1) { ?>
                            <a href="#" class="kt-widget__title">
                                <img class="card_holder_img" style="
                        max-width: 100%;
                        height: 86px;
                        object-fit: cover;
                        right: 22px;
                        position: absolute;
                        display: inline-block;
                        border-radius: 8px;
                        " src="https://www.fulusme.id/assets/img/lunas.jpeg">
                            </a>
                        <?php } ?>

                        <p style=" color: black;"> Efek Bersifat Utang </p>
                        <p>ID Proyek : <span style=" color: #fd7e14;"><?php echo $obj["id"] ?></span></p>

                        <?php if ($obj["code_saham_alias"]) {

                            $inikodealias = $obj["code_saham_alias"];
                        } else {
                            $inikodealias = "-";
                        } ?>

                        <p>Kode Efek : <span style=" color: #040538;"><?php echo $inikodealias ?></span></p>

                        <div class="kt-widget__text">
                            Efek Terjual
                        </div>
                        <div class="progress" style="height: 5px;width: 100%;">
                            <?php if ($query_pendanaan->jumlah_pendanaan > 1) : ?>
                                ?>
                                <div class="progress-bar kt-bg-success" role="progressbar" style="width: <?php echo 100 ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="kt-widget__stats">
                            <?php echo  100 ?>%
                        </div>
                    <?php else : ?>
                        <div class="progress-bar kt-bg-success" role="progressbar" style="width: <?php echo $query_pendanaan->jumlah_pendanaan * 100 ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget__stats">
                        <span style=" color: #040538;"><?php echo $query_pendanaan->jumlah_pendanaan * 100 ?>%</span>
                    </div>
                <?php endif; ?>
                <div class="kt-widget__text">
                    Sisa Waktu
                </div>
                <?php if ($query_pendanaan->jumlah_pendanaan >= 1) { ?>
                    <div class="progress" style="height: 5px;width: 100%;">
                        <div class="progress-bar kt-bg-success" role="progressbar" style="width:100%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget__stats">
                        <span style=" color: #040538;"> - Hari</span>
                    </div>
                <?php } else { ?>
                    <div class="progress" style="height: 5px;width: 100%;">
                        <div class="progress-bar kt-bg-success" role="progressbar" style="width: <?php echo $obj["persensisa"] * 100 ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget__stats">
                        <span style=" color: #040538;"><?php echo $obj["totalhari"] - $obj["sisawaktu"] ?> Hari</span>
                    </div>
                <?php } ?>
                <div class="kt-widget__item">
                    <span class="kt-widget__date">
                        Rating Proyek :
                    </span>

                    <div class="kt-widget__label-success">
                        <span class="btn btn-label-brand btn-sm btn-bold btn-upper btn-info" style="margin-bottom:10px;">
                            <?php if ($query_pendanaan->jumlah_pendanaan != 1) : ?>
                                <? if ($obj["prospektus"]) { ?>
                                    <a href="<?= base_url('assets/file_user/prospektus/') ?><?= $obj["prospektus"] ?>" target="_blank"> <span style=" color: #040538;"> Proposal Bisnis </span></a>
                                <? } else { ?>
                                    <a href="#" onClick="alert('Project ini tidak memiliki prospektus')"> Proposal Bisnis </a>
                                <? } ?><br />
                        </span>
                    <?php endif; ?>


                    <?php if ($query_pendanaan->jumlah_pendanaan == 1) { ?>
                        <!-- <button type="button" style="display: inline;background-color:#fd7e14;border-radius: 15px;" class="btn btn-brand btn-sm btn-upper" onClick="alert('Project ini sudah terdanai, tunggu project lainnya')">Beli</button> -->
                    <?php } else { ?>
                        <a href="<?= base_url('auth') ?>">
                            <button type="button" style="display: inline;background-color:#fd7e14;color:#fff;border-radius: 15px;" class="btn btn-block btn-sm ">Beli</button></a>
                    <?php } ?>
                    </div>
                </div>

                <!-- bottom -->
                <div class="accordion" id="accordionExample" style="margin-top:13%;">
                    <div class="card">
                        <div class="card-header" id="headingOne" style="padding:0px;background-color:#040538;border-radius: 15px;text-align:center;">
                            <h2 class="mb-0">
                                <a class="btn" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $obj["id"] ?>" aria-expanded="true" aria-controls="collapseOne" style="color:#fff;">
                                    Detail
                                </a>
                            </h2>
                        </div>
                        <div id="collapseOne<?php echo $obj["id"] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body" style="border:none;">

                                <div class="kt-widget__bottom">
                                    <div class="kt-widget__item">
                                        <div class="kt-widget__details">
                                            <span class="kt-widget__title">Total Pemodalan</span><br />
                                            <span class="kt-widget__value"><?php echo rupiah($obj["modal_project"]) ?>
                                        </div>



                                    </div>



                                    <div class="kt-widget__item" style="margin: 0;
    padding: 0;">

                                        <div class="kt-widget__details">


                                            <span class="kt-widget__title">Jumlah Efek yang diterbitkan</span><br />
                                            <span class="kt-widget__value" style="height: 50px;"><?php echo ribuan($obj["jumlah_lembar_shm"]) ?> Lembar Efek</span>
                                        </div>
                                    </div>




                                    <div class="kt-widget__item" style="margin: 0;
    padding: 0;">
                                        <div class="kt-widget__details">

                                            <span class="kt-widget__title">Harga Per Lembar Efek</span><br />
                                            <span class="kt-widget__value"><?php echo rupiah($obj["harga_perlembar_shm"]) ?></span>(Minimum Pembelian 1 Lot)



                                        </div>
                                    </div>


                                    <div class="kt-widget__item" style="margin: 0;
    padding: 0;">

                                        <div class="kt-widget__details">
                                            <span class="kt-widget__title">Harga Per 1 Lot Efek</span><br />
                                            <span class="kt-widget__value"><?php echo rupiah(100 * $obj["harga_perlembar_shm"]) ?></span>(Per 1 Lot 100 Lembar Efek)
                                        </div>
                                    </div>




                                    <div class="kt-widget__item" style="margin: 0;
    padding: 0;">

                                        <div class="kt-widget__details">
                                            <span class="kt-widget__title">Jumlah Lot</span><br />
                                            <span class="kt-widget__value"><?php echo (number_format($obj["jumlah_lot"])) ?></span>
                                        </div>
                                    </div>





                                    <div class="kt-widget__item" style="margin: 0;
    padding: 0;">

                                        <div class="kt-widget__details">
                                            <span class="kt-widget__title">Periode Dividen</span><br />
                                            <span class="kt-widget__value">6 bulan</span>
                                        </div>
                                    </div>

                                </div>
                                <!-- end bottom detail -->
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    <?php endif; ?>
<?php } ?>
    </div>
</div>
<!-- end project-->

<div class="site-section">

</div>