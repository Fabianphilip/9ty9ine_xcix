<?php
  include '../includes/connect.php';
  include '../includes/functions.php';
  require_once '../session.php';
  if(!empty($email)){
    error_reporting(E_ALL); ini_set('display_errors', 1);
    $web_file_name = basename($_SERVER["PHP_SELF"],".php");
    if ($web_file_name == "index") {
      $tittle = "$gen_name | Chrome";
    }else{
      $tittle = $web_file_name;
    }
    $actual_link = $_SERVER['REQUEST_URI'];
    $_SESSION['link'] = $actual_link;
    $sql_sel = mysqli_query ($conn, "SELECT * FROM users where email = '$email'");
    $row_user = mysqli_fetch_array ($sql_sel);
    $status = $row_user['status'];
    $is_admin = $row_user['isAdmin'];

    $sql_sel_general = mysqli_query ($conn, "SELECT * FROM general where id = '1'");
    $row_general = mysqli_fetch_array ($sql_sel_general);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <!-- Bootstrap CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- Font Awesome CSS for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/admin.css">
</head>
<body>
  <style type="text/css">
    html{
            font-size: 70% !important;
        }
  </style>

  <button class="sidebar-toggler" onclick="toggleSidebar()"><i class="fas fa-bars"></i> Menu</button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="dashboard" class="<?php if($web_file_name == 'dashboard'){ ?>active<?php } ?>"><i class="fas fa-home"></i> Dashboard</a>
    <?php if($is_admin == '1'){ ?>
      <a href="../restrict/dashboard" class=""><i class="fas fa-home"></i> Admin</a>
    <?php } ?>
    <a href="reviews" class="<?php if($web_file_name == 'reviews'){ ?>active<?php } ?>"><i class="fas fa-search"></i> Reviews</a>
    <a href="settings" class="<?php if($web_file_name == 'settings'){ ?>active<?php } ?>"><i class="fas fa-cogs"></i> Settings</a>
    <a href="orders" class="<?php if($web_file_name == 'orders'){ ?>active<?php } ?>"><i class="fas fa-box"></i> Orders</a>
    <a href="profile" class="<?php if($web_file_name == 'profile'){ ?>active<?php } ?>"><i class="fas fa-user"></i> Profile</a>
    <a href="wishlist" class="<?php if($web_file_name == 'wishlist'){ ?>active<?php } ?>"><i class="fas fa-heart"></i> Wishlist</a>
  </div>

  <!-- Content -->
  <div class="content">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-left: 0px !important;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-bell"></i> Notifications</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-user-circle"></i> Profile</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php } ?>