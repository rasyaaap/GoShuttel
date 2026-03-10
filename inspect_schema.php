<?php
// inspect_schema.php
define('BASEPATH', 'dummy'); 
include('index.php'); // Bootstrap CI
$CI =& get_instance();

echo "--- Rute Table ---\n";
$fields = $CI->db->list_fields('rute');
foreach ($fields as $field) {
    echo $field . "\n";
}

echo "\n--- Jadwal Table ---\n";
$fields = $CI->db->list_fields('jadwal');
foreach ($fields as $field) {
    echo $field . "\n";
}
