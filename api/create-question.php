<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['quiz_id']) || !isset($data['question_text']) || empty(trim($data['question_text']))) {
    echo json_encode([
        "status" => "error",
        "message" => "Quiz ID and Question text are required."
    ]);
    exit();
}

$quiz_id = (int)$data['quiz_id'];
$question_text = trim($data['question_text']);

$query = "INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $quiz_id, $question_text);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Question added successfully.",
        "question_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to add question."
    ]);
}

$stmt->close();
$conn->close();
