<?php
include 'inc/nav.inc.php';
include 'inc/functions.inc.php';
session_start();

// Initialize an error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve email and password from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the login function
    $result = loginUser($email, $password);

    if ($result === 'success') {
        // Login successful, redirect to the home page or dashboard
        header('Location: index.php');
        exit();
    } else {
        // Login failed, set error message
        $error_message = htmlspecialchars($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h2 class="text-center mb-4">Login</h2>
                <?php
                if ($error_message) {
                    echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                }
                ?>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="reset_password.php" class="btn btn-link">Forgot Password?</a>
                </form>
                <p class="mt-3 text-center">
                    Don't have an account? <a href="register.php">Register here</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('mousedown', function() {
            document.getElementById('password').type = 'text';
            this.textContent = 'Hide';
        });
        document.getElementById('togglePassword').addEventListener('mouseup', function() {
            document.getElementById('password').type = 'password';
            this.textContent = 'Show';
        });
    </script>
</body>

</html>