<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pesanan_model');
        $this->load->model('Produk_model');
        $this->load->model('User_model');
        $this->load->library('pagination');
        
        // Get pending orders count for sidebar
        $pending_count = $this->Pesanan_model->count_pending_orders();
        $this->session->set_userdata('pending_orders_count', $pending_count);
    }

    public function index() {
        // Get search parameters
        $search = $this->input->get('search');
        $search_type = $this->input->get('search_type') ?: 'all';
        $status = $this->input->get('status');
        $page = ($this->input->get('page')) ? $this->input->get('page') : 1;
        $per_page = 10;
        
        // Calculate offset
        $offset = ($page - 1) * $per_page;
        
        // Get total rows for pagination
        $total_rows = $this->Pesanan_model->count_all_orders($search, $search_type, $status);
        
        // Get orders with search and filter
        $data['pesanan'] = $this->Pesanan_model->get_orders($per_page, $offset, $search, $search_type, $status);
        $data['products'] = $this->Produk_model->get_all();
        $data['users'] = $this->User_model->get_all();
        
        // Pagination data
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_rows'] = $total_rows;
        
        // Pass search parameters to view
        $data['search'] = $search;
        $data['search_type'] = $search_type;
        $data['status'] = $status;
        
        $this->load->view('pesanan', $data);
    }

    public function create() {
        $id_user         = $this->input->post('id_user');
        $produk          = $this->input->post('produk');
        $jumlah          = $this->input->post('jumlah');
        $stts_pemesanan  = $this->input->post('stts_pemesanan');
        $stts_pembayaran = $this->input->post('stts_pembayaran');
        $id_admin        = $this->input->post('id_admin');
        $total_harga     = 0;
    
        error_log("POST data: " . print_r($this->input->post(), true));
    
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

    public function delete($id_order) {
        $pesanan = $this->Pesanan_model->get_pesanan_by_id($id_order);
        if (!$pesanan) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('pesanan');
        }
    
        $this->db->where('id_order', $id_order);
        $this->db->delete('order_items');
    
        $this->Pesanan_model->delete_pesanan($id_order);
        $this->session->set_flashdata('success', 'Pesanan berhasil dihapus.');
        redirect('pesanan');
    }

    public function get_status($id_order) {
        $order = $this->Pesanan_model->get_order_with_customer($id_order);
        if (!$order) {
            echo json_encode(['error' => 'Order not found']);
            return;
        }
        echo json_encode($order);
    }

    public function update_status() {
        $id_order = $this->input->post('id_order');
        $stts_pemesanan = $this->input->post('stts_pemesanan');
        $stts_pembayaran = $this->input->post('stts_pembayaran');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
    
        if (empty($id_order)) {
            $this->session->set_flashdata('error', 'ID pesanan tidak ditemukan.');
            redirect('pesanan');
        }

        $data = [
            'stts_pemesanan'  => $stts_pemesanan,
            'stts_pembayaran' => $stts_pembayaran
        ];
        
        if (!empty($metode_pembayaran)) {
            $data['metode_pembayaran'] = $metode_pembayaran;
        }
    
        if ($this->Pesanan_model->update_status($id_order, $data)) {
            $this->session->set_flashdata('success', 'Status pesanan berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status.');
        }
        redirect('pesanan');
    }

    public function get_pending_count() {
        $count = $this->Pesanan_model->count_pending_orders();
        echo json_encode(['count' => $count]);
    }
}
