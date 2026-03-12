<?php
//会員登録入力内容確認ページ
session_start();
$pageTitle = '入力確認';
require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>
<li>ログイン</li>
                <span>＞</span>
<li>会員登録</li>
                <span>＞</span>
<li>入力確認</li>
</ul>
</nav>

<?php
require_once 'includes/username.php';
require_once 'includes/drawer.php';

if (!isset($_SESSION['signup'])) {
  header('Location: signup.php');
  exit;
}

$formData = $_SESSION['signup'];

// 入力されたパスワードを「最大4文字」の伏せ字（****）にする
$maskedPassword = str_repeat('●', max(4, strlen($formData['password'])));
?>


<main>
  <div class="innerBody">
    <h2 class="sectionTitle"><span>入力確認</span></h2>

    <div class="resultField">
      <dl>
        <dt>お名前</dt>
        <dd><?= htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>お名前（フリガナ）</dt>
        <dd><?= htmlspecialchars($formData['furigana'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>郵便番号</dt>
        <dd><?= htmlspecialchars($formData['postcode_a'] . $formData['postcode_b'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>住所</dt>
        <dd><?= htmlspecialchars($formData['address'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>メールアドレス</dt>
        <dd><?= htmlspecialchars($formData['mail'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>メールアドレス確認用</dt>
        <dd><?= htmlspecialchars($formData['mail2'], ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>パスワード</dt>
        <dd><?= htmlspecialchars($maskedPassword, ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>パスワード確認用</dt>
        <dd><?= htmlspecialchars($maskedPassword, ENT_QUOTES, 'UTF-8') ?></dd>
      </dl>
    </div>
      
    <div class="linkGroup">
    <form action="signupComplete.php" method="post" class="inlineForm">
        <button type="submit" class="btn">登録する</button>
    </form>
</div>
    
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>
