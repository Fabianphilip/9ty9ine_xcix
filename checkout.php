<?php include 'header.php' ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $_SESSION['payment_userCart'] = tp_input($conn, "userCart"); 
    $_SESSION['payment_full_name'] = tp_input($conn, "full_name"); 
    $address = (!empty(tp_input($conn, "selected_address")))? tp_input($conn, "selected_address") : tp_input($conn, "address");
    $_SESSION['payment_address'] = $address; 
    $_SESSION['payment_country'] = tp_input($conn, "country"); 
    $_SESSION['payment_state'] = tp_input($conn, "state"); 
    $_SESSION['payment_email'] = tp_input($conn, "email"); 
    $_SESSION['payment_phone'] = tp_input($conn, "phone");
    $_SESSION['payment_products'] = tp_input($conn, "products"); 
    $_SESSION['payment_product_id'] = tp_input($conn, "product_id"); 
    $_SESSION['payment_ref'] = random_strings(20);
    
    ?>
    <script>
        window.location = "paystack_process";
    </script>
    <?php

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
					<form action="" method="POST">
                        <input type="hidden" name="userCart" value="<?php echo $userCart ?>">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="checkbox-form">                     
                                    <h3>Shipping Address Details</h3>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="checkout-form-list">
                                                <label>Full Name <span class="required">*</span></label>                                       
                                                <input type="text" placeholder="" required name="full_name" value="<?php if(!empty($email)){ echo $row_user['full_name']; } ?>" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout-form-list">
                                                <label>Email Address <span class="required">*</span></label>                                        
                                                <input type="email" placeholder="" required name="email" value="<?php if(!empty($email)){ echo $row_user['email']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout-form-list">
                                                <label>Phone <span class="required">*</span></label>                                        
                                                <input type="text" placeholder="" required name="phone" value="<?php if(!empty($email)){ echo $row_user['phone']; } ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="country-select">
                                                <label>Country <span class="required">*</span></label>
                                                <select name="country" id="country" onchange="country_select();" required>
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
                                        <?php if(!empty($email)){ ?>
                                        <h5>Choose Your Address</h5>
                                        <div class="mb-3">
                                            <?php
                                            $query_addresses = mysqli_query($conn, "SELECT * FROM user_addresses WHERE email = '$email'");
                                            
                                            while ($row_address = mysqli_fetch_array($query_addresses)) {
                                                ?>
                                                <div class="form-check">
                                                    <input class="form-check-input address-radio" type="radio" name="selected_address" id="address_<?php echo $row_address['id']; ?>" value="<?php echo $row_address['address']; ?>">
                                                    <label class="form-check-label" for="address_<?php echo $row_address['id']; ?>">
                                                        <?php echo $row_address['address']; ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="form-check">
                                                <input class="form-check-input address-radio" type="radio" name="selected_address" id="other_address" value="other">
                                                <label class="form-check-label" for="other_address">
                                                    Enter a New Address
                                                </label>
                                            </div>
                                            <div id="other_address_field" class="mt-3" style="display: none;">
                                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
                                            </div>
                                        </div>
                                        <?php }else{ ?>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" value="<?php if(!empty($email)){ echo $row_user['address']; } ?>">
                                        </div>
                                        <?php } ?>
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
                                                    $queryProduct = mysqli_query($conn, "SELECT p.rating AS rating, p.id AS id, p.price AS price, c.price AS cartprice, p.name AS name, i.image AS image, c.qty AS qty, p.image_token AS image_token FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token WHERE c.user = '$userCart' AND c.status = '1' GROUP BY p.id");
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

        <?php if(!empty($email)){ ?>
        <script>
            document.querySelectorAll(".address-radio").forEach((radio) => {
                radio.addEventListener("change", function() {
                    const otherAddressField = document.getElementById("other_address_field");
                    if (this.value === "other") {
                        otherAddressField.style.display = "block";
                    } else {
                        otherAddressField.style.display = "none";
                    }
                });
            });

        </script>

        <?php } ?>

        <?php include 'footer.php' ?>