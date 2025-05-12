<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Get all blog posts with pagination
    public function get_posts($limit = 10, $offset = 0, $category_id = null, $status = null, $search = null) {
        $this->db->select('blog_posts.*, blog_categories.name as category_name, user.nama as author_name');
        $this->db->from('blog_posts');
        $this->db->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left');
        $this->db->join('user', 'user.id_user = blog_posts.author_id', 'left');
        
        if ($category_id) {
            $this->db->where('blog_posts.category_id', $category_id);
        }
        
        if ($status) {
            $this->db->where('blog_posts.status', $status);
        }
        
        if ($search) {
            $this->db->like('blog_posts.title', $search);
        }
        
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        return $this->db->get()->result();
    }
    
    // Count all blog posts
    public function count_posts($category = null, $status = null, $search = null) {
        $this->db->from('blog_posts');
        
        if ($category) {
            $this->db->where('category_id', $category);
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('content', $search);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }
    
    // Get a single blog post by ID
    public function get_post($id) {
        $this->db->select('blog_posts.*, blog_categories.name as category_name, user.nama as author_name');
        $this->db->from('blog_posts');
        $this->db->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left');
        $this->db->join('user', 'user.id_user = blog_posts.author_id', 'left');
        $this->db->where('blog_posts.id', $id);
        
        return $this->db->get()->row();
    }
    
    // Get a single blog post by slug
    public function get_post_by_slug($slug) {
        $this->db->select('blog_posts.*, blog_categories.name as category_name, user.nama as author_name');
        $this->db->from('blog_posts');
        $this->db->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left');
        $this->db->join('user', 'user.id_user = blog_posts.author_id', 'left');
        $this->db->where('blog_posts.slug', $slug);
        
        return $this->db->get()->row();
    }
    
    // Create a new blog post
    // Add these methods to your Blog_model if they don't exist
    
    public function create_post($data)
    {
        $this->db->insert('blog_posts', $data);
        return $this->db->insert_id();
    }
    
    public function check_slug_exists($slug)
    {
        $query = $this->db->get_where('blog_posts', ['slug' => $slug]);
        return $query->num_rows() > 0;
    }
    
    // Update a blog post
    public function update_post($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('blog_posts', $data);
    }
    
    // Delete a blog post
    public function delete_post($id) {
        $this->db->where('id', $id);
        return $this->db->delete('blog_posts');
    }
    
    // Get all categories
    public function get_categories() {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('blog_categories')->result();
    }
    
    // Create a new category
    public function create_category($data) {
        $this->db->insert('blog_categories', $data);
        return $this->db->insert_id();
    }
    
    // Update a category
    public function update_category($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('blog_categories', $data);
    }
    
    // Delete a category
    public function delete_category($id) {
        $this->db->where('id', $id);
        return $this->db->delete('blog_categories');
    }
    
    // Get all tags
    public function get_tags() {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('blog_tags')->result();
    }
    
    // Get tags for a post
    public function get_post_tags($post_id) {
        // Check if the blog_post_tags table exists
        if ($this->db->table_exists('blog_post_tags')) {
            $this->db->select('blog_tags.*');
            $this->db->from('blog_tags');
            $this->db->join('blog_post_tags', 'blog_post_tags.tag_id = blog_tags.id');
            $this->db->where('blog_post_tags.post_id', $post_id);
            $this->db->order_by('blog_tags.name', 'ASC');
            
            return $this->db->get()->result();
        }
        
        // Return empty array if table doesn't exist
        return array();
    }
    
    // Add tags to a post
    public function add_post_tags($post_id, $tag_ids) {
        // Check if the blog_post_tags table exists
        if (!$this->db->table_exists('blog_post_tags')) {
            // Table doesn't exist, so we can't add tags
            return false;
        }
        
        // First remove all existing tags
        $this->db->where('post_id', $post_id);
        $this->db->delete('blog_post_tags');
        
        // Then add the new tags
        if (!empty($tag_ids)) {
            foreach ($tag_ids as $tag_id) {
                $this->db->insert('blog_post_tags', [
                    'post_id' => $post_id,
                    'tag_id' => $tag_id
                ]);
            }
        }
        
        return true;
    }
    
    // Create a slug from a title
    public function create_slug($title, $id = 0) {
        $slug = url_title($title, '-', TRUE);
        $slug = strtolower($slug);
        
        // Check if slug exists
        $this->db->select('slug');
        $this->db->from('blog_posts');
        $this->db->where('slug', $slug);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            // Slug exists, add a number to make it unique
            $count = 1;
            $new_slug = $slug;
            
            while (true) {
                $new_slug = $slug . '-' . $count;
                $this->db->select('slug');
                $this->db->from('blog_posts');
                $this->db->where('slug', $new_slug);
                if ($id) {
                    $this->db->where('id !=', $id);
                }
                $query = $this->db->get();
                
                if ($query->num_rows() == 0) {
                    return $new_slug;
                }
                
                $count++;
            }
        }
        
        return $slug;
    }
}