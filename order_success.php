

<div class="container">
    <div class="row d-flex justify-content-center">
    <?php
        $queryOrders = mysqli_query($conn, "SELECT po.ref AS ref, po.dated AS dated, po.status AS status, po.full_name AS full_name, po.address AS address, po.state AS state, po.country AS country, po.phone AS phone, po.updated_at AS updated_at, tl.payment_method AS payment_method, tl.amount AS amount FROM product_order po JOIN transaction_log tl ON po.ref = tl.reference WHERE po.ref = '$reference' GROUP BY po.ref");
		if(mysqli_num_rows($queryOrders) > 0){
			$rowOrders = mysqli_fetch_array($queryOrders);
    ?>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 p-5 bg-white border-radius">
                    <div class="text-center">
                        <i class="pe-7s-check so-icon text-success"></i>
                        <h5>YOUR ORDER(S) HAS BEEN PLACED SUCCESSFULLY</h5>
                    </div>
                    <div class="order-details bg-light border-radius p-4 mt-5">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6><b> Date: <?php echo $rowOrders['dated'] ?></b></h6>
                                    <h6 class="mt-5"><b>Status</b></h6>
                                    <p class="m-0"> 
                                        <span class="">Received</span> 
                                    </p>
    
                                </div>
                                <div class="col-md-4">
                                    <h6><b>Delivery Address</b></h6>
                                    <h5 class="mb-0" ><?php echo $rowOrders['full_name'] ?></h5>
                                    <p class="m-0">
                                        <small>
                                            <?php echo $rowOrders['address'].",".$rowOrders['state'].",".$rowOrders['country'] ?>
                                        </small>
                                    </p>
                                    <p class="m-0">
                                        <small>
                                            <?php echo $rowOrders['state'] ?>
                                        </small>
                                    </p>
                                    <p> <small><b>Phone:</b> <?php echo $rowOrders['phone'] ?></small> </p>
    
                                    <h6 class="mt-4"><b>Delivery Time</b></h6>
                                    <p class="m-0">
                                        <?php
                                            echo date('j M', strtotime($rowOrders['dated'] . ' + 3 days')) ." & ".date('j M', strtotime($rowOrders['dated'] . ' + 6 days'));
                                        ?>
                                        
                                        <div><?php echo $reference ?></div>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h6><b>Total Amount</b></h6>
                                    <p class="m-0">&#8358;<?php echo $rowOrders['amount'] ?></p>
    
                                    <h6 class="mt-5"><b>Payment Method</b></h6>
                                    <p class="m-0"><?php echo $rowOrders['payment_method'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light border-radius p-4 mt-2">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6><b>Ordered Item(s)</b></h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <?php
                                            $query_view = mysqli_query($conn, "SELECT p.discount AS discount, p.name AS name, p.price AS price, po.qty AS qty, i.image AS image, po.amount AS amount, p.price AS price, p.id AS id FROM product_order po JOIN product p ON po.products = p.id JOIN product_images i ON i.token = p.image_token WHERE po.ref = '$reference' GROUP BY p.id");
                                            $sn = 1;
                                            if(mysqli_num_rows($query_view) > 0){
                                                while($row = mysqli_fetch_array($query_view)){
                                        ?>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex bg-white border-radius p-3">
                                                    <div class="item-image">
                                                        <a href="../details?id=<?php echo $row['id']; ?>">
                                                            <img src="../product_images/<?php echo $row['image'] ?>" alt="" width="100px">
                                                        </a>
                                                    </div>
                                                    <div class="product-details ml-2">
                                                        <a href="../details?id=<?php echo $row['id']; ?>">
                                                            <p><?php echo $row['name']; ?></p>
                                                        </a>
                                                        <div class="d-flex">
                                                            <div class="price-details">
                                                            
                                                                <?php if($row['discount'] > 0){
                                                                  $slashed = $row['discount'] * $row['price'];
                                                                  $slashed = $slashed / 100;
                                                                  $slashed = $row['price'] - $slashed;
                                                                  echo number_format($slashed, 2);
                                                                }else{ echo '<b>₦'.number_format($row['price'], 2).'</b>'; } ?></div>
                                                             <div class="gray mr1 f7 f6-l"><s>
                                                               <?php 
                                                                if($row['discount'] > 0){
                                                                  $slashed = $row['discount'] * $row['price'];
                                                                  $slashed = $slashed / 100;
                                                                  $slashed = $row['price'] + $slashed;
                                                                  echo '₦'.number_format($slashed, 2);
                                                                }
                                                               ?></s>
                                                            </div>
                                                            <p class="mt-0 mb-1 ml-3"><small><b>Qty:</b> <?php echo $row['qty']; ?></small></p>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>