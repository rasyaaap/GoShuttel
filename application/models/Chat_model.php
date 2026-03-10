<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {

    public function get_conversations($user_id, $role) {
        // Build list of people this user has chatted with
        
        if ($role == 'admin') {
            // Admin sees everyone they chatted with
            $this->db->select('DISTINCT(CASE WHEN sender_id = '.$user_id.' THEN receiver_id ELSE sender_id END) as partner_id, users.name, users.role');
            $this->db->from('chat');
            $this->db->join('users', 'users.id = (CASE WHEN sender_id = '.$user_id.' THEN receiver_id ELSE sender_id END)');
            $this->db->where('sender_id', $user_id);
            $this->db->or_where('receiver_id', $user_id);
            return $this->db->get()->result();
        } else {
            // Driver/User sees Admin + People they chatted with
            
            // 1. Get explicit interactions (e.g. Driver <-> Customer)
            $this->db->select('DISTINCT(CASE WHEN sender_id = '.$user_id.' THEN receiver_id ELSE sender_id END) as partner_id, users.name, users.role');
            $this->db->from('chat');
            $this->db->join('users', 'users.id = (CASE WHEN sender_id = '.$user_id.' THEN receiver_id ELSE sender_id END)');
            $this->db->where('sender_id', $user_id);
            $this->db->or_where('receiver_id', $user_id);
            $chats = $this->db->get()->result();

            // 2. Ensure Admin is always available
            $admin_exists = false;
            foreach($chats as $c) {
                if($c->role == 'admin') $admin_exists = true;
            }

            if(!$admin_exists) {
                $admins = $this->db->get_where('users', ['role' => 'admin'])->result();
                foreach($admins as $a) {
                    $obj = new stdClass();
                    $obj->partner_id = $a->id;
                    $obj->name = $a->name;
                    $obj->role = 'admin';
                    array_unshift($chats, $obj); // Add to top
                }
            }
            
            return $chats;
        }
    }

    public function get_messages($user_id, $partner_id) {
        $this->db->where("(sender_id = $user_id AND receiver_id = $partner_id) OR (sender_id = $partner_id AND receiver_id = $user_id)");
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('chat')->result();
    }

    public function send_message($data) {
        return $this->db->insert('chat', $data);
    }
}
