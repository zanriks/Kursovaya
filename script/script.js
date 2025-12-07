const burger = document.querySelector('.burger-menu');
const mobileMenu = document.getElementById('mobileMenu');
const overlay = document.getElementById('menuOverlay');

function toggleMenu() {
    mobileMenu.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
}

burger.addEventListener('click', toggleMenu);
overlay.addEventListener('click', toggleMenu);

document.querySelectorAll('.mobile-menu__link').forEach(link => {
    link.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    });
});