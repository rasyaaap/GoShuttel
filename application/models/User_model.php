<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function check_login($email) {
        $this->db->where('email', $email);
        return $this->db->get('users')->row();
    }

    public function register($data) {
        return $this->db->insert('users', $data);
    }
    
    public function insert_customer_detail($data) {
        return $this->db->insert('customer_detail', $data);
    }

    public function get_user_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
    }

    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    public function update_password($id, $new_hash) {
        $this->db->where('id', $id);
        return $this->db->update('users', ['password' => $new_hash]);
    }
}
