<?php
require_once('../../config.php');

// Query to fetch curriculum (course) data
$qry = $conn->query("SELECT id, name FROM curriculum_list WHERE status = 1 ORDER BY name ASC");

$courses = array();
while ($row = $qry->fetch_assoc()) {
    $courses[$row['id']] = $row['name'];
}

header('Content-Type: application/json');
echo json_encode($courses);
