<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        if (!$this->session->userdata('id_admin')) {
            redirect('login'); 
        }
    }

    public function index() {
        // Get current page from URL
        $page = ($this->input->get('page')) ? $this->input->get('page') : 1;
        $per_page = 10;
        
        // Calculate offset
        $offset = ($page - 1) * $per_page;
        
        // Get total rows for pagination
        $total_rows = $this->User_model->count_all();
        
        // Get users for current page
        $data['users'] = $this->User_model->get_paginated($per_page, $offset);
        
        // Pagination data
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_rows'] = $total_rows;
        $data['total_pages'] = ceil($total_rows / $per_page);

        $this->load->view('user_management', $data);
    }

    // Hapus user
    public function delete($id) {
        $result = $this->User_model->delete($id);

        if ($result) {
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user.');
        }

        redirect('user');
    }
}