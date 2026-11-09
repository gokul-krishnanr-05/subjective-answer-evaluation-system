<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Retrieve the plaintext password and user type from the database for the given username
    $stmt = $conn->prepare('SELECT password, log_id, type FROM login WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $plaintext_password = $row['password'];
        $id = $row['log_id'];
        $type = $row['type'];
        
        // Verify the password
        if ($password === $plaintext_password) {
            $_SESSION['log_id'] = $id;

            // Redirect based on user type
            switch ($type) {
                case 1:
                    header('Location:teacher-dash.php');
                    exit;
                case 2:
                    header('Location:student-dash.php');
                    exit;
                default:
                    echo "<script>alert('Login successful!');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password1');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password2');</script>";
    }
}
?>