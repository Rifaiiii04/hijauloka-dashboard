<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        if (!$this->session->userdata('id_admin')) {
            redirect('login'); 
        }
    }


    public function index() {
        $data['users'] = $this->User_model->get_all();
        $this->load->view('user_management', $data);
    }

    // Hapus user
    public function delete($id) {
        $result = $this->User_model->delete($id);

        if ($result) {
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user.');
        }

        redirect('user');
    }
}
?>