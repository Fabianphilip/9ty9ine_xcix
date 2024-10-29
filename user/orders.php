<?php include 'header.php'; ?>
<?php if(!empty($email)){ ?>
<?php
	$view = get_input($conn, 'view');
	$track = get_input($conn, 'track');
?>
    <div class="col-md-12">
	    <div class="page-title col-md-12 border-radius mt-4">
            <div class="row">
                <div class="d-flex">
                    <div class="title">
    	                <h5>Dashboard - <small>Orders</small> </h5>
    	            </div>
    	        </div>
    	    </div>
        </div>
        

        <div class="row">
            <div class="col-md-12">
                <!-- <div class="order-title mb-3">
                    <h5>Order History</h5>
                </div> -->
                <?php if(empty($view) && empty($track)){ ?>
                    <div class="card p-4">
                        <?php 
                        	$queryOrders = mysqli_query($conn, "SELECT p.price AS price, po.ref AS ref, p.name AS name, po.pay_status AS pay_status, po.email AS email, po.status AS status, (SELECT GROUP_CONCAT(image ORDER BY id ASC) FROM product_images i WHERE i.token = p.image_token) AS images, p.image_token AS image_token FROM product_order po JOIN product p ON po.products = p.id JOIN product_images pi ON p.image_token = pi.token WHERE po.email = '$email' AND po.pay_status = '1' GROUP BY po.ref");
                        	if(mysqli_num_rows($queryOrders) > 0){
                        		while($rowOrders = mysqli_fetch_array($queryOrders)){
                        			$ref = $rowOrders['ref'];
                        			$queryCount = mysqli_query($conn, "SELECT * FROM product_order WHERE email = '$email' AND pay_status = '1' AND ref = '$ref'");
                        			$count = mysqli_num_rows($queryCount);
                        			$images = explode(',', $rowOrders['images']);
                        	?>
                                <div class="row">
                                    <div class="col-md-12 border-bottom">
                                        <div class="order-box-card bg-white border-radius p-1">
                                            <div class="order-top-note">
                                                <p class="m-0 p-2">You have <?php echo $count ?> item(s) in this order.</p>
                                            </div>
                                            <div class="d-flex p-0">
                                                <div class="item-image desktop">
                                                    <img src="../product_images/<?php echo $images[0]; ?>" alt="" width="100px">
                                                </div>
                                                <div class="product-details ml-2 flex-fill">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="dtails">
                                                            <h6 class="mt-1 mb-2 m-0 text-muted">Order no. <?php echo $rowOrders['ref'] ?></h6>
                                                        </div>
                                                        <div class="actionbtns text-right mr-3">
                                                            	<span class=""><?php echo $rowOrders['status'] ?></span> 
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <p class="m-0"><?php echo $rowOrders['name'] ?></p>
                                                        
                                                        <p class="mt-1 m-0">
                                                            <b>&#8358;<?php echo $rowOrders['price'] ?></b>
                                                        </p>
                                                    </div>
                                                    <div class="">
                                                        <div class="text-right mr-3">
                                                            <a href="orders?view=<?php echo $rowOrders['ref']; ?>" class="text-primary">
                                                                <b>View details</b>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php }else{ ?>
                            <div class="text-center mt-5 pt-4">
                                <p class="m-0"><i class="flaticon2-box-1 text-primary" style="font-size: 60px;"></i></p>
                                <p> <strong>Hi!, <?php echo $row_user['full_name'] ?></strong> You have not placed any order yet.</p>
                                <a href="../shop" class="btn btn-primary btn-sm border-50">Get fantastic deals now</a>
                            </div>
                        <?php } ?>
                	<?php } ?>
                	<?php if(!empty($view)){ ?>

                		<?php
                			$queryOrders = mysqli_query($conn, "SELECT po.ref AS ref, po.dated AS dated, po.status AS status, po.full_name AS full_name, po.address AS address, po.state AS state, po.country AS country, po.phone AS phone, po.updated_at AS updated_at, tl.payment_method AS payment_method, tl.amount AS amount FROM product_order po JOIN transaction_log tl ON po.ref = tl.reference WHERE po.ref = '$view' GROUP BY po.ref");
                			if(mysqli_num_rows($queryOrders) > 0){
                				$rowOrders = mysqli_fetch_array($queryOrders);
                		?>

                		<div class="order-title mb-3 d-flex">
                            <a href="/users/orders" class="mr-2"> 
                                <i class="flaticon2-left-arrow-1" style="font-size: 17px;"></i> 
                            </a>
                            <h5>Order Details</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="row">
                                    <div class="col-md-4 mb-5">
                                        <h6><b>Order no. <?php echo $rowOrders['ref']; ?></b></h6>
                                        <span> Date: <?php echo $rowOrders['dated'] ?></span>
        
                                        <h6 class="mt-3"><b>Status</b></h6>
                                        <p class="m-0"> 
                                            <span class=""><?php echo $rowOrders['status'] ?></span> 
                                        </p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h6><b>Delivery Address</b></h6>
                                            <p class="mb-0">
                                                <b>
                                                    <?php echo $row_user['full_name'] ?>
                                                </b>
                                            </p>
                                            <p class="m-0">
                                                <small>
                                                    <?php echo $rowOrders['address'].", ".$rowOrders['state'].", ".$rowOrders['country']; ?>
                                                </small>
                                            </p>
                                            <p> <small><b>Phone:</b> <?php echo $rowOrders['phone']; ?></small> </p>

                                        <h6 class="mt-4"><b><?php echo $rowOrders['status'] ?> date</b></h6>
                                        <p class="m-0"> <?php echo $rowOrders['updated_at'] ?></p>

                                    </div>
        
                                    <div class="col-md-4">
                                        <h6><b>Payment Method</b></h6>
                                        <p class="m-0">
                                            <?php echo $rowOrders['payment_method'] ?>
                                        </p>
                                        
                                        <h6 class="mt-4"><b>Payment Details</b></h6>
                                        <p class="m-0">Amount: &#8358;<?php echo number_format($rowOrders['amount'], 2); ?></p>
                                        <p class="m-0">Shipping fee: &#8358;</p>
                                        <p class="m-0">
                                            <b>Total: &#8358;<?php echo number_format($rowOrders['amount'], 2); ?></b>
                                        </p>
        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 border-top">
                                <h5 class="text-underline mb-3 mt-3">Order items list</h5>
                                    <div class="row">
                                        <?php
                                            $query_view = mysqli_query($conn, "SELECT p.name AS name, p.price AS price, po.qty AS qty, i.image AS image, po.amount AS amount, p.price AS price, p.id AS id FROM product_order po JOIN product p ON po.products = p.id JOIN product_images i ON i.token = p.image_token WHERE ref = '$view'");
                                            $sn = 1;
                                            if(mysqli_num_rows($query_view) > 0){
                                                while($row = mysqli_fetch_array($query_view)){
                                        ?>

                                                    <div class="col-md-12 mb-2">
                                                <div class="order-box-card bg-white border-radius p-1">
                                                    <div class="d-flex p-0">
                                                        <div class="item-image desktop p-2">
                                                            <img src="../product_images/<?php echo $row['image'] ?>" alt="" width="100px">
                                                        </div>
                                                        <div class="product-details ml-2 flex-fill">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="">
                                                                    <p class="m-0"><?php echo $row['name']; ?></p>
                                                                    <p class="m-0 text-muted"><small>Item no. <?php echo $view ?></small></p>
                                                                    <p class="m-0">
                                                                        <b>&#8358;<?php echo number_format($row['price'], 2) ?></b>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-between">
                                                                <div class="">
                                                                    <div class="d-flex mt-2">
                                                                        <p class="mb-1"><small><b>Qty:</b> <?php echo $row['qty']; ?></small></p>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right mr-3">
                                                                    <a href="../details?id=<?php echo $row['id']; ?>" class="text-primary">
                                                                        <small><b>View details</b></small> 
                                                                    </a> |
                                                                    <a href="orders?track=<?php echo $view ?>" class="text-primary">
                                                                        <small><b>Status</b></small>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <?php
                                            }$sn;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- <ul>
                                    <li class="p-2 border-bottom"><a href="">Active Orders</a></li>
                                    <li class="p-2 border-bottom"><a href="">Completed Orders</a></li>
                                    <li class="p-2 border-bottom"><a href="">Cancelled Orders</a></li>
                                    <li class="p-2 border-bottom"><a href="">Returned Items</a></li>
                                </ul> -->
                            </div>
                        </div>
                    	<?php } ?>

                	<?php } ?>

                	<?php if(!empty($track)){ ?>
                		<?php
                			$queryOrders = mysqli_query($conn, "SELECT po.ref AS ref, po.dated AS dated, po.status AS status, po.full_name AS full_name, po.address AS address, po.state AS state, po.country AS country, po.phone AS phone, po.updated_at AS updated_at, tl.payment_method AS payment_method, tl.amount AS amount FROM product_order po JOIN transaction_log tl ON po.ref = tl.reference WHERE po.ref = '$view' GROUP BY po.ref");
                			if(mysqli_num_rows($queryOrders) > 0){
                				$rowOrders = mysqli_fetch_array($queryOrders);
                		?>

                		<div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div class="text-left d-flex">
                                        <a href="orders" class="mr-2"> 
                                            <i class="flaticon2-left-arrow-1" style="font-size: 17px;"></i> 
                                        </a>
                                    <h5>ORDER TRACKING</h5>
                                </div>
                            </div>
        
                            <div class="border border-radius p-4 mt-3 m-no-p">
							    <div class="col-md-12 order-tracking">
							        <div class="container">
							            <article class="card">
							                <header class="card-header"> My Orders / Tracking </header>
							                <div class="card-body">
							                    <h6>Item no. <?php echo $rowOrders['ref'] ?></h6>
							                    <article class="card">
							                        <div class="card-body row">
							                            <div class="col"> 
							                                <h6 class="mt-4"><b><?php echo $rowOrders['status'] ?> date</b></h6>
                                        					<p class="m-0"> <?php echo $rowOrders['updated_at'] ?></p>
							                            </div>
							                            <!-- <div class="col"> 
							                                <strong>Shipping bY:</strong>
							                                <br> BLUEDART, | <i class="fa fa-phone"></i> +1598675986 
							                            </div> -->
							                            <div class="col"> 
							                                <strong>Status:</strong> 
							                                <br><span class="">
							                                    <?php echo $rowOrders['status'] ?>
							                                </span> 
							                            </div>
							                            <div class="col"> 
							                                <strong>Tracking #:</strong> 
							                                <br> <?php echo $rowOrders['ref'] ?>
							                            </div>
							                        </div>
							                    </article>
							                    <div class="track m-4">
                                                    <style type="text/css">
                                                        .active{
                                                            padding: 10px;
                                                            background-color: green;
                                                            color: white;
                                                        }
                                                    </style>
							                        <span class="step-track <?php if($rowOrders['status'] == 'received' || $rowOrders['status'] == 'confirmed'){ ?> active <?php } ?>"> 
							                            <span class="icon"> <i class="flaticon2-box-1"></i> </span> <span class="text">Recieved</span> 
							                        </span>
							                        <span class="step-track <?php if($rowOrders['status'] == 'received' || $rowOrders['status'] == 'confirmed'){ ?> active <?php } ?>"> 
							                            <span class="icon"> <i class="fa fa-like"></i> </span> <span class="text">Order confirmed</span> 
							                        </span>
							                        <span class="step-track <?php if($rowOrders['status'] == 'received' || $rowOrders['status'] == 'confirmed' || $rowOrders['status'] == 'processing'){ ?> active <?php } ?>"> 
							                            <span class="icon"> <i class="flaticon-time-1"></i> </span> <span class="text"> Processing </span> 
							                        </span>
							                        <span class="step-track <?php if($rowOrders['status'] == 'received' || $rowOrders['status'] == 'confirmed' || $rowOrders['status'] == 'processing' || $rowOrders['status'] == 'processed'){ ?> active <?php } ?>"> 
							                            <span class="icon"> <i class="flaticon-time"></i> </span> <span class="text"> Processed </span> 
							                        </span>
							                        <span class="step-track <?php if($rowOrders['status'] == 'received' || $rowOrders['status'] == 'confirmed' || $rowOrders['status'] == 'processing' || $rowOrders['status'] == 'processed' || $rowOrders['status'] == 'shipped'){ ?> active <?php } ?>"> 
							                            <span class="icon"> <i class="flaticon2-delivery-truck"></i> </span> <span class="text"> Shipped </span> 
							                        </span>
							                        <span class="step-track <?php if($rowOrders['status'] == 'received' || $rowOrders['status'] == 'confirmed' || $rowOrders['status'] == 'processing' || $rowOrders['status'] == 'processed' || $rowOrders['status'] == 'delivered'){ ?> active <?php } ?>"> 
							                            <span class="icon"> <i class="flaticon2-check-mark"></i> </span> <span class="text">Delivered</span> 
							                        </span>
							                    </div>
							                    <hr>
							                    <div class="row">
						                            <?php
	                                                    $query_view = mysqli_query($conn, "SELECT p.name AS name, p.price AS price, po.qty AS qty, i.image AS image, po.amount AS amount, p.price AS price, p.id AS id FROM product_order po JOIN product p ON po.products = p.id JOIN product_images i ON i.token = p.image_token WHERE ref = '$view'");
	                                                    $sn = 1;
	                                                    if(mysqli_num_rows($query_view) > 0){
	                                                        while($row = mysqli_fetch_array($query_view)){
	                                                		?>
								                            <div class="col-md-6">
								                                <div class="d-flex bg-white border-radius p-2">
								                                    <div class="item-image">
								                                        <a href="../details?id=<?php echo $row['id']; ?>">
								                                            <img src="../product_images/<?php echo $row['image'] ?>" alt="" width="100px">
								                                        </a>
								                                    </div>
								                                    <div class="product-details ml-2">
								                                        <a href="../details?id=<?php echo $row['id']; ?>">
								                                            <p><?php echo $row['name']; ?></p>
								                                        </a>
								                                        <div class="track-status">
								                                            <div class="d-flex">
								                                                <div class="price-details">
								                                                    <b>&#8358;<?php echo $row['price']; ?></b>
								                                                </div>
								                                            </div>
								                                            <div class="d-flex mt-2">
								                                                <p class="mb-1"><small><b>Qty:</b> <?php echo $row['qty'] ?></small></p>
								                                            </div>
								                                        </div>
								                                    </div>
								                                </div>
								                            </div>
								                            <?php
	                                                        }$sn;
	                                                    }
	                                                ?>
							                    </div>
							                </div>
							            </article>
							        </div>
							    </div>
							</div>
		                </div>
                	<?php } } ?>
                </div>	
            </div>
        </div>

    </div>

<?php } ?>
<?php include 'footer.php'; ?>