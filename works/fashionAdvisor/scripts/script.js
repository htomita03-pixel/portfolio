//道具を揃える
const checkBtn = document.getElementById('checkBtn');
const tempInput = document.getElementById('tempInput');
const resultDisp = document.getElementById('detailVal');
const tempBar = document.getElementById('tempBar');
const tempText = document.getElementById('currentTemp');
const card = document.querySelector('.card');

//セレクトボックスの中身の温度
for (let i = 40; i >= -10; i--) { // 40から-10までループ
    const option = document.createElement('option');
    option.value = i;
    option.textContent = i;

    // 初期値を20度に設定
    if (i === 20) {
        option.selected = true;
    }

    tempInput.appendChild(option);
}

// 雪を降らす処理
function createSnow() {//雪を1つ作る処理
    const snow = document.createElement('div');//div 要素を作って
    snow.className = 'snowFlake';//作った div に snowFlakeクラスを付ける

    //雪の大きさをランダム決め 5px〜10pxくらい CSS混合
    const size = Math.random() * 5 + 5;
    snow.style.width = size + 'px';
    snow.style.height = size + 'px';

    //雪が画面のどの横位置から落ちるか 画面の左から右までのどこかにランダム
    snow.style.left = Math.random() * 100 + 'vw';

    //雪が落ちる時間2秒〜5秒くらい CSSアニメーションの長さduration
    const duration = Math.random() * 3 + 2;
    snow.style.animationDuration = duration + 's';

    //作った雪を body の中に追加 画面に雪表示
    document.body.appendChild(snow);

    //しばらくしたら雪を消す
    setTimeout(function () {
        snow.remove();//作った雪を画面から削除
    }, duration * 1000);//何ミリ秒後に削除するか
}



//ボタンを押した時のメインの動き
checkBtn.addEventListener('click', function () {
    const temp = parseInt(tempInput.value, 10);

    //エラーチェック
    if (isNaN(temp)) {
        alert('温度を数値で入力してください');
        return;
    }

    //雪の演出
    //入力された温度を読み取り、-1度以下であれば「雪の演出」を3秒間実行

    if (temp <= -1) {
        const snowInterval = setInterval(createSnow, 200);
        setTimeout(function () {
            clearInterval(snowInterval);
        }, 3000);
    }

    //服装と背景を決める
    let outfit = '';
    let clothesImg = '';
    card.classList.remove('hotTheme', 'coldTheme');

    if (temp >= 25) {
        outfit = '暑いですね！半袖でOKです。';
        clothesImg = '1.png';
        card.classList.add('hotTheme');

    } else if (temp >= 21) {
        outfit = '過ごしやすい気候です。長袖シャツがおすすめ。';
        clothesImg = '2.png';

    } else if (temp >= 17) {
        outfit = '冷える時間があるかも。カーディガンをお守りに。';
        clothesImg = '3.png';

    } else if (temp >= 13) {
        outfit = '肌寒いです。セーターがおすすめ。';
        clothesImg = '4.png';

    } else if (temp >= 9) {
        outfit = '上着がないと大分冷えます。薄手のコートがあると安心。';
        clothesImg = '5.png';

    } else {
        outfit = '寒いので、ダウンや厚手のコートを用意しましょう。';
        clothesImg = '6.png';
        card.classList.add('coldTheme');
    }

    //画面に服装を表示
    resultDisp.innerHTML = `
        <p>${temp}度の服装アドバイス：</p>
        <img src="images/${clothesImg}" class="clothesImg">
        <p><strong>${outfit}</strong></p>
    `;

    //温度計のバーを動かす
    //温度 → バーの高さ％へ。＋ 0% ～ 100%の範囲の高さに収める。

    //temp を バーの高さ（％）に変換する計算
    //-10℃ ～ 40℃ -10を基準にして0スタートに変換
    let heightPercent = ((temp + 10) / 50) * 100; //全体の何割か。* 100　％に変換

    if (heightPercent > 100) { //バーが 100%を超えないように最大100%にする
        heightPercent = 100;
    }

    if (heightPercent < 0) { //0%未満にならないように最低0%に制限
        heightPercent = 0;
    }

    //温度バーの高さを変更
    tempBar.style.height = heightPercent + '%';
    //温度の数値を画面に表示 temp = 18なら画面には 18
    tempText.textContent = temp;

    // 気温が低いとき 温度が 15℃未満かどうか バーの色替え
    if (temp < 15) {
        tempBar.classList.add('coldBar');
    } else {//それ以外
        tempBar.classList.remove('coldBar');
    }
});