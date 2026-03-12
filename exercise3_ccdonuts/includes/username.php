<section class="userName">
  <?php if (isset($_SESSION['customer'])): //?>
    
    <span class="welcomeText">
      ようこそ
      <?= htmlspecialchars($_SESSION['customer']['name'], ENT_QUOTES, 'UTF-8') ?>様
    </span>
    <span class="userLink">
      ｜ <a href="logout.php">ログアウト</a>
    </span>

  <?php else: ?>

    <span class="welcomeText">
      ようこそ ゲスト様
    </span>
    <span class="userLink">
      ｜ <a href="login.php">ログイン</a>
    </span>
  <?php endif; //loginしているか、（セッションにログイン記録があるか）で表示切替。if　else文 ?>
</section>
