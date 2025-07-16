<?php include 'check.php';

$old_image_path = "../" . $query->select("about", "*")[0]['image'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_about'])) {

        $id = $_POST['id'];
        $title = $_POST['title'];
        $p1 = $_POST['p1'];
        $p2 = $_POST['p2'];
        $image = $_FILES['image']['name'];

        $sql = "SELECT image FROM about WHERE id=?";
        $result = $query->eQuery($sql, [$id]);

        if ($image) {
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }

            $new_image_name = uniqid() . '-' . basename($image);
            $target_path = "../assets/img/$new_image_name";

            move_uploaded_file($_FILES['image']['tmp_name'], $target_path);

            $sql = "UPDATE about SET title=?, p1=?, p2=?, image=? WHERE id=?";
            $query->eQuery($sql, [$title, $p1, $p2, 'assets/img/' . $new_image_name, $id]);
        } else {
            $sql = "UPDATE about SET title=?, p1=?, p2=? WHERE id=?";
            $query->eQuery($sql, [$title, $p1, $p2, $id]);
        }

        header('Location: about.php?updated=true');
        exit();
    } elseif (isset($_POST['update_ul_items'])) {
        $ul_item_id = $_POST['ul_item_id'];
        $list_item = $_POST['list_item'];

        $sql = "UPDATE about_ul_items SET list_item=? WHERE id=?";
        $query->eQuery($sql, [$list_item, $ul_item_id]);

        header('Location: about.php?updated=true');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Hakkımızda - Yönetim Paneli</title>
    <link href="../favicon.ico" rel="icon">
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

                            <!-- 'about' tablosundan veriler -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Başlık</th>
                                        <th>Yorum</th>
                                        <th>Paragraf</th>
                                        <th>Resim</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // 'about' tablosundan veri çekiliyor
                                    $aboutItems = $query->select('about', '*');

                                    // Her 'about' öğesi için bir satır oluşturuluyor
                                    foreach ($aboutItems as $item) {
                                        echo "<tr>";
                                        echo "<td>{$item['id']}</td>";
                                        echo "<td>{$item['title']}</td>";
                                        echo "<td>{$item['p1']}</td>";
                                        echo "<td>{$item['p2']}</td>";
                                        echo "<td><img src='../{$item['image']}' alt='Resim' style='width: 100px; height: auto;'></td>";
                                        echo "<td>
                                            <button class='btn btn-warning' data-toggle='modal' data-target='#editAboutModal' data-id='{$item['id']}'>Düzenle</button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Düzenleme Modalı -->
                            <div class="modal fade" id="editAboutModal" tabindex="-1" role="dialog"
                                aria-labelledby="editAboutModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAboutModalLabel">Hakkımızda Düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editAboutForm" method="POST" action=""
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="id" id="editAboutId">
                                                <div class="form-group">
                                                    <label for="title">Başlık:</label>
                                                    <input type="text" name="title" id="editAboutTitle"
                                                        class="form-control" required maxlength="255">
                                                </div>
                                                <div class="form-group">
                                                    <label for="p1">Paragraf 1:</label>
                                                    <textarea name="p1" id="editAboutP1" class="form-control"
                                                        required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="p2">Paragraf 2:</label>
                                                    <textarea name="p2" id="editAboutP2" class="form-control"
                                                        required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Resim:</label>
                                                    <input type="file" name="image" class="form-control"
                                                        accept="image/*">
                                                </div>
                                                <button type="submit" name="update_about"
                                                    class="btn btn-primary">Güncelle</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-0">Hakkımızda Liste Öğeleri</h2>

                            <!-- 'about_ul_items' tablosundan veriler -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Liste Öğesi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // 'about_ul_items' tablosundan veri çekiliyor
                                    $ulItems = $query->select('about_ul_items', '*');

                                    // Her UL öğesi için bir satır oluşturuluyor
                                    foreach ($ulItems as $ulItem) {
                                        echo "<tr>";
                                        echo "<td>{$ulItem['id']}</td>";
                                        echo "<td>{$ulItem['list_item']}</td>";
                                        echo "<td>
                                            <button class='btn btn-warning' data-toggle='modal' data-target='#editUlItemModal' data-id='{$ulItem['id']}'>Düzenle</button>
                                        </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- UL Öğesi Düzenleme Modalı -->
                            <div class="modal fade" id="editUlItemModal" tabindex="-1" role="dialog"
                                aria-labelledby="editUlItemModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUlItemModalLabel">Liste Öğesi Düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editUlItemForm" method="POST" action="">
                                                <input type="hidden" name="ul_item_id" id="editUlItemId">
                                                <div class="form-group">
                                                    <label for="list_item">Liste Öğesi:</label>
                                                    <textarea name="list_item" id="editUlItemList" class="form-control"
                                                        required></textarea>
                                                </div>
                                                <button type="submit" name="update_ul_items"
                                                    class="btn btn-primary">Güncelle</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 'Hakkımızda' düzenleme modalı için
        $('#editAboutModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Modalı tetikleyen buton
            var id = button.data('id');

            // Diğer gerekli verileri al
            var title = button.closest('tr').find('td:eq(1)').text();
            var p1 = button.closest('tr').find('td:eq(2)').text();
            var p2 = button.closest('tr').find('td:eq(3)').text();

            var modal = $(this);
            modal.find('#editAboutId').val(id);
            modal.find('#editAboutTitle').val(title);
            modal.find('#editAboutP1').val(p1);
            modal.find('#editAboutP2').val(p2);
        });

        // 'Liste Öğesi' düzenleme modalı için
        $('#editUlItemModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Modalı tetikleyen buton
            var id = button.data('id');
            var list_item = button.closest('tr').find('td:eq(1)').text();

            var modal = $(this);
            modal.find('#editUlItemId').val(id);
            modal.find('#editUlItemList').val(list_item);
        });
    </script>

</body>

</html>