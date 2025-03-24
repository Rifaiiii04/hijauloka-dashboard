<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->model('Laporan_model');

        // Pastikan pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        // Ambil data stok tanaman dari model
        $data['stok_tanaman'] = $this->Produk_model->get_stok_tanaman();
        
        // Gunakan data nyata dari Laporan_model
        $data['best_products'] = $this->Laporan_model->get_best_selling_products() ?? [];
        
        // Data penjualan bulanan jika diperlukan
        $data['monthly_sales'] = $this->Laporan_model->get_monthly_sales() ?? [];
        
        // Load view dashboard beserta data
        $this->load->view('dashboard', $data);
    }

    public function get_chart_data() {
        $best_products = $this->Laporan_model->get_best_selling_products() ?? [];
        $monthly_sales = $this->Laporan_model->get_monthly_sales() ?? [];

        // Debug: Tampilkan data best_products
        var_dump($best_products);
        
        // Set header respons sebagai JSON
        header('Content-Type: application/json');
        echo json_encode([
            'best_products' => $best_products,
            'monthly_sales' => $monthly_sales,
        ]);
    }
}
