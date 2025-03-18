<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pesanan_model'); // Memuat model
        $this->load->helper('url'); // Memuat helper URL
        $this->load->library('form_validation'); // Memuat library form validation
    }

    // Menampilkan daftar pesanan
    public function index() {
        // Ambil data pesanan
        $data['pesanan'] = $this->Pesanan_model->get_all_pesanan();
    
        // Ambil data user dan produk untuk dropdown
        $data['users'] = $this->db->get('user')->result();
        $data['products'] = $this->db->get('product')->result();
    
        $this->load->view('pesanan', $data);
   
    }

    // Menambahkan pesanan baru
    public function create() {
        // Ambil data dari form
        $id_user = $this->input->post('id_user');
        $produk = $this->input->post('produk');
        $jumlah = $this->input->post('jumlah');
        $stts_pemesanan = $this->input->post('stts_pemesanan');
    
        // Hitung total harga
        $total_harga = 0;
        foreach ($produk as $index => $id_product) {
            $product = $this->db->get_where('product', ['id_product' => $id_product])->row();
            $subtotal = $product->harga * $jumlah[$index];
            $total_harga += $subtotal;
        }
    
        // Simpan data order
        $order_data = [
            'id_user' => $id_user,
            'tgl_pemesanan' => date('Y-m-d H:i:s'),
            'stts_pemesanan' => $stts_pemesanan,
            'total_harga' => $total_harga,
            'id_admin' => $this->input->post('id_admin')
        ];
        $this->db->insert('orders', $order_data);
        $id_order = $this->db->insert_id();
    
        // Simpan detail produk ke order_items
        foreach ($produk as $index => $id_product) {
            $product = $this->db->get_where('product', ['id_product' => $id_product])->row();
            $subtotal = $product->harga * $jumlah[$index];
    
            $order_item = [
                'id_order' => $id_order,
                'id_product' => $id_product,
                'quantity' => $jumlah[$index],
                'subtotal' => $subtotal
            ];
            $this->db->insert('order_items', $order_item);

            $this->load->model('Produk_model'); // Pastikan model produk dimuat
    
            $this->db->trans_start(); // Mulai transaksi database
        
            try {
                // Simpan data order
                $order_data = [
                    'id_user' => $id_user,
                    'tgl_pemesanan' => date('Y-m-d H:i:s'),
                    'stts_pemesanan' => $stts_pemesanan,
                    'total_harga' => $total_harga,
                    'id_admin' => $this->input->post('id_admin')
                ];
                $this->db->insert('orders', $order_data);
                $id_order = $this->db->insert_id();
        
                // Proses setiap produk
                foreach ($produk as $index => $id_product) {
                    $product = $this->Produk_model->get_by_id($id_product);
                    
                    // Validasi stok
                    if($product->stok < $jumlah[$index]) {
                        throw new Exception("Stok ".$product->nama_product." tidak cukup");
                    }
        
                    // Update stok produk
                    $new_stock = $product->stok - $jumlah[$index];
                    $this->Produk_model->update($id_product, ['stok' => $new_stock]);
        
                    // Simpan order item
                    $order_item = [
                        'id_order' => $id_order,
                        'id_product' => $id_product,
                        'quantity' => $jumlah[$index],
                        'subtotal' => $product->harga * $jumlah[$index]
                    ];
                    $this->db->insert('order_items', $order_item);
                }
        
                $this->db->trans_commit(); // Commit transaksi jika semua berhasil
                redirect('pesanan');
        
            } catch (Exception $e) {
                $this->db->trans_rollback(); // Rollback jika ada error
                $this->session->set_flashdata('error', $e->getMessage());
                redirect('pesanan');
            }
        }
    
        redirect('pesanan');
    }

    // Menghapus pesanan
    public function delete($id_order) {
        $this->Pesanan_model->delete_pesanan($id_order); // Hapus data pesanan
        redirect('pesanan'); // Redirect ke halaman pesanan
    }

    // Ambil data status untuk modal edit (AJAX)
public function get_status($id_order) {
    $order = $this->Pesanan_model->get_pesanan_by_id($id_order);
    echo json_encode($order);
}

// Update status pesanan
public function update() {
    $id_order = $this->input->post('id_order');
    $stts_pemesanan = $this->input->post('stts_pemesanan');
    
    $data = [
        'stts_pemesanan' => $stts_pemesanan
    ];
    
    $this->Pesanan_model->update_pesanan($id_order, $data);
    redirect('pesanan');
}
}