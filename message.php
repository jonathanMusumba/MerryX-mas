<?php
include 'db.php';

$wish_id = $_GET['wish_id'] ?? null;

// If no wish ID is provided, redirect to index.php
if (!$wish_id) {
    header("Location: index.php");
    exit;
}

// Fetch the wish from the database
$stmt = $conn->prepare("SELECT * FROM wishes WHERE id = ?");
$stmt->bind_param("i", $wish_id);
$stmt->execute();
$result = $stmt->get_result();
$wish = $result->fetch_assoc();
$stmt->close();

// If no wish found, redirect to index.php
if (!$wish) {
    header("Location: index.php");
    exit;
}

// If no custom message is provided, fallback to the default message
$customMessage = $wish['custom_message'] ?? "{$wish['sender_name']} wishes you a Merry Christmas and Happy New Year " . ($wish['year'] ?? date('Y')) . "!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Christmas Message</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2e3b4e;
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .btn-create {
            background-color: #007bff;
            color: white;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <div class="container my-5 text-center">
        <h1 class="text-success">🎄 Merry Christmas & Happy New Year 🎆</h1>
        <p class="lead text-warning"><?= htmlspecialchars($customMessage) ?></p>

        <div class="mt-5">
            <h3>Want to create your own Christmas message?</h3>
            <a href="index.php" class="btn btn-create">Create My Own Message</a>
        </div>
    </div>

</body>
</html>
