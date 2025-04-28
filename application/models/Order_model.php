<?php
class Order_model extends CI_Model {

public function get_all_orders($limit, $offset)
{
    $this->db->select('orders.*, products.product_name, products.unit, CONCAT(users.first_name, " ", users.last_name) as customer, order_items.quantity, order_items.price as total_price, users.user_type');
    $this->db->from('orders');
    $this->db->join('order_items', 'orders.id = order_items.order_id', 'left');
    $this->db->join('products', 'order_items.product_id = products.id', 'left');
    $this->db->join('users', 'users.id = orders.customer_id', 'left');
    
    // Filter by farmer_id from the session
    $userId=$this->session->userdata('user_id');
    if($this->session->userdata('user_type') === 'farmer'){

        $this->db->where('products.farmer_id', $userId);
    }else{

        $this->db->where('orders.customer_id', $userId);
    }

    // Apply pagination
    $this->db->limit($limit, $offset);

    return $this->db->get()->result();
}
public function get_farmer_orders($limit, $offset)
{
    $this->db->select('orders.*, products.product_name, products.unit, CONCAT(users.first_name, " ", users.last_name) as customer, order_items.quantity, order_items.price as total_price, users.user_type');
    $this->db->from('orders');
    $this->db->join('order_items', 'orders.id = order_items.order_id', 'left');
    $this->db->join('products', 'order_items.product_id = products.id', 'left');
    $this->db->join('users', 'users.id = orders.customer_id', 'left');
    
    // Get the logged-in user's ID and type from the session
    $userId = $this->session->userdata('user_id');
    
    // Check if the logged-in user is a farmer
    if ($this->session->userdata('user_type') === 'farmer') {
        // Filter orders where the farmer is the seller of the products
        $this->db->where('products.farmer_id', $userId);
    } else {
        // For customers, filter by their customer ID in the orders table
        $this->db->where('orders.customer_id', $userId);
    }

    // Apply pagination based on limit and offset
    $this->db->limit($limit, $offset);

    // Execute the query and return the result
    return $this->db->get()->result();
}


// Count all orders (for pagination)
public function count_all_orders()
{
    return $this->db->count_all('orders'); // Total number of orders
}
public function count_farmer_orders($farmer_id) {
    // Count the orders for the specific farmer, based on products associated with that farmer
 //   $this->db->distinct();
    $this->db->select('orders.id');
    $this->db->from('orders');
    $this->db->join('order_items', 'orders.id = order_items.order_id', 'left');
    $this->db->join('products', 'products.id = order_items.product_id', 'left');
    $this->db->where('products.farmer_id', $farmer_id); // Filter by the farmer's ID
    
    return $this->db->count_all_results(); // Count the results
}

    public function update_status($order_id, $status) {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', ['order_status' => $status]);
    }

    public function delete_order($order_id) {
        return $this->db->delete('orders', ['id' => $order_id]);
    }

      public function insert_order($data) {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    // Insert order item
    public function insert_order_item($data) {
        return $this->db->insert('order_items', $data);
    }
    public function getOrder($orderId) {
    $this->db->where('id', $orderId);
    $query = $this->db->get('orders');
    return $query->row(); // Returns a single order object
}

public function getOrderItems($orderId) {
    $this->db->where('order_id', $orderId);
    $query = $this->db->get('order_items');
    return $query->result(); // Returns an array of order item objects
}
}
