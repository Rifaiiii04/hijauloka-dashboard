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
        // Validasi input
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('nama_product', 'Nama Produk', 'required');
        $this->form_validation->set_rules('desk_product', 'Deskripsi', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
        $this->form_validation->set_rules('id_kategori[]', 'Kategori', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('produk');
            return;
        }

        // Buat folder uploads jika belum ada
        if (!is_dir('./uploads/')) {
            mkdir('./uploads/', 0777, true);
        }

        // Buat folder uploads/videos jika belum ada
        if (!is_dir('./uploads/videos/')) {
            mkdir('./uploads/videos/', 0777, true);
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
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupload gambar: ' . $this->upload->display_errors());
                redirect('produk');
                return;
            }
        }
        $gambar = implode(',', $images);

        // Handle video upload
        $video_name = null;
        if (!empty($_FILES['cara_rawat_video']['name'])) {
            $video_config = array(
                'upload_path'   => './uploads/videos/',
                'allowed_types' => 'mp4|avi|mov|wmv|flv|mkv',
                'max_size'      => 51200, // 50MB in kilobytes
                'encrypt_name'  => TRUE
            );
            
            $this->upload->initialize($video_config);
            
            if ($this->upload->do_upload('cara_rawat_video')) {
                $video_data = $this->upload->data();
                $video_name = $video_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupload video: ' . $this->upload->display_errors());
                redirect('produk');
                return;
            }
        }

        $id_admin = $this->session->userdata('id_admin');
        if (!$id_admin) {
            $this->session->set_flashdata('error', 'Sesi admin tidak ditemukan');
            redirect('produk');
            return;
        }

        // Siapkan data untuk tabel produk
        $data = [
            'nama_product' => $this->input->post('nama_product'),
            'desk_product' => $this->input->post('desk_product'),
            'harga'        => $this->input->post('harga'),
            'stok'         => $this->input->post('stok'),
            'gambar'       => $gambar,
            'id_admin'     => $id_admin
        ];
        
        if ($video_name) {
            $data['cara_rawat_video'] = $video_name;
        }

        // Insert data produk
        $insert_result = $this->Produk_model->insert($data);
        if (!$insert_result) {
            $this->session->set_flashdata('error', 'Gagal menyimpan data produk');
            redirect('produk');
            return;
        }

        $id_product = $this->db->insert_id();

        // Simpan relasi produk-kategori
        $kategori_arr = $this->input->post('id_kategori');
        if (!empty($kategori_arr) && is_array($kategori_arr)) {
            foreach ($kategori_arr as $kat) {
                $this->db->insert('product_category', [
                    'id_product'  => $id_product,
                    'id_kategori' => $kat
                ]);
            }
        }

        $this->session->set_flashdata('success', 'Data produk berhasil disimpan');
        redirect('produk');
    }

    public function update() {
        $id = $this->input->post('id_product');

        // Buat folder uploads jika belum ada
        if (!is_dir('./uploads/')) {
            mkdir('./uploads/', 0777, true);
        }
        
        // Buat folder uploads/videos jika belum ada
        if (!is_dir('./uploads/videos/')) {
            mkdir('./uploads/videos/', 0777, true);
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
        
        // Handle video upload
        $video_lama = $this->input->post('video_lama');
        $video_name = $video_lama; // Default to keeping old video
        
        if (!empty($_FILES['cara_rawat_video']['name'])) {
            // Reset upload config for video
            $video_config = array(
                'upload_path'   => './uploads/videos/',
                'allowed_types' => 'mp4|avi|mov|wmv|flv|mkv',
                'max_size'      => 51200, // 50MB in kilobytes
                'encrypt_name'  => TRUE
            );
            
            $this->upload->initialize($video_config);
            
            if ($this->upload->do_upload('cara_rawat_video')) {
                // Delete old video if exists
                if (!empty($video_lama) && file_exists('./uploads/videos/' . $video_lama)) {
                    unlink('./uploads/videos/' . $video_lama);
                }
                
                $video_data = $this->upload->data();
                $video_name = $video_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', 'Gagal mengupload video: ' . $error);
            }
        }

        // Update data produk (tanpa kategori)
        $data = [
            'nama_product' => $this->input->post('nama_product'),
            'desk_product' => $this->input->post('desk_product'),
            'harga'        => $this->input->post('harga'),
            'stok'         => $this->input->post('stok'),
            'gambar'       => $gambar,
            'cara_rawat_video' => $video_name
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
    
        // Make sure to include cara_rawat_video in the response
        echo json_encode([
            'produk' => $produk,
            'selected_categories' => $selected_categories
        ]);
    }

    public function delete($id) {
        $this->Produk_model->delete($id);

        // Hapus juga relasi di tabel product_category
        $this->db->where('id_product', $id);
        $this->db->delete('product_category');

        redirect('produk');
    }

    public function make_featured($id_product) {
        $response = array();
        
        try {
            // Get the next available position
            $this->db->select_max('position');
            $query = $this->db->get('featured_products');
            $next_position = ($query->row()->position ?? 0) + 1;
            
            $data = array(
                'id_product' => $id_product,
                'position' => $next_position
            );
            
            if ($this->db->insert('featured_products', $data)) {
                $response['success'] = true;
                $response['message'] = 'Product successfully marked as featured';
            } else {
                throw new Exception('Database insert failed');
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Failed to mark product as featured: ' . $e->getMessage();
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function remove_featured($id_product) {
        $response = array();
        
        try {
            $this->db->where('id_product', $id_product);
            if ($this->db->delete('featured_products')) {
                // Reorder remaining positions
                $this->db->order_by('position', 'ASC');
                $featured = $this->db->get('featured_products')->result();
                
                $position = 1;
                foreach ($featured as $item) {
                    $this->db->where('id_featured', $item->id_featured);
                    $this->db->update('featured_products', ['position' => $position]);
                    $position++;
                }
                
                $response['success'] = true;
                $response['message'] = 'Product successfully removed from featured';
            } else {
                throw new Exception('Database delete failed');
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Failed to remove product from featured: ' . $e->getMessage();
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
