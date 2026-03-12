<?php
// 商品詳細ページ
session_start();

$pageTitle = '商品詳細';
require_once 'includes/db.php';

// id を GET で受け取る商品ごとに表示を変えるために先に読み込む
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 不正アクセス対策数値が入っていなければ商品一覧に戻す
if ($id <= 0) {
  header('Location: products.php');
  exit;
}

// 商品取得
$sql = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$sql->execute([$id]);
$product = $sql->fetch();

// 商品が存在しない場合
if (!$product) {
  header('Location: products.php');
  exit;
}

require_once 'includes/header.php';
require 'includes/pankuzu.php';
?>

<li>商品一覧</li>
<span>＞</span>
<li><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></li>
</ul>
</nav>

<?php
require 'includes/username.php';
require_once 'includes/drawer.php';
?>

<main>
  <div class="innerBody">
    <section class="productSec">
      <div class="productList">
        <article class="productDetail">

          <p class="productDetailImg">
            <img class="productImg"
                 src="images/productImage<?= $product['id'] ?>.png"
                 alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
          </p>

          <div class="productDetailBody">
            <h3 class="productName">
              <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
            </h3>

            <p class="productCaption">
              <?= htmlspecialchars($product['introduction'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <p class="productPrice">
              税込 ￥<?= number_format($product['price']) ?>
            </p>

            <!-- カート追加（数量指定 → 上書き） -->
            <form action="cartUpdate.php" method="post">
              <p>
                <select class="productCount" name="count">
                  <?php for ($i = 1; $i <= 10; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                  <?php endfor; ?>
                </select>
                <span>個</span>
              </p>

              <input type="hidden" name="productId" value="<?= $product['id'] ?>">
              <button type="submit">カートに入れる</button>
            </form>

          </div>
        </article>
      </div>
    </section>
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>


   