</main>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-column">
            <h4>Contact Us</h4>
            <p>Email: <a href="mailto:info@ghiblitreasures.com">info@ghiblitreasures.com</a></p>
            <p>Phone: 068 XXX XXXX</p>
        </div>
        <div class="footer-column">
            <h4>Find Us</h4>
            <p>Check out the museum!</p>
            <p>Tokyo, Japan</p>
            <p><a href="https://www.google.com/maps/place/Ghibli+Museum/" target="_blank">View on Map</a></p>
        </div>
        <div class="footer-column">
            <h4>Follow Us</h4>
            <p><a href="https://instagram.com/ghiblitreasures" target="_blank">Instagram</a></p>
            <p><a href="https://facebook.com/ghiblitreasures" target="_blank">Facebook</a></p>
        </div>
        <div class="footer-column">
            <h4>Feedback</h4>
            <p><a href="mailto:feedback@ghiblitreasures.com">Send Feedback</a></p>
            <p><a href="contact.php">Contact Form</a></p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date("Y") ?> Ghibli Treasures. All rights reserved.</p>
    </div>
</footer>

<script>
    // Fade-in animation for scroll-fade elements
    const faders = document.querySelectorAll('.scroll-fade');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.2 });
    faders.forEach(el => observer.observe(el));
</script>

</body>
</html>
