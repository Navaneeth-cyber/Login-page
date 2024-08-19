<?php

session_start(); // Start the session

// Database connection

$conn = new mysqli("localhost", "username", "password", "database_name");

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);

    $email = trim($_POST['email']);

    $password = trim($_POST['password']);

    $confirm_password = trim($_POST['confirm-password']);

    // Validate input

    if ($password !== $confirm_password) {

        echo "Passwords do not match.";

        exit();

    }

    // Check if the username or email already exists

    $sql = "SELECT id FROM users WHERE username = ? OR email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $username, $email);

    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        echo "Username or email already taken.";

    } else {

        // Hash the password

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {

            $_SESSION['user_id'] = $stmt->insert_id;

            $_SESSION['username'] = $username;

            header("Location: main.html"); // Redirect to the main page

            exit();

        } else {

            echo "Error: " . $stmt->error;

        }

    }

    $stmt->close();

    $conn->close();

}

?>