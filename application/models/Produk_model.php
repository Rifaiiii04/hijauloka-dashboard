<?php
class Produk_model extends CI_Model {
    
    public function get_all() {
        $this->db->select("product.*, GROUP_CONCAT(category.nama_kategori SEPARATOR ', ') as nama_kategori, fp.position as featured_position");
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.id_product = product.id_product', 'left');
        $this->db->join('category', 'category.id_kategori = product_category.id_kategori', 'left');
        $this->db->join('featured_products fp', 'product.id_product = fp.id_product', 'left');
        $this->db->group_by('product.id_product');
        return $this->db->get()->result();
    }
    

    public function get_by_id($id) {
        $this->db->select("product.*, GROUP_CONCAT(category.nama_kategori SEPARATOR ', ') as nama_kategori");
        $this->db->join('product_category', 'product_category.id_product = product.id_product', 'left');
        $this->db->join('category', 'category.id_kategori = product_category.id_kategori', 'left');
        $this->db->group_by('product.id_product');
        return $this->db->get_where('product', ['product.id_product' => $id])->row();
    }
    

    public function insert($data) {
        try {
            // Validasi data yang diperlukan
            if (empty($data['nama_product']) || empty($data['desk_product']) || 
                !isset($data['harga']) || !isset($data['stok']) || empty($data['gambar'])) {
                log_message('error', 'Data tidak lengkap: ' . print_r($data, true));
                return false;
            }

            // Pastikan harga dan stok adalah angka
            if (!is_numeric($data['harga']) || !is_numeric($data['stok'])) {
                log_message('error', 'Harga atau stok bukan angka: ' . print_r($data, true));
                return false;
            }

            // Pastikan id_admin ada
            if (empty($data['id_admin'])) {
                log_message('error', 'ID Admin tidak ditemukan: ' . print_r($data, true));
                return false;
            }

            // Coba insert data
            $result = $this->db->insert('product', $data);
            
            if (!$result) {
                log_message('error', 'Database error: ' . print_r($this->db->error(), true));
                return false;
            }

            return true;
        } catch (Exception $e) {
            log_message('error', 'Exception saat insert: ' . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        $this->db->where('id_product', $id);
        return $this->db->update('product', $data);
    }

    public function delete($id) {
        return $this->db->delete('product', ['id_product' => $id]);
    }

    public function get_stok_tanaman() {
        return $this->db->select('id_product, nama_product, stok')
                        ->from('product')
                        ->order_by('stok', 'ASC')
                        ->limit(5)
                        ->get()
                        ->result();
    }

    public function get_stok_summary() {
        $query = $this->db->query("
            SELECT 
                SUM(stok) as total_stok,
                COUNT(id_product) as jenis_tanaman
            FROM product
        ");
        return $query->row();
    }

    public function count_all_products() {
        return $this->db->count_all('product');
    }

    public function get_products($limit, $start) {
        $this->db->select('p.*, k.nama_kategori, fp.position as featured_position');
        $this->db->from('product p');
        $this->db->join('product_category pc', 'p.id_product = pc.id_product', 'left');
        $this->db->join('category k', 'pc.id_kategori = k.id_kategori', 'left');  // Changed 'kategori' to 'category'
        $this->db->join('featured_products fp', 'p.id_product = fp.id_product', 'left');
        $this->db->limit($limit, $start);
        $this->db->group_by('p.id_product');
        return $this->db->get()->result();
    }

    public function make_featured($id_product) {
        // Check if product exists
        if (!$this->db->where('id_product', $id_product)->get('product')->row()) {
            return false;
        }

        // Count current featured products
        $current_count = $this->db->count_all('featured_products');
        if ($current_count >= 10) {
            return false;
        }

        // Get next position
        $next_position = $current_count + 1;

        // Insert into featured_products
        return $this->db->insert('featured_products', [
            'id_product' => $id_product,
            'position' => $next_position,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function remove_featured($id_product) {
        // Get current position
        $featured = $this->db->where('id_product', $id_product)
                            ->get('featured_products')
                            ->row();
        
        if (!$featured) {
            return false;
        }

        // Begin transaction
        $this->db->trans_start();

        // Remove the featured product
        $this->db->where('id_product', $id_product)
                 ->delete('featured_products');

        // Reorder remaining positions
        $this->db->query("
            UPDATE featured_products 
            SET position = position - 1 
            WHERE position > ?", 
            [$featured->position]
        );

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
