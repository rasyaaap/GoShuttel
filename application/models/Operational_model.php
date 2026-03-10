<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operational_model extends CI_Model {

    // --- RUTE ---
    public function get_all_rute() {
        return $this->db->get('rute')->result();
    }

    public function get_rute_by_id($id) {
        return $this->db->get_where('rute', ['id' => $id])->row();
    }

    public function insert_rute($data) {
        return $this->db->insert('rute', $data);
    }

    public function update_rute($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('rute', $data);
    }

    public function delete_rute($id) {
        $this->db->where('id', $id);
        return $this->db->delete('rute');
    }

    // --- JADWAL ---
    public function get_all_jadwal() {
        $this->db->select('jadwal.*, r.kota_asal, r.kota_tujuan');
        $this->db->from('jadwal');
        $this->db->join('rute r', 'r.id = jadwal.rute_id');
        return $this->db->get()->result();
    }

    public function get_jadwal_by_id($id) {
        return $this->db->get_where('jadwal', ['id' => $id])->row();
    }

    public function insert_jadwal($data) {
        return $this->db->insert('jadwal', $data);
    }

    public function update_jadwal($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('jadwal', $data);
    }
    
    public function delete_jadwal($id) {
        $this->db->where('id', $id);
        return $this->db->delete('jadwal');
    }

    // --- ARMADA ---
    // --- ARMADA ---
    public function get_all_armada() {
        $this->db->select('armada.*');
        $this->db->select('users.name as current_driver_name');
        $this->db->select('users.id as current_driver_id');
        $this->db->from('armada');
        $this->db->join('driver_detail', 'driver_detail.current_armada_id = armada.id', 'left');
        $this->db->join('users', 'users.id = driver_detail.user_id', 'left');
        $this->db->order_by('armada.id', 'ASC');
        return $this->db->get()->result();
    }
    
    public function get_armada_by_id($id) {
        return $this->db->get_where('armada', ['id' => $id])->row();
    }

    public function insert_armada($data) {
        return $this->db->insert('armada', $data);
    }

    // --- PERJALANAN (TRIPS) ---
    public function get_all_perjalanan() {
        $this->db->select('perjalanan.*, jadwal.jam_berangkat, rute.kota_asal, rute.kota_tujuan, armada.nama_armada, users.name as nama_driver');
        $this->db->select('(SELECT COUNT(*) FROM pemesanan WHERE pemesanan.perjalanan_id = perjalanan.id AND status_pembayaran = "lunas") as total_passengers');
        $this->db->select('(SELECT COUNT(*) FROM pemesanan WHERE pemesanan.perjalanan_id = perjalanan.id AND status_pembayaran = "lunas" AND is_picked_up = 1) as picked_up_count');
        $this->db->from('perjalanan');
        $this->db->join('jadwal', 'jadwal.id = perjalanan.jadwal_id');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->join('users', 'users.id = perjalanan.driver_id', 'left');
        $this->db->order_by('perjalanan.tanggal', 'DESC');
        $this->db->order_by('jadwal.jam_berangkat', 'ASC');
        return $this->db->get()->result();
    }

    public function insert_perjalanan($data) {
        return $this->db->insert('perjalanan', $data);
    }

    public function delete_perjalanan($id) {
        $this->db->where('id', $id);
        return $this->db->delete('perjalanan');
    }

    public function get_driver_locations() {
        $this->db->select('driver_detail.latitude, driver_detail.longitude, driver_detail.last_location_update, users.name, users.phone, armada.nama_armada, armada.plat_nomor');
        $this->db->from('driver_detail');
        $this->db->join('users', 'users.id = driver_detail.user_id');
        $this->db->join('armada', 'armada.id = driver_detail.current_armada_id', 'left');
    // REMOVED: Filter needed to show all drivers including those without initial location
    // $this->db->where('driver_detail.latitude IS NOT NULL');
    // $this->db->where('driver_detail.longitude IS NOT NULL');
    // Optional: Only show drivers active in last 30 mins
        // $this->db->where('last_location_update >=', date('Y-m-d H:i:s', strtotime('-30 minutes')));
        return $this->db->get()->result();
    }

    // --- CHAT SYSTEM ---
    public function get_chat_contacts($role) {
        $my_id = $this->session->userdata('user_id');
        $this->db->select('users.id, users.name, users.photo_profile, users.role');
        $this->db->select('(SELECT COUNT(*) FROM chat WHERE chat.sender_id = users.id AND chat.receiver_id = '.$my_id.' AND chat.is_read = 0) as unread_count');
        $this->db->from('users');
        $this->db->where('role', $role);
        return $this->db->get()->result();
    }

    public function get_conversation($user_a, $user_b) {
        $this->db->select('chat.*, sender.name as sender_name');
        $this->db->from('chat');
        $this->db->join('users as sender', 'sender.id = chat.sender_id');
        $this->db->group_start();
            $this->db->where('sender_id', $user_a)->where('receiver_id', $user_b);
        $this->db->group_end();
        $this->db->or_group_start();
            $this->db->where('sender_id', $user_b)->where('receiver_id', $user_a);
        $this->db->group_end();
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get()->result();
    }
    
    public function mark_messages_read($sender_id, $receiver_id) {
        $this->db->where('sender_id', $sender_id);
        $this->db->where('receiver_id', $receiver_id);
        $this->db->update('chat', ['is_read' => 1]);
    }

    public function insert_chat($data) {
        return $this->db->insert('chat', $data);
    }

    public function update_armada($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('armada', $data);
    }
    
    public function delete_armada($id) {
        $this->db->where('id', $id);
        return $this->db->delete('armada');
    }

    public function is_armada_taken($armada_id, $exclude_user_id = null) {
        $this->db->select('user_id');
        $this->db->from('driver_detail');
        $this->db->where('current_armada_id', $armada_id);
        if ($exclude_user_id) {
            $this->db->where('user_id !=', $exclude_user_id);
        }
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }

    // --- DASHBOARD STATS ---
    public function count_drivers() {
        return $this->db->where('role', 'driver')->count_all_results('users');
    }

    public function get_all_drivers() {
        $this->db->select('users.*, driver_detail.current_armada_id');
        $this->db->from('users');
        $this->db->join('driver_detail', 'driver_detail.user_id = users.id', 'left');
        $this->db->where('role', 'driver');
        return $this->db->get()->result();
    }

    public function count_todays_trips() {
        $this->db->where('tanggal', date('Y-m-d'));
        return $this->db->count_all_results('perjalanan');
    }

    public function count_bookings() {
        return $this->db->count_all('pemesanan');
    }

    public function sum_revenue() {
        $this->db->select_sum('total_harga');
        $this->db->where('status_pembayaran', 'lunas');
        $query = $this->db->get('pemesanan');
        return $query->row()->total_harga ?: 0;
    }

    public function get_inbox($user_id) {
        $this->db->select('chat.*, users.name as sender_name, users.role as sender_role');
        $this->db->from('chat');
        $this->db->join('users', 'users.id = chat.sender_id');
        $this->db->where('chat.receiver_id', $user_id);
        $this->db->order_by('chat.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function count_unread_inbox($user_id) {
        $this->db->where('receiver_id', $user_id);
        $this->db->where('is_read', 0);
        return $this->db->count_all_results('chat');
    }

    public function mark_all_read($user_id) {
        $this->db->where('receiver_id', $user_id);
        $this->db->update('chat', ['is_read' => 1]);
    }

    // --- AUTO UPDATE SCHEDULE LOGIC ---
    public function generate_future_trips($days = 7) {
        // 1. Get all active schedules
        $active_schedules = $this->db->get_where('jadwal', ['status' => 'aktif'])->result();
        
        if (empty($active_schedules)) return 0;

        $count = 0;
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime("+$days days"));

        // 2. Loop dates
        $current_date = $start_date;
        while (strtotime($current_date) <= strtotime($end_date)) {
            // Get day name (Indonesian or English depending on stored data, assuming English keys in DB for now "Senin" etc mapped? 
            // Warning: The DB defaults said "Senin", "Selasa". PHP date('l') gives Monday.
            // Need mapping.
            $day_map = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            $day_name = $day_map[date('l', strtotime($current_date))];

            foreach ($active_schedules as $jadwal) {
                 // Check if schedule runs on this day
                 $hari_aktif = json_decode($jadwal->hari_aktif ?? '', true);
                 if (!is_array($hari_aktif)) {
                     // Handle if legacy or plain string "Setiap Hari" (though DB seed says json)
                     // If null or "Setiap Hari", assume run.
                     // The existing seed sets '["Senin",...]'
                 } else {
                     if (!in_array($day_name, $hari_aktif)) continue;
                 }

                 // Check if trip already exists
                 $exists = $this->db->get_where('perjalanan', [
                     'jadwal_id' => $jadwal->id,
                     'tanggal'   => $current_date
                 ])->num_rows() > 0;

                 if (!$exists) {
                     // Auto assign armada (Use Default if set, else random/first)
                     if (!empty($jadwal->armada_id)) {
                         $armada_id = $jadwal->armada_id;
                     } else {
                         // Fallback: Just pick one active armada
                         $armada = $this->db->get('armada')->row(); 
                         $armada_id = $armada ? $armada->id : 1;
                     }
                     
                     $driver_id = !empty($jadwal->driver_id) ? $jadwal->driver_id : NULL;

                     $data = [
                         'jadwal_id' => $jadwal->id,
                         'tanggal'   => $current_date,
                         'armada_id' => $armada_id,
                         'driver_id' => $driver_id,
                         'status'    => 'dijadwalkan'
                     ];
                     $this->db->insert('perjalanan', $data);
                     $count++;
                 }
            }
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
        }
        return $count;
    }
}
