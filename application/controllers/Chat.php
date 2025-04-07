<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');
        $this->load->library('session');
    }

    // Chat UI - user selects who to chat with, etc.
    public function index($otherUserId = null) {
        // Suppose we have a logged-in user:
        $currentUserId = $this->session->userdata('user_id');
        if (!$currentUserId) {
            redirect('welcome');
            return;
        }

        // Load a basic chat view
        $data['otherUserId'] = $otherUserId;
        $this->load->view('chat_view', $data);
    }

    // AJAX: fetch messages
    public function fetch_messages() {
        $currentUserId = $this->session->userdata('user_id');
        $otherUserId = $this->input->post('otherUserId');
 $this->Chat_model->mark_messages_as_read($currentUserId, $otherUserId);
        $messages = $this->Chat_model->get_messages($currentUserId, $otherUserId);

        // Return JSON for front-end to display
        echo json_encode($messages);
    }

    // AJAX: send message
    public function send_message() {
        $currentUserId = $this->session->userdata('user_id');
        $otherUserId = $this->input->post('otherUserId');
        $message = $this->input->post('message');

        $this->Chat_model->insert_message($currentUserId, $otherUserId, $message);

        // Return success or updated message list
        echo json_encode(['status' => 'success']);
    }

    public function fetch_users()
{
    // This is just an example. Adjust to your needs.
    // E.g., if a farmer is logged in, show customers; if a customer is logged in, show farmers, etc.
    
    // Load your User_model (or similar)
    $this->load->model('User_model');
    
    // Suppose we get all users except the current user
    $currentUserId = $this->session->userdata('user_id');
    $users = $this->User_model->get_all_users_except($currentUserId);
	

$this->load->model('Chat_model');
    foreach ($users as &$u) {
        $u['unread_count'] = $this->Chat_model->count_unread_messages($currentUserId, $u['id']);
    }
    // Return as JSON
    echo json_encode($users);
}

}
