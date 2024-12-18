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

// Get the current domain dynamically
$domain = ($_SERVER['HTTPS'] ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}";
$messageUrl = $domain . "/message.php?wish_id=" . $wish_id;
$encodedMessage = urlencode($customMessage); // URL encode the message for sharing
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Christmas Wish</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animations.css">
    <style>
        body {
            background-color: #2e3b4e;
            color: white;
            font-family: 'Arial', sans-serif;
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
    </style>
</head>
<body>

    <div class="container my-5 text-center">
        <h1 class="text-success sparkle-text">🎄 Merry Christmas & Happy New Year 🎆</h1>
        <p class="lead text-warning">
            <?= htmlspecialchars($customMessage) ?>
        </p>

        <!-- Display the clickable dynamic link -->
        <div class="mt-4">
            <p>Share your wish with the following link:</p>
            <a href="<?= $messageUrl ?>" target="_blank" class="btn btn-link"><?= $messageUrl ?></a>
        </div>

        <!-- Share buttons section -->
        <div class="mt-4">
            <button class="btn btn-whatsapp" onclick="shareOnWhatsApp()">Share on WhatsApp</button>
            <button class="btn btn-facebook" onclick="shareOnFacebook()">Share on Facebook</button>
            <button class="btn btn-link" onclick="copyToClipboard('<?= $messageUrl ?>')">Copy Link</button>
        </div>
    </div>

    <script>
        // Share on WhatsApp
        function shareOnWhatsApp() {
            const message = "<?= $encodedMessage ?>";
            const wish_id = <?= $wish_id ?>;
            const shareMessage = `${message} - Check it out at ${window.location.origin}/message.php?wish_id=${wish_id}`;
            window.open(`https://wa.me/?text=${encodeURIComponent(shareMessage)}`, '_blank');
        }

        // Share on Facebook
        function shareOnFacebook() {
            const shareLink = '<?= $messageUrl ?>';
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareLink)}`, '_blank');
        }

        // Copy to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => alert('Link copied to clipboard!'))
                .catch(err => alert('Failed to copy link: ' + err));
        }
    </script>

</body>
</html>
