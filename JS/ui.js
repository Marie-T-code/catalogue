const burger = document.querySelector('.burger_menu');
const nav = document.querySelector('.contacts_header');

burger.addEventListener('click', () =>{
    nav.classList.toggle('open');
});

const toggleBtn = document.querySelectorAll('.toggle-theme'); 

toggleBtn.forEach(toggle => {
  toggle.addEventListener('click', () => {
    const isActive = toggle.classList.contains('active');

    toggleBtn.forEach(t => {
      t.classList.remove('active', 'reverse');
    });

    if (isActive) {
      toggleBtn.forEach(t => t.classList.add('reverse'));
      document.body.classList.remove('darkMode');
      document.dispatchEvent(new CustomEvent('themeChanged', { detail: { mode: 'light' } }));
    } else {
      toggleBtn.forEach(t => t.classList.add('active'));
      document.body.classList.add('darkMode');
      document.dispatchEvent(new CustomEvent('themeChanged', { detail: { mode: 'dark' } }));
    }
  });
});