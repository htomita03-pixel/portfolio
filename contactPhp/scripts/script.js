'use strict';


//ここから文字数カウント、カウントオーバーお知らせ機能
function ShowLength(str) {//HTMLから呼べるようにしておく

        const strCount = document.getElementById("js-input-length");
        if(!strCount) return;//要素がないときは何もしないようにする

        const strLength = str.length;
        strCount.innerText = strLength;

        if(strLength > 500) {//指定文字数を超えるときの処理　変更内容自体はCSSで管理
            strCount.classList.add("countOver");
        } else {
            strCount.classList.remove("countOver");
        }


//ドロワー
//イベントを追加（HTMLが読み込み終わったら関数処理実行
document.addEventListener('DOMContentLoaded', function () {
    // ドロワークローズ時の３本線アイコンを取得
    const openBtn = document.getElementById('js-open-btn');
    //追加分１　ドロワーオープン時のバツアイコンを取得　確実に読み込ませたいのでこちらにもいれておく
    const closeBtn = document.getElementById('js-close-btn');
    // 追加分２　ドロワー本体の取得
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
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            drawer.classList.remove('show');
        }
    });
});

};
