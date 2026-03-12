<?php
//会員登録ページ
session_start();
$pageTitle = '会員登録';
require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>
<li>ログイン</li>
                <span>＞</span>
<li>会員登録</li>
</ul>
</nav>
<?php
require_once 'includes/username.php';
require_once 'includes/drawer.php';

$errors = [];
$values = [
  'name' => '',
  'furigana' => '',
  'postcode_a' => '',
  'postcode_b' => '',
  'address' => '',
  'mail' => '',
  'mail2' => '',
  'password' => '',
  'password2' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($values as $formField => $unUsed) {
    $values[$formField] = isset($_POST[$formField]) ? trim((string)$_POST[$formField]) : '';
  }

  if ($values['furigana'] !== '') {
  $values['furigana'] = mb_convert_kana($values['furigana'], 'KVC', 'UTF-8');// ひらがな→カタカナ、半角→全角
  }
  $values['postcode_a'] = mb_convert_kana($values['postcode_a'], 'n', 'UTF-8');
  $values['postcode_b'] = mb_convert_kana($values['postcode_b'], 'n', 'UTF-8');

  // （必須）
  if ($values['name'] === '') $errors[] = '氏名は必須です。';
  if ($values['furigana'] === '') $errors[] = 'フリガナは必須です。';
  if ($values['address'] === '') $errors[] = '住所は必須です。';
  if ($values['mail'] === '') $errors[] = 'メールアドレスは必須です。';
  if ($values['mail2'] === '') $errors[] = 'メールアドレス（確認用）は必須です。';
  if ($values['password'] === '') $errors[] = 'パスワードは必須です。';
  if ($values['password2'] === '') $errors[] = 'パスワード（確認用）は必須です。';

  if ($values['name'] !== '' && !preg_match('/^[ぁ-んァ-ヶー一-龥々]+$/u', $values['name'])) {
  $errors[] = 'お名前を全角漢字、全角ひらがな、全角カタカナのいずれかの全角文字のみで入力してください。';
  }
  if ($values['furigana'] !== '' && !preg_match('/^[ぁ-んァ-ヶー]+$/u', $values['furigana'])) {
  $errors[] = 'フリガナを全角ひらがな、または全角カタカナのみで入力してください。';
  }
  // 郵便番号
  if (!preg_match('/^\d{3}$/', $values['postcode_a'])) $errors[] = '郵便番号（前3桁）は数字3桁で入力してください。';
  if (!preg_match('/^\d{4}$/', $values['postcode_b'])) $errors[] = '郵便番号（後4桁）は数字4桁で入力してください。';

  // メール形式 & 一致
  if ($values['mail'] !== '' && !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $values['mail'])) {
    $errors[] = 'メールアドレスは半角英数@._%+-で入力してください。';//多くのWebサイトで採用されている、基本的な形式（@があるか、ドメインがあるか）
  }
  if ($values['mail'] !== '' && $values['mail2'] !== '' && $values['mail'] !== $values['mail2']) {
    $errors[] = 'メールアドレスが一致していません。';
  }

  // パス一致
  if ($values['password'] !== '' && $values['password2'] !== '' && $values['password'] !== $values['password2']) {
    $errors[] = 'パスワードが一致していません。';
  }

  // エラーが無ければ確認画面へ
  if (empty($errors)) {
    $_SESSION['signup'] = $values; // 確認画面に渡す（授業範囲のSESSION活用）
    header('Location: signupConfirm.php');
    exit;
  }
}
?>


<main>
  <div class="innerBody">
    <h2 class="sectionTitle"><span>会員登録</span></h2>

    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach ($errors as $errorMessage): ?>
          <li><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form class="inputField" action="signup.php" method="post">
      <p>
          お名前<span class="required">（必須）</span><br>
        <input type="text" name="name" value="<?= htmlspecialchars($values['name'], ENT_QUOTES, 'UTF-8') ?>">
      </p>
      
      <p>お名前（フリガナ）<span class="required">（必須）</span><br>
        <input type="text" name="furigana" value="<?= htmlspecialchars($values['furigana'], ENT_QUOTES, 'UTF-8') ?>">
      </p>
        
      <p >
          郵便番号<span class="required">（必須）</span><br>
          <input class="adressNum1" type="text" name="postcode_a" size="3" maxlength="3" value="<?= htmlspecialchars($values['postcode_a'], ENT_QUOTES, 'UTF-8') ?>"> -
          <input class="adressNum2" type="text" name="postcode_b" size="4" maxlength="4" value="<?= htmlspecialchars($values['postcode_b'], ENT_QUOTES, 'UTF-8') ?>">
      </p>
      
      <p>
          住所<span class="required">（必須）</span><br>
        <input type="text" name="address" value="<?= htmlspecialchars($values['address'], ENT_QUOTES, 'UTF-8') ?>">
      </p>
      
        <p>
          メールアドレス<span class="required">（必須）</span><br>
        <input type="text" name="mail" value="<?= htmlspecialchars($values['mail'], ENT_QUOTES, 'UTF-8') ?>">
      </p>
      
        <p>
          メールアドレス確認用<span class="required">（必須）</span><br>
        <input type="text" name="mail2" value="<?= htmlspecialchars($values['mail2'], ENT_QUOTES, 'UTF-8') ?>">
      </p>
      
        <div>
          パスワード<span class="required">（必須）</span>
          <p class="inputFieldPass">
            <span class="headsUp">半角英数字8文字以上20文字以内で入力してください。※記号の使用はできません</span>
            <input type="password" name="password" value="">
          </p>
        </div>

        <p class="inputFieldPassRe">
          パスワード確認用<span class="required">（必須）</span><br>
        <input type="password" name="password2" value="">
      </p>

      <button type="submit">入力確認へ</button>
    </form>
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>