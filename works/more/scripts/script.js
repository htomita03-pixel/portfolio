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
            document.body.classList.remove('stop');
        }
    });

    //モーダル(HTMLのdetailsとsummaryメインでの管理)
    // モーダルのトグルになっている要素を取得
    const modalToggle = document.querySelectorAll('.modalWrapper');
    const backGround = document.body;

    //クラスの付け替え処理
    modalToggle.forEach(function(modal) {//すべてのmodalTogglesをひとつずつ取り出して処理
    modal.addEventListener('toggle',function() {
        if(this.open) {
        //thisは操作中のmodal　
        // これにdetailsが開いているときについているクラス.openがついていたら処理実行
            backGround.classList.add('stop');//bodyタグにクラス.stopを付与する
        } else {//それ以外の時は
            backGround.classList.remove('stop');//bodyタグについているクラスstopを外す
        }
    });
    });//このbody.stopにCSSでスクロールを止めるコードを付けておくことでスクロールを止める
    
    
    //オープン時の要素を取得、//閉じるきっかけの指定 どの同名の要素を指定するのか指定　操作されてるものから一番近い要素
    const closeModalBtn = document.querySelectorAll('.modalItem');

    closeModalBtn.forEach(function(item){
        item.onclick = function() {
             // modalItemから見て一番近い details要素をclosestで指定
            this.closest('.modalWrapper').removeAttribute('open');
        }
    })
    });