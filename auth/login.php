<?php 
session_start();

require_once('../config.php');

if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($connection, "SELECT * FROM users JOIN Pegawai ON users.id_pegawai = pegawai.id WHERE username = '$username'");

  if(mysqli_num_rows($result) === 1){
  $row = mysqli_fetch_assoc($result);

  if(password_verify($password,$row["password"])) {
      if($row['status'] == 'Aktif'){

        $_SESSION["login"] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['nip'] = $row['nip'];
        $_SESSION['jabatan'] = $row['jabatan'];
        $_SESSION['lokasi_presensi'] = $row['lokasi_presensi'];

        if($row['role'] === 'admin'){
          header ("location: ../admin/home/home.php");
          exit();
        } else {
          header("location: ../pegawai/home/home.php");
          exit();
        }

      }
      else{
        $_SESSION['gagal'] = 'Akun anda belum aktif';
      }
  } else {
    $_SESSION['gagal'] = 'Username salah, silahkan coba lagi';
  }
    } else {
      $_SESSION['gagal'] = 'Username salah, silahkan coba lagi';
  }
  }
?>


<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in Absensi</title>
    <!-- CSS files -->
    <link href=<?= base_url ('assets/css/tabler.min.css?1684106062')?> rel="stylesheet"/>
    <link href=<?= base_url ('assets/css/tabler-vendors.min.css?1684106062')?> rel="stylesheet"/>
    <link href=<?= base_url ('assets/css/demo.min.css?1684106062')?> rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                <a href="" class="navbar-brand navbar-brand-autodark"><img src= <?= base_url ('assets/img/kf.svg') ?> height="160" alt=""></a>
              </div>
              <div class="card card-md">
                <div class="card-body">
                  <h2 class="h2 text-center mb-4">Login to your account</h2>
                  <form action="" method="POST" autocomplete="off" novalidate>
                    <div class="mb-3">
                      <label class="form-label">User Name</label>
                      <input type="text" class="form-control" autofocus name="username" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">
                        Password
                        <span class="form-label-description">
                        </span>
                      </label>
                      <div class="input-group input-group-flat">
                        <input type="password" class="form-control"  name ="password" placeholder="Password"  autocomplete="off">
                        <span class="input-group-text">
                          <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                          </a>
                        </span>
                      </div>
                    </div>
                    <div class="form-footer">
                      <button type="submit" name="login" class="btn btn-primary w-100">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
            <img src=<?= base_url ('assets/img/undraw_secure_login_pdn4.svg') ?> height="300" class="d-block mx-auto" alt="">
          </div>
        </div>
      </div>
    </div>
   
    <!-- Libs JS -->
    <script src=<?= base_url ('assets/libs/apexcharts/dist/apexcharts.min.js?1684106062') ?> defer></script>
    <script src=<?= base_url ('assets/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062')?> defer></script>
    <script src=<?= base_url ('assets/libs/jsvectormap/dist/maps/world.js?1684106062') ?> defer></script>
    <script src=<?= base_url ('assets/libs/jsvectormap/dist/maps/world-merc.js?1684106062') ?> defer></script>
   
    <!-- Tabler Core -->
    <script src=<?= base_url ('assets/js/tabler.min.js?1684106062') ?> defer></script>
    <script src=<?= base_url ('assets/js/demo.min.js?1684106062') ?> defer></script>
   
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

<?php if ($_SESSION['gagal']) {?>

  <Script>
    Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "<?= $_SESSION['Gagal!'] ?>",
  });
  </Script>

  <?php unset($_SESSION['Gagak!']); ?> 

<?php } ?>


    
  </body>
</html>