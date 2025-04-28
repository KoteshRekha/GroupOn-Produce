<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('upload');
    }

public function get_products()
{
    $limit = $this->input->get('limit') ? (int) $this->input->get('limit') : 10; // Default limit 10
    $offset = $this->input->get('offset') ? (int) $this->input->get('offset') : 0; // Default offset 0
    $farmerId = $this->session->userdata('user_id');

    $products = $this->Product_model->get_farmer_products($farmerId,$limit, $offset);
    $total_products = $this->Product_model->count_farmer_products($farmerId); // Get total product count

    $response = [
        'products' => $products,
        'total' => $total_products,
        'limit' => $limit,
        'offset' => $offset
    ];

    echo json_encode($response);
}


    public function addProduct() {

         $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);

        if ($this->upload->do_upload('productImage')) {
           // $upload_data = $this->upload->data();
          //  $image_path = 'uploads/' . $upload_data['file_name'];
              $uploadData = $this->upload->data();
      
  $imagePath  = 'assets/uploads/' . $uploadData['file_name'];

            $data = array(
                 'farmer_id'  => $this->session->userdata('user_id'),
                'product_name'  => $this->input->post('productName'),
                'category_id'      => $this->input->post('productCategory'),
                'price'         => $this->input->post('productPrice'),
                'stock'         => $this->input->post('productStock'),
                'unit' => $this->input->post('unit'),
                'image'         => $imagePath,
                   'created_at'  => date('Y-m-d')
            );

            if ($this->Product_model->insertProduct($data)) {
                $this->session->set_flashdata('success', 'Product added successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to add product.');
            }
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }
        
        redirect('manage-products');
    }


    // Edit product
    public function edit_product($id) {
        $data['product'] = $this->Product_model->get_product_by_id($id);
        $data['categories'] = $this->Product_model->get_all_categories();
        $this->load->view('edit_product_view', $data);
    }

    // Update product
public function update_product() {
    if ($this->input->post()) {
        $id = $this->input->post('id');
        $product_data = array(
            'product_name' => $this->input->post('name'),
            'category_id' => $this->input->post('category'),
            'price' => $this->input->post('price'),
            'stock' => $this->input->post('stock'),
            'unit' => $this->input->post('unit'),
            'farmer_id' => $this->session->userdata('user_id'),
            'updated_at' => date('Y-m-d')
        );

       

        if (!empty($_FILES['image']['name'])) {


            $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $product_data['image'] = 'assets/uploads/' . $uploadData['file_name'];
            } else {
                die('Upload error: ' . $this->upload->display_errors());
            }
        }

        $this->Product_model->update_product($id, $product_data);
        $this->session->set_flashdata('success', 'Product updated successfully.');
        redirect('manage-products');
    }
}



public function delete($id)
{
   // Check if the product exists
    $product = $this->Product_model->get_product_by_id($id);
    if (!$product) {
             $this->session->set_flashdata('error', 'Product not found');
       
        return;
    }

    // Delete product
    if ($this->Product_model->delete_product($id)) {

               $this->session->set_flashdata('success', 'Product deleted successfully!');
    } else {
        $this->session->set_flashdata('error', 'Error Deleting Product!');
    }
    redirect('manage-products');
}

}
?>
