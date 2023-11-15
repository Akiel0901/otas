<?php
ob_start();
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');
session_start();

require_once('initialize.php');
require_once('classes/DBConnection.php');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();

    // Validate and sanitize the input data (You should add more validation)
    $archive_code = $_POST['archive_code'] ?? '';
    $curriculum_id = intval($_POST['curriculum_id'] ?? 0);
    $year = intval($_POST['year'] ?? 0);
    $title = $_POST['title'] ?? '';
    $abstract = $_POST['abstract'] ?? '';
    $members = $_POST['members'] ?? '';
    $banner_path = $_POST['banner_path'] ?? '';
    $document_path = $_POST['document_path'] ?? '';
    $student_id = intval($_POST['student_id'] ?? 0);

    // Check if required fields are not empty
    if (empty($archive_code) || empty($title)) {
        $response['status'] = 'error';
        $response['message'] = 'Archive code and title are required fields.';
    } else {
        // Create a DBConnection instance
        $db = new DBConnection;
        $conn = $db->conn;

        // Prepare and execute the SQL INSERT statement
        $sql = "INSERT INTO archive_list (archive_code, curriculum_id, year, title, abstract, members, banner_path, document_path, student_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siisssssi", $archive_code, $curriculum_id, $year, $title, $abstract, $members, $banner_path, $document_path, $student_id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Research added successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error adding research: ' . $conn->error;
        }

        // Close the database connection
        $stmt->close();
        $db->conn->close();
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle non-POST requests or direct script access
    header("HTTP/1.0 403 Forbidden");
    echo "Forbidden";
}
?>
