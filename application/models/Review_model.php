<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Get all reviews with pagination and filters
    public function get_reviews($limit = 10, $offset = 0, $status = null, $product = null, $rating = null) {
        $this->db->select('review_rating.*, product.nama_product, user.nama as nama_user');
        $this->db->from('review_rating');
        $this->db->join('product', 'product.id_product = review_rating.id_product', 'left');
        $this->db->join('user', 'user.id_user = review_rating.id_user', 'left');
        
        if ($status) {
            $this->db->where('review_rating.stts_review', $status);
        }
        
        if ($product) {
            $this->db->where('review_rating.id_product', $product);
        }
        
        if ($rating) {
            $this->db->where('review_rating.rating', $rating);
        }
        
        $this->db->order_by('review_rating.tgl_review', 'DESC');
        $this->db->limit($limit, $offset);
        
        return $this->db->get()->result();
    }
    
    // Count all reviews
    public function count_reviews($status = null, $product = null, $rating = null) {
        $this->db->from('review_rating');
        
        if ($status) {
            $this->db->where('stts_review', $status);
        }
        
        if ($product) {
            $this->db->where('id_product', $product);
        }
        
        if ($rating) {
            $this->db->where('rating', $rating);
        }
        
        return $this->db->count_all_results();
    }
    
    // Get a single review by ID
    public function get_review($id) {
        $this->db->select('review_rating.*, product.nama_product, user.nama as nama_user, orders.id_order');
        $this->db->from('review_rating');
        $this->db->join('product', 'product.id_product = review_rating.id_product', 'left');
        $this->db->join('user', 'user.id_user = review_rating.id_user', 'left');
        $this->db->join('orders', 'orders.id_order = review_rating.id_order', 'left');
        $this->db->where('review_rating.id_review', $id);
        
        return $this->db->get()->row();
    }
    
    // Update review status
    public function update_review_status($id, $status) {
        $this->db->where('id_review', $id);
        return $this->db->update('review_rating', ['stts_review' => $status]);
    }
    
    // Delete a review
    public function delete_review($id) {
        $this->db->where('id_review', $id);
        return $this->db->delete('review_rating');
    }
    
    // Update product rating
    public function update_product_rating($product_id) {
        // Calculate average rating from approved reviews
        $this->db->select_avg('rating');
        $this->db->where('id_product', $product_id);
        $this->db->where('stts_review', 'disetujui');
        $query = $this->db->get('review_rating');
        $avg_rating = $query->row()->rating;
        
        // Update product rating
        $this->db->where('id_product', $product_id);
        return $this->db->update('product', ['rating' => $avg_rating ? round($avg_rating, 1) : NULL]);
    }
    
    // Get review statistics
    public function get_review_stats() {
        $stats = [];
        
        // Total reviews
        $this->db->from('review_rating');
        $stats['total'] = $this->db->count_all_results();
        
        // Pending reviews
        $this->db->from('review_rating');
        $this->db->where('stts_review', 'pending');
        $stats['pending'] = $this->db->count_all_results();
        
        // Approved reviews
        $this->db->from('review_rating');
        $this->db->where('stts_review', 'disetujui');
        $stats['approved'] = $this->db->count_all_results();
        
        // Rejected reviews
        $this->db->from('review_rating');
        $this->db->where('stts_review', 'ditolak');
        $stats['rejected'] = $this->db->count_all_results();
        
        return $stats;
    }
}