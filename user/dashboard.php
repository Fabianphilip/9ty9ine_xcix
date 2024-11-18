<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>
    <!-- Main Dashboard Content -->
    <div class="container mt-4">
      <h1>Welcome to the Dashboard</h1>
      <p>This is where you can manage your website, view statistics, and much more.</p>

      <style>
        .modal-overlay {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background: rgba(0, 0, 0, 0.5);
              display: flex;
              justify-content: center;
              align-items: center;
            }
            
            .modal-content {
              background: white;
              padding: 20px;
              border-radius: 8px;
              width: 500px;
            }

      </style>
      <div class="row">
        <div class="col-md-6 my-2">
          <div class="card shadow p-3 mb-5 bg-white rounded p-4">
            <div class="row">
              <div class="col-md-12 mb-4"><h5>Account Information</h5></div>
              <div class="col-md-2">
                <center><i class="fa fa-user" style="font-size: 60px;"></i></center>
              </div>
              <div class="col-md-10">
                <strong><?php echo $row_user['full_name'] ?></strong>
                <div><?php echo $row_user['email'] ?></div>
                <div class="col-md-12 mt-4">
                  <a href="profile" class="btn btn-secondary"><i class="fa fa-edit"></i> Edit</a>
                  <a href="settings" class="btn btn-primary"><i class="fa fa-cogs"></i> Settings</a>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-6 my-2">
          <div class="card shadow p-3 mb-5 bg-white rounded p-4">
            <div class="row">
              <div class="col-md-12 mb-4"><h5>Orders</h5></div>
              <?php
                $queryNewOrders = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '1' AND status = 'pending' GROUP BY ref");
                $queryCompletedOrders = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '1' AND status = 'delivered' GROUP BY ref");
                $queryConfirmedOrders = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '1' AND status = 'confirmed' GROUP BY ref");
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
                <a href="orders" class="btn btn-secondary"><i class="fa fa-box"></i> All</a>
                <a href="orders?track=1" class="btn btn-primary"><i class="fa fa-truck"></i> Settings</a>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-6 my-2">
          <div class="card shadow p-3 mb-5 bg-white rounded p-4">
            <div class="row d-flex justify-content-between">
              <div class="col-auto"><h5>Default Shipping Address</h5></div>
              <div class="col-auto"><button class="btn btn-primary" id="addNewAddressBtn"><i class="fa fa-address-book"></i> Add/Manage New Address</button></div>
              <div class="col-md-12 p-4">
                  <?php
                    $result = mysqli_query($conn, "SELECT id, address, setDefault FROM user_addresses WHERE email = '$email'");
                    if(mysqli_num_rows($result) > 0){
                        ?><?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="row mb-3" style="<?php if($row['setDefault'] == '1'){ ?> border: 1px solid green; padding-top: 10px; padding-bottom: 10px; <?php } ?>">
                            <div class="col-md-12">
                                <?php echo $row['address'] ?>
                              </div>
                              </div>
                            <?php
                        }
                    }else{
                        ?><center>No address found</center><?php      
                    }
                  ?>
                  
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 my-2">
          <div class="card shadow p-3 mb-5 bg-white rounded p-4">
            <div class="row d-flex justify-content-between">
              <div class="col-auto"><h5>Recently Saved item</h5></div>
              <div class="col-auto"><button class="btn btn-primary"><i class="fa fa-floppy-o"></i> See all saved items</button></div>
              <div class="col-md-12 p-4"> 
                  <?php
                    $result = mysqli_query($conn, "SELECT p.name AS name, pi.image AS image, p.id AS id FROM wishlist w LEFT JOIN product p ON w.product_id = p.id LEFT JOIN product_images pi ON p.image_token = pi.token  WHERE w.email = '$email' GROUP BY p.id");
                    if(mysqli_num_rows($result) > 0){
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <div class="row mb-3" style="">
                                <div class="col-md-2">
                                    <img src="../product_images/<?php echo $row['image'] ?>" style="width: 100px;">
                                </div>
                                <div class="col-md-12">
                                    <?php echo $row['name'] ?>
                                </div>
                            </div>
                            <?php
                        }
                    }else{
                        ?><center>No recetly saved items found</center><?php      
                    }
                  ?>
                  
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    
    <div id="addressModal" style="display: none;">
      <div class="modal-overlay">
        <div class="modal-content">
          <h4>Manage Addresses</h4>
          <div id="addressRows">
          </div>
          <div class="row mb-3">
            <div class="col-md-10">
              <input type="text" class="form-control" id="newAddressField" placeholder="Enter new address">
            </div>
            <div class="col-md-2">
              <button class="btn btn-success" onclick="addAddressBtn()">Add</button>
            </div>
          </div>
          <button class="btn btn-secondary" id="closeModalBtn">Close</button>
        </div>
      </div>
    </div>
    
    <script>
        document.getElementById('addNewAddressBtn').addEventListener('click', function () {
          document.getElementById('addressModal').style.display = 'block';

          const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
              const addressRows = document.getElementById('addressRows');
                document.getElementById('addressRows').innerHTML = this.responseText;
    
          };
          xhttp.open('GET', '../xhttp.php?get_addresses=1&email=<?php echo $email ?>', true);
          xhttp.send();
        });
        
        function addAddressBtn(){
            showLoader();
            const newAddress = document.getElementById('newAddressField').value;
            if (newAddress.trim() !== '') {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText != 2) {
                    hideLoader();
                  alert('Address added successfully!');
                  const addressRows = document.getElementById('addressRows');
                  document.getElementById('addressRows').innerHTML = this.responseText;
                  document.getElementById('newAddressField').value = '';
                } else {
                    hideLoader();
                  alert('Failed to add address.');
                }
            };
            xhttp.open('GET', '../xhttp.php?add_address=1&address='+ newAddress +'&email=<?php echo $email ?>', true);
            xhttp.send();
          }
        }
        
        function editBtn(id){
            showLoader();
            const updatedAddress = document.getElementById('value_' + id).value;
        
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText == 1) {
                  hideLoader();
                  alert('Address updated successfully!');
                } else {
                  hideLoader();
                  alert('Failed to update address.');
                }
            };
            xhttp.open('GET', '../xhttp.php?edit_address='+ id +'&address='+ updatedAddress, true);
            xhttp.send();
        }
        
        
        function deleteBtn(id){
            showLoader();
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText != 2) {
                    hideLoader();
                  alert('Address delete successfully!');
                  const addressRows = document.getElementById('addressRows');
                  document.getElementById('addressRows').innerHTML = this.responseText;
                } else {
                    hideLoader();
                  alert('Failed to delete address.');
                }
            };
            xhttp.open('GET', '../xhttp.php?delete_address='+ id +'&email=<?php echo $email ?>', true);
            xhttp.send();
        }
        
        
        function chooseBtn(id){
            showLoader();
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText != 2) {
                    hideLoader();
                  alert('Address set to default successfully!');
                  const addressRows = document.getElementById('addressRows');
                  document.getElementById('addressRows').innerHTML = this.responseText;
                } else {
                    hideLoader();
                  alert('Failed to set address to default');
                }
            };
            xhttp.open('GET', '../xhttp.php?choose_address='+ id +'&email=<?php echo $email ?>', true);
            xhttp.send();
        }
        
        document.getElementById('closeModalBtn').addEventListener('click', function () {
          // Hide the modal
          document.getElementById('addressModal').style.display = 'none';
        });
        


    </script>

<?php } ?>
 <?php include 'footer.php'; ?>
