<?php
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->get('user')->result();
    }


    public function delete($id) {
        return $this->db->delete('user', ['id_user' => $id]);
    }
}
?>