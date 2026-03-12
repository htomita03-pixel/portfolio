<?php
//会員登録完了
session_start();
$pageTitle = '登録完了';
require_once 'includes/db.php';
require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>
<li>ログイン</li>
                <span>＞</span>
<li>会員登録</li>
                <span>＞</span>
<li>入力確認</li>
                <span>＞</span>
<li>会員登録完了</li>
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
$errors = [];

try {
  // メール重複チェック
  $sql = $pdo->prepare('SELECT id FROM customers WHERE mail=?');
  $sql->execute([$formData['mail']]);
  if ($sql->fetch()) {
    $errors[] = 'そのメールアドレスは既に登録されています。';
  }

  if (empty($errors)) {
    $sql = $pdo->prepare('
      INSERT INTO customers (name, furigana, postcode_a, postcode_b, address, mail, password)
      VALUES (?, ?, ?, ?, ?, ?, ?)
    ');
    $sql->execute([
      $formData['name'],
      $formData['furigana'],
      (int)$formData['postcode_a'],
      (int)$formData['postcode_b'],
      $formData['address'],
      $formData['mail'],
      $formData['password']//パスワードを平文保存しないために暗号化しようとしましたがそもそもDBの桁数が足りてなかった
    ]);

    // signupのデータの使い回し防止で削除
    unset($_SESSION['signup']);
  }
} catch (Exception $errorMessage) {//全ての例外（エラー）を捕捉し、その情報を$errorMessageという変数に格納する
  $errors[] = '登録処理でエラーが発生しました。';
}
/*異常終了により処理が継続できないということを防ぐため、
本来であれば終了してしまうプログラムの「エラー」を制御するために、
try-catchを利用 */
?>


<main>
  <div class="innerBody">
    <h2 class="sectionTitle"><span>登録完了</span></h2>

    <?php if (!empty($errors)): ?>
      <p class="procedureSummary proceduremessage">
        <span>
          <?= htmlspecialchars($errors[0], ENT_QUOTES, 'UTF-8') ?>
        </span>
      </p>

      <?php else: ?>
      <p class="procedureSummary proceduremessage">
         <span>会員登録が完了しました。<br>
         ログインページへお進みください。</span>
        </p>

      <div class="linkGroup">
        <a href="test.php" class="btn">クレジットカード登録へすすむ</a>
        <a href="test.php" class="btn btnSub">購入確認ページへすすむ</a>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>
