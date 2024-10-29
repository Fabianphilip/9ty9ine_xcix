<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>
<?php
    $success = get_input($conn, 'success');
    $error = get_input($conn, 'error');
    if(isset($_POST['rate_save'])){
        $rating = tp_input($conn, 'rating');
        $message = tp_input($conn, 'message');
        $product_id = tp_input($conn, 'product_id');
        $user_email = tp_input($conn, 'user_email');

        $check = mysqli_query($conn, "SELECT * FROM review WHERE product_id = '$product_id' AND email = '$user_email'");
        if(mysqli_num_rows($check) == 0){
            $insert = mysqli_query($conn, "INSERT INTO review (email, product_id, message, rating) VALUES ('$user_email', '$product_id', '$message', '$rating')");
            if($insert){
                ?><script type="text/javascript">window.location = 'reviews?success=1'</script><?php
            }else{
                ?><script type="text/javascript">window.location = 'reviews?error=1'</script><?php
            }
        }else{
            $update = mysqli_query($conn, "UPDATE review SET messagee = '$message', rating = '$rating' WHERE product_id = '$product_id' AND email = '$user_email'");
            if($update){
                ?><script type="text/javascript">window.location = 'reviews?success=1'</script><?php
            }else{
                ?><script type="text/javascript">window.location = 'reviews?error=1'</script><?php
            }
        }
    }
?>
<?php
    if(!empty($success)){
        ?><div class="row"><div class="col-md-12 alert alert-success">Thank you for your review</div></div><?php
    }
    if(!empty($error)){
        ?><div class="row"><div class="col-md-12 alert alert-danger">Something went wrong</div></div><?php
    }
