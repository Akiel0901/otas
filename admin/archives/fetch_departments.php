<?php
require_once('../../config.php');

// Query to fetch department data
$qry = $conn->query("SELECT id, name FROM department_list WHERE status = 1 ORDER BY name ASC");

$departments = array();
while ($row = $qry->fetch_assoc()) {
    $departments[$row['id']] = $row['name'];
}

header('Content-Type: application/json');
echo json_encode($departments);
