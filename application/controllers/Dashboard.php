<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['stok_tanaman'] = $this->Produk_model->get_stok_tanaman(); 
        $this->load->view('dashboard', $data);
    }
}
