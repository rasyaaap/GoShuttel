<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seeder extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function admin() {
        $email = 'admin@raaster.com';
        $password = 'password123'; // Default password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if admin exists
        $exists = $this->db->get_where('users', ['email' => $email])->row();

        if ($exists) {
            $this->db->where('email', $email);
            $this->db->update('users', ['password' => $hashed_password, 'role' => 'admin']);
            echo "Admin password updated to: <strong>$password</strong><br>";
        } else {
            $data = [
                'name' => 'Admin Raaster',
                'email' => $email,
                'password' => $hashed_password,
                'role' => 'admin',
                'phone' => '081234567890'
            ];
            $this->db->insert('users', $data);
            echo "Admin created with password: <strong>$password</strong><br>";
        }
        
        echo "Email: $email<br>";
        echo "<a href='".base_url('auth/login')."'>Go to Login</a>";
    }
    public function seed_data() {
        // 1. Seed Armada
        $armadas = [
            ['nama_armada' => 'HiAce Executive A1', 'plat_nomor' => 'H 1234 AB', 'kapasitas' => 10, 'status' => 'tersedia'],
            ['nama_armada' => 'HiAce Executive A2', 'plat_nomor' => 'AB 5678 CD', 'kapasitas' => 10, 'status' => 'tersedia'],
            ['nama_armada' => 'Elf Long B1', 'plat_nomor' => 'AD 9012 EF', 'kapasitas' => 16, 'status' => 'tersedia']
        ];
        foreach ($armadas as $a) {
            if ($this->db->get_where('armada', ['plat_nomor' => $a['plat_nomor']])->num_rows() == 0) {
                $this->db->insert('armada', $a);
            }
        }
        echo "Armada seeded.<br>";

        // 2. Seed Rute
        $rutes = [
            ['kota_asal' => 'Semarang', 'kota_tujuan' => 'Yogyakarta', 'harga' => 85000, 'estimasi_waktu' => '3 Jam'],
            ['kota_asal' => 'Yogyakarta', 'kota_tujuan' => 'Semarang', 'harga' => 85000, 'estimasi_waktu' => '3 Jam'],
            ['kota_asal' => 'Semarang', 'kota_tujuan' => 'Solo', 'harga' => 75000, 'estimasi_waktu' => '2 Jam'],
            ['kota_asal' => 'Solo', 'kota_tujuan' => 'Semarang', 'harga' => 75000, 'estimasi_waktu' => '2 Jam'],
            ['kota_asal' => 'Solo', 'kota_tujuan' => 'Yogyakarta', 'harga' => 40000, 'estimasi_waktu' => '1.5 Jam'],
            ['kota_asal' => 'Yogyakarta', 'kota_tujuan' => 'Solo', 'harga' => 40000, 'estimasi_waktu' => '1.5 Jam'],
        ];
        foreach ($rutes as $r) {
            $exist = $this->db->get_where('rute', ['kota_asal' => $r['kota_asal'], 'kota_tujuan' => $r['kota_tujuan']])->row();
            if (!$exist) {
                $this->db->insert('rute', $r);
            }
        }
        echo "Rute seeded.<br>";

        // 3. Seed Jadwal
        // Get Rute IDs first
        $all_rutes = $this->db->get('rute')->result();
        $times = ['06:00:00', '09:00:00', '13:00:00', '16:00:00', '19:00:00'];
        
        foreach ($all_rutes as $rute) {
            foreach ($times as $jam) {
                $check = $this->db->get_where('jadwal', ['rute_id' => $rute->id, 'jam_berangkat' => $jam])->num_rows();
                if ($check == 0) {
                    $this->db->insert('jadwal', [
                        'rute_id' => $rute->id,
                        'jam_berangkat' => $jam,
                        'status' => 'aktif'
                    ]);
                }
            }
        }
        echo "Jadwal seeded.<br>";
        echo "<a href='".base_url()."'>Back to Home</a>";
    }
}
