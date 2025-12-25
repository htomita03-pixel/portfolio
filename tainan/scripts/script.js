'use strict';

// モーダルウィンドウ処理
// ボタンとモーダル要素を取得し、モーダル内容を書き換える
const modalA = document.getElementById('goulmetSec');
const modalButtons = modalA.querySelectorAll('button');

modalButtons.forEach(button => {
  button.addEventListener('click', (event) => {
    const buttonValue = event.target.value;
    console.log('クリックされたボタンの値:', buttonValue);
    // 必要に応じてbuttonValueを使った処理を記述
    switch(buttonValue) {
        case '1':
            document.getElementById('modal2').src = 'images/tnSqModal1Tantu.png';
            break;
        case '2':
            document.getElementById('modal2').src = 'images/tnSqModal2Ebi.png';
            break;
        case '3':
            document.getElementById('modal2').src = 'images/tnSqModal3Shao.png';
            break;
        case '4':
            document.getElementById('modal2').src = 'images/tnSqModal4Yaa.png';
            break;
        default:
            console.log("終了処理");
            break;
    }
    // ボタンがクリックされたらモーダルを開く
    modal.style.display = "block";
  });
});

// ボタンとモーダル要素を取得
let openBtn = document.getElementById("openModalBtn");
let modal = document.getElementById("myModal");
let closeBtn = document.getElementsByClassName("closeBtn")[0];

// バツ印がクリックされたらモーダルを閉じる
closeBtn.onclick = function() {
  modal.style.display = "none";
}

// モーダルの外側がクリックされたらモーダルを閉じる
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}