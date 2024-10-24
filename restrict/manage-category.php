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
    $header = tp_input($conn, 'header');
    $title = tp_input($conn, 'title');
    $description = tp_input($conn, 'description');
    $edit_id = tp_input($conn, 'edit_id');
    $editform = tp_input($conn, 'editform');

    
    if(!empty($del)){
        $del = mysqli_query($conn, "DELETE FROM category WHERE id = '$del'");
        if($del){
            ?><script type="text/javascript">window.location = "manage-category?success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-category?error=1"</script><?php
        }
    }
    
    
    if(isset($_POST['upload'])){
        if(empty($editform)){ 
            $success_alert_link = "";
            $success_alert = "";
        }
        $slug = str_replace(" ", "_", $name);
        $token = random_strings(22);
        
        $image = addslashes($_FILES['categoryImages']['name']);
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $extension;
        move_uploaded_file($_FILES["categoryImages"]["tmp_name"], "../category_images/" .$image);
    
        $sql = mysqli_query($conn, "INSERT INTO category (name, slug, header, title, description, image) VALUES ('$name', '$slug', '$header', '$title', '$description', '$image')");

        

        if($sql){
            ?><script type="text/javascript">window.location = "manage-category?success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-category?error=1"</script><?php
        }
    }

    
    if(isset($_POST['edit'])){
        $slug = str_replace(" ", "_", $name);
        if(!empty($_FILES["categoryImages"]["name"])) {
            $image = addslashes($_FILES['categoryImages']['name']);
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $image = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES["categoryImages"]["tmp_name"], "../category_images/" .$image);
        }else{
            $queryImage = mysqli_query($conn, "SELECT * FROM category WHERE id = '$edit_id'");
            if(mysqli_num_rows($queryImage) > 0){
                $rowImage = mysqli_fetch_array($queryImage);
                $image = $rowImage['image'];
            }
        }
        $sql = mysqli_query($conn, "UPDATE category SET name = '$name', slug = '$slug', header = '$header', title = '$title', description = '$description', image = '$image' WHERE id = '$edit_id'");
        if($sql){
            ?><script type="text/javascript">window.location = "manage-category?edit=<?php echo $edit_id ?>&success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-category?edit=<?php echo $edit_id ?>&error=1"</script><?php
        }
    }

    
    
    $result = mysqli_query($conn, "SELECT * FROM category");
    $count = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM category ORDER BY id DESC");
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
                                <h4>Management Categorys</h4>
                            </div>
                            <div class="col-md-6 p-2 my-0">
                                <a href="manage-category?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add Categorys</a>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="card p-4" style="width: 100%; overflow-x: scroll;">
                                    <table class="table" id="table">
                                        <thead>
                                            <th>Sn</th>
                                            <th>image</th>
                                            <th>Name</th>
                                            <th>Header</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th style="width: 100px;">Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                //$query_shop = mysqli_query($conn, "SELECT * FROM shop ORDER BY id DESC");
                                                $sn = 1;
                                                while($row = mysqli_fetch_array($result)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td><img src="../category_images/<?php echo $row['image']; ?>" style="width: 35px;"></td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo $row['header']; ?></td>
                                                        <td><?php echo $row['title']; ?></td>
                                                        <td><?php echo $row['description']; ?></td>
                                                        <td>
                                                            <div class="row d-flex" style="width: 170px;">
                                                                <div class="col-auto px-0"><a href="manage-category?edit=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-edit"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-category?del=<?php echo $row['id'] ?>" class="btn btn-secondary m-1"><i class="fa fa-trash"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-category?view=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-eye"></i></a></div>
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
                                <h4>Add Category</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-category" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            
                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Category Image</p>
                                                <input type="file" id="categoryImages" name="categoryImages">
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>
                                            
                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Category Text</p>
                                                <input type="text" name="name" class="form-control" required placeholder="Category" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Header</p>
                                                <input type="text" name="header" class="form-control" required placeholder="Category" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Title</p>
                                                <input type="text" name="title" class="form-control" required placeholder="Category" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Description</p>
                                                <input type="text" name="description" class="form-control" required placeholder="Category" value="">
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
                                $query_edit = mysqli_query($conn, "SELECT * FROM category WHERE id = '$edit'");
                                $row = mysqli_fetch_array($query_edit);
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>Edit Category</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-category" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-category?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="hidden" name="edit_id" value="<?php echo $edit; ?>">
                                            
                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Category Image</p>
                                                <input type="file" id="categoryImages" name="categoryImages">
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>
                                            
                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Category Name</p>
                                                <input type="text" name="name" class="form-control" required placeholder="category Name" value="<?php echo $row['name'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Header</p>
                                                <input type="text" name="header" class="form-control" required placeholder="category Name" value="<?php echo $row['header'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Title</p>
                                                <input type="text" name="title" class="form-control" required placeholder="category Name" value="<?php echo $row['title'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Description</p>
                                                <input type="text" name="description" class="form-control" required placeholder="category Name" value="<?php echo $row['description'] ?>">
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
                                $query_view = mysqli_query($conn, "SELECT * FROM category WHERE id = '$view'");
                                $row = mysqli_fetch_array($query_view);
                                $name = $row['name'];
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View category</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-category" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-category?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                            
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <div class="row">
                                        <div class="col-md-3">Image:</div>
                                        <div class="col-md-9">
                                            <img src="../category_images/<?php echo $row['image'] ?>" style="max-width: 100px; max-height: 100px; margin: 10px;">
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Id:</div><div class="col-md-9"><?php echo $row['id'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Category Name:</div><div class="col-md-9"><?php echo $row['name'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Header:</div><div class="col-md-9"><?php echo $row['header'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Title:</div><div class="col-md-9"><?php echo $row['title'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Description:</div><div class="col-md-9"><?php echo $row['description'] ?></div>
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
    
        const categoryImages = document.getElementById('categoryImages');
        const previewContainer = document.getElementById('previewContainer');
        let filesArray = [];


        <?php if(!empty($edit)){ ?>

        const existingImages = [
          <?php
                $query_product = mysqli_query($conn, "SELECT * FROM category WHERE id = '$edit'");  
                if(mysqli_num_rows($query_product) > 0){
                    $rowProduct = mysqli_fetch_array($query_product);
                    ?>{ id: <?php echo $rowProduct['id'] ?>, path: '../category_images/<?php echo $rowProduct['image'] ?>' },<?php
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




        categoryImages.addEventListener('change', function () {
          const files = Array.from(categoryImages.files);
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
          categoryImages.files = dataTransfer.files;
        }
        
    </script>
<?php } ?>
<?php include 'footer.php'; ?>