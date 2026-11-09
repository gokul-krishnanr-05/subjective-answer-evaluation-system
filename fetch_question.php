<?php

include('connection.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected exam name from the AJAX request
    $examName = $_POST['exam_name'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT question FROM online_exam_t WHERE exam_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $examName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the question
        $row = $result->fetch_assoc();
        $question = $row['question'];

        // Return the question as the response
        echo $question;
    } else {
        // If no question is found, you can return an appropriate message or handle it as per your requirement
        echo 'Question not found';
    }

    // Close the statement
    $stmt->close();
}

?>
