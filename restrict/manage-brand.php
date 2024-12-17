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
    $content = tp_input($conn, 'content');
    $discount_news = tp_input($conn, 'discount_news');
    $edit_id = tp_input($conn, 'edit_id');
    $editform = tp_input($conn, 'editform');

    
    if(!empty($del)){
        $del = mysqli_query($conn, "DELETE FROM brand WHERE id = '$del'");
        if($del){
            ?><script type="text/javascript">window.location = "manage-brand?success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-brand?error=1"</script><?php
        }
    }
    
    
    if(isset($_POST['upload'])){
        if(empty($editform)){ 
            $success_alert_link = "";
            $success_alert = "";
        }
        $slug = str_replace(" ", "_", $name);
        $token = random_strings(22);

        $image = addslashes($_FILES['brandImages']['name']);
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $extension;
        move_uploaded_file($_FILES["brandImages"]["tmp_name"], "../brand_images/" .$image);
        $sql = mysqli_query($conn, "INSERT INTO brand (name, slug, content, image, discount_news) VALUES ('$name', '$slug', '$content', '$image', '$discount_news')");

        

        if($sql){
            ?><script type="text/javascript">window.location = "manage-brand?success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-brand?error=1"</script><?php
        }
    }

    
    if(isset($_POST['edit'])){
        $slug = str_replace(" ", "_", $name);
        if(!empty($_FILES["brandImages"]["name"])) {
            $image = addslashes($_FILES['brandImages']['name']);
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $image = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES["brandImages"]["tmp_name"], "../brand_images/" .$image);
        }else{
            $queryImage = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$edit_id'");
            if(mysqli_num_rows($queryImage) > 0){
                $rowImage = mysqli_fetch_array($queryImage);
                $image = $rowImage['image'];
            }
        }
        $sql = mysqli_query($conn, "UPDATE brand SET name = '$name', slug = '$slug', content = '$content', image = '$image', discount_news = '$discount_news' WHERE id = '$edit_id'");
        if($sql){
            ?><script type="text/javascript">window.location = "manage-brand?edit=<?php echo $edit_id ?>&success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "manage-brand?edit=<?php echo $edit_id ?>&error=1"</script><?php
        }
    }

    
    
    $result = mysqli_query($conn, "SELECT * FROM brand");
    $count = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM brand ORDER BY id DESC");
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
                                <h4>Management brands</h4>
                            </div>
                            <div class="col-md-6 p-2 my-0">
                                <a href="manage-brand?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add brands</a>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="card p-4" style="width: 100%; overflow-x: scroll;">
                                    <table class="table" id="table">
                                        <thead>
                                            <th>Sn</th>
                                            <th>image</th>
                                            <th>Name</th>
                                            <th>Content</th>
                                            <th>Discount News</th> 
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
                                                        <td><img src="../brand_images/<?php echo $row['image']; ?>" style="width: 35px;"></td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo $row['content']; ?></td>
                                                        <td><?php echo $row['discount_news']; ?></td>
                                                        <td>
                                                            <div class="row d-flex" style="width: 170px;">
                                                                <div class="col-auto px-0"><a href="manage-brand?edit=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-edit"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-brand?del=<?php echo $row['id'] ?>" class="btn btn-secondary m-1"><i class="fa fa-trash"></i></a></div>
                                                                <div class="col-auto px-0"><a href="manage-brand?view=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-eye"></i></a></div>
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
                                <h4>Add brand</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-brand" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Brand Image</p>
                                                <input type="file" id="brandImages" name="brandImages">
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Brand Text</p>
                                                <input type="text" name="name" class="form-control" required placeholder="Brand" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Brand Content</p>
                                                <input type="text" name="content" class="form-control" required placeholder="Brand" value="">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Discount News</p>
                                                <input type="text" name="discount_news" class="form-control" required placeholder="Brand" value="">
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
                                $query_edit = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$edit'");
                                $row = mysqli_fetch_array($query_edit);
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>Edit Brand</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-brand" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-brand?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="hidden" name="edit_id" value="<?php echo $edit; ?>">

                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Brand Image</p>
                                                <input type="file" id="brandImages" name="brandImages">
                                                <div class="preview-container" id="previewContainer"></div>
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Brand Name</p>
                                                <input type="text" name="name" class="form-control" required placeholder="Brand Name" value="<?php echo $row['name'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Brand Content</p>
                                                <input type="text" name="content" class="form-control" required placeholder="Brand Content" value="<?php echo $row['content'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Discount News</p>
                                                <input type="text" name="discount_news" class="form-control" required placeholder="Brand Content" value="<?php echo $row['discount_news'] ?>">
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
                                $query_view = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$view'");
                                $row = mysqli_fetch_array($query_view);
                                $name = $row['name'];
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View Brand</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-brand" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                                <a href="manage-brand?add=1" class="btn btn-primary float-right mx-2" style="float: right;"> Add </a>
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
                                            <img src="../brand_images/<?php echo $row['image'] ?>" style="max-width: 100px; max-height: 100px; margin: 10px;">
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Brand Name:</div><div class="col-md-9"><?php echo $row['name'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Brand Content:</div><div class="col-md-9"><?php echo $row['content'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Discount News:</div><div class="col-md-9"><?php echo $row['discount_news'] ?></div>
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
         const brandImages = document.getElementById('brandImages');
        const previewContainer = document.getElementById('previewContainer');
        let filesArray = [];


        <?php if(!empty($edit)){ ?>

        const existingImages = [
          <?php
                $query_product = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$edit'");  
                if(mysqli_num_rows($query_product) > 0){
                    $rowProduct = mysqli_fetch_array($query_product);
                    ?>{ id: <?php echo $rowProduct['id'] ?>, path: '../brand_images/<?php echo $rowProduct['image'] ?>' },<?php
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




        brandImages.addEventListener('change', function () {
          const files = Array.from(brandImages.files);
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
          brandImages.files = dataTransfer.files;
        }
    </script>
<?php } ?>
<?php include 'footer.php'; ?>