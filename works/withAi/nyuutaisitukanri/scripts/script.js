// --------------------
// プリセット名前
// --------------------
const presetNames = ["田中", "佐藤", "鈴木", "高橋", "山田"];

// --------------------
// データ
// --------------------
let members = JSON.parse(localStorage.getItem("members")) || [];
let logs = JSON.parse(localStorage.getItem("logs")) || [];
let allUsers = JSON.parse(localStorage.getItem("allUsers")) || [];

// --------------------
// 要素取得
// --------------------
const nameSelect = document.getElementById("nameSelect");
const roomList = document.getElementById("js-room-list");
const logList = document.getElementById("js-log-list");
const countSpan = document.getElementById("count");
const totalCountSpan = document.getElementById("totalCount");
const clock = document.getElementById("js-clock");
const alertSound = document.getElementById("alertSound");
const leaveAtInput = document.getElementById("leaveAt");


// --------------------
// セレクト初期化
// --------------------
function initSelect() {
    nameSelect.innerHTML = "";

    presetNames.forEach(function (name) {

        let exists = false;

        for (let i = 0; i < members.length; i++) {
            if (members[i].name === name) {
                exists = true;
                break;
            }
        }

        if (!exists) {
            const option = document.createElement("option");
            option.value = name;
            option.textContent = name;
            nameSelect.appendChild(option);
        }
    });
}


// --------------------
// 時計
// --------------------
function updateClock() {
    const now = new Date();

    const text =
        now.getFullYear() + "/" +
        ("0" + (now.getMonth() + 1)).slice(-2) + "/" +
        ("0" + now.getDate()).slice(-2) + " " +
        now.toLocaleTimeString();

    clock.textContent = text;
}

setInterval(updateClock, 1000);
updateClock();


// --------------------
// 保存
// --------------------
function save() {
    localStorage.setItem("members", JSON.stringify(members));
    localStorage.setItem("logs", JSON.stringify(logs));
    localStorage.setItem("allUsers", JSON.stringify(allUsers));
}


// --------------------
// 残り時間表示
// --------------------
function formatRemaining(leaveTime) {
    const now = Date.now();
    const diff = leaveTime - now;

    if (diff >= 0) {
        // 退室前 → 残り時間
        const min = Math.floor(diff / 60000);
        const sec = Math.floor((diff % 60000) / 1000);
        return "残り " + min + "分" + sec + "秒";
    } else {
        // 退室予定を過ぎた → 経過時間
        const elapsed = -diff; // 経過ミリ秒
        const min = Math.floor(elapsed / 60000);
        const sec = Math.floor((elapsed % 60000) / 1000);
        return "経過 " + min + "分" + sec + "秒";
    }
}





// --------------------
// 入室
// --------------------
function enterRoom() {

    const name = nameSelect.value;
    if (!name) return;

    const now = new Date();
    let leaveTime;

    if (leaveAtInput.value) {

        const parts = leaveAtInput.value.split(":");
        const h = Number(parts[0]);
        const m = Number(parts[1]);

        leaveTime = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate(),
            h,
            m
        ).getTime();

        if (leaveTime < now.getTime()) {
            leaveTime += 24 * 60 * 60 * 1000;
        }

    } else {
        leaveTime = now.getTime() + 30 * 60 * 1000;
    }

    const member = {
        name: name,
        enterTime: now.getTime(),
        leaveTime: leaveTime,
        warned10: false,
        warned5: false
    };

    members.push(member);

    // allUsers に追加（includes使わない）
    let exists = false;
    for (let i = 0; i < allUsers.length; i++) {
        if (allUsers[i] === name) {
            exists = true;
            break;
        }
    }
    if (!exists) {
        allUsers.push(name);
    }

    logs.unshift(now.toLocaleTimeString() + " " + name + " が入室");

    save();
    update();
}


// --------------------
// 退室
// --------------------
function leaveByName(name) {

    let found = false;

    for (let i = 0; i < members.length; i++) {
        if (members[i].name === name) {
            members.splice(i, 1);
            found = true;
            break;
        }
    }

    if (!found) {
        alert("その人は入室していません");
        return;
    }

    logs.unshift(new Date().toLocaleTimeString() + " " + name + " が退室");

    save();
    update();
}


function leaveRoom() {
    const name = nameSelect.value;
    if (!name) return;
    leaveByName(name);
}


// --------------------
// 表示更新
// --------------------
function update() {

    roomList.innerHTML = "";

    members.forEach(function (m) {

        const li = document.createElement("li");
        li.setAttribute("data-name", m.name);
        li.style.cursor = "pointer";

        const leaveDate = new Date(m.leaveTime);
        const leaveText =
            ("0" + leaveDate.getHours()).slice(-2) + ":" +
            ("0" + leaveDate.getMinutes()).slice(-2);

        li.textContent =
            m.name +
            "（" +
            formatRemaining(m.leaveTime) +
            " / 退室予定 " +
            leaveText +
            "）";
        
        //クリックされたらm.name削除
        li.addEventListener("click", function () {
        leaveByName(m.name);
        });

        // 警告色処理
        li.className = ""; // リセット
        if (m.warned10) li.classList.add("warn10");
        if (m.warned5) li.classList.add("warn5");

        // 退室予定を過ぎていたら点滅
        if (Date.now() > m.leaveTime) {
            li.classList.add("blink");
        }



        roomList.appendChild(li);
    });

    logList.innerHTML = "";

    logs.forEach(function (log) {
        const li = document.createElement("li");
        li.textContent = log;
        logList.appendChild(li);
    });

    countSpan.textContent = members.length;
    totalCountSpan.textContent = allUsers.length;

    initSelect();
}


// --------------------
// カウントダウン
// --------------------
function updateCountdown() {

    const now = Date.now();

    members.forEach(function (m) {

        const remaining = m.leaveTime - now;

        if (!m.warned10 && remaining <= 10 * 60 * 1000 && remaining > 0) {
            m.warned10 = true;
            alertSound.play();
            alert(m.name + " さん、退室予定までまもなくです！");
        }

        if (!m.warned5 && remaining <= 5 * 60 * 1000 && remaining > 0) {
            m.warned5 = true;
        }
    });

    update();
}

setInterval(updateCountdown, 1000);


// --------------------
// 初期化
// --------------------
initSelect();
update();

document.getElementById("enterBtn").addEventListener("click", enterRoom);
document.getElementById("leaveBtn").addEventListener("click", leaveRoom);
document.getElementById("resetBtn").addEventListener("click", function () {
    if (!confirm("データを削除しますか？")) return;
    members = [];
    logs = [];
    allUsers = [];
    save();
    update();
});
document.getElementById("downloadBtn").addEventListener("click", downloadCSV);


// --------------------
// CSVダウンロード
// --------------------
function downloadCSV() {
    let csv = "名前,入退室ログ\n";

    logs.forEach(function (log) {
        csv += log + "\n";
    });

    const blob = new Blob(["\uFEFF" + csv], {
        type: "text/csv;charset=utf-8;"
    });

    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");

    a.href = url;
    a.download = "attendance.csv";
    a.click();

    URL.revokeObjectURL(url);
}
