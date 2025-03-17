<?php
class Kategori_model extends CI_Model {
    
    public function get_all() {
        return $this->db->get('category')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('category', ['id_kategori' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('category', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_kategori', $id)->update('category', $data);
    }

    public function delete($id) {
        return $this->db->delete('category', ['id_kategori' => $id]);
    }

    
}
