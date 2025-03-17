<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->model('Kategori_model');
        if (!$this->session->userdata('id_admin')) {
            echo json_encode(['success' => false, 'message' => 'Admin tidak ditemukan. Pastikan sudah login.']);
            exit;
        }
    }

    public function index() {
        $data['produk'] = $this->Produk_model->get_all();
        $data['kategori'] = $this->Kategori_model->get_all();
        $this->load->view('produk', $data);
    }

    public function store() {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        if (!is_dir('./uploads/')) {
            mkdir('./uploads/', 0777, true);
        }

        $gambar = null;
        if ($this->upload->do_upload('gambar')) {
            $uploadData = $this->upload->data();
            $gambar = $uploadData['file_name'];
        }

        $id_admin = $this->session->userdata('id_admin');

        $data = [
            'nama_product' => $this->input->post('nama_product'),
            'desk_product' => $this->input->post('desk_product'),
            'id_kategori'  => $this->input->post('id_kategori'),
            'harga'        => $this->input->post('harga'),
            'stok'         => $this->input->post('stok'),
            'gambar'       => $gambar,
            'id_admin'     => $id_admin
        ];

        $this->Produk_model->insert($data);
        redirect('produk');
    }

    public function edit($id) {
        $data['produk'] = $this->Produk_model->get_by_id($id);
        $data['kategori'] = $this->Kategori_model->get_all();
        echo json_encode($data);
    }

    public function update() {
        $id = $this->input->post('id_product');

        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        $gambar = $this->input->post('gambar_lama');
        if ($this->upload->do_upload('gambar')) {
            $uploadData = $this->upload->data();
            $gambar = $uploadData['file_name'];
        }

        $data = [
            'nama_product' => $this->input->post('nama_product'),
            'desk_product' => $this->input->post('desk_product'),
            'id_kategori'  => $this->input->post('id_kategori'),
            'harga'        => $this->input->post('harga'),
            'stok'         => $this->input->post('stok'),
            'gambar'       => $gambar
        ];

        $this->Produk_model->update($id, $data);
        redirect('produk');
    }

    public function delete($id) {
        $this->Produk_model->delete($id);
        redirect('produk');
    }
}
