<?php include 'header.php' ?>
<?php if(!empty($email)){ ?>
<div class="container mt-4">

<?php           
    $add = get_input($conn, 'add');
    $edit = get_input($conn, 'edit');
    $view = get_input($conn, 'view');
    $send = get_input($conn, 'send');
    $del = get_input($conn, 'del');
    $pn = get_input($conn, 'pn');
    $success = get_input($conn, 'success');
    $error = get_input($conn, 'error');
    
    $name = tp_input($conn, 'name');
    $price = tp_input($conn, 'price');
    $cost_price = tp_input($conn, 'cost_price');
    $outside_price = tp_input($conn, 'outside_price');
    $outside_cost_price = tp_input($conn, 'outside_cost_price');
    $description = html_entity_decode(tp_input($conn, 'description'));
    $keypoint = html_entity_decode(tp_input($conn, 'keypoint'));
    $search_keyword = html_entity_decode(tp_input($conn, 'search_keyword'));
    $discount = tp_input($conn, 'discount');
    $rating = tp_input($conn, 'rating');
    $category = tp_input($conn, 'category');
    $brand = tp_input($conn, 'brand');
    $sub_category = tp_input($conn, 'sub_category');
    $quantity = tp_input($conn, 'quantity');
    $parking = tp_input($conn, 'parking');
    $origin = tp_input($conn, 'origin');
    $type = tp_input($conn, 'type');
    $sku = tp_input($conn, 'sku');
    $out_of_stock = tp_input($conn, 'out_of_stock');
    $edit_id = tp_input($conn, 'edit_id');
    $editform = tp_input($conn, 'editform');

    
    if(!empty($del)){
        $del = mysqli_query($conn, "DELETE FROM product WHERE id = '$del'");
        if($del){
            ?><script type="text/javascript">window.location = "manage-product?success=1"</script><?php
        }else{
            die('Error note' . mysqli_error($conn));
            ?><script type="text/javascript">window.location = "manage-product?error=1"</script><?php
        }
    }
    
    
    if(isset($_POST['upload'])){
        $discount = empty($discount) || $discount == '0' ? 1 : $discount ;
        $quantity = empty($quantity) || $quantity == '0' ? 1 : $quantity ;
        if(empty($editform)){ 
            $success_alert_link = "";
            $success_alert = "";
        }
        $slug = str_replace(" ", "_", $name);
        $token = random_strings(22);
        if (!empty($_POST['feature'])) {
            $feature = implode(",", $_POST['feature']);
        } else {
            $feature = ''; 
        }
        $sql = mysqli_query($conn, "INSERT INTO product (name, price, cost_price, outside_price, outside_cost_price, description, keypoint, search_keyword, discount, rating, feature, brand, category, sub_category, quantity, parking, image_token, slug, origin, type, sku, out_of_stock) VALUES ('$name', '$price', '$cost_price', '$outside_price', '$outside_cost_price', '$description', '$keypoint', '$search_keyword', '$discount', '$rating', '$feature', '$brand', '$category', '$sub_category', '$quantity', '$parking', '$token', '$slug', '$origin', '$type', '$sku', '$out_of_stock')");

        for ($i=0; $i < count($_FILES["productImages"]["name"]); $i++) { 
          $image = addslashes($_FILES['productImages']['name'][$i]);
          $extension = pathinfo($image, PATHINFO_EXTENSION);
          $image = uniqid() . '.' . $extension;
          move_uploaded_file($_FILES["productImages"]["tmp_name"][$i], "../product_images/" .$image);

          $sql_image = mysqli_query($conn, "INSERT INTO product_images (token, image) VALUES ('$token', '$image')");

        }

        $option_types = $_POST['option_type'];
        $option_values = $_POST['option_value'];

        if (!empty($option_types) && !empty($option_values)) {
            foreach ($option_types as $index => $option_type) {
                $option_value = $option_values[$index];
                $sql_variation = mysqli_query($conn, "INSERT INTO variations (option_type, option_value, token) VALUES ('$option_type', '$option_value', '$token')");
            }
        } 

        if($sql){
            ?><script type="text/javascript">window.location = "manage-product?success=1"</script><?php
        }else{
            echo "$name ------- $price ------- $cost_price ------- $outside_price ------- $outside_cost_price ------- $description ------- $keypoint ------- $search_keyword ------- $discount ------- $rating ------- $feature ------- $brand ------- $category ------- $sub_category ------- $quantity ------- $parking ------- $token ------- $slug ------- $origin ------- $type ------- $sku ------- $out_of_stock ";
            echo 'Error note' . mysqli_error($conn);
            ?><script type="text/javascript">//window.location = "manage-product?error=1"</script><?php
        }
    }

    
    if(isset($_POST['edit'])){
        $discount = empty($discount) || $discount == '0' ? 1 : $discount ;
        $quantity = empty($quantity) || $quantity == '0' ? 1 : $quantity ;
        if (!empty($_POST['feature'])) {
            $feature = implode(",", $_POST['feature']);
        } else {
            $feature = ''; 
        }
        $queryToken = mysqli_query($conn, "SELECT * FROM product WHERE id = '$edit_id'");
        if(mysqli_num_rows($queryToken) > 0){
            $rowtoken = mysqli_fetch_array($queryToken);
            $token = $rowtoken['image_token'];
        }
        //if(!empty($_FILES["productImages"]['name'])){
        if(!empty($_FILES["productImages"]["name"][0])) {
            $delImage = mysqli_query($conn, "DELETE FROM product_images WHERE token = '$token'");
            for ($i=0; $i < count($_FILES["productImages"]["name"]); $i++) { 
              $image = addslashes($_FILES['productImages']['name'][$i]);
              $extension = pathinfo($image, PATHINFO_EXTENSION);
              $image = uniqid() . '.' . $extension;
              move_uploaded_file($_FILES["productImages"]["tmp_name"][$i], "../product_images/" .$image);

              $sql_image = mysqli_query($conn, "INSERT INTO product_images (token, image) VALUES ('$token', '$image')");

            }
        }
        $slug = str_replace(" ", "_", $name);
        $sql = mysqli_query($conn, "UPDATE product SET name = '$name', price = '$price', cost_price = '$cost_price', outside_price = '$outside_price', outside_cost_price = '$outside_cost_price', description = '$description', keypoint = '$keypoint', search_keyword = '$search_keyword', discount = '$discount', rating = '$rating', feature = '$feature', brand = '$brand', category = '$category', sub_category = '$category', quantity = '$quantity', parking = '$parking', slug = '$slug', origin = '$origin', type = '$type', sku = '$sku', out_of_stock = '$out_of_stock' WHERE id = '$edit_id'");

        $del_variation = mysqli_query($conn, "DELETE FROM variations WHERE token = '$token'");

        $option_types = $_POST['option_type'];
        $option_values = $_POST['option_value'];

        if (!empty($option_types) && !empty($option_values)) {
            foreach ($option_types as $index => $option_type) {
                $option_value = $option_values[$index];
                $sql_variation = mysqli_query($conn, "INSERT INTO variations (option_type, option_value, token) VALUES ('$option_type', '$option_value', '$token')");
            }
        } 

        if($sql){
            ?><script type="text/javascript">window.location = "manage-product?edit=<?php echo $edit_id ?>&success=1"</script><?php
        }else{
            echo "$name ------- $price ------- $cost_price ------- $outside_price ------- $outside_cost_price ------- $description ------- $keypoint ------- $search_keyword ------- $discount ------- $rating ------- $feature ------- $brand ------- $category ------- $sub_category ------- $quantity ------- $parking ------- $token ------- $slug ------- $origin ------- $type ------- $sku ------- $out_of_stock ";
            die('Error note' . mysqli_error($conn));
            ?><script type="text/javascript">window.location = "manage-product?edit=<?php echo $edit_id ?>&error=1"</script><?php
        }
    }

    
    
    $result = mysqli_query($conn, "SELECT * FROM product");
    $count = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM product ORDER BY id DESC");
?>

    <?php if(!empty($success)){ ?> <br><br><div class="alert alert-success"> Success </div> <?php } ?>
    <?php if(!empty($error)){ ?> <br><br><div class="alert alert-danger"> Something Went Wrong!! </div> <?php } ?>
    
    <style>
        .general-link{
            border: 1px solid grey;
            padding: 10px;
            margin: 5px;
        }
        .cke_notifications_area{
            display: none !important;
        }
    </style>
        
        
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row d-flex justify-content-center">
                        <?php if(empty($add) && empty($edit) && empty($view)){ ?>
                            <div class="col-md-6 p-2 my-0">
                                <h4>Management Products</h4>
                            </div>
                            <div class="col-md-6 p-2 my-0">
                                <a href="manage-product?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add Products</a>
                                <a href="manage-category" class="btn btn-primary float-right mx-2" style="float: right;"> Products Categories </a>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="card p-4" style="width: 100%; overflow-x: scroll;">
                                    <table class="table" id="table">
                                        <thead>
                                            <th>Sn</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Feature</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Quantity</th>
                                            <th style="width: 100px;">Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                //$query_shop = mysqli_query($conn, "SELECT * FROM shop ORDER BY id DESC");
                                                $sn = 1;
                                                while($row = mysqli_fetch_array($result)){
                                                    $image_token = $row['image_token'];
                                                    $feature = $row['feature'];
                                                    $category = $row['category'];
                                                    $sub_category = $row['sub_category'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td>
                                                            <?php  
                                                                $query_image = mysqli_query($conn, "SELECT * FROM product_images WHERE token = '$image_token' LIMIT 1");
                                                                if(mysqli_num_rows($query_image) > 0){
                                                                    $row_image = mysqli_fetch_array($query_image);
                                                                    ?><img src="../product_images/<?php echo $row_image['image']; ?>" style="width: 50px;"><?php
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo number_format($row['price'], 2); ?></td>
                                                        <td>
                                                            <?php  
                                                                $query_feature = mysqli_query($conn, "SELECT * FROM feature WHERE id = '$feature'");
                                                                if(mysqli_num_rows($query_feature) > 0){
                                                                    $row_feature = mysqli_fetch_array($query_feature);
                                                                    echo $row_feature['name'];
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php  
                                                                $query_category = mysqli_query($conn, "SELECT * FROM category WHERE id = '$category'");
                                                                if(mysqli_num_rows($query_category) > 0){
                                                                    $row_category = mysqli_fetch_array($query_category);
                                                                    echo $row_category['name'];
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php  
                                                                $query_sub_category = mysqli_query($conn, "SELECT * FROM sub_category WHERE id = '$sub_category'");
                                                                if(mysqli_num_rows($query_sub_category) > 0){
                                                                    $row_sub_category = mysqli_fetch_array($query_sub_category);
                                                                    echo $row_sub_category['name'];
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['quantity']; ?></td>
                                                        <td>
                                                            <div class="row d-flex" style="width: 170px;">
                                                                <div class="col-auto px-0"><a href="manage-product?edit=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-edit"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-product?del=<?php echo $row['id'] ?>" class="btn btn-secondary m-1"><i class="fa fa-trash"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-product?view=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-eye"></i></a></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }$sn;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(!empty($add)){ ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>Add Product</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-product" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Product Image</p>
                                                <input type="file" id="productImages" name="productImages[]" multiple>
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Type</p>
                                                <select class="form-select" name="type" id="">
                                                    <option value="">** Choose Type **</option>
                                                    <option value="1">Single Type Product</option>
                                                    <option value="2">Product with variations</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Product Name</p>
                                                <input type="text" name="name" class="form-control" required placeholder="Product Name" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Price/Unit</p>
                                                <input type="number" name="price" class="form-control" required placeholder="Price" value="">
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">Cost Price/Unit</p>
                                                <input type="number" name="cost_price" class="form-control" placeholder="Price" value="">
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">Outside Price/Unit</p>
                                                <input type="number" name="outside_price" class="form-control" placeholder="Price" value="">
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">Outside Cost Price</p>
                                                <input type="number" name="outside_cost_price" class="form-control" placeholder="Price" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Discount</p>
                                                <input type="number" name="discount" class="form-control" placeholder="discount" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Rating</p>
                                                <select class="form-select" name="rating">
                                                    <option value="5">★★★★★</option>
                                                    <option value="4">★★★★</option>
                                                    <option value="3">★★★</option>
                                                    <option value="2">★★</option>
                                                    <option value="1">★</option>
                                                    <option value="0"></option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Brand</p>
                                                <select class="form-select" name="brand" id="brand">
                                                    <option value=""> ** Choose Brand</option>
                                                    <?php  
                                                        $query_brand = mysqli_query($conn, "SELECT * FROM brand");
                                                        if(mysqli_num_rows($query_brand) > 0){
                                                            while($row_brand = mysqli_fetch_array($query_brand)){
                                                                ?><option value="<?php echo $row_brand['id'] ?>"><?php echo $row_brand['name'] ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Category</p>
                                                <select class="form-select" required name="category" id="category" onchange="selectCategory();">
                                                    <option> ** Choose Category</option>
                                                    <?php  
                                                        $query_category = mysqli_query($conn, "SELECT * FROM category");
                                                        if(mysqli_num_rows($query_category) > 0){
                                                            while($row_category = mysqli_fetch_array($query_category)){
                                                                ?><option value="<?php echo $row_category['id'] ?>"><?php echo $row_category['name'] ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2" id="subcategory_call">
                                                <p class="m-0">Sub Category</p>
                                                <select class="form-select" name="category" id="sub_category">
                                                    <option>**** Choose category first ****</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">SKU (Store Keeping Unit)</p>
                                                <input type="text" name="sku" class="form-control" placeholder="" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Quantity</p>
                                                <input type="number" name="quantity" class="form-control" required placeholder="quantity" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Parking</p>
                                                <select class="form-select" name="parking" id="">
                                                    <option value="" required selected="" disabled="">**Select packing type**</option>
                                                    <option value="1 KG">Per KG</option>
                                                    <option value="1 Piece">Per Piece</option>
                                                    <option value="1 Pack">Per Pack</option>
                                                    <option value="200 G">Per 200 G</option>
                                                    <option value="Box">Per Box</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Origin</p>
                                                <input type="text" class="form-control" name="origin" placeholder="Origin">
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="col-md-12">
                                                <p class="m-0">Feature</p>
                                                <?php
                                                    $getfeature = mysqli_query($conn, "SELECT * FROM feature");
                                                    if(mysqli_num_rows($getfeature) > 0){
                                                        while($rowFeature = mysqli_fetch_array($getfeature)){
                                                            ?>
                                                            <span class="mx-4"><input type="checkbox" name="feature[]" value="<?php echo $rowFeature['id']; ?>"> <span><?php echo $rowFeature['name'] ?></span></span>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </div><br><br><br>
                                            <hr>
                                            <div class="col-md-12">
                                                <p class="m-0">Variation</p>
                                                <div id="variations-container">
                                                    <!-- Row for Options and Input -->
                                                    <div class="row mb-3 variation-row">
                                                        <div class="col-md-3">
                                                            <select class="form-select" name="option_type[]">
                                                                <option value="Colors">Colors</option>
                                                                <option value="Size">Size</option>
                                                                <option value="Material">Material</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="option_value[]" placeholder="Options" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-danger">&times;</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add More Button -->
                                                <button type="button" id="add-more" class="btn btn-secondary mb-3">+ Add More</button>
                                            </div>
                                            <br><br><br>
                                            <hr>

                                            <div class="col-md-12 my-2">
                                                <label>Description</label>
                                                <textarea id="message2" name="description" rows="6" class="form-control"></textarea>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <label>Key Point</label>
                                                <textarea name="keypoint" rows="6" class="form-control"></textarea>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <label>Search Keyword</label>
                                                <textarea  name="search_keyword" rows="6" class="form-control" placeholder="ex. blue trousers, shirts, jeans.."></textarea>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Out of Stock</p>
                                                <select class="form-select" name="out_of_stock" id="">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                        <script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script>
                                        <script>
                                            CKEDITOR.replace('message2');
                                        </script> 
                                        
                                        <div class="input-group my-4">
                                            <input type="submit" name="upload" class="btn btn-primary" value="upload">
                                        </div>  
                                    </form>
                                </div>
                            </div>
                        
                        <?php } ?>
                        <?php if(!empty($edit)){ ?>
                            <?php
                                $query_edit = mysqli_query($conn, "SELECT * FROM product WHERE id = '$edit'");
                                $row = mysqli_fetch_array($query_edit);
                                $token = $row['image_token'];
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>Edit Product</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-product" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-product?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="edit_id" value="<?php echo $edit; ?>">
                                        <div class="row">
                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Product Image</p>
                                                <input type="file" id="productImages" name="productImages[]" multiple>
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Type</p>
                                                <select class="form-select" name="type" id="">
                                                    <option value=""></option>
                                                    <option value="1" <?php if($row['type'] == '1'){ ?> selected <?php } ?>>Single Type Product</option>
                                                    <option value="2" <?php if($row['type'] == '2'){ ?> selected <?php } ?>>Product with variations</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Product Name</p>
                                                <input type="text" name="name" class="form-control" required placeholder="Product Name" value="<?php echo $row['name'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Price/Unit</p>
                                                <input type="number" name="price" class="form-control" required placeholder="Price" value="<?php echo $row['price'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">Cost Price/Unit</p>
                                                <input type="number" name="cost_price" class="form-control"  placeholder="Price" value="<?php echo $row['cost_price'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">Outside Price/Unit</p>
                                                <input type="number" name="outside_price" class="form-control"  placeholder="Price" value="<?php echo $row['outside_price'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">Outside Cost Price</p>
                                                <input type="number" name="outside_cost_price" class="form-control"  placeholder="Price" value="<?php echo $row['outside_cost_price'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Discount</p>
                                                <input type="number" name="discount" class="form-control" placeholder="discount" value="<?php echo $row['discount'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Rating</p>
                                                <select class="form-select" name="rating">
                                                    <option value="5" <?php if($row['rating'] == '5'){ ?> selected <?php } ?>>★★★★★</option>
                                                    <option value="4" <?php if($row['rating'] == '4'){ ?> selected <?php } ?>>★★★★</option>
                                                    <option value="3" <?php if($row['rating'] == '3'){ ?> selected <?php } ?>>★★★</option>
                                                    <option value="2" <?php if($row['rating'] == '2'){ ?> selected <?php } ?>>★★</option>
                                                    <option value="1" <?php if($row['rating'] == '1'){ ?> selected <?php } ?>>★</option>
                                                    <option value="0" <?php if($row['rating'] == '0'){ ?> selected <?php } ?>></option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Brand</p>
                                                <select class="form-select" name="category" id="category" onchange="selectCategory();">
                                                    <?php  
                                                        $query_brand = mysqli_query($conn, "SELECT * FROM brand");
                                                        if(mysqli_num_rows($query_brand) > 0){
                                                            while($row_brand = mysqli_fetch_array($query_brand)){
                                                                ?><option value="<?php echo $row_brand['id'] ?>" <?php if($row_brand['id'] == $row['brand']){ ?> selected <?php } ?>><?php echo $row_brand['name'] ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Category</p>
                                                <select class="form-select" name="category" id="category" onchange="selectCategory();">
                                                    <?php  
                                                        $query_category = mysqli_query($conn, "SELECT * FROM category");
                                                        if(mysqli_num_rows($query_category) > 0){
                                                            while($row_category = mysqli_fetch_array($query_category)){
                                                                ?><option value="<?php echo $row_category['id'] ?>" <?php if($row_category['id'] == $row['category']){ ?> selected <?php } ?>><?php echo $row_category['name'] ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2" id="subcategory_call">
                                                <p class="m-0">Sub Category</p>
                                                <select class="form-select" name="sub_category" id="sub_category">
                                                    <option>** choose Your subcategory</option>
                                                    <?php  
                                                        $query_sub_category = mysqli_query($conn, "SELECT * FROM sub_category");
                                                        if(mysqli_num_rows($query_sub_category) > 0){
                                                            while($row_sub_category = mysqli_fetch_array($query_sub_category)){
                                                                ?><option value="<?php echo $row_sub_category['id'] ?>" <?php if($row_sub_category['id'] == $row['sub_category']){ ?> selected <?php } ?>><?php echo $row_sub_category['name'] ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2" style="display: none;">
                                                <p class="m-0">SKU (Store Keeping Unit)</p>
                                                <input type="text" name="sku" class="form-control"  placeholder="" value="<?php echo $row['sku'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Quantity</p>
                                                <input type="number" name="quantity" class="form-control" required placeholder="quantity" value="<?php echo $row['quantity'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Parking</p>
                                                <select class="form-select" name="parking" id="">
                                                    <option  value="" selected="" disabled="">**Select packing type**</option>
                                                    <option <?php if($row['parking'] == '1 KG'){ ?> selected <?php } ?> value="1 KG">Per KG</option>
                                                    <option <?php if($row['parking'] == '1 Piece'){ ?> selected <?php } ?> value="1 Piece">Per Piece</option>
                                                    <option <?php if($row['parking'] == '1 Pack'){ ?> selected <?php } ?> value="1 Pack">Per Pack</option>
                                                    <option <?php if($row['parking'] == '200 G'){ ?> selected <?php } ?> value="200 G">Per 200 G</option>
                                                    <option <?php if($row['parking'] == 'Box'){ ?> selected <?php } ?> value="Box">Per Box</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Origin</p>
                                                <input type="text" name="origin" class="form-control"  placeholder="Origin" value="<?php echo $row['origin'] ?>">
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="col-md-12">
                                                <p class="m-0">Feature</p>
                                                <?php
                                                    $selectedFeatures = $row['feature']; 
                                                    $selectedFeaturesArray = explode(',', $selectedFeatures);

                                                    $getfeature = mysqli_query($conn, "SELECT * FROM feature");
                                                    if(mysqli_num_rows($getfeature) > 0){
                                                        while($rowFeature = mysqli_fetch_array($getfeature)){
                                                            $isChecked = in_array($rowFeature['id'], $selectedFeaturesArray) ? 'checked' : '';
                                                            ?>
                                                            <span class="mx-4"><input type="checkbox" name="feature[]" value="<?php echo $rowFeature['id']; ?>" <?php echo $isChecked; ?>> <span><?php echo $rowFeature['name'] ?></span></span>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </div><br><br><br>
                                            <hr>

                                            <div class="col-md-12">
                                                <p class="m-0">Variation</p>
                                                <div id="variations-container">
                                                    <?php
                                                        $query_variation = mysqli_query($conn, "SELECT * FROM variations WHERE token  = '$token'");
                                                        if(mysqli_num_rows($query_variation) > 0){
                                                            while($rowVariation = mysqli_fetch_array($query_variation)){
                                                                ?>
                                                                <div class="row mb-3 variation-row">
                                                                    <div class="col-md-3">
                                                                        <select class="form-select" name="option_type[]">
                                                                            <option <?php if($rowVariation['option_type'] == 'Colors'){ ?> selected <?php } ?> value="Colors">Colors</option>
                                                                            <option <?php if($rowVariation['option_type'] == 'Size'){ ?> selected <?php } ?> value="Size">Size</option>
                                                                            <option <?php if($rowVariation['option_type'] == 'Material'){ ?> selected <?php } ?> value="Material">Material</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <input type="text" class="form-control" name="option_value[]" placeholder="Options" value="<?php echo $rowVariation['option_value'] ?>" required>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button" class="btn btn-danger">&times;</button>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }else{
                                                            ?>
                                                                <div class="row mb-3 variation-row">
                                                                    <div class="col-md-3">
                                                                        <select class="form-select" name="option_type[]">
                                                                            <option value="Colors">Colors</option>
                                                                            <option value="Size">Size</option>
                                                                            <option value="Material">Material</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <input type="text" class="form-control" name="option_value[]" placeholder="Options" required>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button" class="btn btn-danger remove-btn">&times;</button>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                </div>
                                                <!-- Add More Button -->
                                                <button type="button" id="add-more" class="btn btn-secondary mb-3">+ Add More</button>
                                            </div>
                                            <br><br><br>
                                            <hr>

                                            <div class="col-md-12 my-2">
                                                <label>Description</label>
                                                <textarea id="message2" name="description" rows="6" class="form-control"><?php echo $row['description'] ?></textarea>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <label>Key Point</label>
                                                <textarea name="keypoint" rows="6" class="form-control"><?php echo $row['keypoint'] ?></textarea>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <label>Search Keyword</label>
                                                <textarea  name="search_keyword" rows="6" class="form-control" placeholder="ex. blue trousers, shirts, jeans.."><?php echo $row['search_keyword'] ?></textarea>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Out of Stock</p>
                                                <select class="form-select" name="out_of_stock" id="">
                                                    <option <?php if($row['out_of_stock'] == 'no'){ ?> selected <?php } ?> value="no">No</option>
                                                    <option <?php if($row['out_of_stock'] == 'yes'){ ?> selected <?php } ?> value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                        <script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script>
                                        <script>
                                            CKEDITOR.replace('message2');
                                        </script> 
                                        
                                        <div class="input-group my-4">
                                            <input type="submit" name="edit" class="btn btn-primary" value="edit">
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        
                        <?php } ?>
                        <?php if(!empty($view)){ ?>
                            <?php
                                $query_view = mysqli_query($conn, "SELECT * FROM product WHERE id = '$view'");
                                $row = mysqli_fetch_array($query_view);
                                $name = $row['name'];
                                $image_token = $row['image_token'];
                                $feature = $row['feature'];
                                $category = $row['category'];
                                $sub_category = $row['sub_category'];
                                $brand = $row['brand'];
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View Product</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-product" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-product?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                            
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <div class="row">
                                        <div class="col-md-3">Id:</div><div class="col-md-9"><?php echo $row['id'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Image:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_image = mysqli_query($conn, "SELECT * FROM product_images WHERE token = '$image_token'");
                                                if(mysqli_num_rows($query_image) > 0){
                                                    while($row_image = mysqli_fetch_array($query_image)){
                                                        ?><img src="../product_images/<?php echo $row_image['image'] ?>" style="max-width: 100px; max-height: 100px; margin: 10px;"><?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Parkig:</div><div class="col-md-9"><?php if($row['type'] == '1'){ echo 'Single Type Product'; }else{ echo 'Product with variations'; } ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Product Name:</div><div class="col-md-9"><?php echo $row['name'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Price/Unit:</div><div class="col-md-9"><?php echo number_format($row['price']) ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Cost Price/Unit:</div><div class="col-md-9"><?php echo number_format($row['cost_price']) ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Outside Price/Unit:</div><div class="col-md-9"><?php echo number_format($row['outside_price']) ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Outside Cost Price/Unit:</div><div class="col-md-9"><?php echo number_format($row['outside_cost_price']) ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Quantity:</div><div class="col-md-9"><?php echo $row['quantity'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Parking:</div><div class="col-md-9"><?php echo $row['parking'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Origin:</div><div class="col-md-9"><?php echo $row['origin'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Feature:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_feature = mysqli_query($conn, "SELECT * FROM feature WHERE id IN ($feature)");
                                                if(mysqli_num_rows($query_feature) > 0){
                                                    while($row_feature = mysqli_fetch_array($query_feature)){
                                                        echo $row_feature['name']." | ";
                                                    }
                                                } 
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Brand:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_category = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$brand'");
                                                if(mysqli_num_rows($query_brand) > 0){
                                                    while($row_brand = mysqli_fetch_array($query_brand)){
                                                        echo $row_brand['name'];
                                                    }
                                                } 
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Category:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_category = mysqli_query($conn, "SELECT * FROM category WHERE id = '$category'");
                                                if(mysqli_num_rows($query_category) > 0){
                                                    while($row_category = mysqli_fetch_array($query_category)){
                                                        echo $row_category['name'];
                                                    }
                                                } 
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Sub Category:</div>
                                        <div class="col-md-9">
                                            <?php
                                                $query_sub_category = mysqli_query($conn, "SELECT * FROM sub_category WHERE id = '$sub_category'");
                                                if(mysqli_num_rows($query_sub_category) > 0){
                                                    while($row_sub_category = mysqli_fetch_array($query_sub_category)){
                                                        echo $row_sub_category['name'];
                                                    }
                                                } 
                                            ?>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">SKU (Store Keeping Unit):</div><div class="col-md-9"><?php echo $row['sku'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Description:</div><div class="col-md-9"><?php echo html_entity_decode($row['description']) ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Keypoint:</div><div class="col-md-9"><?php echo $row['keypoint'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Search Keyword:</div><div class="col-md-9"><?php echo $row['search_keyword'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Out of Stock:</div><div class="col-md-9"><?php echo $row['out_of_stock'] ?></div>
                                    </div><hr>
                                </div>
                            </div>
                        <?php } ?>

                        
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / .container-fluid -->
    <script type="text/javascript">
        function selectCategory() {
            const xhttp = new XMLHttpRequest();
            var category = document.getElementById("category").value;
            xhttp.onload = function() {
                document.getElementById("subcategory_call").innerHTML =this.responseText;
            }
            xhttp.open("GET", "../xhttp?category=" + category);
            xhttp.send();
        }

        const productImages = document.getElementById('productImages');
        const previewContainer = document.getElementById('previewContainer');
        let filesArray = [];


        <?php if(!empty($edit)){ ?>

        const existingImages = [
          <?php
                $query_product = mysqli_query($conn, "SELECT * FROM product WHERE id = '$edit'");  
                if(mysqli_num_rows($query_product) > 0){
                    $rowProduct = mysqli_fetch_array($query_product);
                    $image_token = $rowProduct['image_token'];
                    $query_image = mysqli_query($conn, "SELECT * FROM product_images WHERE token = '$image_token'");
                    if(mysqli_num_rows($query_image) > 0){
                        while($row_image = mysqli_fetch_array($query_image)){
                            ?>{ id: <?php echo $row_image['id'] ?>, path: '../product_images/<?php echo $row_image['image'] ?>' },<?php
                        }
                    }
                } 
            ?>
        ];
        existingImages.forEach(image => {
          const imageDiv = document.createElement('div');
          imageDiv.classList.add('preview-image');
          
          const img = document.createElement('img');
          img.src = image.path;
          img.setAttribute('data-id', image.id);
          
          const removeBtn = document.createElement('button');
          removeBtn.classList.add('remove-btn');
          removeBtn.innerText = 'X';
          removeBtn.addEventListener('click', function () {
            imageDiv.remove();
            filesArray = filesArray.filter(f => f.id !== image.id);
            removeImageFromServer(image.id);
          });

          imageDiv.appendChild(img);
          imageDiv.appendChild(removeBtn);
          previewContainer.appendChild(imageDiv);
          filesArray.push({ id: image.id, path: image.path });
        });

        function removeImageFromServer(imageId) {
          console.log('Removing image with ID:', imageId);
        }

        <?php } ?>




        productImages.addEventListener('change', function () {
          const files = Array.from(productImages.files);
          files.forEach(file => {
            if (file && file.type.includes('image')) {
              const reader = new FileReader();
              reader.onload = function (e) {
                const imageDiv = document.createElement('div');
                imageDiv.classList.add('preview-image');
                
                const img = document.createElement('img');
                img.src = e.target.result;

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-btn');
                removeBtn.innerText = 'X';
                removeBtn.addEventListener('click', function () {
                  imageDiv.remove();
                  filesArray = filesArray.filter(f => f.name !== file.name);
                  updateFileInput();
                });

                imageDiv.appendChild(img);
                imageDiv.appendChild(removeBtn);
                previewContainer.appendChild(imageDiv);
                
                filesArray.push(file);
                updateFileInput();
              };
              reader.readAsDataURL(file);
            }
          });
        });

        
        function updateFileInput() {
          const dataTransfer = new DataTransfer();
          filesArray.forEach(file => {
            dataTransfer.items.add(file);
          });
          productImages.files = dataTransfer.files;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const addMoreButton = document.getElementById('add-more');
            const variationsContainer = document.getElementById('variations-container');

            addMoreButton.addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3', 'variation-row');
                newRow.innerHTML = `
                    <div class="col-md-3">
                        <select class="form-select" name="option_type[]">
                            <option value="Colors">Colors</option>
                            <option value="Size">Size</option>
                            <option value="Material">Material</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="option_value[]" placeholder="Options" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger">&times;</button>
                    </div>
                `;
                variationsContainer.appendChild(newRow);

                const removeButtons = document.querySelectorAll('.remove-btn');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        button.closest('.variation-row').remove();
                    });
                });
            });

            const removeButtons = document.querySelectorAll('.remove-btn');
            removeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    button.closest('.variation-row').remove();
                });
            });
        });

    </script>
<?php } ?>
<?php include 'footer.php'; ?>