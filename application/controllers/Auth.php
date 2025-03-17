<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $admin = $this->Admin_model->get_admin_by_email($email);

        if ($admin && password_verify($password, $admin->password)) {
            // Set session
            $session_data = [
                'id_admin' => $admin->id_admin,
                'nama' => $admin->nama,
                'email' => $admin->email,
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Email atau password salah!');
            redirect('auth');
        }
    }

    public function reset_password() {
        // Pastikan hanya admin yang bisa melakukan reset
        if (!$this->session->userdata('logged_in')) {
            show_error('Akses ditolak!', 403);
            return;
        }
    
        $email = 'admin@hijauloka.com'; 
        $new_password = 'admin123'; 
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
        $this->Admin_model->update_password_by_email($email, $hashed_password);
    
        echo "Password berhasil diupdate!";
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
