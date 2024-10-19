<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>
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
              <p>1,234 Active Users</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card bg-success text-white mb-4">
            <div class="card-body">
              <h5>Products</h5>
              <p>567 Products Available</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card bg-warning text-white mb-4">
            <div class="card-body">
              <h5>Orders</h5>
              <p>789 Orders Pending</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body">
              <h5>Revenue</h5>
              <p>$12,345 Earned</p>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php } ?>
 <?php include 'footer.php'; ?>
