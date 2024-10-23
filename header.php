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
    
?>
<!doctype html>
<html class="no-js" lang="en">
    
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Home 5 || Raymond</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="assets/img/favicon.webp" />
	<link rel="preconnect" href="assets/fonts.googleapis.com/index.html">
	<link rel="preconnect" href="assets/fonts.gstatic.com/index.html" crossorigin>
	<link href="assets/fonts.googleapis.com/css24895.css?family=Monda:wght@400;700&amp;family=Oswald:wght@300;400;700&amp;family=Playfair+Display:ital,wght@0,400;1,700&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
        <link rel="stylesheet" href="assets/css/meanmenu.min.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/css/fancybox/jquery.fancybox.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/pe-icon-7-stroke.css">
        <link rel="stylesheet" href="assets/custom-slider/css/nivo-slider.css" type="text/css" />
        <link rel="stylesheet" href="assets/custom-slider/css/preview.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
    </head>
    <body>

        <!-- HEADER AREA START -->
        <header>
            <!-- HEADER-TOP START -->
            <div class="header-top-ber hide-show">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="top-menu">
                                <ul>
                                    <li><a href="index.html"><img width="80" src="assets/img/9ty9inelogo.png" alt="Logo" style="width: 50px;"></a></li>
                                    <li><a href="my-account">My Account</a></li>
                                    <li><a href="wishlist">Wishlist</a></li>
                                    <li><a href="checkout">Checkout</a></li>
                                    <li><a href="login">Login</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 d-none d-md-block m-0 p-0">
                            <div class="header-right">

                                <div class="search-box-area">

                                    <div class="headerFormRelative" style="position: relative;">
                                        <input type="search" class="headerFormInput" style="z-index: 20; width: 400px;" name="search" id="search" onkeyup="searchCheck()" placeholder="Search everything" value="">
                                        <button aria-label="Search icon" class="absolute bn br-100 hover-bg-navy search-icon-redesigned-v2" style="cursor:pointer">
                                            <i class="ld ld-Search absolute" style="font-size:1rem;vertical-align:-0.175em;top:50%;left:50%;transform:translate(-50%, -50%);width:1rem;height:1rem;box-sizing:content-box"></i>
                                        </button>
                                        <div id="resultBox" style="position: absolute; top: 100%; left: 0; width: 100%; background-color: white; border: 1px solid #ddd; z-index: 19; margin-top: -52px; display: none;">
                                        </div>
                                    </div>

                                    <div class="header-menu-item-icon" style="display: none;">
                                       <a href="#" class="icon-search m-0 p-0">
                                            <span>Search</span>
                                            <i class="fa animated fa-search search-icon fa-flip-horizontal"></i>
                                        </a>
                                    </div>
                                     <div class="search-form">
                                        <form action="#" method="post">
                                            <input type="text" placeholder="Search here...">
                                            <a title="Close" class="close-icon" href="#">X</a>
                                        </form>
                                    </div>
                                </div>
                                <div class="user-menu-area">
                                    <div class="header-menu-item-icon">
                                        <a href="#" class="user-icon m-0 p-0">
                                            <i class="fa animated fa-gear"></i>
                                        </a>
                                        <div class="user-menu">
                                            <h3>ACCOUNT</h3>
                                            <ul>
                                                <li>
                                                    <a href="users/dashboard"><i class="fa fa-fw fa-user"></i>My Account</a>
                                                </li>
                                                <li>
                                                    <a href="checkout"><i class="fa fa-fw fa-usd"></i>Checkout</a>
                                                </li>
                                                <li>
                                                    <a href="login"><i class="fa fa-fw fa-unlock-alt"></i>Login</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mini-cart-area">
                                    <div class="header-menu-item-icon m-0 p-0">
                                        <a href="#" class="icon-cart m-0 p-0">
                                            <i class="fa animated fa-shopping-cart"></i>
                                            <span class="cart-total"><span id="cartSpan"><?php echo $countCart ?></span> Items | ₦<span id="cartSpanTotal"><?php echo number_format($totalPrice,2) ?></span></span>
                                        </a>
                                        <div class="mini-cart">
                                            <ul id="cardsidebar">
                                                <?php
                                                    $queryProduct = mysqli_query($conn, "SELECT p.id AS id, p.price AS price, c.price AS cartprice, p.name AS name, i.image AS image, c.qty AS qty, p.image_token AS image_token FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token WHERE c.user = '$userCart' AND c.status = '1'");
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
                                                    }
                                                ?>
                                            </ul>
                                            <p class="total" style="display: none;">
                                                <strong>Total:</strong>
                                                <span class="total-price"></span>
                                            </p>
                                            <p class="buttons">
                                                <a href="">Go To Cart</a>
                                                <a href="checkout">Check Out</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- HEADER-TOP END -->
			<div class="header-area header-two hm-5" id="sticker">
                <div class="container">
                    <div class="row">
                        <!-- LOGO AREA START -->
                        <div class="col-lg-2 col-md-6">
                            <div class="logo">
                                <a href="index.html">
                                    <img width="144" height="60" src="assets/img/9ty9inelogo.png" alt="Logo">
                                </a>
                            </div>
                        </div>
                        <!-- LOGO AREA END -->
                        <!-- MAIN MENU AREA START -->
                        <div class="col-lg-7 d-none d-lg-block">
                            <div class="mainmenu">
                                <nav>
                                    <ul>
                                        <li class="active">
											<a href="index.html">Home</a>
                                            <ul class="dropdown">
                                                <li><a href="index-2.html">Home Two</a></li>
                                                <li><a href="index-3.html">Home Three</a></li>
                                                <li><a href="index-4.html">Home Four</a></li>
                                                <li><a href="index-5.html">Home Five</a></li>
                                                <li><a href="index-6.html">Home Six</a></li>
                                                <li><a href="index-7.html">Home Seven</a></li>
                                                <li><a href="index-8.html">Home Eight</a></li>
                                                <li><a href="index-9.html">Home Nine</a></li>
                                            </ul>
                                        </li>
                                        <li>
											<a href="#">Shop</a>
                                            <ul class="dropdown">
                                                <li><a href="shop-full-width.html">Shop Full Width</a></li>
                                                <li><a href="shop.html">Shop Left Sidebar</a></li>
                                                <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                                <li><a href="shop-2-columns.html">Shop 2 Columns</a></li>
                                                <li><a href="shop.html">Shop 3 Column</a></li>
                                                <li><a href="shop-5-columns.html">Shop 5 columns</a></li>
                                            </ul>
                                        </li>
                                        <li>
											<a href="#">Elements</a>
                                            <div class="mega-menu">
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=all">Product Category</a>
                                                    </h3>
                                                    <a href="shop?category=all">View all></a>
                                                    <?php
                                                        $queryCategories = mysqli_query($conn, "SELECT * FROM category");
                                                        if(mysqli_num_rows($queryCategories) > 0){
                                                            $sn = 1;
                                                            while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                                                                ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><?php echo $rowCategories['name'] ?></a><?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?feature=all">Featured Products</a>
                                                    </h3>
                                                    <a href="shop?category=feature">View all></a>
                                                    <?php
                                                        $queryFeatures = mysqli_query($conn, "SELECT * FROM feature");
                                                        if(mysqli_num_rows($queryFeatures) > 0){
                                                            $sn = 1;
                                                            while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                                                                ?><a href="shop?feature=<?php echo $rowFeatures['id'] ?>"><?php echo $rowFeatures['name'] ?></a><?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=men">Men</a>
                                                    </h3>
                                                    <a href="shop?category=menn">View all></a>
                                                    <?php
                                                        $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%men%'");
                                                        if(mysqli_num_rows($getCategory) > 0){
                                                            $rowCategoryy = mysqli_fetch_array($getCategory);
                                                            $categoryID = $rowCategoryy['id'];
                                                            $queryCategories = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id = '$categoryID'");
                                                            if(mysqli_num_rows($queryCategories) > 0){
                                                                $sn = 1;
                                                                while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                                                                    ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><?php echo $rowCategories['name'] ?></a><?php
                                                                }
                                                            }
                                                        }
                                                        
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=women">Women</a>
                                                    </h3>
                                                    <a href="shop?category=women">View all></a>
                                                    <?php
                                                        $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%women%'");
                                                        if(mysqli_num_rows($getCategory) > 0){
                                                            $rowCategoryy = mysqli_fetch_array($getCategory);
                                                            $categoryID = $rowCategoryy['id'];
                                                            $queryCategories = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id = '$categoryID'");
                                                            if(mysqli_num_rows($queryCategories) > 0){
                                                                $sn = 1;
                                                                while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                                                                    ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><?php echo $rowCategories['name'] ?></a><?php
                                                                }
                                                            }
                                                        }
                                                        
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=unisex">Unisex</a>
                                                    </h3>
                                                    <a href="shop?category=unisex">View all></a>
                                                    <div class="menu-img">
                                                        <?php
                                                        $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%unisex%'");
                                                        if(mysqli_num_rows($getCategory) > 0){
                                                            $rowCategoryy = mysqli_fetch_array($getCategory);
                                                            ?><img src="category_images/<?php echo $rowCategoryy['image'] ?>" alt=""><?php
                                                        }
                                                        
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <a href="#">Brands</a>
                                            <div class="mega-menu">
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=all">A-Z Brands</a>
                                                    </h3>
                                                    <?php
                                                        $queryBrands = mysqli_query($conn, "SELECT * FROM brand ORDER BY name ASC");
                                                        if(mysqli_num_rows($queryBrands) > 0){
                                                            $sn = 1;
                                                            while ($rowBrands = mysqli_fetch_array($queryBrands)) {
                                                                ?><a href="shop?category=<?php echo $rowBrands['id'] ?>"><?php echo $rowBrands['name'] ?></a><?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?feature=all">Featured Products</a>
                                                    </h3>
                                                    <?php
                                                        $queryFeatures = mysqli_query($conn, "SELECT * FROM feature");
                                                        if(mysqli_num_rows($queryFeatures) > 0){
                                                            $sn = 1;
                                                            while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                                                                ?><a href="shop?feature=<?php echo $rowFeatures['id'] ?>"><?php echo $rowFeatures['name'] ?></a><?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=men">Men</a>
                                                    </h3>
                                                    <?php
                                                        $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%men%'");
                                                        if(mysqli_num_rows($getCategory) > 0){
                                                            $rowCategoryy = mysqli_fetch_array($getCategory);
                                                            $categoryID = $rowCategoryy['id'];
                                                            $queryCategories = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id = '$categoryID'");
                                                            if(mysqli_num_rows($queryCategories) > 0){
                                                                $sn = 1;
                                                                while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                                                                    ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><?php echo $rowCategories['name'] ?></a><?php
                                                                }
                                                            }
                                                        }
                                                        
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=women">Women</a>
                                                    </h3>
                                                    <?php
                                                        $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%women%'");
                                                        if(mysqli_num_rows($getCategory) > 0){
                                                            $rowCategoryy = mysqli_fetch_array($getCategory);
                                                            $categoryID = $rowCategoryy['id'];
                                                            $queryCategories = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id = '$categoryID'");
                                                            if(mysqli_num_rows($queryCategories) > 0){
                                                                $sn = 1;
                                                                while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                                                                    ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><?php echo $rowCategories['name'] ?></a><?php
                                                                }
                                                            }
                                                        }
                                                        
                                                    ?>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop?category=unisex">Unisex</a>
                                                    </h3>
                                                    <div class="menu-img">
                                                        <?php
                                                        $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%unisex%'");
                                                        if(mysqli_num_rows($getCategory) > 0){
                                                            $rowCategoryy = mysqli_fetch_array($getCategory);
                                                            ?><img src="category_images/<?php echo $rowCategoryy['image'] ?>" alt=""><?php
                                                        }
                                                        
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- MAIN MENU AREA END -->
                        <!-- HEADER RIGHT START -->
                        <div class="col-lg-3 col-md-6">
                            <div class="header-right">
                                <div class="search-box-area">
                                    <div class="header-menu-item-icon">
                                       <a href="#" class="icon-search">
                                            <i class="fa animated fa-search search-icon"></i>
                                        </a>
                                    </div>
                                    <div class="search-form">
                                        <form action="#" method="post">
                                            <input type="text" placeholder="Search here...">
                                            <a title="Close" class="close-icon" href="#">X</a>
                                        </form>
                                    </div>
                                </div>
                                <div class="user-menu-area">
                                    <div class="header-menu-item-icon">
                                        <a href="#" class="user-icon">
                                            <i class="fa animated fa-gear"></i>
                                        </a>
                                        <div class="user-menu">
                                            <h3>ACCOUNT</h3>
                                            <ul>
                                                <li>
                                                    <a href="my-account.html">
                                                        <i class="fa fa-fw fa-user"></i>My Account
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="wishlist.html">
                                                        <i class="fa fa-fw fa-heart"></i>My Wishlist
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="shopping-cart.html">
                                                        <i class="fa fa-fw fa-shopping-cart"></i>My Cart
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="checkout.html">
                                                        <i class="fa fa-fw fa-usd"></i>Checkout
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="login.html">
                                                        <i class="fa fa-fw fa-unlock-alt"></i>Login
                                                    </a>
                                                </li>
                                            </ul>
                                            <h3>LANGUAGE</h3>
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <img width="18" height="12" src="assets/img/icon/en.webp" alt="">English
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img width="18" height="12" src="assets/img/icon/fr.webp" alt="">French
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img width="18" height="12" src="assets/img/icon/ge.webp" alt="">German
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img width="18" height="12" src="assets/img/icon/sp.webp" alt="">Spanish
                                                    </a>
                                                </li>
                                            </ul>
                                            <h3>CURRENCY</h3>
                                            <ul>
                                                <li>
                                                    <a href="#">$ - USD</a>
                                                </li>
                                                <li>
                                                    <a href="#">€ - Euro</a>
                                                </li>
                                                <li>
                                                    <a href="#">£ - GBP</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mini-cart-area">
                                    <div class="header-menu-item-icon">
                                        <a href="#" class="icon-cart">
                                            <i class="fa animated fa-shopping-cart"></i>
                                            <span class="cart-total" id="carttotal2">0</span>
                                        </a>
                                        <div class="mini-cart">
                                            <ul id="cardsidebar2">

                                                <?php
                                                    $queryProduct = mysqli_query($conn, "SELECT p.id AS id, p.price AS price, c.price AS cartprice, p.name AS name, i.image AS image, c.qty AS qty, p.image_token AS image_token FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token WHERE c.user = '$userCart' AND c.status = '1'");
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
                                                    }
                                                ?>
                                            </ul>
                                            <p class="total" style="display: none;">
                                                <strong>Total:</strong>
                                                <span class="total-price">$630</span>
                                            </p>
                                            <p class="buttons">
                                                <a href="checkout">Check Out</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- HEADER RIGHT END -->
                    </div>
                </div>
                <!-- mobile-menu-area start -->
                <div class="mobile-menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="mobile-menu">
                                    <nav id="dropdown">
                                        <ul>
                                            <li><a href="index.html">Home</a>
                                                <ul>
                                                    <li><a href="index-2.html">Home Two</a></li>
                                                    <li><a href="index-3.html">Home Three</a></li>
                                                    <li><a href="index-4.html">Home Four</a></li>
                                                    <li><a href="index-5.html">Home Five</a></li>
                                                    <li><a href="index-6.html">Home Six</a></li>
                                                    <li><a href="index-7.html">Home Seven</a></li>
                                                    <li><a href="index-8.html">Home Eight</a></li>
                                                    <li><a href="index-9.html">Home Nine</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="shop.html">Shop</a>
                                                <ul>                                        
                                                    <li><a href="shop-full-width.html">Shop Full Width</a></li>
                                                    <li><a href="shop.html">Shop Left Sidebar</a></li>
                                                    <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                                    <li><a href="shop-2-columns.html">Shop 2 Columns</a></li>
                                                    <li><a href="shop.html">Shop 3 Column</a></li>
                                                    <li><a href="shop-5-columns.html">Shop 5 columns</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="shop.html">Elements</a>
                                                <ul>
                                                    <li><a href="shop.html">Products By Category</a></li>
                                                    <li><a href="shop.html">Product Image Zoom</a></li>
                                                    <li><a href="shop.html">Variable Product</a></li>
                                                    <li><a href="shop.html">Product Layout</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="blog-left-sidebar.html">Blogs</a>
                                                <ul>
                                                    <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                                    <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                                    <li><a href="blog-2-columns.html">Blog 2 Columns</a></li>
                                                    <li><a href="blog-3-columns.html">Blog 3 Columns</a></li>
                                                    <li><a href="blog-4-columns.html">Blog 4 Columns</a></li>
                                                    <li><a href="blog-details.html">Detail Blog</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="portfolio-2-columns.html">Portfolio</a>
                                                <ul>
                                                    <li><a href="portfolio-2-columns.html">Portfolio 2 columns</a></li>
                                                    <li><a href="portfolio-3-columns.html">Portfolio 3 columns</a></li>
                                                    <li><a href="portfolio-4-columns.html">Portfolio 4 columns</a></li>
                                                    <li><a href="portfolio-with-pagination-no-filter.html">Portfolio With Pagination</a></li>
                                                    <li><a href="portfolio-details.html">Detail Portfolio</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Pages</a>
                                                <ul>
                                                    <li><a href="about-us.html">About Us</a></li>
                                                    <li><a href="single-product.html">Product Details</a></li>
                                                    <li><a href="shopping-cart.html">Cart</a></li>
                                                    <li><a href="wishlist.html">Wishlist</a></li>
                                                    <li><a href="my-account.html">My Account</a></li>
                                                    <li><a href="login.html">Login Or Register</a></li>
                                                    <li><a href="checkout.html">Checkout</a></li>
                                                    <li><a href="contact.html">Contact</a></li>
                                                    <li><a href="404.html">404 Error</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contact-us.html">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>                  
                            </div>
                        </div>
                    </div>
                </div>
                <!-- mobile-menu-area end -->          
            </div>
		</header>
        <!-- HEADER AREA END -->