<div class="post-body">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-5">
                    <h4 class="card-title"><?= $title ?></h4>
                    <table id="table_peminjam" class="display">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Nama</th>
                                <th>KTP</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Telpon</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($user_data) {
                                $i = 0;
                                foreach ($user_data as $row) {
                                    echo '<tr>';
                                    echo '<td class="text-center">' . $row->user_id . '</td>';
                                    echo '<td>' . $row->name . '</td>';
                                    echo '<td>' . $row->ktp . '</td>';
                                    echo '<td>' . $row->address . '</td>';
                                    echo '<td>' . $row->email_user . '</td>';
                                    echo '<td>' . $row->phone . '</td>';
                                    echo '<td><a href="' . base_url('' . $link_detail . '') . $row->id_user . '"class="btn btn-primary btn-sm">Detail</a></td>';
                                    echo '</tr>';
                                    $i++;
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_peminjam').DataTable();

    });
</script>