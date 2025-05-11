<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaksi_model');
        $this->load->model('Pesanan_model');
        $this->load->model('Produk_model');
        $this->load->model('Laporan_model');
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        // Get today's transaction stats
        $today_stats = $this->Transaksi_model->get_today_stats();
        $data['today_count'] = $today_stats['count'];
        $data['today_income'] = $today_stats['total_income'];

        // Get current month revenue
        $data['current_month_revenue'] = $this->Laporan_model->get_current_month_revenue() ?? 0;

        // Get stock summary
        $data['stok_summary'] = $this->Produk_model->get_stok_summary() ?? (object)['total_stok' => 0, 'jenis_tanaman' => 0];
        
        // Get stock data for table
        $data['stok_tanaman'] = $this->Produk_model->get_stok_tanaman();

        // Get today's orders
        $data['today_orders'] = $this->Pesanan_model->get_orders(5, 0, null, true);

        // Get pending orders count
        $data['pending_orders'] = count(array_filter(
            $this->Pesanan_model->get_orders(100, 0),
            function($order) {
                return $order->stts_pemesanan === 'pending';
            }
        ));

        // Get other dashboard data
        $data['total_products'] = $this->Produk_model->count_all_products();
        $data['total_transactions'] = $this->Transaksi_model->count_all_transactions();
        
        // Get recent transactions
        $data['recent_transactions'] = $this->Transaksi_model->get_transactions(5, 0);
        
        // Get recent orders (last 5 orders)
        $data['recent_orders'] = $this->Pesanan_model->get_orders(5, 0);

        // Get chart data
        $data['best_products'] = $this->Laporan_model->get_best_selling_products() ?? [];
        $data['monthly_sales'] = $this->Laporan_model->get_monthly_sales() ?? [];

        $this->load->view('dashboard', $data);
    }

    public function get_chart_data() {
        $best_products = $this->Laporan_model->get_best_selling_products() ?? [];
        $monthly_sales = $this->Laporan_model->get_monthly_sales() ?? [];

        header('Content-Type: application/json');
        echo json_encode([
            'best_products' => $best_products,
            'monthly_sales' => $monthly_sales,
        ]);
    }
}