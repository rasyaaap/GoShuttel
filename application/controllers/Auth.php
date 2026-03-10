<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            $this->redirect_based_on_role();
        } else {
            redirect('auth/login');
        }
    }

    public function login() {
        if ($this->session->userdata('user_id')) {
            $this->redirect_based_on_role();
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->User_model->check_login($email);

            if ($user) {
                if (password_verify($password, $user->password)) {
                    $session_data = array(
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);
                    $this->redirect_based_on_role();
                } else {
                    $this->session->set_flashdata('error', 'Password salah!');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Email tidak terdaftar!');
                redirect('auth/login');
            }
        }
    }

    public function register() {
         if ($this->session->userdata('user_id')) {
            $this->redirect_based_on_role();
        }

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('phone', 'Nomor HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/register');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'phone' => $this->input->post('phone'),
                'role' => 'customer' // Default role
            );

            if ($this->User_model->register($data)) {
                $user_id = $this->db->insert_id();
                // Init customer detail
                $this->User_model->insert_customer_detail(['user_id' => $user_id]);
                
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal! Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    private function redirect_based_on_role() {
        $role = $this->session->userdata('role');
        if ($role == 'admin') {
            redirect('admin/dashboard');
        } elseif ($role == 'driver') {
            redirect('driver/dashboard');
        } else {
            redirect('customer/dashboard');
        }
    }
}
