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



//cursor
const cursorElement = document.querySelector('.cursor');
window.addEventListener('mousemove', cursor);

function cursor(e) {
  cursorElement.style.top = e.pageY + 'px';
  cursorElement.style.left = e.pageX + 'px';

}

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
