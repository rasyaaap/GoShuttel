<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    public function search_jadwal($asal, $tujuan, $tanggal) {
        // Simple search: Find jadwal with matching route
        // In real app, we check if 'perjalanan' exists for that date, or create dynamic availability
        // For this demo, we assume Jadwal is the master, and we generate Perjalanan on the fly or query availability
        
        $this->db->select('jadwal.*, rute.kota_asal, rute.kota_tujuan, rute.harga, rute.estimasi_waktu, armada.nama_armada');
        $this->db->from('jadwal');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = (SELECT id FROM armada LIMIT 1)', 'left'); // Mock join for fleet info visualization
        $this->db->where('rute.kota_asal', $asal);
        if ($tujuan) {
             $this->db->where('rute.kota_tujuan', $tujuan);
        }
        $this->db->where('jadwal.status', 'aktif');

        // Filter: Hide schedule if departure passed (Only for Today)
        if ($tanggal == date('Y-m-d')) {
             // Logic: Show if jam_berangkat > Current Time
             $current_time = date('H:i:s');
             $this->db->where('jadwal.jam_berangkat >', $current_time);
        } elseif ($tanggal < date('Y-m-d')) {
            return []; // Don't show schedules for past dates
        }

        return $this->db->get()->result();
    }

    public function get_all_schedules() {
        $this->db->select('jadwal.*, rute.kota_asal, rute.kota_tujuan, rute.harga, rute.estimasi_waktu, armada.nama_armada');
        $this->db->from('jadwal');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = (SELECT id FROM armada LIMIT 1)', 'left'); 
        $this->db->where('jadwal.status', 'aktif');
        $this->db->order_by('rute.kota_asal', 'ASC');
        $this->db->order_by('jadwal.jam_berangkat', 'ASC');
        return $this->db->get()->result();
    }

    public function check_trip($jadwal_id, $tanggal) {
        $this->db->select('perjalanan.*, armada.nama_armada, armada.no_plat, armada.kapasitas, users.name as driver_name');
        $this->db->from('perjalanan');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->join('users', 'users.id = perjalanan.driver_id', 'left');
        $this->db->where('perjalanan.jadwal_id', $jadwal_id);
        $this->db->where('perjalanan.tanggal', $tanggal);
        return $this->db->get()->row();
    }

    public function get_jadwal_detail($jadwal_id, $tanggal = null) {
        $this->db->select('jadwal.*, rute.kota_asal, rute.kota_tujuan, rute.harga');
        // Dynamic Armada Selection
        if ($tanggal) {
            $this->db->select('IFNULL(p.layout_kursi, a.layout_kursi) as layout_kursi');
            $this->db->join('perjalanan p_trip', 'p_trip.jadwal_id = jadwal.id AND p_trip.tanggal = "'.$tanggal.'"', 'left');
            $this->db->join('armada p', 'p.id = p_trip.armada_id', 'left'); // Armada from specific trip
            $this->db->join('armada a', 'a.id = (SELECT id FROM armada LIMIT 1)', 'left'); // Fallback default armada
        } else {
             $this->db->select('"1-3-4" as layout_kursi');
        }

        $this->db->from('jadwal');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->where('jadwal.id', $jadwal_id);
        return $this->db->get()->row();
    }

    public function get_booking_by_id($id) {
        $this->db->select('pemesanan.*, perjalanan.tanggal, jadwal.jam_berangkat, rute.kota_asal, rute.kota_tujuan, armada.nama_armada');
        $this->db->select('perjalanan.driver_id, users.name as nama_driver'); // Add driver info
        $this->db->from('pemesanan');
        $this->db->join('perjalanan', 'perjalanan.id = pemesanan.perjalanan_id');
        $this->db->join('jadwal', 'jadwal.id = perjalanan.jadwal_id');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->join('users', 'users.id = perjalanan.driver_id', 'left'); // Join users for driver name
        $this->db->where('pemesanan.id', $id);
        $booking = $this->db->get()->row();

        if ($booking) {
            $this->db->select('nomor_kursi');
            $this->db->where('pemesanan_id', $id);
            $booking->seats = $this->db->get('pemesanan_seat')->result();
        }
        return $booking;
    }

    public function get_bookings_by_customer($customer_id) {
        // Fallback or general use
        return $this->get_upcoming_bookings($customer_id);
    }

    public function get_upcoming_bookings($customer_id) {
        $this->db->select('pemesanan.*, perjalanan.tanggal, jadwal.jam_berangkat, rute.kota_asal, rute.kota_tujuan, jadwal.id as jadwal_id, armada.nama_armada');
        $this->db->select('(SELECT GROUP_CONCAT(nomor_kursi SEPARATOR ", ") FROM pemesanan_seat WHERE pemesanan_seat.pemesanan_id = pemesanan.id) as nomor_kursi');
        $this->db->from('pemesanan');
        $this->db->join('perjalanan', 'perjalanan.id = pemesanan.perjalanan_id');
        $this->db->join('jadwal', 'jadwal.id = perjalanan.jadwal_id');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->where('pemesanan.customer_id', $customer_id);
        // Show future or today
        $this->db->where('perjalanan.tanggal >=', date('Y-m-d'));
        $this->db->order_by('perjalanan.tanggal', 'ASC');
        return $this->db->get()->result();
    }

    public function get_history_bookings($customer_id) {
        $this->db->select('pemesanan.*, perjalanan.tanggal, jadwal.jam_berangkat, rute.kota_asal, rute.kota_tujuan, jadwal.id as jadwal_id, armada.nama_armada');
        $this->db->select('(SELECT GROUP_CONCAT(nomor_kursi SEPARATOR ", ") FROM pemesanan_seat WHERE pemesanan_seat.pemesanan_id = pemesanan.id) as nomor_kursi');
        $this->db->from('pemesanan');
        $this->db->join('perjalanan', 'perjalanan.id = pemesanan.perjalanan_id');
        $this->db->join('jadwal', 'jadwal.id = perjalanan.jadwal_id');
        $this->db->join('rute', 'rute.id = jadwal.rute_id');
        $this->db->join('armada', 'armada.id = perjalanan.armada_id', 'left');
        $this->db->where('pemesanan.customer_id', $customer_id);
        // Show ALL (Past & Future) so user can see their full log
        // $this->db->where('perjalanan.tanggal <', date('Y-m-d')); 
        $this->db->order_by('perjalanan.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_booked_seats($jadwal_id, $tanggal) {
        // Find existing 'perjalanan' or bookings for this schedule date
        // JOIN pemesanan_seat
        
        $this->db->select('pemesanan_seat.nomor_kursi');
        $this->db->from('pemesanan_seat');
        $this->db->join('pemesanan', 'pemesanan.id = pemesanan_seat.pemesanan_id');
        $this->db->join('perjalanan', 'perjalanan.id = pemesanan.perjalanan_id');
        $this->db->where('perjalanan.jadwal_id', $jadwal_id);
        $this->db->where('perjalanan.tanggal', $tanggal);
        $this->db->where_in('pemesanan.status_pembayaran', ['pending', 'lunas']); // Exclude cancelled
        $query = $this->db->get();
        
        return array_column($query->result_array(), 'nomor_kursi');
    }

    public function create_booking($data_pemesanan, $seats) {
        $this->db->trans_start();
        
        // 1. Check or Create Perjalanan
        $perjalanan = $this->db->get_where('perjalanan', [
            'jadwal_id' => $data_pemesanan['jadwal_id'], 
            'tanggal' => $data_pemesanan['tanggal']
        ])->row();

        if (!$perjalanan) {
            // Auto assign armada (first available or random for demo)
            $armada = $this->db->get('armada')->row(); 
            $this->db->insert('perjalanan', [
                'jadwal_id' => $data_pemesanan['jadwal_id'],
                'tanggal' => $data_pemesanan['tanggal'],
                'armada_id' => $armada ? $armada->id : 1, // Fallback
                'status' => 'dijadwalkan'
            ]);
            $perjalanan_id = $this->db->insert_id();
        } else {
            $perjalanan_id = $perjalanan->id;
        }

        // 2. Insert Pemesanan
        $pemesanan_id = 'TRx' . date('ymd') . rand(100,999);
        $insert_pemesanan = [
            'id' => $pemesanan_id,
            'customer_id' => $data_pemesanan['customer_id'],
            'perjalanan_id' => $perjalanan_id,
            'total_harga' => $data_pemesanan['total_harga'],
            'status_pembayaran' => 'pending',
            'metode_pembayaran' => 'transfer',
            'titik_jemput_lat' => $data_pemesanan['lat'],
            'titik_jemput_lng' => $data_pemesanan['lng'],
            'alamat_jemput' => $data_pemesanan['alamat']
        ];
        $this->db->insert('pemesanan', $insert_pemesanan);

        // 3. Insert Seats
        foreach ($seats as $seat) {
            $this->db->insert('pemesanan_seat', [
                'pemesanan_id' => $pemesanan_id,
                'nomor_kursi' => $seat,
                'nama_penumpang' => $data_pemesanan['nama_pemesan'] // Simplification: assume same name
            ]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status() ? $pemesanan_id : FALSE;
    }
    public function get_unique_origins() {
        $this->db->distinct();
        $this->db->select('kota_asal');
        $query = $this->db->get('rute');
        return array_column($query->result_array(), 'kota_asal');
    }

    public function get_unique_destinations() {
        $this->db->distinct();
        $this->db->select('kota_tujuan');
        $query = $this->db->get('rute');
        return array_column($query->result_array(), 'kota_tujuan');
    }

    public function get_recent_bookings($limit = 5) {
        $this->db->select('pemesanan.*, users.name as nama_pemesan');
        $this->db->from('pemesanan');
        $this->db->join('users', 'users.id = pemesanan.customer_id', 'left');
        $this->db->order_by('pemesanan.id', 'DESC'); // Use ID or created_at if available
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
