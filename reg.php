<?php
include_once('base.php');

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// If the request method is GET and the method parameter is 'reg', it means the user is trying to register
if ($method == 'POST' && isset($_POST['method']) && $_POST['method'] == 'reg') {
    // Get the user's ID from the request query string
    $id = $_GET['id'];
    $reg = 1;

    // Check if the user already exists in the database
    $stmt = $db->prepare("SELECT COUNT(*) FROM user WHERE user = :user");
    $stmt->bindParam(':user', $id);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // If the user already exists, return an error message
    if ($count > 0) {
        echo json_encode(array("data" => array("user" => "No")));
        exit;
    }

    // Create a new user in the database
    $stmt = $db->prepare("INSERT INTO user (user, reg) VALUES (:user, :reg)");
    $stmt->bindParam(':user', $id);
    $stmt->bindParam(':reg', $reg);
    $stmt->execute();

    // Return a success message
    echo json_encode(array("data" => array("user" => "Yes")));
}

// If the request method is GET and the method parameter is 'update', it means the user is trying to update their record
if ($method == 'POST' && isset($_POST['method']) && $_POST['method'] == 'update') {
    // Get the user's ID and reg from the request query string
    $id = $_GET['id'];
    $reg = 0;

    // Update the user's reg in the database
    $stmt = $db->prepare("UPDATE user SET reg = :reg WHERE user = :user");
    $stmt->bindParam(':reg', $reg);
    $stmt->bindParam(':user', $id);
    $stmt->execute();

    // Return a success message
    echo json_encode(array("data" => array("user" =>  "Update")));
}

// If the request method is GET and the method parameter is 'update', it means the user is trying to update their record
if ($method == 'POST' && isset($_POST['method']) && $_POST['method'] == 'user') {
// Get the user's ID from the request query string
    $id = $_POST['id'];

    // Get the user's reg from the database
    $stmt = $db->prepare("SELECT reg FROM user WHERE user = :user");
    $stmt->bindParam(':user', $id);
    $stmt->execute();
    $reg = $stmt->fetchColumn();

    // Return the user's reg as JSON
    echo json_encode(array("data" => array("reg" => $reg)));
}
?>