<?php include 'header.php' ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $userCart = tp_input($conn, "userCart"); 
    $full_name = tp_input($conn, "full_name"); 
    $address = tp_input($conn, "address"); 
    $country2 = tp_input($conn, "country"); 
    $state = tp_input($conn, "state"); 
    $email = tp_input($conn, "email"); 
    $phone = tp_input($conn, "phone"); 
    $products = tp_input($conn, "products"); 
    $product_id = tp_input($conn, "product_id"); 
    if(isset($_POST['Paystack'])){
        $payment_method = "Paystack";
    }
    if(isset($_POST['Paypal'])){
        $payment_method = "Paypal";
    }
    
    $ref = tp_input($conn, "ref");
    $_SESSION['ref'] = $ref;

    if($payment_method == "Paypal"){
        $amount = tp_input($conn, "amount");
    }

    $sql_sel_t = mysqli_query ($conn, "SELECT sum(price) as total_price FROM cart WHERE user = '$userCart'");
    $row_t = mysqli_fetch_array($sql_sel_t);
    if($country == "NG"){
        $amount = $row_t['total_price'];
    }else{
        $amount = $row_t['total_price']/$currency_value;
    }

    $sql_sel_tt = mysqli_query ($conn, "SELECT sum(price) as total_price, qty, price, product FROM cart WHERE user = '$userCart'");
    if(mysqli_num_rows($sql_sel_tt) > 0){
        while($rowCart = mysqli_fetch_array($sql_sel_tt)){
            $productID = $rowCart['product'];
            $qty = $rowCart['qty'];
            $price = $rowCart['price'];
            $query_checkout = mysqli_query($conn, "INSERT INTO product_order (ref, user_id, full_name, address, country, state, email, phone, products, qty, amount) VALUES ('$ref', '$userCart', '$full_name', '$address', '$country2', '$state', '$email', '$phone', '$productID', '$qty', '$price')");
            if(!$query_checkout){
                die("Error checkout $qty $userCart". mysqli_error($conn));
            }
        }
    }


    $sql_enter = "INSERT INTO transaction_log ".
    "(email, amount, reference, payment_method, status ) ".
    "VALUES ".
    "('$email', '$amount', '$ref', '$payment_method', '0')";




