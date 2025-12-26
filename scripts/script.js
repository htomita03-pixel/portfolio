'use strict';

//演習２より（少々変更）
//イベントを追加（HTMLが読み込み終わったら関数処理実行
document.addEventListener('DOMContentLoaded', function () {
    // ドロワークローズ時の３本線アイコンを取得
    const openBtn = document.getElementById('open_btn');
    //追加分１　ドロワーオープン時のバツアイコンを取得　確実に読み込ませたいのでこちらにもいれておく
    const closeBtn = document.getElementById('close_btn');
    // 追加分２　ドロワー本体の取得
    const drawer = document.getElementById('drawer_menu');
    // 追加分４　オーバーレイ用タグの取得
    const overLay = document.getElementById('over_lay');


    openBtn.addEventListener('click', function () {
        drawer.classList.add('show');
        overLay.classList.add('show');
    });

    closeBtn.addEventListener('click', function () {
        drawer.classList.remove('show');
        overLay.classList.remove('show');
    });

    overLay.addEventListener('click', function () {
        drawer.classList.remove('show');
        overLay.classList.remove('show');
    });
 
});


