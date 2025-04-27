<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once("../db.php");

$query = "SELECT id, category FROM quizzes";
$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $quizzes = [];

    while ($row = $result->fetch_assoc()) {
        $quizzes[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "message" => "Quizzes fetched successfully.",
        "data" => $quizzes
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No quizzes found."
    ]);
}

$stmt->close();
$conn->close();
