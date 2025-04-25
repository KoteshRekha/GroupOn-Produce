<?php include('header.php')?>
<style type="text/css">
  .payment-box {
      max-width: 400px;
      margin: 50px auto;
      padding: 30px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f8f9fa;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    #paymentStatus {
      margin-top: 15px;
      font-weight: 600;
    }

</style>

<!--<script src="https://checkout.razorpay.com/v1/checkout.js"></script>-->

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
      <button id="paymentBtn" class="form-control btn btn-primary" data-toggle="modal" data-target="#paymentModal"> Pay Now $<?= number_format($order->grand_total, 2); ?></button>

      
    </div>


  </div>
</div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel"> Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Your payment form here -->
        <form id="paymentForm">
          <div class="form-group">
          <label for="cardNumber">Name on Card</label>
          <input type="text" class="form-control" id="cardName" placeholder="Name on Card">
        </div>
        <div class="form-group">
          <label for="cardNumber">Mobile Number</label>
       <input type="tel" id="cardMobile" name="mobile" class="form-control" placeholder="Mobile Number" pattern="[0-9]{10}" maxlength="10" required>

        </div>
        <div class="form-group">
          <label for="cardNumber">Card Number</label>
          <input type="text" class="form-control" id="cardNumber" placeholder="Card Number" maxlength="19">
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="expiry">Expiry (MM/YY)</label>
            <input type="text" class="form-control" id="expiry" placeholder="Expiry (MM/YY)">
          </div>
          <div class="form-group col-md-6">
            <label for="cvv">CVV</label>
            <input type="text" class="form-control" id="cvv" placeholder="Cvv">
          </div>
        </div>
      </form>
        <div id="paymentStatus" class="text-center"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="payBtns">Pay</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<?php include('footer.php'); ?>


<script>

  $(document).ready(function() {
    $('#cardNumber').on('input', function() {
        let value = $(this).val().replace(/\D/g, '').substring(0, 16); // Digits only, max 16 digits
        let formatted = value.replace(/(.{4})/g, '$1 ').trim(); // Add space every 4 digits
        $(this).val(formatted);
    });

       $('#expiry').on('input', function() {
        let input = $(this).val().replace(/\D/g, ''); // remove non-digits
        if (input.length >= 2) {
            let month = input.substring(0, 2);
            if (parseInt(month) > 12) {
                month = '12';
            } else if (parseInt(month) === 0) {
                month = '01';
            }
            let year = input.substring(2, 4);
            $(this).val(month + (year ? '/' + year : ''));
        } else {
            $(this).val(input);
        }
    });

    $('#expiry').on('blur', function() {
        const val = $(this).val();
        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(val)) {
           $('#paymentStatus').text("Invalid expiry format. Use MM/YY.").css('color', 'red');
 
            $(this).focus();
        } else {
            // Optional: Check if expired
            const parts = val.split('/');
            const month = parseInt(parts[0], 10);
            const year = parseInt('20' + parts[1], 10);

            const now = new Date();
            const currentMonth = now.getMonth() + 1;
            const currentYear = now.getFullYear();

            if (year < currentYear || (year === currentYear && month < currentMonth)) {
             
                 $('#paymentStatus').text("Card is expired.").css('color', 'red');
 
                $(this).focus();
            }
        }
    });
      $('#cvv').on('input', function() {
        let val = $(this).val().replace(/\D/g, ''); // allow digits only
        $(this).val(val.substring(0, 4)); // max 4 digits
    });

    $('#cvv').on('blur', function() {
        const val = $(this).val();
        if (!/^\d{3,4}$/.test(val)) {
           $('#paymentStatus').text("Invalid CVV. It should be 3 or 4 digits.").css('color', 'red');
 
        
            $(this).focus();
        }
    });
});


  var amount   = <?= $amount; ?>;
  var amountPaise = amount * 100;

  /*document.getElementById('payBtn').addEventListener('click', function() {
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
*/
   $('#payBtns').on('click', function () {
      const cardNumber = $('#cardNumber').val().replace(/\s/g, '');
      const expiry = $('#expiry').val();
        const cvv = $('#cvv').val();
       // Validate card number
        if (!/^\d{16}$/.test(cardNumber)) {
           $('#paymentStatus').text("Invalid card number. Must be 16 digits.").css('color', 'red');
            $('#cardNumber').focus();
            return;
        }

        // Validate expiry format
        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
             $('#paymentStatus').text("Invalid expiry format. Use MM/YY.").css('color', 'red');
 
            $('#expiry').focus();
            return;
        }

        // Check expiry is not past
        const [mm, yy] = expiry.split('/');
        const expiryDate = new Date(`20${yy}`, mm);
        const today = new Date();
        today.setDate(1); // Compare only by month
        if (expiryDate < today) {
         $('#paymentStatus').text("Card is expired.").css('color', 'red');
            $('#expiry').focus();
            return;
        }

        // Validate CVV
        if (!/^\d{3,4}$/.test(cvv)) {
           $('#paymentStatus').text("Invalid CVV. It should be 3 or 4 digits.").css('color', 'red');
 
            $('#cvv').focus();
            return;
        }

    var cardMobile = $('#cardMobile').val().trim();
    var cardName = $('#cardName').val().trim();
    var card=cardNumber;

    if (!card || !expiry || !cvv || !cardMobile || !cardName) {

        $('#paymentStatus').text("Please fill in all fields.").css('color', 'red');
        return;
    }

    if (!/^\d{10}$/.test(cardMobile)) {
  $('#paymentStatus').text("Please enter a valid 10-digit mobile number.").css('color', 'red');
  return;
}

    $('#paymentStatus').text("Processing...").css('color', '#333');

        $.ajax({
        url: "<?= base_url('order/update_information'); ?>",
        type: "POST",
        dataType: "json",
         data: { 
            card: card,
            expiry: expiry,
            cvv: cvv,
            cardMobile: cardMobile,
            cardName: cardName
        },
        success: function(response) {
if (response.status) {
            // Show success toast and redirect after short delay
            toastr.success(response.message);

            $('#paymentStatus')
  .removeClass('text-danger')
  .addClass('text-success')
  .text(response.message);


            $('#paymentStatus').text(response.message).css('color', '#28a745');

            setTimeout(function () {
                window.location.href = "<?= base_url('order/confirmation'); ?>";
            }, 1500);
        } else {
            toastr.error(response.message);

            $('#paymentStatus')
  .removeClass('text-success')
  .addClass('text-danger')
  .text(response.message);

           // $('#paymentStatus').text(response.message).css('color', '#28a745');
        }
      },
      error: function () {

         $('#paymentStatus')
  .removeClass('text-success')
  .addClass('text-danger')
  .text('Something went wrong!');

      }
    });
  });

</script>

        <?php include('footer.php')?>