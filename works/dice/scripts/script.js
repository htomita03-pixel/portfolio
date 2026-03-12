// 道具を揃える
const btn = document.getElementById('roll-btn');
const totalDisp = document.getElementById('total-val');
const detailDisp = document.getElementById('detail-val'); // HTML側の修正に合わせて変更
const clearBtn = document.getElementById('clear-btn');     // HTML側の修正に合わせて変更
const historyList = document.getElementById('history-list'); // HTML側の修正に合わせて変更

// 「ダイスを振るボタン」を押した時の動き
btn.addEventListener('click', function () {
    // 設定を読み込む
    const count = parseInt(document.getElementById('num').value, 10);
    const sides = parseInt(document.getElementById('sides').value, 10);

    // 入力チェック
    if (isNaN(count) || isNaN(sides) || count < 1 || sides < 1) {
        alert('1以上の数値を入力してください');
        return;
    }

    // 上限チェック
    if (count > 100 || sides > 1000) {
        alert('数値が大きすぎます');
        return;
    }

    // ダイス計算をする
    let diceResults = [];
    let total = 0;

    for (let i = 0; i < count; i++) {
        const roll = Math.floor(Math.random() * sides) + 1;
        diceResults.push(roll);
        total += roll;
    }

    // 画面（メイン）に表示する
    totalDisp.textContent = total;
    detailDisp.textContent = '内訳：' + diceResults.join(', ');

    // アニメーション用のクラス付け替え
    totalDisp.classList.remove('scaleUp');
    void totalDisp.offsetWidth; // リフローを強制してアニメーションを再トリガー
    totalDisp.classList.add('scaleUp');

    // 履歴に追加する
    // 「履歴はありません」のメッセージがあれば消す
    const emptyMsg = historyList.querySelector('.empty');
    if (emptyMsg) {
        historyList.innerHTML = '';
    }

    const historyItem = document.createElement('li');
    historyItem.innerHTML = `<strong>${total}</strong> <small>(${diceResults.join(', ')})</small>`;
    historyList.prepend(historyItem);

    // 履歴が増えすぎたら古い順に消す（10件まで）
    if (historyList.children.length > 10) {
        historyList.removeChild(historyList.lastChild);
    }
});

// 「消去ボタン」を押した時
clearBtn.addEventListener('click', function () {
    if (confirm('履歴をすべて消去しますか？')) {
        historyList.innerHTML = '<li class="empty">履歴はまだありません</li>';
    }
});
