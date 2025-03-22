<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->model('Pesanan_model'); // Untuk ambil data pesanan
        // Pastikan pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // Menampilkan dashboard transaksi
    public function index() {
        $data['title'] = 'Dashboard Transaksi';
        // Ambil data transaksi dari tabel transaksi
        $data['transaksi'] = $this->Transaksi_model->get_all();
        // Ambil semua pesanan dari tabel orders secara sederhana
        $all_orders = $this->Pesanan_model->get_all_orders();
        $filtered = [];
        if (!empty($all_orders)) {
            foreach ($all_orders as $order) {
                // Tampilkan pesanan jika status pembayaran adalah 'belum_dibayar'
                if ($order->stts_pembayaran === 'lunas') {
                    $filtered[] = $order;
                }
            }
        }
        $data['pesanan'] = $filtered;
        $this->load->view('transaksi', $data);
    }

    // Menampilkan detail transaksi (untuk modal detail)
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

    // Membuat transaksi baru secara manual dari pesanan yang dipilih
    public function create() {
        $order_id = $this->input->post('order_id');
        $metode_pembayaran = $this->input->post('metode_pembayaran');

        // Ambil data pesanan terkait
        $order = $this->Pesanan_model->get_pesanan_by_id($order_id);
        if (!$order) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('transaksi');
        }

        // Persiapkan data transaksi
        $transaksi_data = [
            'order_id'          => $order->id_order,
            'user_id'           => $order->id_user,
            'total_bayar'       => $order->total_harga,
            'metode_pembayaran' => $metode_pembayaran,
            // Ambil status pembayaran dari pesanan (misalnya 'belum_dibayar')
            'status_pembayaran' => $order->stts_pembayaran,
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
            'id_admin'          => $order->id_admin
        ];

        $insert_id = $this->Transaksi_model->insert_transaksi($transaksi_data);
        if ($insert_id) {
            $this->session->set_flashdata('success', 'Transaksi berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan transaksi.');
        }
        redirect('transaksi');
    }
}
