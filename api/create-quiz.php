<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['category']) || empty(trim($data['category']))) {
    echo json_encode([
        "status" => "error",
        "message" => "Category is required."
    ]);
    exit();
}

$category = trim($data['category']);

$query = "INSERT INTO quizzes (category) VALUES (?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $category);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Quiz created successfully.",
        "quiz_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to create quiz."
    ]);
}

$stmt->close();
$conn->close();
