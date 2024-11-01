<?php include 'header.php' ?>
<div class="page-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title">
                            <h2>Verify Email</h2>
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
                                <li><span>Verify Email</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="login-register-area">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-6 col-lg-6">
                <!-- Intro -->
                <div class="intro text-center">
                    <span>Email Verification Page</span>
                    <h3 class="mt-2 mb-0">Email Verification Process</h3>
                </div>
                <br>


                <div class="product-style-one" style="padding: 50px;">
                    <?php
                        $uniq_otp_id = get_input($conn, "uni_id");
                        $query = mysqli_query($conn, "SELECT * FROM users WHERE uniq_otp_id='$uniq_otp_id'");
                        $row = mysqli_fetch_array($query);
                        $full_name = $row['full_name'];
                        $email = $row['email'];
                        if(mysqli_num_rows($query)>0){
                            mysqli_query($conn, "UPDATE users SET status='1' WHERE uniq_otp_id='$uniq_otp_id'");
                            $subject_message = "Successfull Account Registration";
                            $mail_message = "
                                    <div style='margin: 10px 10px;'>
                                      <div stlye='margin: 10px 0px; background: rgba(232,168,23,.5); padding: 10px 10px; text-align: center; font-weight: bolder;'>
                                        $gen_name
                                      </div>
                                      <p>Hello $full_name !!</p>
                                      <p>Account Registration Successfull!!!</p>
                                      <p>If you did not create an account, no further action is required.</p>
                                      <p>Regards</p>
                                      <p>$gen_name</p>
                                      <hr>
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
                               $headers = "Successfull Account Registration";
                               send_mail($to, $subject, $message, $headers, $gen_email);
                            ?>
                            <div style="text-align: center;">
                                <i class="fa fa-check-circle" style="color: green; font-size: 28px;"></i>
                                <h5 style="font-size: 18px;">Email Verified Scucessfully</h5>
                                <a href="login" class="rn-btn">Continue to Login!!</a>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div style="text-align: center;">
                                <i class="fa fa-thumbs-down" style="color: green; font-size: 28px;"></i>
                                <h5 style="font-size: 18px;">Error in email verification | Please contact support</h5>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>





<?php
include 'footer.php'
?>