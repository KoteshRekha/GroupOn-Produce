<?php include('header.php')?>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="all-title-box">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2>Payment</h2>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
          <li class="breadcrumb-item active">Payment</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row" style="margin-top:2%;">
    <!-- Billing/Shipping Information -->
    <div class="col-md-6">
      <h3>Billing & Shipping Information</h3>
      <p><strong>Address:</strong> <?= $order->address; ?></p>
      <p><strong>Country:</strong> <?= $order->country; ?></p>
      <p><strong>State:</strong> <?= $order->state; ?></p>
      <p><strong>ZIP:</strong> <?= $order->zip; ?></p>
    </div>

    <!-- Order Summary -->
    <div class="col-md-6">
      <h3>Order Summary</h3>
      <div class="order-summary" style="border: 1px solid #ddd; padding: 15px;">
        <div class="d-flex" style="overflow: hidden;">
          <h4 style="margin:0;">Sub Total</h4>
          <div class="pull-right font-weight-bold" style="margin-left: auto;">$<?= number_format($order->subtotal, 2); ?></div>
        </div>
        <div class="d-flex">
          <h4 style="margin:0;">Tax (10%)</h4>
          <div class="pull-right font-weight-bold" style="margin-left: auto;">$<?= number_format($order->tax, 2); ?></div>
        </div>
        <div class="d-flex">
          <h4 style="margin:0;">Shipping Cost</h4>
          <div class="pull-right font-weight-bold" style="margin-left: auto;">
            <?= $order->shipping_cost == 0 ? "Free" : "$" . number_format($order->shipping_cost, 2); ?>
          </div>
        </div>
        <hr>
        <div class="d-flex gr-total">
          <h5 style="margin:0;">Grand Total</h5>
          <div class="pull-right h5" style="margin-left: auto;">$<?= number_format($order->grand_total, 2); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- Order Items -->
   <div class="container">
  <div class="row my-4">
    <div class="col-md-12">
      <h3>Order Items</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($order_items)): ?>
            <?php foreach ($order_items as $item): ?>
              <tr>
                <td><?= $item->name; ?></td>
                <td>$<?= number_format($item->price, 2); ?></td>
                <td><?= $item->quantity; ?></td>
                <td>$<?= number_format($item->subtotal, 2); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">No items found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

  <!-- Continue Shopping Button -->
  <div class="container">
    <div class="row">
    <div class="col-md-12 text-center">
      <button id="payBtn" class="form-control btn btn-primary">Pay Now $<?= number_format($order->grand_total, 2); ?></button>

      
    </div>
  </div>
</div>
</div>

<?php include('footer.php'); ?>


<script>
  var orderId  = "<?= $order_id; ?>";
  var keyId    = "<?= $key_id; ?>";
  var amount   = <?= $amount; ?>;
  var amountPaise = amount * 100;

  document.getElementById('payBtn').addEventListener('click', function() {
    var options = {
      "key": keyId,
      "order_id": orderId,
      "amount": amountPaise,
      "currency": "USD",
      "name": "Groupon Products",
      "handler": function (response) {
        // Payment success
        console.log("Payment success:", response);
    window.location.href = "<?= base_url('order/confirmation'); ?>";
      
      }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
  });
</script>

        <?php include('footer.php')?>