<?php

include_once("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields."
    ]);
    exit();
}

$username = trim($data['username']);
$email = trim($data['email']);
$password = $data['password'];
$is_admin = 0;

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$checkQuery = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists."
    ]);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

$insertQuery = "INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("sssi", $username, $email, $hashedPassword, $is_admin);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "User registered successfully."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Registration failed. Please try again."
    ]);
}

$stmt->close();
$conn->close();
