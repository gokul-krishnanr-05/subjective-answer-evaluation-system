<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {

    include_once('connection.php');
    // Get the selected file name from the form
    $selectedFileName = $_POST['file_name'];

    $stmt = $conn->prepare('SELECT file_location FROM answers WHERE file_name=?');
    $stmt->bind_param('s', $selectedFileName);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $uploadFolder = $row['file_location'];

    // Validate the file name (you may want to add additional validation)

    // Assuming your Python script is named "extract_script.py"
    $pythonScript = "extract_script.py";

    // Define the upload folder path

    if (file_exists($uploadFolder)) {
        // Build the command to execute the Python script with the file path
        $command = "python $pythonScript $uploadFolder";

        // Execute the command and capture the output
        exec($command, $outputArray);

        // Check if $outputArray is not empty before inserting into the database
        if (!empty($outputArray)) {
            // $outputArray should contain the printed output of the Python script
            $output = implode("\n", $outputArray);

            $stmt = $conn->prepare('INSERT INTO answer_key (file_location, text_data,file_name) VALUES (?, ?,?)');
            $stmt->bind_param('sss', $uploadFolder, $output,$selectedFileName);
            $stmt->execute();
            echo '<script>alert("Success") 
                    window.location="teacher-dash.php"
                    </script>';
        } else {
            echo "Error: Extraction output is empty.";
        }
    } else {
        echo "File not found: $uploadFolder";
    }
}
?>
