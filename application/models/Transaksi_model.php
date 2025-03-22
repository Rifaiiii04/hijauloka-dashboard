<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mengambil semua data transaksi beserta nama pelanggan
    public function get_all() {
        return $this->db->select('transaksi.*, user.nama AS nama_pelanggan')
                        ->from('transaksi')
                        ->join('user', 'user.id_user = transaksi.user_id', 'left')
                        ->order_by('transaksi.tanggal_transaksi', 'DESC')
                        ->get()
                        ->result();
    }

    // Mengambil data transaksi berdasarkan id_transaksi
    public function get_by_id($id) {
        return $this->db->select('transaksi.*, user.nama AS nama_pelanggan')
                        ->from('transaksi')
                        ->join('user', 'user.id_user = transaksi.user_id', 'left')
                        ->where('transaksi.id_transaksi', $id)
                        ->get()
                        ->row();
    }

    // Mengambil item detail transaksi berdasarkan id_transaksi
    public function get_transaksi_items($id) {
        return $this->db->select('detail_transaksi.*, product.nama_product, product.harga')
                        ->from('detail_transaksi')
                        ->join('product', 'product.id_product = detail_transaksi.id_product', 'left')
                        ->where('detail_transaksi.id_transaksi', $id)
                        ->get()
                        ->result();
    }

    // Insert transaksi baru ke tabel transaksi
    public function insert_transaksi($data) {
        $this->db->insert('transaksi', $data);
        return $this->db->insert_id();
    }
}
