<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->model('Laporan_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {

        $data['stok_tanaman'] = $this->Produk_model->get_stok_tanaman();
        

        $data['best_products'] = $this->Laporan_model->get_best_selling_products() ?? [];
        

        $data['monthly_sales'] = $this->Laporan_model->get_monthly_sales() ?? [];
        

        $this->load->view('dashboard', $data);
    }

    public function get_chart_data() {
        $best_products = $this->Laporan_model->get_best_selling_products() ?? [];
        $monthly_sales = $this->Laporan_model->get_monthly_sales() ?? [];

        var_dump($best_products);
        
        header('Content-Type: application/json');
        echo json_encode([
            'best_products' => $best_products,
            'monthly_sales' => $monthly_sales,
        ]);
    }
}
