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

$query = "SELECT id, question_text FROM questions WHERE quiz_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $questions = [];

    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "message" => "Questions fetched successfully.",
        "data" => $questions
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No questions found for this quiz."
    ]);
}

$stmt->close();
$conn->close();
