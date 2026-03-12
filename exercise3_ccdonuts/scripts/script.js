'use strict';
document.addEventListener('DOMContentLoaded', function () {
const openBtn = document.getElementById('drawerOpenId');
const drawer = document.getElementById('js-drawer-menu');
const closeBtn = document.getElementById('drawerCloseBtn');

openBtn.addEventListener('click', function () {
    drawer.classList.add('show');
});

closeBtn.addEventListener('click', function () {
    drawer.classList.remove('show');
});

});
//過去に使ったドロワー用のコードとほぼ同じコード。クラスの付け外しによるタイミング管理