<?php include 'header.php' ?>
<div class="page-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title">
                            <h2> Register</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-menu">
                            <ul>
                                <li><a href="#">Home</a> | </li>
                                <li><span>Register</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php  
	        //session_destroy();
	        $_SESSION['email_error'] = "";
	        $_SESSION['password_error'] = "";
	        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signup'])) {  
	            $full_name = tp_input($conn, "full_name");
	            $phone = tp_input($conn, "phone");
	            $email = tp_input($conn, "email");
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

	            $checkQuery = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

	            if (mysqli_num_rows($checkQuery) > 0) {
	                $_SESSION['email_error'] = "email";
	                ?><!--<div class="container"><div class="row d-flex justify-content-center my-4"><div class="col-md-8 alert alert-danger"><?php echo $negative_alert; ?></div></div></div>-->
	                <script type="text/javascript">
	                    swal({
	                      title: "Error",
	                      text: "<?php echo $negative_alert; ?>",
	                      type: "error",
	                      showCancelButton: false,
	                      confirmButtonColor: "#55dd92",
	                      confirmButtonText: "continue",
	                      closeOnConfirm: true
	                    },
	                    function(){
	                      //window.location = "<?php echo $link ?>";
	                    });
	                </script>
	                <?php
	            }
	            elseif ($password != $c_password) {
	                $_SESSION['password_error'] = "password";
	                ?><!--<div class="container"><div class="row d-flex justify-content-center my-4"><div class="col-md-8 alert alert-danger"><?php echo $password_alert; ?></div></div></div>-->
	                <script type="text/javascript">
	                    swal({
	                      title: "Error",
	                      text: "<?php echo $password_alert; ?>",
	                      type: "error",
	                      showCancelButton: false,
	                      confirmButtonColor: "#55dd92",
	                      confirmButtonText: "continue",
	                      closeOnConfirm: true
	                    },
	                    function(){
	                      //window.location = "<?php echo $link ?>";
	                    });
	                </script>
	                <?php
	            }else{
	                if(strlen($full_name) < 40 && strlen($phone) < 18 && strlen($email) < 50 && strlen($city) < 50){
	                    $sql = "INSERT INTO users ".
	                    "(full_name, email, phone, password, otp, profile_photo, uniq_otp_id, country, state, city, address, sex, dob) ".
	                    "VALUES ".
	                    "('$full_name', '$email', '$phone', '$pass', '$otp', '', '$uniq_otp_id', '$country', '$state', '$city', '$address', '$sex', '$dob')";

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
	                    $to = $email;
	                    $subject = $subject_message;
	                    $message = $mail_message;
	                    $message2 = $message;
	                    $message = message_template($subject, $message, $foot_note, $regards, $directory, $domain, $gen_email, $gen_phone);
	                    $headers = "Verify Email Address";
	                    send_mail($to, $subject, $message, $headers, $gen_email);
	                    ?><!--<div class="container"><div class="row d-flex justify-content-center my-4"><div class="col-md-8 alert alert-success"><?php echo $success_alert; ?> <a href="login">Proceed to login</a></div></div></div>-->
	                    <script type="text/javascript">
	                        swal({
	                          title: "Success",
	                          text: "<?php echo $success_alert; ?>",
	                          type: "success",
	                          showCancelButton: false,
	                          confirmButtonColor: "#55dd92",
	                          confirmButtonText: "continue",
	                          closeOnConfirm: false
	                        },
	                        function(){
	                          window.location = "login";
	                        });
	                    </script>

	                    <?php
	                    // header("location:login");
	                  }else{
	                    ?><!--<div class="container"><div class="row d-flex justify-content-center my-4"><div class="col-md-8 alert alert-danger">Something went wrong contact support <a href="login">Proceed to login</a></div></div></div>-->
	                    <script type="text/javascript">
	                        swal({
	                          title: "Error",
	                          text: "Something Went Wrong",
	                          type: "error",
	                          showCancelButton: false,
	                          confirmButtonColor: "#55dd92",
	                          confirmButtonText: "continue",
	                          closeOnConfirm: true
	                        },
	                        function(){
	                          //window.location = "<?php echo $link ?>";
	                        });
	                    </script>
	                    <?php
	                  }
	            }
	        }
	    ?>
        <div class="login-register-area">
            <div class="container">
				<div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-12">
                        <div class="login-form-area">
                           <h5 class="form-title">Register</h5>
                           <p class="sub-form-title">Sign Up Here</p>
                           <div class="social-login" style="display: none;">
                                <a href="#" class="facebook-login"><i class="fa fa-facebook"></i>Sign In With Facebook</a>
                                <a href="#" class="twitter-login"><i class="fa fa-twitter"></i>Sign In With Twitter</a>
                            </div>
                            <form method="post" action="#">
                            	<p class="login-username">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" placeholder="Full Name">
                                </p>
                                <p class="login-username">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" placeholder="DoB">
                                </p>
                                <p class="login-username">
                                    <label>Phone</label>
                                    <input type="number" name="phone" placeholder="Phone">
                                </p>
                                <p class="login-username">
                                    <label>Geder</label>
                                    <select>
                                    	<option>** Choose Gender</option>
                                    	<option value="Male">Male</option>
                                    	<option value="Female">Female</option>
                                    </select>
                                </p>
                                <p class="login-username">
                                	<label>Country</label>
			                        <select name="country" id="country" req="true" required onchange="country_select();">
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
			                    </p>
			                    <p id="state_call" class="login-username">
			                    	<label>State</label>
			                        <select name="state">
			                            <option>State</option>
			                        </select>
			                    </p>
			                    <p class="login-username">
			                    	<label >City</label>
			                        <input type="text" placeholder="City" name="city" required>
			                    </p>
			                    <p class="login-username">
			                    	<label>Address</label>
			                        <input type="text" placeholder="Address" name="address" required>
			                    </p>
                                <p class="login-username">
                                    <label>Email Address</label>
                                    <input type="email" name="email" placeholder="Email">
                                </p>
                                <p class="login-password">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Password">
                                </p>
                                <p class="login-password">
                                    <label>Confirm Password</label>
                                    <input type="password" name="c_password" placeholder="Confirm Password">
                                </p>
                                <a href="#" class="forgot-password" style="display: none;">Forgot Your password?</a>
                                <p class="login-remember">
                                    <label>
                                        <input type="checkbox" value="forever"> Remember me!
                                    </label>
                                </p>
                                <p class="login-submit">
                                    <input type="submit" name="signup" value="Register" class="button-primary" style="background-color: black; color: white;">
                                </p>
                            </form>
                            <p>Already Registered Signin <a href="login">Here</a></p>
                        </div>
					</div>
				</div> 
			</div>
        </div>
        <?php include 'footer.php' ?>