<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the form data is available and valid
    if (isset($_POST['sender_name']) && !empty($_POST['sender_name'])) {
        $sender_name = htmlspecialchars($_POST['sender_name']); // Sanitize input
        $year = date("Y") + 1; // 1 year ahead

        // Default message
        $default_message = "$sender_name wishes you and your family a Merry Christmas and a Happy New Year $year! May this festive season bring you peace, joy, and countless blessings. Here's to a wonderful year ahead, filled with love, laughter, and beautiful moments together.";

        // Prepare and execute the insert query
        $stmt = $conn->prepare("INSERT INTO wishes (sender_name, custom_message, year, created_at) VALUES (?, ?, ?, NOW())");
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }

        $stmt->bind_param("ssi", $sender_name, $default_message, $year);
        $execute_result = $stmt->execute();
        if (!$execute_result) {
            echo "Error executing query: " . $stmt->error;
            exit;
        }

        // Get the inserted wish's ID
        $wish_id = $stmt->insert_id;
        $stmt->close();

        // Redirect to view.php with the generated wish_id
        header("Location: view.php?wish_id=$wish_id");
        exit;
    } else {
        echo "<p>Please provide a sender name.</p>";
    }
}
?>
