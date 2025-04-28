<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // Load session library
    }

    // Add product to cart
    public function add() {
        $product_id = $this->input->post('id');
        $product_name = $this->input->post('name');
        $product_price = $this->input->post('price');
        $product_image = $this->input->post('image');
         $stock = $this->input->post('stock');

        // Get existing cart from session
        $cart = $this->session->userdata('cart') ? $this->session->userdata('cart') : [];

        // Check if the product is already in the cart
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += 1;
        } else {
            $cart[$product_id] = [
                'id' => $product_id,
                'name' => $product_name,
                'image' => $product_image,
                'price' => $product_price,
                'stock' => $stock,
                'quantity' => 1
            ];
        }

        // Save updated cart in session
        $this->session->set_userdata('cart', $cart);

        // Return JSON response
        echo json_encode([
            'status' => 'success',
            'message' => 'Product added to cart successfully!'
        ]);
    }

    // Get cart item count
    public function count() {
        $cart = $this->session->userdata('cart');
        $total_items = 0;

        if (!empty($cart)) {
            foreach ($cart as $item) {
                $total_items += $item['quantity'];
            }
        }

        echo $total_items;
    }

    // View cart items
    public function view() {
        $data['cart_items'] = $this->session->userdata('cart');
        $this->load->view('cart_view', $data);
    }
    public function getCartitems() {
    $cart = $this->session->userdata('cart') ?? [];

    // Convert associative array to indexed array
    $cart = array_values($cart);

    header('Content-Type: application/json');
    echo json_encode($cart);
    exit;
}

public function removeItem() {
    // Get the product id from POST
    $itemId = $this->input->post('id');

    // Get current cart from session (or an empty array if not set)
    $cart = $this->session->userdata('cart') ?: [];

    // Create a new array excluding the item with the matching id
    $newCart = [];
    foreach ($cart as $item) {
        if ($item['id'] != $itemId) {
            $newCart[] = $item;
        }
    }

    // Update the session data
    $this->session->set_userdata('cart', $newCart);

    // Return a JSON response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
    exit;
}
public function checkout() {
        $data['cart_items'] = $this->session->userdata('cart');

        
        $this->load->view('checkout', $data);


    }
public function updateQuantity() {
    // Get the product id and new quantity from POST
    $id = $this->input->post('id');
    $quantity = $this->input->post('quantity');
    
    // Get current cart from session (or empty array if not set)
    $cart = $this->session->userdata('cart') ?: [];
    
    // Since your cart is stored as an indexed array (each item is an associative array),
    // loop through the cart to find the matching item by its 'id'
    foreach ($cart as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] = $quantity;
            break;
        }
    }
    unset($item); // break reference
    
    // Update the session with the new cart data
    $this->session->set_userdata('cart', $cart);
    
    // Return a JSON response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Quantity updated successfully']);
    exit;
}


}
?>
