<?php
//ログアウト完了ページ
session_start();
$pageTitle = 'ログアウト完了';

require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>
<li>ログアウト完了ページ</li>
</ul>
</nav>
<?php
require_once 'includes/username.php';
require_once 'includes/drawer.php';
?>


<main>
  <div class="innerBody">
    <section class="page">
      <h1 class="sectionTitle"><span>ログアウト完了</span></h1>
      
      <p class="procedureSummary proceduremessage">
          <span>ログアウトしました。<br>
          またのご利用をお待ちしております。<span>
        </p>

      <div class="linkGroup">
        <a href="index.php" class="btn">TOPページへもどる</a>
      </div>
    </section>
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>