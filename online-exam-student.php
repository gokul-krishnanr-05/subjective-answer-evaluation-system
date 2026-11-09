<?php
include('connection.php');
$id = $_SESSION['log_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <form action="answer_submit.php" method="post" enctype="multipart/form-data" class="upload-form">
        <input type="number" name="id" value=<?php echo $id?> hidden>
        <label for="exam_name">Exam name :</label>
        <select name="exam_name" class="select" id="exam_name">
            <option value="" selected>Select the Exam</option>

            <?php
            $sql = "SELECT  exam_name FROM online_exam_t";
            $result = $conn->query($sql);

            // Generate options dynamically
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $examName = $row['exam_name'];
                    echo "<option value='" . $examName . "'>" . $examName . "</option>";
                }
            }
            ?>
        </select>

        <label for="question">Question :</label>
        <input type="text" name="question" id="queston">

        <label for="answer">Answer :</label>
        <textarea name="answer" id="" cols="30" rows="10"></textarea>
        <br><br>
        <input type="submit" value="Submit" name="submit" class="submit-btn">
    </form>

    <script>
    // Add an event listener to the exam_name select element
    $(document).ready(function () {
        $('#exam_name').change(function () {
            // Get the selected exam name
            var examName = $(this).val();

            // Make an AJAX request to fetch the question based on the selected exam name
            $.ajax({
                type: 'POST',
                url: 'fetch_question.php', // Replace with the actual path to your server-side script
                data: { exam_name: examName },
                success: function (response) {
                    // Update the question input field with the fetched question
                    document.getElementById('queston').value = response;
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


</body>

</html>


