<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_table_exists();
    }

    private function ensure_table_exists() {
        if (!$this->db->table_exists('settings')) {
            $this->db->query("CREATE TABLE `settings` (
                `setting_key` VARCHAR(50) NOT NULL,
                `setting_value` TEXT,
                PRIMARY KEY (`setting_key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

            // Insert defaults
            $defaults = [
                'hero_tagline' => 'Mitra Perjalanan Terpercaya',
                'hero_title' => 'Jelajahi Kenyamanan <br><span class="text-blue-300">Perjalanan Antar Kota</span>',
                'hero_subtitle' => 'Akses jadwal perjalanan dengan mudah. Temukan rute terbaik, armada premium, dan tarif transparan dalam satu platform digital yang interaktif.',
                'hero_image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'
            ];

            foreach ($defaults as $key => $val) {
                $this->insert_setting($key, $val);
            }
        }
    }

    public function get_setting($key) {
        $query = $this->db->get_where('settings', ['setting_key' => $key]);
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        return null;
    }

    public function get_all_settings() {
        $result = $this->db->get('settings')->result();
        $settings = [];
        foreach ($result as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        return $settings;
    }

    public function insert_setting($key, $value) {
        return $this->db->insert('settings', ['setting_key' => $key, 'setting_value' => $value]);
    }

    public function update_setting($key, $value) {
        $this->db->where('setting_key', $key);
        if ($this->db->count_all_results('settings') > 0) {
            $this->db->where('setting_key', $key);
            return $this->db->update('settings', ['setting_value' => $value]);
        } else {
            return $this->insert_setting($key, $value);
        }
    }
}
