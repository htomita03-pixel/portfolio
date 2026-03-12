<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}
//処理ページ（受け取りと保存）
// POSTか確認
// 空チェック
// DB保存（プリペアド）
// 成功メッセージ表示

//フォームに入力された（contactからPOSTで送信されたもの）ものの取得、
// セッションにPOSTされた内容を変数に代入

//ハニーポットの処理用 空じゃなかったら処理
//Bot detected アクセスしてきたユーザーがボットであると認識する。
$honeyPot = $_POST['honeyPot'] ?? '';
if ($honeyPot !== '') {
    exit('Bot detected');//強制終了
}

$_SESSION['contactData'] = [
    'name' => trim($_POST['name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'message' => trim($_POST['message'] ?? ''),
];

//変数に最新のPOSTの内容を反映する
//セッションデータから名前のデータを取り出して、変数に登録（以下略）
$name = $_SESSION['contactData']['name'] ?? '';
$email = $_SESSION['contactData']['email'] ?? '';
$message = $_SESSION['contactData']['message'] ?? '';

//CSRFチェック用の処理
//Invalid token 認証情報の期限切れ、不正、または正しくない場合であると認識する(ページ編集中は必要時のみOFF)
if (!isset($_POST['token']) || !isset($_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
    exit('セッションがタイムアウトしたか、正しく送信されませんでした。もう一度お試しください。');
}

//文字数チェック（普通に入力したときは５００字以上入力できないはずなのでエラーを知らせずに戻す
$errors = [];

if (mb_strlen($message) > 500) {
    $errors[] = 'お問い合わせ内容は500文字以内でご記入ください。';
}

if ($name === '') {
    $errors[] = 'お名前をご記入願います。';
}

if ($email === '') {
    $errors[] = 'ご連絡可能なメールアドレスをご記入願います。';
}

if ($message === '') {
    $errors[] = 'お問い合わせ内容をご記入願います。';
}

//名前は入力チェックしない（入力の有無だけ確認）
//メール形式チェック
if ($email !== '' && !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
    $errors[] = 'メールアドレスは半角英数@._%+-でご入力ください。';
}

/*
//入力セッションデータがなければcontactに戻す（ページ編集中コメントアウト
if(!isset($_SESSION['contactData'])) {//$_SESSION['contactData'] = $values;の内容
    header('Location: contact.php');
    exit;
}
*/

//エラーの項目が空＝問題なければ、登録の処理実行
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;//エラーメッセージ用のセッション
    header('Location: contact.php');
    exit;
}

$sql = $pdo->prepare('
    INSERT INTO contacts (name, email, message)
    VALUES (?, ?, ?)
');

$sql->execute([
    $name,
    $email,
    $message,
]);

//セッションのデータを削除
unset($_SESSION['contactData']);
unset($_SESSION['token']);
unset($_SESSION['errors']);
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
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/style.css">

    <title>Tomita's Portfolio | お問い合わせページ</title>
</head>

<body>
    <!--ヘッダー-->
    <header>
        <div class="headerNav">

            <h1 class="titleImg">
                Tomita's Portfolio
            </h1>

            <!-- ドロワー開くボタン（スマホのみ） -->
            <div id="js-drawer-open" class="spOnly">
                <img src="common/images/listBtn.svg" id="js-open-btn" alt="ドロワーオープンボタン画像">
            </div>

            <!-- PC用メニュー（横並び） -->
            <nav class="pcMenu pcOnly">
                <ul>
                    <li class="spOnly">Menu</li>
                    <li><a href="../index.html">Top</a></li>
                    <li><a href="../about/index.html">AboutMe</a></li>
                    <li><a href="../exercise1_DesignHouseRenovations/index.html" target="_blank">Exercise1</a></li>
                    <li><a href="../exercise2_taiwankankou/index.html" target="_blank">Exercise2</a></li>
                    <li><a href="../exercise3_ccdonuts/index.php" target="_blank">Exercise3</a></li>
                    <li><a href="../works/index.html">OtherWorks</a></li>
                </ul>
            </nav>

            <!-- ドロワーメニュー -->
            <div id="js-drawer-menu" class="spOnly">
                <img src="common/images/listCloseBtn.svg" id="js-close-btn" alt="ドロワークローズボタン画像">

                <nav class="drawerMenu">
                    <ul>
                        <li>Menu</li>
                        <li><a href="../index.html">Top</a></li>
                        <li><a href="../about/index.html">AboutMe</a></li>
                        <li><a href="../exercise1_DesignHouseRenovations/index.html" target="_blank">Exercise1</a></li>
                        <li><a href="../exercise2_taiwankankou/index.html" target="_blank">Exercise2</a></li>
                        <li><a href="../exercise3_ccdonuts/index.php" target="_blank">Exercise3</a></li>
                        <li><a href="../works/index.html">OtherWorks</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="wrapper">

            <h3 class="linkSecH3">
                <i class="bi bi-stars beforeStar"></i>
                <span>送信処理結果</span>
                <i class="bi bi-stars afterStar"></i>
            </h3>

            <div class="result">
                <p>
                    <span>
                        送信完了しました。<br>
                        TOPページまたはお問い合わせフォームへお戻りください。
                    </span>
                </p>
            </div>

            <div class="btnContainer">
                <a href="contact.php" class="toMorepage">お問い合わせフォームに戻る</a>
                <a href="../index.html" class="toMorepage">TOPページへ戻る</a>
            </div>

        </div>
    </main>

    <footer>
        <small>
            使用技術・開発環境<br>
            <hr>
            フロントエンド: HTML, CSS, JavaScript<br>
            バックエンド: PHP<br>
            フレームワーク:Bootstrap<br>
            データベース: MySQL(mariaDB)<br>
            開発ツール: VS Code, Git/GitHub<br>
            開発補助、一部画像生成、加工:ChatGPT(基本モデル)<br>
            共同制作での連絡ツール:Chatwork<br>

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