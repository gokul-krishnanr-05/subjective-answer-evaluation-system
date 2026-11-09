<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    
    // Include the connection file
    include_once('connection.php');

    // Get form data
    $type = $_POST['type'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo $email;
    echo $password; // Assuming you don't want to hash the password
    echo $type;
    echo $name;

    // Validate form data (you may want to add more validation)
    if (empty($type) || empty($name) || empty($email) || empty($password)) {
        echo "All fields are required.";
        // You may want to redirect or handle the error differently
    } else {
        // Insert data into the "login" table
        $stmt = $conn->prepare('INSERT INTO login (type, name, email, password) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('isss', $type, $name, $email, $password);

        if ($stmt->execute()) {
            // echo "Registration successful!";
            echo '<script>alert("Registration successful!") 
                    window.location="login.html"
                    </script>';
            // You may want to redirect to a login page or handle success differently
        } else {
            echo '<script>alert("Error: Registration failed.") 
                    window.location="login.html"
                    </script>';
            // echo "Error: Registration failed.";
            // You may want to redirect or handle the error differently
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>
