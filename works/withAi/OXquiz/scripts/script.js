// --- 変数管理 ---
let allQuizzes = JSON.parse(localStorage.getItem('allQuizzes')) || {};
let currentQuizList = [];
let currentIndex = 0;
let score = 0;
let timer;

// 音源（外部URL）
const soundOK = new Audio('');//作成した音源ファイルの相対パス
const soundNG = new Audio('');//作成した音源ファイルの相対パス　

// --- 初期化処理 ---
window.addEventListener('DOMContentLoaded', () => {
    updateSelector();
    
    // イベントリスナーの登録（HTMLとの切り離し）
    document.getElementById('start-btn').addEventListener('click', startQuiz);
    document.getElementById('save-btn').addEventListener('click', saveToLocal);
    document.getElementById('download-btn').addEventListener('click', downloadFile);
    document.getElementById('file-input').addEventListener('change', uploadFile);
    document.getElementById('quiz-selector').addEventListener('change', selectQuiz);
    document.getElementById('btn-o').addEventListener('click', () => checkAnswer('〇'));
    document.getElementById('btn-x').addEventListener('click', () => checkAnswer('×'));
    document.getElementById('next-btn').addEventListener('click', nextQuestion);
    document.getElementById('retry-btn').addEventListener('click', () => location.reload());
    document.getElementById('share-btn').addEventListener('click', shareX);
    document.getElementById('delete-local-btn').addEventListener('click', deleteLocal);
});

// --- 関数定義 ---

//クイズのリスト更新
function updateSelector() {
    const selector = document.getElementById('quiz-selector');
    selector.innerHTML = '<option value="">-- 選んでください --</option>';
    for (let title in allQuizzes) {//すべての名前をスキャンしている
        let op = document.createElement('option');//オプションタグの作成
        op.value = title;
        op.textContent = title;
        selector.appendChild(op);
    }
}

//セレクトボックスによるクイズ集の選択
function selectQuiz(e) {
    const title = e.target.value;
    if (allQuizzes[title]) {
        document.getElementById('quiz-input').value = allQuizzes[title];
        document.getElementById('quiz-title').value = title;
    }
}

//作成したクイズ集の保存
function saveToLocal() {
    const title = document.getElementById('quiz-title').value.trim();
    const content = document.getElementById('quiz-input').value.trim();
    if (!title || !content) return alert("名前と内容を入力してください");
    allQuizzes[title] = content;
    localStorage.setItem('allQuizzes', JSON.stringify(allQuizzes));
    updateSelector();
    alert("保存しました！");
}

//作成したクイズ集の消去
function deleteLocal() {
    const title = document.getElementById('quiz-selector').value;
    if (!title || !confirm(`${title} を削除しますか？`)) return;
    delete allQuizzes[title];
    localStorage.setItem('allQuizzes', JSON.stringify(allQuizzes));
    updateSelector();
    document.getElementById('quiz-input').value = "";
    document.getElementById('quiz-title').value = "";
}

//クイズの開始
function startQuiz() {
    const text = document.getElementById('quiz-input').value.trim();
    if (!text) return;
    
    // データ変換（mapと分割代入）
    currentQuizList = text.split('\n').map(line => {
        const [q, a] = line.split(',');
        return { q: q.trim(), a: a.trim() };
    });

    document.getElementById('setup-area').classList.add('hidden');
    document.getElementById('quiz-area').classList.remove('hidden');
    nextQuestion();
}

//次の問題へ
function nextQuestion() {
    document.body.className = "";
    document.getElementById('overlay-symbol').className = "";
    
    if (currentIndex < currentQuizList.length) {
        document.getElementById('question-text').innerText = currentQuizList[currentIndex].q;
        document.getElementById('result-text').innerText = "";
        document.getElementById('next-btn').classList.add('hidden');
        runTimer();
    } else {
        showResult();
    }
}

function runTimer() {
    let timeLeft = 10;
    document.getElementById('seconds').innerText = timeLeft;
    clearInterval(timer);
    timer = setInterval(() => {
        timeLeft--;
        document.getElementById('seconds').innerText = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(timer);
            checkAnswer("TIMEUP");
        }
    }, 1000);
}

function checkAnswer(userAns) {
    if (!document.getElementById('next-btn').classList.contains('hidden')) return;
    clearInterval(timer);
    
    const correct = currentQuizList[currentIndex].a;
    const overlay = document.getElementById('overlay-symbol');
    
    if (userAns === correct) {
        overlay.innerText = "〇";
        overlay.className = "show symbol-o";
        document.body.className = "bg-correct";
        soundOK.play();
        score++;
    } else {
        overlay.innerText = "×";
        overlay.className = "show symbol-x";
        document.body.className = "bg-wrong";
        soundNG.play();
    }
    
    currentIndex++;
    document.getElementById('next-btn').classList.remove('hidden');
}

function showResult() {
    document.getElementById('quiz-area').classList.add('hidden');
    document.getElementById('score-area').classList.remove('hidden');
    document.getElementById('final-score').innerText = `${currentQuizList.length}問中 ${score}問正解！`;
}

function downloadFile() {
    const title = document.getElementById('quiz-title').value || "quiz";
    const blob = new Blob([document.getElementById('quiz-input').value], {type: 'text/plain'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `${title}.txt`;
    a.click();
}

function uploadFile(e) {
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onload = (ev) => {
        document.getElementById('quiz-input').value = ev.target.result;
        document.getElementById('quiz-title').value = file.name.replace('.txt', '');
    };
    reader.readAsText(file);
}

