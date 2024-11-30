<?php include 'header.php' ?>
<div class="page-header-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>About Us</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PAGE-HEADER-AREA-END -->
<!-- BREADCRUMB-AREA-START -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-menu">
                    <ul>
                        <li><a href="/">Home</a> | </li>
                        <li><span>About Us</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB-AREA-END -->
<!-- ABOUT-US-CONTENT-AREA-END -->
<div class="about-us-content-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title style-two">
                    <h2>ABOUT US</h2>
                </div>
            </div>
        </div>
        <div class="about-us-content">
            <div class="row ">
                <div class="col-lg-8">
                    <div class="card p-4">
                        <div class="about-us-text">
                            <?php echo html_entity_decode($row_general['about']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>