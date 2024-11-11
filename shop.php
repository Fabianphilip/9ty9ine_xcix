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
                    <div class="product-image product_height">
                        <a href="details?id=<?php echo $rowProduct['id']; ?>">
                            <img class="primary-image product_height" alt="Special" width="540" height="692" src="product_images/<?php echo $images[0]; ?>" style="object-fit: cover; border: 10px solid white">
                            <img class="secondary-image product_height" alt="Special" width="540" height="692" src="product_images/<?php echo $images[1]; ?>" style="object-fit: cover; border: 10px solid white">
                        </a>
                        <div class="category-action-buttons">
                            <div class="row">
                                <div class="col-6">
                                    <div class="category">
                                        <a href="details?id=<?php echo $rowProduct['id']; ?>"><?php echo $rowProduct['category_name'] ?></a>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="action-button">
                                        <ul>
                                            <li>
                                                <a href="details?id=<?php echo $rowProduct['id']; ?>" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="pe-7s-search"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" title="Add to Wishlist"><i class="pe-7s-like"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" title="Add to Compare"><i class="pe-7s-repeat"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="cart-button" data-bs-toggle="tooltip" title="Add to Cart"><i class="pe-7s-cart"></i></a>
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
                            <?php
                                for ($i = 1; $i <= $rowProduct['rating']; $i++) {
                                    echo "<i class='fa fa-star'></i>";
                                }
                            ?>
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
            </div>
            <?php
            }
        }else{
            echo 'no product to show';
        }
    ?>
</div>

<?php include 'footer.php'; ?>