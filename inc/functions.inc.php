<?php
// Database connection function
function dbConnect()
{
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_auth";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to handle login
function loginUser($email, $password)
{
    // Connect to the database
    $conn = dbConnect();

    // Prepare and execute the query to check if the email exists
    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If email is not found
    if ($stmt->num_rows == 0) {
        $stmt->close();
        $conn->close();
        return 'No User Found';
    }

    // Fetch the result
    $stmt->bind_result($userId, $passwordHash);
    $stmt->fetch();
    $stmt->close();

    // Verify the password
    if (password_verify($password, $passwordHash)) {
        // Password is correct
        $_SESSION['user_id'] = $userId;
        $conn->close();
        return 'success';
    } else {
        // Password is incorrect
        $conn->close();
        return 'Invalid Password';
    }
}

// Function to handle registration
function registerUser($firstName, $lastName, $email, $password, $securityWord)
{
    // Connect to the database
    $conn = dbConnect();

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If email is already taken
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return 'Email already in use';
    }

    $stmt->close();

    // Hash the password and security word
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $securityWordHash = password_hash($securityWord, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password_hash, security_word) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $passwordHash, $securityWordHash);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return 'Account created successfully';
    } else {
        $stmt->close();
        $conn->close();
        return 'Unable to create account';
    }
}

// Function to reset password
function resetPassword($email, $securityWord, $newPassword)
{
    // Connect to the database
    $conn = dbConnect();

    // Prepare and execute the query to check if the email and security word match
    $stmt = $conn->prepare("SELECT id, security_word FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If email is not found
    if ($stmt->num_rows == 0) {
        $stmt->close();
        $conn->close();
        return 'No User Found';
    }

    // Fetch the result
    $stmt->bind_result($userId, $storedSecurityWord);
    $stmt->fetch();
    $stmt->close();

    // Verify the security word
    if (password_verify($securityWord, $storedSecurityWord)) {
        // Hash the new password
        $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $newPasswordHash, $userId);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return 'Password reset successfully';
        } else {
            $stmt->close();
            $conn->close();
            return 'Unable to reset password';
        }
    } else {
        $conn->close();
        return 'Invalid Security Word';
    }
}
