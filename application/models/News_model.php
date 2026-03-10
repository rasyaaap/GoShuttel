<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

    public function get_all($limit = null, $start = null)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('news', $limit, $start)->result();
    }

    public function count_all()
    {
        return $this->db->count_all('news');
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('news', ['id' => $id])->row();
    }
    
    public function get_recent($limit = 3)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('news', $limit)->result();
    }

    public function insert($data)
    {
        return $this->db->insert('news', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('news', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('news');
    }
}
