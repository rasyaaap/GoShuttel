<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_model extends CI_Model {

    public function get_all() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('info_terkini')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('info_terkini', ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('info_terkini', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('info_terkini', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('info_terkini');
    }
}
