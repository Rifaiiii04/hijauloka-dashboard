<?php
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->get('user')->result();
    }
    
    public function get_paginated($limit, $offset) {
        return $this->db->limit($limit, $offset)
                        ->get('user')
                        ->result();
    }
    
    public function count_all() {
        return $this->db->count_all('user');
    }

    public function delete($id) {
        return $this->db->delete('user', ['id_user' => $id]);
    }
}