<?php
class Produk_model extends CI_Model {
    
    public function get_all() {
        $this->db->select("product.*, GROUP_CONCAT(category.nama_kategori SEPARATOR ', ') as nama_kategori");
        $this->db->join('product_category', 'product_category.id_product = product.id_product', 'left');
        $this->db->join('category', 'category.id_kategori = product_category.id_kategori', 'left');
        $this->db->group_by('product.id_product');
        return $this->db->get('product')->result();
    }
    

    public function get_by_id($id) {
        $this->db->select('product.*, category.nama_kategori');
        $this->db->join('category', 'category.id_kategori = product.id_kategori', 'left');
        return $this->db->get_where('product', ['id_product' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('product', $data);
    }

    public function update($id, $data) {
        $this->db->where('id_product', $id);
        return $this->db->update('product', $data);
    }

    public function delete($id) {
        return $this->db->delete('product', ['id_product' => $id]);
    }

    public function get_stok_tanaman() {
        return $this->db->select('nama_product, stok')
                        ->from('product')
                        ->where('stok >', 0)
                        ->order_by('stok', 'DESC')
                        ->get()
                        ->result();
    }
}
