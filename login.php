<?php
// login.php

require_once __DIR__ . '/includes/db.php'; // Database connection
session_start(); // Start session here

// Prevent logged-in users from accessing login page
if (isset($_SESSION['user']) || isset($_SESSION['customer'])) {
    header('Location: index.php');
    exit();
}

// Check if the database is connected
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$error = ""; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = trim($_POST['input']); // Sanitize input
    $password = $_POST['password'];

    // Check if the user is a customer (using email)
    $sql_customer = "SELECT * FROM CustomerAccount WHERE Email = ?";
    $stmt = $conn->prepare($sql_customer);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("s", $input);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            $_SESSION['customer'] = $row['CustomerName'];
            $_SESSION['customerAccountID'] = $row['CustomerAccountID'];
            header('Location: index.php');
            exit();
        } else {
            $error = "Incorrect password.";
        }
    }

    // Check if the user is an admin or employee (using username)
    $sql_employee = "SELECT * FROM Employee WHERE Username = ?";
    $stmt = $conn->prepare($sql_employee);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("s", $input);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Debugging: Log stored vs entered password
        error_log("Stored Password: " . $row['Password']);
        error_log("Entered Password: " . $password);

        if (password_verify($password, $row['Password'])) {
            $_SESSION['user'] = $row['Username'];
            $_SESSION['role'] = $row['EmpPos']; // Store role (Admin or Employee)
            $_SESSION['empID'] = $row['EmpID']; // Store employee ID

            // Redirect based on role
            if ($_SESSION['role'] == 'Admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: employee/dashboard.php');
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    }

    // If no user found
    if ($error == "") {
        $error = "Invalid email/username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Email/Username:</label><br>
        <input type="text" name="input" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
