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
    $category_id = tp_input($conn, 'category_id');
    $edit_id = tp_input($conn, 'edit_id');
    $editform = tp_input($conn, 'editform');

    
    if(!empty($del)){
        $del = mysqli_query($conn, "DELETE FROM sub_category WHERE id = '$del'");
        if($del){
            ?><script type="text/javascript">window.location = "manage-sub_category?success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-sub_category?error=1"</script><?php
        }
    }
    
    
    if(isset($_POST['upload'])){
        if(empty($editform)){ 
            $success_alert_link = "";
            $success_alert = "";
        }
        $slug = str_replace(" ", "_", $name);
        $token = random_strings(22);
        $image = addslashes($_FILES['subcategoryImages']['name']);
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $extension;
        move_uploaded_file($_FILES["subcategoryImages"]["tmp_name"], "../sub_category_images/" .$image);


        $sql = mysqli_query($conn, "INSERT INTO sub_category (name, slug, category_id, image) VALUES ('$name', '$slug', '$category_id', '$image')");

        

        if($sql){
            ?><script type="text/javascript">window.location = "manage-sub_category?success=1"</script><?php
        }else{
            echo "Error in SQL query: " . mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-sub_category?error=1"</script><?php
        }
    }

    
    if(isset($_POST['edit'])){
        $slug = str_replace(" ", "_", $name);

        if(!empty($_FILES["subcategoryImages"]["name"])) {
            $image = addslashes($_FILES['subcategoryImages']['name']);
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $image = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES["subcategoryImages"]["tmp_name"], "../sub_category_images/" .$image);
        }else{
            $queryImage = mysqli_query($conn, "SELECT * FROM category WHERE id = '$edit_id'");
            if(mysqli_num_rows($queryImage) > 0){
                $rowImage = mysqli_fetch_array($queryImage);
                $image = $rowImage['image'];
            }
        }


        $sql = mysqli_query($conn, "UPDATE sub_category SET name = '$name', slug = '$slug', category_id = '$category_id', image = '$image' WHERE id = '$edit_id'");
        if($sql){
            ?><script type="text/javascript">window.location = "manage-sub_category?edit=<?php echo $edit_id ?>&success=1"</script><?php
        }else{
            echo "Error in SQL query: " . mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-sub_category?edit=<?php echo $edit_id ?>&error=1"</script><?php
        }
    }

    
    
    $result = mysqli_query($conn, "SELECT * FROM sub_category");
    $count = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM sub_category ORDER BY id DESC");
?>

    <?php if(!empty($success)){ ?> <br><br><div class="alert alert-success"> Success </div> <?php } ?>
    <?php if(!empty($error)){ ?> <br><br><div class="alert alert-danger"> Something Went Wrong!! </div> <?php } ?>
    
    <style>
        .general-link{
            border: 1px solid grey;
            padding: 10px;
            margin: 5px;
        }
    </style>
        
        
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row d-flex justify-content-center">
                        <?php if(empty($add) && empty($edit) && empty($view)){ ?>
                            <div class="col-md-6 p-2 my-0">
                                <h4>Management Sub Categorys</h4>
                            </div>
                            <div class="col-md-6 p-2 my-0">
                                <a href="manage-sub_category?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add Sub Categorys</a>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="card p-4" style="width: 100%; overflow-x: scroll;">
                                    <table class="table" id="table">
                                        <thead>
                                            <th>Sn</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th style="width: 100px;">Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                //$query_shop = mysqli_query($conn, "SELECT * FROM shop ORDER BY id DESC");
                                                $sn = 1;
                                                while($row = mysqli_fetch_array($result)){
                                                    $category = $row['category_id'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td><img src="../sub_category_images/<?php echo $row['image']; ?>" style="width: 35px;"></td>
                                                        <td>
                                                            <?php  
                                                                $query_category = mysqli_query($conn, "SELECT * FROM category WHERE id = '$category'");
                                                                if(mysqli_num_rows($query_category) > 0){
                                                                    $row_category = mysqli_fetch_array($query_category);
                                                                    echo $row_category['name'];
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td>
                                                            <div class="row d-flex" style="width: 170px;">
                                                                <div class="col-auto px-0"><a href="manage-sub_category?edit=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-edit"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-sub_category?del=<?php echo $row['id'] ?>" class="btn btn-secondary m-1"><i class="fa fa-trash"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-sub_category?view=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-eye"></i></a></div>
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
                                <h4>Add Sub Category</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-sub_category" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Sub Category Image</p>
                                                <input type="file" id="subcategoryImages" name="subcategoryImages">
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Category</p>
                                                <select class="form-select" name="category_id" id="category" onchange="selectCategory();">
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

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Sub Category Text</p>
                                                <input type="text" name="name" class="form-control" required placeholder="Category" value="">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="input-group my-4">
                                            <input type="submit" name="upload" class="btn btn-primary" value="upload">
                                        </div>  
                                    </form>
                                </div>
                            </div>
                        
                        <?php } ?>
                        <?php if(!empty($edit)){ ?>
                            <?php
                                $query_edit = mysqli_query($conn, "SELECT * FROM sub_category WHERE id = '$edit'");
                                $row = mysqli_fetch_array($query_edit);
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>Edit Sub Category</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-sub_category" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-sub_category?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="hidden" name="edit_id" value="<?php echo $edit; ?>">
                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Sub Category Image</p>
                                                <input type="file" id="subcategoryImages" name="subcategoryImages">
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Category</p>
                                                <select class="form-select" name="category_id" id="category" onchange="selectCategory();">
                                                    <?php  
                                                        $query_category = mysqli_query($conn, "SELECT * FROM category");
                                                        if(mysqli_num_rows($query_category) > 0){
                                                            while($row_category = mysqli_fetch_array($query_category)){
                                                                ?><option value="<?php echo $row_category['id'] ?>" <?php if($row_category['id'] == $row['category_id']){ ?> selected <?php } ?>><?php echo $row_category['name'] ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Sub Category Name</p>
                                                <input type="text" name="name" class="form-control" required placeholder="Sub category Name" value="<?php echo $row['name'] ?>">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="input-group my-4">
                                            <input type="submit" name="edit" class="btn btn-primary" value="edit">
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        
                        <?php } ?>
                        <?php if(!empty($view)){ ?>
                            <?php
                                $query_view = mysqli_query($conn, "SELECT * FROM sub_category WHERE id = '$view'");
                                $row = mysqli_fetch_array($query_view);
                                $name = $row['name'];
                                $category = $row['category_id']
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View Sub Category</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-sub_category" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-sub_category?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                            
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <div class="row">
                                        <div class="col-md-3">Image:</div>
                                        <div class="col-md-9">
                                            <img src="../sub_category_images/<?php echo $row['image'] ?>" style="max-width: 100px; max-height: 100px; margin: 10px;">
                                        </div>
                                    </div><hr>

                                    <div class="row">
                                        <div class="col-md-3">Id:</div><div class="col-md-9"><?php echo $row['id'] ?></div>
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
                                        <div class="col-md-3">Sub Category Name:</div><div class="col-md-9"><?php echo $row['name'] ?></div>
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
    </script>
<?php } ?>
<?php include 'footer.php'; ?>