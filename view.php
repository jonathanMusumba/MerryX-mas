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
    <title>Your Christmas Wish</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animations.css">
</head>
<body class="bg-dark text-light">

    <div class="container my-5 text-center">
        <div class="christmas-lights">
            <div class="christmas-light"></div>
            <div class="christmas-light"></div>
            <div class="christmas-light"></div>
            <div class="christmas-light"></div>
            <div class="christmas-light"></div>
        </div>
        
        <h1 class="text-success sparkle-text">🎄 Merry Christmas & Happy New Year 🎆</h1>
        <p class="lead text-warning">
            <?= htmlspecialchars($customMessage) ?>
        </p>
        
        <div class="floating-stars">
            <div class="floating-star"></div>
            <div class="floating-star"></div>
            <div class="floating-star"></div>
            <div class="floating-star"></div>
        </div>

        <img src="assets/images/christmas-lights.gif" alt="Christmas Lights" class="img-fluid my-4">

        <!-- Audio for Christmas vibe -->
        <audio autoplay loop>
    <source src="assets/sounds/jingle-bells-bells.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>


<div class="mt-3">
    <button class="btn btn-primary" onclick="shareOptions()">Share Your Wish</button>
</div>
    </div>

    <script>
        // Share link to clipboard
        function shareLink() {
            navigator.clipboard.writeText(window.location.href)
                .then(() => alert('Link copied to clipboard!'))
                .catch(err => alert('Failed to copy link: ' + err));
        }
        function shareOptions() {
    const wish_id = <?= $wish_id ?>; // Get the wish ID dynamically from PHP
    const message = "<?= htmlspecialchars($customMessage) ?>"; // Get the custom message dynamically from PHP
    const shareMessage = `${message} - Check it out at view.php?wish_id=${wish_id}`;
    
    const options = prompt("Choose how you want to share your wish:\n1. WhatsApp\n2. Facebook\n3. Get Link");

    if (options === '1') {
        window.open(`https://wa.me/?text=${encodeURIComponent(shareMessage)}`, '_blank');
    } else if (options === '2') {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`, '_blank');
    } else if (options === '3') {
        copyToClipboard(window.location.href);
    } else {
        alert("Invalid option.");
    }
}

// Function to copy the link to the clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => alert('Link copied to clipboard!'))
        .catch(err => alert('Failed to copy link: ' + err));
}

    </script>

</body>
</html>
