<?php
class Transaksi_model extends CI_Model {

    public function get_all() {
        return $this->db->select('transaksi.*, user.nama AS nama_pelanggan') 
                ->join('user', 'user.id_user = transaksi.user_id', 'left')  // Ganti id_user dengan user_id
                ->order_by('transaksi.tanggal_transaksi', 'DESC')  // Sesuaikan dengan nama kolom yang benar
                ->get('transaksi') 
                ->result();
    }

    public function get_by_id($id) {
        return $this->db->select('transaksi.*, user.nama AS nama_pelanggan')  // Ganti nama_pelanggan dengan nama user
                        ->join('user', 'user.id_user = transaksi.user_id', 'left')  // Ganti id_user dengan user_id
                        ->get_where('transaksi', ['id_transaksi' => $id])
                        ->row();
    }

    public function get_transaksi_items($id) {
        return $this->db->select('detail_transaksi.*, product.nama_product')  // Ubah transaksi_detail menjadi detail_transaksi
                        ->join('product', 'product.id_product = detail_transaksi.id_product', 'left')  // Ubah transaksi_detail menjadi detail_transaksi
                        ->get_where('detail_transaksi', ['id_transaksi' => $id])  // Ubah transaksi_detail menjadi detail_transaksi
                        ->result();  // Mengembalikan hasil sebagai array objek
    }
    
}
