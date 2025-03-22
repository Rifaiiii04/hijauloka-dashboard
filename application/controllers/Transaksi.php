<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaksi_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        $data['transaksi'] = $this->Transaksi_model->get_all();
        $this->load->view('transaksi', $data);
    }

    public function detail($id) {
        $data['transaksi'] = $this->Transaksi_model->get_by_id($id);
        $data['items'] = $this->Transaksi_model->get_transaksi_items($id);
        $this->load->view('transaksi_detail', $data);
    }
}
