<?php
    session_start();
    require 'koneksi.php';

    // if(!isset($_SESSION["login"])){
    //   header("location: login.php");
    //   exit;
    // }

    if(isset($_POST["login"])){
      $username = $_POST["username"];
      $result = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username = '$username'");
      $result2 = mysqli_query($conn, "SELECT * FROM petugas WHERE username = '$username'");
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link href="style/generate.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <title>Generate Laporan</title>
    </head>
    <body>
        <nav>
            <ul>
                <li class="label">
                    <label><?= '$username'; ?></label>
                </li>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="pengaduan.php">Pengaduan</a>
                </li>
                <li>
                    <a href="verifikasi.php">Verifikasi</a>
                </li>
                <li>
                    <a href="tanggapan.php">Tanggapan</a>
                </li>
                <li>
                    <a href="generate.php" class="active">Generate</a>
                </li>
                <li class="logout">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>


        <!-- modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label>Anda yakin ingin keluar?</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <a href="logout.php" type="button" class="btn btn-success">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    </body>
</html>