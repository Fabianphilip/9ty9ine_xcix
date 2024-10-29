<?php include 'header.php' ?>
<?php if(!empty($email)){ ?>
<style>
    .cke_notifications_area{
        display: none !important;
    }
</style>
<div class="container mt-4">

<?php           
    $edit = get_input($conn, 'edit');
    $view = get_input($conn, 'view');
    $send = get_input($conn, 'send');
    $del = get_input($conn, 'del');
    $pn = get_input($conn, 'pn');
    $success = get_input($conn, 'success');
    $error = get_input($conn, 'error');
    
    $site_name = tp_input($conn, 'site_name');
    $domain = tp_input($conn, 'domain');
    $site_email = tp_input($conn, 'site_email');
    $site_address = tp_input($conn, 'site_address');
    $site_facebook = tp_input($conn, 'site_facebook');
    $site_phone = tp_input($conn, 'site_phone');
    $currency = tp_input($conn, 'currency');
    $sqmbol = tp_input($conn, 'sqmbol');
    $site_insta = tp_input($conn, 'site_insta');
    $site_linkedin = tp_input($conn, 'site_linkedin');
    $about = tp_input($conn, 'about');
    $terms = tp_input($conn, 'terms');
    $policies = tp_input($conn, 'policies');
    $edit_id = tp_input($conn, 'edit_id');
    $editform = tp_input($conn, 'editform');

    
    if(!empty($del)){
        $del = mysqli_query($conn, "DELETE FROM general WHERE id = '$del'");
        if($del){
            ?><script type="text/javascript">window.location = "general-management?success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "general-management?error=1"</script><?php
        }
    }
    
    
    

    
    if(isset($_POST['edit'])){
        $slug = str_replace(" ", "_", $site_name);
        if(!empty($_FILES["sitelogo"]["name"])) {
            $site_logo = addslashes($_FILES['sitelogo']['name']);
            $extension = pathinfo($site_logo, PATHINFO_EXTENSION);
            $site_logo = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES["sitelogo"]["tmp_name"], "../assets/img/" .$site_logo);
        }else{
            $queryImage = mysqli_query($conn, "SELECT * FROM general WHERE id = '$edit_id'");
            if(mysqli_num_rows($queryImage) > 0){
                $rowImage = mysqli_fetch_array($queryImage);
                $site_logo = $rowImage['site_logo'];
            }
        }
        if(!empty($_FILES["sitelogo"]["name"])) {
            $site_logo2 = addslashes($_FILES['sitelogo2']['name']);
            $extension = pathinfo($site_logo2, PATHINFO_EXTENSION);
            $site_logo2 = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES["sitelogo2"]["tmp_name"], "../assets/img/" .$site_logo2);
        }else{
            $queryImage = mysqli_query($conn, "SELECT * FROM general WHERE id = '$edit_id'");
            if(mysqli_num_rows($queryImage) > 0){
                $rowImage = mysqli_fetch_array($queryImage);
                $site_logo2 = $rowImage['site_logo2'];
            }
        }
        $sql = mysqli_query($conn, "UPDATE general SET site_name = '$site_name', domain = '$domain', site_email = '$site_email', site_address = '$site_address', site_facebook = '$site_facebook', site_phone = '$site_phone', currency = '$currency', sqmbol = '$sqmbol', site_insta = '$site_insta', site_linkedin = '$site_linkedin', site_logo = '$site_logo', site_logo2 = '$site_logo2', about = '$about', policies = '$policies', terms = '$terms' WHERE id = '$edit_id'");
        if($sql){
            ?><script type="text/javascript">window.location = "general-management?edit=<?php echo $edit_id ?>&success=1"</script><?php
        }else{
            echo mysqli_error($conn);
            ?><script type="text/javascript">window.location = "general-management?edit=<?php echo $edit_id ?>&error=1"</script><?php
        }
    }

    
    
    $result = mysqli_query($conn, "SELECT * FROM general");
    $count = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM general ORDER BY id DESC");
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
                        <?php if(empty($edit) && empty($view)){ ?>
                            <div class="col-md-6 p-2 my-0">
                                <h4>Management Features</h4>
                            </div>
                            <div class="col-md-6 p-2 my-0">
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="card p-4" style="width: 100%; overflow-x: scroll;">
                                    <table class="table" id="table">
                                        <thead>
                                            <th>Sn</th>
                                            <th>Site name</th>
                                            <th>Domain</th>
                                            <th>Site email</th>
                                            <th>site address</th>
                                            <th>Site facebook</th>
                                            <th>Site phone</th>
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

                                                        <td><?php echo $row['site_name']; ?></td>
                                                        <td><?php echo $row['domain']; ?></td>
                                                        <td><?php echo $row['site_email']; ?></td>
                                                        <td><?php echo $row['site_address']; ?></td>
                                                        <td><?php echo $row['site_facebook']; ?></td>
                                                        <td><?php echo $row['site_phone']; ?></td>
                                                        <td>
                                                            <div class="row d-flex" style="width: 170px;">
                                                                <div class="col-auto px-0"><a href="general-management?edit=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-edit"></i></a></div>
                                                                <div class="col-auto px-0"><a href="general-management?del=<?php echo $row['id'] ?>" class="btn btn-secondary m-1"><i class="fa fa-trash"></i></a></div>
                                                                <div class="col-auto px-0"><a href="general-management?view=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-eye"></i></a></div>
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
                        <?php if(!empty($edit)){ ?>
                            <?php
                                $query_edit = mysqli_query($conn, "SELECT * FROM general WHERE id = '$edit'");
                                $row = mysqli_fetch_array($query_edit);
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>Edit Feature</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="general-management" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                        
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="hidden" name="edit_id" value="<?php echo $edit; ?>">


                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Name</p>
                                                <input type="text" name="site_name" class="form-control" required placeholder="Site Name" value="<?php echo $row['site_name'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Domain</p>
                                                <input type="text" name="domain" class="form-control" required placeholder="Domain" value="<?php echo $row['domain'] ?>">
                                            </div>


                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Email</p>
                                                <input type="text" name="site_email" class="form-control" required placeholder="Site Email" value="<?php echo $row['site_email'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Address</p>
                                                <input type="text" name="site_address" class="form-control" required placeholder="Site Address" value="<?php echo $row['site_address'] ?>">
                                            </div>


                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Facebook</p>
                                                <input type="text" name="site_facebook" class="form-control" required placeholder="Site Facebook" value="<?php echo $row['site_facebook'] ?>">
                                            </div>


                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Phone</p>
                                                <input type="text" name="site_phone" class="form-control" required placeholder="Site Phone" value="<?php echo $row['site_phone'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Currency</p>
                                                <input type="text" name="currency" class="form-control" required placeholder="Site Currency" value="<?php echo $row['currency'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Symbol</p>
                                                <input type="text" name="sqmbol" class="form-control" required placeholder="Symbol" value="<?php echo $row['sqmbol'] ?>">
                                            </div>

                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Insta</p>
                                                <input type="text" name="site_insta" class="form-control" required placeholder="Site Insta" value="<?php echo $row['site_insta'] ?>">
                                            </div>


                                            <div class="col-md-6 my-2">
                                                <p class="m-0">Site Linkedin</p>
                                                <input type="text" name="site_linkedin" class="form-control" required placeholder="Site Linkedin" value="<?php echo $row['site_linkedin'] ?>">
                                            </div>

                                            <script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script>
                                            <div class="col-md-12 my-2">
                                                <p class="m-0">About</p>
                                                <textarea id="message1" class="form-control" name="about"><?php echo $row['about'] ?></textarea>
                                            </div>

                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Terms</p>
                                                <textarea id="message2" class="form-control" name="terms"><?php echo $row['terms'] ?></textarea>
                                            </div>

                                            <div class="col-md-12 my-2">
                                                <p class="m-0">Policies</p>
                                                <textarea id="message3" class="form-control" name="policies"><?php echo $row['policies'] ?></textarea>
                                            </div>
                                        </div>


                                        
                                        <script>
                                            CKEDITOR.replace('message1');
                                            CKEDITOR.replace('message2');
                                            CKEDITOR.replace('message3');
                                        </script> 
                                        
                                        
                                        
                                        <div class="input-group my-4">
                                            <input type="submit" name="edit" class="btn btn-primary" value="Update General">
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        
                        <?php } ?>
                        <?php if(!empty($view)){ ?>
                            <?php
                                $query_view = mysqli_query($conn, "SELECT * FROM general WHERE id = '$view'");
                                $row = mysqli_fetch_array($query_view);
                                $name = $row['name'];
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View Feature</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="general-management" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
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
                                            <img src="../assets/img/<?php echo $row['image'] ?>" style="max-width: 100px; max-height: 100px; margin: 10px;">
                                        </div>
                                    </div><hr>


                                    <div class="row">
                                        <div class="col-md-3">Site Name:</div><div class="col-md-9"><?php echo $row['site_name'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Somain:</div><div class="col-md-9"><?php echo $row['domain'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Site email:</div><div class="col-md-9"><?php echo $row['site_email'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Site Address:</div><div class="col-md-9"><?php echo $row['site_address'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Site Facebook:</div><div class="col-md-9"><?php echo $row['site_facebook'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Site Phone:</div><div class="col-md-9"><?php echo $row['site_phone'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Site currency:</div><div class="col-md-9"><?php echo $row['currency'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Symbol:</div><div class="col-md-9"><?php echo $row['sqmbol'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Site Instae:</div><div class="col-md-9"><?php echo $row['site_insta'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Site linkedin:</div><div class="col-md-9"><?php echo $row['site_linkedin'] ?></div>
                                    </div><hr>
                                </div>
                            </div>
                        <?php } ?>

                        
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / .container-fluid -->
    <script>
        document.querySelectorAll('.cke_notifications_area').forEach(function(element) {
            element.style.display = 'none';
          });
    </script>
    <script type="text/javascript">
         const featureImages = document.getElementById('featureImages');
        const previewContainer = document.getElementById('previewContainer');
        let filesArray = [];


        <?php if(!empty($edit)){ ?>

        const existingImages = [
          <?php
                $query_product = mysqli_query($conn, "SELECT * FROM general WHERE id = '$edit'");  
                if(mysqli_num_rows($query_product) > 0){
                    $rowProduct = mysqli_fetch_array($query_product);
                    ?>{ id: <?php echo $rowProduct['id'] ?>, path: '../assets/img/<?php echo $rowProduct['image'] ?>' },<?php
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




        featureImages.addEventListener('change', function () {
          const files = Array.from(featureImages.files);
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
          featureImages.files = dataTransfer.files;
        }
    </script>
<?php } ?>
<?php include 'footer.php'; ?>