<?php
// カート追加（+1）
session_start();

$productId = isset($_POST['productId']) ? (int)$_POST['productId'] : 0;

if ($productId > 0) {
  if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
  if (!isset($_SESSION['cart'][$productId])) $_SESSION['cart'][$productId] = 0;

  $_SESSION['cart'][$productId] += 1;
  if ($_SESSION['cart'][$productId] > 10) $_SESSION['cart'][$productId] = 10; // 上限10
}

header('Location: cart.php');
exit;?>

