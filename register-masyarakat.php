<?php

    require 'koneksi.php';

    function registermasyarakat($data){
        global $conn;

        $nik = $data["nik"];
        $nama = $data["nama"];
        $username = $data["username"];
        $password = $data["password"];
        $telp = $data["telp"];
        $confirmpassword = mysqli_real_escape_string($conn, $data["password2"]);

        // cek username
        $result = mysqli_query($conn, "SELECT username FROM masyarakat WHERE username = '$username  '");
        if(mysqli_fetch_assoc($result)){
            echo "<script>
                    alert('Username Has Been Registered')
                  </script";
            return false;
        }

        // cek password
        if($password !== $confirmpassword){
            echo "<script>
                    alert('Your Password Cannot be Confirmed')
                  </script";
            return false;
        }

        // enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // tambah ke database
        mysqli_query($conn, "INSERT INTO masyarakat VALUES('$nik', '$nama', '$username', '$password', '$telp')");
        return mysqli_affected_rows($conn);
    }

    if(isset($_POST["register"])){
        if(registermasyarakat($_POST) > 0){
            echo "<script>
                    alert('Your Account Has Been Successfully Registered');
                  </script>";
        }else{
            echo mysqli_error($conn);
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
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="p-5 pt-3 pb-5">
                                <h2 class="text-center">Register</h2>
                                <form action="" method="POST" class="mt-4">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Konfirmasi Password">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="telp" name="telp" placeholder="Telepone">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="register" class="btn btn-primary">DAFTAR</button>
                                        <br><br>
                                        <a href="login.php">Sudah punya akun? Login!</a>
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