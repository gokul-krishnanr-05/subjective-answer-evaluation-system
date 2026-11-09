<?php
 include('connection.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data with mysqli_real_escape_string for basic input validation
    $examName = mysqli_real_escape_string($conn, $_POST['file_name']);
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answerKey = mysqli_real_escape_string($conn, $_POST['answerkey']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO online_exam_t (exam_name, question, answer_key) VALUES (?, ?, ?)");
    $stmt->bind_param("ssss", $examName, $question, $answerKey);

    if ($stmt->execute()) {
        echo "<script> alert('Data submitted successfully!');
    window.location= 'teacher-dash.php';
    </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data" class="upload-form">
        <label for="file_name">Exam name :</label>
        <input type="text" name="file_name" id="file_name">
        <label for="question">Question :</label>
        <input type="text" name="question" id="file_name">
        <label for="answerkey">Answerkey :</label>
        <textarea name="answerkey" id="" cols="30" rows="10"></textarea>
        <br><br>
        <input type="submit" value="Submit" name="submit" class="submit-btn">
    </form>
</body>

</html>