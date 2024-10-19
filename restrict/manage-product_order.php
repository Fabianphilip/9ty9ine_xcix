<?php include 'header.php' ?>
<?php if(!empty($email)){ ?>
<div class="container mt-4">

<?php              
    $view = get_input($conn, 'view');
    $approve = get_input($conn, 'approve');
    $pn = get_input($conn, 'pn');
    $success = get_input($conn, 'success');
    $error = get_input($conn, 'error');


    if(!empty($approve)){
        $updateProduct = mysqli_query($conn, "UPDATE product_order SET status = 'delivered' WHERE ref = '$approve'");
    }

    $reference_search = tp_input($conn, "reference_search");
    $email_search = tp_input($conn, "email_search");
    $dated_search = tp_input($conn, "dated_search");
    $where = "WHERE id > '0'";
    $where .= (!empty($reference_search))?" AND reference = '$reference_search'":"";
    $where .= (!empty($email_search))?" AND email = '$email_search'":"";
    $where .= (!empty($dated_search))?" AND DATE(dated) = '$dated_search'":"";

    
    
    $result = mysqli_query($conn, "SELECT * FROM product_order {$where} GROUP BY ref");
    $count = mysqli_num_rows($result);
    $per_view = 40;
    $per_view = (!empty($no_of_rows))?$no_of_rows:$per_view;
    $page_link = "restrict/manager-product_order?pn=";
    $link_suffix = "";
    $style_class = "";
    page_numbers();
    $offset = ($per_view * $pn) - $per_view;
    
    $result = mysqli_query($conn, "SELECT * FROM product_order $where GROUP BY ref ORDER BY id DESC LIMIT {$offset},{$per_view}");
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
                                <h4>Management Product Order</h4>
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
                                                <th>Ref</th>
                                                <th>Email</th>
                                                <th>Country</th>
                                                <th>state</th>
                                                <th>Phone</th>
                                                <th>dated</th>
                                                <th>Delivery Status</th>
                                                <th>Pay status</th>
                                                <th>Action</th>
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
                                                                <td><?php echo $row['ref']; ?></td>
                                                                <td><?php echo $row['email']; ?></td>
                                                                <td><?php echo $row['country']; ?></td>
                                                                <td><?php echo $row['state']; ?></td>
                                                                <td><?php echo $row['phone']; ?></td>
                                                                <td><?php echo $row['dated']; ?></td>
                                                                <td><?php echo $row['status'] ?></td>
                                                                <td><?php echo $row['pay_status']; ?></td>
                                                                <td>
                                                                    <div class="row d-flex" style="width: 200px;">
                                                                        <div class="col-auto px-0"><a href="manage-product_order?approve=<?php echo $row['ref'] ?>" class="btn btn-primary m-1"><i class="fa fa-check"></i> Approve Delivery</a></div>
                                                                        <div class="col-auto px-0"><a href="manage-product_order?view=<?php echo $row['ref'] ?>" class="btn btn-primary m-1"><i class="fa fa-eye"></i></a></div>
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
                                $query_view = mysqli_query($conn, "SELECT * FROM product_order WHERE ref = '$view' LIMIT 1");
                                $row = mysqli_fetch_array($query_view);
                            ?>
                            <div class="col-md-4 p-2 my-0">
                                <h4>View Product Order</h4>
                            </div>
                            <div class="col-md-8 p-2 my-0">
                                <a href="manage-product_order" class="btn btn-primary float-right mx-2" style="float: right;"> Go Back </a>
                            </div>
                            <hr>
                            
                            <div class="col-md-12">
                                <div class="card p-4" >
                                    <div class="row">
                                        <div class="col-auto"><div>Reference:</div><div><?php echo $row['ref'] ?></div></div>
                                        <div class="col-auto"><div>User:</div><div><?php echo $row['user_id'] ?></div></div>
                                        <div class="col-auto"><div>Full name:</div><div><?php echo $row['full_name'] ?></div></div>
                                        <div class="col-auto"><div>Email:</div><div><?php echo $row['email'] ?></div></div>
                                        <div class="col-auto"><div>Phone:</div><div><?php echo $row['phone'] ?></div></div>
                                        <div class="col-auto"><div>Country:</div><div><?php echo $row['country'] ?></div></div>
                                        <div class="col-auto"><div>State:</div><div><?php echo $row['state'] ?></div></div>
                                        <div class="col-auto"><div>Address:</div><div><?php echo $row['address'] ?></div></div>
                                        <div class="col-auto"><div>Pay status:</div><div><?php echo $row['pay_status'] ?></div></div>
                                        <div class="col-auto"><div>dated:</div><div><?php echo $row['dated'] ?></div></div>

                                    </div><hr>
                                    <div style="width: 100%; overflow-x: scroll;">
                                        <table class="table" id="table">
                                            <thead>
                                                <th>Sn</th>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $query_view = mysqli_query($conn, "SELECT p.name AS name, p.price AS price, po.qty AS qty, i.image AS image, po.amount AS amount FROM product_order po JOIN product p ON po.products = p.id JOIN product_images i ON i.token = p.image_token WHERE ref = '$view'");
                                                    $sn = 1;
                                                    if(mysqli_num_rows($query_view) > 0){
                                                        while($row = mysqli_fetch_array($query_view)){
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sn++; ?></td>
                                                                <td><img src="../product_images/<?php echo $row['image']; ?>" style="width: 50px" alt="Product Image"> <?php echo $row['name']; ?></td>
                                                                <td><?php echo $row['qty']; ?></td>
                                                                <td><?php echo $row['amount']." ".$row['qty']." (".$row['price'].")"; ?></td>
                                                            </tr>
                                                            <?php
                                                        }$sn;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
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