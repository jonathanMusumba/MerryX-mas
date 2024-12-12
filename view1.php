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
    <link rel="stylesheet" href="assets/css/animatation.css">
    <style>
        /* Custom styles for the page */
        body {
            background-color: #2e3b4e;
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .sparkle-text {
            animation: sparkle 2s infinite alternate;
        }

        @keyframes sparkle {
            0% { text-shadow: 0 0 5px #fff, 0 0 10px #ff0000; }
            100% { text-shadow: 0 0 20px #ff0000, 0 0 30px #ff00ff; }
        }

        .btn-social {
            padding: 10px 20px;
            margin: 10px;
            border-radius: 50px;
            font-size: 18px;
            text-align: center;
        }

        .btn-whatsapp {
            background-color: #25D366;
            color: white;
        }

        .btn-facebook {
            background-color: #4267B2;
            color: white;
        }

        .btn-link {
            background-color: #FFC107;
            color: white;
        }

        .christmas-lights div {
            display: inline-block;
            background-color: #ff0;
            width: 15px;
            height: 15px;
            margin: 3px;
            border-radius: 50%;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            50% { background-color: #ff4500; }
        }
    </style>
</head>
<body>

    <div class="container my-5 text-center">
        <div class="christmas-lights">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
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

        <!-- Social media and link sharing -->
        <div class="mt-4">
            <button class="btn btn-whatsapp" onclick="shareOnWhatsApp()">Share on WhatsApp</button>
            <button class="btn btn-facebook" onclick="shareOnFacebook()">Share on Facebook</button>
            <button class="btn btn-link" onclick="copyToClipboard(window.location.href)">Copy Link</button>
        </div>
    </div>

    <script>
        function shareOnWhatsApp() {
            const wish_id = <?= $wish_id ?>;
            const message = "<?= htmlspecialchars($customMessage) ?>";
            const shareMessage = `${message} - Check it out at message.php?wish_id=${wish_id}`;
            window.open(`https://wa.me/?text=${encodeURIComponent(shareMessage)}`, '_blank');
        }

        function shareOnFacebook() {
            const url = `message.php?wish_id=<?= $wish_id ?>`;  // Directly link to message.php with the wish_id
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => alert('Link copied to clipboard!'))
                .catch(err => alert('Failed to copy link: ' + err));
        }
    </script>

</body>
</html>
