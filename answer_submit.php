<?php
// Assuming you have established a database connection earlier and stored it in $conn variable
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $examName = $_POST["exam_name"];
    $question = $_POST["question"];
    $answerKey = $_POST["answer"];

    // Validate data if needed

    // Insert data into the database
    $sql = "INSERT INTO exam_questions (stud_id, exam_name, question, answer) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id, $examName, $question, $answerKey);

    if ($stmt->execute()) {
        echo "<script> alert('Data submitted successfully!');
    window.location= 'student-dash.php';
    </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
