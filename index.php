<?php
    session_start();
    require 'koneksi.php';

    if(!isset($_SESSION["login"])){
      header("location: login.php");
      exit;
    }

?>