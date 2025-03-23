<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index() {
        // Assume user is logged in and we have their user_id in session
        $userId = $this->session->userdata('user_id');
        if (!$userId) {
            redirect('auth/login'); // Or wherever your login page is
            return;
        }

        // Fetch current user data
        $data['user'] = $this->User_model->get_user($userId);

        // Load the profile update form
        $this->load->view('profile_view', $data);
    }

    public function update() {
        $userId = $this->session->userdata('user_id');
        if (!$userId) {
            redirect('auth/login');
            return;
        }

        // Set form validation rules
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
      
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed; reload the form with errors
            $data['user'] = $this->User_model->get_user($userId);
            $this->load->view('profile_view', $data);
        } else {
            // Validation passed; prepare data for update
            $updateData = [
                'first_name'  => $this->input->post('first_name'),
                'last_name'   => $this->input->post('last_name'),
                'phone'      => $this->input->post('mobile'),
                'email'       => $this->input->post('email'),
                'address'     => $this->input->post('address'),
                
                'state'       => $this->input->post('state'),
                'city'        => $this->input->post('city'),
                'postal_code' => $this->input->post('postal_code')
            ];

            $updated = $this->User_model->update_profile($userId, $updateData);
            if ($updated) {
                $this->session->set_flashdata('success', 'Profile updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Error updating profile.');
            }
            redirect('profile');
        }
    }


    public function change_password() {
        // Check if user is logged in
        $userId = $this->session->userdata('user_id');
        if (!$userId) {
            redirect('auth/login');
            return;
        }

        $this->load->view('change_password_view');
    }

    // Handle the form submission
    public function update_password() {
        $userId = $this->session->userdata('user_id');
        if (!$userId) {
            redirect('auth/login');
            return;
        }

        // Set form validation rules
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the form
            $this->load->view('change_password_view');
        } else {
            // Validation passed
            $oldPassword     = $this->input->post('old_password');
            $newPasswordRaw  = $this->input->post('new_password');
            $confirmPassword = $this->input->post('confirm_password');

            // 1. Verify old password
            $validOld = $this->User_model->verify_old_password($userId, $oldPassword);
            if (!$validOld) {
                $this->session->set_flashdata('error', 'Old password is incorrect.');
                redirect('profile/change_password');
                return;
            }

            // 2. Hash new password
            // e.g. using PHP's password_hash
            $newPasswordHash = password_hash($newPasswordRaw, PASSWORD_BCRYPT);

            // 3. Update the DB with the new hashed password
            $updated = $this->User_model->update_password($userId, $newPasswordHash);
            if ($updated) {
                $this->session->set_flashdata('success', 'Password updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Error updating password.');
            }

            redirect('profile/change_password');
        }
    }
    
}
