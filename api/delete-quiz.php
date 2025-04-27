<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['quiz_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Quiz ID is required."
    ]);
    exit();
}

$quiz_id = (int)$data['quiz_id'];

$query = "DELETE FROM quizzes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $quiz_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        
        echo json_encode([
            "status" => "success",
            "message" => "Quiz deleted successfully."
        ]);
    } else {
        
        echo json_encode([
            "status" => "error",
            "message" => "Quiz not found or already deleted."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete quiz."
    ]);
}

$stmt->close();
$conn->close();
