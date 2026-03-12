
// 名前抽選用プログラム
//道具を揃える
const btn = document.getElementById('roll-btn');
const totalDisp = document.getElementById('total-val');
const detailDisp = document.getElementById('detailVal');
const historyList = document.getElementById('history-list');
const nameInput = document.getElementById('name-list'); // テキストエリア

btn.addEventListener('click', () => {
    // 名前を配列にする　split → trim → 空行削除
    const members = nameInput.value
        .split(/\r\n|\n/)
        .map(line => line.trim())
        .filter(line => line !== "");

/* .split(/\r\n|\n/):
テキストエリアの文章を「改行」があるところで切って、バラバラの配列にする
.filter(...): 
空行（エンターだけ押した行）が混ざっていても、それを無視して「中身がある行」だけを選別
members.length: 
入力された人数を自動で数えてくれる.何人でも対応。*/

    // エラーチェック
    if (members.length === 0) {
        alert("名前を入力してください");
        return;
    }

    // 抽選
    const selected = members[Math.floor(Math.random() * members.length)];

    // 表示（ダイスの数値ではなく、名前を表示）
    totalDisp.textContent = selected;
    detailDisp.textContent = `候補数: ${members.length}`;

    //履歴
    const li = document.createElement('li');
    li.textContent = selected;
    historyList.prepend(li);
    if (historyList.children.length > 10) {
        historyList.removeChild(historyList.lastChild);
    }
});

// 履歴消去
const clearBtn = document.getElementById('clear-btn');

clearBtn.addEventListener('click', () => {
    historyList.innerHTML = '';


    
});


