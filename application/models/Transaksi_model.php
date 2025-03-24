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
}
