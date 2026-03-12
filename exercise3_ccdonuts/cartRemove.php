<?php
//カート商品削除処理ページ
// カートから削除（POST）セッションの破棄
session_start();

$productId = isset($_POST['productId']) ? (int)$_POST['productId'] : 0;

if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
  unset($_SESSION['cart'][$productId]);
}

header('Location: cart.php');
exit;
?>
