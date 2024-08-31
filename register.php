<?php include 'inc/nav.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h2 class="text-center mb-4">Register</h2>
                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                }
                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['success']) . '</div>';
                }
                ?>
                <form action="register_action.php" method="post">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_email" class="form-label">Confirm Email</label>
                        <input type="email" class="form-control" id="confirm_email" name="confirm_email" required>
                        <div id="emailError" class="form-text text-danger">Emails do not match</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="security_word" class="form-label">Security Word</label>
                        <input type="text" class="form-control" id="security_word" name="security_word" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <p class="mt-3 text-center">
                    Already have an account? <a href="login.php">Login here</a>
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

        // Confirm email match
        document.getElementById('confirm_email').addEventListener('input', function() {
            const email = document.getElementById('email').value;
            const confirmEmail = this.value;
            const emailError = document.getElementById('emailError');
            if (email !== confirmEmail) {
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
        });
    </script>
</body>

</html>