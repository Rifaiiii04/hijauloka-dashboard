<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Kategori_model');
    }

    public function index() {
        $data['kategori'] = $this->Kategori_model->get_all();
        $this->load->view('kategori', $data);
    }

    public function store() {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori'),
            'id_admin' => 1 // Ganti sesuai ID admin yang login
        ];

        if ($this->input->post('id_kategori')) {
            $this->Kategori_model->update($this->input->post('id_kategori'), $data);
        } else {
            $this->Kategori_model->insert($data);
        }

        redirect('kategori');
    }

    public function edit($id) {
        echo json_encode($this->Kategori_model->get_by_id($id));
    }

    public function delete($id) {
        $this->Kategori_model->delete($id);
        redirect('kategori');
    }
}
