<?php
session_start();
$pageTitle = '未実装';
require_once 'includes/header.php';
require_once 'includes/username.php';
require_once 'includes/drawer.php';
?>

<main>
  <div class="innerBody">

     <p class="procedureSummary proceduremessage ">
         <span>
          この先の処理は未実装です。<br>
         実装済みページにお戻りください。
        </span>
    </p>

    <div class="linkGroup">
     <a href="cart.php" class="btn">カートへ戻る</a>
    </div>

  </div>
</main>

<?php require_once 'includes/footer.php'; ?>
