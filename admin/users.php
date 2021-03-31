<?php

    session_start();
    require '../koneksi.php';

    if(!isset($_SESSION["admin"])){
        header("location: ../login.php");
        exit;
    }

    $result = mysqli_query($conn, "SELECT * FROM masyarakat");

     // pagination
     $dataPerHalaman = 7;
     $result = mysqli_query($conn, "SELECT * FROM masyarakat");
     $jumlahData = mysqli_num_rows($result);
     $jumlahHalaman = ceil($jumlahData / $dataPerHalaman);
     if(isset($_GET["halaman"])){
         $halamanAktif = $_GET["halaman"];
     }else {
         $halamanAktif = 1;
     }
     $dataAwal = ($dataPerHalaman * $halamanAktif) - $dataPerHalaman;
     $laporan = mysqli_query($conn, "SELECT * FROM masyarakat LIMIT $dataAwal, $dataPerHalaman");
 
     if(isset($_POST['lihat'])){ // check jika tombol verify sudah di submit
         global $conn;
         $idpengaduan = $_POST['lihat']; // tanggap id pengaduan yang dikirim 
         $_SESSION['lihat'] = $idpengaduan; // masukkan id pengaduan ke dalam session
         $cek = mysqli_query($conn, "SELECT * FROM pengaduan
                                     INNER JOIN tanggapan 
                                     ON pengaduan.id_pengaduan = tanggapan.id_pengaduan
                                     INNER JOIN petugas
                                     ON tanggapan.id_petugas = petugas.id_petugas
                                     WHERE id_pengaduan = '$idpengaduan'") 
                                     or die(mysqli_error($conn)); // query ke database
     }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Users</title>
        <!-- Custom fonts for this template-->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                    <div class="sidebar-brand-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">Pengaduan Masyarakat</div>
                </a>
                <!-- Divider -->
                <hr class="sidebar-divider my-0">
                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- masyarakat -->
                <div class="sidebar-heading">
                    admin
                </div>
                <li class="nav-item">
                    <a class="nav-link pb-0" href="pengaduan.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Pengaduan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pb-0" href="verifikasi.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Verifikasi dan Validasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pb-0" href="register-petugas.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Registrasi</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link pb-0" href="users.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="generate.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Generate Laporan</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
                
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </ul>
            <!-- End of Sidebar -->


            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION["data"]["username"]; ?></span>
                                    <i class="fas fa-user"></i>
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Settings
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Activity Log
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <!-- End of Topbar -->


                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- tulis laporan -->
                        <h1 class="h3 mb-4 text-gray-800">Daftar Masyarakat</h1>
                        <div class="row">
                            <div class="col-lg">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="table-primary">
                                            <th scope="col">No</th>
                                            <th scope="col">NIK</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Telepone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach($result as $item): ?>
                                        <tr>
                                            <td scope="row"><?= $i; $i++; ?></td>
                                            <td><?= $item["nik"]; ?></td>
                                            <td><?= $item["nama"]; ?></td>
                                            <td><?= $item["username"]; ?></td>
                                            <td><?= $item["telp"]; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php if($halamanAktif > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">&laquo;</a>
                                    </li>
                                <?php endif; ?>
                                <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                    <?php if($i == $halamanAktif): ?>
                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php else: ?>
                                                <li class="page-item" aria-current="page">
                                                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                                </li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <?php if($halamanAktif < $jumlahHalaman): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">&raquo;</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <!-- end pagination -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->


                <!-- Modal -->
                <div class="modal fade" id="newHapusUserModal" tabindex="-1" aria-labelledby="newHapusUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newHapusUserModalLabel">Apa anda yakin ingin menghapus User ini?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-footer float-left">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 


                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Muhdani Boyrendi Erlan Azhari <?= date('Y'); ?></span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini</div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>
    </body>
</html>
