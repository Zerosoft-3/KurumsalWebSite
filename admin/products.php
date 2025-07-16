<?php
include 'check.php';

// Ürünleri getir
$products = $query->select('products', '*');
$categories = $query->eQuery('SELECT * FROM category');

// Ürün silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Resimleri sil
    $imagesUrl = $query->select('product_images', '*', "WHERE product_id = $delete_id");
    foreach ($imagesUrl as $image) {
        $imageUrl = "../assets/img/product/" . $image['image_url'];
        if (file_exists($imageUrl)) {
            unlink($imageUrl);
        }
    }

    // Ürünü sil
    $query->eQuery('DELETE FROM products WHERE id = ?', [$delete_id]);
    exit('success');
}

// Ürün ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    // Resim yükleme işlemi
    $uploadedImages = [];
    $totalFiles = count($_FILES['image']['name']);
    if ($totalFiles <= 10) {
        for ($i = 0; $i < $totalFiles; $i++) {
            if ($_FILES['image']['error'][$i] == 0) {
                $image_name = basename($_FILES['image']['name'][$i]);
                $encrypted_name = md5(time() . $image_name) . "." . pathinfo($image_name, PATHINFO_EXTENSION);
                $target_dir = "../assets/img/product/";
                $target_file = $target_dir . $encrypted_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_file)) {
                    $uploadedImages[] = $encrypted_name;
                }
            }
        }

        if (!empty($uploadedImages)) {
            $query->eQuery('INSERT INTO products (product_name, description, price, category_id) VALUES (?, ?, ?, ?)', [$product_name, $description, $price, $category_id]);

            $product_id = $query->lastInsertId();

            foreach ($uploadedImages as $uploadedImage) {
                $query->eQuery('INSERT INTO product_images (product_id, image_url) VALUES (?, ?)', [$product_id, $uploadedImage]);
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        echo "Lütfen 10 adetten fazla resim yüklemeyin.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ürünler - Yönetim Paneli</title>
    <link href="../favicon.ico" rel="icon">
    <?php include 'includes/css.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/header.php' ?>
        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- Ürün Ekle Modalı -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#addCategoryModal">
                                Ürün Ekle
                            </button>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Ürün Adı</th>
                                        <th>Resim</th>
                                        <th>Fiyat</th>
                                        <th>Açıklama</th>
                                        <th>Kategori</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody id="productTable">
                                    <?php foreach ($products as $i => $product): ?>
                                        <tr id="product<?php echo $product['id']; ?>">
                                            <?php
                                            $productid = $product['id'];
                                            $product_images = $query->select('product_images', '*', "Where product_id = $productid");
                                            $product_image = "../assets/img/product/" . $product_images[0]['image_url'];
                                            ?>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                            <td><img src="<?= $product_image ?>"
                                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                                    style="width: 100px;"></td>
                                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                                            <?php $category_id = $product['category_id'] ?>
                                            <td><?php echo $query->select('category', '*', "Where id = $category_id")[0]['category_name']; ?>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteProduct(<?php echo $productid; ?>)">
                                                    Sil
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <!-- Ürün Ekle Modalı -->
                            <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
                                aria-labelledby="addCategoryLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="productModalLabel">Ürün Ekle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="productForm" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="action" value="add">
                                                <div class="form-group">
                                                    <label for="product_name">Ürün Adı</label>
                                                    <input type="text" class="form-control" name="product_name"
                                                        id="productName" maxlength="255" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="price">Fiyat</label>
                                                    <input type="number" class="form-control" name="price"
                                                        id="productPrice" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Açıklama</label>
                                                    <textarea class="form-control" name="description"
                                                        id="productDescription" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="category_id">Kategori Seç</label>
                                                    <select class="form-control" name="category_id" id="category_id"
                                                        required>
                                                        <option value="">Kategori Seç</option>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo $category['id']; ?>">
                                                                <?php echo htmlspecialchars($category['category_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Resim Yükle (en fazla 10)</label>
                                                    <input type="file" class="form-control" name="image[]"
                                                        id="productImage" accept="image/*" multiple required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Kapat</button>
                                                <button type="submit" class="btn btn-primary">Ekle</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/js.php'; ?>

    <script>
        function deleteProduct(id) {
            Swal.fire({
                title: "Emin misiniz?",
                text: "Bu ürünü geri alamayacaksınız!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.value == true) {

                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: {
                            action: 'delete',
                            delete_id: id
                        },
                        success: function (response) {
                            if (response === 'success') {
                                $('#product' + id).remove();
                                Swal.fire("Silindi!", "Ürün başarıyla silindi!", "success");
                            } else {
                                Swal.fire("Hata!", "Bir hata oluştu!", "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Hata!", "AJAX isteği sırasında bir hata oluştu!", "error");
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>