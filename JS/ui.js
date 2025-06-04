const burger = document.querySelector('.burger_menu');
const nav = document.querySelector('.contacts_header');

burger.addEventListener('click', () =>{
    nav.classList.toggle('open');
});