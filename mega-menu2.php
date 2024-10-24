<div class="mega-menu">
    <div class="single-mega-menu">
        <h3 class="menu-hedding">
            <a href="shop?category=all">Product Category</a>
        </h3>
        <a href="shop?category=all">View all</a>
        <?php
            $queryCategories = mysqli_query($conn, "SELECT * FROM category");
            if(mysqli_num_rows($queryCategories) > 0){
                $sn = 1;
                while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                    ?><a href="shop?category=<?php echo $rowCategories['id'] ?>" class="my-1"><img src="category_images/<?php echo $rowCategories['image'] ?>" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowCategories['name'] ?></a><?php
                }
            }
        ?>
    </div>
    <div class="single-mega-menu">
        <h3 class="menu-hedding">
            <a href="shop?feature=all">Featured Products</a>
        </h3>
        <a href="shop?category=feature">View all</a>
        <?php
            $queryFeatures = mysqli_query($conn, "SELECT * FROM feature");
            if(mysqli_num_rows($queryFeatures) > 0){
                $sn = 1;
                while ($rowFeatures = mysqli_fetch_array($queryFeatures)) {
                    ?><a href="shop?feature=<?php echo $rowFeatures['id'] ?>"><img src="feature_images/<?php echo $rowFeatures['image'] ?>" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowFeatures['name'] ?></a><?php
                }
            }
        ?>
    </div>
    <div class="single-mega-menu">
        <h3 class="menu-hedding">
            <a href="shop?category=men">Men</a>
        </h3>
        <a href="shop?category=menn">View all</a>
        <?php
            $getCategory = mysqli_query($conn, "SELECT * FROM category WHERE name LIKE '%men%'");
            if(mysqli_num_rows($getCategory) > 0){
                $rowCategoryy = mysqli_fetch_array($getCategory);
                $categoryID = $rowCategoryy['id'];
                $queryCategories = mysqli_query($conn, "SELECT * FROM sub_category WHERE category_id = '$categoryID'");
                if(mysqli_num_rows($queryCategories) > 0){
                    $sn = 1;
                    while ($rowCategories = mysqli_fetch_array($queryCategories)) {
                        ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><img src="sub_category_images/<?php echo $rowCategories['image'] ?>" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowCategories['name'] ?></a><?php
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
                        ?><a href="shop?category=<?php echo $rowCategories['id'] ?>"><img src="sub_category_images/<?php echo $rowCategories['image'] ?>" style="border-radius: 50px; width: 30px; margin-right: 10px;"><?php echo $rowCategories['name'] ?></a><?php
                    }
                }
            }
            
        ?>
    </div>
    <div class="single-mega-menu" style="display: none;">
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