<script type="text/javascript" charset="utf-8">
    $(function() {

        $('#button-save').click(function() {

            var bln = $('#bulan').val();

            var thn = $('#tahun').val();

            oTable.fnClearTable();

            $.post('<?php echo site_url() . 'invoice/search' ?>', {

                    bulan: bln,

                    tahun: thn

                },

                function(msg) {

                    if (msg) {

                        msg = eval(msg);

                        oTable.fnAddData(msg);

                    }

                }

            );

        });

    });
</script>



<div class="col-lg-12">

    <div class="card">

        <div class="card-body">

            <div class="post-body">

                <?php

                if ($this->session->userdata('SUCCESSMSG')) {

                    echo "<div class='success'>" . $this->session->userdata('SUCCESSMSG') . "</div>";

                    $this->session->unset_userdata('SUCCESSMSG');
                }

                $data['class'] = 'input';

                ?>

                <div class="col-lg-12">

                    <div class="panel panel-info">

                        <div class="panel-heading">

                            <h4><?= $this->lang->line('filter_data') ?></h4>

                        </div>

                        <div class="panel-body">

                            <?php echo form_open('purchasing/purchasing_hutang'); ?>

                            <div class="panel panel-info">

                                <div class="panel-body">

                                    <div class="row">

                                        <!-- <div class="col-4">

											<?php echo form_label("Tanggal", 'tanggal'); ?> :

											<?php

                                            $datatgl['name'] = 'tanggal1';

                                            $datatgl['type'] = 'date';

                                            $datatgl['id'] = 'datepicker';

                                            $datatgl['class'] = "form-control";



                                            echo form_input($datatgl);

                                            ?>

										</div> -->

                                        <div class="col-4 form-group">

                                            <label>Id Project</label>

                                            <select class="form-control select2" name="projectId" id="projectId">

                                                <option selected disabled>Pilih Project ...</option>

                                                <?php foreach ($project as $row) : ?>

                                                    <option value="<?= $row->id_project ?>"><?= $row->id_project ?></option>

                                                <?php endforeach ?>

                                            </select>

                                        </div>

                                        <div class="col-4 align-middle pt-4">

                                            <button type="submit" name="submit" class="btn btn-info btn-sm" value="filter"><i class="fa fa-search"></i> <?= $this->lang->line('filter_data') ?></button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php echo form_close(); ?>

                        </div>

                    </div>

                </div>

                <?php echo $this->session->flashdata('message'); ?>

                <br />

                <div class="col-lg-12">

                    <div class="panel panel-info">

                        <div class="panel-heading"><i class="fa fa-th-list"></i> <?= $this->lang->line('detail_data') ?></div>

                        <div class="panel-body">

                            <div class="table-responsive m-t-5">

                                <table class="display" id="table_data_hutang">

                                    <thead>

                                        <tr>

                                            <th>Project ID</th>

                                            <th><?php echo $this->lang->line('no_invoice'); ?></th>

                                            <th style="width: 60px"><?php echo $this->lang->line('tanggal_invoice'); ?></th>

                                            <th>Customer</th>

                                            <th><?php echo $this->lang->line('jumlah'); ?> </th>

                                            <th><?php echo $this->lang->line('total_bayar'); ?> </th>

                                            <th><?php echo $this->lang->line('sisa'); ?> </th>

                                            <th>Status </th>

                                            <th></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        if ($journal_data) {

                                            foreach ($journal_data as $row) {

                                                $total_dibayar = $this->purchasing_model->get_dibayar($row->id);

                                                if (!$total_dibayar) {

                                                    $tot_dibayar = 0;
                                                } else {

                                                    $tot_dibayar = $total_dibayar->nominal;
                                                }

                                                if ($tot_dibayar < $row->nominal) {

                                                    $stslunas = "<span class='label label-danger'>" . $this->lang->line('belum_lunas') . "</span>";
                                                } else {

                                                    $stslunas = "<span class='label label-success'>" . $this->lang->line('lunas') . "</span>";
                                                }

                                                echo '<tr>';

                                                echo '<td>' . $row->id_project . '</td>';

                                                echo '<td>' . $row->no_invoice . '</td>';

                                                echo '<td>' . $row->create_ts . '</td>';

                                                echo '<td>' . $row->full_name . '</td>';

                                                echo '<td>' . number_format($row->nominal) . '</td>';

                                                echo '<td>' . number_format($tot_dibayar) . '</td>';

                                                echo '<td>' . number_format($row->nominal - $tot_dibayar) . '</td>';

                                                echo '<td>' . $stslunas . '</td>';

                                                echo '<td>' . anchor(site_url() . "purchasing/debt_payment/" . $row->id, 'Detail') . '</td>';

                                                echo '</tr>';
                                            }
                                        }

                                        ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<script type="text/javascript">
    $(document).ready(function() {

        $('#table_data_hutang').DataTable({

            "order": [

                [1, "asc"]

            ]

        });

    });
</script>