?>  
    <div class="col-md-12">
                
            <div class="page-title col-md-12 border-radius mt-4">
                <div class="row">
                    <div class="d-flex">
                        <div class="title">
                            <h5>Dashboard - <small>Reviews</small> </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8 bg-white mb-2 border-radius">
                            <div class="card p-4">
                                <div class="col-md-12">
                                        <div class="row">
                                        <?php  
                                            $query = mysqli_query($conn, "SELECT p.image_token AS token, po.qty AS qty, p.discount AS discount, p.price AS price, p.name AS name, po.products AS product_id, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token) AS images FROM product_order po JOIN product p ON po.products = p.id JOIN product_images pi ON p.image_token = pi.token WHERE po.email = '$email' AND po.status = 'delivered'");
                                            if(mysqli_num_rows($query) > 0){
                                                while($rowQuery = mysqli_fetch_array($query)){
                                                    $product_id = $rowQuery['product_id'];
                                                    $token = $rowQuery['token'];
                                                    $images = explode(',', $rowQuery['images']);
                                                    $queryReview = mysqli_query($conn, "SELECT * FROM review WHERE product_id = '$product_id' AND email = '$email'");
                                                    if(mysqli_num_rows($queryReview) == 0){
                                                        ?>
                                                        <div class="col-md-12 bg-white border-radius">
                                                            <div class="d-flex mt-2 p-0">
                                                                <div class="item-image">
                                                                    <img src="../product_images/<?php echo $images[0]; ?>" alt="" width="100px">
                                                                    
                                                                </div>
                                                                <div class="product-details ml-2 flex-fill">
                                                                    <div class="d-flex justify-content-between">
                                                                        <a href="../details?id=<?php echo $rowQuery['product_id'] ?>">
                                                                            <p><?php echo $rowQuery['name'] ?></p>
                                                                        </a>
                                                                        <a href="javascript:void(0)" onclick="ratethis()" class="text-primary" data-prepare-rating="<?php echo $rowQuery['product_id'] ?>"> 
                                                                            <small><b>RATE THIS ITEM</b></small>
                                                                        </a>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between">
                                                                        <div class="d-flex">
                                                                            <div class="price-details">
                                                                                <s>
                                                                                <?php 
                                                                                    if($rowQuery['discount'] > 1){
                                                                                      $slashed = $rowQuery['discount'] * $rowQuery['price'];
                                                                                      $slashed = $slashed / 100;
                                                                                      $slashed = $rowQuery['price'] + $slashed;
                                                                                      echo '₦'.number_format($slashed, 2);
                                                                                    }
                                                                                ?>
                                                                                </s><br>
                                                                                <span class="new-price"><?php if($rowQuery['discount'] > 1){
                                                                                  $slashed = $rowQuery['discount'] * $rowQuery['price'];
                                                                                  $slashed = $slashed / 100;
                                                                                  $slashed = $rowQuery['price'] - $slashed;
                                                                                  echo '₦'.number_format($slashed, 2);
                                                                                }else{ echo '₦'.number_format($rowQuery['price'], 2); } ?></span>
                                                                            </div>
                                                                            <span class="mx-4">
                                                                            <?php 
                                                                                $queryVariation = mysqli_query($conn, "SELECT * FROM variations WHERE token = '$token'");
                                                                                if(mysqli_num_rows($queryVariation)){
                                                                                    while($rowVariations = mysqli_fetch_array($queryVariation)){
                                                                                        $option_value = explode(',', $rowVariations['option_value']);
                                                                                        ?>
                                                                                        <div>
                                                                                            <div class="label-text">
                                                                                                <label><strong><?php echo $rowVariations['option_type'] ?></strong></label>
                                                                                            </div>
                                                                                            <div class="value">
                                                                                                <?php
                                                                                                    foreach($option_value AS $option_value ){
                                                                                                         echo $option_value.","; 
                                                                                                    }
                                                                                                ?>                   
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            </span>
                                                                            <p class="mt-0 mb-1 ml-3"><small><b>Qty:</b> <?php echo $rowQuery['qty'] ?></small></p>
                                                                        </div>
                                                                        <div>
                                                                            <form method="POST" action="">
                                                                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                                                <input type="hidden" name="user_email" value="<?php echo $email; ?>">
                                                                                <select class="form-select" name="rating">
                                                                                    <option value="5">★★★★★</option>
                                                                                    <option value="4">★★★★</option>
                                                                                    <option value="3">★★★</option>
                                                                                    <option value="2">★★</option>
                                                                                    <option value="1">★</option>
                                                                                    <option value="0"></option>
                                                                                </select>
                                                                                <div class="my-3">
                                                                                    <textarea class="form-control" rows="4" placeholder="leave a review" name="message"></textarea>
                                                                                </div>
                                                                                <input type="submit" name="rate_save" class="btn btn-primary" value="Save">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <div class="text-center mt-5 pt-4">
                                                            <p class="m-0"><i class="mdi mdi-message-draw text-primary" style="font-size: 60px;"></i></p>
                                                            <p> 
                                                                <strong>Hi!, <?php echo $row_user['full_name'] ?></strong> You have no pending reviews for now. <br>
                                                                You're reviews will help improve user's experience on how they shop on AprilVines.
                                                            </p>
                                                            <a href="../shop" class="btn btn-primary rounded-btn btn-sm">Continue Shopping</a>
                                                        </div>

                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-4">
                                <div class="order-title mb-3">
                                    <h5>Your Recent Reviews</h5>
                                </div>
                                <?php
                                    $query = mysqli_query($conn, "SELECT po.qty AS qty, p.discount AS discount, p.price AS price, p.name AS name, po.products AS product_id, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token LIMIT 1) AS images FROM product_order po JOIN product p ON po.products = p.id JOIN product_images pi ON p.image_token = pi.token WHERE po.email = '$email' AND po.status = 'delivered'");
                                    if(mysqli_num_rows($query) > 0){
                                        while($rowQuery = mysqli_fetch_array($query)){
                                            $product_id = $rowQuery['product_id'];
                                            $images = explode(',', $rowQuery['images']);
                                            $queryReview = mysqli_query($conn, "SELECT * FROM review WHERE product_id = '$product_id' AND email = '$email'");
                                            if(mysqli_num_rows($queryReview) > 0){
                                                while($rowReview = mysqli_fetch_array($queryReview)){
                                                ?>
                                                <div class="review">
                                                    <div class="d-flex">
                                                        <div class="rv-item">
                                                            <a href="../details?id=<?php echo $rowQuery['product_id'] ?>">
                                                                <img src="../product_images/<?php echo $images[0]; ?>" alt="" width="70px">
                                                            </a>
                                                        </div>
                                                        <div class="">
                                                            <p class="rate ml-2" app-rating="0"></p>
                                                            <p class="ml-2 mb-0"><small class="text-bold"><?php echo $rowReview['message']; ?></small></p>
                                                            <p class="mt-0 ml-2"><small class="text-dark"><?php echo $rowReview['dated'] ?></small></p>
                                                            <p class="mt-0 ml-2">
                                                                <small class="text-dark">
                                                                    <?php
                                                                        for ($i = 1; $i <= $rowReview['rating']; $i++) {
                                                                            echo "<i class='fa fa-star' style='font-size: 11px;'></i>";
                                                                        } 
                                                                    ?>   
                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                            }else{
                                                ?>
                                                <div class="text-center">
                                                    <p>
                                                        You have not review any item yet.<br>
                                                        You're reviews will help improve user's experience on how they shop on AprilVines.
                                                    </p>
                                                    <a href="../shop" class="btn btn-primary rounded-btn btn-sm">Shop now</a>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php } ?>
<?php include 'footer.php'; ?>