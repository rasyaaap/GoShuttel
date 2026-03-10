<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint_model extends CI_Model {

    public function get_all($limit = null, $start = null)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('complaints', $limit, $start)->result();
    }

    public function count_all()
    {
        return $this->db->count_all('complaints');
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('complaints', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('complaints', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('complaints', $data);
    }
    
    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('complaints', ['status' => $status]);
    }
    
    public function delete($id)
    {
         $this->db->where('id', $id);
         return $this->db->delete('complaints');
    }
}
