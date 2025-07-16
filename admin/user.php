<?php include 'check.php' ?>

<?php
$user = $query->select('users', '*')[0];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $query->hashPassword($_POST['password']);

  $data = [
    'name' => $name,
    'username' => $username,
    'password' => $password
  ];

  $query->update('users', $data, "WHERE id = {$user['id']}");

  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
          icon: 'success',
          title: 'Başarıyla güncellendi!',
          text: 'Kullanıcı bilgileri güncellendi!',
          confirmButtonText: 'Tamam'
      }).then((result) => {
          window.location.href = './';
      });
  });
</script>";
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kullanıcı Güncelleme</title>
  <!-- CSS includes -->
  <?php include 'includes/css.php'; ?>
  <link href="../favicon.ico" rel="icon">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include 'includes/header.php' ?>
    <div class="content-wrapper">

      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-6 mx-auto">
              <!-- Kullanıcı güncelleme formu -->
              <div class="card" style="margin-top: 50px">
                <div class="card-header">
                  <h3 class="card-title">Kullanıcı Güncelle</h3>
                </div>

                <!-- Form buradan başlar -->
                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Tam Ad</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Adınızı girin"
                        value="<?php echo $user['name'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="username">Kullanıcı Adı</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı adını girin"
                        value="<?php echo $user['username'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="password">Şifre</label>
                      <input type="password" class="form-control" id="password" name="password"
                        placeholder="Şifreyi girin" required>
                    </div>
                  </div>

                  <!-- Gönder butonu -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                  </div>
                </form>
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
  <?php include 'includes/js.php' ?>
</body>

</html>