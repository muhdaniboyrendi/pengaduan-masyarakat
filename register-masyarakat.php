<?php

    session_start();
    require 'function.php';

    if(isset($_SESSION["masyarakat"])){
        header("location: masyarakat/");
        exit;
    }
    if(isset($_SESSION["admin"])){
        header("location: admin/");
        exit;
    }
    if(isset($_SESSION["petugas"])){
        header("location: petugas/");
        exit;
    }

    if(isset($_POST["register"])){
        if(registermasyarakat($_POST) > 0){
            echo "<script>
                    alert('Akunmu Telah Berhasil Terdaftar');
                    document.location.href = login.php;
                  </script>";
        }else{
            echo "<script>
                    alert('Akunmu Gagal Terdaftar');
                  </script>";
        }
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <title>Registrasi Masyarakat</title>
    </head>
    <body class="bg-secondary">
        <div class="container">
            <div class="mt-1">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card o-hidden border-0 shadow-lg my-5  bg-dark text-light">
                            <div class="p-5 pt-3 pb-5">
                                <h2 class="text-center mt-2">Register</h2>
                                <form action="" method="POST" class="mt-5">
                                    <div class="mb-3">
                                        <input type="text" class="form-control bg-dark text-light" id="nik" name="nik" placeholder="NIK">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control bg-dark text-light" id="nama" name="nama" placeholder="Nama Lengkap">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control bg-dark text-light" id="username" name="username" placeholder="Username">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <input type="password" class="form-control bg-dark text-light" name="password" placeholder="Password">
                                        </div>
                                        <div class="col">
                                            <input type="password" class="form-control bg-dark text-light" name="password2" placeholder="Konfirmasi Password">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control bg-dark text-light" id="telp" name="telp" placeholder="Telepone">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="register" class="btn btn-outline-primary mt-3 mb-3">DAFTAR</button>
                                        <br>
                                        <a href="index.php">Sudah punya akun? Login!</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    </body>
</html>