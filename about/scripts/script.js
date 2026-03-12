'use strict';

// 演習２より（少々変更）
// イベントを追加（HTMLが読み込み終わったら関数処理実行）
document.addEventListener('DOMContentLoaded', function () {
    // ドロワークローズ時の３本線アイコンを取得
    const openBtn = document.getElementById('js-open-btn');
    // ドロワーオープン時のバツアイコンを取得
    const closeBtn = document.getElementById('js-close-btn');
    // ドロワー本体の取得
    const drawer = document.getElementById('js-drawer-menu');

    // 必要な要素がないページでは何もしない
    if (!openBtn || !closeBtn || !drawer) {
        return;
    }

    openBtn.addEventListener('click', function () {
        drawer.classList.add('show');
    });

    closeBtn.addEventListener('click', function () {
        drawer.classList.remove('show');
    });

    // PC → スマホ切替時に .show が残っていると一瞬出るのでクラスを強制的に外す
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768) {
            drawer.classList.remove('show');
        }
    });
});


