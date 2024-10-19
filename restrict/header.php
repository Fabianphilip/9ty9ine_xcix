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

  <!-- Sidebar -->
  <div class="sidebar" style="overflow-y: scroll;">
    <a href="dashboard" class="<?php if($web_file_name == 'dashboard'){ ?>active<?php } ?>"><i class="fas fa-home"></i> Dashboard</a>
    <h5 style="color: silver; padding: 20px 0px 0px 20px;">User Management</h5>
    <a href="manage-users" class="<?php if($web_file_name == 'manage-users'){ ?>active<?php } ?>"><i class="fas fa-users"></i> Users</a>
    <h5 style="color: silver; padding: 20px 0px 0px 20px;">Product Management</h5>
    <a href="manage-product" class="<?php if($web_file_name == 'manage-product'){ ?>active<?php } ?>"><i class="fas fa-box"></i> Products</a>
    <h5 style="color: silver; padding: 20px 0px 0px 20px;">Order Management</h5>
    <a href="manage-product_order" class="<?php if($web_file_name == 'manage-product_order'){ ?>active<?php } ?>"><i class="fas fa-chart-line"></i> Product Orders</a>
    <h5 style="color: silver; padding: 20px 0px 0px 20px;">Category Management</h5>
    <a href="manage-category" class="<?php if($web_file_name == 'manage-category'){ ?>active<?php } ?>"><i class="fas fa-chart-line"></i> Category</a>
    <a href="manage-sub_category" class="<?php if($web_file_name == 'manage-sub_category'){ ?>active<?php } ?>"><i class="fas fa-cogs"></i> Sub Category</a>
    <h5 style="color: silver; padding: 20px 0px 0px 20px;">Feature Management</h5>
    <a href="manage-feature" class="<?php if($web_file_name == 'manage-feature'){ ?>active<?php } ?>"><i class="fas fa-chart-line"></i> Feature</a>
    <h5 style="color: silver; padding: 20px 0px 0px 20px;">Transaction Management</h5>
    <a href="manage-payments" class="<?php if($web_file_name == 'manage-payments'){ ?>active<?php } ?>"><i class="fas fa-chart-line"></i> Payments</a>
    <a href="manage-transaction_log" class="<?php if($web_file_name == 'manage-transaction_log'){ ?>active<?php } ?>"><i class="fas fa-chart-line"></i> Teansaction Log</a>
    <h5 style="color: silver; padding: 20px 0px 0px 20px;">Role Management</h5>
    <a href="role-management" class="<?php if($web_file_name == 'role-management'){ ?>active<?php } ?>"><i class="fas fa-user"></i> Role Management</a>
    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
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