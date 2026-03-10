<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_Content extends CI_Controller {
    public function index() {
        $this->load->database();
        $query = $this->db->get('news');
        $results = $query->result();
        
        echo "<h1>Debug News Content</h1>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Title</th><th>Content Length</th><th>Raw Content</th></tr>";
        
        foreach($results as $row) {
            echo "<tr>";
            echo "<td>{$row->id}</td>";
            echo "<td>{$row->title}</td>";
            echo "<td>" . strlen($row->content) . "</td>";
            echo "<td><pre>" . htmlspecialchars($row->content) . "</pre></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
