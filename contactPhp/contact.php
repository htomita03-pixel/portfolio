<?php
session_start();
require_once 'includes/db.php';
//お問い合わせページ本体
// HTMLフォーム
//action="process.php"
//method="POST"
/*
contact.php
フォーム表示
CSRFトークン生成
入力値保持表示

入力保持の仕組み（バリデーションで戻ったときに値を表示）を実装
CSRFトークンを生成・埋め込み（セッション利用）
ハニーポット（見えない入力）を追加してボット検知
エラーメッセージを入力欄の近くに出す
*/

$name = $email = $message = '';
/*入力のために空にしておいている*/

//トークンの作成　今回はCSRF攻撃を防ぐのにトークン（認証するためのランダムなデータ）を先に生成しておく
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

//処理でエラーがあって戻ってきたときの処理セッションに情報が入っている場合のみ変数に代入してそのセッションは消去する
$errors = $_SESSION['errors'] ?? [];

//エラーのため再入力でもどしたので、既に入力したデータは残せるように、セッションから抽出して戻して変数に代入
if (isset($_SESSION['contactData'])) {
    $name = $_SESSION['contactData']['name'] ?? '';
    $email = $_SESSION['contactData']['email'] ?? '';
    $message = $_SESSION['contactData']['message'] ?? '';
    unset($_SESSION['contactData']);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../common/reset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/style.css">

    <title>Tomita's Portfolio | お問い合わせページ</title>
</head>

<body>
    <!-- ヘッダー-->
    <header>
        <div class="headerNav">

            <h1 class="titleImg">
                Tomita's Portfolio
            </h1>

            <!-- ドロワー開くボタン（スマホのみ） -->
            <div id="js-drawer-open" class="spOnly">
                <img src="../common/images/listBtn.svg" id="js-open-btn" alt="ドロワーオープンボタン画像">
            </div>

            <!-- PC用メニュー（横並び） -->
            <nav class="pcMenu pcOnly">
                <ul>
                    <li class="spOnly">Menu</li>
                    <li><a href="../index.html"target="_blank">Top</a></li>
                    <li><a href="../about/index.html"target="_blank">AboutMe</a></li>
                    <li><a href="../exercise1_DesignHouseRenovations/index.html" target="_blank">Exercise1</a></li>
                    <li><a href="../exercise2_taiwankankou/index.html" target="_blank">Exercise2</a></li>
                    <li><a href="../exercise3_ccdonuts/index.php" target="_blank">Exercise3</a></li>
                    <li><a href="../works/index.html"target="_blank">OtherWorks</a></li>
                </ul>
            </nav>

            <!-- ドロワーメニュー -->
            <div id="js-drawer-menu" class="spOnly">
                <img src="../common/images/listCloseBtn.svg" id="js-close-btn" alt="ドロワークローズボタン画像">

                <nav class="drawerMenu">
                    <ul>
                        <li>Menu</li>
                        <li><a href="../index.html"target="_blank">Top</a></li>
                        <li><a href="../about/index.html"target="_blank">AboutMe</a></li>
                        <li><a href="../exercise1_DesignHouseRenovations/index.html" target="_blank">Exercise1</a></li>
                        <li><a href="../exercise2_taiwankankou/index.html" target="_blank">Exercise2</a></li>
                        <li><a href="../exercise3_ccdonuts/index.php" target="_blank">Exercise3</a></li>
                        <li><a href="../works/index.html"target="_blank">OtherWorks</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="contactSecH3">
            <i class="bi bi-stars beforeStar"></i>
            <span>お問い合わせフォーム</span>
            <i class="bi bi-stars afterStar"></i>
        </div>

        <form class="inputField" action="process.php" method="post">
            <!--処理ページprocessにフォームの内容を飛ばす-->

            <?php if (!empty($errors)): ?>
                <!--エラーの変数が空でなければ処理-->
                <ul class="errorMessage">
                    <?php foreach ($errors as $error): ?>
                        <!--すべての格納されたエラーに該当するメッセージを一つずつ取り出す-->
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                        <!--ここにリストとして表示。-->
                    <?php endforeach; ?>
                </ul>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <!--BOTやCSRF攻撃よけ-->
            <input
                type="hidden"
                name="token"
                value="<?= htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8') ?>">
            <!--CSRFトークンを生成するためのコード-->
   

            <div class="honeyPotField">
                <input type="text" name="honeyPot">
            </div>
            <!--botを捕まえる罠-->

            <label>
                お名前<span class="required">（必須）</span><br>
                <input type="text" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
            </label>

            <label>
                メールアドレス<span class="required">（必須）</span><br>
                半角英数@._%+-でご入力ください。
                <input type="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
            </label>

            <label>
                お問い合わせ内容<span class="required">（必須）</span><br>
                全角５００文字以内でご記入ください。
                <textarea name="message" maxlength="500" onkeyup="ShowLength(value);"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></textarea>
                <!--以下文字数を表示する場所 (初期値は0) -->
                <span class="textCount">現在の文字数: <span id="js-input-length">0</span>/500 </span>
            </label>
            <!--onkeyup="ShowLength(value);"文字カウントのための記述。onkeyupで文字が離されるたびにJSのShowLengthを呼ぶ
        maxlength 入力できる文字数の制限）-->

            <button type="submit">送信</button>
            
        </form>

        <a class="toMorepage" href="../index.html">
            TOPページへ戻る
        </a>

        <?php ?>
    </main>

    <footer>
        <small>
            <p>
                使用技術・開発環境<br>
                <hr>
                フロントエンド: HTML, CSS, JavaScript<br>
                バックエンド: PHP<br>
                フレームワーク:Bootstrap<br>
                データベース: MySQL(mariaDB)<br>
                開発ツール: VS Code, Git/GitHub<br>
                開発補助、一部画像生成、加工:ChatGPT(基本モデル)<br>
                共同制作での連絡ツール:Chatwork<br>
            </p>
            <hr>
            <hr>
            &copy;2026 Tomita. All rights reserved.
        </small>
    </footer>

    <script src="scripts/script.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>