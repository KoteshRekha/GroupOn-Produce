<?php include('header.php'); ?>

<div class="all-title-box">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2>Order Confirmation</h2>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
          <li class="breadcrumb-item active">Order Confirmation</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- End All Title Box -->

<div class="container my-5">
  <div class="alert alert-success" role="alert">
    <h1 class="alert-heading">Thank You for Your Order!</h1>
    <p>Your order has been placed successfully. Your order ID is <strong><?= $order->id; ?></strong>.</p>
    <hr>
   
  </div>

  <div class="row">
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

  <!-- Order Items -->
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

  <!-- Continue Shopping Button -->
  <div class="row">
    <div class="col-md-12 text-center">
      <a href="<?= base_url(); ?>" class="btn btn-primary">Continue Shopping</a>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
