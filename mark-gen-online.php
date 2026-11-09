<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {

    include_once('connection.php');

    // Get the selected file name from the form
    $selectedExamName = $_POST['exam_name'];
    $outofmark = $_POST['mark'];

   
    $stmt = $conn->prepare('SELECT answer_key FROM online_exam_t WHERE exam_name=?');
    $stmt->bind_param('s', $selectedExamName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $text1 = $row['answer_key'];
        // echo $text1;

        // Fetch text data from answer_key_1
        $stmt = $conn->prepare('SELECT stud_id, answer FROM exam_questions');
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['stud_id'];
                $text2 = $row['answer'];
                // echo $text2;

                // Remove line breaks from text
                $text1 = str_replace(["\r", "\n"], "", $text1);
                $text2 = str_replace(["\r", "\n"], "", $text2);

                // Assuming your Python script is named "content_similarity.py"
                $pythonScript = "python content_similarity.py \"$text1\" \"$text2\"";

                // Execute the command and capture the output
                $output = shell_exec($pythonScript);

                if (!empty($output)) {
                    // Check if the ID is not already present in student_mark
                    $checkStmt = $conn->prepare('SELECT id FROM student_mark_online WHERE id = ?');
                    $checkStmt->bind_param('i', $id);
                    $checkStmt->execute();
                    $checkResult = $checkStmt->get_result();

                    if ($checkResult->num_rows == 0) {
                        // Insert into student_mark only if ID is not present
                        $mark = $output * $outofmark / 100;
                        $insertStmt = $conn->prepare('INSERT INTO student_mark_online (id, mark) VALUES (?, ?)');
                        $insertStmt->bind_param('id', $id, $mark);
                        $insertStmt->execute();
                        echo "<script> alert('Mark Generated!');
    window.location= 'teacher-dash.php';
    </script>";
                    } //else {
                    //     echo "ID: $id already present in student_mark" . PHP_EOL;
                    // }

                    // Close the check statement
                    $checkStmt->close();
                } else {
                    echo "Error: Empty output for ID $id" . PHP_EOL;
                }
            }
        } else {
            echo "Error: No data found in answer_key_1";
        }

        // Close the main statement
        $stmt->close();

    } else {
        echo "Error: No data found for selected file name";
    }
}
?>