<link href="https://wrappixel.com/demos/admin-templates/material-pro/assets/plugins/morrisjs/morris.css" rel="stylesheet">

<?php
$language = $this->athoslib->listLanguage();
$active = $this->athoslib->activeLang();
//if(isset($periode['nama_periode'])){; 
?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor"><?php echo $this->lang->line('dash_dashboard'); ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('dash_home'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo $this->lang->line('dash_dashboard'); ?></li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">

    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card-body">
            <div class="card">
                <div class="text-center">
                    <h4 class="pt-1">Securities Crowd Funding</h4>
                </div>
                <div class="card-body border-top collapse show">
                    <div class="list-group mb-4">
                        <li class="list-group-item list-group-item-warning">
                            <?= "Jatuh tempo ( H-3 )" ?>
                        </li>
                        <?php foreach ($crowdfunding as $row) : ?>
                            <?php $query_modal = $this->db->get_where('history_project', ['id' => $row['id_project']])->row(); ?>
                            <?php if ($query_modal) {
                                $modal = $query_modal->modal_project;
                            } ?>
                            <?php if ($query_modal) : ?>
                                <?php if ($modal <= $row['dana_terkumpul']) : ?>
                                    <?php if ($row['tgl_deadline'] <= date('Y-m-d', strtotime("+3 day")) && $row['tgl_deadline'] >= date('Y-m-d')) : ?>
                                        <a href="<?= base_url('project/detail') ?>/<?= $row['id_project'] ?>" class="list-group-item list-group-item-action"><?= $row['nama_project'] ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="list-group mb-4">
                        <li class="list-group-item list-group-item-danger">
                            <?= "Yang tidak terkumpul" ?>
                        </li>
                        <?php foreach ($project_tidak_terkumpul as $row) : ?>
                            <?php if ($row->nama_project == 'Project Retail') : ?>
                                <?php $nama_toko = $this->db_fulus->get_where('project_retail', ['id_project' => $row->id_project])->row()->nama_toko; ?>
                                <a href="<?= base_url('project_retail/market_place') ?>/<?= $row->id_project ?>" class="list-group-item list-group-item-action"><?= $row->nama_project ?></a>
                            <?php else : ?>
                                <a href="<?= base_url('project/detail') ?>/<?= $row->id_project ?>" class="list-group-item list-group-item-action"><?= $row->nama_project ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="list-group mb-4">
                        <li class="list-group-item list-group-item-success">
                            <?= "Terkumpul ( H+2 )" ?>
                        </li>
                        <?php foreach ($project_terkumpul as $row) : ?>
                            <a href="<?= base_url('project/detail') ?>/<?= $row->id_project ?>" class="list-group-item list-group-item-action"><?= $row->nama_project ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card-body">
            <div class="card">
                <div class="text-center">
                    <h4 class="pt-1">Pengembalian Dividen</h4>
                </div>
                <div class="card-body border-top collapse show">
                    <div class="list-group mb-4">
                        <li class="list-group-item list-group-item-warning">
                            <?= "Jatuh tempo ( H-3 s.d H )" ?>
                        </li>
                        <?php foreach ($pengembalian_project as $row) : ?>
                            <?php if (date('Y-m-d', strtotime("+3 day")) >= $row->tgl_tempo && date('Y-m-d', strtotime("-3 day")) <= $row->tgl_tempo) : ?>
                                <a href="<?= base_url('transaksi/form_bayar') ?>/<?= $row->id_project ?>" class="list-group-item list-group-item-action"><?= $row->nama_project ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="list-group mb-4">
                        <li class="list-group-item list-group-item-danger">
                            <?= " >H, ( H+30, H+60 )" ?>
                        </li>
                        <?php foreach ($pengembalian_project as $row) : ?>
                            <?php if (date('Y-m-d') > $row->tgl_tempo) : ?>
                                <a href="<?= base_url('transaksi/form_bayar') ?>/<?= $row->id_project ?>" class="list-group-item list-group-item-action"><?= $row->nama_project ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="list-group mb-4">
                        <li class="list-group-item list-group-item-primary">
                            <?= "H+90" ?>
                        </li>
                        <?php foreach ($pengembalian_project as $row) : ?>
                            <?php if (date('Y-m-d', strtotime("-90 day")) > $row->tgl_tempo) : ?>
                                <a href="<?= base_url('transaksi/form_bayar') ?>/<?= $row->id_project ?>" class="list-group-item list-group-item-action"><?= $row->nama_project ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
//}else{
?>

<script src="<?php echo base_url() . 'assets/material' ?>/plugins/peity/jquery.peity.min.js"></script>
<script src="<?php echo base_url() . 'assets/material' ?>/plugins/raphael/raphael-min.js"></script>
<script src="<?php echo base_url() . 'assets/material' ?>/plugins/morrisjs/morris.js"></script>
<script type="text/javascript">
    $('#totalHutang').html("<?php echo  number_format($TotalHutang) ?>")
</script>
<script type="text/javascript">
    $("span.donut").peity("donut", {
        width: 150,
        height: 150
    });
</script>