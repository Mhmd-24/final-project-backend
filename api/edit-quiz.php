<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['quiz_id']) || !isset($data['category'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Quiz ID and Category are required."
    ]);
    exit();
}

$quiz_id = (int)$data['quiz_id'];
$category = trim($data['category']);

$query = "UPDATE quizzes SET category = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $category, $quiz_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        
        echo json_encode([
            "status" => "success",
            "message" => "Quiz updated successfully."
        ]);
    } else {
        
        echo json_encode([
            "status" => "error",
            "message" => "Quiz not found or no changes made."
        ]);
    }
} else {
    
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update quiz."
    ]);
}

$stmt->close();
$conn->close();
