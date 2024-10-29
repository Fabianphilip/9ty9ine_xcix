<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>
    <!-- Main Dashboard Content -->
    <div class="container mt-4">
      <h1>Welcome to the Dashboard</h1>
      <p>This is where you can manage your website, view statistics, and much more.</p>


      <div class="row">
        <div class="col-md-6 my-2">
          <div class="card p-4">
            <div class="row">
              <div class="col-md-12 mb-4"><h5>Account Information</h5></div>
              <div class="col-md-2">
                <center><i class="fa fa-user" style="font-size: 60px;"></i></center>
              </div>
              <div class="col-md-10">
                <strong><?php echo $row_user['full_name'] ?></strong>
                <div><?php echo $row_user['email'] ?></div>
                <div>
                  <a href="profile" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                  <a href="settings" class="btn btn-primary"><i class="fa fa-cogs"></i> Settings</a>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-6 my-2">
          <div class="card p-4">
            <div class="row">
              <div class="col-md-12 mb-4"><h5>Orders</h5></div>
              <?php
                $queryNewOrders = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '1' AND status = 'pending' GROUP BY ref");
                $queryCompletedOrders = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '1' AND status = 'delivered' GROUP BY ref");
                $queryConfirmedOrders = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '1' AND status = 'pending' GROUP BY ref");
                $queryReturnedOrders = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '0' AND status = 'returned' GROUP BY ref");
              ?>
              <div class="col-md-6">
                <div>New: <strong><?php echo mysqli_num_rows($queryNewOrders); ?></strong></div>
                <div>Completed: <strong><?php echo mysqli_num_rows($queryCompletedOrders); ?></strong></div>
              </div>
              <div class="col-md-6" style="text-align: right;">
                <div>Confirmed: <strong><?php echo mysqli_num_rows($queryConfirmedOrders); ?></strong></div>
                <div>Returned Item: <strong><?php echo mysqli_num_rows($queryReturnedOrders); ?></strong></div>
              </div>
              <div class="col-md-12 mt-4" style="text-align: right;">
                <a href="orders" class="btn btn-primary"><i class="fa fa-box"></i> All</a>
                <a href="orders?track=1" class="btn btn-primary"><i class="fa fa-truck"></i> Settings</a>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-6 my-2">
          <div class="card p-4">
            <div class="row d-flex justify-content-between">
              <div class="col-auto"><h5>Default Shipping Address</h5></div>
              <div class="col-auto"><button class="btn btn-primary"><i class="fa fa-address-book"></i> Add New Address</button></div>
              <div class="col-md-12 p-4"><center>No address found</center></div>
            </div>
          </div>
        </div>

        <div class="col-md-6 my-2">
          <div class="card p-4">
            <div class="row d-flex justify-content-between">
              <div class="col-auto"><h5>Recently Saved item</h5></div>
              <div class="col-auto"><button class="btn btn-primary"><i class="fa fa-floppy-o"></i> See all saved items</button></div>
              <div class="col-md-12 p-4"><center>No recetly saved items found</center></div>
            </div>
          </div>
        </div>


      </div>
    </div>

<?php } ?>
 <?php include 'footer.php'; ?>
