<?php include 'check.php'; ?>
<?php $statistics = $query->select('statistics', '*') ?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>İstatistikler - Yönetim Paneli</title>
    <link href="../favicon.ico" rel="icon">
    <!-- CSS files -->
    <?php include 'includes/css.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Sayı</th>
                                        <th>Başlık</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($statistics as $statistic): ?>
                                        <tr>
                                            <td><?php echo $statistic['id']; ?></td>
                                            <td><?php echo $statistic['count']; ?></td>
                                            <td><?php echo $statistic['title']; ?></td>
                                            <td><?php echo $statistic['description']; ?></td>
                                            <td>
                                                <!-- Form için düzenleme butonu -->
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $statistic['id']; ?>">
                                                    Düzenle
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Düzenleme için modal -->
                                        <div class="modal fade" id="editModal<?php echo $statistic['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $statistic['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?php echo $statistic['id']; ?>">Düzenle</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="update_statistics.php" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $statistic['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="count">Sayı</label>
                                                                <input type="number" class="form-control" name="count" value="<?php echo $statistic['count']; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="title">Başlık</label>
                                                                <input type="text" class="form-control" name="title" value="<?php echo $statistic['title']; ?>" maxlength="100" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Açıklama</label>
                                                                <textarea class="form-control" name="description" required maxlength="255"><?php echo $statistic['description']; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                                            <button type="submit" class="btn btn-primary">Güncelle</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Ana Altbilgi -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- KOMUT DOSYALARI -->
    <?php include 'includes/js.php'; ?>
</body>

</html>