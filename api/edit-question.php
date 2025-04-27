<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['question_id']) || !isset($data['question_text']) || empty(trim($data['question_text']))) {
    echo json_encode([
        "status" => "error",
        "message" => "Question ID and Question text are required."
    ]);
    exit();
}

$question_id = (int)$data['question_id'];
$question_text = trim($data['question_text']);

$query = "UPDATE questions SET question_text = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $question_text, $question_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Question updated successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Question not found or no changes made."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update question."
    ]);
}

$stmt->close();
$conn->close();
