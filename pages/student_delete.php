<?php
include dirname(__DIR__)."/db.php";

/* grab and validate the id parameter */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo 'Invalid student ID';
    exit;
}

$stmt = $conn->prepare("DELETE FROM student WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header('Location: ../pages/student_list.php');
    exit;
} else {
    echo 'Error: Student not found or could not be deleted';
}
?>