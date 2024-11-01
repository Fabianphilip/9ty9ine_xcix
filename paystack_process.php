<?php
include 'includes/connect.php';
include 'includes/functions.php';
include 'session_front.php';
if(!empty($email)){
    $sql_sel = mysqli_query ($conn, "SELECT * FROM users where email = '$email'");
    $row_user = mysqli_fetch_array ($sql_sel);
    $status = $row_user['status'];
    $is_admin = $row_user['isAdmin'];
    $userCart = $email;
}else{
  $userCart = $sessionId;
}
$sql_sel_general = mysqli_query ($conn, "SELECT * FROM general where id = '1'");
$row_general = mysqli_fetch_array ($sql_sel_general);

$queryCart = mysqli_query($conn, "SELECT * FROM cart WHERE user = '$userCart'");
$countCart   = mysqli_num_rows($queryCart);
$cartProduct = [];
if($countCart > 0){
  while($rowCart = mysqli_fetch_array($queryCart)){
    $cartProduct[] = $rowCart['product'];
  }
}
$queryProduct = mysqli_query($conn, "SELECT SUM(price) AS totalPrice FROM cart WHERE user = '$userCart' AND status = '1'");
if(mysqli_num_rows($queryProduct) > 0){
  $rowProduct = mysqli_fetch_array($queryProduct);
  $totalPrice = $rowProduct['totalPrice']; 
}else{
  $totalPrice = 0;
}

$country_ip = get_client_ip();

$userCart = $_SESSION['payment_userCart'];
$ref = $_SESSION['payment_ref'];
$full_name = $_SESSION['payment_full_name']; 
$address = $_SESSION['payment_address'];
$country2 = $_SESSION['payment_country'];
$state = $_SESSION['payment_state'];
$payment_email = $_SESSION['payment_email'];
$phone = $_SESSION['payment_phone'];
$products = $_SESSION['payment_products'];
$product_id = $_SESSION['payment_product_id'];

$name = $full_name;
$email = (!empty($row_user['email']))?$row_user['email']:"support@betensured.com";
$user_id = $userCart;
if(!empty($userCart) && !empty($country_ip) && !empty($user_id) && !empty($name)){

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
            $query_checkout = mysqli_query($conn, "INSERT INTO product_order (ref, user_id, full_name, address, country, state, email, phone, products, qty, amount) VALUES ('$ref', '$userCart', '$full_name', '$address', '$country2', '$state', '$payment_email', '$phone', '$productID', '$qty', '$price')");
            if(!$query_checkout){
                die("Error checkout $qty $userCart". mysqli_error($conn));
            }
        }
    }


    $sql_enter = "INSERT INTO transaction_log (email, amount, reference, payment_method, status ) VALUES ('$email', '$amount', '$ref', '$payment_method', '0')";

    $queryProduct = mysqli_query($conn, "SELECT p.id AS id, p.price AS price, p.name AS name, i.image AS image FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token  WHERE c.user = '$userCart' AND c.status = '1'");

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

    /////=============Paystack Process=============//////

    $url = "https://api.paystack.co/transaction/initialize";
     $public_key = "pk_test_ad58a6411f3c79ed8f37156bcbdc68f9a580870d"; 
     $secret_key = "sk_test_e2ee709a238dbe23b1457ddb8e049161af692826";

    $redirect_url = "https://$domain/paystack-response"; 
    $txref = $ref;
    $payment_userCart = ""; 


    $fields = [
        'email' => $email,
        'amount'=>$amount*100,
        'country'=>$flutterwave_country,
        'currency'=>$currency,
        'reference'=>$txref,
        'public_key'=>$public_key,
        'callback_url' => "https://$domain/paystack-response?ssiref=".$ref,
        'payment_userCart'=> $payment_userCart
      ];
    $fields_string = http_build_query($fields);
      //open connection
    $ch = curl_init();
      
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer ".$secret_key,
        "Cache-Control: no-cache",
    ));
      
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
      
    //execute post
    $result = curl_exec($ch);
    $transaction = json_decode($result);
    if(!$transaction->data && !$transaction->data->authorization_url){
        // there was an error from the API
        print_r('API returned error: ' . $transaction->data->message);
    }
    echo "<script> window.location.href = '".$transaction->data->authorization_url."'; </script>";

    mysqli_close($conn);

}

?>