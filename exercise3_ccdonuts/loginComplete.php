<?php
//ログインページ　
session_start();
$pageTitle = 'ログイン完了';

require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>
<li>ログイン</li>
                <span>＞</span>
<li>ログイン完了ページ</li>
</ul>
</nav>

<?php
require_once 'includes/username.php';
require_once 'includes/drawer.php';

if (!isset($_SESSION['customer'])) {//ログインできていなければ、
  header('Location: login.php');//ログインページに戻す
  exit;//
}

?>


<main>
  <div class="innerBody">
    <section class="page">
      <h1 class="sectionTitle"><span>ログイン完了</span></h1>

      <p class="procedureSummary proceduremessage">
        <span>ログインが完了しました。<br>
          引き続きお楽しみください。</span>
        </p>

      <div class="linkGroup">
        <span>
        <a href="test.php" class="btn btnSub">購入確認ページへすすむ</a>
        <a href="index.php" class="btn">TOPページへもどる</a>
        </span>
      </div>
    </section>
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>