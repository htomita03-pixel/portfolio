<?php
//カートの個数増減ページ
session_start();

$productId = isset($_POST['productId']) ? (int)$_POST['productId'] : 0;
$count     = isset($_POST['count']) ? (int)$_POST['count'] : 1;

if ($productId <= 0) {
  header('Location: cart.php');
  exit;
}

if ($count <= 0) $count = 1;
if ($count > 10) $count = 10;

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}


if (isset($_SESSION['cart'][$productId])) {
    // 再計算ボタン等からの送信なら選んだ個数を上書き
    $_SESSION['cart'][$productId] = $count; 
} else {
  // 新しくカートに入れる
    $_SESSION['cart'][$productId] = $count;
}

header('Location: cart.php');
exit;?>


