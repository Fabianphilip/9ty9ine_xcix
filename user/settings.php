<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>  

<?php
    $error = get_input($conn, 'error');
    $success = get_input($conn, 'success');

    if(isset($_POST['change_password'])){
        $current_password = md5(tp_input($conn, 'current_password'));
        $password = md5(tp_input($conn, 'password'));
        $confirm_password = md5(tp_input($conn, 'confirm_password'));
        $user_email = tp_input($conn, 'user_email');

        $queryUser = mysqli_query($conn, "SELECT * FROM users WHERE email = '$user_email'");
        if(mysqli_num_rows($queryUser) > 0){
            $rowUser = mysqli_fetch_array($queryUser);
            $existingPassword = $rowUser['password'];

            if($password == $confirm_password){
                if($existingPassword == $current_password){
                    $updatepassword = mysqli_query($conn, "UPDATE users SET password = '$password' WHERE email = '$user_email'");
                    if($updatepassword){
                        ?><script type="text/javascript">window.location = 'settings?success=1'</script><?php
                    }
                }else{
                ?><script type="text/javascript">window.location = 'settings?error=1'</script><?php
                }
            }else{
                ?><script type="text/javascript">window.location = 'settings?error=2'</script><?php
            }
        }
    }
?>  
    
<?php
    if(!empty($success)){
        ?><div class="row"><div class="col-md-12 alert alert-success">PAssword updated successfully</div></div><?php
    }
    if(!empty($error)){
        if($error == 1){
            ?><div class="row"><div class="col-md-12 alert alert-danger">The current password entered is incorrect</div></div><?php
        }
        if($error == 2){
            ?><div class="row"><div class="col-md-12 alert alert-danger">The passwords entered dont match </div></div><?php
        }
    }

?>
    <div class="col-md-12">

        <div class="page-title col-md-12 border-radius mt-4">
            <div class="row">
                <div class="d-flex">
                    <div class="title">
                        <h5>Dashboard - <small>Account settings</small> </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card p-4">
                    <div class="title">
                        <h4>Password Settings</h4>
                    </div>
                    <div class="d-flex mt-2 p-2">
                        <div class="details ml-2">
                            <strong> </strong>
                            <p> <?php echo $row_user['full_name']; ?></p>
                            
                            <div class="actions">
                                <div class="d-flex justify-content-end">
                                    <button onclick="openmodal('changePassword')" class="btn btn-primary">Change Password </button>
                                    <!-- <a href="javascript:;" action-modal="#2FactorAuthentication" class="btn btn-sm btn-light ml-2">
                                        Enable 2(FA) Two Factor Authentication
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal" id="changePassword">
            <div class="modal-dialog">
                <div class="modal-content p-4">
                    <form action="" method="post">
                        <div class="text-center">
                            <h3 class="title">Change Password</h3>
                        </div>
                        <div class="form-modal-body">
                            <input type="hidden" name="user_email" value="<?php echo $email; ?>">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                <div class="form-group form-box-inputs my-2">
                                    <input type="password" name="current_password" class="form-control" placeholder="Current Password"
                                    validate-field="true" validation-message="Please enter your current password">
                                </div>
                                <div class="form-group form-box-inputs my-2">
                                    <input type="password" name="password" class="form-control" placeholder="New Password"
                                    validate-field="true" validation-message="Password cannot be empty">
                                </div>
                                <div class="form-group form-box-inputs my-2">
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password"
                                    validate-field="true" validation-message="Confirm your password.">
                                </div>
                            </div>
                        </div>
                        <div class="form-modal-footer my-4">
                            <div class="text-center">
                                <span onclick="closemodal('changePassword')" class="btn btn-secondary">Cancel</span>
                                <input type="submit" name="change_password" class="btn btn-primary" value="Save Psssword">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <script type="text/javascript">
        function openmodal(id) {
            document.getElementById(id).style.display = 'block';
        }

        function closemodal(id){
            document.getElementById(id).style.display = 'none';
        }
    </script>

<?php } ?>
<?php include 'footer.php'; ?>