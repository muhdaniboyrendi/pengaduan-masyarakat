<?php 

    session_start();
    require '../function.php';

    if(!isset($_SESSION["masyarakat"])){
        header("location: ../");
        exit;
    }


    $id_pengaduan = $_GET['id_pengaduan'];

    function hapus($id_pengaduan){
        global $conn;
        mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan = $id_pengaduan");
        return mysqli_affected_rows($conn);
    }

    if(hapus($id_pengaduan) > 0){
        echo "<script>
                    alert('Laporan berhasil dihapus');
                </script>";
    }else{
        echo "<script>
                    alert('Laporan gagal dihapus');
                </script>";
    }
    header("location: laporan-saya.php");

?>