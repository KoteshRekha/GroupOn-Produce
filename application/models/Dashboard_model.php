<?php
class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get total number of orders
    public function get_total_orders() {
        return $this->db->count_all('orders');
    }

public function get_farmer_orders($farmer_id) {
    $this->db->distinct();
    $this->db->select('orders.id'); 
    $this->db->from('orders');
    $this->db->join('order_items', 'order_items.order_id = orders.id', 'inner');
    $this->db->join('products', 'products.id = order_items.product_id', 'inner');
    $this->db->where('products.farmer_id', $farmer_id);

    $query = $this->db->get();
    return $query->num_rows(); // Returns the count of unique orders for the farmer
}
public function get_customer_orders($customer_id) {
    $this->db->distinct();
    $this->db->select('orders.id'); 
    $this->db->from('orders');
    $this->db->join('order_items', 'order_items.order_id = orders.id', 'inner');
    $this->db->join('products', 'products.id = order_items.product_id', 'inner');
    $this->db->where('orders.customer_id', $customer_id); // Filtering by customer_id

    $query = $this->db->get();
    return $query->num_rows(); // Returns the count of unique orders for the customer
}
public function get_customer_earnings($customer_id) {
    $this->db->select_sum('orders.grand_total', 'total_earnings'); // Total earnings for the customer
    $this->db->from('orders');
    $this->db->where('orders.customer_id', $customer_id); // Filter by customer_id

    $query = $this->db->get();
    $row = $query->row();
    return $row->total_earnings ? $row->total_earnings : 0; // Returns the earnings or 0 if no data
}



public function get_farmer_earnings($farmer_id) {
    $this->db->select_sum('order_items.subtotal', 'total_earnings'); 
    $this->db->from('orders');
    $this->db->join('order_items', 'order_items.order_id = orders.id', 'inner');
    $this->db->join('products', 'products.id = order_items.product_id', 'inner');
    $this->db->where('products.farmer_id', $farmer_id);

    $query = $this->db->get();
    $row = $query->row();
    return $row->total_earnings ? $row->total_earnings : 0;
}

public function get_customer_orders_count($customer_id, $order_status = null) {
    $this->db->distinct();
    $this->db->select('orders.id'); 
    $this->db->from('orders');
    $this->db->join('order_items', 'order_items.order_id = orders.id', 'inner');
    $this->db->join('products', 'products.id = order_items.product_id', 'inner');
    $this->db->where('orders.customer_id', $customer_id); // Filtering by customer_id
    
    if ($order_status) {
        $this->db->where('orders.order_status', $order_status); // Optionally filter by order status
    }

    return $this->db->count_all_results(); // Returns the count of unique orders for the customer
}

public function get_farmer_orders_count($farmer_id, $order_status = null) {
    $this->db->distinct();
    $this->db->select('orders.id'); 
    $this->db->from('orders');
    $this->db->join('order_items', 'order_items.order_id = orders.id', 'inner');
    $this->db->join('products', 'products.id = order_items.product_id', 'inner');
    $this->db->where('products.farmer_id', $farmer_id);
    
    if ($order_status) {
        $this->db->where('orders.order_status', $order_status);
    }

    return $this->db->count_all_results();
}

public function get_farmer_total_products($farmer_id) {
    $this->db->from('products');
    $this->db->where('farmer_id', $farmer_id);
    return $this->db->count_all_results();
}
    // Get total earnings (sum of grand_total in orders table)
    public function get_total_earnings() {
        $this->db->select_sum('grand_total', 'total_earnings');
        $query = $this->db->get('orders');
        $row = $query->row();
        return $row->total_earnings ? $row->total_earnings : 0;
    }

    // Get total number of pending orders
    public function get_pending_orders() {
        $this->db->where('order_status', 'Order Placed');
        $this->db->from('orders');
        return $this->db->count_all_results();
    }
         public function get_placed_orders() {
        $this->db->where('order_status', 'Order Placed');
        $this->db->from('orders');
        return $this->db->count_all_results();
    }
    public function get_completd_orders() {
        $this->db->where('order_status', 'Delivered');
        $this->db->from('orders');
        return $this->db->count_all_results();
    }
    public function get_total_products()
{
    // Count all rows in the 'products' table
    $this->db->from('products');
    return $this->db->count_all_results();
}
public function get_total_users()
{
    $this->db->from('users');
    return $this->db->count_all_results();
}
public function get_distinct_user_types_count()
{
    // DISTINCT approach
    $this->db->distinct();
    $this->db->select('user_type');
    $this->db->from('users');
    $query = $this->db->get();

    // Number of distinct user_type rows
    return $query->num_rows();
}
public function get_farmer_total_messages($farmer_id) {
    $this->db->from('messages');
    $this->db->where('to_user_id', $farmer_id); // Farmer is the receiver
    return $this->db->count_all_results();
}



public function get_total_messages()
{
    $this->db->from('messages');
    return $this->db->count_all_results();
}

}
