<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Review_model');
        $this->load->model('Produk_model'); // Changed from Product_model to Produk_model
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        // Pagination configuration
        $config['base_url'] = site_url('review');
        $config['total_rows'] = $this->Review_model->count_reviews();
        $config['per_page'] = 10;
        $config['uri_segment'] = 2;
        
        // Initialize pagination
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        
        // Get current page
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        
        // Get filter parameters
        $status = $this->input->get('status');
        $product = $this->input->get('product');
        $rating = $this->input->get('rating');
        
        // Get reviews
        $data['reviews'] = $this->Review_model->get_reviews($config['per_page'], $page, $status, $product, $rating);
        $data['products'] = $this->Produk_model->get_all(); // Changed to use get_all() method
        $data['total_rows'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        
        $this->load->view('review/index', $data);
    }
    
    public function view($id) {
        $data['review'] = $this->Review_model->get_review($id);
        
        if (!$data['review']) {
            $this->session->set_flashdata('error', 'Review tidak ditemukan!');
            redirect('review');
        }
        
        $this->load->view('review/view', $data);
    }
    
    public function approve($id) {
        $review = $this->Review_model->get_review($id);
        
        if (!$review) {
            $this->session->set_flashdata('error', 'Review tidak ditemukan!');
            redirect('review');
        }
        
        // Update review status
        $this->Review_model->update_review_status($id, 'disetujui');
        
        // Update product rating
        $this->Review_model->update_product_rating($review->id_product);
        
        $this->session->set_flashdata('success', 'Review berhasil disetujui.');
        redirect('review');
    }
    
    public function reject($id) {
        $review = $this->Review_model->get_review($id);
        
        if (!$review) {
            $this->session->set_flashdata('error', 'Review tidak ditemukan!');
            redirect('review');
        }
        
        // Update review status
        $this->Review_model->update_review_status($id, 'ditolak');
        
        $this->session->set_flashdata('success', 'Review berhasil ditolak.');
        redirect('review');
    }
    
    public function delete($id) {
        $review = $this->Review_model->get_review($id);
        
        if (!$review) {
            $this->session->set_flashdata('error', 'Review tidak ditemukan!');
            redirect('review');
        }
        
        // Delete review
        $this->Review_model->delete_review($id);
        
        // Update product rating
        $this->Review_model->update_product_rating($review->id_product);
        
        $this->session->set_flashdata('success', 'Review berhasil dihapus.');
        redirect('review');
    }
}