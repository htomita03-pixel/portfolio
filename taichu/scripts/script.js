'use strict';

// モーダルウィンドウ処理
// ボタンとモーダル要素を取得し、モーダル内容を書き換える
const modalA = document.getElementById('museum');
const modalButtons = modalA.querySelectorAll('button');
let modal = document.getElementById("myModal");

modalButtons.forEach(button => {
  button.addEventListener('click', (event) => {
    modal.classList.add('is-visible');
    const buttonValue = event.target.value;
    console.log('クリックされたボタンの値:', buttonValue);
    // 必要に応じてbuttonValueを使った処理を記述
    switch(buttonValue) {
        case '1':
            document.getElementById('modal1').textContent = '新天地西洋博物館';
            document.getElementById('modal2').src = 'images/imgSeiyouSub1.png';
            document.getElementById('modal3').src = 'images/imgSeiyouSub2.png';
            document.getElementById('modal4').textContent = '10:00〜18:00';
            document.getElementById('modal5').textContent = '台湾台中市東区旱渓東路一段456号1階';
            break;
        case '2':
            document.getElementById('modal1').textContent = 'アジア近代美術館';
            document.getElementById('modal2').src = 'images/imgAsiaSub1.png';
            document.getElementById('modal3').src = 'images/imgAsiaSub2.png';
            document.getElementById('modal4').textContent = '9:30～17:00';
            document.getElementById('modal5').textContent = '413台湾台中市霧峰區柳豐路500號';
            break;
        case '3':
            document.getElementById('modal1').textContent = '勤美術館';
            document.getElementById('modal2').src = 'images/imgChinSub1.png';
            document.getElementById('modal3').src = 'images/imgChinSub2.png';
            document.getElementById('modal4').textContent = '09:00〜17:00';
            document.getElementById('modal5').textContent = '台中市西區館前路71號';
            break;
        case '4':
            document.getElementById('modal1').textContent = '台中文学館';
            document.getElementById('modal2').src = 'images/imgTaichuSub1.png';
            document.getElementById('modal3').src = 'images/imgTaichuSub2.png';
            document.getElementById('modal4').textContent = '09:00〜17:00';
            document.getElementById('modal5').textContent = '台中市楽群街38号';
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
let closeBtn = document.getElementsByClassName("closeBtn")[0];

// バツ印がクリックされたらモーダルを閉じる
closeBtn.onclick = function() {
  modal.style.display = "none";
  modal.classList.remove('is-visible');
}

// モーダルの外側がクリックされたらモーダルを閉じる
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    modal.classList.remove('is-visible');
  }
}