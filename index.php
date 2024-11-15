<?php include 'header.php' ?>
    <?php if(!isset($_SESSION['firstsee'])){ 
        $_SESSION['firstsee'] = 1;
    ?>
    <div id="firstsee" style="position: fixed;top: 0;left: 0; width: 100%;height: 100%;background-color: white;align-items: center;justify-content: center;z-index: 999999999;text-align: center; align-content: center;">
        <img src="assets/img/9ty9inelogo.png" style="background-color: #fff;padding: 20px; width: 80%;max-width: 400px;border-radius: 8px;position: relative;text-align: center; animation: fadeIn 0.3s ease-in-out;"><br>
        <span style="padding: 10px 10px; background: black; color: white; font-weight: 900; border-radius: 50px; display: inline-block;" onclick="closefirstseen()">Continue</span>
    </div>
    <script type="text/javascript">
        function closefirstseen(){
            document.getElementById("firstsee").style.display = 'none';
        }
    </script>
    <?php } ?>

        <!-- SLIDER AREA START -->
        <div class="" style="display: none;">
            <div class="row">
                <div class="col-12">
                    <div class="slider-area marg-b70">
                        <div id="ensign-nivoslider-1" class="">   
                            <img width="1920" height="909" src="assets/img/slider/home-1/sliderbg.webp" alt="" title="#slider-direction-1"  />
                            <img width="1920" height="909" src="assets/img/slider/home-1/sliderbg.webp" alt="" title="#slider-direction-2"  />
                        </div>
                        <!-- direction 1 -->
                        <div id="slider-direction-1" class="slider-direction">
                            <div class="slider-content">
                                <?php
                                    $queryFeatures = mysqli_query($conn, "SELECT * FROM feature WHERE discount_news != '' AND position = '1' ORDER BY RAND(id) LIMIT 2");
                                    if(mysqli_num_rows($queryFeatures) > 0){
                                        $sn = 1;
                                        while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                                            $snn = $sn++;
                                            $featureId = $rowFeatures['id'];
                                        ?>
                                        <div class="sliderimg">
                                            <img class="fadeInRight" width="890" height="910" src="feature_images/<?php echo $rowFeatures['image'] ?>" alt="">
                                            <div class="slider-text">
                                                <div class="sl-heading">
                                                    <center><h2 class="bounceInUp" style="width: 60%;"><?php echo $rowFeatures['name'] ?></h2></center>
                                                    <h2 class="off-text fadeInLeft"><?php echo $rowFeatures['discount_news'] ?></h2>
                                                </div>
                                                <div class="sub-title">
                                                    <center><p class="fadeInDown" style="width: 70%;"><?php echo $rowFeatures['content'] ?></p></center>
                                                </div>
                                                <a href="shop" class="sl-button fadeInUp">SHOP NOW</a>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- direction 2 -->
                        <div id="slider-direction-2" class="slider-direction">
                            <div class="slider-content">
                                <?php
                                    $queryFeatures = mysqli_query($conn, "SELECT * FROM feature WHERE discount_news != '' AND position = '1' ORDER BY RAND(id) LIMIT 2,2");
                                    if(mysqli_num_rows($queryFeatures) > 0){
                                        $sn = 1;
                                        while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                                            $snn = $sn++;
                                            $featureId = $rowFeatures['id'];
                                        ?>
                                        <div class="sliderimg">
                                            <img class="fadeInUp" width="890" height="910" src="feature_images/<?php echo $rowFeatures['image'] ?>" alt="">
                                            <div class="slider-text">
                                                <div class="sl-heading">
                                                    <center><h2 class="bounceInUp" style="width: 60%;"><?php echo $rowFeatures['name'] ?></h2></center>
                                                    <h2 class="off-text fadeInLeft"><?php echo $rowFeatures['discount_news'] ?></h2>
                                                </div>
                                                <div class="sub-title">
                                                    <center><p class="fadeInDown" style="width: 70%;"><?php echo $rowFeatures['content'] ?></p></center>
                                                </div>
                                                <a href="shop" class="sl-button fadeInUp">SHOP NOW</a>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SLIDER AREA END -->

        <!-- <div id="breadcrumb">
            <?php
                $backgroundColors = ['#c9e726', '#C22D2E', '#4A90E2', '#F5A623', '#7ED321', '#D0021B'];
                $queryFeatures = mysqli_query($conn, "SELECT * FROM feature WHERE discount_news != '' AND position = '1' ORDER BY RAND(id)");
                    if(mysqli_num_rows($queryFeatures) > 0){
                        $sn = 1;
                        while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                            $snn = $sn++;
                            $featureId = $rowFeatures['id'];
                            $bgColor = $backgroundColors[array_rand($backgroundColors)];
                        ?>
                        <div class="slide" style="background-color: <?php echo $bgColor; ?>;">
                            <div class="content">
                                <h1 class="title"><?php echo $rowFeatures['name'] ?> <?php echo $rowFeatures['discount_news'] ?></h1>
                                <p class="subtitle"><?php echo $rowFeatures['content'] ?></p>
                            </div>
                            <img src="feature_images/<?php echo $rowFeatures['image'] ?>" alt="Model Image" class="model">
                        </div>
                    <?php
                    }
                }
            ?>
        </div> -->

        <div id="breadcrumb">
            
            <div class="slide" style="background-color: #555257;">
                <div class="content">
                    <h1 class="title" style="color: white; font-size: 68px;"><strong>XCIX</strong></h1>
                    <p class="subtitle" style="color: white; font-size: 48px;">Luxery Street Wear redefined</p>
                    <div><a href="shop" style="background: black; color: white; padding: 10px;">Shop Now</a></div>
                </div>
                <img src="assets/img/6729bf57b6fcfferuyu.png" alt="Model Image" class="model">
            </div>

            <div class="slide" style="background-color: #d58d16;">
                <div class="content">
                    <h1 class="title" style="color: white; font-size: 68px;"><strong>XCIX</strong></h1>
                    <p class="subtitle" style="color: white; font-size: 48px;">Compliment Dresses</p>
                    <div><a href="shop" style="background: black; color: white; padding: 10px;">Shop Now</a></div>
                </div>
                <img src="assets/img/6729bf40a3bc44234.png" alt="Model Image" class="model">
            </div>
              
        </div>

        <div class="popular-category-area marg-b70" style="display: none;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2>POPULAR CATEGORIES</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="popular-category-carosul nav-button-style-one owl-carousel owl-theme">
                        <?php
                            $queryCategories = mysqli_query($conn, "SELECT * FROM category ORDER BY RAND(id) LIMIT 5");
                            if(mysqli_num_rows($queryCategories) > 0){
                                $sn = 1;
                                while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                                    $snn = $sn++;
                                    $categoryId = $rowCategories['id'];
                                    $queryNo = mysqli_query($conn, "SELECT category FROM product WHERE category = '$categoryId'");
                                ?>
                                <div class="single-category-product">
                                    <a href="shop?category=<?php echo $rowCategories['name'] ?>">
                                        <div class="category-thumb">
                                            <img width="540" height="692" src="category_images/<?php echo $rowCategories['image'] ?>" alt="Category">
                                        </div>
                                        <div class="category-title">
                                            <h3>
                                                <?php echo $rowCategories['name'] ?><small>( <?php echo mysqli_num_rows($queryNo) ?>)</small>
                                            </h3>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- PRODUCT-TAB AREA START -->
        <div class="product-tab-area marg-b70">
            <div class="container mobilexmargin">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title style-two">
                            <h2>THE TRENDY PRODUCTS</h2>
                        </div>
                        <div class="tab-menu">
                          <ul class="nav">
                            <?php
                                $queryFeatures = mysqli_query($conn, "SELECT * FROM feature WHERE discount_news != '' AND position = '3' LIMIT 4");
                                if(mysqli_num_rows($queryFeatures) > 0){
                                    $sn = 1;
                                    while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                                        $snn = $sn++;
                                        $featureId = $rowFeatures['id'];
                                    ?>
                                    <li class="nav-item"><button class="nav-link <?php if($snn == '1'){ ?>active <?php } ?>" data-bs-toggle="tab" href="#<?php echo $rowFeatures['slug'] ?>" aria-expanded="true"><?php echo $rowFeatures['name'] ?></button></li>
                                    <?php
                                    }
                                }
                            ?>
                          </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="tab-content">
                        <?php
                            $queryFeatures = mysqli_query($conn, "SELECT * FROM feature WHERE discount_news != '' AND position = '3' LIMIT 4");
                            if(mysqli_num_rows($queryFeatures) > 0){
                                $sn = 1;
                                while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                                $snn = $sn++;
                                $featureId = $rowFeatures['id'];
                            ?>
                        <div id="<?php echo $rowFeatures['slug'] ?>" class="tab-pane fade <?php if($snn == '1'){ ?>active show <?php } ?>">
                            <div class="row">
                                <?php
                                    $queryProduct = mysqli_query($conn, "SELECT c.name AS category_name, p.id AS id, p.price AS price, p.rating AS rating, p.discount AS discount, p.name AS name, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token LIMIT 2) AS images, p.image_token AS image_token FROM product p JOIN product_images i ON i.token  = p.image_token JOIN category c ON c.id = p.category WHERE p.feature LIKE '%$featureId%' GROUP BY p.id ");
                                    if(mysqli_num_rows($queryProduct) > 0){
                                        while($rowProduct = mysqli_fetch_array($queryProduct)){
                                            $images = explode(',', $rowProduct['images']);
                                    ?>
                                        <div class="col-6 col-lg-3 col-sm-6 col-md-6">
                                            <div class="single-product">
                                                <div class="product_height" style="border: 10px solid white;">
                                                    <a href="details?id=<?php echo $rowProduct['id']; ?>">
                                                        <?php if(!empty($images[0])){ ?><img class="primary-image product_height" alt="Special" width="540" height="692" src="product_images/<?php echo $images[0]; ?>" style="object-fit: cover; border: 10px solid white"><?php } ?>
                                                        <?php if(!empty($images[1])){ ?><img class="secondary-image product_height" style="display: none" alt="Special" width="540" height="692" src="product_images/<?php echo $images[1]; ?>" style="object-fit: cover; border: 10px solid white"><?php } ?>
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
        </div>

        <div class="brand-logo-area" style="display:none">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="brand-logo-carosul owl-carousel owl-theme">
                            <?php
                                $getBrand = mysqli_query($conn, "SELECT * FROM brand");
                                if(mysqli_num_rows($getBrand) > 0){
                                    while($rowBrand = mysqli_fetch_array($getBrand)){
                                        ?><img src="brand_images/<?php echo $rowBrand['image'] ?>" alt="" style="max-width: 150px;"><?php
                                    }
                                }
                            ?>
                                                        
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/1.webp" alt="Logo Brand"></a>
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/2.webp" alt="Logo Brand"></a>
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/3.webp" alt="Logo Brand"></a>
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/4.webp" alt="Logo Brand"></a>
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/5.webp" alt="Logo Brand"></a>
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/1.webp" alt="Logo Brand"></a>
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/3.webp" alt="Logo Brand"></a>
                            <a href="#"><img width="235" height="100" src="assets/img/brand-logo/4.webp" alt="Logo Brand"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            let currentSlide = 0;
            const slides = document.querySelectorAll(".slide");

            function showSlide(index) {
              slides.forEach((slide, i) => {
                slide.classList.remove("active");
                if (i === index) {
                  slide.classList.add("active");
                }
              });
            }

            function nextSlide() {
              currentSlide = (currentSlide + 1) % slides.length;
              showSlide(currentSlide);
            }

            showSlide(currentSlide);
            setInterval(nextSlide, 5000);

        </script>
        <!-- BRAND-LOGO-AREA END -->
        <?php include 'footer.php' ?>