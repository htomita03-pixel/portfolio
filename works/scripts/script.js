'use strict';
//画像がゆるゆる移動し、マウスが乗ると止まって大きくなる（CSSとの組み合わせ
document.addEventListener('DOMContentLoaded', function () {
const images = document.querySelectorAll('.worksAtendImg img');
const worksAtendImg = document.querySelectorAll('.worksAtendImg');

images.forEach(img => {
    img.addEventListener('mouseenter',() => {
     worksAtendImg.forEach(worksAtendImg => {
    worksAtendImg.classList.add('worksAtendIn_Stop');
     });   
    });

    img.addEventListener('mouseleave',() => {
     worksAtendImg.forEach(worksAtendImg => {
    worksAtendImg.classList.remove('worksAtendIn_Stop');
     });   
    });
});
});



