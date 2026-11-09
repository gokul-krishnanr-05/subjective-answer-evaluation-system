<?php
session_start();
if (!isset($_SESSION['log_id'])) {
    header('location:login.html');
    //$id = $_SESSION['log_id'];

} else {
    $id = $_SESSION['log_id'];

    include('connection.php');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the "answers" table
    $sql = "SELECT file_id, file_name FROM answers_1 WHERE file_id ='$id'";
    $result = $conn->query($sql);

    // Close the database connection
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dash-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Student-Dashboard</title>
    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class='dashboard'>
        <div class="dashboard-nav">
            <header>
                <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
                <a href="#" class="brand-logo"><i class="fa-solid fa-graduation-cap"></i><span>SAE.com</span></a>
            </header>
            <nav class="dashboard-nav-list">
                <a href="#home" class="dashboard-nav-item"><i class="fas fa-home"></i>Home </a>
                <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-photo-video"></i>Evaluation</a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="#upload" class="dashboard-nav-dropdown-item">Upload Answer</a>
                        <a href="#extract" class="dashboard-nav-dropdown-item">Text-Extraction</a>
                        <a href="#online" class="dashboard-nav-dropdown-item">Online-Exam</a>
                    </div>
                </div>
                <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-photo-video"></i>Exam</a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="#mark" class="dashboard-nav-dropdown-item">View Marks</a>
                        <a href="#mark_on" class="dashboard-nav-dropdown-item">View Online Marks</a>
                        <a href="#" class="dashboard-nav-dropdown-item">View feedbacks</a>
                    </div>
                </div>
                <!-- <div class='dashboard-nav-dropdown'>
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                        <i class="fas fa-photo-video"></i>Study-Metrials</a>
                    <div class='dashboard-nav-dropdown-menu'>
                        <a href="#Meterials" class="dashboard-nav-dropdown-item">Add Metrials</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Update Metrials</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Delete Metrials</a>
                    </div>
                </div> -->
                <div class="nav-item-divider"></div>
                <a href="logout.php" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout </a>
            </nav>
        </div>
        <div class='dashboard-app'>
            <header class='dashboard-toolbar'><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a></header>
            <div class='dashboard-content'>
                <div class='container' id="#home">
                    <div class='card'>
                        <div class='card-header'>
                            <h1>Welcome

                            </h1>
                        </div>
                        <div class='card-body'>
                            <p>Your Account types is: Student</p>
                        </div>
                    </div>
                </div>

                <div class='container' id="#upload">
                    <form action="add-answer-2.php" method="post" enctype="multipart/form-data" class="upload-form">
                        <label for="file">Select file to upload:</label>
                        <input type="file" name="file" id="file">
                        <label for="file_name">File name :</label>
                        <input type="text" name="file_name" id="file_name">
                        <br><br>
                        <input type="submit" value="Upload file" name="submit" class="submit-btn">
                    </form>
                </div>
                <div class='container' id="#extract">
                    <form action="extract-2.php" method="post" enctype="multipart/form-data" class="upload-form">
                        <!-- <label for="file">Select file to upload:</label>
                        <input type="file" name="file" id="file">
                        <label for="file_name">File name :</label>
                        <input type="text" name="file_name" id="file_name"> -->
                        <select name="file_name" class="select">
                            <option value="" selected>Select the Answer</option>

                            <?php
                            // Generate options dynamically
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["file_name"] . "'>" . $row["file_name"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <input type="submit" value="Extract" name="submit" class="submit-btn">
                    </form>
                </div>
                <div class='container' id="#online">
                    <?php include("online-exam-student.php");?>
                </div>
                <div class='container' id="#mark">
                    <?php include("view-marks.php");?>
                </div>
                <div class='container' id="#mark_on">
                    <?php include("view-marks-online.php");?>
                </div>
                

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const mobileScreen = window.matchMedia("(max-width: 990px )");
        $(document).ready(function () {
            $(".dashboard-nav-dropdown-toggle").click(function () {
                $(this).closest(".dashboard-nav-dropdown")
                    .toggleClass("show")
                    .find(".dashboard-nav-dropdown")
                    .removeClass("show");
                $(this).parent()
                    .siblings()
                    .removeClass("show");
            });
            $(".menu-toggle").click(function () {
                if (mobileScreen.matches) {
                    $(".dashboard-nav").toggleClass("mobile-show");
                } else {
                    $(".dashboard").toggleClass("dashboard-compact");
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Get all anchor tags within dashboard-nav-list
            const dashboardNavAnchors = document.querySelectorAll('.dashboard-nav-list a');

            // Get all containers within dashboard-content
            const dashboardContentContainers = document.querySelectorAll('.dashboard-content .container');

            // Function to show the 'home' page when the page loads
            function showHomePage() {
                dashboardContentContainers.forEach(container => {
                    if (container.id === '#home') {
                        container.style.display = 'block'; // Show the 'home' container
                    } else {
                        container.style.display = 'none'; // Hide other containers
                    }
                });
            }

            // Show the 'home' page when the page loads
            showHomePage();

            // Loop through all anchor tags
            dashboardNavAnchors.forEach(anchor => {
                anchor.addEventListener('click', function (event) {
                    const href = this.getAttribute('href');

                    // Check if the link belongs to the dashboard navigation
                    if (href.startsWith('#')) {
                        event.preventDefault(); // Prevent default link behavior

                        // Get the target container ID from the href attribute
                        const targetContainerId = href;

                        // Loop through containers to show/hide based on clicked anchor
                        dashboardContentContainers.forEach(container => {
                            if (container.id === targetContainerId) {
                                container.style.display = 'block'; // Show the target container
                            } else {
                                container.style.display = 'none'; // Hide other containers
                            }
                        });
                    }
                });
            });
        });

    </script>
</body>

</html>