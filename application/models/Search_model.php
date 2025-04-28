<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Example search in products table
  public function search_products($query)
{
    $this->db->select('products.*, product_category.name as category');
    $this->db->from('products');
    $this->db->join('product_category', 'product_category.id = products.category_id', 'left');

    // Convert the search term to lowercase
    $lowerQuery = strtolower($query);

    // Use LOWER() on the columns, then compare with $lowerQuery
    // Also pass 'both' for wildcard and FALSE for the 4th parameter to avoid escaping the field expression
    $this->db->like("LOWER(products.product_name)", $lowerQuery, 'both', FALSE);
    $this->db->or_like("LOWER(product_category.name)", $lowerQuery, 'both', FALSE);

    $queryResult = $this->db->get();
    return $queryResult->result();
}

}
