<div class="mega-menu" style="height: 200px;overflow-y: scroll;">
    <div class="single-mega-menu">
        <h3 class="menu-hedding" id="toggleDropdownCategory">
            <a href="shop?category=all">Product Category <i class="fa fa-angle-down"></i></a>
        </h3>
        <div id="dropdownMenuCategory" class="dropdownMenu" style="display: none;">
        <a href="shop?category=all">View all</a>
        <?php
            $queryCategories = mysqli_query($conn, "SELECT * FROM category LIMIT 4");
            if(mysqli_num_rows($queryCategories) > 0){
                $sn = 1;
                while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                    ?><a href="shop?category=<?php echo $rowCategories['id'] ?>" class="my-1"><img src="assets/img/9ty9inelogo.png" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowCategories['name'] ?></a><?php
                }
            }
        ?>
        </div>
    </div>
    <div class="single-mega-menu" style="display: none;">
        <h3 class="menu-hedding">
            <a href="shop?feature=all" id="toggleDropdownFeature">Featured Products <i class="fa fa-angle-down"></i></a>
        </h3>
        <div id="dropdownMenuFeature" class="dropdownMenu" style="display: none;">
        <a href="shop?category=feature">View all</a>
        <?php
            $queryFeatures = mysqli_query($conn, "SELECT * FROM feature LIMIT 4");
            if(mysqli_num_rows($queryFeatures) > 0){
                $sn = 1;
                while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                    ?><a href="shop?feature=<?php echo $rowFeatures['id'] ?>"><img src="assets/img/9ty9inelogo.png" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowFeatures['name'] ?></a><?php
                }
            }
        ?>
        </div>
    </div>
    <div class="single-mega-menu">
        <h3 class="menu-hedding">
            <a href="shop?category=men" id="toggleDropdownMen">Men <i class="fa fa-angle-down"></i></a>
        </h3>
        <div id="dropdownMenuMen" class="dropdownMenu" style="display: none;">
        <a href="shop?category=men">View all</a>
        <?php
            $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%men%' LIMIT 4");
            if(mysqli_num_rows($getCategory) > 0){
                $rowCategoryy = mysqli_fetch_array($getCategory);
                $categoryID = $rowCategoryy['id'];
                $queryCategories = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id = '$categoryID'");
                if(mysqli_num_rows($queryCategories) > 0){
                    $sn = 1;
                    while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                        ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><img src="assets/img/9ty9inelogo.png" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowCategories['name'] ?></a><?php
                    }
                }
            }
            
        ?>
        </div>
    </div>
    <div class="single-mega-menu">
        <h3 class="menu-hedding">
            <a href="shop?category=women" id="toggleDropdownWomen">Women <i class="fa fa-angle-down"></i></a>
        </h3>
        <div id="dropdownMenuWomen" class="dropdownMenu" style="display: none;">
        <a href="shop?category=women">View all</a>
        <?php
            $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%women%' LIMIT 4");
            if(mysqli_num_rows($getCategory) > 0){
                $rowCategoryy = mysqli_fetch_array($getCategory);
                $categoryID = $rowCategoryy['id'];
                $queryCategories = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id = '$categoryID'");
                if(mysqli_num_rows($queryCategories) > 0){
                    $sn = 1;
                    while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                        ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><img src="assets/img/9ty9inelogo.png" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowCategories['name'] ?></a><?php
                    }
                }
            }
            
        ?>
        </div>
    </div>
    <div class="single-mega-menu" style="display: none;">
        <h3 class="menu-hedding">
            <a href="shop?category=unisex">Unisex <i class="fa fa-angle-down"></i></a>
        </h3>
        <a href="shop?category=unisex">View all</a>
        <div class="menu-img">
            <?php
            $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%unisex%' LIMIT 4");
            if(mysqli_num_rows($getCategory) > 0){
                $rowCategoryy = mysqli_fetch_array($getCategory);
                ?><img src="category_images/<?php echo $rowCategoryy['image'] ?>" alt=""><?php
            }
            
        ?>
        </div>
    </div>
</div>