<?php
if (!isset($_SESSION['log_id'])) {
    header('location:login.html');
    //$id = $_SESSION['log_id'];
} else {
    include_once('connection.php');

    $stmt = $conn->prepare('SELECT b.name, a.mark FROM student_mark_online a, login b WHERE a.id=b.log_id');
    $stmt->execute();
    $result = $stmt->get_result();
    echo'<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #3498db; /* Blue color for header */
        color: #fff; /* White text for header */
    }

    tr:nth-child(even) {
        background-color: #fff; /* White color for even rows */
    }

    tr:nth-child(odd) {
        background-color: #f2f2f2; /* Light gray color for odd rows */
    }
</style>
';
    echo '<table border="1">
            <tr>
                <th>Name</th>
                <th>Mark</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $mark = $row['mark'];
        echo "<tr>
                <td>$name</td>
                <td>$mark</td>
              </tr>";
    }

    echo '</table>';
}
?>
