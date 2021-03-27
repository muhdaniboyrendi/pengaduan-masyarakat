<?php
    session_start();
    require '../koneksi.php';

    if(!isset($_SESSION["masyarakat"])){
      header("location: ../login.php");
      exit;
    }

    function FetchData($query){
        global $conn; // memanggil fungsi DBConnection dan masukkan ke dalam variable $conn
        $query = mysqli_query($conn, $query); // masukkan variable $conn, dan paramenter $query ke dalam fungsi mysqli_query
        $rows = []; // menyiapkan varible bertipe array kosong
        while ($row = mysqli_fetch_assoc($query)) { // looping hasil query dan di ubah menjadi array assosicative dan masukkan ke dalam folder row
            $rows[] = $row; // masukkan data dari varible $row dan masukkan ke dalam varible $rows (yang berisi array kosong)
        }
        return $rows; // kembalikan data yang sudah masuh ke variable $rows
    }

    function FetchData2($query){
        global $conn; // memanggil fungsi DBConnection dan masukkan ke dalam variable $conn
        $query = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }
        return $rows;
    }

    $pengaduan = FetchData("SELECT * FROM pengaduan
                            INNER JOIN masyarakat
                            ON pengaduan.nik = masyarakat.nik");

    $laporan2 = FetchData2("SELECT * FROM pengaduan
                            INNER JOIN tanggapan
                            ON pengaduan.id_pengaduan = tanggapan.id_pengaduan
                            INNER JOIN petugas
                            ON tanggapan.id_petugas = petugas.id_petugas
                            WHERE tanggapan.id_pengaduan = pengaduan.id_pengaduan");

    // pagination
    $dataPerHalaman = 5;
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

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Daftar Laporan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
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
                    Masyarakat
                </div>
                <li class="nav-item">
                    <a class="nav-link pb-0" href="pengaduan.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Pengaduan</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="laporan.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Daftar Laporan</span>
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
                        <!-- daftar laporan -->
                        <h1 class="h3 mb-4 text-gray-800">Daftar Laporan</h1>
                        <div class="row">
                            <div class="col-lg">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="table-primary">
                                            <th scope="col">No</th>
                                            <th scope="col">NIK</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($pengaduan as $item): ?>
                                        <tr>
                                            <?php
                                                $i = 1;
                                            ?>
                                            <td><?= $i; $i++; ?></td>
                                            <td><?= $item["nik"]; ?></td>
                                            <td><?= $item["nama"]; ?></td>
                                            <td><?= $item["tgl_pengaduan"]; ?></td>
                                            <td><?= $item["status"]; ?></td>
                                            <td>
                                                <a href="?id_pengaduan=<?= $item['id_pengaduan']; ?>" class="badge btn-primary" data-toggle="modal" data-target="#lihatModal">Lihat Laporan</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

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
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->


                <!-- Modal -->

                <!-- Lihat Modal-->
                <div class="modal fade" id="lihatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detail Laporan</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <?php foreach($laporan2 as $item2): ?>
                            <div class="modal-body">
                                <h5>Isi Laporan</h5>
                                <p><?= $item2["isi_laporan"]; ?></p>
                                <hr>
                                <h5>Foto</h5>
                                <p><?= $item2["foto"]; ?></p>
                                <hr>
                                <h5>Tanggapan</h5>
                                <p><?= $item2["tanggapan"]; ?></p>
                                <h5>Petugas</h5>
                                <p><?= $item2["nama_petugas"]; ?></p>
                            </div>
                            <?php endforeach; ?>
                            <div class="modal-footer">
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

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
                        <a class="btn btn-primary" href="login.html">Logout</a>
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
