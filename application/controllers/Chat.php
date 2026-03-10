<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');
        
        // If Driver accessing index directly -> Chat with Admin
        if ($role == 'driver') {
            // Load view with NO partner_id, which JS handles as "Chat with Admin"
            $this->load->view('layout/header', ['title' => 'Chat Admin']);
            $this->load->view('chat/index'); 
            $this->load->view('layout/footer');
            return;
        }

        // Standard Admin Logic (List contacts) -- Wait, Admin doesn't use this view yet.
        // For now, let's keep it compatible.
        
        $data['contacts'] = $this->Chat_model->get_conversations($user_id, $role);
        $data['active_chat'] = null;
        
        $this->load->view('layout/header', ['title' => 'Chat']);
        $this->load->view('chat/index', $data);
        $this->load->view('layout/footer');
    }

    // AJAX
    // AJAX
    public function get_messages($partner_id) {
        $user_id = $this->session->userdata('user_id');
        
        $this->load->model('Operational_model');
        // Mark as read
        $this->Operational_model->mark_messages_read($partner_id, $user_id);
        
        $messages = $this->Operational_model->get_conversation($user_id, $partner_id);
        
        echo json_encode($messages);
    }

    public function with_driver($driver_id) {
        $user_id = $this->session->userdata('user_id');
        
        // Fetch Driver Info (Optional, for header)
        $driver = $this->db->get_where('users', ['id' => $driver_id])->row();
        
        $data['partner_id'] = $driver_id;
        $data['partner_name'] = $driver ? $driver->name : 'Driver';
        $data['is_driver_chat'] = true;

        $this->load->view('layout/header', ['title' => 'Chat Driver']);
        $this->load->view('chat/index', $data);
        $this->load->view('layout/footer');
    }

    public function with_customer($customer_id) {
        $user_id = $this->session->userdata('user_id');
        
        $customer = $this->db->get_where('users', ['id' => $customer_id])->row();
        
        $data['partner_id'] = $customer_id;
        $data['partner_name'] = $customer ? $customer->name : 'Penumpang';
        $data['is_driver_chat'] = false; // Driver chatting with customer

        $this->load->view('layout/header', ['title' => 'Chat Penumpang']);
        $this->load->view('chat/index', $data);
        $this->load->view('layout/footer');
    }

    // AJAX
    public function send_message() {
        $data = [
            'sender_id' => $this->session->userdata('user_id'),
            'receiver_id' => $this->input->post('receiver_id'),
            'message' => $this->input->post('message'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($this->Chat_model->send_message($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    // --- SIMPLIFIED DRIVER CHATS (Talk to Admin) ---
    public function get_admin_messages() {
        $user_id = $this->session->userdata('user_id');
        $admin_id = 1; 

        $this->load->model('Operational_model'); 
        
        // Mark admin messages as read
        $this->Operational_model->mark_messages_read($admin_id, $user_id);

        $messages = $this->Operational_model->get_conversation($user_id, $admin_id);
        
        echo json_encode($messages);
    }

    public function send_to_admin() {
        $message = $this->input->post('message');
        $user_id = $this->session->userdata('user_id');
        $admin_id = 1;

        if ($message) {
            $data = [
                'sender_id' => $user_id,
                'receiver_id' => $admin_id,
                'message' => $message,
                'is_read' => 0
            ];
            $this->load->model('Operational_model');
            $this->Operational_model->insert_chat($data);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
