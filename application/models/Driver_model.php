<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_model extends CI_Model {

    public function get_assigned_armada($user_id) {
        $this->db->select('armada.*');
        $this->db->from('driver_detail');
        $this->db->join('armada', 'armada.id = driver_detail.current_armada_id');
        $this->db->where('driver_detail.user_id', $user_id);
        return $this->db->get()->row();
    }

    public function get_todays_trips($driver_id) {
        $this->db->select('perjalanan.*, jadwal.jam_berangkat, rute.kota_asal, rute.kota_tujuan, armada.nama_armada, armada.plat_nomor');
        $this->db->from('perjalanan');
        $this->db->join('jadwal', 'jadwal.id = perjalanan.jadwal_id');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->where('perjalanan.driver_id', $driver_id);
        $this->db->where('perjalanan.tanggal', date('Y-m-d'));
        return $this->db->get()->result();
    }

    public function get_passengers_by_trip($perjalanan_id) {
        $this->db->select('pemesanan.*, users.name as nama_customer, users.phone');
        $this->db->from('pemesanan');
        $this->db->join('users', 'users.id = pemesanan.customer_id');
        $this->db->where('pemesanan.perjalanan_id', $perjalanan_id);
        $this->db->where_in('pemesanan.status_pembayaran', ['lunas']);
        return $this->db->get()->result();
    }
    
    public function validate_ticket($booking_id) {
        $this->db->where('id', $booking_id);
        $this->db->where('status_pembayaran', 'lunas');
        $booking = $this->db->get('pemesanan')->row();
        
        if ($booking) {
            // Check if ticket already scanned
            $ticket = $this->db->get_where('qr_ticket', ['pemesanan_id' => $booking_id])->row();
            if ($ticket && $ticket->is_scanned) {
                return ['status' => false, 'message' => 'Tiket sudah digunakan/scan sebelumnya!'];
            }
            
            // Mark as scanned
            // Check if ticket row exists first
            if (!$ticket) {
                 $this->db->insert('qr_ticket', [
                     'pemesanan_id' => $booking_id,
                     'is_scanned' => 1,
                     'scanned_at' => date('Y-m-d H:i:s'),
                     'scanned_by' => $this->session->userdata('user_id')
                 ]);
            } else {
                 $this->db->where('id', $ticket->id);
                 $this->db->update('qr_ticket', [
                     'is_scanned' => 1,
                     'scanned_at' => date('Y-m-d H:i:s'),
                     'scanned_by' => $this->session->userdata('user_id')
                 ]);
            }
            
            return ['status' => true, 'message' => 'Tiket VALID! Penumpang berhasil check-in.'];
        }
        
        return ['status' => false, 'message' => 'Tiket TIDAK DITEMUKAN atau belum lunas!'];
    }
    public function get_trip_detail($id) {
        $this->db->select('perjalanan.*, jadwal.jam_berangkat, rute.kota_asal, rute.kota_tujuan');
        $this->db->select('users.name as nama_driver, users.phone as driver_phone, armada.nama_armada, armada.plat_nomor');
        $this->db->from('perjalanan');
        $this->db->join('jadwal', 'jadwal.id = perjalanan.jadwal_id');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('users', 'users.id = perjalanan.driver_id', 'left');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->where('perjalanan.id', $id);
        return $this->db->get()->row();
    }

    public function get_driver_stats($driver_id) {
        // Total Completed Trips
        $this->db->where('driver_id', $driver_id);
        $this->db->where('status', 'selesai');
        $total = $this->db->count_all_results('perjalanan');

        // This Week
        $start_week = date('Y-m-d', strtotime('monday this week'));
        $end_week = date('Y-m-d', strtotime('sunday this week'));
        
        $this->db->where('driver_id', $driver_id);
        $this->db->where('status', 'selesai');
        $this->db->where('tanggal >=', $start_week);
        $this->db->where('tanggal <=', $end_week);
        $weekly = $this->db->count_all_results('perjalanan');

        return [
            'total_trips' => $total,
            'weekly_trips' => $weekly
        ];
    }
}
