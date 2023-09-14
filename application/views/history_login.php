<table id="tHis" class="table table-hover mt-5">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Id User</th>
            <th scope="col">Nama </th>
            <th scope="col">Email</th>
            <th scope="col">IP Address</th>
            <th scope="col">Waktu</th>
        </tr>
    </thead>
    <tbody>

        <?php $i = 0;
        foreach ($allhistory as $p) : ?>
            <tr>
                <td scope="col"><?= $i + 1; ?></th>
                <td scope="col"><?= $p->id_user; ?></td>
                <td scope="col"><?= $p->name; ?> </td>
                <td scope="col"><?= $p->email; ?></td>
                <td scope="col"><?= $p->ip; ?></td>
                <td scope="col"><?= $p->datetime; ?></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>

    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tHis').DataTable();
    })
</script>