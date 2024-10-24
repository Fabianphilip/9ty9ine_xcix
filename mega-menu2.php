<div class="mega-menu">
    <div class="single-mega-menu">
        <h3 class="menu-hedding">
            <a href="shop?category=all">A-Z Brands</a>
        </h3>
        <a href="shop?category=brand">View all</a>
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
        <a href="shop?feature=all">View all</a>
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
        <a href="shop?category=men">View all</a>
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
        <a href="shop?category=women">View all</a>
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
        <a href="shop?category=unisex">View all</a>
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