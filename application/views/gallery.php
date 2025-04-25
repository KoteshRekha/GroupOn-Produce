<?php include('header.php'); ?>
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Services</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Gallery  -->
    <div class="products-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>Shop</h1>
                        <p>A vibrant glimpse of fresh produce, dedicated farmers, and the journey from field to table.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="special-menu text-center">
                        <?php 
$filter = isset($_GET['filter']) ? $_GET['filter'] : ''; 
?>
                        <div class="button-group filter-button-group">
                            <button class="<?php echo ($filter == '') ? 'active' : ''; ?>" data-filter="*">All</button>
   
                               <button class="<?php echo ($filter == 'fruits') ? 'active' : ''; ?>" data-filter=".fruits">Fruits</button>
  
                            <button class="<?php echo ($filter == 'vegetables') ? 'active' : ''; ?>" data-filter=".vegetables">Vegetables</button>
							
						  <button class="<?php echo ($filter == 'dairy-products') ? 'active' : ''; ?>" data-filter=".dairy-products">Dairy Products</button>
</div>
                    </div>
                </div>
            </div>

            <div class="row special-list">
                <?php if (!empty($latest_products)): ?>
                <?php foreach ($latest_products as $product): ?>
                    <?php 
                        // Convert category name to lowercase and replace spaces with hyphens for filtering
                        $category_class = strtolower(str_replace(' ', '-', $product->category)); 
                    ?>
                    <?php if ($product->stock > 0): ?>
                    <div class="col-lg-3 col-md-6 special-grid <?= $category_class; ?>">
                        <div class="products-single fix">
                            <div class="box-img-hover">
                                <div class="type-lb">
                                    <p class="sale">Sale</p>
                                </div>
                                <img src="<?= base_url($product->image ? $product->image : 'assets/images/default-product.jpg'); ?>" 
                                     class="img-fluid" alt="<?= htmlspecialchars($product->product_name); ?>">
                                <div class="mask-icon">
                                <!--    <ul>
                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    </ul>-->

                                     <a class="cart add-to-cart" 
       data-id="<?= $product->id; ?>" 
       data-name="<?= $product->product_name; ?>" 
       data-price="<?= $product->price; ?>" 
       data-stock="<?= $product->stock; ?>" 
       data-image="<?= $product->image; ?>" 
       href="javascript:void(0);">
       Add to Cart
    </a>
    <?php else: ?>
        <div class="col-lg-3 col-md-6 special-grid <?= $category_class; ?>">
                        <div class="products-single fix">
                            <div class="box-img-hover">
                                <div class="type-lb">
                                    <p class="sale">Out Of Stock</p>
                                </div>
                                <img src="<?= base_url($product->image ? $product->image : 'assets/images/default-product.jpg'); ?>" 
                                     class="img-fluid" alt="<?= htmlspecialchars($product->product_name); ?>">
                                <div class="mask-icon">
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                            <div class="why-text">
                                <h4><?= htmlspecialchars($product->product_name); ?></h4>
                                <h5>$<?= number_format($product->price, 2); ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>

         
      
            </div>
        </div>
    </div>
    <!-- End Gallery  -->
    <?php include('footer.php'); ?>
