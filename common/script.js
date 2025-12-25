'use strict';

//ドロワーメニュー
//イベントを追加（HTMLが読み込み終わったら関数処理実行
    document.addEventListener('DOMContentLoaded', function () {
    // ドロワークローズ時の３本線アイコンを取得
    const openNav = document.getElementById('openNav');
//追加分１　ドロワーオープン時のバツアイコンを取得　確実に読み込ませたいのでこちらにもいれておく
    const closeNav = document.getElementById('closeNav');
// 追加分２　ドロワー本体の取得
    const drawer = document.getElementById('drawerNav');  
// 追加分４　オーバーレイ用タグの取得
    const overLay = document.getElementById('overLay');


    // 3本線にクリックイベント設定
    openNav.addEventListener('click', function () {
         //  #drawerNav（ドロワーオープン時メニュー） を取得してshowを追加
        drawer.classList.toggle('show');
    //　追加分５オーバーレイ用タグを取得してshowを追加
        overLay.classList.add('show');
    });


/*追加分３　ドロワーを×ボタンで閉じるためのJS　オープン時とほぼ同じJS */
        // 　バツボタンにクリックイベント設定
        closeNav.addEventListener('click', function () {
        //  #drawerNav（ドロワーオープン時メニュー） を取得してshowをremoveで削除
        drawer.classList.remove('show');
        
//　追加分５オーバーレイ用タグを取得してshowをremoveで削除
        overLay.classList.remove('show');
    });
/*追加分６　オーバーレイクリックでも閉じる　オープン時とほぼ同じJS*/
        //オーバーレイ部分がクリックされたら関数を実行
        overLay.addEventListener('click', function () {
        //#drawerNav（ドロワーオープン時メニュー） を取得してshowをremoveで削除
        drawer.classList.remove('show');
        //オーバーレイ用タグを取得してshowをremoveで削除
        overLay.classList.remove('show');
        });
});


/*今回のJS説明
機能
ハンバーガーアイコン　      開く　　#drawerNav.show を付ける → 右から開く
×アイコン、オーバーレイ　　閉じる	　show を削除 → 戻る

/*ドロワー開閉変更点詳細

１・jQueryをJSに書き換えています。
書き換え部分リスト
/* jQuery	　　　　　→JavaScript
$('#open_nav')	　　　→document.getElementById('#openNav')
.on('click')	　　　→.addEventListener('click')
$('#wrapper, #nav')	　→document.querySelector('#drawerNav')
.toggleClass()	　　　→.classList.toggle()

２・ページ全体の移動指定を削除
教科書ではページ全体とドロワーが移動していますが、
今回はドロワーだけの移動のためページ全体の移動指定を削除しています
$('#wrapper,#nav').toggleClass()	　→drawer＝IDのdrawerNavのみ　.classList.toggle()

３・DOMContentLoaded追加
DOMContentLoadedでHTML読み込み後に
    処理が実行されるようにしています
    （実行しようとして必要なタグなどが用意されていないとエラーになる

４・const~
タグの読み込みを一か所にまとめて記述しています。

５・（追加分２ 要素取得のための定数名作成
document.querySelector('#drawerNav')の部分の取得を一か所にまとめて、
定数名drawerで管理しています　


６・（追加分３
バツボタンに閉じる機能を追加しています。
教科書では出現したメニューのボタンを押して閉じる形ではなかったので、
そのままだと×アイコンには閉じる機能がつきません。
（なくても開閉自体の機能はありますが、トリガーが三本線アイコンになっているので
出現したメニューの奥になってしまって押すことはできません。）

　
７・（追加分４、５、６
オーバーレイのための記述追加（新規）

・/*CSSの変更点→CSSに記載します*/


/*
■ 参考　元の教科書内jQuery記述部分 
ドロワーメニュー（#wrapper と #nav）の開閉　
$(document).ready(function() {
   $('#open_nav').on('click', function() {
       $('#wrapper, #nav').toggleClass('show');
   });
});

注）ページごと画面内部に右からずれてきて、
    閉じるときは右に戻る形のスタイル
    開く、閉じるに同じボタンを利用しているタイプ
*/


//ローディング
//画像・CSS・動画など、すべての読み込みが終わったら処理開始
window.addEventListener("load", () => {
    //IDloadingOverlayの要素を取得
    const loading = document.getElementById("loadingOverlay");

    // 点滅2回分でローディング終了
    //指定のミリ秒数ローディングアニメーションが再生されるのを待ってから
    // ローディング終了のクラスを追加し、
    // そのタグに指定しているＣＳＳによる終了アニメーションが始まる。
    setTimeout(() => {
        
        loading.classList.add("hide");

    }, 3000);
});