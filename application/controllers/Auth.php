<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->database(); // Load database
    }

    public function index() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        // Validasi form
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
            return;
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        try {
            $admin = $this->Admin_model->get_admin_by_email($email);
            
            if (!$admin) {
                $this->session->set_flashdata('error', 'Email atau password salah!');
                redirect('auth');
                return;
            }

            if (password_verify($password, $admin->password)) {
                // Set session data
                $session_data = [
                    'id_admin' => $admin->id_admin,
                    'nama' => $admin->nama,
                    'email' => $admin->email,
                    'logged_in' => TRUE
                ];

                // Set session tanpa memanggil session_start()
                $this->session->set_userdata($session_data);

                // Redirect ke dashboard
                $this->session->set_flashdata('success', 'Login berhasil!');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah!');
                redirect('auth');
            }

        } catch (Exception $e) {
            log_message('error', 'Login error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            redirect('auth');
        }
    }

    public function reset_password() {
        // Hanya boleh dilakukan jika sudah login
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
        // Hapus session
        $this->session->unset_userdata([
            'id_admin', 'nama', 'email', 'logged_in'
        ]);
        $this->session->sess_destroy();

        // Redirect ke halaman login
        redirect('auth');
    }
}
