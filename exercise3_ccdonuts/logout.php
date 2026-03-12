<?php
//ログアウト処理ページ
session_start();

// ログインしたセッションの情報だけ消す（カートに入れた商品は消してない）
unset($_SESSION['customer']);

header('Location: logoutComplete.php');
exit;
?>