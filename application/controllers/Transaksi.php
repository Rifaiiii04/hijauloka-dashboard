<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->model('Pesanan_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        // Get current page from URL
        $page = ($this->input->get('page')) ? $this->input->get('page') : 1;
        $per_page = 10; // Items per page
        
        // Calculate offset
        $offset = ($page - 1) * $per_page;
        
        // Get total rows for pagination
        $total_rows = $this->Transaksi_model->count_all_transactions();
        
        // Get transactions for current page
        $data['transaksi'] = $this->Transaksi_model->get_transactions($per_page, $offset);
        $data['pesanan'] = $this->Pesanan_model->get_unpaid_orders();
        
        // Pagination data
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_rows'] = $total_rows;
        
        $this->load->view('transaksi', $data);
    }

    public function detail($id) {
        $transaksi = $this->Transaksi_model->get_by_id($id);
        if (!$transaksi) {
            echo '<p class="text-red-500">Transaksi tidak ditemukan.</p>';
            return;
        }
        $data['transaksi'] = $transaksi;
        $data['items'] = $this->Transaksi_model->get_transaksi_items($id);
        $this->load->view('transaksi_detail_modal', $data);
    }

    public function create() {
        $order_id = $this->input->post('order_id');
        $metode_pembayaran = $this->input->post('metode_pembayaran');

        $order = $this->Pesanan_model->get_pesanan_by_id($order_id);
        if (!$order) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('transaksi');
        }

    
        $transaksi_data = [
            'order_id'          => $order->id_order,
            'user_id'           => $order->id_user,
            'total_bayar'       => $order->total_harga,
            'metode_pembayaran' => $metode_pembayaran,
            'status_pembayaran' => $order->stts_pembayaran,
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
            'id_admin'          => $order->id_admin
        ];

        $this->db->trans_start();

        $insert_id = $this->Transaksi_model->insert_transaksi($transaksi_data);
        if (!$insert_id) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Gagal menambahkan transaksi.');
            redirect('transaksi');
        }

        $order_items = $this->db->get_where('order_items', ['id_order' => $order->id_order])->result();
        if (!empty($order_items)) {
            foreach ($order_items as $item) {
                $detail_data = [
                    'id_transaksi'  => $insert_id,
                    'id_product'    => $item->id_product,
                    'jumlah'        => $item->quantity,
                    'harga_satuan'  => isset($item->harga) ? $item->harga : 0,
                    'subtotal'      => $item->subtotal
                ];
                $this->db->insert('detail_transaksi', $detail_data);
            }
        }
        // ------------------------------------------------

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        } else {
            $this->session->set_flashdata('success', 'Transaksi berhasil ditambahkan.');
        }
        redirect('transaksi');
    }
}
