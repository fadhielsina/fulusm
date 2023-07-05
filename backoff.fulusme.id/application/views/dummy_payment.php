<!DOCTYPE html>
<html>

<head>
    <title>Dummy Payment</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">
        #results {
            padding: 20px;
            border: 1px solid;
            background: #ccc;
        }
    </style>
</head>

<body>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Id Project</th>
                    <th scope="col">Nominal</th>
                    <th scope="col">Total Lot</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_pendanaan as $pendanaan) : ?>
                    <tr>
                        <th scope="row"><?= $pendanaan['project_id']; ?></th>
                        <td><?= number_format($pendanaan['nominal']); ?></td>
                        <td><?= $pendanaan['total_lot'] ?></td>
                        <?php if ($pendanaan['status'] == 0) : ?>
                            <td><a href="<?= base_url('user/postPayment/') ?><?= $pendanaan['id'] ?>" class="btn btn-sm btn-success">Bayar</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

</body>

</html>