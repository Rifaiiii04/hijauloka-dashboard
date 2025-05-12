<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->select('transaksi.*, user.nama AS nama_pelanggan')
                        ->from('transaksi')
                        ->join('user', 'user.id_user = transaksi.user_id', 'left')
                        ->order_by('transaksi.tanggal_transaksi', 'DESC')
                        ->get()
                        ->result();
    }

    public function get_by_id($id) {
        return $this->db->select('transaksi.*, user.nama AS nama_pelanggan')
                        ->from('transaksi')
                        ->join('user', 'user.id_user = transaksi.user_id', 'left')
                        ->where('transaksi.id_transaksi', $id)
                        ->get()
                        ->row();
    }

    public function get_transaksi_items($id_transaksi) {
        $query = $this->db->query("
        SELECT p.nama_product, oi.subtotal / oi.quantity AS harga, oi.quantity AS jumlah, oi.subtotal
        FROM order_items oi
        JOIN product p ON oi.id_product = p.id_product
        WHERE oi.id_order = (SELECT order_id FROM transaksi WHERE id_transaksi = ?)", 
        array($id_transaksi)
    );
    
        return $query->result();
    }
    
    

    public function insert_transaksi($data) {
        $this->db->insert('transaksi', $data);
        return $this->db->insert_id();
    }

    public function get_today_orders_count() {
        $query = $this->db->query("
            SELECT COUNT(*) as total
            FROM transaksi
            WHERE DATE(tanggal_transaksi) = CURDATE()
        ");
        return $query->row()->total ?? 0;
    }

    public function count_all_transactions() {
        return $this->db->count_all('transaksi');
    }

    public function get_transactions($limit, $offset) {
        $this->db->select('transaksi.*, user.nama as nama_pelanggan');
        $this->db->from('transaksi');
        $this->db->join('orders', 'orders.id_order = transaksi.order_id', 'left');  // Changed from id_order to order_id
        $this->db->join('user', 'user.id_user = orders.id_user', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('transaksi.tanggal_transaksi', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get today's transaction statistics
     * 
     * @return array Array containing count and total_income for today
     */
    public function get_today_stats() {
        $today = date('Y-m-d');
        
        // Get count of today's transactions
        $this->db->where('DATE(tanggal_transaksi)', $today);
        $count = $this->db->count_all_results('transaksi');
        
        // Get sum of today's transaction amounts
        $this->db->select_sum('total_bayar');
        $this->db->where('DATE(tanggal_transaksi)', $today);
        $query = $this->db->get('transaksi');
        $total_income = $query->row()->total_bayar ?? 0;
        
        return [
            'count' => $count,
            'total_income' => $total_income
        ];
    }
}
