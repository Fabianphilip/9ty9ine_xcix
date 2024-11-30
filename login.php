<?php include 'header.php' ?>
<div class="page-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title">
                            <h2>Login</h2>
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
                                <li><span>Login</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
		    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signin'])) {
		        $email= tp_input($conn, "email"); 
		        $password = tp_input($conn, "password");
		        $main_password = md5($password);
		        $negative_alert = "Wrong email or password.";
		        $negative_alert_link ="login"; 

		        $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' and password='$main_password' ");
		        $count = mysqli_num_rows($query);
		        
		        if(isset($_SESSION['link'])){
		            $goto_link =  $_SESSION['link'];
		            $link = $goto_link;
		        }else{
		            $link = "user/dashboard";
		        }

		        if ($count > 0) {
		        	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		        	$status = $row['status'];
		            $_SESSION['email'] = $row['email'];
		            $email = $_SESSION['email'];
		            $result=mysqli_num_rows($query);
		            $count=mysqli_num_rows($query);

		            if($count==1){
		                    //if($status == 1){
		                    $date_time = date("Y-m-d H:m:i");
		                    $get_lastLogin = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
		                    $row_lastLogin = mysqli_fetch_array($get_lastLogin);
		                    $last_login = $row_lastLogin["current_login"];
		                    $get_lastIp = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
		                    $row_lastIp = mysqli_fetch_array($get_lastLogin);
		                    $last_ip = $row_lastLogin["current_ip"];
		                    $update_currentLogin = mysqli_query($conn, "UPDATE users SET current_login = '$date_time', last_login = '$last_login', current_ip = '$country_ip', last_ip = '$last_ip' WHERE email = '$email'");
		                    ?>
		                    <script type="text/javascript">
		                      //window.location="<?php echo $link; ?>";
		                    </script>
		                    <script type="text/javascript">
		                        swal({
		                          title: "Success",
		                          text: "Login successfull",
		                          type: "success",
		                          showCancelButton: false,
		                          confirmButtonColor: "#55dd92",
		                          confirmButtonText: "continue",
		                          closeOnConfirm: false
		                        },
		                        function(){
		                          window.location = "<?php echo $link ?>";
		                        });
		                        setTimeout(function() {
		                            window.location = "<?php echo $link ?>";
		                        }, 2000);
		                    </script>
		                    <?php 
		                //}else{
		                    ?><div class="row d-flex justify-content-center" style="display: none;"><div class="col-md-9 m-4"><div class="alert alert-danger">Your accout is currently being reviewed, kindly excercise patient as this will be done within 24 - 48 hrs</div></div></div><?php
		                //}
		            }
		        }
		        else {
		            ?><!--<div class="container"><div class="row d-flex justify-content-center my-4"><div class="col-md-8 alert alert-danger"><?php echo $negative_alert; ?></div></div></div>-->
		            <script type="text/javascript">
		                swal({
		                  title: "Error",
		                  text: "<?php echo $negative_alert; ?>",
		                  type: "error",
		                  showCancelButton: false,
		                  confirmButtonColor: "#55dd92",
		                  confirmButtonText: "Try again",
		                  closeOnConfirm: true
		                },
		                function(){
		                  //window.location = "deposit";
		                });
		            </script>
		            <?php
		        }
		    }
		?>
        <div class="login-register-area">
            <div class="container">
				<div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-12">
                        <div class="login-form-area">
                           <h5 class="form-title">Login</h5>
                           <p class="sub-form-title">Hello, Welcome your to account</p>
                           <div class="social-login" style="display: none;">
                                <a href="#" class="facebook-login"><i class="fa fa-facebook"></i>Sign In With Facebook</a>
                                <a href="#" class="twitter-login"><i class="fa fa-twitter"></i>Sign In With Twitter</a>
                            </div>
                            <form method="post" action="#">
                                <p class="login-username">
                                    <label>Email Address</label>
                                    <input type="email" name="email" placeholder="Email">
                                </p>
                                <p class="login-password">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Password">
                                </p>
                                <a href="#" class="forgot-password">Forgot Your password?</a>
                                <p class="login-remember">
                                    <label>
                                        <input type="checkbox" value="forever"> Remember me!
                                    </label>
                                </p>
                                <p class="login-submit">
                                    <input type="submit" name="signin" value="LogIn" class="button-primary">
                                </p>
                            </form>
                            <p>Don't have an acconut Signup <a href="register">Here</a></p>
                        </div>
					</div>
				</div> 
			</div>
        </div>
        <?php include 'footer.php' ?>