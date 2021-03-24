<?php

    session_start();
    require 'koneksi.php';

    if(isset($_SESSION["login"])){
        header("location: index.php");
        exit;
    }

    if(isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $result = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username = '$username'");
        $result2 = mysqli_query($conn, "SELECT * FROM petugas WHERE username = '$username'");
        // cek username masyarakat
        if(mysqli_num_rows($result) === 1){
            // cek password
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["password"])){
                // set session
                $_SESSION["login"] = true;
                header("location: index.php");
                exit;
            }
        }$error = true;
        // cek username petugas
        if(mysqli_num_rows($result2) === 1){
            // cek password
            $row = mysqli_fetch_assoc($result2);
            if(password_verify($password, $row["password"])){
                // set session
                $_SESSION["login"] = true;
                header("location: index.php");
                exit;
            }
        }$error = true;
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style/login.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <title>Login</title>
    </head>
    <body class="bg-secondary">
        <div class="container">
            <div class="mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="p-5 pt-4">
                                <h2 class="mb-4 text-center">Login</h2>
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="login" value="login" class="btn btn-primary">Login</button>
                                    </div>
                                </form>
                                <br>

                                <!-- Button trigger modal -->
                                <div class="text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Belun punya akun? Daftar!</a>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Daftar sebagai</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Admin / Petugas</h5>
                                                <p><a href="register-petugas.php" role="button" class="btn btn-success popover-test" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Daftar</a> Khusus untuk admin atau petugas</p>
                                                <hr>
                                                <h5>Masyarakat</h5>
                                                <p><a href="register-masyarakat.php" role="button" class="btn btn-success popover-test" title="Popover title" data-bs-content="Popover body content is set in this attribute.">Daftar</a> Khusus untuk masyarakat</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Script -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    </body>
</html>