document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menu = document.querySelector('.menu');
    const menuRight = document.querySelector('.menu-right');

    mobileMenu.addEventListener('click', function() {
        menu.classList.toggle('active');
        menuRight.classList.toggle('active');
    });
});