<?php include 'header.php'; ?>

<?php
    $category = get_input($conn, 'category');
    $feature = get_input($conn, 'feature');

    $where = 'WHERE p.id > 0';
    if(!empty($category)){ 
        $where .= " AND c.name = '$category'"; 
        if($category == 'unisex'){ $where .= " OR (c.name = 'men' OR c.name = 'women')"; }
        if($category == 'men'){ $where .= " OR c.name = 'unisex'"; }
        if($category == 'women'){ $where .= " OR c.name = 'unisex'"; }
    }
    if(!empty($feature)){ $where .= " AND f.name = '$feature'"; }
?>


<div class="row my-5">
    <?php
        $queryProduct = mysqli_query($conn, "SELECT c.name AS category_name, p.id AS id, p.price AS price, p.rating AS rating, p.discount AS discount, p.name AS name, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token LIMIT 2) AS images, p.image_token AS image_token FROM product p JOIN product_images i ON i.token  = p.image_token JOIN category c ON c.id = p.category JOIN feature f ON FIND_IN_SET(f.id, p.feature) $where GROUP BY p.id ");
        if(mysqli_num_rows($queryProduct) > 0){
            while($rowProduct = mysqli_fetch_array($queryProduct)){
                $images = explode(',', $rowProduct['images']);
        ?>
            <div class="col-6 col-lg-3 col-sm-6 col-md-6">
                <div class="single-product">
                    <div class="product_height" style="">
                        <center>
                        <a href="details?id=<?php echo $rowProduct['id']; ?>">
                            <?php if(!empty($images[0])){ ?><img class="primary-image product_height" alt="Special" width="200" height="200" src="product_images/<?php echo $images[0]; ?>" style="object-fit: cover; "><?php } ?>
                            <?php if(!empty($images[1])){ ?><img class="secondary-image product_height" style="display: none" alt="Special" width="540" height="692" src="product_images/<?php echo $images[1]; ?>" style="object-fit: cover;"><?php } ?>
                        </a>
                        <div class="category-action-buttons d-flex justify-content-center">
                            <button type="button" id="addproduct_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" onclick="addtocart('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>')" style="<?php if (in_array($rowProduct['id'], $cartProduct)) { ?>display: none;<?php  } ?> padding: 10px; background-color: black; color: white;">
                              <i class="ld ld-Plus" title="add to cart"></i>
                              <span class="mr2">Add To Cart</span>
                            </button>
                            <div class="" id="product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" data-qty="1" style="<?php if (in_array($rowProduct['id'], $cartProduct)) { ?>display: block;<?php }else{ ?>display: none;<?php } ?>">
                                <input type="number" style="width: 100px; <?php if (in_array($rowProduct['id'], $cartProduct)) { ?>display: block;<?php }else{ ?>display: none;<?php } ?>" value="1" id="product_qty<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" onkeyup="quantityChange('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>', this.id)" onchange="quantityChange('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>', this.id)">
                            </div>
                            <button id="removeproduct_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" onclick="removefromcart('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>')" class="w_hhLG w_8nsR w_jDfj pointer bn sans-serif b ph2 flex items-center justify-center w-auto shadow-1" style="background: #68696b; display: none"><i class="ld ld-Minus"></i><span class="mr2">Remove</span></button>
                        </div>
                        </center>
                    </div>
                    <div class="product-info">
                        <div class="product-title">
                            <a href="details?id=<?php echo $rowProduct['id']; ?>"><?php echo $rowProduct['name'] ?></a>
                        </div>
                        <div class="price-rating">
                            <div class="" style="color: grey; font-weight: 900;">
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
                            <div class="">
                            <?php
                                for ($i = 1; $i <= $rowProduct['rating']; $i++) {
                                    echo "<i class='fa fa-star'></i>";
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
        }else{
            echo 'no product to show';
        }
    ?>
</div>

<?php include 'footer.php'; ?>