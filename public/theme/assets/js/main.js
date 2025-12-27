//scroll header
const header = document.querySelector('#header');

function myScroll() {
    if (window.scrollY > header.offsetHeight + 150) {
        header.classList.add('header_sticky')
    } else {
        header.classList.remove('header_sticky')
    }
}

window.addEventListener('scroll', myScroll);




//mobile menu active
const mobileMenuActive = document.querySelector('.mobile-menu-wrap');
const mainMenu = document.querySelector('.menu-elements');
const mobileMenuClose = document.querySelector('.menu-close-btn');
mobileMenuActive.addEventListener('click', menuactive);
mobileMenuClose.addEventListener('click', menuClose);

function menuClose() {
    mainMenu.classList.remove('acitve');
}

function menuactive() {
    mainMenu.classList.add('acitve');
};