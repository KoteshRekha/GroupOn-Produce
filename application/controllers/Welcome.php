<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct()
{
    parent::__construct();
    $this->load->model('Product_model');
     $this->load->model('Order_model');
     $this->load->model('Dashboard_model');
    $this->load->helper('url');
}

	public function index()
	{
		     $data['products'] = $this->Product_model->get_all_products(20,0);
    $data['latest_products'] = $this->Product_model->get_latest_products(8);
    $data['fruits'] = $this->Product_model->get_latest_products_by_category(1,4);
      $data['vegetables'] = $this->Product_model->get_latest_products_by_category(2,4);
	$data['dairy'] = $this->Product_model->get_latest_products_by_category(3,4);
	$data['grains'] = $this->Product_model->get_latest_products_by_category(4,4);	     
	
	 if($this->session->userdata('user_type') == 'farmer'){
	     $farmerId = $this->session->userdata('user_id');

		 	$data['orders'] = $this->Order_model->get_all_orders(20,0,$farmerId);	 
		 	$data['total_orders'] = $this->Dashboard_model->get_farmer_orders($farmerId);
		 	    $data['pending_orders'] = $this->Dashboard_model->get_farmer_orders_count($farmerId, 'Pending'); 
		 	    $data['placed_orders'] = $this->Dashboard_model->get_farmer_orders_count($farmerId, 'Order Placed'); 
        $data['completd_orders'] = $this->Dashboard_model->get_farmer_orders_count($farmerId, 'Delivered'); 
        
 $data['total_earnings'] = $this->Dashboard_model->get_farmer_earnings($farmerId);
       
         $data['total_products'] = $this->Dashboard_model->get_farmer_total_products($farmerId);
          $data['total_users'] = $this->Dashboard_model->get_total_users();
        $data['total_accounts'] = $this->Dashboard_model->get_distinct_user_types_count();
         $data['total_messages'] = $this->Dashboard_model->get_farmer_total_messages($farmerId);

        $this->load->view('my-account', $data);
	 }
    else{

    	$this->load->view('welcome_message', $data);
    }

        
        		
	}
	public function account()
	{
		
		 $farmerId = $this->session->userdata('user_id');
		 $user_type = $this->session->userdata('user_type');

		 	$data['orders'] = $this->Order_model->get_all_orders(20,0,$farmerId);	 
		 	if($user_type == 'customer'){
		 	    $data['total_orders'] = $this->Dashboard_model->get_customer_orders($farmerId);
		 	    $data['pending_orders'] = $this->Dashboard_model->get_customer_orders_count($farmerId, 'Pending'); 
		 	    $data['placed_orders'] = $this->Dashboard_model->get_customer_orders_count($farmerId, 'Order Placed'); 
        $data['completd_orders'] = $this->Dashboard_model->get_customer_orders_count($farmerId, 'Delivered'); 
        
        $data['total_earnings'] = $this->Dashboard_model->get_customer_earnings($farmerId);
		 	}else{
		 	    $data['total_orders'] = $this->Dashboard_model->get_farmer_orders($farmerId);
		 	    $data['pending_orders'] = $this->Dashboard_model->get_farmer_orders_count($farmerId, 'Pending'); 
		 	    $data['placed_orders'] = $this->Dashboard_model->get_farmer_orders_count($farmerId, 'Order Placed'); 
        $data['completd_orders'] = $this->Dashboard_model->get_farmer_orders_count($farmerId, 'Delivered'); 
        $data['total_earnings'] = $this->Dashboard_model->get_farmer_earnings($farmerId);
		 	}

			  
        
        
        
        $data['total_products'] = $this->Dashboard_model->get_farmer_total_products($farmerId);
        $data['total_users'] = $this->Dashboard_model->get_total_users();
        $data['total_accounts'] = $this->Dashboard_model->get_distinct_user_types_count();
         $data['total_messages'] = $this->Dashboard_model->get_farmer_total_messages($farmerId);

        $this->load->view('my-account', $data);
        
	}
	public function manage_products()
	{
		
		     $data['categories'] = $this->Product_model->get_all_categories();
        $this->load->view('manage-products', $data);
        //$this->load->view('manage-products');
	}
	public function manage_orders()
	{
		
		     
        $this->load->view('manage-orders');
        //$this->load->view('manage-products');
	}
	public function about()
	{
		
		     
        $this->load->view('about');
        //$this->load->view('manage-products');
	}
	public function contact()
	{
		
		     
        $this->load->view('contact');
        //$this->load->view('manage-products');
	}
	public function form_process()
{
    // Load the helper and library
    $this->load->helper('url');
    $this->load->library('email');

    // Get POST data
    $name = $this->input->post('name', true);
    $email = $this->input->post('email', true);
    $msg_subject = $this->input->post('msg_subject', true);
    $message = $this->input->post('message', true);

    // Validate inputs
    if (empty($name) || empty($email) || empty($msg_subject) || empty($message)) {
        echo "All fields are required.";
        return;
    }

    // Email configuration
    $this->email->from($email, $name);
    $this->email->to('chavasivapavankumar0209@gmail.com'); // Replace with your email
    $this->email->subject($msg_subject);
    $this->email->message($message);

    // Send email
    if ($this->email->send()) {
        echo "success";
    } else {
        echo "Error: " . $this->email->print_debugger();
    }
}

	public function gallery()
	{
		
		     
        $data['latest_products'] = $this->Product_model->get_latest_products(20);
    $data['fruits'] = $this->Product_model->get_latest_products_by_category(1,4);
      $data['vegetables'] = $this->Product_model->get_latest_products_by_category(2,4);
	$data['dairy'] = $this->Product_model->get_latest_products_by_category(3,4);
	$data['grains'] = $this->Product_model->get_latest_products_by_category(4,4);	     
	 $this->load->view('gallery', $data);
        //$this->load->view('manage-products');
	}
}
