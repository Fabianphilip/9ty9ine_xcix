<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>
<?php
	$remove = get_input($conn, 'remove');
	$success = get_input($conn, 'success');
	$error = get_input($conn, 'error');

	if(!empty($remove)){
		$act = mysqli_query($conn, "DELETE FROM wishlist WHERE id = '$remove'");
		if($act){
			?> <script type="text/javascript">window.location = 'wishlist?success=1'</script> <?php
		}else{
			?> <script type="text/javascript">window.location = 'wishlist?error=1'</script> <?php
		}
	}
?>

<?php
	if(!empty($success)){
		?><div class="row"><div class="alert alert-success col-md-12">success</div></div><?php
	}
?>

<?php
	if(!empty($error)){
		?><div class="row"><div class="alert alert-danger col-md-12">something went wrong</div></div><?php
	}
?>
	<div class="col-md-12">
                
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h5>Dashboard - <small>Wishlist</small> </h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 p-3 bg-white border-radius">
                <div class="row">
                    <?php
                    	$queryWishlist = mysqli_query($conn, "SELECT p.id AS product_id, w.id AS wishlist_id, p.image_token AS token, p.discount AS discount, b.name AS brand_name, p.brand AS brand_id, p.price AS price, p.name AS name, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token) AS images, p.image_token AS image_token FROM wishlist w JOIN product p ON p.id = w.product_id JOIN product_images pi ON p.image_token = pi.token JOIN brand b ON p.brand = b.id WHERE w.email = '$email'");
                    	if(mysqli_num_rows($queryWishlist) > 0){
                    		while($rowWishlist = mysqli_fetch_array($queryWishlist)){
                    			$images = explode(',', $rowOrders['images']);
                                $token = $rowWishlist['token'];
                    ?>
                        <div class="col-md-6 mb-2">
                            <div class="card p-4">
                                <a href="../details?id=<?php echo $rowWishlist['product_id']; ?>" style="color: black; text-decoration: none;">
                                <div class="d-flex mt-2 p-0 border-top">
                                    <div class="item-image">
                                        <img src="../product_images/<?php echo $images[0]; ?>" alt="" width="100px">
                                    </div>
                                    <div class="product-details ml-2">
                                        <span class="product-brand-name">
                                            <strong><?php echo $rowWishlist['brand_name'] ?></strong>
                                        </span>
                                        <h6 class="mt-3 m-0"><?php echo $rowWishlist['name'] ?></h6>
                                        <p class="rate" app-rating="0"></p>
                                        <div class="d-flex pt-2"><span>
                                            <?php 
                                                if($rowWishlist['discount'] > 1){
                                                  $slashed = $rowWishlist['discount'] * $rowWishlist['price'];
                                                  $slashed = $slashed / 100;
                                                  $slashed = $rowWishlist['price'] + $slashed;
                                                  echo '₦'.number_format($slashed, 2);
                                                }
                                            ?>
                                            </span>
                                            <span class="new-price"><?php if($rowWishlist['discount'] > 1){
                                              $slashed = $rowWishlist['discount'] * $rowWishlist['price'];
                                              $slashed = $slashed / 100;
                                              $slashed = $rowWishlist['price'] - $slashed;
                                              echo number_format($slashed, 2);
                                            }else{ echo '₦'.number_format($rowWishlist['price'], 2); } ?></span>
                                        </div>
                                        <div class="sales-var-colors d-flex p-1">

                                            <?php 
                                                $queryVariation = mysqli_query($conn, "SELECT * FROM variations WHERE token = '$token'");
                                                if(mysqli_num_rows($queryVariation)){
                                                    while($rowVariations = mysqli_fetch_array($queryVariation)){
                                                        $option_value = explode(',', $rowVariations['option_value']);
                                                        ?>
                                                            <div style="margin-right: 40px;">
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
                                        </div>
                                    </div>
                                </div>
                                </a>
                                <div class="mt-1 border-top text-center">
                                    <a href="wishlist?remove=<?php echo $rowWishlist['wishlist_id']; ?>" data-wishlist-remover="true" class="text-danger">
                                        <small><i class="flaticon2-trash"></i> Remove</small> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } }else{ ?>
                    	<div class="text-center mt-5 pt-4">
	                        <p class="m-0"><i class="icofont-heart text-primary" style="font-size: 60px;"></i></p>
	                        <p><small><strong>Hi!, <?php echo $row_user['full_name'] ?></strong> You have no item in your list.</small></p>
	                        <a href="/super-sales" class="btn btn-primary border-50 btn-sm">Get fantastic deals now</a>
	                    </div>
                    <?php } ?>
                	</div>
            </div>
        </div>

    </div>

<?php } ?>
<?php include 'footer.php'; ?>