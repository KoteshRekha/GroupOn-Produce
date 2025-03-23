<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require __DIR__ . '/vendor/autoload.php';
 use Razorpay\Api\Api;

 class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_model');
        

    }
  
  public function get_orders()
{
    $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 10; // Default limit 10
    $offset = $this->input->get('offset') ? (int)$this->input->get('offset') : 0; // Default offset 0
    $orders = $this->Order_model->get_farmer_orders($limit, $offset);
    $farmerId = $this->session->userdata('user_id');
    $total_orders = $this->Order_model->count_farmer_orders($farmerId); // Total orders count

    $response = [
        'orders' => $orders,
        'total' => $total_orders,
        'limit' => $limit,
        'offset' => $offset
    ];

    echo json_encode($response);
}


    public function index() {
        $data['orders'] = $this->Order_model->get_all_orders();
        $this->load->view('orders_view', $data);
    }

 public function confirmation() {
    $orderId = $this->session->userdata('order_id');
    if (!$orderId) {
        show_error('No order ID found in session.');
        return;
    }
    
    // Then load the order details as shown in Approach 1
    $this->load->model('Order_model');
    $data['order'] = $this->Order_model->getOrder($orderId);
    $data['order_items'] = $this->Order_model->getOrderItems($orderId);
    
    if (!$data['order']) {
        show_error('Order not found.');
        return;
    }
    
    $this->load->view('order_confirmation', $data);
}

public function payment() {
    $amount = $this->session->userdata('grandTotal'); // ₹500
    $key_id = 'rzp_test_i0TyJp4Vx74gX3';
    $key_secret = 'JKQg9hfxiTMOtyuQuK71R1yf';

  $api = new \Razorpay\Api\Api($key_id, $key_secret);

  $orderData = [
    'receipt'         => 'rcptid_11',
    'amount'          => $amount * 100,
    'currency'        => 'INR',
    'payment_capture' => 1
  ];

  $razorpayOrder = $api->order->create($orderData);
  $razorpayOrderId = $razorpayOrder['id'];

  // Pass this order_id to the view
  $data['order_id'] = $razorpayOrderId;
  $data['amount']   = $amount;
  $data['key_id']   = $key_id;

   $orderId = $this->session->userdata('order_id');
    if (!$orderId) {
      show_error('No order ID found in session.');
        return;
    }
    
    // Then load the order details as shown in Approach 1
    $this->load->model('Order_model');
    $data['order'] = $this->Order_model->getOrder($orderId);
    $data['order_items'] = $this->Order_model->getOrderItems($orderId);
    
    if (!$data['order']) {
        show_error('Order not found.');
        return;
    }
    

  $this->load->view('payment', $data);
    
    
}


    public function update_status($order_id) {
        $status = $this->input->post('status');
        if ($this->Order_model->update_status($order_id, $status)) {
            echo json_encode(['success' => true, 'message' => 'Order status updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update order status.']);
        }
    }

    public function delete($order_id) {
        if ($this->Order_model->delete_order($order_id)) {
            echo json_encode(['success' => true, 'message' => 'Order deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting order.']);
        }
    }


    public function placeOrder() {
    // Load the form validation library
    $this->load->library('form_validation');

    // Set validation rules for required fields
    $this->form_validation->set_rules('address', 'Address', 'trim|required');
    $this->form_validation->set_rules('country', 'Country', 'trim|required');
    $this->form_validation->set_rules('state', 'State', 'trim|required');
    $this->form_validation->set_rules('zip', 'Zip Code', 'trim|required');
    
    // Payment details validation (if handling card payments on your form)
  

    // Run validation; if it fails, redirect back to checkout with error messages
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('cart/checkout');
        return; // Ensure the function stops here
    }

    // Capture Billing/Shipping Data
    $billing = [
        'address' => $this->input->post('address'),
        'country' => $this->input->post('country'),
        'state'   => $this->input->post('state'),
        'zip'     => $this->input->post('zip')
    ];

    // Get shipping data (shipping cost should be sent from the form)
    $shippingCost = floatval($this->input->post('shipping_cost')); // e.g., 0, 10, or 20

    // Get payment method and details (further security/validation is recommended for card data)
   // $paymentMethod = $this->input->post('paymentMethod');

    // Retrieve cart items from session
    $cart = $this->session->userdata('cart');
    if (empty($cart)) {
        $this->session->set_flashdata('error', 'Your cart is empty.');
        redirect('checkout');
        return;
    }

    // Calculate Subtotal from Cart Items
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    // Calculate Tax (assumed 10%)
    $tax = $subtotal * 0.10;
    $grandTotal = $subtotal + $tax + $shippingCost;

    // Prepare Order Data for Insertion
    $orderData = [
        'address'         => $billing['address'],
        'country'         => $billing['country'],
        'state'           => $billing['state'],
        'zip'             => $billing['zip'],
        'customer_id'     => $this->session->userdata('user_id'),
        'subtotal'        => $subtotal,
        'tax'             => $tax,
        'shipping_cost'   => $shippingCost,
        'grand_total'     => $grandTotal,
        'order_status'    => 'Order Placed',  // Adjust as needed (e.g., 'Pending', etc.)
        'order_date'      => date('Y-m-d H:i:s'),
        'payment_status'  => 'Done'           // Update based on payment processing results
        // Add additional fields if necessary
    ];

    // Insert the Order and Get Order ID
    $orderId = $this->Order_model->insert_order($orderData);

    // Insert each Order Item into the Order Items Table
    foreach ($cart as $item) {
        $orderItemData = [
            'order_id'   => $orderId,
            'product_id' => $item['id'],
            'name'       => $item['name'],
            'price'      => $item['price'],
            'quantity'   => $item['quantity'],
            'subtotal'   => $item['price'] * $item['quantity']
        ];
        $this->Order_model->insert_order_item($orderItemData);
    }

    // Optionally process payment here and update order status

    // Clear the cart from session
    $this->session->unset_userdata('cart');

    // Set a success flash message and redirect to the order confirmation page
 $this->session->set_userdata('order_id', $orderId);
  $this->session->set_userdata('grandTotal', $grandTotal);
redirect('order/payment');
}

public function razorpaySuccess()
{
    $paymentId  = $this->input->post('razorpay_payment_id');
    $orderId    = $this->input->post('razorpay_order_id');
    $signature  = $this->input->post('razorpay_signature');
    $grandTotal = $this->input->post('grand_total'); // optional if you need it

    // Verify the signature using your $key_secret
    // Example using Razorpay library:
    /*
    $api = new \Razorpay\Api\Api($key_id, $key_secret);
    $attributes = array(
        'razorpay_order_id' => $orderId,
        'razorpay_payment_id' => $paymentId,
        'razorpay_signature' => $signature
    );
    try {
        $api->utility->verifyPaymentSignature($attributes);
        // If no exception, signature is valid
    } catch(\Razorpay\Api\Errors\SignatureVerificationError $e) {
        // signature invalid
        $this->session->set_flashdata('error', 'Payment signature verification failed!');
        redirect('order/payment_failed');
        return;
    }
    */

    // If valid, update your orders table: set payment status to "Paid"
    // ...

    $this->session->set_flashdata('success', 'Payment successful!');
    redirect('order/payment_success'); // or wherever you want
}


}
