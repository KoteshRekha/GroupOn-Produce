<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Search_model'); // Load your model
    }

    // Handle the search query
    public function results() {
        // 1. Get the search term from the URL
        $query = $this->input->get('q', TRUE); // e.g. ?q=apples

        // 2. Pass it to the model to fetch matching results
        $data['results'] = $this->Search_model->search_products($query);

        // 3. Load a view to display the results
        $this->load->view('search_results', $data);
    }
}
