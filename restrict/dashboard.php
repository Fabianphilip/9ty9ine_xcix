<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>
  <?php
    $usersCount = mysqli_query($conn, "SELECT * FROM users");
    $productCount = mysqli_query($conn, "SELECT * FROM product");
    $productOrdersCount = mysqli_query($conn, "SELECT * FROM product_order WHERE pay_status = '1' AND status = 'pending'");
    $productOrdersCount = mysqli_query($conn, "SELECT * FROM product_order WHERE pay_status = '1'");
    if(mysqli_num_rows($productOrdersCount) > 0){
      $productOrdersCountT = mysqli_query($conn, "SELECT SUM(amount) AS totalAmount FROM product_order WHERE pay_status = '1'");
      $rowproductOrderCount = mysqli_fetch_array($productOrdersCountT);
      $earned = $rowproductOrderCount['totalAmount'];
    }else{
      $earned = 0;
    }

  ?>
    <!-- Main Dashboard Content -->
    <div class="container mt-4">
      <h1>Welcome to the Dashboard</h1>
      <p>This is where you can manage your website, view statistics, and much more.</p>

      <div class="row">
        <!-- Example Cards -->
        <div class="col-lg-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
            <div class="card-body">
              <h5>Users</h5>
              <p><?php echo mysqli_num_rows($usersCount); ?> Active Users</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card bg-success text-white mb-4">
            <div class="card-body">
              <h5>Products</h5>
              <p><?php echo mysqli_num_rows($productCount); ?> Products Available</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card bg-warning text-white mb-4">
            <div class="card-body">
              <h5>Orders</h5>
              <p><?php echo mysqli_num_rows($productOrdersCount); ?> Orders Pending</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body">
              <h5>Revenue</h5>
              <p>₦<?php echo number_format($earned, 2); ?> Earned</p>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php } ?>
 <?php include 'footer.php'; ?>
