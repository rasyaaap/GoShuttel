<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {

    public function get_all($limit = null, $start = null)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('gallery', $limit, $start)->result();
    }
    
    public function get_recent($limit = 6)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('gallery', $limit)->result();
    }

    public function get_by_category($category)
    {
        $this->db->where('category', $category);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('gallery')->result();
    }

    public function count_all()
    {
        return $this->db->count_all('gallery');
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('gallery', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('gallery', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('gallery', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('gallery');
    }
}
