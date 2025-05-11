<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->model('Pesanan_model');
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        // Get filters from request
        $filters = [
            'status' => $this->input->get('status'),
            'method' => $this->input->get('method'),
            'search' => $this->input->get('search')
        ];

        // Get current page from URL
        $page = ($this->input->get('page')) ? (int)$this->input->get('page') : 1;
        $per_page = 10; // Items per page
        
        // Calculate offset
        $offset = ($page - 1) * $per_page;
        
        // Get total rows for pagination with filters
        $total_rows = $this->Transaksi_model->count_all_transactions($filters);
        
        // Get transactions for current page with filters
        $data['transaksi'] = $this->Transaksi_model->get_transactions($per_page, $offset, $filters);
        
        // Get today's stats
        $today_stats = $this->Transaksi_model->get_today_stats();
        $data['today_count'] = $today_stats['count'];
        $data['today_income'] = $today_stats['total_income'];
        
        // Get unpaid orders count
        $data['pesanan'] = $this->Pesanan_model->get_unpaid_orders();
        
        // Pagination data
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_rows'] = $total_rows;
        $data['filters'] = $filters;
        
        $this->load->view('transaksi', $data);
    }

    public function detail($id) {
        $summary = $this->Transaksi_model->get_transaction_summary($id);
        if (!$summary) {
            echo '<div class="p-6 text-center">
                    <div class="bg-red-100 p-6 rounded-full mb-4 inline-block">
                        <i class="fas fa-exclamation-circle text-red-500 text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 mb-1">Transaksi Tidak Ditemukan</h3>
                    <p class="text-gray-500">Transaksi yang Anda cari tidak dapat ditemukan dalam sistem.</p>
                  </div>';
            return;
        }

        $this->load->view('transaksi_detail_modal', $summary);
    }

    public function update_status() {
        // Check if it's an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (!$id || !$status) {
            $this->output->set_status_header(400)
                         ->set_content_type('application/json')
                         ->set_output(json_encode([
                             'success' => false,
                             'message' => 'ID dan status harus diisi'
                         ]));
            return;
        }

        // Validate status
        $valid_statuses = ['pending', 'lunas', 'gagal'];
        if (!in_array($status, $valid_statuses)) {
            $this->output->set_status_header(400)
                         ->set_content_type('application/json')
                         ->set_output(json_encode([
                             'success' => false,
                             'message' => 'Status tidak valid'
                         ]));
            return;
        }

        // Update status
        $updated = $this->Transaksi_model->update_status($id, $status);
        
        if ($updated) {
            $this->output->set_status_header(200)
                         ->set_content_type('application/json')
                         ->set_output(json_encode([
                             'success' => true,
                             'message' => 'Status berhasil diperbarui'
                         ]));
        } else {
            $this->output->set_status_header(500)
                         ->set_content_type('application/json')
                         ->set_output(json_encode([
                             'success' => false,
                             'message' => 'Gagal memperbarui status'
                         ]));
        }
    }

    public function create() {
        // Validate request method
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $order_id = $this->input->post('order_id');
        $metode_pembayaran = $this->input->post('metode_pembayaran');

        // Validate required fields
        if (!$order_id || !$metode_pembayaran) {
            $this->session->set_flashdata('error', 'Semua field harus diisi.');
            redirect('transaksi');
        }

        $order = $this->Pesanan_model->get_pesanan_by_id($order_id);
        if (!$order) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('transaksi');
        }

        // Prepare transaction data
        $transaksi_data = [
            'order_id'          => $order->id_order,
            'user_id'           => $order->id_user,
            'total_bayar'       => $order->total_harga,
            'metode_pembayaran' => $metode_pembayaran,
            'status_pembayaran' => 'pending',
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
            'id_admin'          => $this->session->userdata('user_id')
        ];

        $this->db->trans_start();

        try {
            // Insert transaction
            $insert_id = $this->Transaksi_model->insert_transaksi($transaksi_data);
            if (!$insert_id) {
                throw new Exception('Gagal menambahkan transaksi.');
            }

            // Get order items and create transaction details
            $order_items = $this->db->get_where('order_items', ['id_order' => $order->id_order])->result();
            foreach ($order_items as $item) {
                $detail_data = [
                    'id_transaksi'  => $insert_id,
                    'id_product'    => $item->id_product,
                    'jumlah'        => $item->quantity,
                    'harga_satuan'  => $item->subtotal / $item->quantity,
                    'subtotal'      => $item->subtotal
                ];
                
                if (!$this->db->insert('detail_transaksi', $detail_data)) {
                    throw new Exception('Gagal menambahkan detail transaksi.');
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Terjadi kesalahan saat menyimpan transaksi.');
            }

            $this->session->set_flashdata('success', 'Transaksi berhasil ditambahkan.');
            redirect('transaksi');

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('transaksi');
        }
    }
}
