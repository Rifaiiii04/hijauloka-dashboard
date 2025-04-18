<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->model('Kategori_model');  // Add this line
        $this->load->library('pagination');
    }

    public function index() {
        // Now use $this->Kategori_model instead of $this->kategori_model
        $config['base_url'] = base_url('produk/index');
        $config['total_rows'] = $this->Produk_model->count_all_products();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        
        // Pagination styling
        $config['full_tag_open'] = '<div class="flex gap-2">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<div class="px-3 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">';
        $config['first_tag_close'] = '</div>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<div class="px-3 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">';
        $config['prev_tag_close'] = '</div>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<div class="px-3 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">';
        $config['next_tag_close'] = '</div>';
        $config['last_tag_open'] = '<div class="px-3 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">';
        $config['last_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="px-3 py-2 bg-green-500 text-white rounded-lg">';
        $config['cur_tag_close'] = '</div>';
        $config['num_tag_open'] = '<div class="px-3 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">';
        $config['num_tag_close'] = '</div>';
    
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data['produk'] = $this->Produk_model->get_products($config['per_page'], $page);
        $data['kategori'] = $this->Kategori_model->get_all();  // Updated this line
        
        $this->load->view('produk', $data);
    }

    public function store() {
        // Buat folder uploads jika belum ada
        if (!is_dir('./uploads/')) {
            mkdir('./uploads/', 0777, true);
        }

        // Konfigurasi upload gambar
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        $files     = $_FILES;
        $fileCount = isset($files['gambar']['name']) ? count($files['gambar']['name']) : 0;
        if ($fileCount < 1 || $fileCount > 5) {
            $this->session->set_flashdata('error', 'Upload minimal 1 gambar dan maksimal 5 gambar.');
            redirect('produk');
            return;
        }

        $images = [];
        for ($i = 0; $i < $fileCount; $i++) {
            $_FILES['gambar']['name']     = $files['gambar']['name'][$i];
            $_FILES['gambar']['type']     = $files['gambar']['type'][$i];
            $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$i];
            $_FILES['gambar']['error']    = $files['gambar']['error'][$i];
            $_FILES['gambar']['size']     = $files['gambar']['size'][$i];

            if ($this->upload->do_upload('gambar')) {
                $uploadData = $this->upload->data();
                $images[]   = $uploadData['file_name'];
            }
        }
        $gambar = implode(',', $images);

        $id_admin = $this->session->userdata('id_admin');

        // Siapkan data untuk tabel produk (tanpa kategori, karena akan dimasukkan ke tabel pivot)
        $data = [
            'nama_product' => $this->input->post('nama_product'),
            'desk_product' => $this->input->post('desk_product'),
            'harga'        => $this->input->post('harga'),
            'stok'         => $this->input->post('stok'),
            'gambar'       => $gambar,
            'id_admin'     => $id_admin
        ];

        $this->Produk_model->insert($data);
        $id_product = $this->db->insert_id();

        // Simpan relasi produk-kategori ke tabel pivot (misal: product_category)
        $kategori_arr = $this->input->post('id_kategori'); // berupa array
        if (!empty($kategori_arr) && is_array($kategori_arr)) {
            foreach ($kategori_arr as $kat) {
                $this->db->insert('product_category', [
                    'id_product'  => $id_product,
                    'id_kategori' => $kat
                ]);
            }
        }

        redirect('produk');
    }

    public function edit($id) {
        // Ambil data produk
        $produk = $this->Produk_model->get_by_id($id);

        // Ambil kategori yang sudah terhubung dengan produk
        $this->db->select('id_kategori');
        $this->db->from('product_category');
        $this->db->where('id_product', $id);
        $query = $this->db->get();
        $selected_categories = [];
        foreach ($query->result() as $row) {
            $selected_categories[] = $row->id_kategori;
        }

        $data = [
            'produk'              => $produk,
            'selected_categories' => $selected_categories,
            'kategori'            => $this->Kategori_model->get_all() // jika dibutuhkan di front-end
        ];

        echo json_encode($data);
    }

    public function update() {
        $id = $this->input->post('id_product');

        // Buat folder uploads jika belum ada
        if (!is_dir('./uploads/')) {
            mkdir('./uploads/', 0777, true);
        }

        // Konfigurasi upload gambar
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        $gambar_lama = $this->input->post('gambar_lama'); // string gambar lama
        $files       = $_FILES;
        $fileCount   = isset($files['gambar']['name'][0]) && !empty($files['gambar']['name'][0])
                       ? count($files['gambar']['name'])
                       : 0;

        if ($fileCount > 0) {
            if ($fileCount < 1 || $fileCount > 5) {
                $this->session->set_flashdata('error', 'Upload minimal 1 gambar dan maksimal 5 gambar.');
                redirect('produk');
                return;
            }
            $images = [];
            for ($i = 0; $i < $fileCount; $i++) {
                $_FILES['gambar']['name']     = $files['gambar']['name'][$i];
                $_FILES['gambar']['type']     = $files['gambar']['type'][$i];
                $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$i];
                $_FILES['gambar']['error']    = $files['gambar']['error'][$i];
                $_FILES['gambar']['size']     = $files['gambar']['size'][$i];

                if ($this->upload->do_upload('gambar')) {
                    $uploadData = $this->upload->data();
                    $images[]   = $uploadData['file_name'];
                }
            }
            $gambar = implode(',', $images);
        } else {
            $gambar = $gambar_lama;
        }

        // Update data produk (tanpa kategori)
        $data = [
            'nama_product' => $this->input->post('nama_product'),
            'desk_product' => $this->input->post('desk_product'),
            'harga'        => $this->input->post('harga'),
            'stok'         => $this->input->post('stok'),
            'gambar'       => $gambar
        ];

        $this->Produk_model->update($id, $data);

        // Perbarui relasi kategori: hapus relasi lama, kemudian masukkan relasi baru
        $this->db->where('id_product', $id);
        $this->db->delete('product_category');

        $kategori_arr = $this->input->post('id_kategori');
        if (!empty($kategori_arr) && is_array($kategori_arr)) {
            foreach ($kategori_arr as $kat) {
                $this->db->insert('product_category', [
                    'id_product'  => $id,
                    'id_kategori' => $kat
                ]);
            }
        }

        redirect('produk');
    }

    public function delete($id) {
        $this->Produk_model->delete($id);

        // Hapus juga relasi di tabel product_category
        $this->db->where('id_product', $id);
        $this->db->delete('product_category');

        redirect('produk');
    }
}
