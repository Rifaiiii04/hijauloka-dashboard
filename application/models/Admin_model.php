<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    
    public function get_admin_by_email($email) {
        return $this->db->get_where('admin', ['email' => $email])->row();
    }

    public function update_password_by_email($email, $hashed_password) {
        $this->db->where('email', $email);
        return $this->db->update('admin', ['password' => $hashed_password]);
    }
}
