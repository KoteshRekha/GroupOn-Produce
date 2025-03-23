<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['otherUserId'] = $this->input->get('user_id'); // Get the other user’s ID
        $this->load->view('chat_view', $data);
    }

    public function fetch_messages() {
        $userId = $this->session->userdata('user_id'); // Logged-in user ID
        $otherUserId = $this->input->post('otherUserId');

        if (!$userId || !$otherUserId) {
            echo json_encode([]);
            return;
        }

        $messages = $this->Chat_model->getMessages($userId, $otherUserId);
        echo json_encode($messages);
    }

    public function send_message() {
        $userId = $this->session->userdata('user_id');
        $otherUserId = $this->input->post('otherUserId');
        $message = $this->input->post('message');

        if (!$userId || !$otherUserId || empty($message)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
            return;
        }

        $this->Chat_model->sendMessage($userId, $otherUserId, $message);
        echo json_encode(['status' => 'success']);
    }
}
