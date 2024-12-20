<style type="text/css">
#whatsapp-button {
  position: fixed;
  bottom: 20px;
  left: 20px;
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 60px;
  height: 60px;
/*  background-color: #25d366;*/
  border-radius: 50%;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out;
}

#whatsapp-button img {
/*  width: 35px;*/
/*  height: 35px;*/
}

#whatsapp-button:hover {
  transform: scale(1.1);
}

</style>
<a href="https://wa.me/<?php echo $row_general['site_phone'] ?>" target="_blank" id="whatsapp-button">
  <img src="assets/img/whatsapplogo.png" alt="WhatsApp" />
</a>
<div class="footer-top-area hm-4">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-md-4">
                        <div class="footer-logo">
                            <a href="">
                                <img width="144" height="60" src="assets/img/notwlogo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                     <div class="col-lg-3 col-md-4">
                        <div class="footer-socials">
                            <ul>
                                <!-- <li><a href="<?php //echo $row_general['site_linkedin'] ?>"><i class="fa fa-linkedin" style="color:#006ABB;"></i></a></li>
                                <li><a href="<?php //echo $row_general['site_twitter'] ?>"><i class="fa fa-twitter" style="color:#1C96E9;"></i></a></li> -->
                                <li><a href="<?php echo $row_general['site_insta'] ?>"><i class="fa fa-instagram" style="color:#D01688;"></i></a></li>
                                <li><a href="https://wa.me/<?php echo $row_general['site_phone'] ?>"><i class="fa fa-whatsapp" style="color:#46C355;"></i></a></li>
                                <li><a href="https://www.tiktok.com/@9ty9ine.xcix?_t=ZM-8sB3JllUsaL&_r=1"><img src="assets/img/tiktok.png" style="width: 15px;"></a></li>
                                <li><a href="https://snapchat.com/t/9uKLD12V"><i class="fa fa-snapchat" style="color:gold;"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4" style="display: none;">
                        <div class="news-letter-button">
                            <a data-bs-target="#newslatterModal" data-bs-toggle="modal" href="#">JOIN OUR NEWSLETTER</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER TOP AREA END -->
        <!-- FOOTER MIDDLE AREA START -->
        <div class="footer-middle hm-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="contact-info">
                            <h3 class="footer-title">CONTACT US</h3>
                            <div class="address-area">
                                <ul>
                                    <li>
                                        <a href="#"><i class="fa fa-map-marker" style="color:red;"></i>
                                        <span><?php echo $row_general['site_address'] ?></span></a>
                                    </li>
                                    <li>
                                        <a href="mailto:<?php echo $row_general['site_email'] ?>">
                                            <i class="fa fa-envelope"></i>
                                            <span><?php echo $row_general['site_email'] ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="tel:<?php echo $row_general['site_phone'] ?>"><i class="fa fa-phone" style="color:green;"></i>
                                        <span><?php echo $row_general['site_phone'] ?></span></a>
                                    </li>
                                </ul>
                             </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-menu">
                            <h3 class="footer-title">QUICK LINK</h3>
                            <ul>
                                <li><a href="policies">Policies</a></li>
                                <!-- <li><a href="terms">Terms and Conditions</a></li> -->
                                <li><a href="about">About Us</a></li>
                                <li><a href="contact">Contact</a></li>
                            </ul>
                         </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-menu">
                            <h3 class="footer-title">Sub LINK</h3>
                            <ul>
                                <li><a href="faq">FAQs</a></li>
                                <li><a href="shipping-and-returns">Shipping & Returns</a></li>
                            </ul>
                         </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER MIDDLE AREA END -->
        <!-- FOOTER BOTTOM AREA START -->
        <div class="footer-bottom hm-4">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="copy-right">
                            <center>
                                <div>©  <?php echo date("Y") ?> 9TY9INE</div>
                                Developed by <i class="fa fa-heart text-danger"></i><a href="https://wa.me/+2347030083673" target="_blank">Suave</a>
                            </center>
                        </div>
                    </div>
                    <div class="col-12 col-md-6" style="display: none;">
                        <div class="footer-socials">
                            <ul>
                                <li><a href="<?php echo $row_general['site_linkedin'] ?>"><i class="fa fa-linkedin" style="color:#006ABB;"></i></a></li>
                                <li><a href="<?php echo $row_general['site_twitter'] ?>"><i class="fa fa-twitter" style="color:#1C96E9;"></i></a></li>
                                <li><a href="https://www.instagram.com/high_chief_imoh/profilecard/?igsh=eTd2Z2Uya2ZyYTBy"><i class="fa fa-instagram" style="color:#D01688;"></i></a></li>
                                <li><a href="https://wa.me/+2347030083673"><i class="fa fa-whatsapp" style="color:#46C355;"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // const toggleDropdownCategory = document.getElementById('toggleDropdownCategory');
            // const dropdownMenuCategory = document.getElementById('dropdownMenuCategory');

            // const toggleDropdownFeature = document.getElementById('toggleDropdownFeature');
            // const dropdownMenuFeature = document.getElementById('dropdownMenuFeature');

            // const toggleDropdownMen = document.getElementById('toggleDropdownMen');
            // const dropdownMenuMen = document.getElementById('dropdownMenuMen');

            // const toggleDropdownWomen = document.getElementById('toggleDropdownWomen');
            // const dropdownMenuWomen = document.getElementById('dropdownMenuWomen');


            // toggleDropdownCategory.addEventListener('click', (event) => {
            //     event.preventDefault(); // Prevent the default link action
            //     if (dropdownMenuCategory.style.display === 'none' || dropdownMenuCategory.style.display === '') {
            //         dropdownMenuCategory.style.display = 'block';
            //     } else {
            //         dropdownMenuCategory.style.display = 'none';
            //     }
            // });


            // toggleDropdownFeature.addEventListener('click', (event) => {
            //     event.preventDefault(); // Prevent the default link action
            //     if (dropdownMenuFeature.style.display === 'none' || dropdownMenuFeature.style.display === '') {
            //         dropdownMenuFeature.style.display = 'block';
            //     } else {
            //         dropdownMenuFeature.style.display = 'none';
            //     }
            // });

            // toggleDropdownMen.addEventListener('click', (event) => {
            //     event.preventDefault(); // Prevent the default link action
            //     if (dropdownMenuMen.style.display === 'none' || dropdownMenuMen.style.display === '') {
            //         dropdownMenuMen.style.display = 'block';
            //     } else {
            //         dropdownMenuMen.style.display = 'none';
            //     }
            // });

            // toggleDropdownWomen.addEventListener('click', (event) => {
            //     event.preventDefault(); // Prevent the default link action
            //     if (dropdownMenuWomen.style.display === 'none' || dropdownMenuWomen.style.display === '') {
            //         dropdownMenuWomen.style.display = 'block';
            //     } else {
            //         dropdownMenuWomen.style.display = 'none';
            //     }
            // });


            // document.addEventListener('click', (event) => {
            //     if (!toggleDropdownCategory.contains(event.target) && !dropdownMenuCategory.contains(event.target)) {
            //         dropdownMenuCategory.style.display = 'none';
            //     }
            // });

            // document.addEventListener('click', (event) => {
            //     if (!toggleDropdownFeature.contains(event.target) && !dropdownMenuFeature.contains(event.target)) {
            //         dropdownMenuFeature.style.display = 'none';
            //     }
            // });

            // document.addEventListener('click', (event) => {
            //     if (!toggleDropdownMen.contains(event.target) && !dropdownMenuMen.contains(event.target)) {
            //         dropdownMenuMen.style.display = 'none';
            //     }
            // });

            // document.addEventListener('click', (event) => {
            //     if (!toggleDropdownWomen.contains(event.target) && !dropdownMenuWomen.contains(event.target)) {
            //         dropdownMenuWomen.style.display = 'none';
            //     }
            // });

        </script>
        <script type="text/javascript">
            // const sliderContainer_mobile = document.querySelector('.slider-container_mobile');
            // const slides_mobile = document.querySelectorAll('.slide_mobile');
            // let currentIndex_mobile = 0;

            // function updateSlider() {
            //   sliderContainer_mobile.style.transform = `translateX(-${currentIndex_mobile * 50}%)`;
            // }

            // setInterval(() => {
            //   currentIndex_mobile = (currentIndex_mobile + 1) % slides_mobile.length; // Loop back to first slide
            //   updateSlider();
            // }, 3000);

            const sliderContainer_mobile = document.querySelector('.slider-container_mobile');
            const slides_mobile = document.querySelectorAll('.slide_mobile');
            let currentIndex_mobile = 0;

            // Update slider width to accommodate 4 slides
            sliderContainer_mobile.style.width = `${slides_mobile.length * 100}%`;

            // Function to update slide position
            function updateSlider() {
                sliderContainer_mobile.style.transform = `translateX(-${currentIndex_mobile * (100 / slides_mobile.length)}%)`;
            }

            // Automatic sliding every 3 seconds
            setInterval(() => {
                currentIndex_mobile = (currentIndex_mobile + 1) % slides_mobile.length; // Loop back to the first slide
                updateSlider();
            }, 3000);


        </script>
        <script type="text/javascript">
            document.getElementById("carttotal2").innerHTML = document.getElementById("cartSpan").innerHTML;
        </script>


        <script type="text/javascript">
            function searchCheck(){
              const xhttp = new XMLHttpRequest();
              var query = document.getElementById('search').value;
              var currentDate = new Date();
              document.getElementById('resultBox').style.display = 'block';
              xhttp.onload = function() {
                  document.getElementById('resultBox').innerHTML = this.responseText
              }
              xhttp.open("GET", "xhttp.php?searchquery="+ query +"&currentdate="+ currentDate);
              xhttp.send();
            }
          </script>


          <script type="text/javascript">
              function country_select() {
                  const xhttp = new XMLHttpRequest();
                  var country = document.getElementById("country").value;
                  var currentDate = new Date();
                  xhttp.onload = function() {
                    document.getElementById("state_call").innerHTML =
                    this.responseText;
                  }
                  xhttp.open("GET", "xhttp?country=" + country + "&currentdate="+ currentDate);
                  xhttp.send();
              }
          </script>


          <script type="text/javascript">
              function addtocart(data) {
                  const xhttp = new XMLHttpRequest();
                  var parts = data.split('_');
                  var productId = parts[1];
                  var currentDate = new Date();
                  var qty = document.getElementById('product_qty' + parts[1] + '_' + parts[2]).value;
                  // alert(data + " | " + productId + "---" + qty);
                  xhttp.onload = function() {
                    if(this.responseText == 1){
                      document.getElementById("succesAlert").style.display = "block";
                      //document.getElementById("remove" + data).style.display = "block";
                      document.getElementById(data).style.display = "block";
                      document.getElementById("add" + data).style.display = "none";
                      document.getElementById('product_qty' + parts[1] + '_' + parts[2]).style.display = 'block';
                      setTimeout( function() { document.getElementById("succesAlert").style.display = "none"; }, 2000);
                      checkCartno(productId);
                      checkCartTotal(productId);
                      cartsidebar();
                      document.getElementById("carttotal2").innerHTML = document.getElementById("cartSpan").innerHTML;
                    }
                  }
                  xhttp.open("GET", "xhttp?addtocart=1&productId=" + productId + "&qty=" + qty + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                  xhttp.send();
              }
              function removefromcart(data) {
                  const xhttp = new XMLHttpRequest();
                  var parts = data.split('_');
                  var productId = parts[1];
                  var currentDate = new Date();
                  //alert(data + " | " + productId + "---" + qty);
                  xhttp.onload = function() {
                    if(this.responseText == 1){
                      document.getElementById("removalAlert").style.display = "block";
                      document.getElementById("remove" + data).style.display = "none";
                      document.getElementById("add" + data).style.display = "block";
                      setTimeout( function() { document.getElementById("removalAlert").style.display = "none"; }, 2000);
                      checkCartno(productId);
                      checkCartTotal(productId);
                      cartsidebar();
                    }
                  }
                  xhttp.open("GET", "xhttp?removefromcart=1&productId=" + productId + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                  xhttp.send();
              }
              function removefromcartsidebar(data) {
                  const xhttp = new XMLHttpRequest();
                  var parts = data.split('_');
                  var productId = parts[1];
                  var currentDate = new Date();
                  //alert(data + " | " + productId + "---" + qty);
                  xhttp.onload = function() {
                    if(this.responseText == 1){
                      document.getElementById("removalAlert").style.display = "block";
                      setTimeout( function() { document.getElementById("removalAlert").style.display = "none"; }, 2000);
                      checkCartno(productId);
                      checkCartTotal(productId);
                      cartsidebar();
                    }
                  }
                  xhttp.open("GET", "xhttp?removefromcart=1&productId=" + productId + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                  xhttp.send();
              }
              function checkCartno(productId){
                  const xhttp = new XMLHttpRequest();
                  var currentDate = new Date();
                  xhttp.onload = function() {
                    document.getElementById("cartSpan").innerHTML = this.responseText;
                    document.getElementById("carttotal2").innerHTML = this.responseText;
                  }
                  xhttp.open("GET", "xhttp?checkCart=1&productId=" + productId + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                  xhttp.send();
              }
              function checkCartTotal(productId){
                  const xhttp = new XMLHttpRequest();
                  var currentDate = new Date();
                  xhttp.onload = function() {
                    document.getElementById("cartSpanTotal").innerHTML = this.responseText;
                  }
                  xhttp.open("GET", "xhttp?checkCartTotal=1&productId=" + productId + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                  xhttp.send();
              }
              function cartsidebar(){
                const xhttp = new XMLHttpRequest();
                var currentDate = new Date();
                xhttp.onload = function() {
                  document.getElementById("cardsidebar").innerHTML = this.responseText;
                  document.getElementById("cardsidebar2").innerHTML = this.responseText;
                }
                xhttp.open("GET", "xhttp?cartsidebar=1&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                xhttp.send();
              }
          </script>

          <script type="text/javascript">
              function quantityChange(data, id) {
                var qty = document.getElementById(id).value;
                var currentDate = new Date();
                document.getElementById(data).setAttribute('data-qty', qty);
                  if(qty != ''){
                    if(qty < 1){
                        var parts2 = id.split('_');
                        var parts = data.split('_');
                        removefromcart('product_' +  parts[1] + '_' + parts2[2]);
                        document.getElementById('product_qty' +  parts[1] + '_' + parts2[2]).style.display = "none";
                    }else{

                        const xhttp = new XMLHttpRequest();
                        var parts = data.split('_');
                        var parts2 = id.split('_');
                        var productId = parts[1];
                        var qty = document.getElementById('product_qty' + parts[1] + '_' + parts2[2]).value;
                        //alert(data + " | " + productId + "---" + qty);
                        xhttp.onload = function() {
                          if(this.responseText == 1){
                            document.getElementById("succesAlert").style.display = "block";
                            setTimeout( function() { document.getElementById("succesAlert").style.display = "none"; }, 2000);
                            cartsidebar();
                          }
                        }
                        xhttp.open("GET", "xhttp?quantityChange=1&productId=" + productId + "&qty=" + qty + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                        xhttp.send();
                    }
                  }
              }
              
              function sidecart_quantityChange(data, id) {
                var qty = document.getElementById(id).value;
                var currentDate = new Date();
                // document.getElementById(data).setAttribute('data-qty', qty);
                
                if(qty < 1){
                    var parts2 = id.split('_');
                    var parts = data.split('_');
                    removefromcart('product_' +  parts[1] + '_' + parts2[2]);
                    document.getElementById('sideccart_' +  parts[1] + '_' + parts2[2]).style.display = "none";
                    document.getElementById('product_qty' +  parts[1] + '_' + parts2[2]).style.display = "none";
                }else{

                    const xhttp = new XMLHttpRequest();
                    var parts = data.split('_');
                    var parts2 = id.split('_');
                    var productId = parts[1];
                    var qty = document.getElementById('sidecartproduct_qty' + parts[1] + '_' + parts2[2]).value;
                    //alert(data + " | " + productId + "---" + qty);
                    xhttp.onload = function() {
                      if(this.responseText == 1){
                        document.getElementById("succesAlert").style.display = "block";
                        setTimeout( function() { document.getElementById("succesAlert").style.display = "none"; }, 2000);
                        cartsidebar();
                      }
                    }
                    xhttp.open("GET", "xhttp?quantityChange=1&productId=" + productId + "&qty=" + qty + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                    xhttp.send();
                }
              }
              
              function cart_quantityChange(data, id) {
                var qty = document.getElementById(id).value;
                var currentDate = new Date();
                // document.getElementById(data).setAttribute('data-qty', qty);
                
                if(qty < 1){
                    var parts2 = id.split('_');
                    var parts = data.split('_');
                    removefromcart('product_' +  parts[1] + '_' + parts2[2]);
                    document.getElementById('sideccart_' +  parts[1] + '_' + parts2[2]).style.display = "none";
                    document.getElementById('product_qty' +  parts[1] + '_' + parts2[2]).style.display = "none";
                }else{

                    const xhttp = new XMLHttpRequest();
                    var parts = data.split('_');
                    var parts2 = id.split('_');
                    var productId = parts[1];
                    var qty = document.getElementById('cartproduct_qty' + parts[1] + '_' + parts2[2]).value;
                    //alert(data + " | " + productId + "---" + qty);
                    xhttp.onload = function() {
                      if(this.responseText == 1){
                        document.getElementById("succesAlert").style.display = "block";
                        setTimeout( function() { document.getElementById("succesAlert").style.display = "none"; }, 2000);
                        cartsidebar();
                      }
                    }
                    xhttp.open("GET", "xhttp?quantityChange=1&productId=" + productId + "&qty=" + qty + "&currentdate="+ currentDate + "&sessionId=<?php echo $sessionId ?><?php if(!empty($email)){ ?>&email=<?php if(!empty($email)){ echo $email; } ?><?php } ?>");
                    xhttp.send();
                }
              }
              function showsidecart(){
                document.getElementById("cartsidebarmain").style.display = "block";
              }
              function closesidecart(){
                document.getElementById("cartsidebarmain").style.display = "none";
              }
          </script>


        <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
		<!-- bootstrap js -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- Nivo slider js -->        
        <script src="assets/custom-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
        <script src="assets/custom-slider/home.js" type="text/javascript"></script>
		<!-- owl.carousel js -->
        <script src="assets/js/owl.carousel.min.js"></script>
		<!-- meanmenu js -->
        <script src="assets/js/jquery.meanmenu.js"></script>
		<!-- jquery-ui js -->
        <script src="assets/js/jquery-ui.min.js"></script>
        <!-- jquery.mixitup js -->
        <script src="assets/js/jquery.mixitup.min.js"></script>
        <!-- fancybox js -->
        <script src="assets/js/fancybox/jquery.fancybox.pack.js"></script>
        <!-- jquery.counterup js -->
        <script src="assets/js/jquery.counterup.min.js"></script>
        <script src="assets/js/waypoints.js"></script>
        <!-- elevateZoom js -->
        <script src="assets/js/jquery.elevateZoom-3.0.8.min.js"></script>
        <!-- jquery.bxslider.min.js -->       
        <script src="assets/js/jquery.bxslider.min.js"></script>
		<!-- wow js -->
        <script src="assets/js/wow.min.js"></script>
		<!-- plugins js -->
        <script src="assets/js/plugins.js"></script>
		<!-- main js -->
        <script src="assets/js/main.js"></script>
    </body>
 
</html>