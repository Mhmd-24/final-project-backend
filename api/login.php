<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing email or password."
    ]);
    exit();
}

$email = trim($data['email']);
$password = $data['password'];

$query = "SELECT id, username, email, password, is_admin FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password."
    ]);
    $stmt->close();
    $conn->close();
    exit();
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password."
    ]);
    $stmt->close();
    $conn->close();
    exit();
}

echo json_encode([
    "status" => "success",
    "message" => "Login successful.",
    "user" => [
        "id" => $user['id'],
        "username" => $user['username'],
        "email" => $user['email'],
        "is_admin" => (bool)$user['is_admin']
    ]
]);

$stmt->close();
$conn->close();
