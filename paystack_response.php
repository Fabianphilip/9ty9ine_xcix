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

// $merchant_ref = $_SESSION["trans_ref"];
$merchant_ref = $_GET["ssiref"];
// echo($merchant_ref);
// exit;
$result = mysqli_query($conn, "transaction_log", "WHERE user_id = '$id' AND reference_no = '$merchant_ref'", "*", "");
$row = fetch_data($result);

$trans_ref = $row["ref"];
$log_id = $row["id"];
$email = $row["email"];
$reference = $row["reference"];
$email = $row["email"];
$name = $_SESSION['payment_full_name']; 
$amount2 = $row["amount"].'00';
$amount = $row["amount"];
$status = $row["status"];
$payment_means = $row["payment_method"];
$currency = "NGN";

$message = "";

$ref = $merchant_ref;


// $query = array(
//     $secret_key => "sk_test_20baee5b886efdfc7aefdccb8faed10e09090040",
//     "txref" => $ref
// );

$data_string = json_encode($query);

// $transaction_id = $_GET["trxref"];
$transaction_id = $_GET["ssiref"];
$curl = curl_init();
// $secret_key = "sk_test_20baee5b886efdfc7aefdccb8faed10e09090040";
$secret_key = "sk_test_e2ee709a238dbe23b1457ddb8e049161af692826";
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$transaction_id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$secret_key,
        "Cache-Control: no-cache",
    ),
));

$response = curl_exec($curl);

// $err = curl_error($curl);
curl_close($curl);

// if ($err) {
//     $this->verified = false;
//     return false;
// } 
// else 
// {
    $response = json_decode($response);
 
    $transStatus = $response->data->status;
    $transDescr = $response->data->message;
       
    $paymentStatus = $chargeAmount = $chargeCurrency = "";
    if($transStatus == "success") 
    {
        
       $paymentStatus = $response->data->status;
        $chargeAmount = $response->data->amount;
        $chargeCurrency = $response->data->currency;
    }
    // print_r ($response);
    // exit;
    
// }


$response_code = (($transStatus == "success") && ($chargeAmount == $amount2)  && ($chargeCurrency == $currency))?"00":"11";

$response_description = (($transStatus == "success") && ($chargeAmount == $amount2)  && ($chargeCurrency == $currency))?"Successful Transaction":$transDescr;

$update_status = "";



//============ Updates Plan ================//
if(!empty($reference) && ($response_code == "00" || $response_code == "0") && ($chargeAmount == $amount2)  && ($chargeCurrency == $currency) && $status == 0){

    $updateTransactiopnLog = mysqli_query($conn, "UPDATE transaction_log SET response_code = '$response_code', response_desc = '$response_description', status = 1, date_time = '$date_time', paystack_transaction_ref = '$transaction_id' WHERE id = '$log_id'");

    $updateProduct_order = mysqli_query($conn, "UPDATE product_order SET status = 'Confirmed' pay_status = '1' WHERE ref = '$reference'"); 

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


     $sql_enter = "INSERT INTO payments ".
     "(email, amount, reference, plan) ".
     "VALUES ".
     "('$email', '$amount', '$ref', '$plan')";

     $enter_data = mysqli_query($conn, $sql_enter);
     if (!$enter_data) {
         die('Could not enter data: ' . $conn->error);
     }

     if ($update_tra_log_paypal) {
        $initials = $name;
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
    
}else if(!empty($reference) && ($response_code == "00" || $response_code == "0") && ($chargeAmount == $amount2)  && ($chargeCurrency == $currency) && $status == 1){
    $update_status = "Account Already Updated";
}else if(!empty($reference) && (($response_code != "00" && $response_code != "0") || $chargeAmount != $amount2  || $chargeCurrency != $currency) && $status == 0){

    

}
///////////////////////////////////////////////////////////////////////


$message = "<table class=\"table table-striped table-hover\">
<tr><th style=\"width:160px;\">Description:</th><td>" . $description . "</td></tr>
<tr><th>Total Amount:</th><td>NGN" . formatNumber($amount) . "</td></tr>
<tr><th>Transaction Reference ID:</th><td>" . $merchant_ref . "</td></tr>
<tr><th>Status Code:</th><td>" . $response_code . "</td></tr>
<tr><th>Status Description:</th><td>" . $response_description . "</td></tr>
<tr><th>Update Status:</th><td>";
$message .= (!empty($update_status))?$update_status:"Not Available";
$message .= "</td></tr>
</table>";
?>

    <style>
        <!--
        div table thead tr th, div table tr th, div table tbody tr td, div table tr td{
            text-align:left !important;
        }
        -->
    </style>
<div class="az-content-body">
       
        <div class="col-lg-12 mg-t-20">
            <div class="card card-table-two">
                <h3 class="card-title">Paystack Payment Response</h3>
    <br />
    <div>

        <?php echo $message; ?>

    </div>

    <?php $users = "users/new-index"; ?>
            <div class="row">
            <div class="col-lg-6">
            <div class="bottom-edit text-left">
                <button class="btn btn-danger btn-rounded" onClick="window.location.reload();"> <i class="typcn typcn-refresh"></i> Refresh Payment</button>
            </div>
            </div>
            <div class="col-lg-6">
            <div class="bottom-edit text-right">
                <a href="/"
                   class="btn btn-danger btn-rounded">Back to Dashboard
                </a>
            </div>
            </div>
        </div>
            </div>
            
        </div>
    
        <!--<div>-->
            
            <!--<a href="<?php echo $users; ?>" class="btn gen-btn float-right"><i class="fa fa-dashboard" aria-hidden="true"></i> Back to Dashboard</a>-->
            
        <!--</div>-->
    
        <!--<script src="new-js/general-form.js"></script>-->
    
        </div>
