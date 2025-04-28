<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
         $this->load->database(); // Ensure database is loaded
         $this->load->helper('string');
         $this->load->library('email');
    }
 
    // User Registration
    public function register() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
 $this->form_validation->set_rules(
    'phone',
    'Phone',
    'trim|required|regex_match[/^[0-9]{1,10}$/]',
    [
        'regex_match' => 'The {field} field must be a valid numeric phone number (up to 10 digits).'
    ]
);
       $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]');

        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => false, 'message' => validation_errors()]);
        } else {
            $data = [
                'user_type' => $this->input->post('user_type'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'address' => $this->input->post('address'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'postal_code' => $this->input->post('postal_code')
            ];

            if ($this->User_model->register_user($data)) {
                echo json_encode(['status' => true, 'message' => 'Registration successful!']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Registration failed!']);
            }
        }
    }

    // User Login
     public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->login_user($email, $password);

        if ($user) {
            $session_data = [
                'user_id' => $user->id,
                'user_type' => $user->user_type,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'logged_in' => true
            ];
            $this->session->set_userdata($session_data);
            echo json_encode(['status' => true, 'user_type'=> $user->user_type, 'message' => 'Login successful!']);
             
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid email or password!']);
        }
    }

    // Logout
    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url()); // Redirect to homepage
    }
      public function forgot_password() {
        $this->load->view('forgot_password_view');
    }
public function process_forgot_password() {
        // Validate email
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('forgot_password_view');
        } else {
            $email = $this->input->post('email');
            $user = $this->User_model->get_user_by_email($email);

            if (!$user) {
                $this->session->set_flashdata('error', 'Email not found.');
                redirect('auth/forgot_password');
                return;
            }

            // Generate reset token
            $token = random_string('alnum', 40); // e.g. a 40-char random token

            // Save token in DB
            $this->User_model->set_reset_token($user->id, $token);

            // Build reset link
            $resetLink = base_url("auth/reset_password/".$token);

            // Send email (this is a simplified example)
            $subject = "Password Reset";
            $message = "Click the link to reset your password: ".$resetLink;
            // Use CodeIgniter's email library or any other method
            // For demonstration, let's assume we do a quick mail():
              $this->email->from($email, 'Your Name');
        $this->email->to($email);
        // You can set multiple recipients using $this->email->to(array('person1@example.com','person2@example.com'));

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'A password reset link has been sent to your email.');
             redirect('auth/forgot_password');
        } else {
            // Print debug info or log it
            echo $this->email->print_debugger();

        }

          
           
        }
    }

    // Step 3: Reset password form
    public function reset_password($token = null) {
        if (!$token) {
            show_error('Invalid password reset token.');
            return;
        }

        // Verify token
        $user = $this->User_model->verify_reset_token($token);
        if (!$user) {
            show_error('Invalid or expired token.');
            return;
        }

        $data['token'] = $token;
        $this->load->view('reset_password_view', $data);
    }

    // Step 4: Update password in DB
    public function process_reset_password() {
        $token = $this->input->post('token');
        $user = $this->User_model->verify_reset_token($token);
        if (!$user) {
            show_error('Invalid or expired token.');
            return;
        }

        // Validate new password
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
        if ($this->form_validation->run() == FALSE) {
            $data['token'] = $token;
            $this->load->view('reset_password_view', $data);
        } else {
            // Hash the new password
            $newPasswordRaw = $this->input->post('new_password');
            $hashedPassword = password_hash($newPasswordRaw, PASSWORD_BCRYPT);

            // Update DB
            $this->User_model->update_password_and_clear_token($user->id, $hashedPassword);

            $this->session->set_flashdata('success', 'Password updated successfully! You can now log in.');
            redirect(base_url());
        }
    }
}
?>
