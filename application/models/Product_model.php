<?php
class Product_model extends CI_Model {

    public function insertProduct($data) {
        return $this->db->insert('products', $data);
    }
    public function get_all_products($limit, $offset)
{
    $this->db->select('products.*, product_category.name as category');
    $this->db->from('products');
    $this->db->join('product_category', 'product_category.id = products.category_id', 'left');
    $this->db->limit($limit, $offset); // Apply pagination
    return $this->db->get()->result();
}

public function get_farmer_products($farmer_id, $limit, $offset) {
    $this->db->select('products.*, product_category.name as category');
    $this->db->from('products');
    $this->db->join('product_category', 'product_category.id = products.category_id', 'left');
    $this->db->where('products.farmer_id', $farmer_id); // Filter by logged-in farmer's ID
    $this->db->limit($limit, $offset); // Apply pagination
    return $this->db->get()->result();
}

public function get_latest_products($limit)
{
    $this->db->select('products.*, product_category.name as category');
    $this->db->from('products');
    $this->db->join('product_category', 'product_category.id = products.category_id', 'left');
    $this->db->order_by('products.id', 'DESC'); // Order by ID descending
    $this->db->limit($limit);
    return $this->db->get()->result();
}

public function get_latest_products_by_category($category_id, $limit)
{
    $this->db->where('category_id', $category_id);
    $this->db->order_by('created_at', 'DESC'); // Order by latest first
    
    $this->db->limit($limit); // Limit to 4 products per category
    $query = $this->db->get('products'); // Fetch from 'products' table
    return $query->result();
}

// Function to get total product count
public function count_all_products()
{
    return $this->db->count_all('products'); // Total product count
}

public function count_farmer_products($farmer_id) {
    // Apply the 'where' condition to filter products by farmer_id
    $this->db->where('farmer_id', $farmer_id);
    
    // Now count the filtered rows
    return $this->db->count_all_results('products'); // Count filtered products for this farmer
}


    public function update_product($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }
      public function get_product_by_id($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    public function get_all_categories() {
        return $this->db->get('product_category')->result();
    }
    public function delete_product($id)
{
    return $this->db->where('id', $id)->delete('products');
}

}
?>
