<?php include('header.php')?>
 <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Cart</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active">Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table" id="cart_table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>

               
    <?php if (!empty($cart_items)): ?>
        <?php foreach ($cart_items as $item): ?>
            <tr data-id="<?= $item['id']; ?>">
                 <td class="thumbnail-img">
                                        <a href="#">
                                    <img class="img-fluid" src="<?php echo base_url()?><?= $item['image']; ?>" alt="" width="120px"/>
                                </a>
                                    </td>
                <td class="name-pr"><?= $item['name']; ?></td>
                <td class="price-pr">$<?= number_format($item['price'], 2); ?></td>
                <td class="quantity-box"><input type="number" size="4" value="<?= $item['quantity']; ?>" min="1" step="1" class="c-input-text qty text"></td>
                <td class="total-pr">$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                 <td class="remove-pr ">
                         <button class="btn btn-danger remove-item" data-id="<?= $item['id']; ?>">Remove</button>
           
                            
                                    </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Your cart is empty.</td>
        </tr>
    <?php endif; ?>


                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

           
            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <h3>Order summary</h3>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold" id="order_subtotal"> </div>
                        </div>
                        <!--<div class="d-flex">
                            <h4>Discount</h4>
                            <div class="ml-auto font-weight-bold" id="order_discount"> $ 40 </div>
                        </div>-->
                        <hr class="my-1">
                    
                        <div class="d-flex">
                            <h4>Tax (10%)</h4>
                            <div class="ml-auto font-weight-bold" id="order_tax"> </div>
                        </div>
                        <div class="d-flex">
                            <h4>Shipping Cost</h4>
                            <div class="ml-auto font-weight-bold" > Free </div>
                        </div>
                        <hr>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5" id="order_grand_total"> </div>
                        </div>
                        <hr> </div>
                </div>
                <div class="col-12 d-flex shopping-box"><a href="<?php echo base_url();?>cart/checkout" class="ml-auto btn hvr-hover">Checkout</a> </div>
            </div>

        </div>
    </div>
    <?php include('footer.php')?>
  

