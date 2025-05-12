<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('text');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        // Pagination configuration
        $config['base_url'] = site_url('blog');
        $config['total_rows'] = $this->Blog_model->count_posts();
        $config['per_page'] = 10;
        $config['uri_segment'] = 2;
        
        // Initialize pagination
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        
        // Get current page
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        
        // Get search term
        $search = $this->input->get('search');
        
        // Get category filter
        $category = $this->input->get('category');
        
        // Get status filter
        $status = $this->input->get('status');
        
        // Get posts
        $data['posts'] = $this->Blog_model->get_posts($config['per_page'], $page, $category, $status, $search);
        $data['categories'] = $this->Blog_model->get_categories();
        $data['total_rows'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        
        $this->load->view('blog/index', $data);
    }
    
    public function create() {
        $data['categories'] = $this->Blog_model->get_categories();
        $data['tags'] = $this->Blog_model->get_tags();
        
        $this->load->view('blog/create', $data);
    }
    
    public function store() {
        // Set validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Validation failed, return to form with errors
            $this->session->set_flashdata('error', validation_errors());
            redirect('blog/create');
        } else {
            // Handle image upload
            $featured_image = '';
            if (!empty($_FILES['featured_image']['name'])) {
                // Set upload configuration
                $config['upload_path'] = './uploads/blog/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create upload directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('featured_image')) {
                    $upload_data = $this->upload->data();
                    $featured_image = 'uploads/blog/' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('blog/create');
                }
            }
            
            // Create slug from title
            $slug = $this->Blog_model->create_slug($this->input->post('title'));
            
            // Prepare post data
            $post_data = [
                'title' => $this->input->post('title'),
                'slug' => $slug,
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt'),
                'category_id' => $this->input->post('category_id'),
                'status' => $this->input->post('status'),
                'author_id' => $this->session->userdata('user_id'),
                'featured_image' => $featured_image
            ];
            
            // Insert post
            $post_id = $this->Blog_model->create_post($post_data);
            
            // Handle tags
            if ($this->input->post('tags')) {
                $this->Blog_model->add_post_tags($post_id, $this->input->post('tags'));
            }
            
            $this->session->set_flashdata('success', 'Artikel berhasil dibuat!');
            redirect('blog');
        }
    }
    
    public function edit($id) {
        $data['post'] = $this->Blog_model->get_post($id);
        
        if (!$data['post']) {
            $this->session->set_flashdata('error', 'Artikel tidak ditemukan!');
            redirect('blog');
        }
        
        $data['categories'] = $this->Blog_model->get_categories();
        $data['tags'] = $this->Blog_model->get_tags();
        $data['post_tags'] = $this->Blog_model->get_post_tags($id);
        
        $this->load->view('blog/edit', $data);
    }
    
    public function update($id) {
        // Set validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Validation failed, return to form with errors
            $this->session->set_flashdata('error', validation_errors());
            redirect('blog/edit/' . $id);
        } else {
            // Get current post
            $post = $this->Blog_model->get_post($id);
            
            if (!$post) {
                $this->session->set_flashdata('error', 'Artikel tidak ditemukan!');
                redirect('blog');
            }
            
            // Handle image upload
            $featured_image = $post->featured_image;
            if (!empty($_FILES['featured_image']['name'])) {
                // Set upload configuration
                $config['upload_path'] = './uploads/blog/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create upload directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('featured_image')) {
                    $upload_data = $this->upload->data();
                    $featured_image = 'uploads/blog/' . $upload_data['file_name'];
                    
                    // Delete old image if exists
                    if ($post->featured_image && file_exists('./' . $post->featured_image)) {
                        unlink('./' . $post->featured_image);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('blog/edit/' . $id);
                }
            }
            
            // Create slug from title if title has changed
            $slug = $post->slug;
            if ($post->title != $this->input->post('title')) {
                $slug = $this->Blog_model->create_slug($this->input->post('title'), $id);
            }
            
            // Prepare post data
            $post_data = [
                'title' => $this->input->post('title'),
                'slug' => $slug,
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt'),
                'category_id' => $this->input->post('category_id'),
                'status' => $this->input->post('status'),
                'featured_image' => $featured_image
            ];
            
            // Update post
            $this->Blog_model->update_post($id, $post_data);
            
            // Handle tags
            if ($this->input->post('tags')) {
                $this->Blog_model->add_post_tags($id, $this->input->post('tags'));
            }
            
            $this->session->set_flashdata('success', 'Artikel berhasil diperbarui!');
            redirect('blog');
        }
    }
    
    public function delete($id) {
        $post = $this->Blog_model->get_post($id);
        
        if (!$post) {
            $this->session->set_flashdata('error', 'Artikel tidak ditemukan!');
            redirect('blog');
        }
        
        // Delete featured image if exists
        if ($post->featured_image && file_exists('./' . $post->featured_image)) {
            unlink('./' . $post->featured_image);
        }
        
        // Delete post
        $this->Blog_model->delete_post($id);
        
        $this->session->set_flashdata('success', 'Artikel berhasil dihapus!');
        redirect('blog');
    }
    
    public function categories() {
        $data['categories'] = $this->Blog_model->get_categories();
        $this->load->view('blog/categories', $data);
    }
    
    public function create_category() {
        // Set validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Validation failed, return to form with errors
            $this->session->set_flashdata('error', validation_errors());
            redirect('blog/categories');
        } else {
            // Create slug from name
            $slug = url_title($this->input->post('name'), '-', TRUE);
            
            // Prepare category data
            $category_data = [
                'name' => $this->input->post('name'),
                'slug' => $slug
            ];
            
            // Insert category
            $this->Blog_model->create_category($category_data);
            
            $this->session->set_flashdata('success', 'Kategori berhasil dibuat!');
            redirect('blog/categories');
        }
    }
    
    public function update_category() {
        // Set validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('id', 'ID', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Validation failed, return to form with errors
            $this->session->set_flashdata('error', validation_errors());
            redirect('blog/categories');
        } else {
            // Create slug from name
            $slug = url_title($this->input->post('name'), '-', TRUE);
            
            // Prepare category data
            $category_data = [
                'name' => $this->input->post('name'),
                'slug' => $slug
            ];
            
            // Update category
            $this->Blog_model->update_category($this->input->post('id'), $category_data);
            
            $this->session->set_flashdata('success', 'Kategori berhasil diperbarui!');
            redirect('blog/categories');
        }
    }
    
    public function delete_category($id) {
        // Delete category
        $this->Blog_model->delete_category($id);
        
        $this->session->set_flashdata('success', 'Kategori berhasil dihapus!');
        redirect('blog/categories');
    }
}