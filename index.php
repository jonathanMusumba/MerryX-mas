<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>Christmas Messages, Offers & Designs | Musumba Jonathan</title>
    <meta name="description" content="Explore a wide variety of Christmas messages, offers, custom designs, Christmas graphics, birthday wishes, and much more. Spread joy with personalized messages and festive greetings this season.">
    <meta name="keywords" content="Christmas messages, offers, Xmas graphics, Christmas designs, birthday wishes, Musumba Jonathan, festive greetings, seasonal offers, holiday graphics">
    <meta name="author" content="Musumba Jonathan">
    
    <!-- Open Graph Meta Tags for Social Media Sharing -->
    <meta property="og:title" content="Christmas Messages, Offers & Designs | Musumba Jonathan">
    <meta property="og:description" content="Explore a wide variety of Christmas messages, offers, custom designs, and holiday graphics. Create memorable moments with personalized wishes and festive greetings.">
    <meta property="og:image" content="path_to_image.jpg"> <!-- Update with an actual image URL -->
    <meta property="og:url" content="https://www.facebook.com/photo/?fbid=4446796405545530&set=a.1388393884719146">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Christmas Messages, Offers & Designs | Musumba Jonathan">
    <meta name="twitter:description" content="Explore a wide variety of Christmas messages, offers, custom designs, and holiday graphics. Create memorable moments with personalized wishes and festive greetings.">
    <meta name="twitter:image" content="assets/images/card.jpg"> <!-- Update with an actual image URL -->
    
    <!-- Charset and Favicon -->
    <link rel="icon" href="assets/favicon.ico">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    
    <!-- Font Awesome Icons -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/snowstorm/1.52/snowstorm-min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <!-- Custom CSS for Animations -->
    <link rel="stylesheet" href="assets/css/animate.css">  <!-- Custom Animations CSS -->

    <!-- Content Security Policy (CSP) -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; style-src 'self' https://cdnjs.cloudflare.com; img-src 'self' data:; font-src 'self'; connect-src 'self'; object-src 'none'; frame-ancestors 'none';">

    <!-- HTTP Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains; preload">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
</head>


    <link rel="stylesheet" href="assets/css/animate.css">  <!-- Custom Animations CSS -->
</head>
<body class="bg-light">
    <div class="container my-5 text-center">
        <!-- Christmas Tree Animation -->
        <!-- Title Section -->
        <h1 class="text-success animated bounceInDown">🎄 Create Your Christmas Wish 🎅</h1>
        <p class="lead text-info animated fadeInUp delay-1s">Send a Merry Christmas and Happy New Year wish with a personal touch!</p>
        <p class="glowing">🎅 Merry Christmas and Happy New Year! 🎄</p>


        <!-- Wish Form -->
        <form id="wish-form" action="generate.php" method="POST" class="animated fadeInUp delay-2s">
            <div class="mb-3">
                <label for="sender_name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="sender_name" name="sender_name" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Generate Your Wish</button>
        </form>

        <div id="result" class="mt-4">
            <!-- The result will be displayed here after form submission -->
        </div>

        <!-- Advertisement Section with Dynamic Offers -->
        <div class="mt-5 animated fadeIn delay-3s">
            <h2>🎁 Seasonal Offers</h2>
            <p class="lead">Check out our amazing Christmas offers on products and services! Don't miss out!</p>
            <?php 
           // Fetch the latest offers from the database
$sql = "SELECT * FROM offers ORDER BY created_at DESC LIMIT 3"; // Fetch the most recent 3 offers
$result = $conn->query($sql);

if ($result->num_rows > 0): ?>
    <div class="row">
        <?php while ($offer = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-3 animated fadeIn">
                <div class="card">
                    <?php if (!empty($offer['image_url']) && file_exists($offer['image_url'])): ?>
                        <img src="<?= htmlspecialchars($offer['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($offer['product_name']) ?>">
                    <?php else: ?>
                        <!-- Font Awesome icon fallback if no image is available -->
                        <div class="card-img-top d-flex justify-content-center align-items-center" style="height: 200px; background-color: #f0f0f0;">
                            <i class="fas fa-gift fa-3x text-warning"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($offer['product_name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($offer['description']) ?></p>
                        <p class="card-text"><strong>UGX.<?= number_format($offer['price']) ?></strong></p>
                        <a href="#" class="btn btn-warning">Buy Now</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No offers available at the moment. Stay tuned!</p>
<?php endif; ?>
        
    </div>

</body>
</html>
