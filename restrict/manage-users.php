<?php include 'header.php' ?>
<?php if(!empty($email)){ ?>
<div class="container mt-4">

<?php           
    $add = get_input($conn, 'add');
    $edit = get_input($conn, 'edit');
    $view = get_input($conn, 'view');
    $send = get_input($conn, 'send');
    $del = get_input($conn, 'del');
    $pn = get_input($conn, 'pn');
    $success = get_input($conn, 'success');
    $error = get_input($conn, 'error');
    
    $name = tp_input($conn, 'name');
    $price = tp_input($conn, 'price');
    $description = html_entity_decode(tp_input($conn, 'description'));
    $discount = tp_input($conn, 'discount');
    $rating = tp_input($conn, 'rating');
    $feature = tp_input($conn, 'feature');
    $category = tp_input($conn, 'category');
    $sub_category = tp_input($conn, 'sub_category');
    $quantity = tp_input($conn, 'quantity');
    $parkig = tp_input($conn, 'parkig');
    $edit_id = tp_input($conn, 'edit_id');
    $editform = tp_input($conn, 'editform');

    
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['editAdmin'])) {  
        $adminId = tp_input($conn, "id");
        $full_name = tp_input($conn, "full_name");
        $phone = tp_input($conn, "phone");
        $adminemail = tp_input($conn, "email");
        $country = tp_input($conn, "country");
        $state = tp_input($conn, "state");
        $city = tp_input($conn, "city");
        $sex = tp_input($conn, "sex");
        $dob = tp_input($conn, "dob");
        $address = tp_input($conn, "address");
        $status = nr_input($conn, "status");
        $isAdmin = tp_input($conn, "isAdmin");
        $password = tp_input($conn, "password_change");
        $success_alert = "Edit Successfull";
        if($password != ''){
            $pass = md5($password);
        }else{
            $queryPAss = mysqli_query($conn, "SELECT * FROM users WHERE id = '$adminId'");
            if(mysqli_num_rows($queryPAss) > 0){
                $rowPass = mysqli_fetch_array($queryPAss);
                $pass = $rowPass['password'];
            }
        }
        $sql = mysqli_query($conn, "UPDATE users SET full_name = '$full_name', email = '$adminemail', phone = '$phone', password = '$pass', country = '$country', state = '$state', city = '$city', address = '$address', sex = '$sex', dob = '$dob', status = '$status', isAdmin = '$isAdmin' WHERE id = '$adminId'");
        if($sql){
            ?><div class="container"><div class="row d-flex justify-content-center my-2"><div class="col-md-8 alert alert-success"><?php echo $success_alert; ?> </div></div></div><?php
        }

    }
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addAdmin'])) {  
        $full_name = tp_input($conn, "full_name");
        $phone = tp_input($conn, "phone");
        $adminemail = tp_input($conn, "email");
        $country = tp_input($conn, "country");
        $state = tp_input($conn, "state");
        $city = tp_input($conn, "city");
        $sex = tp_input($conn, "sex");
        $dob = tp_input($conn, "dob");
        $address = tp_input($conn, "address");
        $password = tp_input($conn, "password");
        $pass = md5($password);
        $c_password = tp_input($conn, "c_password");
        $negative_alert = "Your Email already exist! Please sign in your account.";
        $negative_alert_link ="register";
        $password_alert = "Your passwords dont match please try again";
        $password_alert_link ="register";
        $success_alert = "Registration Successfull";
        $success_alert_link ="verify_email";
        $otp = random_strings(10);
        $referral = random_strings(10);
        $uniq_otp_id = random_strings(55);
        $date_registered = date("Y-m-d H:m:i");

        $checkQuery = mysqli_query($conn, "SELECT * FROM users WHERE email='$adminemail'");

        if (mysqli_num_rows($checkQuery) > 0) {
            ?><div class="container"><div class="row d-flex justify-content-center my-2"><div class="col-md-8 alert alert-danger"><?php echo $negative_alert; ?></div></div></div>
            <?php
        }
        elseif ($password != $c_password) {
            ?><div class="container"><div class="row d-flex justify-content-center my-2"><div class="col-md-8 alert alert-danger"><?php echo $password_alert; ?></div></div></div>
            <?php
        }else{
            if(strlen($full_name) < 40 && strlen($phone) < 18 && strlen($adminemail) < 50 && strlen($address) < 50 && strlen($city) < 50){
                $sql = "INSERT INTO users ".
                "(full_name, email, phone, password, otp, profile_photo, uniq_otp_id, country, state, city, address, sex, dob, status) ".
                "VALUES ".
                "('$full_name', '$adminemail', '$phone', '$pass', '$otp', '', '$uniq_otp_id', '$country', '$state', '$city', '$address', '$sex', '$dob', 1)";

                $retval = mysqli_query( $conn, $sql );
                if(! $retval )
                {
                   die('Could not enter data: ' . $conn->error);
                }
                $subject_message = "Verify Email Address";
                $mail_message = "
                    <div style='margin: 10px 10px;'>
                      <div stlye='margin: 10px 0px; background: rgba(232,168,23,.5); padding: 10px 10px; text-align: center; font-weight: bolder;'>
                        $gen_name
                      </div>
                      <p>Hello $first_name !!</p>
                      <p>Please click the button below to verify your email address.</p>
                      <p><a href='https://$domain/verify_email?uni_id=$uniq_otp_id' style='padding: 10px 30px; background-color: rgb(231,145,121); color: white; font-weight: bolder; border: 1px solid black; border-radius: 6px;'> Verify Email</a></p>
                      <p>If you did not create an account, no further action is required.</p>
                      <p>Regards</p>
                      <p>$gen_name</p>
                      <hr>
                      <p style='font-size: 12px;'>           
                          If you're having trouble clicking the Verify Email Address button, copy and paste the URL below into your web browser: https://$domain/verify_email?uni_id=$uniq_otp_id 
                      </p>
                      <hr>
                      <div stlye='margin: 10px 0px; background: rgba(232,168,23,.5); padding: 10px 10px; text-align: center; font-weight: bolder;'>
                        © $date_year $domain. All rights reserved.
                      </div>
                    </div>
                    ";
                $to = $adminemail;
                $subject = $subject_message;
                $message = $mail_message;
                $message2 = $message;
                $message = message_template($subject, $message, $foot_note, $regards, $directory, $domain, $gen_email, $gen_phone);
                $headers = "Verify Email Address";
                send_mail($to, $subject, $message, $headers, $gen_email);
                ?><div class="container"><div class="row d-flex justify-content-center my-2"><div class="col-md-8 alert alert-success"><?php echo $success_alert; ?> </div></div></div>

                <?php
                // header("location:login");
              }else{
                echo mysqli_error($conn);
                ?><div class="container"><div class="row d-flex justify-content-center my-2"><div class="col-md-8 alert alert-danger">Something went wrong contact support </div></div></div>
                <?php
              }
        }
    }

    
    
    $result = mysqli_query($conn, "SELECT * FROM users");
    $count = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

    <?php if(!empty($success)){ ?> <br><br><div class="alert alert-success"> Success </div> <?php } ?>
    <?php if(!empty($error)){ ?> <br><br><div class="alert alert-danger"> Something Went Wrong!! </div> <?php } ?>
    
    <style>
        .general-link{
            border: 1px solid grey;
            padding: 10px;
            margin: 5px;
        }
    </style>
        
        
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row d-flex justify-content-center">
                        <?php if(empty($add) && empty($edit) && empty($view)){ ?>
                            <div class="col-md-6 p-2 my-0">
                                <h4>Management Products</h4>
                            </div>
                            <div class="col-md-6 p-2 my-0">
                                <a href="manage-users?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add User</a>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="card p-4" style="width: 100%; overflow-x: scroll;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sn</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Sex</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Last Login</th>
                                                <th scope="col">Registered</th>
                                                <th scope="col">Status</th>
                                                <th id="theadhide">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  
                                                $queryAdmin = mysqli_query($conn, "SELECT * FROM users");
                                                if(mysqli_num_rows($queryAdmin) > 0){
                                                    $sn = 0;
                                                    while($rowAdmin = mysqli_fetch_array($queryAdmin)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sn++; ?></td>
                                                            <td><?php echo $rowAdmin['full_name'] ?></td>
                                                            <td><?php echo $rowAdmin['email'] ?></td>
                                                            <td><?php echo $rowAdmin['sex'] ?></td>
                                                            <td><?php echo $rowAdmin['phone'] ?></td>
                                                            <td><?php if($rowAdmin['isAdmin'] == 1){ echo "Admin"; }elseif($rowAdmin['isAdmin'] == 2){ echo "Super Admin"; }elseif($rowAdmin['isAdmin'] == '' || $rowAdmin['isAdmin'] == 0){ echo "User"; }else{ echo "not assigned"; } ?></td>
                                                            <td><?php echo date('d/m/Y H:i:s', strtotime($rowAdmin['last_login'])); ?></td>
                                                            <td><?php echo date('d/m/Y H:i:s', strtotime($rowAdmin['date_registered'])); ?></td>
                                                            <td><?php if($rowAdmin['status'] == 0 || $rowAdmin['status'] == ''){ echo "<span style='padding: 0px 10px; background: red;'></span>"; }else{ echo "<span style='padding: 0px 10px; background: green;'></span>";  } ?></td>
                                                            <td>
                                                                <div class="row d-flex" style="width: 170px;">
                                                                    <div class="col-auto px-0">
                                                                        <a class="btn btn-primary mx-1" href="manage-users?view=<?php echo $rowAdmin['id'] ?>"><i class="fa fa-eye"></i></a>
                                                                    </div>
                                                                    <div class="col-auto px-0">
                                                                        <a class="btn btn-primary mx-1" href="manage-users?edit=<?php echo $rowAdmin['id'] ?>"><i class="fa fa-edit"></i></a>
                                                                    </div>
                                                                    <div class="col-auto px-0">
                                                                        <a class="btn btn-danger mx-1" href="manage-users?delete=<?php echo $rowAdmin['id'] ?>"><i class="fa fa-trash"></i></a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(!empty($add)){ ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>Add Product</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-users" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Full Name</label>
                                            <input type="text" placeholder="Full name" class="form-control" name="full_name" value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Date of Birth</label>
                                            <input type="date" placeholder="DOB" class="form-control" name="dob" value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Phone</label>
                                            <input type="text" placeholder="Phone no" class="form-control" name="phone" value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Sex</label>
                                            <select class="form-control" name="sex" required>
                                                <option>** Choose Sex</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Country</label>
                                            <select class="form-control" name="country" id="country" req="true" required>
                                                <option value="" selected disabled>** Select Country **</option>
                                                <?php
                                                    $query_country = mysqli_query($conn, "SELECT * FROM countries_ where status='1'");
                                                    while ($row_countries = mysqli_fetch_array($query_country)) {
                                                        ?>
                                                        <option value="<?php echo $row_countries['country_name'];?>"><?php echo $row_countries['country_name'];?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">State</label>
                                            <input type="text" name="state" class="form-control" value="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">City</label>
                                            <input type="text" placeholder="City" class="form-control" name="city" value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Address</label>
                                            <input type="text" placeholder="Address" class="form-control" name="address" value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Email</label>
                                            <input type="email" placeholder="hello@finwise.com" class="form-control" name="email" value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Admin Status</label>
                                            <div id="state_call">
                                                <select class="form-control" name="status">
                                                    <option value=""></option>
                                                    <option value="">Not Active</option>                                                    
                                                    <option value="1">Active</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php if($is_admin == 2){ ?>
                                            <div class="mb-3">
                                                <label for="exampleInputPassword1" class="form-label">Make Admin</label>
                                                <div id="state_call">
                                                    <select class="form-control" name="isAdmin">
                                                        <option <?php if($rowAdminEdit['isAdmin'] == '' || $rowAdminEdit['isAdmin'] == 0){ ?> selected <?php } ?> value="">'Not Admin</option>
                                                        <option value="1">Admin</option>
                                                        <option value="2">Super Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                            <input type="password" name="password">
                                        </div>

                                        <div class="d-grid">
                                            <input  class="btn btn-primary" class="form-control" name="editAdmin" type="submit" value="Edit Admin">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        
                        <?php } ?>
                        <?php if(!empty($edit)){ ?>
                            <?php
                            $queryAdminEdit = mysqli_query($conn, "SELECT * FROM users WHERE id = '$edit'");
                            if(mysqli_num_rows($queryAdminEdit) > 0){
                                $rowAdminEdit = mysqli_fetch_array($queryAdminEdit);
                                ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $edit; ?>">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Full Name</label>
                                        <input type="text" placeholder="Full name" class="form-control" name="full_name" value="<?php echo $rowAdminEdit['full_name'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Date of Birth</label>
                                        <input type="date" placeholder="DOB" class="form-control" name="dob" value="<?php echo $rowAdminEdit['dob'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Phone</label>
                                        <input type="text" placeholder="Phone no" class="form-control" name="phone" value="<?php echo $rowAdminEdit['phone'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Sex</label>
                                        <select class="form-control" name="sex" required>
                                            <option>** Choose Sex</option>
                                            <option <?php if($rowAdminEdit['sex'] == "male"){ ?> selected <?php } ?> value="male">Male</option>
                                            <option <?php if($rowAdminEdit['sex'] == "female"){ ?> selected <?php } ?>  value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Country</label>
                                        <select class="form-control" name="country" id="country" req="true" required>
                                            <option value="" selected disabled>** Select Country **</option>
                                            <?php
                                                $query_country = mysqli_query($conn, "SELECT * FROM countries_ where status='1'");
                                                while ($row_countries = mysqli_fetch_array($query_country)) {
                                                    ?>
                                                    <option <?php if($rowAdminEdit['country'] == $row_countries['country_name']){ ?> selected <?php } ?> value="<?php echo $row_countries['country_name'];?>"><?php echo $row_countries['country_name'];?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">State</label>
                                        <input type="text" name="state" class="form-control" value="<?php echo $rowAdminEdit['state'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">City</label>
                                        <input type="text" placeholder="City" class="form-control" name="city" value="<?php echo $rowAdminEdit['city'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Address</label>
                                        <input type="text" placeholder="Address" class="form-control" name="address" value="<?php echo $rowAdminEdit['address'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Email</label>
                                        <input type="email" placeholder="hello@finwise.com" class="form-control" name="email" value="<?php echo $rowAdminEdit['email'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Admin Status</label>
                                        <div id="state_call">
                                            <select class="form-control" name="status">
                                                <option <?php if($rowAdminEdit['status'] == 1){ ?> selected <?php } ?> value="1">Active</option>
                                                <option <?php if($rowAdminEdit['status'] == '' || $rowAdminEdit['status'] == 0){ ?> selected <?php } ?> value="">Not Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($is_admin == 2){ ?>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Make Admin</label>
                                            <div id="state_call">
                                                <select class="form-control" name="isAdmin">
                                                    <option <?php if($rowAdminEdit['isAdmin'] == '' || $rowAdminEdit['isAdmin'] == 0){ ?> selected <?php } ?> value="">'Not Admin</option>
                                                    <option <?php if($rowAdminEdit['isAdmin'] == 1){ ?> selected <?php } ?> value="1">Admin</option>
                                                    <option <?php if($rowAdminEdit['isAdmin'] == 2){ ?> selected <?php } ?> value="2">Super Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="password" style="display: none;">
                                        <input type="password" class="form-control" id="password_change" name="password_change" placeholder="Password" autocomplete="new-password">
                                    </div>

                                    <div class="d-grid">
                                        <input  class="btn btn-primary" class="form-control" name="editAdmin" type="submit" value="Edit Admin">
                                    </div>
                                </form>
                                <?php
                            }
                        ?>
                        <?php } ?>
                        <?php if(!empty($view)){ ?>
                            <?php
                                $query_view = mysqli_query($conn, "SELECT * FROM product WHERE id = '$view'");
                                $row = mysqli_fetch_array($query_view);
                                $name = $row['name'];
                                $image_token = $row['image_token'];
                                $feature = $row['feature'];
                                $category = $row['category'];
                                $sub_category = $row['sub_category'];
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View Product</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-users" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-users?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                            
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <div class="row">
                                        <div class="col-md-3">Id:</div><div class="col-md-9"><?php echo $row['id'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Image:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_image = mysqli_query($conn, "SELECT * FROM product_images WHERE token = '$image_token'");
                                                if(mysqli_num_rows($query_image) > 0){
                                                    while($row_image = mysqli_fetch_array($query_image)){
                                                        ?><img src="../product_images" style="max-width: 100px; max-height: 100px; margin: 10px;"><?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Product Name:</div><div class="col-md-9"><?php echo $row['name'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Price:</div><div class="col-md-9"><?php echo number_format($row['price']) ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Quantity:</div><div class="col-md-9"><?php echo $row['quantity'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Parking:</div><div class="col-md-9"><?php echo $row['parking'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Feature:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_feature = mysqli_query($conn, "SELECT * FROM feature WHERE id = '$feature'");
                                                if(mysqli_num_rows($query_feature) > 0){
                                                    while($row_feature = mysqli_fetch_array($query_feature)){
                                                        echo $row_feature['name'];
                                                    }
                                                } 
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Category:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_category = mysqli_query($conn, "SELECT * FROM category WHERE id = '$category'");
                                                if(mysqli_num_rows($query_category) > 0){
                                                    while($row_category = mysqli_fetch_array($query_category)){
                                                        echo $row_category['name'];
                                                    }
                                                } 
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Sub Category:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_sub_category = mysqli_query($conn, "SELECT * FROM sub_category WHERE id = '$sub_category'");
                                                if(mysqli_num_rows($query_sub_category) > 0){
                                                    while($row_sub_category = mysqli_fetch_array($query_sub_category)){
                                                        echo $row_sub_category['name'];
                                                    }
                                                } 
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Description:</div><div class="col-md-9"><?php echo html_entity_decode($row['description']) ?></div>
                                    </div><hr>
                                </div>
                            </div>
                        <?php } ?>

                        
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / .container-fluid -->
    <script type="text/javascript">
        function selectCategory() {
            const xhttp = new XMLHttpRequest();
            var category = document.getElementById("category").value;
            xhttp.onload = function() {
                document.getElementById("subcategory_call").innerHTML =this.responseText;
            }
            xhttp.open("GET", "../xhttp?category=" + category);
            xhttp.send();
        }
    </script>
<?php } ?>
<?php include 'footer.php'; ?>