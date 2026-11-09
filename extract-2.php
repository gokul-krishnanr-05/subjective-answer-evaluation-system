<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {

    include_once('connection.php');
    // Get the selected file name from the form
    $selectedFileName = $_POST['file_name'];

    $stmt = $conn->prepare('SELECT file_id,file_location FROM answers_1 WHERE file_name=?');
    $stmt->bind_param('s', $selectedFileName);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $uploadFolder =  $row['file_location'];
    $id =  $row['file_id'];

    // Validate the file name (you may want to add additional validation)

    // Assuming your Python script is named "extract_script.py"
    $pythonScript = "extract_script.py";

    // Define the upload folder path
    

    if (file_exists($uploadFolder)) {
        // Build the command to execute the Python script with the file path
        $command = "python $pythonScript $uploadFolder";

        // Execute the command and capture the output
        $output = shell_exec($command);

        // Display the output (you may want to handle this differently, e.g., redirect to a new page)
        // echo "Extraction result: $output";
        $stmt = $conn->prepare('INSERT INTO answer_key_1 (id, text_data) VALUES (?,?)');
        $stmt->bind_param('is',$id ,$output);
        $stmt->execute();
        echo '<script>alert("Success") 
						window.location="student-dash.php"
						</script>';
    } else {
        echo "File not found: $uploadFolder";
    }
   
}
?>
