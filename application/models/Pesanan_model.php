<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mengambil semua data pesanan dengan join lengkap (untuk tampilan detail)
    public function get_all_pesanan() {
        $this->db->select('
            orders.*, 
            user.nama AS nama_pelanggan, 
            order_items.id_product, 
            order_items.quantity, 
            order_items.subtotal, 
            product.nama_product
        ');
        $this->db->from('orders');
        $this->db->join('user', 'user.id_user = orders.id_user', 'left');
        $this->db->join('order_items', 'order_items.id_order = orders.id_order', 'left');
        $this->db->join('product', 'product.id_product = order_items.id_product', 'left');
        $query = $this->db->get();

        $result = [];
        foreach ($query->result() as $row) {
            $id_order = $row->id_order;
            if (!isset($result[$id_order])) {
                $result[$id_order] = (object)[
                    'id_order'         => $row->id_order,
                    'nama_pelanggan'   => $row->nama_pelanggan,
                    'tgl_pemesanan'    => $row->tgl_pemesanan,
                    'stts_pemesanan'   => $row->stts_pemesanan,
                    'stts_pembayaran'  => $row->stts_pembayaran,
                    'total_harga'      => $row->total_harga,
                    'tgl_dikirim'      => $row->tgl_dikirim,
                    'tgl_selesai'      => $row->tgl_selesai,
                    'tgl_batal'        => $row->tgl_batal,
                    'produk'           => []
                ];
            }
            if (!empty($row->id_product)) {
                $result[$id_order]->produk[] = (object)[
                    'nama_produk' => $row->nama_product,
                    'quantity'    => $row->quantity,
                    'subtotal'    => $row->subtotal
                ];
            }
        }
        return array_values($result);
    }

    // Metode sederhana untuk mengambil data orders (tanpa join kompleks)
    public function get_all_orders() {
        return $this->db->get('orders')->result();
    }

    // Mengambil data pesanan berdasarkan id_order
    public function get_pesanan_by_id($id_order) {
        return $this->db->get_where('orders', ['id_order' => $id_order])->row();
    }

    // Insert pesanan baru ke tabel orders
    public function insert($data) {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    // Update pesanan (misalnya update status)
    public function update_status($id_order, $data) {
        $this->db->where('id_order', $id_order);
        return $this->db->update('orders', $data);
    }

    // Menghapus pesanan dan detailnya
    public function delete_pesanan($id_order) {
        // Hapus detail terlebih dahulu
        $this->db->where('id_order', $id_order);
        $this->db->delete('order_items');
        // Hapus pesanan
        $this->db->where('id_order', $id_order);
        return $this->db->delete('orders');
    }
}
