<?php
$db = new mysqli(HOST, USER, PASSWORD, DATABASE);

$query = "SELECT * FROM settings";

$result = $db->query($query);

$settings = $result->fetch_all(MYSQLI_ASSOC);

foreach ($settings as $setting) {
    $constant = strtoupper($setting['setting_name']);

    if (!defined($constant)) {
        define($constant, $setting['setting_value']);
    }
}
