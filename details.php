<?php include 'header.php' ?>

<?php
  	$productId = get_input($conn, 'id');
  	$queryProduct = mysqli_query($conn, "SELECT sc.id AS sub_category_id, c.id AS category_id, p.rating AS rating, p.id AS id, p.out_of_stock AS out_of_stock, p.name AS name, c.name AS category_name, sc.name AS sub_category_name, p.description AS description, p.price AS price, p.discount AS discount, p.image_token AS image_token, p.category AS category, p.keypoint AS keypoint FROM product p JOIN category c ON c.id = p.category LEFT JOIN sub_category sc ON sc.id = p.sub_category  WHERE p.id = '$productId'");
    if(mysqli_num_rows($queryProduct) > 0){
      	$rowProduct = mysqli_fetch_array($queryProduct);
      	$token = $rowProduct['image_token'];
      	$category = $rowProduct['category'];
        $category_name = $rowProduct['category_name'];
    }
?>

	<div class="page-header-area" style="background: url('assets/img/bredcrum.jpeg'); object-fit: fill; background-repeat: no-repeat; align-content: center;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title">
                            <h2><?php echo $rowProduct['name'] ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE-HEADER-AREA-END -->
        <!-- BREADCRUMB-AREA-START -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-menu">
                            <ul>
                                <li><a href="/">Home</a> | </li>
                                <li><a href="shop?category=<?php echo $rowProduct['category_id'] ?>"><?php echo $rowProduct['category_name'] ?></a> | </li>
                                <li><a href="shop?category=<?php echo $rowProduct['sub_category_id'] ?>"><?php echo $rowProduct['sub_category_name'] ?></a> | </li>
                                <li><span><?php echo $rowProduct['name'] ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCRUMB-AREA-END -->
        <div class="main-content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 col-xl-9 page-content">
                        <!-- product-over-view-tab-start -->
                        <div class="product-view-area">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="zoomWrapper">
                                        <div id="img-1" class="product-image">
                                            <?php
                                                $query_image = mysqli_query($conn, "SELECT * FROM product_images WHERE token = '$token' LIMIT 1");
                                                if(mysqli_num_rows($query_image) > 0){
                                                    $sn = 1;
                                                    while ($rowImage = mysqli_fetch_assoc($query_image)) {
                                                        ?>
                                                    <a href="#">
                                                        <img id="zoom1" width="800" height="800" src="product_images/<?php echo $rowImage['image'] ?>" data-zoom-image="product_images/<?php echo $rowImage['image'] ?>" alt="big-1">
                                                    </a>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            <span class="onsale">Sale!</span>
                                        </div>
                                        <div class="single-zoom-thumb">
                                            <ul class="bxslider" id="gallery_01">
                                                <?php
                                                    $query_image = mysqli_query($conn, "SELECT * FROM product_images WHERE token = '$token'");
                                                    if(mysqli_num_rows($query_image) > 0){
                                                        $sn = 1;
                                                        while ($rowImage = mysqli_fetch_assoc($query_image)) {
                                                            ?>
                                                            <li>
                                                                <a href="#" class="elevatezoom-gallery active" data-image="product_images/<?php echo $rowImage['image'] ?>" data-zoom-image="product_images/<?php echo $rowImage['image'] ?>"><img width="180" height="228" src="product_images/<?php echo $rowImage['image'] ?>" alt="zo-th-1" /></a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="item-content-info">
                                        <h2>
                                            <a href="#"><?php echo $rowProduct['name'] ?></a>
                                        </h2>
                                        <div class="ro-rate">
                                            <div class="star-rating">
                                                <?php
                                                    for ($i = 1; $i <= $rowProduct['rating']; $i++) {
                                                        echo "<i class='fa fa-star'></i>";
                                                    }
                                                ?>
                                            </div>
                                            <a class="review-link" href="#">
                                                <?php
                                                    $queryReview = mysqli_query($conn, "SELECT * FROM review WHERE product_id = '$productId'");
                                                ?>
                                                <span><?php if(mysqli_num_rows($queryReview)){ echo mysqli_num_rows($queryReview); }else{ echo '0'; } ?></span>
                                                 Review (s)
                                            </a>
                                        </div>
                                        <div class="product-price-meta">
                                            <div class="price">
                                                <span class="old-price">₦
                                                <?php 
                                                    if($rowProduct['discount'] > 0){
                                                      $slashed = $rowProduct['discount'] * $rowProduct['price'];
                                                      $slashed = $slashed / 100;
                                                      $slashed = $rowProduct['price'] + $slashed;
                                                      echo '₦'.number_format($slashed, 2);
                                                    }
                                                ?>
                                                </span>
                                                <span class="new-price">₦<?php if($rowProduct['discount'] > 0){
                                                  $slashed = $rowProduct['discount'] * $rowProduct['price'];
                                                  $slashed = $slashed / 100;
                                                  $slashed = $rowProduct['price'] - $slashed;
                                                  echo number_format($slashed, 2);
                                                }else{ echo number_format($rowProduct['price'], 2); } ?></span>
                                            </div>
                                            <div class="stock"> Avaiability: <?php if($rowProduct['out_of_stock'] == 'no'){ ?><span> in stock</span> <?php }else{ ?> <span style="color: red;"> out of stock </span> <?php } ?></div>
                                        </div>
                                        <div class="product-desc">
                                            <?php echo $rowProduct['description'] ?>
                                        </div>
                                        <div class="product-option">
                                            <form action="#" method="post">
                                                <table>
                                                	<?php 
                                                		$queryVariation = mysqli_query($conn, "SELECT * FROM variations WHERE token = '$token'");
                                                		if(mysqli_num_rows($queryVariation)){
                                                			while($rowVariations = mysqli_fetch_array($queryVariation)){
                                                				$option_value = explode(',', $rowVariations['option_value']);
                                                				?>
                                                				<tr>
			                                                        <td class="label-text">
			                                                            <label><?php echo $rowVariations['option_type'] ?></label>
			                                                        </td>
			                                                        <td class="value">
			                                                            <select>
			                                                                <option value="">Choose an option</option>
			                                                                <?php
			                                                                foreach($option_value AS $option_value ){
			                                                                	?><option value="<?php echo $option_value ?><"><?php echo $option_value ?></option><?php
			                                                                }
			                                                                ?>
			                                                            </select>                     
			                                                        </td>
			                                                    </tr>
                                                				<?php
                                                			}
                                                		}
                                                	?>
                                                </table>
                                                <div class="quantity-inc" id="product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" data-qty="1" style="<?php if (in_array($rowProduct['id'], $cartProduct)) { ?>display: block;<?php }else{ ?>display: none;<?php } ?>">
                                                    <label>Qty<span> *</span></label>
                                                    <div class="numbers-row">
                                                        <input type="number" value="1" style="<?php if (in_array($rowProduct['id'], $cartProduct)) { ?>display: block;<?php }else{ ?>display: none;<?php } ?>" data-qty="1" id="product_qty<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" onkeyup="quantityChange('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>', this.id)" onchange="quantityChange('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>', this.id)" name="#">
                                                        
                                                   </div>
                                                </div>
                                                <div class="product-button">
                                                    <ul>
                                                        <li><a href="javascript:void(0)" class="curt-button" id="addproduct_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" onclick="addtocart('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>')" style="<?php if (in_array($rowProduct['id'], $cartProduct)) { ?>display: none;<?php  } ?>"> Add to cart</a></li>
                                                        <li>
                                                            <a href="#"><i class="pe-7s-like"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="pe-7s-repeat"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product-over-view-tab-end -->
                        <div class="product-over-view-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="prod-tab-menu">
                                        <ul class="nav">
                                            <li class="nav-item"><button class="nav-link active" data-bs-target="#description" data-bs-toggle="tab">Description</button></li>
                                            <li class="nav-item"><button class="nav-link" data-bs-target="#tags" data-bs-toggle="tab">TAGS</button></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div id="description" class="tab-pane fade active show">
                                            <h2>Product Description</h2>
                                            <p><?php echo $rowProduct['description'] ?></p>
                                        </div>
                                        <div id="tags" class="tab-pane fade">
                                           <span class="tagged_as">Tags: 
                                           		<?php 
			                                		$keypoint = explode(',', $rowProduct['keypoint']);
			                                		foreach($keypoint AS $keypoint){
			                                			?><a href="#"><?php echo $keypoint ?></a>, <?php 
			                                		}
			                                	?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="related-product-area">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section-title">
                                        <h2>Related Products</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="product-carosul-2 nav-button-style-one owl-carousel owl-theme">
                                    <?php
	                                    $queryProduct = mysqli_query($conn, "SELECT c.name AS category_name, p.id AS id, p.price AS price, p.rating AS rating, p.discount AS discount, p.name AS name, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token LIMIT 2) AS images, p.image_token AS image_token FROM product p JOIN product_images i ON i.token  = p.image_token JOIN category c ON c.id = p.category WHERE c.name LIKE '%$category_name%' GROUP BY p.id ");
	                                    if(mysqli_num_rows($queryProduct) > 0){
	                                        while($rowProduct = mysqli_fetch_array($queryProduct)){
	                                            $images = explode(',', $rowProduct['images']);
	                                    ?>
	                                    <div class="single-product">
	                                        <div class="product-image">
	                                            <a href="#">
	                                                <?php if(!empty($images[0])){ ?><img class="primary-image" alt="Special" width="540" height="692" src="product_images/<?php echo $images[0]; ?>"><?php } ?>
                                                        <?php if(!empty($images[1])){ ?><img class="secondary-image" alt="Special" width="540" height="692" src="product_images/<?php echo $images[1]; ?>"><?php } ?>
	                                            </a>
	                                            <span class="onsale">Sale!</span>
	                                            <div class="category-action-buttons">
	                                                <div class="row">
	                                                    <div class="col-6">
	                                                        <div class="category">
	                                                            <a href="#"><?php echo $rowProduct['category_name'] ?></a>
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-6">
	                                                        <div class="action-button">
	                                                            <ul>
	                                                                <li>
	                                                                    <a href="#" title="Quick View" data-bs-target="#productModal" data-bs-toggle="modal"><i class="pe-7s-search"></i></a>
	                                                                </li>
	                                                                <li>
	                                                                    <a title="" data-bs-toggle="tooltip" href="#" data-original-title="Add to Wishlist"><i class="pe-7s-like"></i></a>
	                                                                </li>
	                                                                <li>
	                                                                    <a title="" data-bs-toggle="tooltip" href="#" data-original-title="Add to Compare"><i class="pe-7s-repeat"></i></a>
	                                                                </li>
	                                                                <li>
	                                                                    <a title="" data-bs-toggle="tooltip" class="cart-button" href="#" data-original-title="Add to Cart"><i class="pe-7s-cart"></i></a>
	                                                                </li>
	                                                            </ul>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="product-info">
	                                            <div class="product-title">
	                                                <a href="#"><?php echo $rowProduct['name'] ?></a>
	                                            </div>
	                                            <div class="price-rating">
	                                                <div class="star-rating">
	                                                    <i class="fa fa-star"></i>
	                                                    <i class="fa fa-star"></i>
	                                                    <i class="fa fa-star"></i>
	                                                    <i class="fa fa-star"></i>
	                                                </div>
	                                                <div class="price">
	                                                    <span class="old-price">
                                                        <?php 
                                                            if($rowProduct['discount'] > 1){
                                                              $slashed = $rowProduct['discount'] * $rowProduct['price'];
                                                              $slashed = $slashed / 100;
                                                              $slashed = $rowProduct['price'] + $slashed;
                                                              echo '₦'.number_format($slashed, 2);
                                                            }
                                                        ?>
                                                        </span>
                                                        <span class="new-price"><?php if($rowProduct['discount'] > 1){
                                                          $slashed = $rowProduct['discount'] * $rowProduct['price'];
                                                          $slashed = $slashed / 100;
                                                          $slashed = $rowProduct['price'] - $slashed;
                                                          echo number_format($slashed, 2);
                                                        }else{ echo '₦'.number_format($rowProduct['price'], 2); } ?></span>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <?php
		                                }
		                            }
	                             ?>
                                </div>
                            </div>
                        </div>
                        <!-- related-product-area-end -->

                    </div>
                    <div class="col-12 col-md-4 col-xl-3 sidebar-area">
                        <!-- special-product-area-start -->
                        <div class="special-product-area">
                            <div class="section-title">
                                <h2>Upsell Products</h2>
                            </div>
                            
                            <div class="special-product">
                                <?php
	                            	$queryProduct = mysqli_query($conn, "SELECT p.id AS id, p.price AS price, p.feature AS feature, p.name AS name, i.image AS image, p.rating AS rating, p.discount AS discount, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token LIMIT 2) AS images FROM product p JOIN product_images i ON i.token = p.image_token WHERE p.feature LIKE '%4%' GROUP BY p.id");
						            if(mysqli_num_rows($queryProduct) > 0){
						              	while($rowProduct = mysqli_fetch_array($queryProduct)){
                                            $images = explode(',', $rowProduct['images']);
	                            	?>
	                                <div class="special-single-product">
	                                    <div class="sp-img">
	                                        <a href="#">
	                                            <img alt="" width="180" height="228" src="product_images/<?php echo $images[0]; ?>">
	                                        </a>
	                                    </div>
	                                    <div class="sp-prod-info">
	                                        <div class="product-title">
	                                            <a href="#"><?php echo $rowProduct['name']; ?></a>
	                                        </div>
	                                        <div class="price-rating">
	                                            <div class="rating">
	                                                <?php
                                                        for ($i = 1; $i <= $rowProduct['rating']; $i++) {
                                                            echo "<i class='fa fa-star'></i>";
                                                        }
                                                      ?>
	                                            </div>
	                                            <div class="price">
	                                                <span class="old-price">₦
                                                    <?php 
                                                        if(!empty($rowProduct['discount'])){
                                                            $slashed = $rowProduct['discount'] * $rowProduct['price'];
                                                            $slashed = $slashed / 100;
                                                            $slashed = $rowProduct['price'] + $slashed;
                                                            echo number_format($slashed, 2);
                                                        }
                                                    ?>
                                                    </span>
                                                    <span class="new-price">₦<?php echo number_format($rowProduct['price'], 2); ?></span>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                                <?php
		                            }
		                        }
	                            ?>
                            </div>
                        </div>
                         <!-- special-product-area-end -->
                         <div class="banner-area">
                            <div class="single-banner">
                                <a href="#">
                                    <img alt="" width="271" height="480" src="assets/img/banner/4.webp">
                                </a>
                                <div class="banner-text">
                                    <h2>SAVE</h2>
                                    <h3>MEN’S COLLECTION<span> MID SEASON SALE</span></h3>
                                </div>
                            </div>
                        </div>
                        <!-- popular-tag-area-start -->
                        <div class="populer-tag-area">
                            <div class="section-title">
                                <h2>Product Tags</h2>
                            </div>
                            <div class="tag">
                                <ul>
                                	<?php 
                                		$keypoint = explode(',', $rowProduct['keypoint']);
                                		foreach($keypoint AS $keypoint){
                                			?><li><a href="#"><?php echo $keypoint ?></a></li><?php 
                                		}
                                	?>
                                </ul>
                            </div>
                        </div>
                        <!-- popular-tag-area-end -->
                    </div>
                </div>
            </div>
        </div>

<?php include 'footer.php' ?>