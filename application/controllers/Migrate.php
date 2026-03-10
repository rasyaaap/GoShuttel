<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function index() {
        echo "<h1>Migrating Database...</h1>";
        
        // 1. Add current_armada_id to driver_detail
        if (!$this->db->field_exists('current_armada_id', 'driver_detail')) {
            $this->db->query("ALTER TABLE driver_detail ADD COLUMN current_armada_id INT NULL");
            echo "<p>[SUCCESS] Added column 'current_armada_id' to table 'driver_detail'.</p>";
        } else {
             echo "<p>[SKIP] Column 'current_armada_id' already exists.</p>";
        }

        // 2. Add Location Columns
        if (!$this->db->field_exists('latitude', 'driver_detail')) {
            $this->db->query("ALTER TABLE driver_detail ADD COLUMN latitude DECIMAL(10,8) NULL");
            $this->db->query("ALTER TABLE driver_detail ADD COLUMN longitude DECIMAL(11,8) NULL");
            $this->db->query("ALTER TABLE driver_detail ADD COLUMN last_location_update DATETIME NULL");
            echo "<p>[SUCCESS] Added location columns to 'driver_detail'.</p>";
        } else {
             echo "<p>[SKIP] Location columns already exist.</p>";
        }

        // 3. Create Payments Table
        if (!$this->db->table_exists('driver_payments')) {
            $this->db->query("CREATE TABLE driver_payments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                admin_id INT NOT NULL,
                amount DECIMAL(15,2) NOT NULL,
                payment_date DATE NOT NULL,
                note TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;");
             echo "<p>[SUCCESS] Created table 'driver_payments'.</p>";
        } else {
             echo "<p>[SKIP] Table 'driver_payments' already exists.</p>";
        }

        // 3.5 Update payment_date to DATETIME (Fix for 00:00 issue)
        // We use a safe check by trying to alter it.
        $this->db->query("ALTER TABLE driver_payments MODIFY COLUMN payment_date DATETIME NOT NULL");
        echo "<p>[UPDATE] Ensured 'payment_date' is DATETIME in 'driver_payments'.</p>";
        
        // Fix ALL specific records with 00:00
        $this->db->query("UPDATE driver_payments SET payment_date = NOW() WHERE DATE_FORMAT(payment_date, '%H:%i') = '00:00'"); 
        echo "<p>[UPDATE] Fixed timestamp for ALL 00:00 payment records.</p>";

        // 4. Create News Table
        if (!$this->db->table_exists('news')) {
            $this->db->query("CREATE TABLE news (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                image VARCHAR(255) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;");
             echo "<p>[SUCCESS] Created table 'news'.</p>";
        } else {
             echo "<p>[SKIP] Table 'news' already exists.</p>";
        }

        // 5. Create Complaints Table
        if (!$this->db->table_exists('complaints')) {
            $this->db->query("CREATE TABLE complaints (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NULL,
                name VARCHAR(100) NULL,
                email VARCHAR(100) NULL,
                subject VARCHAR(200) NOT NULL,
                message TEXT NOT NULL,
                status ENUM('pending', 'resolved') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;");
             echo "<p>[SUCCESS] Created table 'complaints'.</p>";
        } else {
             echo "<p>[SKIP] Table 'complaints' already exists.</p>";
        }

        // 6. Create Info Terkini Table (New Feature)
        if (!$this->db->table_exists('info_terkini')) {
            $this->db->query("CREATE TABLE info_terkini (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                info_type ENUM('promo', 'rute', 'info') NOT NULL DEFAULT 'info',
                content TEXT NULL,
                link_url VARCHAR(255) NULL,
                tag_text VARCHAR(50) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;");
             echo "<p>[SUCCESS] Created table 'info_terkini'.</p>";
        } else {
             echo "<p>[SKIP] Table 'info_terkini' already exists.</p>";
        }

        // 7. Update info_type to VARCHAR (Flexibility)
        $this->db->query("ALTER TABLE info_terkini MODIFY COLUMN info_type VARCHAR(50) NOT NULL DEFAULT 'info'");
        echo "<p>[UPDATE] Changed 'info_type' to VARCHAR for more color options.</p>";

        // 8. Add Default Resources to Jadwal
        if (!$this->db->field_exists('armada_id', 'jadwal')) {
            $this->db->query("ALTER TABLE jadwal ADD COLUMN armada_id INT NULL");
            $this->db->query("ALTER TABLE jadwal ADD COLUMN driver_id INT NULL");
             echo "<p>[SUCCESS] Added 'armada_id' and 'driver_id' to 'jadwal' table.</p>";
        } else {
             echo "<p>[SKIP] Default resource columns already exist in 'jadwal'.</p>";
        }

        echo "<h3>Migration Complete. <a href='".base_url('admin/users')."'>Back to Admin</a></h3>";
    }
}
