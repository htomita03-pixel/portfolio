'use strict';

//演習２より（少々変更）
//イベントを追加（HTMLが読み込み終わったら関数処理実行
document.addEventListener('DOMContentLoaded', function () {
    // ドロワークローズ時の３本線アイコンを取得
    const openBtn = document.getElementById('js-open-btn');
    //追加分１　ドロワーオープン時のバツアイコンを取得　確実に読み込ませたいのでこちらにもいれておく
    const closeBtn = document.getElementById('js-close-btn');
    // 追加分２　ドロワー本体の取得
    const drawer = document.getElementById('js-drawer-menu');
    // 追加分４　オーバーレイ用タグの取得
    const overlay = document.getElementById('js-over-lay');

    if (!openBtn || !closeBtn || !drawer) {
        return;
    }

    openBtn.addEventListener('click', function () {
        drawer.classList.add('show');
        overlay.classList.add('show');
    });

    closeBtn.addEventListener('click', function () {
        drawer.classList.remove('show');
        overlay.classList.remove('show');
    });

    overlay.addEventListener('click', function () {
        drawer.classList.remove('show');
        overlay.classList.remove('show');
    });
    // PC → スマホ切替時に .show が残っていると一瞬出るのでクラスを強制的に外す
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            drawer.classList.remove('show');
            overlay.classList.remove('show');
        }
    });
});

//TOPを開いたときにまずは全体に名前とイメージをオーバーレイさせておく

//初期画面
//画像・CSS・動画など、すべての読み込みが終わったら処理開始
window.addEventListener("load", () => {
    const loading = document.getElementById("js-over-wrap");

    setTimeout(function () {
        loading.classList.add("hide");
    }, 2000);
});