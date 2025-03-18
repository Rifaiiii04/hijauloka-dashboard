<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Memuat database
    }

    // Mengambil semua data pesanan beserta detail produk
    public function get_all_pesanan() {
        // Sesuaikan nama tabel dan kolom
        $this->db->select('orders.*, user.nama as nama_pelanggan, order_items.id_product, order_items.quantity, order_items.subtotal, product.nama_product');
        $this->db->from('orders');
        $this->db->join('user', 'user.id_user = orders.id_user');
        $this->db->join('order_items', 'order_items.id_order = orders.id_order');
        $this->db->join('product', 'product.id_product = order_items.id_product'); // Gunakan 'product' bukan 'products'
        $query = $this->db->get();
    
        $result = [];
        foreach ($query->result() as $row) {
            $id_order = $row->id_order;
            if (!isset($result[$id_order])) {
                $result[$id_order] = (object) array( // Konversi ke OBJEK
                    'id_order' => $row->id_order,
                    'nama_pelanggan' => $row->nama_pelanggan,
                    'tgl_pemesanan' => $row->tgl_pemesanan,
                    'stts_pemesanan' => $row->stts_pemesanan,
                    'total_harga' => $row->total_harga,
                    'produk' => []
                );
            }
            $result[$id_order]->produk[] = (object) array( // Konversi ke OBJEK
                'nama_produk' => $row->nama_product,
                'quantity' => $row->quantity,
                'subtotal' => $row->subtotal
            );
        }
    
        return array_values($result);
    }

    // Menyimpan data pesanan baru
    public function insert_pesanan($data) {
        $this->db->insert('orders', $data); // Simpan data ke tabel orders
        return $this->db->insert_id(); // Kembalikan ID pesanan yang baru dibuat
    }

    // Menghapus data pesanan
    public function delete_pesanan($id_order) {
        $this->db->where('id_order', $id_order);
        $this->db->delete('orders'); // Hapus data dari tabel orders
    }

    // Ambil data pesanan berdasarkan ID
public function get_pesanan_by_id($id_order) {
    $this->db->where('id_order', $id_order);
    return $this->db->get('orders')->row();
    return $this->db->get_where('product', ['id_product' => $id])->row();
}

// Update data pesanan
public function update_pesanan($id_order, $data) {
    
    // Ambil data status sebelumnya
    $current_data = $this->db->get_where('orders', ['id_order' => $id_order])->row();
    
    // Jika status berubah, set tanggal sesuai status baru
    if ($data['stts_pemesanan'] != $current_data->stts_pemesanan) {
        $new_status = $data['stts_pemesanan'];
        $tanggal_fields = [
            'dikirim'   => 'tgl_dikirim',
            'selesai'   => 'tgl_selesai',
            'dibatalkan' => 'tgl_batal'
        ];

        if (array_key_exists($new_status, $tanggal_fields)) {
            $data[$tanggal_fields[$new_status]] = date('Y-m-d H:i:s');
        }
    }
    $this->db->where('id_product', $id);
    return $this->db->update('product', $data);
    $this->db->where('id_order', $id_order);
    $this->db->update('orders', $data);
}
}