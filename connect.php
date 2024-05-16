<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Collect form data
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "database123";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if (isset($_POST['save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $satisfaction = $_POST['satisfaction'];

    // Insert data into database
    $sql_query = "INSERT INTO entry_details (firstname, lastname, email, rate) 
                  VALUES ('$firstname', '$lastname', '$email', '$satisfaction')";

    if (mysqli_query($conn, $sql_query)) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Return success response for AJAX requests
            echo json_encode(array('success' => true));
        } else {
            // Redirect back to the HTML page for regular form submissions
            header('Location: index.html');
            exit();
        }
    } else {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Return error response for AJAX requests
            echo json_encode(array('success' => false, 'error' => mysqli_error($conn)));
        } else {
            // Redirect back to the HTML page with an error message for regular form submissions
            header('Location: index.html?error=' . urlencode('Error submitting feedback'));
            exit();
        }
    }
}

// Close connection
mysqli_close($conn);
?>
