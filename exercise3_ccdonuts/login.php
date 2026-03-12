<?php
//ログインページ
session_start();
$pageTitle = 'ログイン';?>
<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>
<li>ログイン</li>

</ul>
</nav>
<?php
require_once 'includes/username.php';
require_once 'includes/drawer.php';

// 未定義の変数の初期化をしておく
$error = '';//ここに各エラーの内容を入れていく
$mail  = '';//ここにメールアドレスを入れていく

//ログインの入力情報を取得（確実にstringで文字列として、trimであたまと後ろの空白を省く
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POSTされているものだけを読み込む
  $mail = isset($_POST['mail']) ? trim((string)$_POST['mail']) : '';
  $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

  if ($mail === '' || $password === '') {//メールとパスワードが空の時の処理（厳密に入力されていない状態と同じかどうか確認）
    $error = 'メールアドレスとパスワードを入力してください。';

  } else {
      //メルアド、パスワードの情報取得、照合
    $sql = $pdo->prepare(
    'SELECT * FROM customers WHERE mail=? AND password=?'//顧客データからメールとパスワードを検索
    );
    
    $sql->execute([$mail, $password]);//
    $customer = $sql->fetch();//該当するデータをDBの1件取り出し

    //処理
    if ($customer) {
      $_SESSION['customer'] = [         //セッションデータから読み込み
        'id'   => (int)$customer['id'],//文字列ではなく整数で読み込み
        'name' => $customer['name'],//ユーザー名
        'mail' => $customer['mail'],//メルアド
      ];
      header('Location: loginComplete.php');//loginComplete.phpに飛ばす
      exit;

  } else {//メールアドレスまたはパスワードが違う場合は変数に代入
    $error = 'メールアドレスまたはパスワードが違います。';
  }

    }
}
?>

<main>
  <div class="innerBody">
    
    <div class="procedureDetail">
      <h1 class="sectionTitle"><span>ログイン</span></h1>
      
        <!--エラーがあったときの記述-->

        <?php if ($error !== ''): ?><!--エラーの変数に値が入っているときのみ-->
         <p class="procedureSummary proceduremessage">
          <span>
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') //それぞれのエラー$errorに合わせてメッセージを表示?>
          </span>
        </p>
        
          <?php endif; ?>

        <form class="procedureSummary" action="login.php" method="post"><!--処理系ページの表示箇所共通の箱-->
          <p>
            メールアドレス<br>
            <input type="text" name="mail" value="<?= htmlspecialchars($mail, ENT_QUOTES, 'UTF-8') ?>">
          </p>

          <p>
            パスワード<br>
            <input type="password" name="password">
          </p>

          <button type="submit">ログインする</button>
        </form>

      <p class="toSignUp">
        <a href="signup.php">会員登録はこちら</a></p>
    </div>

  </div>
</main>

<?php require_once 'includes/footer.php'; ?>

