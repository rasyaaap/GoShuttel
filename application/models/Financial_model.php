<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_model extends CI_Model {

    public function get_all_payments() {
        $this->db->select('driver_payments.*, u.name as driver_name, a.name as admin_name');
        $this->db->from('driver_payments');
        $this->db->join('users u', 'u.id = driver_payments.user_id');
        $this->db->join('users a', 'a.id = driver_payments.admin_id');
        $this->db->order_by('payment_date', 'DESC');
        return $this->db->get()->result();
    }

    public function get_driver_payments($driver_id) {
        $this->db->select('driver_payments.*, u.name as admin_name');
        $this->db->from('driver_payments');
        $this->db->join('users u', 'u.id = driver_payments.admin_id', 'left');
        $this->db->where('driver_payments.user_id', $driver_id);
        $this->db->order_by('payment_date', 'DESC');
        return $this->db->get()->result();
    }

    public function get_payment_by_id($id) {
        $this->db->select('driver_payments.*, u.name as admin_name, d.name as driver_name, d.phone as driver_phone, d.email as driver_email');
        $this->db->from('driver_payments');
        $this->db->join('users u', 'u.id = driver_payments.admin_id', 'left');
        $this->db->join('users d', 'd.id = driver_payments.user_id', 'left');
        $this->db->where('driver_payments.id', $id);
        return $this->db->get()->row();
    }

    public function insert_payment($data) {
        // Use 'pembayaran_driver' table if that's the standard, or 'driver_payments'
        // Just purely based on previous view, it used 'driver_payments'.
        // But the Schema had 'pembayaran_driver'. I'll stick to 'driver_payments' to match the existing model code.
        return $this->db->insert('driver_payments', $data);
    }

    public function get_driver_salary_summary() {
        // List all drivers with their stats
        $this->db->select('users.id, users.name, users.phone, driver_detail.gaji_per_trip');
        $this->db->select('(SELECT COUNT(*) FROM perjalanan WHERE perjalanan.driver_id = users.id AND perjalanan.status = "selesai") as total_pp');
        
        $this->db->from('users');
        $this->db->join('driver_detail', 'driver_detail.user_id = users.id', 'left');
        $this->db->where('users.role', 'driver');
        return $this->db->get()->result();
    }

    public function update_driver_rate($user_id, $rate) {
        $this->db->where('user_id', $user_id);
        // Check if exists
        if($this->db->count_all_results('driver_detail') > 0) {
            $this->db->where('user_id', $user_id);
            return $this->db->update('driver_detail', ['gaji_per_trip' => $rate]);
        } else {
            return $this->db->insert('driver_detail', ['user_id' => $user_id, 'gaji_per_trip' => $rate]);
        }
    }
}
