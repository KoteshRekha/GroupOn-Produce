<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Insert user data (Registration)
    public function register_user($data) {
        return $this->db->insert('users', $data);
    }

    // Check login credentials
    public function login_user($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user; // Login successful
            }
        }
        return false; // Login failed
    }
     public function get_user($userId) {
        $this->db->where('id', $userId);
        $query = $this->db->get('users'); // Your user table
        return $query->row(); // Returns a single row object
    }

    // Update user profile
    public function update_profile($userId, $data) {
        $this->db->where('id', $userId);
        return $this->db->update('users', $data);
    }
    public function verify_old_password($userId, $oldPassword) {
        $this->db->where('id', $userId);
        $query = $this->db->get('users');
        $user = $query->row();

        if (!$user) {
            return false; // user not found
        }

        // Compare hashed password with user input
        // For example, if you're using password_hash:
        if (password_verify($oldPassword, $user->password)) {
            return true;
        }
        return false;
    }

    // Update the user password
    // newPassword is already hashed at the controller level (recommended).
    public function update_password($userId, $newPassword) {
        $this->db->where('id', $userId);
        return $this->db->update('users', ['password' => $newPassword]);
    }

     // Check if email exists and return user record
    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row(); // single user object or null
    }

    // Store reset token and expiry in DB
    public function set_reset_token($userId, $token) {
        $data = [
            'reset_token' => $token,
            'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour')) // token valid for 1 hour
        ];
        $this->db->where('id', $userId);
        return $this->db->update('users', $data);
    }

    // Verify token and check if not expired
    public function verify_reset_token($token) {
        $this->db->where('reset_token', $token);
        $this->db->where('reset_expires >=', date('Y-m-d H:i:s')); // token not expired
        $query = $this->db->get('users');
        return $query->row(); // returns user record if valid, otherwise null
    }

    // Clear token and set new password
    public function update_password_and_clear_token($userId, $hashedPassword) {
        $data = [
            'password' => $hashedPassword,
            'reset_token' => null,
            'reset_expires' => null
        ];
        $this->db->where('id', $userId);
        return $this->db->update('users', $data);
    }
    public function get_all_users_except($userId)
{
    $this->db->where('id !=', $userId);
    $query = $this->db->get('users');
    return $query->result_array();  // or ->result() depending on your preference
}

}
?>
