<?php include 'check.php'; ?>
<?php $services = $query->select('services', '*') ?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Hizmetler - Yönetim Paneli</title>
    <link href="../favicon.ico" rel="icon">
    <!-- CSS -->
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
                                        <th>Başlık</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services as $service): ?>
                                        <tr>
                                            <td><?php echo $service['id']; ?></td>
                                            <td><?php echo $service['title']; ?></td>
                                            <td><?php echo $service['description']; ?></td>
                                            <td>
                                                <!-- Hizmet için düzenleme butonu -->
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $service['id']; ?>">
                                                    Düzenle
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Hizmet düzenleme modalı -->
                                        <div class="modal fade" id="editModal<?php echo $service['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $service['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?php echo $service['id']; ?>">Düzenle</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="update_services.php" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="title">Başlık</label>
                                                                <input type="text" class="form-control" name="title" value="<?php echo $service['title']; ?>" maxlength="255" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Açıklama</label>
                                                                <textarea class="form-control" name="description" required><?php echo $service['description']; ?></textarea>
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