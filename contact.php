<?php include 'header.php' ?>
<?php
    if(isset($_POST['send'])){
        $name = tp_input($conn, 'name');
        $client_email = tp_input($conn, 'client_email');
        $subject = tp_input($conn, 'subject');
        $message = tp_input($conn, 'message');
        $subject_message = "Verify Email Address";
        $mail_message = "
            <div style='margin: 10px 10px;'>\
                name: $name <br>
                Email: $client_email <br>
              $message
            </div>
            ";
        $to = $email;
        $message = $mail_message;
        $message2 = $message;
        $message = message_template($subject, $message, $foot_note, $regards, $directory, $domain, $gen_email, $gen_phone);
        $headers = "Verify Email Address";
        if(send_mail($row_general['site_email'], $subject, $message, $headers, $gen_email)){
            ?><script type="text/javascript">alert('message sent succesfilly');</script><?php
        }
    }
?>
<div class="page-header-area">
    <div class="">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>Contact</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PAGE-HEADER-AREA-END -->
<!-- BREADCRUMB-AREA-START -->
<div class="breadcrumb-area">
    <div class="">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-menu">
                    <ul>
                        <li><a href="#">Home</a> | </li>
                        <li><span>Contact</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB-AREA-END -->
<div class="my-4 py-4">
    <div class="row">
        <div class="col-12">
            <!-- MAP START-->
            <div class="contact-map position-relative">
                <div id="googleMap" style="width:100%;height:430px;"></div>
                <div class="contact-info">
                     <h3 class="footer-title">CONTACT US</h3>
                     <div class="address-area">
                         <ul>
                            <li>
                                <a href=""><i class="fa fa-map-marker"></i>
                                <span><?php echo $row_general['site_address'] ?></span></a>
                            </li>
                            <li>
                                <a href="mailto:<?php echo $row_general['site_email'] ?>"><i class="fa fa-envelope"></i>
                                <span><?php echo $row_general['site_email'] ?></span></a>
                            </li>
                            <li>
                                <a href="tel:<?php echo $row_general['site_phone'] ?>"><i class="fa fa-phone"></i>
                                <span><?php echo $row_general['site_phone'] ?></span></a>
                            </li>
                        </ul>
                     </div>
                 </div>
            </div>
            <!-- MAP END-->
        </div>
    </div>
    <div class="contact-form">
        <form method="post" >
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-form-area">
                        <p>
                            <label>Name <span class="required">*</span></label>
                            <input type="text" name="name">
                        </p>
                        <p>
                            <label>Email <span class="required">*</span></label>
                            <input type="text" name="client_email">
                        </p>
                        <p>
                            <label>Subject</label>
                            <input type="text" name="subject">
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form-area">
                        <p class="comment-form-comment">
                            <label>Content <span class="required">*</span></label>
                            <textarea cols="60" rows="6" name="message"></textarea>
                        </p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <p class="form-submit">
                        <input type="submit" value="Send Message" name="submitform">
                    </p>
                </div>
            </div>
         </form>
    </div>
</div>
<?php include 'footer.php' ?>