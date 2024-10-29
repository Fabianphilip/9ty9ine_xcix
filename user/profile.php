<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>  

<?php
    $success = get_input($conn, 'success');
    $error = get_input($conn, 'error');
    if(isset($_POST['save'])){
        $full_name = tp_input($conn, 'full_name');
        $phone = tp_input($conn, 'phone');
        $gender = tp_input($conn, 'gender');
        $dob = tp_input($conn, 'dob');
        $user_email = tp_input($conn, 'user_email');


        $update = mysqli_query($conn, "UPDATE users SET full_name = '$full_name', phone = '$phone', sex = '$gender', dob = '$dob' WHERE email = '$user_email'");
        if($update){
            ?> <script type="text/javascript">window.location = 'profile?success=1'</script><?php
        }else{
            ?> <script type="text/javascript">window.location = 'profile?error=1'</script><?php   
        }
    }
?>  

<?php
    if(!empty($success)){
        ?><div class="row"><div class="col-md-12 alert alert-success">Updated successfully</div></div><?php
    }
    if(!empty($error)){
        ?><div class="row"><div class="col-md-12 alert alert-danger">Something went wrong</div></div><?php
    }
?>  

    <div class="col-md-12">
        <div class="page-title col-md-12 border-radius mt-4">
            <div class="row">
                <div class="d-flex">
                    <div class="title">
                        <h5>Dashboard - <small>Profile</small> </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 p-3 bg-white border-radius">
                    <h5>Account Details</h5>
                    <form action="" method="post">
                        <input type="hidden" name="user_email" value="<?php echo $email; ?>">
                        <div class="card p-4">
                            <div class="col-md-12">
        
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname"> <small>Full name</small> </label>
                                            <input type="text" id="firstname" name="full_name" class="form-control" value="<?php echo $row_user['full_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email"><small>Email</small></label>
                                            <input type="text" id="email" name="email" class="form-control" readonly value="<?php echo $email; ?>">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone"><small>Phone</small></label>
                                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $row_user['phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender"><small>Gender </small></label>
                                            <select class="form-control" name="gender" id="gender">
                                                <option value="">** choose gender **</option>
                                                <option value="male" <?php if($row_user['sex'] == 'male'){ ?> selected <?php } ?>>male</option>
                                                <option value="female" <?php if($row_user['sex'] == 'female'){ ?> selected <?php } ?>>female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birth"><small>Birthday </small></label>
                                            <input type="date" class="form-control" name="dob" id="birth" value="<?php echo $row_user['dob'] ?>">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="text-right mt-2">
                                    <input type="submit" class="btn btn-primary" name="save" value="Save">
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>

    </div>

<?php } ?>
<?php include 'footer.php'; ?>