let Clickdrop = document.querySelector('#user-popup-dropdown');
let drop = document.querySelector('.user-box-popup');
let a = 0;

Clickdrop.addEventListener('click', () => {
    if (a === 0) {
        drop.style.transform = 'scaleY(1)';
        drop.style.opacity = 1;
        a = 1;
    } else {
        drop.style.transform = 'scaleY(0)';
        a = 0;
    }

});