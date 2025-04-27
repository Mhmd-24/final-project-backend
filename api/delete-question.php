<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['question_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Question ID is required."
    ]);
    exit();
}

$question_id = (int)$data['question_id'];

$query = "DELETE FROM questions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $question_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Question deleted successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Question not found or already deleted."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete question."
    ]);
}

$stmt->close();
$conn->close();
