<?php include('header.php')?>

<style type="text/css">
    .error-header {
  background-color: #d9534f;  /* Bootstrap danger red */
  color: #fff;
}
.error-header .close {
  color: #fff;
  opacity: 1;
}


</style>
 <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Checkout</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
<?php if (empty($this->session->userdata('user_id'))){ ?>

<div class="row new-account-login">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="title-left">
                        <h3>Account Login</h3>
                    </div>
                    <h5><a href="#" data-toggle="modal" data-target="#loginModal">Click here to Login</a></h5>
                    
                </div>
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="title-left">
                        <h3>Create New Account</h3>
                    </div>
                    <h5>
                        <a href="#" data-toggle="modal" data-target="#registerModal">Click here to Register</a>

                    
                </div>
            </div>

<?php } ?>
            <!---->
            <div class="row">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="checkout-address">
                        <div class="title-left">
                            <h3>Billing address</h3>
                        </div>
                         <form id="checkoutForm" method="post" action="<?= base_url('order/placeOrder'); ?>" novalidate>
 
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name *</label>
                                    <input type="text" class="form-control" name="first_name" id="firstName" placeholder="" value="<?php echo $this->session->userdata('first_name'); ?>" required>
                                    <div class="invalid-feedback"> Valid first name is required. </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name *</label>
                                    <input type="text" class="form-control" name="last_name" id="lastName"  placeholder="" value="<?php echo $this->session->userdata('last_name'); ?>" required>
                                    <div class="invalid-feedback"> Valid last name is required. </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email">Email Address *</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="" value="<?php echo $this->session->userdata('email'); ?>">
                                <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address *</label>
                                <input type="text" class="form-control" name="address" id="address"  placeholder="" required>
                                <div class="invalid-feedback"> Please enter your shipping address. </div>
                            </div>
                            
                            <div class="row">
    <div class="col-md-5 mb-3">
        <label for="country">Country *</label>
        <select class="wide w-100" name="country" id="country" >
            <option value="" data-display="Select">Choose...</option>
            <option value="United States">United States</option>
            <option value="India">India</option>
        </select>
        <div class="invalid-feedback">Please select a valid country.</div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="state">State *</label>
        <select class="wide w-100" name="state" id="state">
            <option value="" data-display="Select">Choose...</option>
        </select>
        <div class="invalid-feedback">Please provide a valid state.</div>
    </div>


                                <div class="col-md-3 mb-3">
                                    <label for="zip">Zip *</label>
                                    <input type="text" class="form-control" name="zip" id="zip"placeholder="" required>
                                    <div class="invalid-feedback"> Zip code required. </div>
                                </div>
                            </div>
                          <!--  <hr class="mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="same-address">
                                <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="save-info">
                                <label class="custom-control-label" for="save-info">Save this information for next time</label>
                            </div>-->
                          
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="shipping-method-box">
                                <div class="title-left">
                                    <h3>Shipping Method</h3>
                                </div>
                                <div class="mb-4">
                                  <!-- Shipping Options -->
<div class="custom-control custom-radio">
    <input id="shippingOption1" name="shipping-option" class="custom-control-input" checked="checked" type="radio" value="0">
    <label class="custom-control-label" for="shippingOption1">Standard Delivery</label> 
    <span class="pull-right font-weight-bold">FREE</span>
</div>
<div class="ml-4 mb-2 small">(3-7 business days)</div>

<div class="custom-control custom-radio">
    <input id="shippingOption2" name="shipping-option" class="custom-control-input" type="radio" value="10">
    <label class="custom-control-label" for="shippingOption2">Express Delivery</label> 
    <span class="pull-right font-weight-bold">$10.00</span>
</div>
<div class="ml-4 mb-2 small">(2-4 business days)</div>

<div class="custom-control custom-radio">
    <input id="shippingOption3" name="shipping-option" class="custom-control-input" type="radio" value="20">
    <label class="custom-control-label" for="shippingOption3">Next Business day</label> 
    <span class="pull-right font-weight-bold">$20.00</span>
</div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="odr-box">
                                <div class="title-left">
                                    <h3>Shopping cart</h3>
                                </div>
                                <div class="rounded p-2 bg-light">

                                     <?php 
                                     
                                     if (!empty($cart_items)): ?>
                                        <?php $total = 0; // Initialize grand total ?>
        <?php foreach ($cart_items as $item): ?>
            
 <?php 
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;

        ?>
             <div class="media mb-2 border-bottom">
                                        <div class="media-body"> <a href="#"> <?= $item['name']; ?></a>
                                            <div class="small text-muted">Price: $<?= number_format($item['price'], 2); ?> <span class="mx-2">|</span> Qty: <?= $item['quantity']; ?> <span class="mx-2">|</span> Subtotal: $<?= number_format($item['price'] * $item['quantity'], 2); ?></div>
                                        </div>
                                    </div>
    <?php endforeach; ?>
     <?php else: ?>
         <div class="media mb-2 border-bottom">
           <div class="media-body">Your cart is empty.</div>
</div>
    <?php endif; ?>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="order-box">
                                <div class="title-left">
                                    <h3>Your order</h3>
                                </div>
                                <div class="d-flex">
                                    <div class="font-weight-bold">Product</div>
                                    <div class="ml-auto font-weight-bold">Total</div>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex">
                                    <h4>Sub Total</h4>
                                    <div class="ml-auto font-weight-bold" id="order_subtotal"> $<?= number_format($total, 2); ?></div>
                                </div>
                                
                                <hr class="my-1">
                               
                                <div class="d-flex">
                                    <h4>Tax (10%)</h4>
                                    <div class="ml-auto font-weight-bold" id="order_tax"> <?php $tax = $total * 0.1; ?>$<?= number_format($tax, 2); ?></div>
                                </div>
                                <div class="d-flex">
                                    <h4>Shipping Cost</h4>
                                    <div class="ml-auto font-weight-bold" id="order_shipping"> Free </div>
                                </div>
                                <hr>
                                <div class="d-flex gr-total">
                                    <h5>Grand Total</h5><?php  if (!empty($cart_items)) {
                                    
                                    $grandTotal = $total + $tax;
                                    }
                                    else{
                                         $grandTotal=0;
                                    }?>
                                    <div class="ml-auto h5" id="order_grand_total">$<?= number_format($grandTotal, 2); ?> </div>
                                </div>
                                <hr> </div>
                        </div>
                         <input type="hidden" name="order_subtotal" id="order_subtotal" value="<?php if (!empty($cart_items)) { echo $total; }?>
                         ">
      <input type="hidden" name="order_tax" id="order_tax" value="<?= $tax; ?>">
      <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
      <input type="hidden" name="grand_total" id="grand_total" value="<?= $grandTotal; ?>">
      <input type="hidden" name="cart_items" id="cart_items" value='<?= json_encode($cart_items); ?>'>
    

      
                        <div class="col-12 d-flex shopping-box">
                            <?php if (empty($this->session->userdata('user_id'))){ ?>
                            <?php } else {?>
                            
                             <button type="submit" class="ml-auto btn hvr-hover">Place Order</button>
                             <?php } ?>
                            </div>

                    </div>
                </div>
            </div>
    </form>

        </div>
    </div>
<?php if ($this->session->flashdata('error')): ?>
<div id="errorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header error-header">
        <h2 class="modal-title" style="margin-right:80%;color: #fff;">Error</h2>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p><?php echo $this->session->flashdata('error'); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Script to auto open the modal -->
<script>
  $(document).ready(function() {
    $('#errorModal').modal('show');
  });
</script>

<?php endif; ?>


    <!-- End Cart -->
        <?php include('footer.php')?>
