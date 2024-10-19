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
                                    <li><a href="index.html"><img width="80" src="assets/img/logo.png" alt="Logo"></a></li>
                                    <li><a href="my-account.html">My Account</a></li>
                                    <li><a href="wishlist.html">Wishlist</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="login.html">Login</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 d-none d-md-block">
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
                                       <a href="#" class="icon-search">
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
                                        <a href="#" class="user-icon">
                                            <i class="fa animated fa-gear"></i>
                                        </a>
                                        <div class="user-menu">
                                            <h3>ACCOUNT</h3>
                                            <ul>
                                                <li>
                                                    <a href="my-account.html"><i class="fa fa-fw fa-user"></i>My Account</a>
                                                </li>
                                                <li>
                                                    <a href="wishlist.html"><i class="fa fa-fw fa-heart"></i>My Wishlist</a>
                                                </li>
                                                <li>
                                                    <a href="shopping-cart.html"><i class="fa fa-fw fa-shopping-cart"></i>My Cart</a>
                                                </li>
                                                <li>
                                                    <a href="checkout.html"><i class="fa fa-fw fa-usd"></i>Checkout</a>
                                                </li>
                                                <li>
                                                    <a href="login.html"><i class="fa fa-fw fa-unlock-alt"></i>Login</a>
                                                </li>
                                            </ul>
                                            <h3>LANGUAGE</h3>
                                            <ul>
                                                <li><a href="#"><img width="18" height="12" src="assets/img/icon/en.webp" alt="">English</a></li>
                                                <li><a href="#"><img width="18" height="12" src="assets/img/icon/fr.webp" alt="">French</a></li>
                                                <li><a href="#"><img width="18" height="12" src="assets/img/icon/ge.webp" alt="">German </a></li>
                                                <li><a href="#"><img width="18" height="12" src="assets/img/icon/sp.webp" alt="">Spanish</a></li>
                                            </ul>
                                            <h3>CURRENCY</h3>
                                            <ul>
                                                <li><a href="#">$ - USD</a></li>
                                                <li><a href="#">€ - Euro</a></li>
                                                <li><a href="#">£ - GBP</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mini-cart-area">
                                    <div class="header-menu-item-icon">
                                        <a href="#" class="icon-cart">
                                            <i class="fa animated fa-shopping-cart"></i>
                                            <span class="cart-total">2 Items</span>
                                        </a>
                                        <div class="mini-cart">
                                            <ul>
                                                <li>
                                                    <a href="#" class="remove">X</a>
                                                    <div class="pro-img">
                                                        <img width="180" height="228" src="assets/img/cart/1.webp" alt="">
                                                    </div>
                                                    <div class="cart-poro-details">
                                                        <h2>
                                                            <a href="#">New Oxford Blazer</a>
                                                        </h2>
                                                        <div class="star-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                        <div class="quantity">
                                                            1x<span>$450.00</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="#" class="remove">X</a>
                                                    <div class="pro-img">
                                                        <img width="180" height="228" src="assets/img/cart/2.webp" alt="">
                                                    </div>
                                                    <div class="cart-poro-details">
                                                        <h2>
                                                            <a href="#">New Oxford Blazer</a>
                                                        </h2>
                                                        <div class="star-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                        <div class="quantity">
                                                            1x<span>$180.00</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <p class="total">
                                                <strong>Total:</strong>
                                                <span class="total-price">$630</span>
                                            </p>
                                            <p class="buttons">
                                                <a href="shoppint-cart.html">Go To Cart</a>
                                                <a href="checkout.html">Check Out</a>
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
                                    <img width="144" height="60" src="assets/img/logowhite.jpg" alt="Logo">
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
                                                        <a href="shop.html">Product Elements</a>
                                                    </h3>
                                                    <a href="shop.html">Products By Category</a>
                                                    <a href="shop.html">
                                                        <span class="new-pro">Product Featured Video</span>
                                                    </a>
                                                    <a href="shop.html">Product Image Zoom</a>
                                                    <a href="shop.html">
                                                        <span class="hot-pro">Product No Sidebar</span>
                                                    </a>
                                                    <a href="shop.html">Variable Product</a>
                                                    <a href="shop.html">Product Layout</a>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="shop.html">Product Elements</a>
                                                    </h3>
                                                    <a href="shop.html">Products – Best Selling</a>
                                                    <a href="shop.html">
                                                        <span class="sale-pro">Product On Sale</span>
                                                    </a>
                                                    <a href="shop.html">Products – Top Rate</a>
                                                    <a href="shop.html">
                                                        <span class="new-pro">Products – Featured</span>
                                                    </a>
                                                    <a href="shop.html">Products – Recent</a>
                                                    <a href="shop.html">Product Columns</a>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <h3 class="menu-hedding">
                                                        <a href="#">Theme Elements</a>
                                                    </h3>
                                                    <a href="#">Accordion / Tabs</a>
                                                    <a href="#">Google Maps</a>
                                                    <a href="#">Columns</a>
                                                    <a href="#">Team & Testimonials</a>
                                                    <a href="#">
                                                        <span class="hot-pro">Raymond Banner & Slider</span>
                                                    </a>
                                                    <a href="shop.html">
                                                        <span class="new-pro">Custom search, Icon & Others</span>
                                                    </a>
                                                </div>
                                                <div class="single-mega-menu">
                                                    <div class="menu-img">
                                                        <img width="240" height="193" src="assets/img/menu.webp" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
											<a href="#">Blogs</a>
                                            <ul class="dropdown">
                                                <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                                <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                                <li><a href="blog-2-columns.html">Blog 2 Columns</a></li>
                                                <li><a href="blog-3-columns.html">Blog 3 Columns</a></li>
                                                <li><a href="blog-4-columns.html">Blog 4 Columns</a></li>
                                                <li><a href="blog-details.html">Detail Blog</a></li>
                                            </ul>
                                        </li>
                                        <li>
											<a href="#">Portfolio</a>
                                             <ul class="dropdown">
                                                <li><a href="portfolio-2-columns.html">Portfolio 2 columns</a></li>
                                                <li><a href="portfolio-3-columns.html">Portfolio 3 columns</a></li>
                                                <li><a href="portfolio-4-columns.html">Portfolio 4 columns</a></li>
                                                <li><a href="portfolio-with-pagination-no-filter.html">Portfolio With Pagination</a></li>
                                                <li><a href="portfolio-details.html">Detail Portfolio</a></li>
                                            </ul>
                                        </li>
                                        <li>
											<a href="#">Pages</a>
                                            <ul class="dropdown">
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
                                            <span class="cart-total">2</span>
                                        </a>
                                        <div class="mini-cart">
                                            <ul>
                                                <li>
                                                    <a href="#" class="remove">X</a>
                                                    <div class="pro-img">
                                                        <img width="180" height="228" src="assets/img/cart/1.webp" alt="">
                                                    </div>
                                                    <div class="cart-poro-details">
                                                        <h2>
                                                            <a href="#">New Oxford Blazer</a>
                                                        </h2>
                                                        <div class="star-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                        <div class="quantity">
                                                            1x<span>$450.00</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="#" class="remove">X</a>
                                                    <div class="pro-img">
                                                        <img width="180" height="228" src="assets/img/cart/2.webp" alt="">
                                                    </div>
                                                    <div class="cart-poro-details">
                                                        <h2>
                                                            <a href="#">New Oxford Blazer</a>
                                                        </h2>
                                                        <div class="star-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                        <div class="quantity">
                                                            1x<span>$180.00</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <p class="total">
                                                <strong>Total:</strong>
                                                <span class="total-price">$630</span>
                                            </p>
                                            <p class="buttons">
                                                <a href="shopping-cart.html">Go To Cart</a>
                                                <a href="checkout.html">Check Out</a>
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