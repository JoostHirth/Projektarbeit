document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const registerBtn = document.getElementById('registerBtn');
    const loginBtn = document.getElementById('loginBtn');
    const gastBtn = document.querySelector('.gast-form .btn'); // Gast-Button auswählen

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });

    gastBtn.addEventListener('click', () => {
        <a href="hauptseite.php">Spiel starten</a>
    });
});
