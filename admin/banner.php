<?php include 'check.php'; ?>

<?php
$banners = $query->select('banners', '*');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {

    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        $originalImage = $_FILES['image']['name'];
        $extension = pathinfo($originalImage, PATHINFO_EXTENSION);
        $timestamp = date('YmdHis');
        $newImageName = uniqid('banner_', true) . '_' . $timestamp . '.' . $extension;

        $target = "../assets/img/banners/" . basename($newImageName);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $button_text = $_POST['button_text'];
            $button_link = $_POST['button_link'];

            $data = [
                'image' => $newImageName,
                'title' => $title,
                'description' => $description,
                'button_text' => $button_text,
                'button_link' => $button_link
            ];

            $query->insert('banners', $data);
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        } else {
            echo "Resim yüklenirken bir hata oluştu.";
        }
    } else {
        echo "Resim seçilmedi.";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $banner = $query->select('banners', '*', "WHERE id = {$id}");

    if (isset($banner[0])) {
        $banner = $banner[0];
        $imagePath = "../assets/img/banners/" . $banner['image'];

        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                $query->delete('banners', "WHERE id = {$id}");
                header("Location: {$_SERVER['PHP_SELF']}");
                exit;
            } else {
                echo "Resim silinirken bir hata oluştu.";
            }
        } else {
            echo "Banner silmek için bulunamadı.";
        }
    } else {
        echo "Banner silmek için bulunamadı.";
    }
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Banner Management</title>
    <!-- CSS files -->
    <?php include 'includes/css.php'; ?>
    <link href="../favicon.ico" rel="icon">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <!-- Banner ekleme butonu -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                        data-target="#addBannerModal">
                        Banner Ekle
                    </button>

                    <!-- Banner Ekle modalı -->
                    <div class="modal fade" id="addBannerModal" tabindex="-1" role="dialog"
                        aria-labelledby="addBannerModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBannerModalLabel">Banner Ekle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="image">Resim Seç</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Başlık</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Başlık" maxlength="255" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Açıklama</label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Açıklama" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="button_text">Buton Metni</label>
                                            <input type="text" class="form-control" id="button_text" name="button_text"
                                                placeholder="Buton metni" maxlength="100" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="button_link">Buton Linki</label>
                                            <input type="text" class="form-control" id="button_link" name="button_link"
                                                placeholder="Buton linki" maxlength="255" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Kapat</button>
                                        <button type="submit" name="add" class="btn btn-primary">Ekle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Banner listesi -->
                    <div class="card-header">
                    </div>
                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Resim</th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Buton Metni</th>
                                <th>Buton Linki</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($banners as $index => $banner): ?>
                                <tr>
                                    <td><?php echo $index + 1 ?></td>
                                    <td><img src="../assets/img/banners/<?php echo $banner['image']; ?>"
                                            alt="<?php echo $banner['title']; ?>" width="100"></td>
                                    <td><?php echo $banner['title']; ?></td>
                                    <td><?php echo $banner['description']; ?></td>
                                    <td><?php echo $banner['button_text']; ?></td>
                                    <td><?php echo $banner['button_link']; ?></td>
                                    <td>
                                        <button onclick="deleteBanner(<?php echo $banner['id']; ?>)" type="button"
                                            class="btn btn-danger" onclick="deleteProduct(2)">Sil</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Altbilgi -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- JS dosyaları -->
    <?php include 'includes/js.php'; ?>

    <script>
        function deleteBanner(id) {
            Swal.fire({
                title: "Emin misiniz?",
                text: "Bu bannerı geri alamayacaksınız!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        type: 'GET',
                        url: '',
                        data: {
                            action: 'delete',
                            delete: id
                        },
                        success: function (response) {
                            Swal.fire("Silindi!", "Banner başarıyla silindi!", "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire("Hata!", "Banner silinirken bir hata oluştu.", "error");
                        }
                    });
                }
            });
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>