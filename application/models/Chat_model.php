<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch messages between two users (farmer <-> customer)
public function get_messages($userId, $otherUserId, $lastMessageId = 0) {
    $this->db->select('messages.*, users.first_name, users.last_name');
    $this->db->from('messages');
    $this->db->join('users', 'users.id = messages.from_user_id'); // Join with users table
    $this->db->where("(from_user_id = $userId AND to_user_id = $otherUserId) 
                      OR (from_user_id = $otherUserId AND to_user_id = $userId)");
    if ($lastMessageId > 0) {
        $this->db->where("messages.id >", $lastMessageId); // Fetch only new messages
    }
    $this->db->order_by('messages.created_at', 'ASC');
    
    return $this->db->get()->result();
}

    

    // Insert a new message
   public function insert_message($fromUserId, $toUserId, $message) {
    $data = [
        'from_user_id' => $fromUserId,
        'to_user_id'   => $toUserId,
        'message'      => $message,
        'is_read'      => 0  // always 0 for new messages
    ];
    return $this->db->insert('messages', $data);
}
public function mark_messages_as_read($currentUserId, $otherUserId) {
    $this->db->where('from_user_id', $otherUserId);
    $this->db->where('to_user_id', $currentUserId);
    $this->db->where('is_read', 0);
    $this->db->update('messages', ['is_read' => 1]);
}
public function count_unread_messages($currentUserId, $otherUserId) {
    $this->db->where('from_user_id', $otherUserId);
    $this->db->where('to_user_id', $currentUserId);
    $this->db->where('is_read', 0);
    return $this->db->count_all_results('messages');
}
public function get_last_message_time($userA, $userB)
{
    $this->db->select_max('created_at'); // or use MAX(timestamp) if it's called that
    $this->db->where("(from_user_id = $userA AND to_user_id = $userB) OR (from_user_id = $userB AND to_user_id = $userA)", NULL, FALSE);
    $query = $this->db->get('messages');

    $result = $query->row_array();
    return $result['created_at'] ?? null;
}

}
