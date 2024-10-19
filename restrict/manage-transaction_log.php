<?php include 'header.php' ?>
<?php if(!empty($email)){ ?>
<div class="container mt-4">

<?php              
    $view = get_input($conn, 'view');
    $pn = get_input($conn, 'pn');
    $success = get_input($conn, 'success');
    $error = get_input($conn, 'error');

    $reference_search = tp_input($conn, "reference_search");
    $email_search = tp_input($conn, "email_search");
    $dated_search = tp_input($conn, "dated_search");
    $where = "WHERE id > '0'";
    $where .= (!empty($reference_search))?" AND reference = '$reference_search'":"";
    $where .= (!empty($email_search))?" AND email = '$email_search'":"";
    $where .= (!empty($dated_search))?" AND DATE(dated) = '$dated_search'":"";

    
    
    $result = mysqli_query($conn, "SELECT * FROM transaction_log {$where}");
    $count = mysqli_num_rows($result);
    $per_view = 40;
    $per_view = (!empty($no_of_rows))?$no_of_rows:$per_view;
    $page_link = "restrict/manager-transaction_log?pn=";
    $link_suffix = "";
    $style_class = "";
    page_numbers();
    $offset = ($per_view * $pn) - $per_view;
    
    $result = mysqli_query($conn, "SELECT * FROM transaction_log $where ORDER BY id DESC LIMIT {$offset},{$per_view}");
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
                        <?php if(empty($view)){ ?>
                            <div class="col-md-6 p-2 my-0">
                                <h4>Management Transaction Logs</h4>
                            </div>
                            <div class="col-md-6 p-2 my-0">
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <div class="card p-4" style="background: rgba(0, 0, 0, .3);">
                                        <h4>Search By</h4>
                                        <form method="POST" action="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div>Email</div>
                                                    <input type="text" name="email_search" class="form-control" placeholder="Email">
                                                </div>
                                                <div class="col-md-6">
                                                    <div>Reference</div>
                                                    <input type="text" name="reference_search" class="form-control" placeholder="reference">
                                                </div>
                                                <div class="col-md-6">
                                                    <div>Date</div>
                                                    <input type="date" name="dated_search" class="form-control" placeholder="Date">
                                                </div>
                                                <div class="col-md-6">
                                                    <div>..</div>
                                                    <input type="submit" name="search" class="btn btn-primary" style="float: right;" value="Search">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div style="width: 100%; overflow-x: scroll;">
                                        <table class="table" id="table">
                                            <thead>
                                                <th>Sn</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                                <th>Reference</th>
                                                <th>Paymant Method</th>
                                                <th>Dated</th>
                                                <th style="width: 100px;">Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    //$query_shop = mysqli_query($conn, "SELECT * FROM shop ORDER BY id DESC");
                                                    $sn = 1;
                                                    if(mysqli_num_rows($result) > 0){
                                                        while($row = mysqli_fetch_array($result)){
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sn++; ?></td>
                                                                <td><?php echo $row['email']; ?></td>
                                                                <td><?php echo $row['amount']; ?></td>
                                                                <td><?php echo $row['reference']; ?></td>
                                                                <td><?php echo $row['payment_method']; ?></td>
                                                                <td><?php echo $row['dated']; ?></td>
                                                                <td>
                                                                    <div class="row d-flex" style="width: 70px;">
                                                                        <div class="col-auto px-0"><a href="manage-transaction_log?view=<?php echo $row['id'] ?>" class="btn btn-primary m-1"><i class="fa fa-eye"></i></a></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }$sn;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if(mysqli_num_rows($result) > 0){ echo ($last_page>1)?"<div class=\"page-nos\">" . $center_pages . "</div>":""; } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(!empty($view)){ ?>
                            <?php
                                $query_view = mysqli_query($conn, "SELECT * FROM transaction_log WHERE id = '$view'");
                                $row = mysqli_fetch_array($query_view);
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View Transaction Log</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-transaction_log" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                            
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <div class="row">
                                        <div class="col-md-3">Id:</div><div class="col-md-9"><?php echo $row['id'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Email:</div><div class="col-md-9"><?php echo $row['email'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Amount:</div><div class="col-md-9"><?php echo $row['amount'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Reference:</div><div class="col-md-9"><?php echo $row['reference'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Payment Mathod:</div><div class="col-md-9"><?php echo $row['payment_method'] ?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-md-3">Dated:</div><div class="col-md-9"><?php echo $row['dated'] ?></div>
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
        
    </script>
<?php } ?>
<?php include 'footer.php'; ?>