<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pesanan_model'); // Memuat model
        $this->load->helper('url'); // Memuat helper URL
        $this->load->library('form_validation'); // Memuat library form validation
    }

    public function index() {
        $data['pesanan'] = $this->Pesanan_model->get_all_pesanan();
        $data['users'] = $this->db->get('user')->result();
        $data['products'] = $this->db->get('product')->result();
        $this->load->view('pesanan', $data);
    }

    public function create() {
        $this->load->model('Produk_model');
        
        $id_user = $this->input->post('id_user');
        $produk = $this->input->post('produk');
        $jumlah = $this->input->post('jumlah');
        $stts_pemesanan = $this->input->post('stts_pemesanan');
        $total_harga = 0;
  
        foreach ($produk as $index => $id_product) {
            $product = $this->Produk_model->get_by_id($id_product);
            if(!$product || $product->stok < $jumlah[$index]) {
                $this->session->set_flashdata('error', 'Stok produk tidak mencukupi');
                redirect('pesanan');
            }
            $total_harga += $product->harga * $jumlah[$index];
        }
    
        $this->db->trans_start();
    
        try {
            $order_data = [
                'id_user' => $id_user,
                'tgl_pemesanan' => date('Y-m-d H:i:s'),
                'stts_pemesanan' => $stts_pemesanan,
                'total_harga' => $total_harga,
                'id_admin' => $this->input->post('id_admin')
            ];
            $this->db->insert('orders', $order_data);
            $id_order = $this->db->insert_id();
    
            // Simpan order items
            foreach ($produk as $index => $id_product) {
                $product = $this->Produk_model->get_by_id($id_product);
                
                // Update stok
                $new_stock = $product->stok - $jumlah[$index];
                $this->Produk_model->update($id_product, ['stok' => $new_stock]);
    
                // Simpan item
                $order_item = [
                    'id_order' => $id_order,
                    'id_product' => $id_product,
                    'quantity' => $jumlah[$index],
                    'subtotal' => $product->harga * $jumlah[$index]
                ];
                $this->db->insert('order_items', $order_item);
            }
    
            $this->db->trans_commit();
            redirect('pesanan');
    
        } catch (Exception $e) {
            $this->db->trans_rollback(); // Rollback jika error
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('pesanan');
        }
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
    
    // Panggil model untuk update
    $this->Pesanan_model->update_pesanan($id_order, $data);
    redirect('pesanan');
}
}