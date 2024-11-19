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
        <title><?php echo $row_general['site_name'] ?></title>
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
		<link rel="stylesheet" href="assets/css/style6.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
    </head>
    <body>
        <style type="text/css">
            @media only screen and (max-width: 600px){
                .product_height{
                    height: 200px;
                }
                .mobilexmargin{
                    margin: 0px 0px 0px 0px !important;
                    width: 100% !important;
                }
            }
            @media only screen and (min-width: 600px){
                .product_height{
                    height: 200px;
                }
            }
            input[type="number"] {
                -moz-appearance: textfield; /* Firefox */
                -webkit-appearance: none; /* Safari, Chrome, iOS */
                appearance: none; /* Standard */
            }

            input[type="number"]::-webkit-inner-spin-button, 
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: inner-spin-button; /* Ensures spin buttons show */
                margin: 0; /* Removes any margin for better alignment */
            }

        </style>
        <div class="btn btn-success p-2" id="succesAlert" style="color: white; position: fixed; z-index: 999999; width: 100%; display: none;">
            <center>Successfull added to cart</center>
        </div>
        <div class="btn btn-secondary p-2" id="removalAlert" style="color: white; position: fixed; z-index: 999999; width: 100%; display: none;">
            <center>Successfull removed to cart</center>
        </div>

        <!-- HEADER AREA START -->
        <header>
            <!-- HEADER-TOP START -->
            <div class="header-top-ber hide-show">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="top-menu">
                                <ul>
                                    <li><a href="/"><img width="80" src="assets/img/9ty9inelogo.png" alt="Logo" style="width: 50px;"></a></li>
                                    <li><a href="shop">Shop</a></li>
                                    <li><a href="shop?category=men">Men</a></li>
                                    <li><a href="shop?category=women">Women</a></li>
                                    <li><a href="shop?category=unisex" style="display: none;">Unisex</a></li>
                                    <li><a href="login">Login</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 d-none d-md-block m-0 p-0">
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
                                        <a href="#" class="user-icon m-0 p-0" style="display: none;">
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
                                            <span class="cart-total"><span id="cartSpan"><?php echo $countCart ?></span> Items | ₦<span id="cartSpanTotal"><?php if($totalPrice > 0){ echo number_format($totalPrice,2); }else{ echo '0.0'; } ?></span></span>
                                        </a>
                                        <div class="mini-cart">
                                            <ul id="cardsidebar">
                                                <?php
                                                    $queryProduct = mysqli_query($conn, "SELECT p.rating AS rating, p.id AS id, p.price AS price, c.price AS cartprice, p.name AS name, i.image AS image, c.qty AS qty, p.image_token AS image_token FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token WHERE c.user = '$userCart' AND c.status = '1' GROUP BY p.id");
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
                                                <!-- <a href="">Go To Cart</a> -->
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
                <div class="">
                    <div class="row">
                        <!-- LOGO AREA START -->
                        <div class="col-6 col-lg-2 col-md-6" style="align-content: center !important;">
                            <div class="m-0 p-0" style="align-content: center !important; background-color: black; border: 4px solid white;">
                                <a href="/">
                                    <!-- <img src="assets/img/9ty9inelogo.png" alt="Logo" style="width: 50px;"> -->
                                    <strong><h1 style="padding: 10px; color: white; font-family: serif !important; font-weight: 900; margin: 0px; font-size: 40px;">9ty9ine</h1></strong>
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
											<a href="/">Home</a>
                                        </li>
                                        <li>
											<a href="shop">Shop</a>
                                        </li>
                                        <li>
											<a href="#">Items</a>
                                            <?php include 'mega-menu.php' ?>
                                        </li>

                                        <li>
                                            <a href="#">Brands</a>
                                            <?php include 'mega-menu2.php'; ?>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- MAIN MENU AREA END -->
                        <!-- HEADER RIGHT START -->
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="header-right">
                                <div class="user-menu-area">
                                    <div class="header-menu-item-icon">
                                        <a href="#" class="user-icon" style="display: none;">
                                            <i class="fa animated fa-gear"></i>
                                        </a>
                                        <div class="user-menu" style="display: none;">
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
                                                    $queryProduct = mysqli_query($conn, "SELECT p.rating AS rating, p.image_token AS image_token, p.id AS id, p.price AS price, c.price AS cartprice, p.name AS name, i.image AS image, c.qty AS qty, p.image_token AS image_token FROM cart c JOIN product p ON p.id = c.product JOIN product_images i ON i.token = p.image_token WHERE c.user = '$userCart' AND c.status = '1' GROUP BY p.id");
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
                                            <li><a href="/">Home</a>
                                            </li>
                                            <li><a href="shop">Shop</a>
                                            </li>
                                            <li><a href="shop">Items</a>
                                                <?php include 'mega-menu.php' ?>
                                            </li>
                                            <li><a href="brands">Brands</a>
                                                <<?php include 'mega-menu2.php'; ?>
                                            </li>
                                            <li><a href="contact">Contact</a></li>
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