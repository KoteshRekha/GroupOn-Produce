<?php include('header.php')?>

<div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                     <h2>Search Results</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<div class="products-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Title / Heading -->
                <div class="title-all text-center">
                   
                    <p>Here are the items we found that match your query.</p>
                </div>
            </div>
        </div>
        <div class="row special-list">
            <!-- Suppose you loop through each result item here -->
            <!-- e.g. in PHP: foreach ($results as $item) { ... } -->
            <?php if (!empty($results)): ?>
    <ul>
    <?php foreach ($results as $row): ?>

    <div class="col-lg-3 col-md-6 special-grid">
    <div class="products-single fix">
        <div class="box-img-hover">
            <div class="type-lb">
                <p class="sale">Sale</p>
            </div>
            <img src="<?php echo base_url(); ?><?= $row->image; ?>" class="img-fluid" alt="Image">
            <div class="mask-icon">
                <ul>
                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                </ul>
                <a class="cart add-to-cart" 
                   data-id="<?= $row->id; ?>" 
                   data-name="<?= $row->product_name; ?>" 
                   data-price="<?= $row->price; ?>" 
                   data-image="<?= $row->image; ?>" 
                   href="javascript:void(0);">
                   Add to Cart
                </a>
            </div>
        </div>
        <!-- Add product name (and optional price) below the image -->
        <div class="why-text">
            <h4><?= htmlspecialchars($row->product_name); ?></h4>
            <!-- Uncomment below if you want to show price as well -->
           <h5>$<?= number_format($row->price, 2); ?></h5> 
        </div>
    </div>
</div>

           
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No Results Found</p>
<?php endif; ?>

   </div>
   </div>


        <?php include('footer.php')?>