$queryProduct = mysqli_query($conn, "SELECT p.id AS id, p.price AS price, p.name AS name, i.image AS image 
                                     FROM cart c 
                                     JOIN product p ON p.id = c.product 
                                     JOIN product_images i ON i.token = p.image_token 
                                     WHERE c.user = '$userCart' AND c.status = '1'");

$product_list = '';

if (mysqli_num_rows($queryProduct) > 0) {
    while ($rowProduct = mysqli_fetch_array($queryProduct)) {
        $product_list .= "
            <li>
                <div class='d-flex justify-content-between p-2' style='width: 100%;'>
                    <span>
                        <img src='product_images/" . $rowProduct['image'] . "' style='width: 50px' alt='Product Image'> 
                        " . $rowProduct['name'] . "
                    </span>
                    <span>" . $rowProduct['price'] . " 
                        <span style='padding: 10px;' onclick=\"removefromcartsidebar('product_" . $rowProduct['id'] . "_0')\">
                            <i class='fa fa-times'></i>
                        </span>
                    </span>
                </div>
            </li>
        ";
    }
} else {
    $product_list = "<li>No items in cart</li>";
}



                    

    $initials = $full_name;
    $subject_message = "Payment Attempt Notification";
    $mail_message = "<table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
    <tr>
    <td>&nbsp;</td>
    <td class='container'>
    <div class='content'>

    <!-- START CENTERED WHITE CONTAINER -->
    <table role='presentation' class='main'>

    <!-- START MAIN CONTENT AREA -->
    <tr>
    <td class='wrapper'>
    <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
    <tr>
    <td>
    <center><h3>Payment Attempt Notification</h3></center>
    <p>Hello $initials,</p>
    <p>Todays a great day! this is to notify you on your payment attempt for the products <br> 
    <ul style=''>
        <li class='dropdown-header' style='width: 100%;'>Cart Items <span style='padding: 10px; float: right;' onclick='closesidecart()'><i class='fa fa-times'></i></span></li>
        <span>
        $product_list
        </span>
    </ul>
    <br>with reference no $ref and amount $amount wishing you well</p>
    <p> Our reperesentative will contact you shortly for briefing</p>
    <p>You can also feel free to reach out to us</p>
    <p>Join the fast growing community</p>
    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary'>
    <tbody>
    <tr>
    <td align='left'>
    <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
    <tbody>
    <tr>
    <td> <a href='http://www.norvas.org/signin' target='_blank'>Continue</a> </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <p>You just took your first step to faster and richer market online.</p>
    <p>Good luck!.</p>
    </td>
    </tr>
    </table>
    </td>
    </tr>

    <!-- END MAIN CONTENT AREA -->
    </table>";

    $to = "$email";
    $subject = $subject_message;
    $message = $mail_message;
    $message2 = $message;
    $message = message_template($subject, $message, $foot_note, $regards, $directory, $domain, $gen_email, $gen_phone);
    $headers = "Payment Attempt Notification";
    send_mail($to, $subject, $message, $headers, $gen_email);


    $enter_data = mysqli_query($conn, $sql_enter);
    if (!$enter_data) {
      die('Could not enter data: ' . $conn->error);
    }

    if ($payment_method == "Paystack") {
      $plan = "custom";
      $next_link = "payment_custom";
      payment_process1($email, $amount, $country_pay, $country, $ref, $plan, $next_link);
    }

    if ($payment_method == "Paypal" && !empty($paypal_pay_succ)) {
        $update_tra_log_paypal = mysqli_query($conn, "UPDATE transaction_log SET status = '1' WHERE reference = '$ref'");

        $transaction_log_order = "UPDATE product_order SET pay_status = '1' WHERE email = '$email' AND ref = '$ref' AND user_id = '$userCart'";
        $transaction_log_update_order = mysqli_query($conn, $transaction_log_order);
        if (!$transaction_log_update_order) {
         die('Could not update data: ' . $conn->error);
     }



     $sql_enter = "INSERT INTO payments ".
     "(email, amount, reference, plan) ".
     "VALUES ".
     "('$email', '$amount', '$ref', '$plan')";

     $enter_data = mysqli_query($conn, $sql_enter);
     if (!$enter_data) {
         die('Could not enter data: ' . $conn->error);
     }

     if ($update_tra_log_paypal) {
        $initials = $firstname;
        $subject_message = "Payment Success Notification";
        $mail_message = "<table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
        <tr>
        <td>&nbsp;</td>
        <td class='container'>
        <div class='content'>

        <!-- START CENTERED WHITE CONTAINER -->
        <table role='presentation' class='main'>

        <!-- START MAIN CONTENT AREA -->
        <tr>
        <td class='wrapper'>
        <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
        <tr>
        <td>
        <center><h3>Payment Attempt Notification</h3></center>
        <p>Hello $initials,</p>
        <p>Todays a great day! this is to notify you on your concluded payment for the products <br> 
        <ul style=''>
            <li class='dropdown-header' style='width: 100%;'>Cart Items <span style='padding: 10px; float: right;' onclick='closesidecart()'><i class='fa fa-times'></i></span></li>
            <span>
            $product_list
            </span>
        </ul>
        <br> with reference no $ref and amount $currency$amount wishing you well</p>
        <p>Join the fast growing community</p>
        <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary'>
        <tbody>
        <tr>
        <td align='left'>
        <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
        <tbody>
        <tr>
        <td> <a href='http://www.norvas.org/signin' target='_blank'>Continue</a> </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        <p>You just took your first step to faster and richer market online.</p>
        <p>Good luck!.</p>
        </td>
        </tr>
        </table>
        </td>
        </tr>

        <!-- END MAIN CONTENT AREA -->
        </table>";

        $to = "$email";
        $subject = $subject_message;
        $message = $mail_message;
        $message2 = $message;
        $message = message_template($subject, $message, $foot_note, $regards, $directory, $domain, $gen_email, $gen_phone);
        $headers = "Payment Success Notification";
        send_mail($to, $subject, $message, $headers, $gen_email);

        $clearCart = mysqli_query($conn, "DELETE FROM cart  WHERE user = '$userCart'");
    }
    ?>
    <script>
        alert("Payment successfull");
        window.location = "/";
    </script>
    <?php
    }

}
?>
<div class="coupon-area">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="coupon-accordion">
							<!-- ACCORDION START -->
							<h3>Returning customer? <span id="showlogin">Click here to login</span></h3>
							<div id="checkout-login" class="coupon-content">
								<div class="coupon-info">
									<p class="coupon-text">If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>
									<form action="#">
										<p class="form-row-first">
											<label>Username or email <span class="required">*</span></label>
											<input type="text" />
										</p>
										<p class="form-row-last">
											<label>Password  <span class="required">*</span></label>
											<input type="text" />
										</p>
										<p class="form-row">                    
											<input type="submit" value="Login" />
											<label>
												<input type="checkbox" />
												 Remember me 
											</label>
										</p>
										<p class="lost-password">
											<a href="#">Lost your password?</a>
										</p>
									</form>
								</div>
							</div>
							<h3>Have a coupon? <span id="showcoupon">Click here to enter your code</span></h3>
							<div id="checkout_coupon" class="coupon-checkout-content">
								<div class="coupon-info">
									<form action="#">
										<p class="form-row-first">
											<input type="text" placeholder="Coupon code" />
										</p>
										<p class="form-row-last">
											<input type="submit" value="Apply Coupon" />
										</p>
									</form>
								</div>
							</div>
							<!-- ACCORDION END -->                      
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- coupon-area end -->
		<!-- checkout-area start -->
		<div class="checkout-area">
			<div class="container">
				<div class="row">
					<form action="#">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="checkbox-form">                     
                                    <h3>Shipping Address Details</h3>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout-form-list">
                                                <label>Full Name <span class="required">*</span></label>                                       
                                                <input type="text" placeholder="" name="full_name" value="<?php if(!empty($email)){ echo $row_user['full_name']; } ?>" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout-form-list">
                                                <label>Last Name <span class="required">*</span></label>                                        
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="checkout-form-list">
                                                <label>Company Name</label>
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout-form-list">
                                                <label>Email Address <span class="required">*</span></label>                                        
                                                <input type="email" placeholder="" name="email" value="<?php if(!empty($email)){ echo $row_user['email']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout-form-list">
                                                <label>Phone <span class="required">*</span></label>                                        
                                                <input type="text" placeholder="" name="phone" value="<?php if(!empty($email)){ echo $row_user['phone']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="country-select">
                                                <label>Country <span class="required">*</span></label>
                                                <select name="country" id="country" onchange="country_select();">
                                                    <option value="" selected disabled>** Select Country **</option>
                                                    <?php
                                                    $query_country = mysqli_query($conn, "SELECT * FROM countries_ where status='1'");
                                                    while ($row_countries = mysqli_fetch_array($query_country)) {
                                                        ?>
                                                        <option <?php if(!empty($email)){ if($row_user['country'] == $row_countries['country_name']){ ?> selected <?php } } ?> value="<?php echo $row_countries['country_name'];?>"><?php echo $row_countries['country_name'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>                                     
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="checkout-form-list">
                                                <label>Address <span class="required">*</span></label>
                                                <input type="text" placeholder="Street address" name="address" value="<?php if(!empty($email)){ echo $row_user['address']; } ?>" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="country-select" id="state_call">
                                                <label>State<span class="required">*</span></label>                         
                                                <select name="state">
                                                    <option>State</option>
                                                    <?php
                                                        if(!empty($email)){
                                                            $country_dropdown = $row_user['country'];
                                                            $query_c = mysqli_query($conn, "SELECT * FROM countries_ WHERE country_name='$country_dropdown'");
                                                            $row_c = mysqli_fetch_array($query_c);
                                                            $country_id = $row_c['country_id'];
                                                            $query_states = mysqli_query($conn, "SELECT * FROM states WHERE country_id='$country_id'");
                                                            while ($row_states = mysqli_fetch_array($query_states)) {
                                                                ?>
                                                                <option <?php if(!empty($email)){ if($row_user['state'] == $row_states['state_name']){ ?> selected <?php } } ?> value="<?php echo $row_states['state_name'];?>"><?php echo $row_states['state_name'];?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>                              
                                    </div>                                                 
                                </div>
                            </div>  
                            <div class="col-lg-6 col-12">
                                <div class="your-order">
                                    <h3>Your order</h3>
                                    <div class="your-order-table table-responsive">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="product-name">Product</th>
                                                    <th class="product-total">Total</th>
                                                </tr>                           
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $queryProduct = mysqli_query($conn, "SELECT p.rating AS rating, p.id AS id, p.price AS price, c.price AS cartprice, p.name AS name, i.image AS image, c.qty AS qty, p.image_token AS image_token FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token WHERE c.user = '$userCart' AND c.status = '1'");
                                                    if(mysqli_num_rows($queryProduct) > 0){
                                                        while($rowProduct = mysqli_fetch_array($queryProduct)){
                                                          ?>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                                <?php echo $rowProduct['name']; ?> <strong class="product-quantity"> × <?php echo $rowProduct['qty'] ?></strong>
                                                            </td>
                                                            <td class="product-total">
                                                                <span class="amount">₦<?php echo number_format($rowProduct['cartprice'], 2) ?></span>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <?php
                                                    $queryProduct = mysqli_query($conn, "SELECT SUM(price) AS totalPrice FROM cart WHERE user = '$userCart' AND status = '1'");
                                                   if(mysqli_num_rows($queryProduct) > 0){
                                                    $rowProduct = mysqli_fetch_array($queryProduct);
                                                        $totalPrice = $rowProduct['totalPrice']; 
                                                    }else{
                                                        $totalPrice = 0;
                                                    }
                                                ?>
                                                <tr class="cart-subtotal">
                                                    <th>Cart Subtotal</th>
                                                    <td><span class="amount">₦<?php echo number_format($totalPrice, 2); ?></span></td>
                                                </tr>
                                                <tr class="shipping" style="display: none;">
                                                    <th>Shipping</th>
                                                    <td>
                                                        <ul>
                                                            <li>
                                                                <input type="radio" />
                                                                <label>
                                                                    Flat Rate: <span class="amount">£18.00</span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" />
                                                                <label>Free Shipping:</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" />
                                                                <label>International Delivery: <span class="amount">£120.00</span></label>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th>Order Total</th>
                                                    <td><strong><span class="amount">₦<?php echo number_format($totalPrice, 2); ?></span></strong>
                                                    </td>
                                                </tr>                               
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="checkout-payment-wrapper mt-3">
                                        <h4 class="title-tertiary text-capitalize">Select Payment Method</h4>
                                        <div class="checkout-payment">
                                            <ul>
                                                <li>
                                                    <div class="custom-checkbox">
                                                        <div class="custom-checkbox__group payment_radio">
                                                            <input type="radio" id="payment_check" class="checkbox_input"
                                                                name="payment_mathod" checked>
                                                            <label for="payment_check" class="checkbox__label mb-2">
                                                                <span class="checkbox__type-radio"></span>
                                                                Check Payment
                                                            </label>
                
                                                            <div class="payment-option-form" id="payment_check_form"
                                                                style="display: block;">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="single-form mb-3">
                                                                            <input type="text"
                                                                                placeholder="Enter Your Bank Account Number" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox">
                                                        <div class="custom-checkbox__group payment_radio">
                                                            <input type="radio" id="payment_paypal" class="checkbox_input"
                                                                name="payment_mathod">
                                                            <label for="payment_paypal" class="checkbox__label mb-2">
                                                                <span class="checkbox__type-radio"></span>
                                                                Paypal
                                                            </label>
                
                                                            <div class="payment-option-form" id="payment_paypal_form"
                                                                style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="single-form mb-3">
                                                                            <input type="email" placeholder="Enter Your Paypal Email"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox">
                                                        <div class="custom-checkbox__group payment_radio">
                                                            <input type="radio" id="payment_card" class="checkbox_input"
                                                                name="payment_mathod">
                                                            <label for="payment_card" class="checkbox__label mb-2">
                                                                <span class="checkbox__type-radio"></span>
                                                                Card
                                                            </label>
                                                            <div class="payment-option-form" id="payment_card_form"
                                                                style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="single-form  mb-3">
                                                                            <input type="email" placeholder="Enter Your Card Number"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox">
                                                        <div class="custom-checkbox__group payment_radio">
                                                            <input type="radio" id="payment_cod" class="checkbox_input"
                                                                name="payment_mathod">
                                                            <label for="payment_cod" class="checkbox__label mb-2">
                                                                <span class="checkbox__type-radio"></span>
                                                                Cash On Delivery
                                                            </label>
                
                                                            <div class="payment-option-form" id="payment_cod_form"
                                                                style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="single-form  mb-3">
                                                                            <p>Please send a Check to Store name with Store Street,
                                                                                Store Town, Store State, Store Postcode, Store Country.
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-button-payment">
                                            <button class="btn" type="submit">Place order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</form>
				</div>
			</div>
		</div>

        <?php include 'footer.php' ?>