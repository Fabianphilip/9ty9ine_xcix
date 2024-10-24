 
  <?php
    include 'includes/connect.php';
    include 'includes/functions.php';
    $country = get_input($conn, 'country');
    $category = get_input($conn, 'category');
    $quantityChange = get_input($conn, 'quantityChange');
    $removefromcart = get_input($conn, 'removefromcart');
    $addtocart = get_input($conn, 'addtocart');
    $productId = get_input($conn, 'productId');
    $checkCart = get_input($conn, 'checkCart');
    $checkCartTotal = get_input($conn, 'checkCartTotal');
    $cartsidebar = get_input($conn, 'cartsidebar');
    $qty = get_input($conn, 'qty');
    $email = get_input($conn, 'email');
    $sessionId = get_input($conn, 'sessionId');
    $searchquery = get_input($conn, 'searchquery');
    // $sessionId = $_SESSION['id'];
    if(!empty($email)){
        $userCart = $email;
    }else{
      $userCart = $sessionId;
    }
    
    if(!empty($searchquery)){
      ?><div style="height: 60px;"></div><?php
      $querySearch = mysqli_query($conn, "SELECT * FROM category  WHERE name LIKE '%$searchquery%' OR description LIKE '%searchquery%'");
      if(mysqli_num_rows($querySearch) > 0){
        ?><h5 class="mx-2">Categories</h5><?php
        ?><div class="row mx-2"><?php
        while($rowSearch = mysqli_fetch_array($querySearch)){
          ?>
            <div class="col-auto">
              <div class=""><img src="category_images/<?php echo $rowSearch['image'] ?>" style="width: 150px;"></div>
              <div class="">
                <?php
                  $highlightedWord = preg_replace("/($searchquery)/i", "<strong>$1</strong>", $rowSearch['name']);
                  echo $highlightedWord;
                ?>
                </div>
              <hr>
            </div>
          <?php
        }
        ?></div><?php
      }

      $querySearch = mysqli_query($conn, "SELECT p.id AS id, i.image AS image, p.name AS name  FROM product p JOIN product_images i ON i.token = p.image_token WHERE name LIKE '%$searchquery%' OR description LIKE '%searchquery%' OR search_keyword LIKE '%$searchquery%' OR keypoint LIKE '%$searchquery%' OR slug LIKE '%searchquery%'");
      if(mysqli_num_rows($querySearch) > 0){
        ?><h5 class="mx-2">Products</h5><?php
        while($rowSearch = mysqli_fetch_array($querySearch)){
          ?>
            <div class="row m-2 py-2" style="border: 2px solid silver;">
              <div class="col-auto" style="display: none;"><img src="product_images/<?php echo $rowSearch['image'] ?>" style="width: 20px;"></div>
              <div class="col-auto">
                <?php
                  $highlightedWord = preg_replace("/($searchquery)/i", "<strong>$1</strong>", $rowSearch['name']);
                  echo $highlightedWord;
                ?>    
              </div>
            </div>
          <?php
        }
      }
    }

    if(!empty($cartsidebar)){
      $queryProduct = mysqli_query($conn, "SELECT p.image_token AS image_token, p.id AS id, p.price AS price, c.price AS cartprice, p.name AS name, i.image AS image, c.qty AS qty FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token WHERE c.user = '$userCart' AND c.status = '1'");
      if(mysqli_num_rows($queryProduct) > 0){
        while($rowProduct = mysqli_fetch_array($queryProduct)){
          ?>
          <li id="sideccart_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>">
            <a href="javascript:void(0)" class="remove" onclick="removefromcartsidebar('product_<?php echo $rowProduct['id'] ?>_0')">X</a>
            <div class="pro-img">
                <img width="180" height="228" src="product_images/<?php echo $rowProduct['image']; ?>" alt="">
            </div>
            <div class="cart-poro-details">
                <h2>
                    <a href="details?id=<?php echo $rowProduct['id']; ?>"><?php echo $rowProduct['name']; ?></a>
                </h2>
                <div class="star-rating">
                    <?php
                        for ($i = 1; $i <= $rowProduct['rating']; $i++) {
                            echo "<i class='fa fa-star'></i>";
                        }
                    ?>
                </div>
                <div class="quantity">
                    <?php echo $rowProduct['qty'] ?>x<span>₦<?php echo number_format($rowProduct['price'],2); ?></span>
                </div>
                <div>
                  <input type="number" class="w_hhLG w_8nsR pointer flex items-center justify-center shadow-1" style="padding:5px 20px; width: 100px;" value="<?php echo $rowProduct['qty'] ?>" id="sidecartproduct_qty<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>" onkeyup="sidecart_quantityChange('product_<?php echo $rowProduct['id'] ?>', this.id)" onchange="sidecart_quantityChange('product_<?php echo $rowProduct['id'] ?>_<?php echo $rowProduct['image_token'] ?>', this.id)">
                </div>
            </div>
        </li>
          <?php
            }
          }else{
          echo "";
        }
    }

    if(!empty($checkCart) && !empty($productId)){
      if(!empty($email)){
        $checkCart = mysqli_query($conn, "SELECT * FROM cart WHERE user = '$email' AND status = '1'");
        echo mysqli_num_rows($checkCart);
      }else{
        $checkCart = mysqli_query($conn, "SELECT * FROM cart WHERE user = '$sessionId' AND status = '1'");
        echo mysqli_num_rows($checkCart);
      }
    }


    if(!empty($checkCartTotal) && !empty($productId)){
      if(!empty($email)){
        $queryProduct = mysqli_query($conn, "SELECT SUM(price) AS totalPrice FROM cart WHERE user = '$email' AND status = '1'");
        if(mysqli_num_rows($queryProduct) > 0){
          $rowProduct = mysqli_fetch_array($queryProduct);
          echo number_format($rowProduct['totalPrice'],2); 
        }else{
          echo number_format(0, 2);
        }
      }else{
        $queryProduct = mysqli_query($conn, "SELECT SUM(price) AS totalPrice FROM cart WHERE user = '$sessionId' AND status = '1'");
        if(mysqli_num_rows($queryProduct) > 0){
          $rowProduct = mysqli_fetch_array($queryProduct);
          echo number_format($rowProduct['totalPrice'],2); 
        }else{
          echo number_format(0, 2);
        }
      }
    }


    if(!empty($productId) && !empty($quantityChange) && !empty($qty)){
      $getProduct = mysqli_query($conn, "SELECT * FROM product WHERE id = '$productId'");
      $rowProduct = mysqli_fetch_array($getProduct);
      $price = $rowProduct['price'];
      $cartPrice = $price * $qty;
      if(!empty($email)){
        $checkCart = mysqli_query($conn, "SELECT * FROM cart WHERE user = '$email' AND product = '$productId' AND status = '1'");
        if(mysqli_num_rows($checkCart) > 0){
          $updateQty = mysqli_query($conn, "UPDATE cart SET qty = '$qty', price = '$cartPrice' WHERE user = '$email' AND product = '$productId' AND status = '1'");
          if($updateQty){
            echo 1;
          }
        }
      }else{
        $checkCart = mysqli_query($conn, "SELECT * FROM cart WHERE user = '$sessionId' AND product = '$productId' AND status = '1'");
        if(mysqli_num_rows($checkCart) > 0){
          $updateQty = mysqli_query($conn, "UPDATE cart SET qty = '$qty', price = '$cartPrice' WHERE user = '$sessionId' AND product = '$productId' AND status = '1'");
        }
        if($updateQty){
          echo 1;
        }
      }
    }

    if(!empty($productId) && !empty($addtocart) && !empty($qty)){
      $getProduct = mysqli_query($conn, "SELECT * FROM product WHERE id = '$productId'");
      $rowProduct = mysqli_fetch_array($getProduct);
      $price = $rowProduct['price'];
      $cartPrice = $price * $qty;
      if(!empty($email)){
        $checkCart = mysqli_query($conn, "SELECT * FROM cart WHERE user = '$email' AND product = '$productId' AND status = '1'");
        if(mysqli_num_rows($checkCart) == 0){
          $insertCart = mysqli_query($conn, "INSERT INTO cart (user, product, qty, price, status) VALUES ('$email', '$productId', '$qty', '$cartPrice', '1')");
          if($insertCart){
            echo 1;
          }else{
            echo 2;
          }
        }
      }else{
        $checkCart = mysqli_query($conn, "SELECT * FROM cart WHERE user = '$sessionId' AND product = '$productId' AND status = '1'");
        if(mysqli_num_rows($checkCart) == 0){
          $insertCart = mysqli_query($conn, "INSERT INTO cart (user, product, qty, price, status) VALUES ('$sessionId', '$productId', '$qty', '$cartPrice', '1')");
          if($insertCart){
            echo 1;
          }else{
            echo 2;
          }
        }
      }
    }


    if(!empty($productId) && !empty($removefromcart)){
      if(!empty($email)){
        $removefromcart = mysqli_query($conn, "DELETE FROM cart WHERE user = '$email' AND product = '$productId'");
        if($removefromcart){
          echo 1;
        }else{
          echo 2;
        }
      }else{
        $removefromcart = mysqli_query($conn, "DELETE FROM cart WHERE user = '$sessionId' AND product = '$productId'");
        if($removefromcart){
          echo 1;
        }else{
          echo 2;
        }
      }
    }

    if(!empty($country)){
    ?>
      <label>State<span class="required">*</span></label>  
        <select name="state">
          <?php
          $query_c = mysqli_query($conn, "SELECT * FROM countries_ WHERE country_name='$country'");
          $row_c = mysqli_fetch_array($query_c);
          $country_id = $row_c['country_id'];
          $query_states = mysqli_query($conn, "SELECT * FROM states WHERE country_id='$country_id'");
          while ($row_s = mysqli_fetch_array($query_states)) {
            ?>
            <option value="<?php echo $row_s['state_name'] ?>"><?php echo $row_s['state_name'] ?></option>
            <?php
          }
    
          ?>
        </select>
    <?php
  }

  if(!empty($category)){
    ?>
        <p class="m-0">Sub Category</p>
        <select name="sub_category" class="form-select">
          <option>** choose Sub category **</option>
          <?php
          $query_sub_category = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id='$category'");
          while ($row_s = mysqli_fetch_array($query_sub_category)) {
            ?>
            <option value="<?php echo $row_s['id'] ?>"><?php echo $row_s['name'] ?></option>
            <?php
          }
    
          ?>
        </select>
    <?php
  }



  ?>