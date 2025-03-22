<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pesanan_model'); // Load model Pesanan
        $this->load->model('Produk_model');  // Load model Produk
        $this->load->helper('url');          // Load helper URL
        $this->load->library('form_validation'); // Load library form validation
    }

    // Menampilkan daftar pesanan
    public function index() {
        // Gunakan method get_all_pesanan() yang ada di model Pesanan_model
        $data['pesanan'] = $this->Pesanan_model->get_all_pesanan();
        $data['users']   = $this->db->get('user')->result();
        $data['products']= $this->db->get('product')->result();
        $this->load->view('pesanan', $data);
    }

    // Membuat pesanan baru
    public function create() {
        // Ambil data dari form
        $id_user         = $this->input->post('id_user');
        $produk          = $this->input->post('produk');      // Array produk
        $jumlah          = $this->input->post('jumlah');      // Array jumlah tiap produk
        $stts_pemesanan  = $this->input->post('stts_pemesanan');
        $stts_pembayaran = $this->input->post('stts_pembayaran');
        $id_admin        = $this->input->post('id_admin');
        $total_harga     = 0;
    
        // Debug POST data
        error_log("POST data: " . print_r($this->input->post(), true));
    
        // Validasi stok produk
        foreach ($produk as $index => $id_product) {
            $product = $this->Produk_model->get_by_id($id_product);
            if (!$product) {
                $this->session->set_flashdata('error', 'Produk tidak ditemukan untuk ID: ' . $id_product);
                redirect('pesanan');
            }
            if ($product->stok < $jumlah[$index]) {
                $this->session->set_flashdata('error', 'Stok tidak mencukupi untuk ' . $product->nama_product);
                redirect('pesanan');
            }
            $total_harga += $product->harga * $jumlah[$index];
        }
    
        // Mulai transaksi database
        $this->db->trans_start();
    
        try {
            $order_data = [
                'id_user'         => $id_user,
                'tgl_pemesanan'   => date('Y-m-d H:i:s'),
                'stts_pemesanan'  => $stts_pemesanan,
                'stts_pembayaran' => $stts_pembayaran,
                'total_harga'     => $total_harga,
                'id_admin'        => $id_admin
            ];
            $id_order = $this->Pesanan_model->insert($order_data);
            if (!$id_order) {
                throw new Exception("Insert pesanan gagal.");
            }
    
            // Simpan detail pesanan dan update stok
            foreach ($produk as $index => $id_product) {
                $product = $this->Produk_model->get_by_id($id_product);
                $new_stock = $product->stok - $jumlah[$index];
                $this->Produk_model->update($id_product, ['stok' => $new_stock]);
                $order_item = [
                    'id_order'   => $id_order,
                    'id_product' => $id_product,
                    'quantity'   => $jumlah[$index],
                    'subtotal'   => $product->harga * $jumlah[$index]
                ];
                $this->db->insert('order_items', $order_item);
            }
    
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Pesanan berhasil dibuat.');
        } catch (Exception $e) {
            $this->db->trans_rollback();
            error_log("Error create pesanan: " . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    
        redirect('pesanan');
    }

    // Menghapus pesanan
    public function delete($id_order) {
        $pesanan = $this->Pesanan_model->get_pesanan_by_id($id_order);
        if (!$pesanan) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('pesanan');
        }
    
        // Hapus detail pesanan terlebih dahulu
        $this->db->where('id_order', $id_order);
        $this->db->delete('order_items');
    
        // Hapus pesanan dari tabel orders
        $this->Pesanan_model->delete_pesanan($id_order);
        $this->session->set_flashdata('success', 'Pesanan berhasil dihapus.');
        redirect('pesanan');
    }

    // Mengambil data pesanan via AJAX untuk form edit status
    public function get_status($id_order) {
        $order = $this->Pesanan_model->get_pesanan_by_id($id_order);
        echo json_encode($order);
    }

    // Mengupdate status pesanan (edit hanya status)
    public function update_status() {
        $id_order = $this->input->post('id_order');
        $stts_pemesanan = $this->input->post('stts_pemesanan');
        $stts_pembayaran = $this->input->post('stts_pembayaran');
    
        error_log("Update order: " . print_r($this->input->post(), true));
    
        if (empty($id_order)) {
            $this->session->set_flashdata('error', 'ID pesanan tidak ditemukan.');
            redirect('pesanan');
        }
    
        $data = [
            'stts_pemesanan'  => $stts_pemesanan,
            'stts_pembayaran' => $stts_pembayaran
        ];
    
        if ($this->Pesanan_model->update_status($id_order, $data)) {
            $this->session->set_flashdata('success', 'Status pesanan berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status.');
        }
        redirect('pesanan');
    }
}
