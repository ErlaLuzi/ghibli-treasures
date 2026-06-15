<?php
// Random quote + intro image setup
$quotes = [
    ["text" => "Life is suffering. It is hard. The world is cursed. But still, you find reasons to keep living.", "author" => "Ashitaka, Princess Mononoke"],
    ["text" => "Always believe in yourself. Do this and no matter where you are, you will have nothing to fear.", "author" => "The Cat Returns"],
    ["text" => "They say the best blaze burns brightest when circumstances are at their worst.", "author" => "Howl, Howl’s Moving Castle"],
    ["text" => "You cannot alter your fate. However, you can rise to meet it.", "author" => "Princess Mononoke"],
    ["text" => "Once you do something, you never forget. Even if you can’t remember.", "author" => "Zeniba, Spirited Away"]
];

$introImages = [
    "images/hometotoro.png",
    "images/emotion.jpg",
    "images/flying.jpg"
];

$randomQuote = $quotes[array_rand($quotes)];
$randomImage = $introImages[array_rand($introImages)];
?>

<?php include 'includes/header.php'; ?>


<video autoplay muted loop id="bg-video">
    <source src="videos/homeback.mp4" type="video/mp4">
</video>
<div class="video-overlay"></div>

<main>
  <?php if (!empty($_SESSION['error'])): ?>
      <div class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></div>
      <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

    <!-- INTRO -->
    <section class="intro scroll-fade">
        <h1 class="main-welcome">Welcome to Ghibli Treasures</h1>
        <p>Studio Ghibli is a world-renowned Japanese animation studio known for its whimsical, deeply emotional, and visually stunning films.
            Founded in 1985, it has brought to life masterpieces like <em>Spirited Away</em>, <em>My Neighbor Totoro</em>, and <em>Princess Mononoke</em>.
        </p>
        <img src="<?= $randomImage ?>" alt="Ghibli Intro Image" class="section-banner">

        <h2>Our Story</h2>
        <p>Ghibli Treasures was founded by a small group of animation fans who wanted to share their love for Studio Ghibli’s timeless films.
        What started as a passion project quickly grew into a curated collection of high-quality merchandise inspired by the worlds and characters we admire.
        From handcrafted plushies to exclusive apparel, our goal is to bring a little Ghibli magic into your everyday life.</p>
    </section>

    <!-- QUOTES -->
    <section class="ghibli-quotes scroll-fade">
        <blockquote>“<?= $randomQuote['text'] ?>”</blockquote>
        <cite>— <?= $randomQuote['author'] ?></cite>
    </section>

    <!-- ABOUT MIYAZAKI -->
    <section class="miyazaki scroll-fade">
        <img src="images/miyazaki.jpg" alt="Hayao Miyazaki" class="section-banner">
        <h2>About Hayao Miyazaki</h2>
        <p>Hayao Miyazaki is the visionary co-founder of Studio Ghibli, widely regarded as one of the most influential animation directors in history. His films are renowned for their deep emotional themes, environmental messages, and unforgettable worlds.</p>
        <p>Known for titles like <em>Spirited Away</em>, <em>Howl’s Moving Castle</em>, and <em>Nausicaä of the Valley of the Wind</em>, Miyazaki’s work transcends age and culture. He has a rare ability to blend fantasy with social commentary, and his attention to detail creates stories that are both magical and profoundly human.</p>
        <p>To this day, Miyazaki continues to inspire fans around the world with his creativity, wisdom, and unwavering dedication to storytelling through hand-drawn animation.</p>

        <a href="https://en.wikipedia.org/wiki/Hayao_Miyazaki" target="_blank" class="read-more-link">Learn more about Hayao Miyazaki →</a>
    </section>

    <!-- WHAT MAKES GHIBLI SPECIAL -->
    <section class="ghibli-special scroll-fade">
        <h2>What Makes Ghibli Special</h2>
        <div class="ghibli-grid">
            <div class="feature-item">
                <p>🌱</p>
                <h4>Nature</h4>
                <p>Forests, spirits, and mountains that feel alive.</p>
            </div>
            <div class="feature-item">
                <p>🐉</p>
                <h4>Flight</h4>
                <p>Airships, witches on brooms, and sky-bound wonder.</p>
            </div>
            <div class="feature-item">
                <p>🎏</p>
                <h4>Emotion</h4>
                <p>Stories that leave a lasting emotional impact.</p>
            </div>
        </div>
    </section>

    <!-- FEATURED MERCH -->
    <section class="featured-products scroll-fade">
        <h2>Featured Ghibli Merch</h2>
        <div class="product-grid">
            <div class="product-card">
                <img src="productimages/totoroplush.png" alt="Totoro Plush">
                <h4>Totoro Plush</h4>
                <p>$24.99</p>
            </div>
            <div class="product-card">
                <img src="productimages/kikinotebook.png" alt="Kiki Notebook">
                <h4>Kiki Notebook</h4>
                <p>$18.99</p>
            </div>
            <div class="product-card">
                <img src="productimages/poster1sa.png" alt="Spirited Away Poster">
                <h4>Spirited Away Poster</h4>
                <p>$12.00</p>
            </div>
        </div>

        <div class="see-more-container">
            <a href="shop.php" class="see-more-btn">Click to See More</a>
        </div>
    </section>

</main>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>


<?php include 'includes/footer.php'; ?>
